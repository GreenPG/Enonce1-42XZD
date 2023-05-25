<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query\Select;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetSurveys
 *
 * @package TotalSurvey\Tasks\Survey
 * @method static Collection invoke($filters = [], $paginate = true)
 * @method static Collection invokeWithFallback($fallback, $filters = [], $paginate = true)
 */
class GetSurveys extends Task
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
     * GetSurveys constructor.
     *
     * @param array $filters
     * @param bool $paginate
     */
    public function __construct($filters = [], $paginate = true)
    {
        $this->paginate = $paginate;

        $this->filters = Arrays::merge(
            [
                'status'    => null,
                'from_date' => null,
                'to_date'   => null,
                'page'      => 1,
                'per_page'  => 8,
            ],
            (array)$filters
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
     * @inheritDoc
     * @throws DatabaseException
     */
    protected function execute()
    {
        /**
         * @var Query|Select $query
         */
        $query = Survey::query()->select();
        $query->orderBy('id', 'desc');

        if ($this->filters['from_date']) {
            $query->whereDate('created_at', '>=', $this->filters['from_date']);
        }

        if ($this->filters['to_date']) {
            $query->whereDate('created_at', '<=', $this->filters['to_date']);
        }

        if ($this->filters['status']) {
            $filters = array_filter((array)$this->filters['status']);
            $query->whereIn('status', $filters);
        }

        if ($this->paginate) {
            $this->filters['per_page'] = ($this->filters['per_page'] < 1) ? 8 : $this->filters['per_page'];

            return $query->paginate($this->filters['per_page'], $this->filters['page'] ?? 1);
        }

        return Survey::all();
    }
}
