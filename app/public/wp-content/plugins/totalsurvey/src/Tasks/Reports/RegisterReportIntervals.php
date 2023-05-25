<?php

namespace TotalSurvey\Tasks\Reports;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurvey\Tasks\Entries\ConvertEntryToHTMLTable;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Strings;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\View\Engine;


class RegisterReportIntervals extends Task
{
    public function __construct()
    {
        add_filter('cron_schedules', [$this, 'addIntervalMonth']);
    }

    public function addIntervalMonth($schedules)
    {
        $schedules['monthly'] = [
            'interval' => 2635200,
            'display'  => __('Monthly'),
        ];

        $schedules['bi-weekly'] = [
            'interval' => 1317600,
            'display'  => __('Bi-Weekly'),
        ];

        return $schedules;
    }

    protected function execute()
    {
        define('TOTALSURVEY_REPORT_INTERVALS', [
            '0'  => [
                'label'      => 'Daily',
                'recurrence' => 'daily',
                'start'      => 'previous day midnight',
                'end'        => 'previous day 23:59:59',
                'timestamp'  => 'tomorrow 9am',
            ],
            '7'  => [
                'label'      => 'Weekly',
                'recurrence' => 'weekly',
                'start'      => 'previous week midnight',
                'end'        => 'previous week 23:59:59 +6 days',
                'timestamp'  => 'next week 9am',
            ],
            '15' => [
                'label'      => 'Bi-Weekly',
                'recurrence' => 'bi-weekly',
                'start'      => 'previous week midnight',
                'end'        => 'previous week 23:59:59 +6 days',
                'timestamp'  => '15 days 9am',
            ],
            '30' => [
                'label'      => 'Monthly',
                'recurrence' => 'monthly',
                'start'      => 'first day of last month midnight',
                'end'        => 'last day of last month 23:59:59',
                'timestamp'  => 'first day of next month 9am',
            ],
        ]);
    }

    /**
     * @return bool|mixed|void
     */
    protected function validate()
    {
        return true;
    }
}
