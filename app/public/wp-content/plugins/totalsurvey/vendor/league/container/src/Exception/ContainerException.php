<?php

namespace TotalSurveyVendors\League\Container\Exception;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\Psr\Container\ContainerExceptionInterface;
use RuntimeException;

class ContainerException extends RuntimeException implements ContainerExceptionInterface
{
}
