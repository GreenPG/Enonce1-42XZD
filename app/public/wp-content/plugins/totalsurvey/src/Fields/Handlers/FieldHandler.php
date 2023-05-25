<?php


namespace TotalSurvey\Fields\Handlers;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Entry;
use TotalSurvey\Models\FieldDefinition;
use TotalSurvey\Tasks\ProcessCondition;

abstract class FieldHandler
{
    /**
     * @param Entry $entry
     * @param FieldDefinition $field
     * @param array $answer
     *
     * @return mixed
     */
    abstract protected function handle(Entry $entry, FieldDefinition $field, array $answer);

    public function check($answer, $operator, $value)
    {
        return ProcessCondition::invokeWithFallback(false, $answer, $operator, $value);
    }

    /**
     * @param Entry $entry
     * @param FieldDefinition $field
     * @param mixed $value
     *
     * @return mixed
     */
    public function __invoke(Entry $entry, FieldDefinition $field, $value)
    {
        return $this->handle($entry, $field, $value);
    }
}