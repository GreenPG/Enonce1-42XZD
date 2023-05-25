<?php

namespace TotalSurvey\Events;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;

/**
 * Class OnPostValidateEntry
 * @package TotalSurvey\Events
 * @method static void emit(Survey $survey, array $data) : Event
 */
class OnPostValidateEntry extends \TotalSurveyVendors\TotalSuite\Foundation\Event
{
    const ALIAS = 'totalsurvey/validate/entry';

    /**
     * @var Survey
     */
    public $survey;

    /**
     * @var array
     */
    public $data;

    /**
     * constructor.
     *
     * @param Survey $survey
     * @param array $data
     */
    public function __construct(Survey $survey, array $data)
    {
        $this->survey = $survey;
        $this->data   = $data;
    }
}