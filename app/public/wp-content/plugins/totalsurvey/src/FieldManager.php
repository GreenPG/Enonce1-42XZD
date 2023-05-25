<?php

namespace TotalSurvey;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Concerns\FieldHandlerRegistry;
use TotalSurvey\Exceptions\FieldException;
use TotalSurvey\Fields\Field;
use TotalSurvey\Models\FieldDefinition;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Concerns\ResolveFromContainer;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

/**
 * Class FieldsManager
 *
 * @package TotalSurvey
 */
class FieldManager
{
    use FieldHandlerRegistry;
    use ResolveFromContainer;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @param string $type
     * @param string $class
     *
     * @throws Exception
     */
    public function registerType($type, $class)
    {
        if (array_key_exists($type, $this->fields)) {
            FieldException::throw(sprintf('A Field typed %s is already registred', $type));
        }

        if ( ! class_exists($class)) {
            FieldException::throw(sprintf('Class not found for field %s (%s)', $type, $class));
        }

        if ( ! in_array(Field::class, class_parents($class), true)) {
            FieldException::throw(sprintf('Field must extends %s class', Field::class));
        }

        $this->fields[$type] = $class;
    }

    /**
     * @param FieldDefinition $definition
     *
     * @return Html
     */
    public function render(FieldDefinition $definition): Html
    {
        if (! array_key_exists($definition->type, $this->fields)) {
            return Html::create(
                'div',
                [
                    'data-error' => sprintf('Field type [%s] class not found', $definition->type)
                ]
            );
        }

        $class    = $this->fields[$definition->type];
        $instance = new $class($definition);

        return $instance->render();
    }
}