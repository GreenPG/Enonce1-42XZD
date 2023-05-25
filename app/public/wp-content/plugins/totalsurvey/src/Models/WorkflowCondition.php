<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;

/**
 * Class WorkflowCondition
 *
 * @package TotalSurvey\Models
 *
 * @property string $operator
 * @property Section $section
 * @property Block $question
 * @property string $sectionUid
 * @property string $questionUid
 * @property mixed $value
 */
class WorkflowCondition extends Model
{
    /**
     * @var WorkflowRule
     */
    protected $rule;

    /**
     * constructor.
     *
     * @param  WorkflowRule  $rule
     * @param  array  $attributes
     */
    public function __construct(WorkflowRule $rule, $attributes = [])
    {
        $this->rule = $rule;
        parent::__construct($attributes);

        try {
            $this->section  = $this->rule->getSurvey()->getSection($this->sectionUid);
            $this->question = $this->section->getBlock($this->questionUid);
        } catch (\Exception $exception) {
        }
    }
}
