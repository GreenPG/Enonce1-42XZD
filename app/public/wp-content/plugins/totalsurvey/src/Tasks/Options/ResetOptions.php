<?php


namespace TotalSurvey\Tasks\Options;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;

//@TODO: Extract this task to the foundation framework

/**
 * Class ResetOptions
 *
 * @package TotalSurvey\Tasks\Options
 */
class ResetOptions extends Task
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
     * @throws Exception
     */
    protected function execute()
    {
        $options = (array)(new DefaultOptions())->run();

        if (!$this->options->put($options)) {
            throw new Exception('Could not save options');
        }

        return $options;
    }
}
