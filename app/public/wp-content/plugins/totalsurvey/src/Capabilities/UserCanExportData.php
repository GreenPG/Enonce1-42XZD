<?php

namespace TotalSurvey\Capabilities;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Capability;

/**
 * Class ExportData
 *
 * @package TotalSurvey\Capabilities
 */
class UserCanExportData extends Capability
{
    const NAME = 'totalsurvey_export_data';
}