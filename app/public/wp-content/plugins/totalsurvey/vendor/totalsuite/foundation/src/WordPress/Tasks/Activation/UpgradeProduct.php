<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Activation;
! defined( 'ABSPATH' ) && exit();


use Plugin_Upgrader;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\ActivationException;
use TotalSurveyVendors\TotalSuite\Foundation\License;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Upgrader\SilentUpgraderSkin;

include_once(ABSPATH . 'wp-admin/includes/plugin.php');
include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

/**
 * Class UpgradeProduct
 * @package TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Activation
 * @method static invoke($productId)
 * @method static invokeWithFallback($fallback, $productId)
 */
class UpgradeProduct extends Task
{
    /**
     * @var string
     */
    protected $productId;

    /**
     * Upgrade constructor.
     *
     * @param $productId
     */
    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return bool
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @return bool
     * @throws \TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception
     */
    protected function execute()
    {
        $license = License::instance();

        if (!$license->isRegistered()) {
            ActivationException::throw(__('You need to activate your product first.'));
        }

        $wpUpgrade = new Plugin_Upgrader(new SilentUpgraderSkin());
        $availableProducts = $license->get('downloads', []);

        if (!array_key_exists($this->productId, $availableProducts)) {
            ActivationException::throw(__('The product you are trying to upgrade is not covered by your license.'));
        }

        $result = $wpUpgrade->install($availableProducts[$this->productId], ['overwrite_package' => true]);

        if (!$result || is_wp_error($result)) {
            ActivationException::throw(__('Something went wrong during the installation.'));
        }

        return true;
    }
}