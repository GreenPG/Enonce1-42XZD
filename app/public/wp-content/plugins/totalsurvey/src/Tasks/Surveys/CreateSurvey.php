<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Strings;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\ValidateInput;

/**
 * Class CreateSurvey
 *
 * @package TotalSurvey\Tasks\Survey
 * @method static Survey invoke(array $data)
 * @method static Survey invokeWithFallback($fallback, array $data)
 */
class CreateSurvey extends Task
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * Create constructor.
     *
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function validate()
    {
        return ValidateInput::invoke(
            [
                'name'         => 'string|max:255',
                'description'  => 'string',
                'sections'     => 'array',
                'settings'     => 'array',
                'translations' => 'array',
            ],
            $this->data
        );
    }

    /**
     * @return false|mixed|Survey
     * @throws Exception
     * @throws DatabaseException
     * @throws \Exception
     */
    public function execute()
    {
        $data = Arrays::only(
            $this->data,
            [
                'name',
                'description',
                'sections',
                'settings',
                'translations',
                'enabled',
                'status',
            ]
        );

        $data['uid']     = Strings::uid();
        $data['user_id'] = get_current_user_id();
        $data['status']  = Survey::STATUS_OPEN;

        $survey = Survey::create($data);
        Exception::throwUnless($survey, 'Could not create the survey');

        return $survey;
    }
}
