<?php


namespace TotalSurvey\Tasks;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Condition;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class ProcessCondition
 *
 * @package TotalSurvey\Tasks
 *
 * @method static boolean invoke($input, $operator, $value)
 * @method static boolean invokeWithFallback($fallback, mixed $input, $operator, $value)
 */
class ProcessCondition extends Task
{
    /**
     * @var mixed
     */
    protected $input;

    /**
     * @var string
     */
    protected $operator;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * ProcessCondition constructor.
     *
     * @param  mixed  $input
     * @param  mixed  $operator
     * @param  mixed  $value
     */
    public function __construct($input, $operator, $value)
    {
        $this->input    = $input;
        $this->operator = $operator;
        $this->value    = (array) $value;
    }


    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
        $input = current((array) $this->input);
        switch ($this->operator) {
            case Condition::OPERATOR_EQUALS :
            {
                return $input == $this->value[0];
            }
            case Condition::OPERATOR_NOT_EQUALS :
            {
                return $input != $this->value[0];
            }
            case Condition::OPERATOR_LESS_THAN :
            {
                return $input < $this->value[0];
            }
            case Condition::OPERATOR_GREATER_THAN :
            {
                return $input > $this->value[0];
            }
            case Condition::OPERATOR_IN :
            {
                $compare = array_intersect((array) $this->input, $this->value);

                return !empty($compare);
            }
            case Condition::OPERATOR_NOT_IN :
            {
                $compare = array_intersect((array) $this->input, $this->value);

                return empty($compare);
            }
            case Condition::OPERATOR_CONTAINS :
            {
                return mb_stripos($input, $this->value[0]) !== false;
            }
            case Condition::OPERATOR_NOT_CONTAINS :
            {
                return mb_stripos($input, $this->value[0]) === false;
            }
        }

        return false;
    }
}
