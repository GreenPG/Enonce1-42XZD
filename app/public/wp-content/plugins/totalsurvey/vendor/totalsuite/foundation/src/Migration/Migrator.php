<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Migration;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\League\Container\Container;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Connection;
use TotalSurveyVendors\TotalSuite\Foundation\Environment;
use TotalSurveyVendors\TotalSuite\Foundation\Filesystem;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Concerns\ResolveFromContainer;
use TotalSurveyVendors\TotalSuite\Foundation\Migration\Concerns\MigrationQueue;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Database\WPConnection;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;

/**
 * Class Migrator
 * @package TotalSurveyVendors\TotalSuite\Foundation\Migration
 */
class Migrator
{
    use MigrationQueue, ResolveFromContainer;

    /**
     * @var Environment
     */
    protected $env;

    /**
     * @var WPConnection
     */
    protected $connection;

    /**
     * @var Filesystem
     */
    protected $fs;

    /**
     * @var Options
     */
    protected $options;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $currentVersion;

    /**
     * Migrator constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->env = $container->get(Environment::class);
        $this->connection = $container->get(Connection::class);
        $this->path = $this->env->get('path.migrations');
        $this->fs = $container->get(Filesystem::class)->withPrefix($this->path);
        $this->options = $container->get(Options::class)->withKey($this->env->get('stores.versionKey'));
        $this->container = $container;

        $this->currentVersion = $this->options->get('version');

        $this->fetchMigrations();
    }

    public function execute()
    {
        if (empty($this->migrations)) {
            return;
        }

        $currentVersion = null;
        $previousVersion = null;

        foreach ($this->migrations as $currentVersion => $migration) {
            $instance = $this->loadMigration($migration, $previousVersion);
            $instance->run();
            $previousVersion = $currentVersion;
        }

        $this->options->fill([
            'version' => $currentVersion,
            'date' => date('Y-m-d H:i:s')
        ])->save();

        $this->currentVersion = $currentVersion;
    }

}