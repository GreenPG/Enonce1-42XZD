<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;

/**
 * Class Condition
 *
 * @package TotalSurvey\Models
 *
 * @property string $field
 * @property string $operator
 * @property string $action
 * @property string $next_section_uid
 * @property mixed  $value
 */
class Condition extends Model
{
    const OPERATOR_EQUALS = 'equals';
    const OPERATOR_NOT_EQUALS = 'not equals';
    const OPERATOR_LESS_THAN = 'less than';
    const OPERATOR_GREATER_THAN = 'greater than';
    const OPERATOR_IN = 'in';
    const OPERATOR_NOT_IN = 'not in';
    const OPERATOR_CONTAINS = 'contains';
    const OPERATOR_NOT_CONTAINS = 'not contains';

    /**
     * @var string[]
     */
    protected $types = [
        'value' => 'array',
    ];
}