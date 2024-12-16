<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            $rules = [
                'persian_name' => 'required|max:50|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r&?؟!! ]+$/u',
                'original_name' => 'required|max:50|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r&?؟!! ]+$/u',
                'logo' =>  'nullable|image|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml|max:4096',
                'status' => 'required|numeric|in:0,1',
                'tags' => 'string'
            ];
        } elseif($this->isMethod('put')) {
            $rules = [
                'persian_name' => 'required|max:50|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r&?؟!! ]+$/u',
                'original_name' => 'required|max:50|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r&?؟!! ]+$/u',
                'logo' => 'nullable|image|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml|max:4096',
                'status' => 'required|numeric|in:0,1',
                'tags' => 'string'
            ];
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'persian_name' => 'نام فارسی برند',
            'original_name' => 'نام لاتین برند',
            'logo' => 'لوگوی برند'
        ];
    }
}
