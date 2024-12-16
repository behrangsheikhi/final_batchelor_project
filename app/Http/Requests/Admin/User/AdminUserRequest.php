<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user())
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
        if ($this->isMethod('put')) {
            $rules = [
                'firstname' => 'nullable|max:120|string',
                'lastname' => 'nullable|max:120|string',
                'profile_photo_path' => 'nullable|image|mimes:png,jpg,jpeg,gif',
            ];
            if ($this->filled('password')){
                $rules['password'] = [
                    'required',
                    'unique:users',
                    Password::min(8)->letters()->numbers()->uncompromised(),
                    'confirmed'
                ];
            }
            return $rules;
        } else {
            // TODO : fix the password uppercase and lowercase validation usage! show the messages in persian
            return [
                'firstname' => 'nullable|max:120|string',
                'lastname' => 'nullable|max:120|string',
                'mobile' => ['required', 'digits:11', 'unique:users'],
                'email' => [ 'nullable', 'email', 'unique:users'],
//                'password' => ['required', 'unique:users', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(), 'confirmed'],
                'password' => ['required', 'unique:users', Password::min(8)->letters()->numbers()->uncompromised(), 'confirmed'],
                'profile_photo_path' => 'nullable|image|mimes:png,jpg,jpeg,gif',
                'activation' => 'numeric|in:0,1',
                'status' => 'required|numeric|in:0,1'
            ];
        }
    }

    public function attributes(): array
    {
        return [
            'national_code' => 'کد ملی',
            'profile_photo_path' => 'تصویر پروفایل',
            'activation' => 'مجوز فعالیت',
            'current_team_id' => 'تیم'
        ];
    }
}
