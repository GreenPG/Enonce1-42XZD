<?php

namespace TotalSurvey\Tasks\Utils;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Capabilities\UserCanCreateSurvey;
use TotalSurvey\Capabilities\UserCanDeleteEntries;
use TotalSurvey\Capabilities\UserCanDeleteSurvey;
use TotalSurvey\Capabilities\UserCanExportData;
use TotalSurvey\Capabilities\UserCanExportEntries;
use TotalSurvey\Capabilities\UserCanManageModules;
use TotalSurvey\Capabilities\UserCanManageOptions;
use TotalSurvey\Capabilities\UserCanUpdateSurvey;
use TotalSurvey\Capabilities\UserCanViewData;
use TotalSurvey\Capabilities\UserCanViewEntries;
use TotalSurvey\Capabilities\UserCanViewSurveys;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Roles;

/**
 * Class AttachRoles
 *
 * @package TotalSurvey\Tasks
 * @method static array invoke()
 * @method static array invokeWithFallback(array $fallback)
 */
class AttachDefaultCapabilitiesToDefaultRoles extends Task
{
    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function execute()
    {
        Roles::set(
            Roles::ADMINISTRATOR,
            [
                UserCanManageOptions::NAME,
                UserCanManageModules::NAME,
                UserCanCreateSurvey::NAME,
                UserCanUpdateSurvey::NAME,
                UserCanDeleteSurvey::NAME,
                UserCanViewSurveys::NAME,
                UserCanViewEntries::NAME,
                UserCanDeleteEntries::NAME,
                UserCanExportEntries::NAME,
                UserCanViewData::NAME,
                UserCanExportData::NAME,
            ]
        );
    }
}
