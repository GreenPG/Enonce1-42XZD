<?php


namespace TotalSurvey\Tasks\Options;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;

//@TODO: Extract this task to the foundation framework

/**
 * Class GetOptions
 *
 * @package TotalSurvey\Tasks\Options
 */
class GetOptions extends Task
{

    /**
     * @var Options
     */
    protected $options;

    /**
     * Reset constructor.
     *
     * @param Options $options
     */
    public function __construct(Options $options)
    {
        $this->options = $options;
    }


    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function execute()
    {
        $defaults = (new DefaultOptions())->run();

        return array_replace_recursive($defaults, $this->options->toArray());
    }
}
