<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\League\Container\Container;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Module;

/**
 * Class Extension
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\WordPress\Module
 */
abstract class Extension extends Module
{
    /**
     * Extension constructor.
     *
     * @param Definition $definition
     * @param Container  $container
     */
    public function __construct(Definition $definition, Container $container)
    {
        parent::__construct($definition, $container);
        $this->run();
    }

    /**
     * @return mixed
     */
    abstract public function run();
}