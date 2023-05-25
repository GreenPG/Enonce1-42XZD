<?php
namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress;
! defined( 'ABSPATH' ) && exit();


use WP_Upgrader_Skin;

/**
 * Class ApiSkin
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\WordPress\Upgrader
 */
class SilentUpgraderSkin extends WP_Upgrader_Skin
{
    public function header() {}
    public function footer(){}
    public function feedback($string, ...$args){}
    protected function decrement_update_count($type){}
}