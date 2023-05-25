<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Events\Surveys\OnUpdateSurvey;
use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class UpdateSurvey
 *
 * @package TotalSurvey\Tasks\Survey
 * @method static Survey invoke(string $surveyUid, array $data)
 * @method static Survey invokeWithFallback($fallback, string $surveyUid, array $data)
 */
class UpdateSurvey extends Task
{
    /**
     * @var string
     */
    protected $surveyUid;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * UpdateSurvey constructor.
     *
     * @param string $surveyUid
     * @param array $data
     */
    public function __construct(string $surveyUid, array $data)
    {
        $this->surveyUid = $surveyUid;
        $this->data      = $data;
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
     */
    public function execute()
    {
        $survey = Survey::byUid($this->surveyUid);

        $data = Arrays::only(
            $this->data,
            [
                'name',
                'description',
                'sections',
                'translations',
                'settings',
                'enabled',
                'status',
            ]
        );

        $survey->hydrate($data, false);
        $survey->updated_at = date('Y-m-d H:i:s');
        OnUpdateSurvey::emit($survey);

        Exception::throwUnless($survey->update(), 'Could not update the survey');

        return $survey;
    }
}
