<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Dashboard;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\GetBlogFeed;

class Blog extends Action
{
    /**
     * @return Response
     * @throws Exception
     */
    public function execute(): Response
    {
        return GetBlogFeed::invoke()->toJsonResponse();
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return true;
    }
}