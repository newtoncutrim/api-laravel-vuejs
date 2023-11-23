<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordComplexRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) < 8 || !preg_match('/[A-Z]/', $value) || !preg_match('/[\W_]/', $value)) {
            $fail('A senha deve conter pelo menos 8 caracteres, 1 letra maiúscula e 1 símbolo.');
        }
    }
}

