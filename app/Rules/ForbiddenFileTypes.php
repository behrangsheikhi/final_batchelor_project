<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ForbiddenFileTypes implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    public function rule($attribute, $value): bool
    {
        $forbiddenExtensions = ['exe', 'sql', 'js','json','jsx','py','cpp','c'];
        $extension = strtolower($value->getClientOriginalExtension());
        return !in_array($extension, $forbiddenExtensions);
    }
}
