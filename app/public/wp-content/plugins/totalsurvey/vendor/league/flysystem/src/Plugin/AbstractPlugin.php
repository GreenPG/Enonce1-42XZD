<?php

namespace TotalSurveyVendors\League\Flysystem\Plugin;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\League\Flysystem\FilesystemInterface;
use TotalSurveyVendors\League\Flysystem\PluginInterface;

abstract class AbstractPlugin implements PluginInterface
{
    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * Set the Filesystem object.
     *
     * @param FilesystemInterface $filesystem
     */
    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }
}
