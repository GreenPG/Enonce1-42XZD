<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Contracts;
! defined( 'ABSPATH' ) && exit();


/**
 * Interface ActionInterface
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Contracts
 */
interface ActionInterface
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