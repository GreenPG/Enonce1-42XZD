<?php

namespace TotalSurvey\Jobs;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Blocks\BlockType;
use TotalSurvey\Blocks\DefaultBlockType;
use TotalSurvey\Exceptions\Blocks\BlockException;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Concerns\ResolveFromContainer;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

/**
 * Class JobScheduler
 *
 * @package TotalSurvey
 */
class JobScheduler
{
    use ResolveFromContainer;

    /**
     * @var Collection<JobDefinition>|JobDefinition[]
     */
    protected $jobs;

    public function __construct()
    {
        $this->jobs = Collection::create();
    }

    /**
     * @param  string|BlockType  $class
     *
     * @throws Exception
     */
    public function registerJob($class)
    {
        if (!class_exists($class)) {
            BlockException::throw(sprintf('Class not found (%s)', $class));
        }

        if (!is_a($class, BlockType::class, true)) {
            BlockException::throw(sprintf('Field must extends %s class', BlockType::class));
        }

        if ($this->jobs->has($class::getTypeId())) {
            BlockException::throw(sprintf('Field type %s is already registered', $class::getTypeId()));
        }

        $this->jobs[$class::getTypeId()] = $class;

        return true;
    }

    /**
     * @param $class
     *
     * @return bool
     * @throws Exception
     */
    public static function register($class)
    {
        return static::instance()->registerJob($class);
    }
}
