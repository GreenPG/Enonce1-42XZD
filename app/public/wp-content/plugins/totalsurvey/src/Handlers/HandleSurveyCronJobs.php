<?php

namespace TotalSurvey\Handlers;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Events\Surveys\OnDisplaySurvey;
use TotalSurvey\Events\Surveys\OnUpdateSurvey;
use TotalSurvey\Models\Survey;
use TotalSurvey\Tasks\Reports\SetupCronReport;
use TotalSurvey\Tasks\Surveys\RenderSurvey;
use TotalSurveyVendors\League\Event\EventInterface;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Listener;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\ActionHandler;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

class HandleSurveyCronJobs extends Listener
{
    /**
     * @param EventInterface|OnUpdateSurvey $event
     */
    public function handle(EventInterface $event)
    {
        try {
            SetupCronReport::invoke($event->survey);
        } catch (Exception $e) {
            //@TODO Define how to handle exceptions during this execution context
        }
    }
}
