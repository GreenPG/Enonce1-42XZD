<?php

namespace TotalSurvey\Actions\Reports;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurvey\Models\SurveyReport;
use TotalSurvey\Tasks\Reports\SendSurveyReportToEmail;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;

class SendNowReport extends \TotalSurveyVendors\TotalSuite\Foundation\Action
{

    /**
     * @return Response
     * @throws Exception
     */
    protected function execute(): Response
    {
        $uid    = $this->request->getParam('surveyUid');
        $survey = Survey::byUidAndActive($uid);
        $report = new SurveyReport($survey, [
            'email'         => $this->request->getParam('email'),
            'intervalStart' => strtotime($this->request->getParam('from') ?: 'last year midnight'),
            'intervalEnd'   => strtotime($this->request->getParam('to') ?: 'today 23:59:59'),
            'intervalLabel' => '',
            'label'         => '',
            'interval'      => '',
            'sections'      => (array) $this->request->getParam('sections') ?: [],
        ]);

        $report->store();
        $report->send();

        return $report->toJsonResponse();
    }

    public function authorize(): bool
    {
        return true;
    }
}
