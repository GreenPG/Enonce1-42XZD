<?php


namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Activation;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\License;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

class RemoveLicense extends Task
{
    protected function validate()
    {
    }

    protected function execute()
    {
        License::instance()->reset();
    }
}