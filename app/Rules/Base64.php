<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Base64 implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->passes($value)) {
            $fail("The $attribute must be a base64 encoded image.");
        }
    }

    /**
     * Determine if the validation rule passes.
     */
    public function passes(string $value): bool
    {
        return preg_match('/^data:image\/(\w+);base64,/', $value) === 1;
    }
}
