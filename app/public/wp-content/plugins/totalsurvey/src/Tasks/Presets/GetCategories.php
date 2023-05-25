<?php

namespace TotalSurvey\Tasks\Presets;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Preset;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetCategories
 *
 * @package TotalSurvey\Tasks
 * @method static Collection invoke()
 * @method static array invokeWithFallback(array $fallback)
 */
class GetCategories extends Task
{
    protected $filters = [];

    /**
     * GetPresets constructor.
     *
     */
    public function __construct()
    {
    }


    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    protected function execute()
    {
        return Preset::getCategories();
    }
}
