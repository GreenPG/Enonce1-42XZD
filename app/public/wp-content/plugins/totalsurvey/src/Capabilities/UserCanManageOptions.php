<?php


namespace TotalSurvey\Capabilities;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Capability;

/**
 * Class ManageOption
 *
 * @package TotalSurvey\Capabilities
 */
class UserCanManageOptions extends Capability
{
    const NAME = 'totalsurvey_manage_options';
}