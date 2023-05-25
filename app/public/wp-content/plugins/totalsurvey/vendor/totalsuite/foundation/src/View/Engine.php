<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\View;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Concerns\ResolveFromContainer;

/**
 * Class Engine
 *
 * @package TotalSuite\Foundation
 */
class Engine extends \TotalSurveyVendors\League\Plates\Engine
{
    use ResolveFromContainer;
}
