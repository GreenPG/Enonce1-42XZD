<?php

namespace TotalSurvey\Tasks\Presets;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Preset;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetPresets
 *
 * @package TotalSurvey\Tasks
 * @method static Collection invoke()
 * @method static array invokeWithFallback(array $fallback)
 */
class GetDefaultPresets extends Task
{
    protected $filters = [];

    /**
     * GetPresets constructor.
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
     * @return Collection
     * @throws DatabaseException
     */
    protected function execute()
    {
        return Preset::query()->where('source', 'default')->get();
    }
}
