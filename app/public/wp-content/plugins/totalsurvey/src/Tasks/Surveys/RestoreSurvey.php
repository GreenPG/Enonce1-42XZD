<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class RestoreSurvey
 *
 * @package TotalSurvey\Tasks\Survey
 * @method static Survey invoke(string $surveyUid)
 * @method static Survey invokeWithFallback($fallback, string $surveyUid)
 */
class RestoreSurvey extends Task
{

    /**
     * @var string
     */
    protected $surveyUid;

    /**
     * Create constructor.
     *
     * @param $surveyUid
     */
    public function __construct(string $surveyUid)
    {
        $this->surveyUid = $surveyUid;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        return true;
    }

    /**
     * @return Survey
     * @throws Exception
     * @throws DatabaseException
     */
    public function execute(): Survey
    {
        $survey = Survey::byUid($this->surveyUid);

        $survey->deleted_at = null;
        $survey->status     = Survey::STATUS_OPEN;
        $survey->enabled    = true;

        $survey->save();

        return $survey;
    }
}
