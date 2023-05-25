<?php

namespace TotalSurvey\Jobs;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Tasks\Workflow\AbstractWorkflowTask;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

/**
 * Class JobDefinition
 *
 * @package TotalSurvey\Models
 *
 * @property string $uid
 * @property string $tag
 * @property AbstractWorkflowTask|string $class
 * @property string $label
 */
class JobDefinition extends Model
{
    /**
     * @var array
     */
    protected $types = [
        'arguments' => 'arguments',
    ];

    /**
     * @param mixed $arguments
     *
     * @return Collection
     * @noinspection PhpUnused
     */
    public function castToArguments($arguments): Collection
    {
        return Collection::create($arguments);
    }
}
