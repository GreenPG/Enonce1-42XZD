<?php

namespace TotalSurvey\Tasks\Sections;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Condition;
use TotalSurvey\Models\NextAction;
use TotalSurvey\Models\Section;
use TotalSurvey\Models\Survey;
use TotalSurvey\Tasks\ProcessCondition;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class ProcessConditions
 *
 * @package TotalSurvey\Tasks\Sections
 * @method static NextAction invoke(Survey $survey, Section $section, array $entry)
 * @method static NextAction invokeWithFallback($fallback, Survey $survey, Section $section, array $entry)
 */
class ProcessConditions extends Task
{
    /**
     * @var Survey
     */
    protected $survey;

    /**
     * @var Section
     */
    protected $section;

    /**
     * @var array
     */
    protected $entry;

    /**
     * ProcessSection constructor.
     *
     * @param  Survey  $survey
     * @param  Section  $section
     * @param  Collection  $entry
     */
    public function __construct(Survey $survey, Section $section, Collection $entry)
    {
        $this->survey  = $survey;
        $this->section = $section;
        $this->entry   = $entry;
    }

    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function execute()
    {
        switch ($this->section->action) {
            case Survey::ACTION_CONDITIONS:
            {
                return $this->applyConditions();
            }
            case Survey::ACTION_SUBMIT:
            {
                return NextAction::from(
                    [
                        'action'      => Survey::ACTION_SUBMIT,
                        'section_uid' => null,
                    ]
                );
            }
            case Survey::ACTION_SECTION:
            {
                return NextAction::from(
                    [
                        'action'      => Survey::ACTION_SECTION,
                        'section_uid' => $this->section->next_section_uid,
                    ]
                );
            }
            case Survey::ACTION_NEXT:
            default :
            {
                $next = $this->section->getNextSection();

                if ($next instanceof Section) {
                    return NextAction::from(
                        [
                            'action'      => Survey::ACTION_NEXT,
                            'section_uid' => $next->uid,
                        ]
                    );
                }

                return NextAction::from(
                    [
                        'action'      => Survey::ACTION_SUBMIT,
                        'section_uid' => null,
                    ]
                );
            }
        }
    }

    /**
     * @return NextAction
     */
    protected function applyConditions(): NextAction
    {
        foreach ($this->section->conditions as $condition) {
            if ($this->applyOperator($condition) === true) {
                return NextAction::from(
                    [
                        'action'      => $condition->action,
                        'section_uid' => $condition->next_section_uid,
                    ]
                );
            }
        }

        return NextAction::from(
            [
                'action'      => Survey::ACTION_NEXT,
                'section_uid' => $this->section->getNextSection()->uid,
            ]
        );
    }

    /**
     * @param  Condition  $condition
     *
     * @return bool
     */
    protected function applyOperator(Condition $condition): bool
    {
        $input = $this->entry->get($condition->field);

        if ($input === null) {
            return false;
        }

        return ProcessCondition::invokeWithFallback(false, $input, $condition->operator, $condition->value);
    }
}
