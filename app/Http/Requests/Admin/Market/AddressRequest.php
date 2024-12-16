<?php

namespace App\Http\Requests\Admin\Market;

use App\Models\Admin\Market\Address;
use App\Models\Admin\Market\City;
use App\Models\Admin\Market\Province;
use Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::check())
            return true;

        return false;
    }

    public function prepareForValidation(): void
    {
        // Convert postal_code, no, and unit to English characters
        $this->merge([
            'address' => convertPersianToEnglish($this->input('address')),
            'postal_code' => convertPersianToEnglish($this->input('postal_code')),
            'no' => convertPersianToEnglish($this->input('no')),
            'unit' => convertPersianToEnglish($this->input('unit')),
            'mobile' => convertPersianToEnglish($this->input('mobile'))
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            $rules = [
                'province_id' => 'required|exists:' . Province::class . ',id',
                'city_id' => 'required|exists:' . City::class . ',id',
                'address' => 'required|string|min:1|max:300',
                'receiver' => 'sometimes',
                'postal_code' => 'required|string|ir_postal_code|unique:' . Address::class . ',postal_code',
                'no' => 'nullable',
                'unit' => 'nullable',
                'recipient_first_name' => 'required_if:receiver,on|persian_alpha',
                'recipient_last_name' => 'required_if:receiver,on|persian_alpha',
                'mobile' => 'required_if:receiver,on|ir_mobile',
            ];
        } elseif ($this->isMethod('put')) {
            $rules = [
                'province_id' => 'required|exists:' . Province::class . ',id',
                'city_id' => 'required|exists:' . City::class . ',id',
                'address' => 'required|string|min:1|max:300',
                'postal_code' => [
                    'required',
                    'string',
                    'ir_postal_code',
                    Rule::unique('addresses', 'postal_code')
                        ->ignore($this->route('address'), 'id')
                        ->where('deleted_at'),
                ],
                'no' => 'nullable',
                'unit' => 'nullable',
                'receiver' => 'sometimes',
                'recipient_first_name' => 'required_if:receiver,on|persian_alpha',
                'recipient_last_name' => 'required_if:receiver,on|persian_alpha',
                'mobile' => 'required_if:receiver,on|ir_mobile',
            ];
        }
        return $rules;

    }

    public function attributes(): array
    {
        return [
            'province_id' => 'استان',
            'city_id' => 'شهر',
            'address' => 'آدرس',
            'recipient_first_name' => 'نام گیرنده',
            'recipient_last_name' => 'نام خانوادگی گیرنده',
            'mobile' => 'شماره موبایل گیرنده',
            'receiver' => 'سفارش برای شخص دیگر',
            'receiver.on' => 'علامت زده شده',
            'postal_code' => 'کد پستی',
            'no' => 'شماره پلاک',
            'unit' => 'واحد'
        ];
    }


}
