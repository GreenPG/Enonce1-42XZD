<?php


namespace TotalSurvey\Tasks\Options;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;

//@TODO: Extract this task to the foundation framework

/**
 * Class UpdateOptions
 *
 * @package TotalSurvey\Tasks\Options
 */
class UpdateOptions extends Task
{

    /**
     * @var Options
     */
    protected $options;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Reset constructor.
     *
     * @param Options $options
     * @param array   $data
     */
    public function __construct(Options $options, array $data)
    {
        $this->options = $options;
        $this->data    = $data;
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
        if (!$this->options->put($this->data)) {
            throw new Exception('Could not save options');
        }

        return $this->options->toArray();
    }
}
