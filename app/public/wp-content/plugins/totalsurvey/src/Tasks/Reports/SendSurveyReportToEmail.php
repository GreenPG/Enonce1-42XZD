<?php

namespace TotalSurvey\Tasks\Reports;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurvey\Models\SurveyReport;
use TotalSurvey\Plugin;
use TotalSurvey\Tasks\Entries\ConvertEntryToHTMLTable;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Strings;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\View\Engine;


class SendSurveyReportToEmail extends Task
{
    /**
     * @var SurveyReport
     */
    protected $report;

    public function __construct(SurveyReport $report)
    {
        $this->report = $report;
    }

    protected function execute()
    {
        // Prepare the email arguments
        $subject = Strings::template(
            "📊 Your {{intervalLabel}} report of {{survey.name}}",
            [
                'intervalLabel' => $this->report->intervalLabel,
                'survey'        => $this->report->survey,
            ]
        );

        $view = Engine::instance()->render(
            'report-email',
            [
                'content'   => $this->report->html(),
                'reportUrl' => $this->report->url,
            ]
        );

        // Send the email
        $emailSent = wp_mail($this->report->email, $subject, $view, ['Content-Type: text/html; charset=UTF-8']);

        // Fallback if something goes wrong
        Exception::throwIf(!$emailSent, 'Error! Email has not been sent.');

        return $emailSent;
    }

    /**
     * @return bool|mixed|void
     */
    protected function validate()
    {
        return true;
    }
}
