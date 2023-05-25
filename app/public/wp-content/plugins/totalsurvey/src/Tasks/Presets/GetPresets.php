<?php

namespace TotalSurvey\Tasks\Presets;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Preset;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetPresets
 *
 * @package TotalSurvey\Tasks
 * @method static Collection invoke(array $filters = [])
 * @method static array invokeWithFallback(array $fallback, array $filters = [])
 */
class GetPresets extends Task
{
    protected $filters = [];

    /**
     * GetPresets constructor.
     *
     * @param array $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = Arrays::merge(
            [
                'keyword'  => null,
                'category' => null,
                'source'   => null
            ],
            $filters
        );
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
        $presets = Preset::query();

        if ($this->filters['keyword']) {
            $presets->where('name', 'like', '%' . $this->filters['keyword'] . '%');
        }

        if ($this->filters['category']) {
            $presets->where('category', $this->filters['category']);
        }

        if ($this->filters['source']) {
            $presets->where('source', $this->filters['source']);
        }

        return $presets->paginate(36, 1);
    }
}
