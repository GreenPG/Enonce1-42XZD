<?php

namespace TotalSurvey\Tasks\Presets;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Preset;
use TotalSurvey\Tasks\Surveys\ViewSurvey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\View\Engine;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

class PreviewPreset extends Task
{
    /**
     * @var string
     */
    protected $presetUid;

    /**
     * PreviewPreset constructor.
     *
     * @param  string  $presetUid
     */
    public function __construct(string $presetUid)
    {
        $this->presetUid = $presetUid;
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
        $preset = Preset::getByUid($this->presetUid);
        $preset->survey->setAttribute('preview', true);
        $preset->survey->setAttribute('enabled', true);

        return ViewSurvey::invoke(Manager::instance(), Engine::instance(), $preset->survey);
    }
}
