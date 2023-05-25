<?php

namespace TotalSurvey\Capabilities;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Capability;

/**
 * Class CreateSurvey
 *
 * @package TotalSurvey\Capabilities
 */
class UserCanCreateSurvey extends Capability
{
    const NAME = 'totalsurvey_create_survey';
}