<?php


namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\ValidateInput;

/**
 * Class EnableSurvey
 *
 * @package TotalSurvey\Tasks\Survey
 * @method static Survey invoke(string $surveyUid, string $status)
 * @method static Survey invokeWithFallback($fallback, string $surveyUid, string $status)
 */
class EnableSurvey extends Task
{
    /**
     * @var bool
     */
    protected $status;

    /**
     * @var string
     */
    protected $surveyUid;

    /**
     * constructor.
     *
     * @param $surveyUid
     * @param $status
     */
    public function __construct(string $surveyUid, $status)
    {
        $this->surveyUid = $surveyUid;
        $this->status    = $status;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function validate()
    {
        return ValidateInput::invoke(['status' => 'present'], ['status' => $this->status]);
    }

    /**
     * @return Survey
     * @throws Exception
     */
    public function execute(): Survey
    {
        $survey          = Survey::byUid($this->surveyUid);
        $survey->enabled = (bool)$this->status;
        $survey->update();

        return $survey;
    }
}
