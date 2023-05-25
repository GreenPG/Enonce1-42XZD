<?php

namespace TotalSurvey\Tasks\Sections;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Section;
use TotalSurvey\Services\SurveyValidator;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\ValidationException;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

class ValidateSection extends Task
{
    /**
     * @var Section
     */
    protected $section;

    /**
     * @var array
     */
    protected $entry;

    /**
     * ValidateSection constructor.
     *
     * @param  Section  $section
     * @param  Collection|array  $entry
     *
     */
    public function __construct(Section $section, $entry)
    {
        $this->section = $section;
        $this->entry   = $entry;
    }


    protected function validate()
    {
        return true;
    }

    /**
     * @return mixed|void
     * @throws Exception
     */
    protected function execute()
    {
        if (!$this->section->blocks->isEmpty()) {
            $validation = SurveyValidator::instance()->validateSection($this->section, $this->entry);

            if ($validation->fails()) {
                ValidationException::throw(
                    __('Validation errors', 'totalsurvey'),
                    $this->getErrorsFromValidation($validation)
                );
            }
        }

        return true;
    }

    /**
     * @param  \TotalSurveyVendors\Rakit\Validation\Validation  $validation
     *
     * @return array
     */
    protected function getErrorsFromValidation(\TotalSurveyVendors\Rakit\Validation\Validation $validation)
    {
        $errors = [];
        foreach ($validation->errors->toArray() as $field => $error) {
            $errors[$field] = array_values((array) $error);
        }

        return $errors;
    }
}
