<?php
namespace TotalSurvey\Actions\Presets;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Capabilities\UserCanCreateSurvey;
use TotalSurvey\Tasks\Presets\GetPresets;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;

class Index extends Action
{
    /**
     * @return Response
     * @throws Exception
     */
    protected function execute()
    {
        $filters = $this->request->getQueryParams();

        return ResponseFactory::json(GetPresets::invoke($filters));

    }

    public function authorize(): bool
    {
        return UserCanCreateSurvey::check();
    }
}