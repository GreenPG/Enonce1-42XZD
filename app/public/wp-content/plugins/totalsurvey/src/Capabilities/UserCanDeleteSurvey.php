<?php

namespace TotalSurvey\Capabilities;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Capability;

/**
 * Class DeleteSurvey
 *
 * @package TotalSurvey\Capabilities
 */
class UserCanDeleteSurvey extends Capability
{
    const NAME = 'totalsurvey_delete_survey';
}