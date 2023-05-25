<?php

namespace TotalSurveyVendors\Rakit\Validation\Rules\Interfaces;
! defined( 'ABSPATH' ) && exit();


interface BeforeValidate
{
    /**
     * Before validate hook
     *
     * @return void
     */
    public function beforeValidate();
}
