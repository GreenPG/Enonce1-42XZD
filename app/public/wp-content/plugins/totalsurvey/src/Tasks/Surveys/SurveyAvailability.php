<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class SurveyAvailability
 *
 * @package TotalSurvey\Tasks\Surveys
 */
class SurveyAvailability extends Task
{
    /**
     * @var string
     */
    protected $surveyId;

    /**
     * SurveyAvailability constructor.
     *
     * @param string $surveyId
     */
    public function __construct(string $surveyId)
    {
        $this->surveyId = $surveyId;
    }


    /**
     * @inheritDoc
     */
    protected function validate()
    {
        // TODO: Implement validate() method.
    }

    /**
     * @inheritDoc
     * @return Survey
     * @throws DatabaseException|Exception
     */
    protected function execute(): Survey
    {
        /**
         * @var Survey`$survey
         */
        $survey = Survey::query()->where('id', $this->surveyId)->where('enabled', true)->first();

        if (!$survey instanceof Survey) {
            throw new Exception(__('This survey is not available at the moment.', 'totalsurvey'));
        }

        (new CheckLimitations($survey))->run();

        return $survey;
    }
}