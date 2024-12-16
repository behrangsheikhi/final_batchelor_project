<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
//        dd($this->request);
        return [
            'title' =>  'required|max:100|min:3|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r&::،?؟!! ]+$/u',
            'description' =>  'required|max:1000|min:3|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r&?؟!! ]+$/u',
            'logo' => 'image|mimes:jpg,jpeg,png,svg',
            'icon' => 'image|mimes:jpg,jpeg,png,svg',
            'address' =>   'required|max:100|min:3|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.،,><\/;\n\r&?؟!! ]+$/u',
            'keywords' =>  'required|max:500|min:3|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r&?؟!! ،,]+$/u',
            'email' => 'email',
            'phone' => ['regex:/^(\+98|0)?9\d{9}$/']
        ];
    }

    public function attributes(): array
    {
        return [
            'logo' => 'لوگو',
            'icon' => 'آیکون',
            'keywords' => 'کلمات کلیدی'
        ];
    }
}
