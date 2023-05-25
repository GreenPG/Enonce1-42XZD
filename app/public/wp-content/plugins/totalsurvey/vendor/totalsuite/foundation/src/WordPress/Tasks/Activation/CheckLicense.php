<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Activation;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Environment;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\ActivationException;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\License;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Plugin;

/**
 * Class CheckLicense
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\License
 */
class CheckLicense extends Task
{
    protected function validate()
    {
        return true;
    }

    /**
     * @return License
     * @throws Exception
     */
    protected function execute()
    {
        $license = License::instance();
        $url = Plugin::env('url.activation.license', 'https://totalsuite.net/api/v3/license');
        $host = Environment::instance()->hostName();
        $url = add_query_arg(['license' => $license->getKey(), 'domain' => $host], $url);

        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            ActivationException::throw(__('Something went wrong. Please try again.', Plugin::env('textdomain')));
        }

        $apiResponse = json_decode(wp_remote_retrieve_body($response), true);

        if (empty($apiResponse['success'])) {
            $reason = $apiResponse['reason'] ?? License::INACTIVE;

            License::persist($apiResponse['data'] ?? [], $reason);
            ActivationException::throw(__('License is inactive.', Plugin::env('textdomain')));
        }

        return License::persist($apiResponse['data'] ?? []);
    }
}