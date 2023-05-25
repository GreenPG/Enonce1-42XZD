<?php

namespace TotalSurvey;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Actions\Reports\SendNowReport;
use TotalSurvey\Actions\Surveys\Section;
use TotalSurvey\Capabilities\UserCanCreateSurvey;
use TotalSurvey\Capabilities\UserCanDeleteEntries;
use TotalSurvey\Capabilities\UserCanDeleteSurvey;
use TotalSurvey\Capabilities\UserCanExportEntries;
use TotalSurvey\Capabilities\UserCanManageModules;
use TotalSurvey\Capabilities\UserCanManageOptions;
use TotalSurvey\Capabilities\UserCanUpdateSurvey;
use TotalSurvey\Capabilities\UserCanViewData;
use TotalSurvey\Capabilities\UserCanViewEntries;
use TotalSurvey\Capabilities\UserCanViewSurveys;
use TotalSurvey\Events\OnRoutesRegistered;
use TotalSurvey\Events\Surveys\OnDisplaySurvey;
use TotalSurvey\Events\Surveys\OnUpdateSurvey;
use TotalSurvey\Gutenberg\SurveyGutenbergBlock;
use TotalSurvey\Handlers\HandleDisplaySurvey;
use TotalSurvey\Handlers\HandleSurveyCronJobs;
use TotalSurvey\Models\Entry;
use TotalSurvey\Models\Preset;
use TotalSurvey\Models\Survey;
use TotalSurvey\Pages\Dashboard;
use TotalSurvey\Services\PluginServiceProvider;
use TotalSurvey\Tasks\Blocks\RegisterDefaultBlockTypes;
use TotalSurvey\Tasks\Entries\SetupViewEntryTemplate;
use TotalSurvey\Tasks\Presets\SetupPreviewPresetTemplate;
use TotalSurvey\Tasks\Reports\HandleSurveyReportCronJob;
use TotalSurvey\Tasks\Reports\RegisterReportIntervals;
use TotalSurvey\Tasks\Surveys\FlushRewriteRules;
use TotalSurvey\Tasks\Surveys\SetupViewSurveyTemplate;
use TotalSurvey\Tasks\Utils\AssurePaths;
use TotalSurvey\Tasks\Utils\AttachDefaultCapabilitiesToDefaultRoles;
use TotalSurvey\Tasks\Utils\DeleteUploadedFiles;
use TotalSurvey\Tasks\Utils\DetachDefaultCapabilitiesFromDefaultRoles;
use TotalSurvey\Tasks\Utils\HonorRequestLocale;
use TotalSurvey\Tasks\Utils\RegisterDefaultAssets;
use TotalSurvey\Tasks\Utils\WipeSurveysData;
use TotalSurvey\Widgets\Survey as SurveyWidget;
use TotalSurveyVendors\League\Container\ServiceProvider\ServiceProviderInterface;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Migration\Migrator;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Activation\Activate;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Activation\Check;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Activation\Unlink;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Activation\Upgrade;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Dashboard\Blog as GetBlogFeed;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Marketing\NPS;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Modules\Activate as ActivateModule;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Modules\Deactivate as DeactivateModule;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Modules\Index as GetModules;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Modules\Install as InstallModule;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Modules\Store;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Modules\Uninstall as UninstallModule;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Onboarding\Collect;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Options\Defaults as GetDefaults;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Options\Get as GetOptions;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Options\Reset as ResetOptions;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Options\Update as UpdateOptions;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Tracking\TrackFeatures;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Tracking\TrackScreens;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Plugin as AbstractPlugin;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Rest\Router;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Scheduler;

/**
 * Class Plugin
 *
 * @package TotalSurvey
 */
class Plugin extends AbstractPlugin
{
    /**
     * Initiate the plugin
     *
     * @throws Exception
     */
    public function run()
    {
        // Main admin page.
        new Dashboard();

        // Setup intervals
        RegisterReportIntervals::invoke();

        // Setup view survey mechanism
        SetupViewSurveyTemplate::invoke();

        // Setup view entry
        SetupViewEntryTemplate::invoke();

        // Setup preview preset mechanism
        SetupPreviewPresetTemplate::invoke();

        // Register block types
        RegisterDefaultBlockTypes::invoke();

        // Gutenberg
        SurveyGutenbergBlock::register();

        //Handlers
        OnDisplaySurvey::listen(HandleDisplaySurvey::class);
        OnUpdateSurvey::listen(new HandleSurveyCronJobs());

        // Cron jobs
        HandleSurveyReportCronJob::invoke();
        // Utils
        AssurePaths::invoke();
    }

    /**
     * @inheritDoc
     */
    public function getServiceProvider(): ServiceProviderInterface
    {
        return new PluginServiceProvider();
    }

    /**
     * @inheritDoc
     */
    public function registerRoutes(Router $router)
    {
        // Make sure that the locale (language) provided by the user is honored.
        HonorRequestLocale::invoke();

        // Onboarding
        $router->put('/admin/collect', Collect::class)
               ->capability(UserCanManageOptions::class);

        // Options
        $router->get('/admin/options', GetOptions::class)
               ->capability(UserCanManageOptions::class);
        $router->post('/admin/options', UpdateOptions::class)
               ->capability(UserCanManageOptions::class);
        $router->delete('/admin/options', ResetOptions::class)
               ->capability(UserCanManageOptions::class);
        $router->get('/admin/options/defaults', GetDefaults::class)
               ->capability(UserCanManageOptions::class);

        // Modules
        $router->get('/admin/modules', GetModules::class)
               ->capability(UserCanManageModules::class);
        $router->get('/admin/modules/store', Store::class)
               ->capability(UserCanManageModules::class);
        $router->post('/admin/modules/install', InstallModule::class)
               ->capability(UserCanManageModules::class);
        $router->patch('/admin/modules/activate', ActivateModule::class)
               ->capability(UserCanManageModules::class);
        $router->patch('/admin/modules/deactivate', DeactivateModule::class)
               ->capability(UserCanManageModules::class);
        $router->delete('/admin/modules/uninstall', UninstallModule::class)
               ->capability(UserCanManageModules::class);

        // Presets
        $router->get('/admin/presets/categories', Actions\Presets\Categories::class)
               ->capability(UserCanCreateSurvey::class);
        $router->get('/admin/presets', Actions\Presets\Index::class)
               ->capability(UserCanCreateSurvey::class);
        $router->get('/admin/presets', Actions\Presets\Get::class)
               ->capability(UserCanCreateSurvey::class);

        // Surveys
        $router->get('/survey', Actions\Surveys\GetPublic::class);

        $router->get('/admin/survey', Actions\Surveys\Index::class)
               ->capability(UserCanViewSurveys::class);

        $router->get('/admin/survey', Actions\Surveys\Get::class)
               ->capability(UserCanViewSurveys::class);

        $router->post('/admin/survey', Actions\Surveys\Create::class)
               ->capability(UserCanCreateSurvey::class);

        $router->put('/admin/survey', Actions\Surveys\Update::class)
               ->capability(UserCanUpdateSurvey::class);

        $router->delete('/admin/survey', Actions\Surveys\Delete::class)
               ->capability(UserCanDeleteSurvey::class);

        $router->get('/admin/survey/duplicate', Actions\Surveys\Duplicate::class)
               ->capability(UserCanCreateSurvey::class);

        $router->delete('/admin/survey/trash', Actions\Surveys\Trash::class)
               ->capability(UserCanDeleteSurvey::class);

        $router->delete('/admin/survey/reset', Actions\Surveys\Reset::class)
               ->capability(UserCanDeleteSurvey::class);

        $router->patch('/admin/survey/restore', Actions\Surveys\Restore::class)
               ->capability(UserCanDeleteSurvey::class);

        $router->patch('/admin/survey/enable', Actions\Surveys\Enable::class)
               ->capability(UserCanUpdateSurvey::class);

        $router->post('/survey/section', Section::class);

        // Entries
        $router->post('/entry', Actions\Entries\Create::class);
        $router->get('/entry', Actions\Entries\GetPublic::class);

        $router->get('/admin/entry', Actions\Entries\Index::class)
               ->capability(UserCanViewEntries::class);
        $router->get('/admin/entry', Actions\Entries\Get::class)
               ->capability(UserCanViewEntries::class);
        $router->delete('/admin/entry', Actions\Entries\Delete::class)
               ->capability(UserCanDeleteEntries::class);
        $router->post('/admin/entry/export', Actions\Entries\Export::class)
               ->capability(UserCanExportEntries::class);

        // Dashboard
        $router->get('/admin/dashboard/blog', GetBlogFeed::class)
               ->capability(UserCanViewData::class);
        $router->get('/admin/dashboard/activity', Actions\Dashboard\Activity::class)
               ->capability(UserCanViewData::class);

        // Marketing
        $router->post('/admin/marketing/nps', NPS::class)
               ->capability(UserCanManageOptions::class);

        // Tracking
        $router->post('/admin/tracking/features', TrackFeatures::class)
               ->capability(UserCanViewData::class);

        $router->post('/admin/tracking/screens', TrackScreens::class)
               ->capability(UserCanViewData::class);

        // Activation
        $router->post('/admin/activation', Activate::class)
               ->capability(UserCanManageOptions::class);

        $router->get('/admin/license', Check::class)
               ->capability(UserCanManageOptions::class);

        $router->post('/admin/license/unlink', Unlink::class)
               ->capability(UserCanManageOptions::class);

        $router->post('/admin/product/upgrade', Upgrade::class)
               ->capability(UserCanManageOptions::class);

        // Reports
        $router->post('/admin/report', SendNowReport::class)
               ->capability(UserCanManageOptions::class);

        // Register routes event
        OnRoutesRegistered::emit($router);
    }

    /**
     * @inheritDoc
     */
    public function registerShortCodes()
    {
        /**
         * Survey shortcode
         */
        new Shortcodes\Survey();
    }

    /**
     * @inheritDoc
     */
    public function registerAssets()
    {
        /**
         * Default assets
         */
        RegisterDefaultAssets::invoke();
    }

    /**
     * @inheritDoc
     */
    public function registerWidgets()
    {
        SurveyWidget::register();
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function onActivation()
    {
        define('TOTALSURVEY_ACTIVATING', true);

        /**
         * Migrations
         */
        Migrator::instance()->execute();

        /**
         * Capabilities
         */
        AttachDefaultCapabilitiesToDefaultRoles::invoke();

        /**
         * Rewrite rules
         */
        FlushRewriteRules::invoke();
    }

    /**
     * @inheritDoc
     */
    public function onDeactivation()
    {
        define('TOTALSURVEY_DEACTIVATING', true);

        /**
         * Capabilities
         */
        DetachDefaultCapabilitiesFromDefaultRoles::invoke();

        /**
         * Rewrite rules
         */
        FlushRewriteRules::invoke();

        /**
         * Scheduler
         */
        Scheduler::instance()->unregister();
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public static function onUninstall()
    {
        define('TOTALSURVEY_UNINSTALLING', true);

        /*
         * Data
         */
        $wipeData = (bool) static::options('uninstall.wipeOnUninstall', false);

        if ($wipeData) {
            DeleteUploadedFiles::invoke();
            WipeSurveysData::invoke();
        }

        /**
         * Capabilities
         */
        DetachDefaultCapabilitiesFromDefaultRoles::invoke();

        /**
         * Rewrite rules
         */
        FlushRewriteRules::invoke();

        /**
         * Scheduler
         */
        Scheduler::instance()->unregister();
    }

    /**
     * @return array
     */
    public function objectsCount()
    {
        return [
            'surveys' => Survey::count(),
            'entries' => Entry::count(),
            'presets' => Preset::count(),
        ];
    }
}
