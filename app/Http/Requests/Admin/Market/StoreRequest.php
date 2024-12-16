<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'marketable_number' => str_replace(',','',$this->input('marketable_number'))
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
            'receiver' => 'required|min:2|max:120|string',
            'deliverer' => 'required|min:2|max:120|string',
            'details' => 'required|min:5|max:255|string',
            'marketable_number' => 'required|numeric'
        ];
    }

    public function attributes(): array
    {
        return [
            'receiver' => 'نام تحویل گیرنده',
            'deliverer' => 'نام تحویل دهنده',
            'details' => 'جزئیات',
            'marketable_number' => 'تعداد قابل فروش'
        ];
    }
}
