<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            $rules = [
                'name' => 'required|string|max:120|min:2',
                'parent_id' => 'nullable|sometimes|exists:product_categories,id',
                'image' => 'nullable|mimes:png,jpg,jpeg,gif,webp',
                'status' => 'required|integer|in:0,1',
                'tags' => 'required|string',
                'description' => 'required|string|max:1000|min:5',
                'show_in_menu' => 'required|integer|in:0,1',
            ];
        } else {
            $rules['image'] = 'nullable';
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'show_in_menu' => 'وضعیت نمایش در منو',
            'parent_id' => 'منوی والد',
            'image' => 'تصویر دسته بندی'
        ];
    }
}
