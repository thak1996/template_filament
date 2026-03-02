<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCnpj implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $digits = preg_replace('/\D+/', '', (string) $value) ?? '';

        if (strlen($digits) !== 14) {
            $fail(__('onboarding.validation.cnpj_format'));

            return;
        }

        if (preg_match('/^(\d)\1{13}$/', $digits)) {
            $fail(__('onboarding.validation.cnpj_format'));

            return;
        }

        $weightsOne = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $weightsTwo = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        $sumOne = 0;
        foreach ($weightsOne as $index => $weight) {
            $sumOne += (int) $digits[$index] * $weight;
        }

        $digitOne = $sumOne % 11;
        $digitOne = $digitOne < 2 ? 0 : 11 - $digitOne;

        if ((int) $digits[12] !== $digitOne) {
            $fail(__('onboarding.validation.cnpj_digits'));

            return;
        }

        $sumTwo = 0;
        foreach ($weightsTwo as $index => $weight) {
            $sumTwo += (int) $digits[$index] * $weight;
        }

        $digitTwo = $sumTwo % 11;
        $digitTwo = $digitTwo < 2 ? 0 : 11 - $digitTwo;

        if ((int) $digits[13] !== $digitTwo) {
            $fail(__('onboarding.validation.cnpj_digits'));
        }
    }
}
