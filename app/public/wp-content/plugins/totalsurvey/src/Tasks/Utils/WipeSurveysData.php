<?php

namespace TotalSurvey\Tasks\Utils;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Connection;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

class WipeSurveysData extends Task
{
    protected function validate()
    {
        return true;
    }

    protected function execute()
    {

        $db = Plugin::instance()->container(Connection::class);

        // Delete plugin options
        delete_option(Plugin::env('stores.optionsKey'));
        delete_option(Plugin::env('stores.modulesKey'));
        delete_option(Plugin::env('stores.versionKey'));
        delete_option(Plugin::env('stores.trackingKey'));

        try {
            $db->raw(sprintf('DROP TABLE %stotalsurvey_surveys', $db->getTablePrefix()));
            $db->raw(sprintf('DROP TABLE %stotalsurvey_entries', $db->getTablePrefix()));
            $db->raw(sprintf('DROP TABLE %stotalsurvey_presets', $db->getTablePrefix()));
        } catch (DatabaseException $e) {
        }
    }
}
