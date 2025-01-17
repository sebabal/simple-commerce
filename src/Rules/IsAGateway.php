<?php

namespace DoubleThreeDigital\SimpleCommerce\Rules;

use DoubleThreeDigital\SimpleCommerce\Contracts\Gateway;
use Illuminate\Contracts\Validation\Rule;

class IsAGateway implements Rule
{
    public function passes($attribute, $value)
    {
       return (new $value()) instanceof Gateway;
    }

    public function message()
    {
        return __('simple-commerce::validation.is_a_gateway');
    }
}