<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
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
            'amount' => str_replace(',','',$this->input('amount'))
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')){
            $rules = [
                'name' => 'required|string|min:2|max:50',
                'amount' => 'required|regex:/^[0-9]+$/u',
                'delivery_time' => 'required|integer',
                'delivery_time_unit' => 'required|string',
                'status' => 'required|numeric|in:0,1',
                'description' => 'nullable|string'
            ];
        }
        elseif($this->isMethod('put')){
            $rules = [
                'name' => 'required|string|min:2|max:50',
                'amount' => 'required|numeric',
                'delivery_time' => 'required|numeric',
                'delivery_time_unit' => 'required|string',
                'description' => 'nullable|string|min:2|max:255'
            ];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name' => 'عنوان روش ارسال',
            'amount' => 'هزینه روش ارسال',
            'delivery_time' => 'مدت زمان تحویل',
            'delivery_time_unit' => 'واحد زمانی',
            'description' => 'توضیحات روش ارسال'
        ];
    }
}
