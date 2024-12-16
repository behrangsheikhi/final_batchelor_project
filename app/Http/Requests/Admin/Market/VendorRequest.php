<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class VendorRequest extends FormRequest
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
        return [
            'firstname' => 'required|string|min:2|max:50',
            'lastname' => 'required|string|min:2|max:100',
            'national_code' => 'required|max:12|unique:vendors,national_code',
            'mobile' => 'required|max:11|unique:vendors,mobile',
            'email' => 'required|email:filter|unique:vendors,email',
            'password' => 'required',\Illuminate\Validation\Rules\Password::min(8)->letters()->uncompromised()->numbers(),'confirmed',
            'profile_photo_path' => 'nullable|image|mimes:png,jpg,jpeg,gif',
            'status' => 'required|numeric|in:0,1',
        ];
    }

    public function attributes() : array
    {
        return [
            'national_code' => 'کد ملی',
        ];
    }
}
