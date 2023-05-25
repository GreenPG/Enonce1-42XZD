<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Filesystem;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\League\Flysystem\Adapter\CanOverwriteFiles;
use TotalSurveyVendors\League\Flysystem\Adapter\Local;

/**
 * Class LocalAdapter
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Filesystem
 */
class LocalAdapter extends Local implements CanOverwriteFiles
{

}