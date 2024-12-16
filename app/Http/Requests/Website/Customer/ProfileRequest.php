<?php

namespace App\Http\Requests\Website\Customer;

use App\Rules\NationalCodeRule;
use Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::check())
            return true;

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'sometimes|required',
            'lastname' => 'sometimes|required',
            'email' => 'sometimes|email|unique:users,email',
            'mobile' => 'sometimes|min:10|max:13|unique:users,mobile',
            'national_code' => [
                'sometimes',
                'unique:users,national_code',
                Rule::unique('users', 'national_code'),
                new NationalCodeRule
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'firstname' => 'نام',
            'lastname' => 'نام خانوادگی',
            'mobile' => 'موبایل',
            'national_code' => 'کد ملی',
            'email' => 'ایمیل'
        ];
    }
}
