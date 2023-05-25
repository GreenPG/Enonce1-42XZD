<?php


namespace TotalSurvey\Tasks\Modules;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\ModuleException;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

//@TODO: Extract this task to the foundation framework

/**
 * Class ActivateModule
 *
 * @package TotalSurvey\Tasks\Modules
 */
class ActivateModule extends Task
{

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @var string
     */
    protected $id;

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
        return current_user_can('totalsurvey_manage_modules');
    }

    /**
     * @inheritDoc
     * @throws ModuleException
     * @throws Exception
     */
    protected function execute()
    {
        if (!$this->manager->activate($this->id)) {
            throw new Exception('Cannot activate module');
        }

        return $this->manager->getDefinition($this->id);
    }
}
