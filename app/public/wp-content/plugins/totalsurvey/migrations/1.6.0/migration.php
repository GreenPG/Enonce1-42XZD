<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Tasks\Surveys\FlushRewriteRules;
use TotalSurveyVendors\League\Container\Container;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Connection;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Filesystem;
use TotalSurveyVendors\TotalSuite\Foundation\Migration\Migration;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Database\WPConnection;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;

/**
 * @class Anonymous migration class
 *
 * @param  Container  $container
 * @param           $path
 * @param           $previousVersion
 *
 * @return Migration
 */
return function (Container $container, $path, $previousVersion) {
    return new class($container, $path, $previousVersion) extends Migration {

        protected $version = '1.6.0';

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
         * @param  Container  $container
         * @param           $path
         * @param           $previousVersion
         */
        public function __construct(Container $container, $path, $previousVersion)
        {
            parent::__construct($container, $path, $previousVersion);

            $this->db = $this->container->get(Connection::class);
        }

        public function applySchema()
        {
            $schema = $this->fs->glob('/schema/*.sql');

            foreach ($schema as $file) {
                $sql = str_replace('{{prefix}}', $this->db->getTablePrefix(), file_get_contents($file));
                $this->db->raw(trim($sql));
            }

            FlushRewriteRules::invoke();

            try {
                Manager::instance()->activate('limitations-extension');
            } catch (Exception $exception){
                // In case of regular version, the extension is not there thus an exception is thrown.
            }
        }
    };
};
