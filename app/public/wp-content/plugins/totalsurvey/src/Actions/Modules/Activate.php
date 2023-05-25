<?php

namespace TotalSurvey\Actions\Modules;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Tasks\Modules\ActivateModule;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

//@TODO: Extract this action to the foundation framework

/**
 * Class Activate
 *
 * @package TotalSurvey\Actions\Modules
 */
class Activate extends Action
{

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * Index constructor.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param $id
     *
     * @return Response
     */
    public function execute($id): Response
    {
        $definition = (new ActivateModule($this->manager, $id))->run();

        return ResponseFactory::json($definition);
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return current_user_can('totalsurvey_manage_modules');
    }

    public function getParams(): array
    {
        return [
            'id' => [
                'expression'        => '(?<id>([\w-]+))',
                'sanitize_callback' => function ($id) {
                    return (string)$id;
                },
            ],
        ];
    }
}
