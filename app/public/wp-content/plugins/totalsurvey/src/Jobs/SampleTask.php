<?php


namespace TotalSurvey\Jobs;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class SampleTask
 *
 * @package TotalSurvey\Tasks
 *
 * @method static boolean invoke($input, $operator, $value)
 * @method static boolean invokeWithFallback($fallback, mixed $input, $operator, $value)
 */
class SampleTask extends Task
{
    /**
     * SampleTask constructor.
     *
     * @param  mixed  $input
     * @param  mixed  $operator
     * @param  mixed  $value
     */
    public function __construct($input, $operator, $value)
    {
    }

    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
    }
}
