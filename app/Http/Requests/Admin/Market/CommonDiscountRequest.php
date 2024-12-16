<?php

namespace App\Http\Requests\Admin\Market;

use App\Models\Admin\Market\CommonDiscount;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommonDiscountRequest extends FormRequest
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
            'discount_ceiling' => str_replace(',', '', $this->input('discount_ceiling')),
            'minimum_order_amount' => str_replace(',', '', $this->input('minimum_order_amount')),
            'start_date' => substr($this->input('start_date'),0,10),
            'end_date' => substr($this->input('end_date'),0,10)
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
        $discount = $this->route('discount');
        if ($this->isMethod('post')) {
            return [
                'title' => [
                    'required',
                    'string',
                    'min:2',
                    Rule::unique('common_discounts', 'title')
                        ->where('deleted_at')
                ],
                'percentage' => ['required', 'numeric', 'between:1,100'],
                'discount_ceiling' => ['nullable', 'numeric'],
                'minimum_order_amount' => ['nullable', 'numeric'],
                'start_date' => ['numeric', 'before_or_equal:end_date'],
                'end_date' => ['numeric', 'after_or_equal:start_date'],
                'status' => ['required', 'in:0,1']
            ];
        } elseif ($this->isMethod('put')) {
            return [
                'title' => [
                    'required',
                    'string',
                    'min:2',
                    Rule::unique('common_discounts', 'title')->ignore($discount->id)
                ],
                'percentage' => ['required', 'numeric', 'between:1,100'],
                'discount_ceiling' => ['nullable', 'numeric'],
                'minimum_order_amount' => ['nullable', 'numeric'],
                'start_date' => ['numeric', 'before_or_equal:end_date'],
                'end_date' => ['numeric', 'after_or_equal:start_date'],
                'status' => ['required', 'in:0,1']
            ];
        }
    }

    public function attributes(): array
    {
        return [
            'title' => 'عنوان تخفیف',
            'code' => 'کد تخفیف',
            'percentage' => 'درصد تخفیف',
            'discount_ceiling' => 'سقف تخفیف',
            'minimum_order-amount' => 'حداقل میزان خرید',
            'start_date' => 'تاریخ شروع تخفیف',
            'end_date' => 'تاریخ پایان تخفیف'
        ];
    }
}
