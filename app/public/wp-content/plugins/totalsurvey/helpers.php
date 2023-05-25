<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Plugin;

if (!function_exists('TotalSurvey')) {
    /**
     * @return Plugin
     */
    function TotalSurvey()
    {
        return TotalSurvey\Plugin::instance();
    }
}