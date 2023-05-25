<?php

namespace TotalSurveyVendors\Rakit\Validation\Rules;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\Rakit\Validation\Rule;

class TypeArray extends Rule
{

    /** @var string */
    protected $message = "The :attribute must be array";

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        return is_array($value);
    }
}
