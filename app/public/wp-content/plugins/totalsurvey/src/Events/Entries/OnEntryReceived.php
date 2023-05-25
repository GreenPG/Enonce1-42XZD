<?php

namespace TotalSurvey\Events\Entries;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Entry;
use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Event;

class OnEntryReceived extends Event
{
    const ALIAS = 'totalsurvey/entry/received';

    /**
     * @var Survey
     */
    public $survey;

    /**
     * @var Entry
     */
    public $entry;

    /**
     * constructor.
     *
     * @param Survey $survey
     * @param Entry $entry
     */
    public function __construct($survey, $entry)
    {
        $this->survey = $survey;
        $this->entry = $entry;
    }
}
