<?php

namespace TotalSurvey\Tasks\Reports;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Exceptions\Surveys\SurveyNotFound;
use TotalSurvey\Models\Survey;
use TotalSurvey\Models\SurveyReport;
use TotalSurvey\Tasks\Entries\ConvertEntryToHTMLTable;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Strings;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\View\Engine;


class HandleSurveyReportCronJob extends Task
{
    protected function execute()
    {
        add_action(SetupCronReport::CRON_HOOK_NAME, [$this, 'handleCronReport']);
    }

    public function handleCronReport($uid)
    {
        try {
            $survey = Survey::byUidAndActive($uid);
            $report = new SurveyReport($survey);

            $report->store();
            $report->send();
        } catch (SurveyNotFound $exception) {
            wp_clear_scheduled_hook(SetupCronReport::CRON_HOOK_NAME, [$uid]);
        } catch (Exception $e) {
            echo esc_html($e->getMessage());
        }
    }

    /**
     * @return bool|mixed|void
     */
    protected function validate()
    {
        return true;
    }
}
