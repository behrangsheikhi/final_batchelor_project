<?php

namespace App\Http\Requests\Auth;

use App\Models\Auth\OTP;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

class LoginRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'identity' => convertPersianToEnglish($this->input('identity')),
            'otp' => convertPersianToEnglish($this->input('otp')),
            'national_code' => convertPersianToEnglish($this->input('national_code'))
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * //     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $route = \Illuminate\Support\Facades\Route::currentRouteName();
        if ($route === 'auth.auth') {
            return [
                'identity' => 'required|min:11|max:64|regex:/^[a-zA-Z0-9_.@\+]*$/',
            ];
        } elseif ($route === 'auth.login-confirm.token') {
            return [
                'otp' => 'required|min:6|max:6|exists:' . OTP::class . ',otp_code'
            ];
        } else {
            return [
                'firstname' => 'required|min:2|max:30|persian_alpha',
                'lastname' => 'required|min:2|max:30|persian_alpha',
                'national_code' => ['required', 'unique:' . User::class . ',national_code', 'ir_national_code'],
                'identity' => ['required', 'unique:' . User::class . ',mobile', 'ir_mobile'],
            ];
        }

    }

    public function attributes(): array
    {
        return [
            'identity' => 'شماره موبایل',
            'otp' => 'کد وارد شده',
            'national_code' => 'کد ملی'
        ];
    }

    public function messages(): array
    {
        return [
            'otp.required' => 'رمز یکبار مصرف الزامی است.',
            'otp.exists' => 'رمز یکبار مصرف معتبر نیست.'
        ];
    }
}
