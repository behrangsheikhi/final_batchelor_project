<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Admin\Market\Product;

class CategoryValueRequest extends FormRequest
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
            'price_increase' => str_replace(',','',$this->input('price_increase'))
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
            'value' => 'required|string',
            'price_increase' => 'required|numeric',
            'type' => 'required|integer|in:0,1',
            'product_id' => 'required|exists:' . Product::class . ',id',
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'نام کالا',
            'value' => 'مقدار',
            'type' => 'نوع',
            'price_increase' => 'افزایش قیمت'
        ];
    }
}
