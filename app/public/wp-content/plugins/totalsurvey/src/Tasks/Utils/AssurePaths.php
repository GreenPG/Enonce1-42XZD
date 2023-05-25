<?php

namespace TotalSurvey\Tasks\Utils;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\Contracts\Database\Connection;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

class AssurePaths extends Task
{
    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
        $paths = [
            Plugin::env('path.userUploads'),
            Plugin::env('path.userReports')
        ];

        foreach ($paths as $path){
            wp_mkdir_p($path);
            if (!file_exists("$path/index.html")) {
                file_put_contents("$path/index.html", '');
            }
        }
    }
}
