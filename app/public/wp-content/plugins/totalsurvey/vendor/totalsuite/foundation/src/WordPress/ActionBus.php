<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\League\Event\EventInterface;
use TotalSurveyVendors\TotalSuite\Foundation\Event;
use TotalSurveyVendors\TotalSuite\Foundation\Listener;

/**
 * Class ActionBus
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\WordPress
 */
class ActionBus extends Listener
{
    /**
     * Handle an event.
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function handle(EventInterface $event)
    {
        if (!$event->isPropagationStopped()) {
            do_action($event instanceof Event ? $event::alias() : $event->getName(), $event);
        }
    }
}