<?php

namespace TotalSurvey\Events\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Event;

class OnResetSurvey extends Event
{
    const ALIAS = 'totalsurvey/survey/reset';

    /**
     * @var Survey
     */
    public $survey;

    /**
     * OnResetSurvey constructor.
     *
     * @param  Survey  $survey
     */
    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }


}
