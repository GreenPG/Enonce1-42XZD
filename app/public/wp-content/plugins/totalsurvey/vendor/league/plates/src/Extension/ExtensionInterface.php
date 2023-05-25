<?php

namespace TotalSurveyVendors\League\Plates\Extension;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\League\Plates\Engine;

/**
 * A common interface for extensions.
 */
interface ExtensionInterface
{
    public function register(Engine $engine);
}
