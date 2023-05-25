<?php

namespace TotalSurvey\Tasks;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetLanguages
 *
 * @package TotalSurvey\Tasks
 * @method static array invoke()
 * @method static array invokeWithFallback(array $fallback)
 */
class GetLanguages extends Task
{
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
        return [];
    }
}
