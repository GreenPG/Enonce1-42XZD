<?php

namespace TotalSurvey\Actions\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Capabilities\UserCanDeleteSurvey;
use TotalSurvey\Tasks\Surveys\RestoreSurvey;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;

/**
 * Class Restore
 *
 * @package TotalSurvey\Actions\Surveys
 */
class Restore extends Action
{
    /**
     * @param $surveyUid
     *
     * @return Response
     * @throws Exception
     */
    public function execute($surveyUid): Response
    {
        return RestoreSurvey::invoke($surveyUid)
                            ->toJsonResponse();
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return UserCanDeleteSurvey::check();
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'surveyUid' => [
                'expression'        => '(?<surveyUid>([\w-]+))',
                'sanitize_callback' => static function ($surveyUid) {
                    return (string) $surveyUid;
                },
            ],
        ];
    }
}
