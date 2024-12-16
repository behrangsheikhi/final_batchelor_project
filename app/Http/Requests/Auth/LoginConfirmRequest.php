<?php

namespace App\Http\Requests\Auth;

use App\Models\Auth\OTP;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginConfirmRequest extends FormRequest
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
            'otp' => convertPersianToEnglish($this->input('otp'))
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'otp' => 'required|min:6|max:6|exists:' . OTP::class . ',otp_code'
        ];
    }

    public function attributes(): array
    {
        return [
            'otp' => 'کد وارد شده',
        ];
    }
}
