<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\View\Engine;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

/**
 * Class ViewSuvey
 *
 * @package TotalSurvey\Tasks\Survey
 */
class ViewSurvey extends Task
{
    /**
     * @var string
     */
    protected $survey;

    /**
     * @var Engine
     */
    protected $engine;

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * ViewSuvey constructor.
     *
     * @param  Manager  $manager
     * @param  Engine  $engine
     * @param  Survey  $survey
     */
    public function __construct(Manager $manager, Engine $engine, Survey $survey)
    {
        $this->survey  = $survey;
        $this->manager = $manager;
        $this->engine  = $engine;
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
     * @throws Exception
     * @throws \Exception
     */
    protected function execute()
    {
        UserCanAccessSurvey::invoke($this->survey);

        $renderedSurvey = DisplaySurvey::invoke($this->survey);

        // Add survey to the title
        add_filter(
            'wp_title_parts',
            function ($parts) {
                array_unshift($parts, $this->survey->name);

                return $parts;
            }
        );
        
        // Add description meta tag
        add_action(
            'wp_head',
            function () {
                if ($this->survey->isPreview()) {
                    show_admin_bar(false);
                }
                printf('<meta name="description" content="%s">'.PHP_EOL, $this->survey->description);
            },
            1
        );

        // Render view
        return $this->engine->render(
            'survey',
            ['survey' => $this->survey, 'content' => $renderedSurvey]
        );
    }
}
