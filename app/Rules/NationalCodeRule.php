<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NationalCodeRule implements ValidationRule
{

    public function validate(string $attribute, $value, Closure $fail): void
    {
        // TODO : THIS METHOD IS NOT FULLY OK! TEST IT IN CASE THAT EVERYTHING IS OK OR NOT OK!
        $value = trim($value, ' .');
        $value = convertArabicToEnglish($value);
        $value = convertPersianToEnglish($value);
        $forbidden_national_numbers = [
            '0000000000',
            '1111111111',
            '2222222222',
            '3333333333',
            '4444444444',
            '5555555555',
            '6666666666',
            '7777777777',
            '8888888888',
            '9999999999'
        ];

        if (empty($value)) {
            $fail('کد ملی نامعتبر است.');
        } else if (count(str_split($value)) != 10) {
            $fail('کد ملی نامعتبر است.');
        } else if (in_array($value, $forbidden_national_numbers))
        {
            $fail('کد ملی نامعتبر است.');
        }
        else{

            $sum = 0;

            for($i = 0; $i < 9; $i++)
            {
                // 1234567890
                $sum += (int) $value[$i] * (10 - $i);
            }

            $divideRemaining = $sum % 11;

            if($divideRemaining < 2)
            {
                $lastDigit = $divideRemaining;
            }
            else{
                $lastDigit = 11 - ($divideRemaining);
            }

            if((int) $value[9] == $lastDigit)
            {
               echo 'ok';
            }
            else{
                $fail('کد ملی نامعتبر است.');
            }
        }
    }

    public function message(): string
    {
        return ':attribute معتبر نیست.';
    }


}
