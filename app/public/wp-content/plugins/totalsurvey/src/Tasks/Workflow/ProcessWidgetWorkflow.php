<?php

namespace TotalSurvey\Tasks\Workflow;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Events\OnRatingChanged;
use TotalSurvey\Events\OnRatingReceived;
use TotalSurvey\Events\OnRatingRevoked;
use TotalSurvey\Models\WorkflowEventDefinition;
use TotalSurvey\Models\WorkflowRule;
use TotalSurvey\Services\WorkflowRegistry;
use TotalSurveyVendors\TotalSuite\Foundation\Event;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class ProcessWidgetWorkflow
 *
 * @package TotalSurvey\Tasks\Widget
 * @method static void invoke(Event $event, WorkflowEventDefinition $workflowEvent)
 * @method static void invokeWithFallback($fallback, Event $event, WorkflowEventDefinition $workflowEvent)
 */
class ProcessWidgetWorkflow extends Task
{
    /**
     * @var Event
     */
    protected $event;

    /**
     * @var WorkflowEventDefinition
     */
    protected $workflowEvent;

    /**
     * constructor.
     *
     * @param Event|OnRatingReceived|OnRatingChanged|OnRatingRevoked $event
     * @param WorkflowEventDefinition                                $workflowEvent
     */
    public function __construct(Event $event, WorkflowEventDefinition $workflowEvent)
    {
        $this->event         = $event;
        $this->workflowEvent = $workflowEvent;
    }

    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @return void
     */
    protected function execute()
    {
        $matchingRules = $this->event->survey->getWorkflowRules()
                                             ->filter([$this, 'filterRule']);

        foreach ($matchingRules as $rule) {
            WorkflowRegistry::instance()
                            ->invokeTaskFromRuleContext($rule, $this->event);
        }
    }

    public function filterRule(WorkflowRule $rule)
    {
        return $rule->isEnabled() && $rule->getEvent() === $this->workflowEvent->id && $this->matchesConditions($rule);
    }

    protected function matchesConditions(WorkflowRule $rule): bool
    {
        foreach ($rule->getConditions() as $condition) {
            if ($condition->attributeUid === $this->event->entry->attribute_uid) {
                $conditionAttribute = $condition->getRatingAttribute();

                if (!$conditionAttribute) {
                    continue;
                }

                $conditionPoint = $condition->getPoint();
                $receivedPoint  = $conditionAttribute->getPoint($this->event->entry->point_uid);

                if (!$conditionPoint || !$receivedPoint) {
                    continue;
                }

                if ($condition->isOperatorLessThan() && $receivedPoint->value >= $conditionPoint->value) {
                    return false;
                }

                if ($condition->isOperatorEquals() && $receivedPoint->value === $conditionPoint->value) {
                    return false;
                }

                if ($condition->isOperatorGreaterThan() && $receivedPoint->value <= $conditionPoint->value) {
                    return false;
                }
            }
        }

        return true;
    }
}
