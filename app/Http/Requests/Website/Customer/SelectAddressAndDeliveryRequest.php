<?php

namespace App\Http\Requests\Website\Customer;

use App\Models\Admin\Market\Address;
use App\Models\Admin\Market\Delivery;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SelectAddressAndDeliveryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (\Auth::check())
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
            'address_id' => 'required|exists:'.Address::class.',id',
            'delivery_id' => 'required|exists:'.Delivery::class.',id'
        ];
    }
}
