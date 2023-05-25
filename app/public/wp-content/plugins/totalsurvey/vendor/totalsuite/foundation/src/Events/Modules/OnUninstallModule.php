<?php


namespace TotalSurveyVendors\TotalSuite\Foundation\Events\Modules;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Event;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Definition;

class OnUninstallModule extends Event {
    /**
     * @var Definition
     */
    public $definition;

    /**
     * OnActivateModule constructor.
     *
     * @param  Definition  $definition
     */
    public function __construct(Definition $definition)
    {
        $this->definition = $definition;
    }

}