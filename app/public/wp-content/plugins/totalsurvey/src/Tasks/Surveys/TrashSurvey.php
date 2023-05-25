<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Database\TableModel;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class TrashSurvey
 *
 * @package TotalSurvey\Tasks\Survey
 * @method static Survey invoke(string $surveyUid)
 * @method static Survey invokeWithFallback($fallback, string $surveyUid)
 */
class TrashSurvey extends Task
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
     * @return mixed|TableModel|Collection
     * @throws Exception
     * @throws DatabaseException
     */
    public function execute()
    {
        $survey = Survey::byUid($this->surveyUid);

        $survey->status     = Survey::STATUS_DELETED;
        $survey->enabled    = false;
        $survey->deleted_at = date('Y-m-d H:i:s');

        Exception::throwUnless($survey->save(), __('Could not delete the survey', 'totalsurvey'));

        return $survey;
    }
}
