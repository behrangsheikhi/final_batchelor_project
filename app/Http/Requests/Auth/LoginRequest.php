<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'identity' => convertPersianToEnglish($this->input('identity'))
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
            'identity' => 'required|min:11|max:64|regex:/^[a-zA-Z0-9_.@\+]*$/',
        ];
    }

    public function attributes(): array
    {
        return [
            'identity' => 'شماره موبایل',
        ];
    }
}
