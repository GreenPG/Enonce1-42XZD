<?php

namespace TotalSurvey\Templates\DefaultTemplate;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurvey\Plugin;
use TotalSurvey\Views\Template;

class Module extends Template
{

    protected function registerSurveyScripts()
    {
        wp_enqueue_script(
            'totalsurvey-default-template',
            Plugin::env()->isDebug() ? $this->getUrl('assets/js/app.js') : $this->getUrl('assets/js/app.min.js'),
            ['totalsurvey-vue-js'],
            Plugin::env('version'),
            true
        );
    }

    protected function registerInsightsScripts()
    {
        wp_enqueue_script(
            'totalsurvey-insights-default-template',
            Plugin::env()->isDebug() ? $this->getUrl('assets/js/insights/app-insights.js') : $this->getUrl(
                'assets/js/insights/app-insights.min.js'
            ),
            ['totalsurvey-vue-js', 'chart-js'],
            Plugin::env('version'),
            true
        );
    }

    /**
     * @param  Survey  $survey
     *
     * @param  string  $template
     *
     * @return string
     */
    public function render(Survey $survey, $template = 'survey'): string
    {
        $this->registerSurveyScripts();

        return parent::render($survey, $template);
    }

    /**
     * @param   $survey_uid
     * @param   $sections
     * @param $embed
     * @param  string  $template
     *
     * @return string
     */
    public function renderInsights($survey_uid, $sections, $embed, $template = 'insights'): string
    {
        $this->registerInsightsScripts();

        return parent::renderInsights($survey_uid, $sections, $embed, $template);
    }

}
