<?php

namespace App\Http\Services\Payment;

use App\Constants\PaymentStatusType;
use Carbon\Carbon;
use Config;
use Mpdf\Http\Exception\RequestException;
use Zarinpal\Clients\GuzzleClient;
use Zarinpal\Zarinpal;

class PaymentService
{

    public function zarinpal($amount, $order, $onlinePayment)
    {
        $merchant_id = Config::get('payment.merchant_id'); // got from roocket.ir
        $sandbox = false;
        $zarinpal_gate = false;
        $client = new GuzzleClient($sandbox);
        $zarinpal_gate_psp = '';
        $lang = 'fa';
        $zarinpal = new Zarinpal($merchant_id, $client, $lang, $sandbox, $zarinpal_gate, $zarinpal_gate_psp);

        $payment = [
            'callback_url' => route('customer.payment-callback', [$order, $onlinePayment]),
            'amount' => $amount * 10, // change Toman to Rial
            'description' => 'پرداخت سفارش مورخه ' . persianDateTime(Carbon::now())
        ];

        try {
            $response = $zarinpal->request($payment);
            $code = $response['data']['code'];
            $message = $zarinpal->getCodeMessage($code);

            if ($code == 100) {
                $onlinePayment->update([
                    'bank_first_response' => $response
                ]);
                $authority = $response['data']['authority'];
                return $zarinpal->redirect($authority); // redirect to the callback method in paymentController
            } else {
                return redirect()->back()->with('error', 'خط در درپاه پرداخت پیش آمده است.');
            }
        } catch (RequestException $exception) {
            return false;
        }
    }


    public function zarinpal_verify($amount, $onlinePayment): array
    {
        $authority = $_GET['Authority']; // first character should be Uppercase
        $data = [
            'merchant_id' => Config::get('payment.merchant_id'),
            'authority' => $authority,
            'amount' => (int)$amount * 10 // convert toman to rial (but save toman in database of the app)
        ];

        $json_data = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_data)
        ));

        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);

        $onlinePayment->update([
            'bank_second_response' => $result
        ]);

        if (count($result['errors']) == 0) {
            if ($result['data']['code'] == 100) {
                return ['success' => true];
            } else {
                // Map the error code to the corresponding message
                $errorMessage = $this->resultCodes($result['data']['code']);
                return ['success' => false, 'errorMessage' => $errorMessage];
            }
        } else {
            // Handle errors if any
            // You might want to log the errors or handle them in a different way
            return ['success' => false, 'errorMessage' => 'خطا در تایید اطلاعات پرداخت'];
        }
    }

    function resultCodes($code): string
    {
        return match ($code) {
            100 => "با موفقیت تایید شد",
            102 => "merchant یافت نشد",
            103 => "merchant غیرفعال",
            104 => "merchant نامعتبر",
            201 => "قبلا تایید شده",
            105 => "amount بایستی بزرگتر از 1,000 ریال باشد",
            106 => "callbackUrl نامعتبر می‌باشد. (شروع با http و یا https)",
            113 => "amount مبلغ تراکنش از سقف میزان تراکنش بیشتر است.",
            202 => "سفارش پرداخت نشده یا ناموفق بوده است",
            203 => "trackId نامعتبر می‌باشد",
            default => "وضعیت مشخص شده معتبر نیست",
        };
    }

    function statusCodes($code): string
    {
        return match ($code) {
            -1 => "در انتظار پردخت",
            -2 => "خطای داخلی",
            1 => "پرداخت شده - تاییدشده",
            2 => "پرداخت شده - تاییدنشده",
            3 => "لغوشده توسط کاربر",
            4 => "‌شماره کارت نامعتبر می‌باشد",
            5 => "‌موجودی حساب کافی نمی‌باشد",
            6 => "رمز واردشده اشتباه می‌باشد",
            7 => "‌تعداد درخواست‌ها بیش از حد مجاز می‌باشد",
            8 => "‌تعداد پرداخت اینترنتی روزانه بیش از حد مجاز می‌باشد",
            9 => "مبلغ پرداخت اینترنتی روزانه بیش از حد مجاز می‌باشد",
            10 => "‌صادرکننده‌ی کارت نامعتبر می‌باشد",
            11 => "خطای سوییچ",
            12 => "کارت قابل دسترسی نمی‌باشد",
            default => "وضعیت مشخص شده معتبر نیست",
        };
    }
}
