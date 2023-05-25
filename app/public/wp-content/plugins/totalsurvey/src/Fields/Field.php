<?php

namespace TotalSurvey\Fields;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\FieldDefinition;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

abstract class Field
{
    /**
     * @var bool
     */
    protected $multiple = false;

    /**
     * @var FieldDefinition
     */
    protected $definition;

    /**
     * Field constructor.
     *
     * @param FieldDefinition $definition
     */
    public function __construct(FieldDefinition $definition)
    {
        $this->definition = $definition;
    }

    /**
     * @return FieldDefinition
     */
    public function getDefinition(): FieldDefinition
    {
        return $this->definition;
    }

    /**
     * @param FieldDefinition $definition
     */
    public function setDefinition(FieldDefinition $definition)
    {
        $this->definition = $definition;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return sprintf('%s[%s]%s', $this->definition->question->section->uid, $this->definition->uid, $this->multiple ? '[]' : '');
    }

    /**
     * @param null $section
     *
     * @return Html
     */
    abstract public function render(): Html;
}