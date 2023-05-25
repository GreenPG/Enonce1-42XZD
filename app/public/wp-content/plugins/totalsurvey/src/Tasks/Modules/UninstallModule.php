<?php


namespace TotalSurvey\Tasks\Modules;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\ModuleException;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

//@TODO: Extract this task to the foundation framework

/**
 * Class UninstallModule
 *
 * @package TotalSurvey\Tasks\Modules
 */
class UninstallModule extends Task
{

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @var string
     */
    private $id;

    /**
     * Activate constructor.
     *
     * @param Manager $manager
     * @param string  $id
     */
    public function __construct(Manager $manager, string $id)
    {
        $this->manager = $manager;
        $this->id      = $id;
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
     * @throws ModuleException
     */
    protected function execute()
    {
        if (!$this->manager->uninstall($this->id)) {
            throw new Exception('Cannot uninstall module');
        }
    }
}
