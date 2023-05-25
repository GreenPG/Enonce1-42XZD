<?php

namespace TotalSurveyVendors\League\Container\Exception;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\Psr\Container\NotFoundExceptionInterface;
use InvalidArgumentException;

class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}
