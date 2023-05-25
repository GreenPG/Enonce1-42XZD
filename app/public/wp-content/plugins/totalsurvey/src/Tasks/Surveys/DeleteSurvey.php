<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Entry;
use TotalSurvey\Models\Survey;
use TotalSurvey\Tasks\Utils\DeleteUploadedFiles;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class DeleteSurvey
 *
 * @package TotalSurvey\Tasks\Survey
 * @method static Survey invoke(string $surveyUid)
 * @method static Survey invokeWithFallback($fallback, string $surveyUid)
 */
class DeleteSurvey extends Task
{

    /**
     * @var string
     */
    protected $surveyUid;

    /**
     * Delete constructor.
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
     * @return mixed|null
     * @throws Exception
     * @throws DatabaseException
     */
    public function execute()
    {
        $survey = Survey::byUid($this->surveyUid);
        Exception::throwUnless($survey->delete(), 'Could not delete the survey');

        Entry::query()
             ->delete()
             ->where('survey_uid', $this->surveyUid)
             ->execute();

        DeleteUploadedFiles::invoke($this->surveyUid);

        return $survey;
    }
}
