<?php


namespace TotalSurvey\Tasks\Modules;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\UploadedFile;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

//@TODO: Extract this task to the foundation framework

/**
 * Class InstallModule
 *
 * @package TotalSurvey\Tasks\Modules
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
    protected $file;
    /**
     * @var UploadedFile
     */
    private $moduleFile;

    /**
     * Activate constructor.
     *
     * @param Manager      $manager
     * @param UploadedFile $moduleFile
     */
    public function __construct(Manager $manager, UploadedFile $moduleFile)
    {
        $this->manager    = $manager;
        $this->moduleFile = $moduleFile;
    }


    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function execute()
    {
        return $this->manager->installFromFile($this->moduleFile->file);
    }
}
