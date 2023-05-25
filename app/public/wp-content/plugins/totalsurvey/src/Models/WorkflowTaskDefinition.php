<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Tasks\Workflow\AbstractWorkflowTask;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;

/**
 * Class WorkflowTaskDefinition
 *
 * @package TotalSurvey\Models
 *
 * @property string                      $id
 * @property AbstractWorkflowTask|string $class
 * @property string                      $label
 */
class WorkflowTaskDefinition extends Model
{

}
