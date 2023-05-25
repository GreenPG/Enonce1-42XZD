<?php

namespace TotalSurvey\Tasks\Reports;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Survey;
use TotalSurvey\Models\SurveyReport;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurvey\Extensions\Insights\Tasks\GenerateInsightsForSurvey;

/**
 * Class
 *
 */
class GenerateHTMLReport extends Task
{
    protected $report;

    /**
     * @param  SurveyReport  $report
     */
    public function __construct(SurveyReport $report)
    {
        $this->report = $report;
    }

    protected function execute()
    {
        // Get the survey's insights
        $interval  = $this->report->interval;
        $endDate   = date('Y-m-d H:i:s', $this->report->intervalEnd);
        $startDate = date('Y-m-d H:i:s', $this->report->intervalStart);

        try {
            $insights = GenerateInsightsForSurvey::invoke(
                $this->report->survey,
                $startDate,
                $endDate
            );

            // Filter the sections to include only the ones that the user selected
            $insights['sections'] = array_filter($insights['sections'], function ($section) {
                return in_array($section['uid'], $this->report->sections);
            });

            // In case we don't have any data
            Exception::throwIf(
                empty($insights['sections']),
                __("No data found between $startDate and $endDate.", 'totalsurvey')
            );

            // Generate the HTML report
            $report = ConvertInsightsToHTMLTable::invoke($insights);
        } catch (\Exception $exception) {
            $report = $exception->getMessage();
        }

        // Will be used to send the email report
        return $report;
    }

    /**
     * @return bool|mixed|void
     */
    protected function validate()
    {
        return true;
    }
}
