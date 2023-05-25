<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Tasks\Presets\CreatePreset;
use TotalSurveyVendors\League\Container\Container;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Connection;
use TotalSurveyVendors\TotalSuite\Foundation\Filesystem;
use TotalSurveyVendors\TotalSuite\Foundation\Migration\Migration;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Database\WPConnection;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;

/**
 * @class Anonymous migration class
 *
 * @param Container $container
 * @param           $path
 * @param           $previousVersion
 *
 * @return Migration
 */
return function (Container $container, $path, $previousVersion) {
    return new class($container, $path, $previousVersion) extends Migration {

        protected $version = '1.1.0';

        /**
         * @var Filesystem
         */
        protected $fs;

        /**
         * @var WPConnection
         */
        protected $db;

        /**
         * @var Options
         */
        protected $options;

        /**
         *  constructor.
         *
         * @param Container $container
         * @param           $path
         * @param           $previousVersion
         */
        public function __construct(Container $container, $path, $previousVersion)
        {
            parent::__construct($container, $path, $previousVersion);

            $this->db = $this->container->get(Connection::class);
        }


        public function applySchemaAndDefaultPresets()
        {
            $schema = $this->fs->glob('/schema/*.sql');

            foreach ($schema as $file) {
                $sql = str_replace('{{prefix}}', $this->db->getTablePrefix(), file_get_contents($file));
                $this->db->raw(trim($sql));
            }

            $files = $this->fs->glob('/data/*.php');

            try {
                foreach ($files as $file) {
                    $preset = (array)(include $file);
                    CreatePreset::invoke($preset);
                }
            } catch (Exception $e) {
            }
        }
    };
};