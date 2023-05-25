<?php

namespace TotalSurvey\Tasks\Entries;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Filters\Entries\EntriesQueryFilter;
use TotalSurvey\Models\Entry;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetEntries
 *
 * @package TotalSurvey\Tasks\Entries
 * @method static Collection invoke(array $filters, bool $paginate = true)
 * @method static Collection invokeWithFallback($fallback, array $filters, bool $paginate = true)
 */
class GetEntries extends Task
{
    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var bool
     */
    protected $paginate = false;

    /**
     * StoreRating constructor.
     *
     * @param  array  $filters
     * @param       $paginate
     */
    public function __construct($filters = [], $paginate = true)
    {
        $this->paginate = $paginate;

        $this->filters = Arrays::merge([
            'survey_uid' => null,
            'from_date'  => null,
            'to_date'    => null,
            'per_page'   => 25
        ], (array)$filters);
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
     * @throws DatabaseException
     */
    protected function execute()
    {
        /**
         * @var Query|Query\Select
         */
        $query = Entry::query()
                      ->select()
                      ->orderBy('created_at', 'desc');

        if ($this->filters['survey_uid']) {
            $query->where('survey_uid', $this->filters['survey_uid']);
        }

        if ($this->filters['from_date']) {
            $query->where(Query::raw('DATE(created_at)'), '>=', $this->filters['from_date']);
        }

        if ($this->filters['to_date']) {
            $query->where(Query::raw('DATE(created_at)'), '<=', $this->filters['to_date']);
        }

        EntriesQueryFilter::apply($query, $this->filters, $this->paginate);

        if ($this->paginate) {
            $this->filters['per_page'] = ($this->filters['per_page'] < 1) ? 10 : $this->filters['per_page'];

            return $query->paginate($this->filters['per_page'], $this->filters['page'] ?? 1);
        }

        return $query->get();
    }
}
