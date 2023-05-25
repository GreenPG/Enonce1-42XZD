<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\CronJobs;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Scheduler;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Scheduler\CronJob;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Activation\CheckLicense as CheckLicenseTask;

/**
 * Class CheckLicense
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\CronJobs
 */
class CheckLicense extends CronJob
{
    public function execute()
    {
        try {
            CheckLicenseTask::invoke();
        } catch (Exception $e) {
            return;
        }
    }

    public function getRecurrence()
    {
        return Scheduler::SCHEDULE_DAILY;
    }
}