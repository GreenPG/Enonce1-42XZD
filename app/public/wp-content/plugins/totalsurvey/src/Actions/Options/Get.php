<?php

namespace TotalSurvey\Actions\Options;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Tasks\Options\GetOptions;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;

//@TODO: Extract this action to the foundation framework

/**
 * Class Get
 *
 * @package TotalSurvey\Actions\Options
 */
class Get extends Action
{

    /**
     * @var Options
     */
    protected $options;

    /**
     * ResetOptions constructor.
     *
     * @param Options $options
     */
    public function __construct(Options $options)
    {
        $this->options = $options;
    }

    /**
     * @return Response
     */
    public function execute(): Response
    {
        $options = (new GetOptions($this->options))->run();

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
