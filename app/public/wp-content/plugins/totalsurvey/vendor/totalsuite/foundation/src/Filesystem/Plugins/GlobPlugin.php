<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Filesystem\Plugins;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\League\Flysystem\FilesystemInterface;
use TotalSurveyVendors\League\Flysystem\PluginInterface;

/**
 * Class GlobPlugin
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Filesystem\Plugins
 */
class GlobPlugin implements PluginInterface
{
    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * @param     $pattern
     * @param int $flag
     *
     * @return array|false
     */
    public function handle($pattern, $flag = 0)
    {
        $prefix = $this->filesystem->getAdapter()->getPathPrefix();
        return glob($prefix . ltrim($pattern, DIRECTORY_SEPARATOR), $flag);
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return 'glob';
    }

    /**
     * @inheritDoc
     */
    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }
}
