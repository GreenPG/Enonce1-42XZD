<?php

namespace TotalSurvey\Capabilities;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Capability;

/**
 * Class ViewEntries
 *
 * @package TotalSurvey\Capabilities
 */
class UserCanViewEntries extends Capability
{
    const NAME = 'totalsurvey_view_entries';
}