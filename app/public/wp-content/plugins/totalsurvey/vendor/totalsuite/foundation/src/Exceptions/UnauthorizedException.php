<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Exceptions;
! defined( 'ABSPATH' ) && exit();



/**
 * Class UnauthorizedException
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Exceptions
 */
class UnauthorizedException extends Exception
{
    const CODE = 401;
}