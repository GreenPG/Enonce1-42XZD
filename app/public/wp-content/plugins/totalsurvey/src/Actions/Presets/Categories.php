<?php


namespace TotalSurvey\Actions\Presets;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Capabilities\UserCanCreateSurvey;
use TotalSurvey\Tasks\Presets\GetCategories;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;

class Categories extends Action
{
    /**
     * @return Response
     * @throws Exception
     */
    protected function execute()
    {
        return ResponseFactory::json(GetCategories::invoke());
    }

    public function authorize(): bool
    {
        return UserCanCreateSurvey::check();
    }
}