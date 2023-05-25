<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Modules;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Modules\InstallModule;

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
        Exception::throwUnless($uploaded, 'No file was uploaded');

        return InstallModule::invoke($this->manager, $uploaded)
                            ->toJsonResponse();
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
