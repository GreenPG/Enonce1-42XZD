<?php

namespace TotalSurvey\Tasks\Reports;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Entry;
use TotalSurvey\Models\SurveyReport;
use TotalSurvey\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\View\Engine;

class StoreSurveyReportFile extends Task
{
    /**
     * @var SurveyReport
     */
    protected $report;

    /**
     * @param  SurveyReport  $report
     */
    public function __construct(SurveyReport $report)
    {
        $this->report = $report;
    }

    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
        // get the view of the report and rendering it
        $content = Engine::instance()->render('report-html-file', ['content' => $this->report->html()]);

        // write the file
        return file_put_contents($this->report->path, $content) !== false;
    }
}
