<?php
namespace TotalSurvey\Tasks\Utils;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\Filesystem;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

class DeleteUploadedFiles extends Task
{
    /**
     * @var string
     */
    protected $dir;

    /**
     * DeleteUploadedFiles constructor.
     *
     * @param  string  $dir
     */
    public function __construct(string $dir = '')
    {
        $this->dir = $dir;
    }


    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
        $root = Plugin::env('path.userUploads');

        if (empty($this->dir)) {
            $this->dir = basename($root);
            $root      = dirname($root);
        }

        /**
         * @var Filesystem $fs
         */
        $fs = Plugin::get(Filesystem::class)
                    ->withPrefix($root);

        if ($fs->has($this->dir)) {
            return $fs->deleteDir($this->dir);
        }

        return false;
    }
}
