<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Modules;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Events\Modules\OnInstallModule;
use TotalSurveyVendors\TotalSuite\Foundation\Http\UploadedFile;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Definition;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

/**
 * Class InstallModule
 *
 * @method static Definition invoke(Manager $manager, UploadedFile $moduleFile)
 * @method static Definition invokeWithFallback($fallback, Manager $manager, UploadedFile $moduleFile)
 */
class InstallModule extends Task
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @var UploadedFile
     */
    protected $moduleFile;

    /**
     * Activate constructor.
     *
     * @param Manager $manager
     * @param UploadedFile $moduleFile
     */
    public function __construct(Manager $manager, UploadedFile $moduleFile)
    {
        $this->manager = $manager;
        $this->moduleFile = $moduleFile;
    }


    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return $this->moduleFile->getError() === UPLOAD_ERR_OK;
    }

    /**
     * @inheritDoc
     */
    protected function execute()
    {
        $definition = $this->manager->installFromFile($this->moduleFile->file);
        OnInstallModule::emit($definition);
        
        return $definition;
    }
}
