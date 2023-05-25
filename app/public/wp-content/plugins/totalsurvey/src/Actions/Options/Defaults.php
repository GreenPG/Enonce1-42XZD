<?php

namespace TotalSurvey\Actions\Options;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Tasks\Options\DefaultOptions;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;

//@TODO: Extract this action to the foundation framework

/**
 * Class Defaults
 *
 * @package TotalSurvey\Actions\Options
 */
class Defaults extends Action
{

    public function execute(): Response
    {
        $task    = new DefaultOptions();
        $options = $task->run();

        return ResponseFactory::json($options);
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return current_user_can('totalsurvey_manage_options');
    }
}
