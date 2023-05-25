<?php

namespace TotalSurvey\Validations;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\Rakit\Validation\Rule;
use TotalSurveyVendors\Rakit\Validation\Rules\Traits\SizeTrait;

class MinLength extends Rule
{

    use SizeTrait;

    /** @var string */
    protected $message = "The :attribute minimum length  is :minLength";

    /** @var array */
    protected $fillableParams = ['minLength'];

    /**
     * Check the $value is valid
     *
     * @param  mixed  $value
     *
     * @return bool
     * @throws \TotalSurveyVendors\Rakit\Validation\MissingRequiredParameterException
     */
    public function check($value): bool
    {
        $this->requireParameters($this->fillableParams);
        $min         = $this->getBytesSize($this->parameter('minLength'));
        $valueString = strlen((string) $value);

        return $valueString >= $min;
    }
}
