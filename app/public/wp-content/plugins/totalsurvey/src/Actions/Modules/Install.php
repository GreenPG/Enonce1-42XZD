<?php

namespace TotalSurvey\Actions\Modules;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Tasks\Modules\InstallModule;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

//@TODO: Extract this action to the foundation framework

/**
 * Class Install
 *
 * @package TotalSurvey\Actions\Modules
 */
class Install extends Action
{

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * Install constructor.
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
        $uploaded = Arrays::get($this->request->getUploadedFiles(), 'module', null);

        if ($uploaded === null) {
            throw new Exception('No file was uploaded');
        }

        $definition = (new InstallModule($this->manager, $uploaded))->run();

        return ResponseFactory::json($definition);
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return current_user_can('totalsurvey_manage_modules');
    }
}
