<?php

namespace TotalSurvey\Actions\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Capabilities\UserCanViewSurveys;
use TotalSurvey\Models\Survey;
use TotalSurvey\Tasks\Surveys\GetSurveys;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;

/**
 * Class Index
 *
 * @package TotalSurvey\Actions\Surveys
 */
class Index extends Action
{
    /**
     * @return Response
     * @throws Exception
     */
    public function execute(): Response
    {
        return GetSurveys::invoke($this->request->getQueryParams())
                         ->map([$this, 'filter'])
                         ->toJsonResponse();
    }

    /**
     * @param  Survey  $survey
     *
     * @return Survey
     */
    public function filter(Survey $survey)
    {
        return $survey->withStatistics();
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return UserCanViewSurveys::check();
    }
}
