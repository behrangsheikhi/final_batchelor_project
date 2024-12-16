<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
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
            'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'url' => [
                'required',
                'url',
                Rule::unique('menus')->whereNull('deleted_at')->ignore($this->menu),
            ],
            'status' => 'required|numeric|in:0,1',
            'parent_id' => 'nullable|string|exists:menus,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'url' => 'لینک',
            'parent_id' => 'منوی والد'
        ];
    }
}
