<?php

namespace TotalSurvey\Tasks\Utils;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

class HonorRequestLocale extends Task
{
    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
        add_filter('locale', function ($locale) {
            if (Plugin::env()->isRest()) {
                $userLocale = Plugin::request('language', '');

                if (preg_match('/^(\w{2}|\w{2}_\w{2})$/i', $userLocale)) {
                    $locale = $userLocale;
                }
            }

            return $locale;
        });
    }
}
