<?php


namespace TotalSurvey\Actions\Options;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Tasks\Options\UpdateOptions;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;

//@TODO: Extract this action to the foundation framework

/**
 * Class Update
 *
 * @package TotalSurvey\Actions\Options
 */
class Update extends Action
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
        $data    = $this->request->getParsedBody();
        $options = (new UpdateOptions($this->options, $data))->run();

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
