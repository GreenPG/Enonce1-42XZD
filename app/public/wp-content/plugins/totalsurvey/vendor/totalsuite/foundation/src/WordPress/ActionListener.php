<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\League\Event\EventInterface;
use TotalSurveyVendors\League\Event\ListenerInterface;

/**
 * Class ActionListener
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\WordPress
 */
class ActionListener implements ListenerInterface
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
            do_action($event->getName(), $event);
        }
    }

    /**
     * Check whether the listener is the given parameter.
     *
     * @param mixed $listener
     *
     * @return bool
     */
    public function isListener($listener): bool
    {
        return $listener === $this;
    }
}