<?php

namespace TotalSurvey;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Fields\Choices;
use TotalSurvey\Fields\Date;
use TotalSurvey\Fields\Dropdown;
use TotalSurvey\Fields\Handlers\MultipleChoiceHandler;
use TotalSurvey\Fields\Handlers\ScaleHandler;
use TotalSurvey\Fields\MultipleChoices;
use TotalSurvey\Fields\Number;
use TotalSurvey\Fields\Paragraph;
use TotalSurvey\Fields\Scale;
use TotalSurvey\Fields\Text;
use TotalSurvey\Handlers\HandleDisplaySurvey;
use TotalSurvey\Services\WorkflowRegistry;
use TotalSurvey\Validations\FieldValidator;
use TotalSurvey\Validations\InArray;
use TotalSurveyVendors\League\Container\Container;
use TotalSurveyVendors\League\Container\ServiceProvider\AbstractServiceProvider;
use TotalSurveyVendors\Rakit\Validation\Validator;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

/**
 * Class ServiceProvider
 *
 * @package TotalSurvey
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        FieldManager::class,
        FieldValidator::class,
        HandleDisplaySurvey::class,
        WorkflowRegistry::class
    ];

    /**
     * @inheritDoc
     */
    public function register()
    {
        /**
         * @var Container $container
         */
        $container = $this->getContainer();

        // Field Manager
        $container->share(
            FieldManager::class,
            function () {
                // Register default field
                $fields = new FieldManager();
                $fields->registerType('text', Text::class);
                $fields->registerType('paragraph', Paragraph::class);
                $fields->registerType('number', Number::class);
                $fields->registerType('scale', Scale::class);
                $fields->registerType('date', Date::class);
                $fields->registerType('select', Dropdown::class);
                $fields->registerType('radio', Choices::class);
                $fields->registerType('checkbox', MultipleChoices::class);

                // Register default handlers
                $fields->registerHandler('radio', MultipleChoiceHandler::class);
                $fields->registerHandler('checkbox', MultipleChoiceHandler::class);
                $fields->registerHandler('select', MultipleChoiceHandler::class);
                $fields->registerHandler('scale', ScaleHandler::class);

                return $fields;
            }
        );

        // Field Validator
        $container->share(FieldValidator::class)->addArgument($container->get(Validator::class));

        // Handlers
        $container->add(HandleDisplaySurvey::class)->addArgument($container->get(Manager::class));

        // Workflow Registry
        $container->share(WorkflowRegistry::class);

        // Register custom validation rules
        $validator = $container->get(Validator::class);
        $validator->addValidator('inArray', new InArray());
    }
}
