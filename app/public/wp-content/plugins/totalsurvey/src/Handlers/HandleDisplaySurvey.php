<?php

namespace TotalSurvey\Handlers;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Events\Surveys\OnDisplaySurvey;
use TotalSurvey\Models\Survey;
use TotalSurvey\Tasks\Surveys\RenderSurvey;
use TotalSurveyVendors\League\Event\EventInterface;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\ActionHandler;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

class HandleDisplaySurvey extends ActionHandler
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * HandleDisplaySurvey constructor.
     *
     * @param  Manager  $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param  EventInterface|OnDisplaySurvey  $event
     */
    public function handle(EventInterface $event)
    {
        try {
            $survey = Survey::byUidAndActiveForRendering($event->surveyUid);
            echo RenderSurvey::invoke($this->manager, $survey);
        } catch (Exception $e) {
            echo esc_html($e->getMessage());
        }
    }
}
