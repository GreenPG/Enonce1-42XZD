<?php


namespace TotalSurvey\Tasks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Plugin;
use TotalSurveyVendors\Rakit\Validation\Validator;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\ValidationException;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class Validation
 *
 * @package TotalSurvey\Tasks
 */
class Validation extends Task
{

    /**
     * @var Validator
     */
    protected $validator;
    /**
     * @var array
     */
    private $rules;
    /**
     * @var array
     */
    private $data;
    /**
     * @var array
     */
    private $messages;

    /**
     * Validation constructor.
     *
     * @param array $rules
     * @param array $data
     * @param array $messages
     */
    public function __construct(array $rules, array $data, array $messages = [])
    {
        $this->validator = Plugin::get(Validator::class);
        $this->rules     = $rules;
        $this->data      = $data;
        $this->messages  = $messages;
    }

    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @inheritDoc
     * @throws ValidationException
     */
    protected function execute()
    {
        $validation = $this->validator->make($this->data, $this->rules, $this->messages);
        $validation->validate();

        if ($validation->fails()) {
            throw new ValidationException('Validation failed', $validation->errors->toArray());
        }
    }
}
