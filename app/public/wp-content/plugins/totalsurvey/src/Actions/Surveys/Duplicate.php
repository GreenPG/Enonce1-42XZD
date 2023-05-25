<?php

namespace TotalSurvey\Actions\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Capabilities\UserCanCreateSurvey;
use TotalSurvey\Tasks\Surveys\DuplicateSurvey;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;

/**
 * Class Get
 *
 * @package TotalSurvey\Actions\Surveys
 */
class Duplicate extends Action
{

    /**
     * @param  string  $surveyUid
     *
     * @return Response
     * @throws Exception
     */
    public function execute($surveyUid): Response
    {
        return DuplicateSurvey::invoke($surveyUid)->toJsonResponse();
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return UserCanCreateSurvey::check();
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
