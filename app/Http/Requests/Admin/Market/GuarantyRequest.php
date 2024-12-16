<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GuarantyRequest extends FormRequest
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

    public function prepareForValidation(): void
    {
        $this->merge([
            'price_increase' => str_replace(',', '', $this->input('price_increase')),
        ]);
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
            'name' => ['required', 'string', 'max:255'],
            'price_increase' => ['required'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'عنوان گارانتی',
            'price_increase' => 'افزایش قیمت',
        ];
    }
}
