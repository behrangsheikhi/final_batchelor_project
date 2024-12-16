<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation() : void
    {
        $this->merge([
            'identity' => convertPersianToEnglish($this->input('identity')),
            'national_code' => convertPersianToEnglish($this->input('national_code'))
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
            'national_code' => ['required', 'unique:' . User::class . ',national_code', 'ir_national_code'],
            'identity' => ['required', 'unique:' . User::class . ',mobile', 'ir_mobile'],
        ];
    }

    public function attributes(): array
    {
        return [
            'identity' => 'شماره موبایل',
            'national_code' => 'کد ملی'
        ];
    }

}
