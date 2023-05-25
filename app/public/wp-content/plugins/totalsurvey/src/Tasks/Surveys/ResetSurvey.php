<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Events\Surveys\OnResetSurvey;
use TotalSurvey\Models\Entry;
use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class ResetSurvey
 * @package TotalSurvey\Tasks\Surveys
 * @method static Survey invoke(string $surveyUid)
 * @method static Survey invokeWithFallback($fallback, string $surveyUid)
 */
class ResetSurvey extends Task
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

    public function validate()
    {
        return true;
    }

    /**
     * @return mixed|Survey
     * @throws Exception
     * @throws DatabaseException
     */
    public function execute()
    {
        $survey = Survey::byUid($this->surveyUid);

        $result = Entry::query()
                       ->delete()
                       ->where('survey_uid', $this->surveyUid)
                       ->execute();

        Exception::throwUnless($result, 'Could not reset the survey');

        OnResetSurvey::emit($survey);

        $survey->reset_at = wp_date('Y-m-d H:i:s');
        $survey->save();

        return $survey;
    }
}
