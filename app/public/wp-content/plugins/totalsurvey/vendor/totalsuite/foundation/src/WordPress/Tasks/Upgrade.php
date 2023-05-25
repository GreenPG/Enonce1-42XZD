<?php
namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks;
! defined( 'ABSPATH' ) && exit();


use Plugin_Upgrader;
use TotalSurveyVendors\TotalSuite\Foundation\License;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\SilentUpgraderSkin;
use WP_Error;

include_once(ABSPATH . 'wp-admin/includes/plugin.php');
include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

class Upgrade extends Task
{
    /**
     * @var License
     */
    protected $license;

    /**
     * Upgrade constructor.
     *
     * @param  License  $license
     */
    public function __construct(License $license)
    {
        $this->license = $license;
    }

    /**
     * @return bool
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @return array|bool|mixed|WP_Error
     */
    protected function execute()
    {
        if(! $this->license->isRegistered()) {
            return false;
        }

        $wp_upgrader = new Plugin_Upgrader(new SilentUpgraderSkin());
        $products = $this->license->get('downloads', []);

        foreach($products as $product) {
            $wp_upgrader->install($product, ['overwrite_package' => true]);
        }

        return true;
    }
}