<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryAttributeRequest extends FormRequest
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
            'name' => 'required|string',
            'category_id' => 'required|exists:product_categories,id',
            'unit'=> 'nullable|string'
        ];
    }

    public function attributes() : array
    {
        return [
            'unit' => 'واحد اندازه گیری',
            'category_id' => 'دسته بندی والد',
            'name' => 'نام خصوصیت'
        ];
    }
}
