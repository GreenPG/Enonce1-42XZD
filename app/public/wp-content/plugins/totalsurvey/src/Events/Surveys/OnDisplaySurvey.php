<?php

namespace TotalSurvey\Events\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Event;

class OnDisplaySurvey extends Event
{
    const ALIAS = 'totalsurvey/display/survey';

    /**
     * @var string
     */
    public $surveyUid;

    /**
     * constructor.
     *
     * @param string $surveyUid
     */
    public function __construct(string $surveyUid)
    {
        $this->surveyUid = $surveyUid;
    }
}
