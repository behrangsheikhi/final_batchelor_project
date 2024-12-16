<?php

namespace App\Http\Controllers\Website\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Customer\ProfileRequest;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Models\Admin\Market\CartItem;
use App\Models\Auth\OTP;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Melipayamak\MelipayamakApi;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart_items = CartItem::where('user_id', $user->id)->get();
        return view('app.customer.sales-process.profile', compact(['user', 'cart_items']));
    }

    public function update(ProfileRequest $request)
    {
        // TODO : TEST THIS METHOD TO ENSURE THAT EVERYTHING IN ANY CONDITION IS OK
        if (Auth::check()) {
            $inputs = $request->all();
            $user = Auth::user();
            // set identity to send otp code to authenticate

            if (isset($inputs['mobile']) || isset($inputs['email'])) {
                if (isset($inputs['email']) && empty($user->email) && filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
                    $type = 'email';
                    $old_user = User::where('email', $inputs['email'])->first();
                    if ($old_user) {
                        return redirect()->back()->with('swal-error', 'ایمیل وارد شده تکراری است.');
                    }
                } elseif (isset($inputs['mobile']) && empty($user->mobile) && preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['mobile'])) {
                    $type = 'mobile';
                    $inputs['mobile'] = convertArabicToEnglish($inputs['mobile']);
                    $inputs['mobile'] = convertPersianToEnglish($inputs['mobile']);
                    // all mobile number should have this format : 9** *** ****
                    $inputs['mobile'] = ltrim($inputs['mobile'], '0');
                    $inputs['mobile'] = str_starts_with($inputs['mobile'], '98') ? substr($inputs['mobile'], 2) : $inputs['mobile'];;
                    str_replace('+98', '', $inputs['mobile']);
                    // TODO : FIX THIS PART
                    $user_mobile = '0' . $inputs['mobile'];
                    $old_user = User::where('mobile', $user_mobile)->first();
                    if ($old_user) { // user is new
                        return redirect()->back()->with('swal-error', 'شماره موبایل وارد شده تکراری است.');
                    }
                }// end elseif
                else {
                    $user = User::where('id', Auth::user()->id)->first();
                    $token = null;
                }
                if (isset($type)) {
                    // create OTP code
                    $otp_code = rand(100000, 999999);
                    $token = Str::random(60);
                    $otp_record = [
                        'token' => $token,
                        'user_id' => Auth::user()->id,
                        'otp_code' => $otp_code,
                        'identity' => $inputs['mobile'] ?? $inputs['email'],
                        'type' => $type,
                        'used' => 0,
                    ];
                    OTP::create($otp_record);
                }
            }

            // Update first name and last name if provided
            if (isset($inputs['firstname'])) {
                $user->firstname = $request->firstname;
            }
            if (isset($inputs['lastname'])) {
                $user->lastname = $request->lastname;
            }
            if (isset($request->national_code)) {
                $national_code = convertPersianToEnglish($request->national_code);
                $national_code = convertArabicToEnglish($request->national_code);
                $user->national_code = $national_code;
            }
            $user->save();

            if (isset($otp_code)) {

                if ($type === 'mobile') {
                    $user_mobile = '0' . $otp_record['identity'];
                    // send otp to mobile number
                    $username = Config::get('sms.username');
                    $password = Config::get('sms.password');
                    $api = new MelipayamakApi($username, $password);
                    $smsSoap = $api->sms('soap');
                    $to = $user_mobile;
                    $bodyId = '194834';
                    $text = array($otp_code);
                    $response = $smsSoap->SendByBaseNumber($text[0], $to, $bodyId);

                } elseif ($type === 'email') {
                    $user_email = '0' . $otp_record['identity'];
                    // send otp to email
                    $type = $inputs['email'];
                    $email_service = new EmailService();
                    $details = [
                        'title' => 'لطفا ایمیل خود را تایید کنید.',
                        'body' => "کد فعالسازی شما : $otp_code"
                    ];
                    $email_service->setDetails($details);
                    $email_service->setFrom('behrangsheikhi@hotmail.com', 'راسته فرش');
                    $email_service->setSubject('کد یکبار مصرف شما');
                    $email_service->setTo($inputs['email']);
                    $message_service = new MessageService($email_service);
                    $message_service->send();
                }
                return redirect()->route('customer.profile.confirm-form', compact('token'))->with('swal-success', 'کد تایید با موفقیت ارسال شد.');
            } else {
                return redirect()->route('customer.address-and-delivery')->with('swal-success', 'اطلاعات وارد شده با موفقیت ثبت شد.');
            }
        }
        return redirect()->route('customer.auth-form')->with('swal-error', 'ابتدا وارد حساب کاربری خود شوید.');
    }

    public function confirmForm($token)
    {
        $otp = OTP::where('token', $token)->first();
        $identity = $otp->identity;
        if (empty($otp)) {
            return redirect()->route('customer.profile.update')->with('swal-error', 'آدرس وارد شده نامعتبر می باشد.');
        }
        return view('app.customer.sales-process.profile-confirm', compact(['token', 'otp', 'identity']));
    }

    public function confirm($token,Request $request)
    {
        $inputs = $request->validate([
            'otp' => 'required|min:6|max:6|exists:' . OTP::class . ',otp_code'
        ], [
            'otp.required' => 'کد تایید الزامی است.',
            'otp.min' => 'کد وارد شده معتبر نیست.',
            'otp.max' => 'کد وارد شده معتبر نیست.',
            'otp.exists' => 'کد وارد شده معتبر نیست.',
        ]);
        $otp = OTP::where('token', $token)
            ->where('used', 0)
            ->where('created_at', '>=', Carbon::now()->subSeconds(60)->toDateTimeString())
            ->first();

        if (empty($otp)) {
            return redirect()->back()->with('swal-error', 'کد وارد شده معتبر نیست.');
        } else {
            $otp->used = 1;
            $otp->save();
            $user = $otp->user()->first();

            if ($otp->type === 'email') {
                $user->update([
                    'email' => $otp->identity,
                    'email_verified_at' => Carbon::now()
                ]);
            } elseif($otp->type === 'mobile') {
                $user->update([
                    'mobile' => $otp->identity,
                    'mobile_verified_at' => Carbon::now()
                ]);
            }
        }
        return redirect()->route('customer.address-and-delivery')->with('swal-success','شناسه شما با موفقیت تایید شد.');

    }


}
