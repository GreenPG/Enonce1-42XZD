<?php

namespace TotalSurvey\Tasks\Reports;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurvey\Tasks\Entries\ConvertEntryToHTMLTable;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Strings;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\View\Engine;


class SetupCronReport extends Task
{
    /**
     * The hook name used with WordPress cron job API
     */
    const CRON_HOOK_NAME = 'totalsurvey_send_reports';

    /**
     * @var Survey
     */
    protected $survey;

    /**
     * @param  Survey  $survey
     */
    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }

    protected function execute()
    {
        if (!$this->survey->shouldSendReport()) {
            return;
        }

        // Clear any previously scheduled cron jobs
        wp_clear_scheduled_hook(self::CRON_HOOK_NAME, [$this->survey->uid]);

        return wp_schedule_event(
            $this->survey->getReportIntervalTimestamp(),
            $this->survey->getReportIntervalRecurrence(),
            self::CRON_HOOK_NAME,
            [$this->survey->uid]
        );
    }

    /**
     * @return bool|mixed|void
     */
    protected function validate()
    {
        return true;
    }
}
