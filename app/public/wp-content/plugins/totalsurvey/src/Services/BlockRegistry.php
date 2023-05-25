<?php

namespace TotalSurvey\Services;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Blocks\BlockType;
use TotalSurvey\Blocks\DefaultBlockType;
use TotalSurvey\Exceptions\Blocks\BlockException;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Concerns\ResolveFromContainer;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

/**
 * Class BlockRegistry
 *
 * @package TotalSurvey
 */
class BlockRegistry
{
    use ResolveFromContainer;

    /**
     * @var Collection<BlockType>|BlockType[]
     */
    protected $blockTypes;

    public function __construct()
    {
        $this->blockTypes = Collection::create();
    }

    /**
     * @param  string|BlockType  $class
     *
     * @throws Exception
     */
    public function registerType($class, $aliases = [])
    {
        if (!class_exists($class)) {
            BlockException::throw(sprintf('Class not found (%s)', $class));
        }

        if (!is_a($class, BlockType::class, true)) {
            BlockException::throw(sprintf('Field must extends %s class', BlockType::class));
        }

        if ($this->blockTypes->has($class::getTypeId())) {
            BlockException::throw(sprintf('Field type %s is already registered', $class::getTypeId()));
        }

        $this->blockTypes[$class::getTypeId()] = $class;
        foreach ($class::$aliases as $alias) {
            $this->blockTypes[$alias] = $class;
        }

        return true;
    }

    /**
     * @param  string  $typeId
     *
     * @param  string  $fallback
     *
     * @return BlockType
     */
    public function getBlockType($typeId, $fallback = DefaultBlockType::class)
    {
        return $this->blockTypes->get($typeId, $fallback);
    }

    /**
     * @param $class
     *
     * @return bool
     * @throws Exception
     */
    public static function register($class)
    {
        return static::instance()->registerType($class);
    }

    /**
     * @param $typeId
     *
     * @param  string  $fallback
     *
     * @return BlockType
     */
    public static function blockTypeFrom($typeId, $fallback = DefaultBlockType::class)
    {
        return static::instance()->getBlockType($typeId, $fallback);
    }
}
