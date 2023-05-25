<?php

namespace TotalSurvey\Tasks\Entries;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Entry;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

class ExportJSON extends Task
{
    /**
     * @var array
     */
    protected $entries;

    /**
     * ExportJson constructor.
     *
     * @param Collection|Entry $entries
     */
    public function __construct(Collection $entries)
    {
        $this->entries = $entries;
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
        $exportable = [];

        /**
         * @var Entry $entry
         */
        foreach ($this->entries as $entry) {
            $exportable[] = $entry->toExport('json');
        }

        return ResponseFactory::file($exportable, 'entries-export-' . date('Y-d-m') . '.json', 'text/json');
    }
}
