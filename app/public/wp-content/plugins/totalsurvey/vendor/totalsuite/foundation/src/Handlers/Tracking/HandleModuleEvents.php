<?php
namespace TotalSurveyVendors\TotalSuite\Foundation\Handlers\Tracking;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\League\Event\EventInterface;
use TotalSurveyVendors\TotalSuite\Foundation\Contracts\TrackingStorage;
use TotalSurveyVendors\TotalSuite\Foundation\Events\Modules\OnActivateModule;
use TotalSurveyVendors\TotalSuite\Foundation\Events\Modules\OnDeactivateModule;
use TotalSurveyVendors\TotalSuite\Foundation\Events\Modules\OnInstallModule;
use TotalSurveyVendors\TotalSuite\Foundation\Events\Modules\OnUninstallModule;
use TotalSurveyVendors\TotalSuite\Foundation\Listener;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Plugin;

class HandleModuleEvents extends Listener
{
    /**
     * @var Options
     */
    protected $options;

    /**
     * HandleModuleEvents constructor.
     *
     */
    public function __construct()
    {
        $this->options = Plugin::get(TrackingStorage::class);
    }


    /**
     * @param  EventInterface|OnActivateModule|OnDeactivateModule|OnInstallModule|OnUninstallModule  $event
     */
    public function handle(EventInterface $event)
    {
        $action = [
            'label'  => $event->definition->get('id'),
            'date'   => date(DATE_ATOM),
        ];

        switch (get_class($event)) {
            case OnActivateModule::class :
            {
                $action['action'] = 'activate';
                break;
            }
            case OnDeactivateModule::class :
            {
                $action['action'] = 'deactivate';
                break;
            }
            case OnInstallModule::class :
            {
                $action['action'] = 'install';
                break;
            }
            case OnUninstallModule::class :
            {
                $action['action'] = 'uninstall';
                break;
            }
        }

        $storage = $this->options->get('features', []);
        $storage[] = $action;
        $this->options->set('features', $storage)->save();
    }
}