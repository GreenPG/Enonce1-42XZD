<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\CronJobs;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Contracts\TrackingStorage;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Scheduler;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Scheduler\CronJob;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Tracking\SendTrackingRequest;

class TrackEvents extends CronJob
{
    /**
     * @throws Exception|Exception
     */
    public function execute()
    {
        $url = Plugin::env('url.tracking.events');
        $options = Plugin::get(TrackingStorage::class);

        SendTrackingRequest::invoke($url, $options->all());
    }

    public function getRecurrence()
    {
        return Scheduler::SCHEDULE_DAILY;
    }

    public function getStartTime()
    {
        return time();
    }
}