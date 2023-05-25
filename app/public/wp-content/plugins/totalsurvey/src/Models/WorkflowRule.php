<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

/**
 * Class WorkflowRule
 *
 * @package TotalSurvey\Models
 *
 * @property bool                $enabled
 * @property string              $event
 * @property WorkflowCondition[] $conditions
 * @property WorkflowTask        $task
 */
class WorkflowRule extends Model
{
    /**
     * @var array
     */
    protected $types = [
        'conditions' => 'conditions',
        'task'       => 'task',
    ];

    /**
     * @var Survey
     */
    protected $survey;

    /**
     * constructor.
     *
     * @param Survey $survey
     * @param array  $attributes
     */
    public function __construct(Survey $survey, $attributes = [])
    {
        $this->survey = $survey;
        parent::__construct($attributes);
    }

    /**
     * @param mixed $task
     *
     * @return WorkflowTask
     * @noinspection PhpUnused
     */
    public function castToTask($task): WorkflowTask
    {
        return new WorkflowTask($this, $task);
    }

    /**
     * @param mixed $conditions
     *
     * @return Collection<WorkflowCondition>
     * @noinspection PhpUnused
     */
    public function castToConditions($conditions): Collection
    {
        $casted = [];
        foreach ($conditions as $condition) {
            $casted[] = new WorkflowCondition($this, $condition);
        }

        return Collection::create($casted);
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->getAttribute('enabled', false);
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->getAttribute('event');
    }

    /**
     * @return WorkflowTask
     */
    public function getTask(): WorkflowTask
    {
        return $this->getAttribute('task');
    }

    /**
     * @return WorkflowCondition[]|Collection<WorkflowCondition>
     */
    public function getConditions(): Collection
    {
        return $this->getAttribute('conditions');
    }

    /**
     * @return Survey
     */
    public function getSurvey(): Survey
    {
        return $this->survey;
    }
}
