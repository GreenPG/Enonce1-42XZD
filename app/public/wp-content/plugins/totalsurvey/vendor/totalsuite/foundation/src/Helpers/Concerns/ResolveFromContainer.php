<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Helpers\Concerns;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Plugin;

/**
 * Trait ResolvableFromContainer
 *
 * @package TotalSuite\Foundation
 */
trait ResolveFromContainer
{
    /**
     * @return static
     */
    public static function instance()
    {
        return Plugin::get(static::class);
    }
}