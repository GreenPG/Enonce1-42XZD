<?php


namespace TotalSurvey\Tasks\Utils;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class ApplyPrivacyOptions
 *
 * @package TotalSurvey\Tasks
 * @method static string invoke()
 * @method static string invokeWithFallback()
 */
class GetIP extends Task
{
    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
        $request  = Plugin::request();
        $honorDNT = Plugin::options('privacy.honorDNT', false) && $request->hasHeader('dnt');

        if ($honorDNT || Plugin::options('privacy.hashIP', false)) {
            return sha1($request->ip());
        }

        return $request->ip();
    }
}
