<?php

namespace TotalSurvey\Capabilities;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Capability;

/**
 * Class ExportEntries
 *
 * @package TotalSurvey\Capabilities
 */
class UserCanExportEntries extends Capability
{
    const NAME = 'totalsurvey_export_entries';
}