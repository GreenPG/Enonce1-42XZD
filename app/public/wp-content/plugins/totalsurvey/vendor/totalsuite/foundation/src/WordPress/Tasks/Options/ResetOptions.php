<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Options;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;

/**
 * Class ResetOptions
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Options
 * @method static Collection invoke(Options $options)
 * @method static Collection invokeWithFallback($fallback, Options $options)
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
        Exception::throwUnless(
            $this->options->fill($this->options->getDefaults()->toArray())->save(),
            'Could not save options'
        );

        return $this->options->getBase();
    }
}
