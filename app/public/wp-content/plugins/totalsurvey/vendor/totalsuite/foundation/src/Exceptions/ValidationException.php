<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Exceptions;
! defined( 'ABSPATH' ) && exit();


/**
 * Class ValidationException
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Exceptions
 */
class ValidationException extends Exception
{
    const CODE = 422;
}