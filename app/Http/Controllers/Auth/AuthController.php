<?php

namespace App\Http\Controllers\Auth;

use App\Constants\UserTypeValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginConfirmRequest;
use App\Http\Requests\Auth\LoginRegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\Auth\OTP;
use App\Models\User;
use DB;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Melipayamak\MelipayamakApi;

class AuthController extends Controller
{
    public function form()
    {
        return view('auth.login-register');
    }

    public function auth(LoginRequest $request)
    {
        $inputs = $request->all();
        // check what is the identity?
        if (preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['identity'])) {
            $type = 'mobile';
            // all mobile numbers should have this number format in iran
            $inputs['identity'] = ltrim($inputs['identity'], '0');
            $inputs['identity'] = str_starts_with($inputs['identity'], '98') ? substr($inputs['identity'], 2) : $inputs['identity'];
            str_replace('=+98', '', $inputs['identity']);
            $user_mobile = '0' . $inputs['identity'];
            $user = User::whereMobile($user_mobile)->first();
        } else {
            return redirect()->back()->with('swal-error', 'شماره موبایل نامعتبر است.');
        }

        // create an OTP code for authenticate user
        $otp_code = rand(100000, 999999);
        $token = Str::random(64);
        $otp_inputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otp_code,
            'identity' => $inputs['identity'],
            'type' => $type,
            'used' => 0
        ];
        OTP::create($otp_inputs);

        // send SMS to user
        if ($type === 'mobile') {
            $username = \Config::get('sms.username');
            $password = \Config::get('sms.password');
            $api = new MelipayamakApi($username, $password);
            $smsSoap = $api->sms('soap');
            $to = $user->mobile;
            $bodyId = '194834';
            $text = array($otp_code);
            $response = $smsSoap->SendByBaseNumber($text[0], $to, $bodyId);
        } else {
            return redirect()->back()->with('swal-error', 'شماره موبایل اشتباه است.');
        }
        return redirect()->route('auth.login-confirm-form', $token)->with('swal-success', 'کد تایید ارسال شد.');
    }

    public function loginConfirmForm($token)
    {
        $otp = OTP::where('token', $token)->first();
        if (empty($otp)) {
            return redirect()->route('auth.form')->with('swal-error', 'خطا در اعتبار سنجی');
        }
        return view('auth.login-confirm', compact(['token', 'otp',]));
    }

    public function loginConfirm($token, LoginConfirmRequest $request)
    {
        $inputs = $request->all();

        $otp = OTP::where('token', $token)
            ->where('used', 0)
            ->where('created_at', '>=', Carbon::now()->subSeconds(120))
            ->first();

        if (empty($otp)) {
            return redirect()->route('auth.form')->with('swal-error', 'خطا در اعتبار سنجی');
        }
        // if otp does not match
        if ($otp->otp_code !== $inputs['otp']) {
            return redirect()->route('auth.form')->with('swal-error', 'کد تایید نامعتبر است.');
        } else {
            // if everything is OK!
            $otp->used = 1;
            $otp->save();
            $user = $otp->user()->first();

            if ($otp->type === 'mobile' && $user->mobile_verified_at == null) {
                $user->mobile_verified_at = now();
                $user->activation = 1;
                $user->activation_date = now();
                $user->save();
            }

            // login the user
            Auth::login($user);

            if ($user->user_type === UserTypeValue::SUPER_ADMIN || $user->user_type === UserTypeValue::ADMIN) {
                return redirect()->route('admin.admin');
            }
            return redirect()->route('app.home');
        }
    }

    public function registerCreate()
    {
        return view('auth.register');
    }

    public function registerSendOtp(RegisterRequest $request)
    {
        try {
            $inputs = $request->all();
            $user = User::whereMobile($inputs['identity'])->first();

            if ($user) {
                return redirect()->route('auth.form')->withErrors(['error', 'شما قبلا ثبت نام کرده اید']);
            } else {

                DB::beginTransaction();
                // create the new user if user is invalid in users table
                $newUser = User::create([
                    'firstname' => $inputs['firstname'],
                    'lastname' => $inputs['lastname'],
                    'mobile' => $inputs['identity'],
                    'mobile_verified_at' => Carbon::now(),
                    'activation' => 1,
                    'activation_date' => Carbon::now(),
                    'status' => 1,
                    'national_code' => $inputs['national_code'],
                    'user_type' => 3, // customer
                ]);

                // create code and token
                $otpCode = rand(100000, 999999);
                $token = Str::random(64);

                // create otp a record in otp table
                OTP::create([
                    'token' => $token,
                    'user_id' => $newUser->id,
                    'mobile' => $inputs['identity'],
                    'otp_code' => $otpCode,
                    'used' => 0
                ]);

                // send the sms to user
                $username = Config::get('sms.username');
                $password = Config::get('sms.password');
                $api = new MelipayamakApi($username, $password);
                $smsSoap = $api->sms('soap');
                $to = $newUser->mobile;
                $bodyID = Config::get('sms.bodyId');
                $text = array($otpCode);
                $smsSoap->SendByBaseNumber($text[0], $to, $bodyID);

                DB::commit();
                return $this->loginConfirmForm($token)->with('swal-success', 'کد تایید ارسال شد');
            }
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function dashboard()
    {
        if (Auth::user()->user_type == 1 || Auth::user()->user_type == 2){
            return view('admin.index');
        }

        return view('app.customer.dashboard.index');
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('app.home');
    }

}
