<?php

namespace TotalSurvey\Actions\Dashboard;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Tasks\Dashboard\BlogFeed;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;

//@TODO: Extract this action to the foundation framework

/**
 * Class Blog
 *
 * @package TotalSurvey\Actions\Dashboard
 */
class Blog extends Action
{
    /**
     * @return Response
     */
    public function execute(): Response
    {
        $posts = (new BlogFeed())->run();

        return ResponseFactory::json($posts);
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return current_user_can('totalsurvey_view_data');
    }
}
