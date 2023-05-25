<?php


namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Promotion;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Definition;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

class GetModules extends Task
{
    /**
     * @return false|mixed|void
     */
    protected function validate()
    {
        return false;
    }

    /**
     * @return array|mixed
     */
    protected function execute()
    {
        $definitions = Manager::instance()
                              ->getDefinitions();
        $modules = [];

        /**
         * @var Definition $definition
         */
        foreach ($definitions as $definition) {
            $modules[$definition->get('id')] = [
                'id'          => $definition->get('id'),
                'name'        => $definition->get('name'),
                'description' => $definition->get('description'),
                'activated'   => $definition->get('activated', false),
                'refreshOnActivation' => $definition->get('refreshOnActivation', false)
            ];
        }

        return $modules;
    }
}