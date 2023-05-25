<?php

namespace TotalSurvey\Tasks\Presets;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Preset;
use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Strings;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\ValidateInput;

class CreatePreset extends Task
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * Create constructor.
     *
     * @param array $data
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
                'name'        => 'string',
                'description' => 'string',
                'category'    => 'string',
                'source'      => 'string',
                'thumbnail'   => 'string',
                'survey'      => 'array',
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
                'category',
                'source',
                'thumbnail',
                'survey'
            ]
        );


        $preset = new Preset();
        $preset->fillAttributes($data);
        $preset->uid = Strings::uid();

        Exception::throwUnless($preset->save(), 'Could not create the preset');

        return $preset;
    }
}