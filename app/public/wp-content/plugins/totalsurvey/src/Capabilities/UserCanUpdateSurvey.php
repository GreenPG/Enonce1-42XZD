<?php

namespace TotalSurvey\Capabilities;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Capability;

/**
 * Class UpdateSurvey
 *
 * @package TotalSurvey\Capabilities
 */
class UserCanUpdateSurvey extends Capability
{
    const NAME = 'totalsurvey_update_survey';
}