<?php

namespace TotalSurvey\Tasks\Utils;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class RegisterDefaultAssets
 *
 * @package TotalSurvey\Tasks
 * @method static array invoke()
 * @method static array invokeWithFallback(array $fallback)
 */
class RegisterDefaultAssets extends Task
{
    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function execute()
    {
        $baseUrl          = Plugin::env('url.base');
        $polyfillsEnabled = Plugin::options('advanced.polyfills.enabled');
        $min              = Plugin::env()->isDebug() ? '' : '.min';
        $version          = Plugin::env('version');

        wp_register_script(
            'polyfill-io',
            'https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=default%2Csmoothscroll%2CscrollIntoView%2Cfetch',
            [],
            $version,
            false
        );

        wp_register_script(
            'chart-js',
            'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.1/chart.umd.min.js',
            [],
            $version,
            false
        );


        // Enqueue vendors
        wp_register_script(
            'totalsurvey-vue-js',
            "{$baseUrl}/assets/js/vue{$min}.js",
            $polyfillsEnabled ? ['jquery', 'polyfill-io'] : ['jquery'],
            $version
        );

        wp_register_style('totalsurvey-loading', $baseUrl."/assets/frontend/loading.css", [], $version);
    }
}
