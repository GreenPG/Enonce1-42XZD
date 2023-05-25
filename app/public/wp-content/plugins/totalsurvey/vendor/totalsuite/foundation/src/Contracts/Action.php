<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Contracts;
! defined( 'ABSPATH' ) && exit();


/**
 * Interface Action
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Contracts
 */
interface Action
{
    /**
     * @return bool
     */
    public function authorize(): bool;

    /**
     * @return array
     */
    public function getParams(): array;
}