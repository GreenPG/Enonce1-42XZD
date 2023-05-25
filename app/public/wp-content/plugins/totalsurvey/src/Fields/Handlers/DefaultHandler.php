<?php


namespace TotalSurvey\Fields\Handlers;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Entry;
use TotalSurvey\Models\FieldDefinition;

class DefaultHandler extends FieldHandler
{
    /**
     * @param Entry $entry
     * @param FieldDefinition $field
     * @param array $answer
     *
     * @return array
     */
    protected function handle(Entry $entry, FieldDefinition $field, array $answer)
    {
        $answer['value'] = implode(', ', array_map('esc_html', (array)$answer['value']));
        return $answer;
    }
}