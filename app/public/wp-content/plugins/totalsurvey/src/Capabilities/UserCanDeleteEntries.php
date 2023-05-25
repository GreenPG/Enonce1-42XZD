<?php

namespace TotalSurvey\Capabilities;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Capability;

/**
 * Class DeleteEntries
 *
 * @package TotalSurvey\Capabilities
 */
class UserCanDeleteEntries extends Capability
{
    const NAME = 'totalsurvey_delete_entries';
}