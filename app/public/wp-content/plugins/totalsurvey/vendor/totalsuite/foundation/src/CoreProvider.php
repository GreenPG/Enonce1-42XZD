<?php

namespace TotalSurveyVendors\TotalSuite\Foundation;
! defined( 'ABSPATH' ) && exit();


use Composer\Autoload\ClassLoader;
use TotalSurveyVendors\League\Container\Container;
use TotalSurveyVendors\League\Container\ServiceProvider\AbstractServiceProvider;
use TotalSurveyVendors\League\Container\ServiceProvider\BootableServiceProviderInterface;
use TotalSurveyVendors\League\Flysystem\Adapter\AbstractAdapter;
use TotalSurveyVendors\Rakit\Validation\Validator;
use TotalSurveyVendors\TotalSuite\Foundation\Contracts\CallableResolver;
use TotalSurveyVendors\TotalSuite\Foundation\Contracts\ExceptionHandler as ExceptionHandlerContract;
use TotalSurveyVendors\TotalSuite\Foundation\Contracts\TrackingStorage;
use TotalSurveyVendors\TotalSuite\Foundation\CronJobs\CheckLicense;
use TotalSurveyVendors\TotalSuite\Foundation\CronJobs\TrackEnvironment;
use TotalSurveyVendors\TotalSuite\Foundation\CronJobs\TrackEvents;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Connection;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query;
use TotalSurveyVendors\TotalSuite\Foundation\Filesystem\WordPressAdapter;
use TotalSurveyVendors\TotalSuite\Foundation\Http\CookieJar;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Request;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ServerContext;
use TotalSurveyVendors\TotalSuite\Foundation\Migration\Migrator;
use TotalSurveyVendors\TotalSuite\Foundation\Validators\DateFormatRule;
use TotalSurveyVendors\TotalSuite\Foundation\Validators\StringRule;
use TotalSurveyVendors\TotalSuite\Foundation\View\Engine;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\ActionBus;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\ActionEmitter;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Admin\Page;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Admin\UninstallFeedback;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Database\WPConnection;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Rest\ActionResolver;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Rest\Router;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Scheduler;

/**
 * Class CoreProvider
 *
 * @package TotalSuite\Foundation
 */
class CoreProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    /**
     * @var array
     */
    protected $provides = [
        ClassLoader::class,
        ExceptionHandlerContract::class,
        Connection::class,
        Filesystem::class,
        Options::class,
        Manager::class,
        Request::class,
        Emitter::class,
        CallableResolver::class,
        Router::class,
        Engine::class,
        Migrator::class,
        Validator::class,
        Scheduler::class,
        TrackingStorage::class,
        CookieJar::class,
    ];

    /**
     * @inheritDoc
     */
    public function register()
    {
        /**
         * @var Container $container
         */
        $container = $this->getContainer();

        /**
         * @var Environment $env
         */
        $env = $container->get(Environment::class);

        // Class loader
        $container->share(
            ClassLoader::class,
            static function () use ($env) {
                return $env['loader'];
            }
        );

        // Exception
        $container->share(
            ExceptionHandlerContract::class,
            static function () use ($env) {
                return new ExceptionHandler($env);
            }
        );

        // Filesystem
        $container->share(
            Filesystem::class,
            static function () use ($env) {
                $adapter = new WordPressAdapter($env->get('path.base'));
                $filesystem = new Filesystem($adapter, ['visibility' => AbstractAdapter::VISIBILITY_PUBLIC]);
                $filesystem->addPlugin(new Filesystem\Plugins\GlobPlugin());
                $filesystem->addPlugin(new Filesystem\Plugins\JsonPlugin());

                return $filesystem;
            }
        );

        // Plugins Options
        $container->share(Options::class)
                  ->addArgument($env['stores.optionsKey'])
                  ->addArgument($env->get('defaults.options', []));

        // Plugins License
        $container->share(License::class, function () {
            return new License('totalsuite_license', License::getDefault());
        });

        // Tracking Options
        $container->share(TrackingStorage::class, function () {
            return Options::instance()->withKey(Plugin::env('stores.trackingKey'), [
                'screens' => [],
                'features' => []
            ]);
        });

        // Module manager
        $container->share(Manager::class, Manager::class)
                  ->addArgument($container)
                  ->addArgument($env)
                  ->addArgument($container->get(Filesystem::class))
                  ->addArgument($container->get(Options::class)->withKey($env['stores.modulesKey']))
                  ->addArgument($container->get(ClassLoader::class));

        // Server Request
        $container->share(
            Request::class,
            static function () {
                return Request::createFromServer(ServerContext::create($_SERVER));
            }
        );

        // Cookie jar
        $container->share(CookieJar::class, static function () {
            return CookieJar::createFromServer();
        });

        // Event Emitter
        $container->share(
            Emitter::class,
            static function () {
                $emitter = new ActionEmitter();
                $emitter->addListener('*', new ActionBus(), ActionEmitter::P_LOW);
                return $emitter;
            }
        );

        // Route Callable Resolver
        $container->share(
            CallableResolver::class,
            static function () use ($container) {
                return new ActionResolver($container);
            }
        );

        // Router
        $container->share(Router::class)
                  ->addArgument($container->get(CallableResolver::class))
                  ->addArgument($env->get('namespaces.rest', $env->get('product.id')))
                  ->addArgument($container->get(ExceptionHandlerContract::class));

        // Scheduler
        $container->share(Scheduler::class, function () {
            $productId = Plugin::env('product.id');

            $scheduler = new Scheduler();
            $scheduler->addCronJob("{$productId}_weekly_environment", new TrackEnvironment());
            $scheduler->addCronJob("{$productId}_daily_activity", new TrackEvents());
            $scheduler->addCronJob('totalsuite_check_license', new CheckLicense());

            return $scheduler;
        });

        // Validator
        $container->share(
            Validator::class,
            static function () {
                $validator = new Validator();
                $validator->addValidator('string', new StringRule());
                $validator->addValidator('dateFormat', new DateFormatRule());

                return $validator;
            }
        );

        // Migrator
        $container->share(Migrator::class)->addArgument($container);

        // Uninstall feedback
        $container->share(UninstallFeedback::class, new UninstallFeedback());
    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
        /**
         * @var Container $container
         */
        $container = $this->getContainer();

        /**
         * @var Environment $env
         */
        $env = $container->get(Environment::class);

        // Database
        $container->share(
            Connection::class,
            static function () use ($env) {
                return new WPConnection(DB_NAME, $env->get('db.prefix', 'wp_'));
            }
        );

        // Template Engine
        $container->share(
            Engine::class,
            static function () use ($env) {
                $engine = new Engine($env->get('path.base') . 'views');
                $engine->addFolder('marketing', dirname(__DIR__) . '/views/marketing');

                return $engine;
            }
        );

        // Initialize Model
        Query::setConnection($container->get(Connection::class));

        // Initialize View Engine
        Page::setEngine($container->get(Engine::class));
    }
}
