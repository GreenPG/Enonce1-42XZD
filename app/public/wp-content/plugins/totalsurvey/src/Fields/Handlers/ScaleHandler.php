<?php
namespace TotalSurvey\Fields\Handlers;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Entry;
use TotalSurvey\Models\FieldDefinition;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;

class ScaleHandler extends FieldHandler
{
    /**
     * @param Entry $entry
     * @param FieldDefinition $field
     * @param array $answer
     *
     * @return mixed|string
     */
    protected function handle(Entry $entry, FieldDefinition $field, array $answer)
    {
        $answer['value'] = sprintf(
            __('%d out of %d', 'totalsurvey'),
            (int)$answer['value'],
            Arrays::get($field->options, 'scale', 0)
        );

        return $answer;
    }
}