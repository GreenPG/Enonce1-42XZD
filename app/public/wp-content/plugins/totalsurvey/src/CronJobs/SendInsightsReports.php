<?php

namespace TotalSurvey\CronJobs;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Scheduler;

class SendInsightsReports
{
    protected $survey;
    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }

    public function execute()
    {

    }

    public function getRecurrence()
    {

    }


}
