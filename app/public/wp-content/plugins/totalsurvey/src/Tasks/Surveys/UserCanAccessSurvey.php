<?php


namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Capabilities\UserCanViewSurveys;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

class UserCanAccessSurvey extends Task
{
    protected $survey;

    /**
     * CheckAccess constructor.
     *
     * @param $survey
     */
    public function __construct($survey)
    {
        $this->survey = $survey;
    }


    protected function validate()
    {
        return true;
    }

    /**
     * @return mixed|void
     * @throws Exception
     */
    protected function execute()
    {
        Exception::throwIf(
            $this->survey && ! $this->survey->enabled && UserCanViewSurveys::check(),
            'You are not allowed to access this survey.'
        );
    }
}
