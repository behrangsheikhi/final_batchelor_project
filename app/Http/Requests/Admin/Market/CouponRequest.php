<?php

namespace App\Http\Requests\Admin\Market;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
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
            'amount' => str_replace(',', '', $this->input('amount')),
            'discount_ceiling' => ($this->input('discount_ceiling') !== null) ? str_replace(',', '', $this->input('discount_ceiling')) : null,
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
        $rules = [];
        $commonRules = [
            'code' => [
                'required',
                'string',
                'min:1',
                Rule::unique('coupons', 'code')->where('deleted_at'),
            ],
            'amount' => [
                'required',
                'numeric',
                Rule::when($this->input('amount_type') == 0, ['between:1,100']),
            ],
            'amount_type' => ['required', 'in:0,1'],
            'discount_ceiling' => ['nullable', 'numeric', 'min:0'],
            'type' => ['required', 'in:0,1'],
            'status' => ['required', 'in:0,1'],
            'start_date' => ['numeric', 'before_or_equal:end_date'],
            'end_date' => ['numeric', 'after_or_equal:start_date'],
            'user_id' => [
                Rule::when($this->input('type') == 1, ['required', 'exists:' . User::class . ',id']),
            ],
        ];

        if ($this->isMethod('post')) {
            $rules = $commonRules;
        } elseif ($this->isMethod('put')) {
            $rules = array_merge($commonRules, [
                'code' => [
                    'required',
                    'string',
                    'min:1',
                    Rule::unique('coupons', 'code')
                        ->ignore($this->route('coupon'), 'id')
                        ->where('deleted_at'),
                ],
                'type' => [
                    Rule::when($this->input('user_id') != null,['required',Rule::in([1])])
                ]

            ]);
        }

        return $rules;

    }

    public function attributes()
    {
        return [
            'code' => 'کد تخفیف',
            'amount' => 'مقدار',
            'amount_type' => 'نوع تخفیف(درصدی/ریالی)',
            'discount_ceiling' => 'حداکثر مقدار تخفیف',
            'type' => 'نوع تخفیف(عمومی/اختصاصی)',
            'status' => 'وضعیت',
            'start_date' => 'تاریخ شروع',
            'end_date' => 'تاریخ پایان',
            'user_id' => 'مشتری'
        ];
    }
}
