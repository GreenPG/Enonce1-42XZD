<?php
namespace TotalSurvey\Fields\Handlers;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Entry;
use TotalSurvey\Models\FieldDefinition;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;

class MultipleChoiceHandler extends FieldHandler
{
    /**
     * @param Entry $entry
     * @param FieldDefinition $field
     * @param array $answer
     *
     * @return mixed
     */
    protected function handle(Entry $entry, FieldDefinition $field, array $answer)
    {
        $value  = (array)$answer['value'];
        $choices = Arrays::extract($field->options['choices'] ?? [], 'label', 'uid');

        foreach ($value as $index => $v) {
            if (isset($choices[$v])) {
                $value[$index] = esc_html($choices[$v]);
            } elseif ($field->type !== 'select') {
                $value[$index] = sprintf(__('(Other) %s', 'totalsurvey'), esc_html($v));
            }
        }

        $answer['value'] = implode(', ', (array)$value);

        return $answer;
    }
}