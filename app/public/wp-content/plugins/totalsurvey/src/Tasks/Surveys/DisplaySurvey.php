<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();



use Exception;
use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Contracts\Support\HTMLRenderable;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class DisplaySurvey
 *
 * @package TotalSurvey\Tasks\Surveys
 * @method static string invoke(Survey $survey)
 * @method static string invokeWithFallback($fallback, Survey $survey)
 */
class DisplaySurvey extends Task
{
    /**
     * @var Survey
     */
    protected $survey;

    /**
     * DisplaySurvey constructor.
     *
     * @param  Survey  $survey
     */
    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }

    /**
     * @return bool
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function execute()
    {
        try {
            CheckLimitations::invoke($this->survey);

            return $this->survey->render();
        } catch (Exception $exception) {
            if ($exception instanceof HTMLRenderable) {
                $html = $exception->toHTML();
            } else {
                $html = Html::create('p', [], $exception->getMessage());
            }

            return $html;
        }
    }
}
