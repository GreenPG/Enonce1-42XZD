<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetSurvey
 *
 * @package TotalSurvey\Tasks\Survey
 * @method static Survey invoke(string $surveyUid)
 * @method static Survey invokeWithFallback($fallback, string $surveyUid)
 */
class GetSurvey extends Task
{

    /**
     * @var string
     */
    protected $surveyUid;

    /**
     * GetSurvey constructor.
     *
     * @param string $surveyUid
     */
    public function __construct(string $surveyUid)
    {
        $this->surveyUid = $surveyUid;
    }

    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function execute()
    {
        return Survey::byUid($this->surveyUid);
    }
}
