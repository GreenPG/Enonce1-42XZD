<?php

namespace TotalSurvey\Actions\Modules;
! defined( 'ABSPATH' ) && exit();



use Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

//@TODO: Extract this action to the foundation framework

/**
 * Class Index
 *
 * @package TotalSurvey\Actions\Modules
 */
class Index extends Action
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
     * @return Response
     * @throws Exception
     */
    public function execute(): Response
    {
        $modules = $this->manager->fetch()->values();

        return ResponseFactory::json($modules);
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return current_user_can('totalsurvey_manage_modules');
    }
}
