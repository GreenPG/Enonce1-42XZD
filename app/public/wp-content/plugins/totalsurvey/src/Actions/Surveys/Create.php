<?php

namespace TotalSurvey\Actions\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Capabilities\UserCanCreateSurvey;
use TotalSurvey\Tasks\Surveys\CreateSurvey;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;

/**
 * Class Create
 *
 * @package TotalSurvey\Actions\Surveys
 */
class Create extends Action
{
    /**
     * @return Response
     * @throws Exception
     */
    public function execute(): Response
    {
        $data = (array) $this->request->getParsedBody();

        return CreateSurvey::invoke($data)->toJsonResponse();
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return UserCanCreateSurvey::check();
    }
}
