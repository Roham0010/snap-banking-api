<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CreditCard implements ValidationRule
{
    /**
     * Runs a validation rule.
     * Credit: check here for the validation algorithm
     * http://www.aliarash.com/article/creditcart/credit-debit-cart.htm
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[0-9]{16}$/u', $value)) {
            $fail('The :attribute must be a valid credit card number.');
        }
        $value = str_split($value);
        $total = 0;
        for ($i = 0; $i < 16; $i++) {
            $number = (int) $value[$i];
            if ($i % 2 == 0) {
                $total += (($number * 2 > 9) ? ($number * 2) - 9 : ($number * 2));
            } else {
                $total += $number;
            }
        }

        if ($total % 10 !== 0) {
            $fail('The :attribute must be a valid credit card number.');
        }
    }
}
