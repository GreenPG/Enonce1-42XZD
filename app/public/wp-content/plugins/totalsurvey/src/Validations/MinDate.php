<?php

namespace TotalSurvey\Validations;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\Rakit\Validation\Rules\After;
use TotalSurveyVendors\Rakit\Validation\Rules\Date;

class MinDate extends After
{

    /**
     * Check the $value is valid
     *
     * @param  mixed  $value
     *
     * @return bool
     * @throws \Exception
     */
    public function check($value): bool
    {
        $dateVal = new Date();
        if (!$dateVal->check($value)) {
            return false;
        }

        return parent::check($value);
    }
}
