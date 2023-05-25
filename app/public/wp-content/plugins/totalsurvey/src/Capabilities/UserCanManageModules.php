<?php

namespace TotalSurvey\Capabilities;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Capability;

/**
 * Class ManageModules
 *
 * @package TotalSurvey\Capabilities
 */
class UserCanManageModules extends Capability
{
    const NAME = 'totalsurvey_manage_modules';
}