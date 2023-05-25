<?php

namespace TotalSurvey\Capabilities;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Capability;

/**
 * Class ViewData
 *
 * @package TotalSurvey\Capabilities
 */
class UserCanViewData extends Capability
{
    const NAME = 'totalsurvey_view_data';
}