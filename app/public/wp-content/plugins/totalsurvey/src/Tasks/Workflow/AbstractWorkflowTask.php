<?php

namespace TotalSurvey\Tasks\Workflow;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\WorkflowRule;
use TotalSurveyVendors\TotalSuite\Foundation\Event;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class WorkflowTask
 *
 * @method static void invoke(WorkflowRule $rule, Event $event)
 * @method static void invokeWithFallback($fallback, WorkflowRule $rule, Event $event)
 */
abstract class AbstractWorkflowTask extends Task
{
    /**
     * @var WorkflowRule
     */
    protected $rule;

    /**
     * @var Event
     */
    protected $event;

    /**
     * constructor.
     *
     * @param WorkflowRule $rule
     * @param Event        $event
     */
    public function __construct(WorkflowRule $rule, Event $event)
    {
        $this->rule  = $rule;
        $this->event = $event;
    }


    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }
}
