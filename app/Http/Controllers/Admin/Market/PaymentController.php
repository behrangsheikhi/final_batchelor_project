<?php

namespace App\Http\Controllers\Admin\Market;

use App\Constants\PaymentTypeValue;
use App\Http\Controllers\Controller;
use App\Models\Admin\Market\CashPayment;
use App\Models\Admin\Market\OfflinePayment;
use App\Models\Admin\Market\OnlinePayment;
use App\Models\Admin\Market\Payment;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Throwable;

class PaymentController extends Controller
{

    public function index()
    {
        $payments = Payment::orderByDesc('created_at')->get();

        return view('admin.market.payment.index', compact('payments'));
    }

    /**
     * @throws MpdfException|Throwable
     */
    public function paymentPrint()
    {
        $payments = Payment::orderByDesc('created_at')->get();
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        // Create an mPDF instance
        $pdf = new Mpdf([
            'fontDir' => array_merge($fontDirs, [
                base_path('public/assets/fonts/IRANSans'),
            ]),
            'fontdata' => $fontData + [ // lowercase letters only in font key
                    'IRANSans' => [
                        'R' => 'woff/IRANSansWeb.woff',
                        'B' => 'woff/IRANSansWeb_Bold.woff',
                    ]
                ],
            'default_font' => 'IRANSans',
            'format' => 'A4-L',
            'orientation' => 'L',
            'margin_left' => 4,
            'margin_right' => 4,
            'margin_top' => 2,
            'margin_bottom' => 5,
            'margin_header' => 0,
            'margin_footer' => 0,
            'direction' => 'rtl'
        ]);
        $pdf->autoLangToFont = true;
        $pdf->autoScriptToLang = true;
        $pdf->autoArabic = false;
        $pdf->charset_in = 'UTF-8';

        // Pass data to the blade view
        $html = view('admin.market.payment.print', compact('payments'))->render();

        // Write HTML to PDF
        $pdf->WriteHTML($html);
        $pdf->SetHeader('لیست تمام تراکنش های فروشگاه raastehfarsh.ir');

        return $pdf->Output();

    }

    public function online()
    {
        $payments = Payment::where('paymentable_type', OnlinePayment::class)->orderByDesc('created_at')->get();
        return view('admin.market.payment.index', compact('payments'));
    }

    public function offline()
    {
        $payments = Payment::where('paymentable_type', OfflinePayment::class)->orderByDesc('created_at')->get();

        return view('admin.market.payment.index', compact('payments'));
    }

    public function cash()
    {
        $payments = Payment::where('paymentable_type', CashPayment::class)->orderByDesc('created_at')->get();
        return view('admin.market.payment.index', compact('payments'));
    }

    public function confirm()
    {
        return view('');
    }

    public function payedOrPending(Payment $payment)
    {
        $payment->status = $payment->status === 4 ? 3 : 4;
        $result = $payment->save();
        if ($payment->status == 3){
            $message = 'وضعیت پرداخت به پرداخت شده تغییر کرد.';
            $alertType = 'swal-success';
        }

        elseif($payment->status == 4){
            $message = 'وضعیت پرداخت به در انتظار پرداخت تغییر کرد.';
            $alertType = 'swal-success';
        }
        else{
            $message = 'مشکلی پیش آمده است.';
            $alertType = 'swal-error';
        }

        if ($result)
            return redirect()->back()->with($alertType,$message);
        return redirect()->back()->with('swal-error','مشکلی پیش آمده است، لطفا دوباره تلاش کنید.');
    }

    public function cancelOrReturned(Payment $payment)
    {
        $payment->status = $payment->status === 1 ? 2 : 1;
        $result = $payment->save();
        if ($payment->status == 1){
            $message = 'وضعیت پرداخت به مرجوعی تغییر کرد.';
            $alertType = 'swal-success';
        }

        elseif($payment->status == 4){
            $message = 'وضعیت پرداخت به لغو شده تغییر کرد.';
            $alertType = 'swal-success';
        }
        else{
            $message = 'مشکلی پیش آمده است.';
            $alertType = 'swal-error';
        }

        if ($result)
            return redirect()->back()->with($alertType,$message);
        return redirect()->back()->with('swal-error','مشکلی پیش آمده است، لطفا دوباره تلاش کنید.');
    }

    public function show(Payment $payment)
    {
        $user = $payment->user;
        return view('admin.market.payment.show', compact(['payment', 'user']));
    }


}
