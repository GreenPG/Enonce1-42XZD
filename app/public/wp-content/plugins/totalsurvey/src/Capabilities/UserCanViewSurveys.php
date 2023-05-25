<?php

namespace TotalSurvey\Capabilities;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Capability;

/**
 * Class ViewSurveys
 *
 * @package TotalSurvey\Capabilities
 */
class UserCanViewSurveys extends Capability
{
    const NAME = 'totalsurvey_view_surveys';
}