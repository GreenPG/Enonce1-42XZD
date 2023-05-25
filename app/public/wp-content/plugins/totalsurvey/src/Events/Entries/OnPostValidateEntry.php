<?php

namespace TotalSurvey\Events\Entries;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Event;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

/**
 * Class OnPostValidateEntry
 *
 * @package TotalSurvey\Events
 * @method static void emit(Survey $survey, Collection $data) : Event
 */
class OnPostValidateEntry extends Event
{
    const ALIAS = 'totalsurvey/validate/entry';

    /**
     * @var Survey
     */
    public $survey;

    /**
     * @var Collection
     */
    public $data;

    /**
     * constructor.
     *
     * @param  Survey  $survey
     * @param  Collection  $data
     */
    public function __construct(Survey $survey, Collection $data)
    {
        $this->survey = $survey;
        $this->data   = $data;
    }
}
