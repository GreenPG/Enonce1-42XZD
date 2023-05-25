<?php
namespace TotalSurvey\Concerns;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Exceptions\FieldException;
use TotalSurvey\Fields\Handlers\DefaultHandler;
use TotalSurvey\Fields\Handlers\FieldHandler;
use TotalSurvey\Models\Entry;
use TotalSurvey\Models\FieldDefinition;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;

trait FieldHandlerRegistry
{
    /**
     * @var FieldHandler[]
     */
    protected $handlers = [];

    /**
     * @var array
     */
    protected $handlerInstance = [];

    /**
     * @param string $type
     * @param string $handler
     *
     * @throws Exception
     */
    public function registerHandler($type, $handler)
    {
        if ($this->hasHandler($type)) {
            FieldException::throw(sprintf('A Handler for field %s type is already registred', $type));
        }

        if ( ! class_exists($handler)) {
            FieldException::throw(sprintf('Class not found for %s handler', $type));
        }

        if(! in_array(FieldHandler::class, class_parents($handler), true)) {
            FieldException::throw(sprintf('Handler must extends %s class', FieldHandler::class));
        }

        $this->handlers[$type] = $handler;
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function hasHandler($type) {
        return array_key_exists($type, $this->handlers);
    }

    /**
     * @param Entry $entry
     * @param FieldDefinition $definition
     * @param array $answer [string title, mixed $value, string type, array meta]
     *
     * @return mixed|string
     */
    public function handle(Entry $entry, FieldDefinition $definition, array $answer)
    {
        $handler = null;

        if ($this->hasHandler($definition->type)) {
            $handler = $this->getHandlerInstance($definition->type);
        } else {
            $handler = new DefaultHandler();
        }

        return $handler($entry, $definition, $answer);
    }

    /**
     * @param $type
     *
     * @return FieldHandler
     */
    public function getHandlerInstance($type) {

        if(array_key_exists($type, $this->handlerInstance)) {
            return $this->handlerInstance[$type];
        }

        $handlerClass = $this->handlers[$type];
        $handlerInstance = new $handlerClass();

        $this->handlerInstance[$type] = $handlerInstance;

        return $handlerInstance;
    }
}