<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;

/**
 * Class Question
 *
 * @package TotalSurvey\Models
 *
 * @property string $uid
 * @property string $label
 * @property string $title
 * @property string $description
 * @property FieldDefinition $field
 * @property mixed|null sectionUid
 */
class Question extends Model
{
    protected $types = [
        'field' => 'field',
    ];

    /**
     * @var Section
     */
    public $section;

    /**
     * Question constructor.
     *
     * @param Section $section
     * @param array $attributes
     */
    public function __construct(Section $section, $attributes = [])
    {
        parent::__construct($attributes);
        $this->section = $section;
    }


    /**
     * @param array $data
     *
     * @return FieldDefinition
     * @noinspection PhpUnused
     */
    public function castToField(array $data): FieldDefinition
    {
        return new FieldDefinition($this, $data);
    }
}