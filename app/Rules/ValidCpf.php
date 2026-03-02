<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCpf implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $digits = preg_replace('/\D+/', '', (string) $value) ?? '';

        if (strlen($digits) !== 11) {
            $fail('CPF inválido. Use o formato 000.000.000-00.');

            return;
        }

        if (preg_match('/^(\d)\1{10}$/', $digits)) {
            $fail('CPF inválido. Use o formato 000.000.000-00.');

            return;
        }

        for ($t = 9; $t < 11; $t++) {
            $sum = 0;

            for ($index = 0; $index < $t; $index++) {
                $sum += (int) $digits[$index] * (($t + 1) - $index);
            }

            $digit = ((10 * $sum) % 11) % 10;

            if ((int) $digits[$t] !== $digit) {
                $fail('CPF inválido. Verifique os dígitos informados.');

                return;
            }
        }
    }
}
