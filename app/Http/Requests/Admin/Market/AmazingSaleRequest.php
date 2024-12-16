<?php

namespace App\Http\Requests\Admin\Market;

use App\Models\Admin\Market\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AmazingSaleRequest extends FormRequest
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
            'start_date' => substr($this->input('start_date'), 0, 10),
            'end_date' => substr($this->input('end_date'), 0, 10)
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
            'product_id' => 'required|exists:' . Product::class . ',id',
            'percentage' => ['required', 'numeric', 'between:1,100'],
            'start_date' => ['numeric', 'before_or_equal:end_date'],
            'end_date' => ['numeric', 'after_or_equal:start_date'],
            'status' => ['required', 'in:0,1']
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'محصول',
            'percentage' => 'درصد تخفیف',
            'start_date' => 'تاریخ شروع تخفیف',
            'end_date' => 'تاریخ پایان تخفیف',
            'status' => 'وضعیت'
        ];
    }
}
