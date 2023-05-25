<?php

namespace TotalSurvey\Tasks\Workflow;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Events\Entries\OnEntryReceived;
use TotalSurvey\Models\EntryBlock;
use TotalSurvey\Models\EntrySection;
use TotalSurvey\Models\WorkflowEventDefinition;
use TotalSurvey\Models\WorkflowRule;
use TotalSurvey\Services\WorkflowRegistry;
use TotalSurvey\Tasks\ProcessCondition;
use TotalSurveyVendors\TotalSuite\Foundation\Event;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class ProcessWidgetWorkflow
 *
 * @package TotalSurvey\Tasks\Widget
 * @method static void invoke(Event $event, WorkflowEventDefinition $workflowEvent)
 * @method static void invokeWithFallback($fallback, Event $event, WorkflowEventDefinition $workflowEvent)
 */
class ProcessSurveyWorkflow extends Task
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
     * @param  Event|OnEntryReceived  $event
     * @param  WorkflowEventDefinition  $workflowEvent
     */
    public function __construct(Event $event, WorkflowEventDefinition $workflowEvent)
    {
        $this->event = $event;
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
     * @throws Exception
     */
    protected function execute()
    {
        $matchingRules = $this->event->survey->getWorkflowRules()->filter([$this, 'filterRule']);

        foreach ($matchingRules as $rule) {
            WorkflowRegistry::instance()->invokeTaskFromRuleContext($rule, $this->event);
        }
    }

    public function filterRule(WorkflowRule $rule)
    {
        return $rule->isEnabled() && $rule->getEvent() === $this->workflowEvent->id && $this->matchesConditions($rule);
    }

    protected function matchesConditions(WorkflowRule $rule): bool
    {
        foreach ($rule->getConditions() as $condition) {
            if ($condition->question) {
                /**
                 * @var EntrySection $section
                 */
                $section = $this->event->entry->data->sections
                    ->where(['uid' => $condition->sectionUid])
                    ->first();

                if (!$section) {
                    continue;
                }

                /**
                 * @var EntryBlock $entryBlock
                 */
                $entryBlock = $section->blocks->where(['uid' => $condition->questionUid])->first();

                if (!$entryBlock) {
                    continue;
                }

                return ProcessCondition::invokeWithFallback(
                    false,
                    $entryBlock->value,
                    $condition->operator,
                    $condition->value
                );
            }
        }

        return true;
    }
}
