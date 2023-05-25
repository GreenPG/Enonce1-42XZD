<?php

namespace TotalSurvey\Views;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Filters\Surveys\SurveyAfterContentFilter;
use TotalSurvey\Filters\Surveys\SurveyAssetsFilter;
use TotalSurvey\Filters\Surveys\SurveyBeforeContentFilter;
use TotalSurvey\Filters\Surveys\SurveyCustomCssFilter;
use TotalSurvey\Models\Entry;
use TotalSurvey\Models\Survey;
use TotalSurvey\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Template as BaseTemplate;

/**
 * Class Template
 *
 * @package TotalSurvey
 */
abstract class Template extends BaseTemplate
{
    /**
     * @param  Survey  $survey
     *
     * @param  string  $template
     *
     * @return string
     */
    public function render(Survey $survey, string $template = 'survey'): string
    {
        // reCaptcha integration
        if (Plugin::options('advanced.recaptcha.enabled', false)) {
            wp_enqueue_script(
                'recaptcha-v3',
                sprintf("https://www.google.com/recaptcha/api.js?render=%s", Plugin::options('advanced.recaptcha.key')),
                [],
                null
            );
        }

        // Generate nonce
        $nonce = is_user_logged_in() ? wp_create_nonce('wp_rest') : null;

        // Share data
        $this->engine->addData(
            [
                'survey'    => $survey,
                'options'   => [
                    'recaptcha' => [
                        'enabled' => Plugin::options('advanced.recaptcha.enabled'),
                        'key'     => Plugin::options('advanced.recaptcha.key'),
                    ],
                ],
                'language'  => get_locale(),
                'nonce'     => $nonce,
                'apiBase'   => rest_url(Plugin::env('url.apiBase')),
                'customCss' => SurveyCustomCssFilter::apply($survey->getCustomCss()),
                'before'    => SurveyBeforeContentFilter::apply(''),
                'after'     => SurveyAfterContentFilter::apply(''),
                'assets'    => SurveyAssetsFilter::apply(
                    [
                        'css' => [
                            'template' => $this->getUrl('assets/css/style.css'),
                        ],
                        'js'  => [],
                    ]
                ),
            ]
        );

        return $this->view($template);
    }

    public function renderEntry(Entry $entry, $template = 'entry'): string
    {
        $this->engine->addData(
            [
                'entry'  => $entry,
                'survey' => $entry->survey(),
                'assets' => SurveyAssetsFilter::apply(
                    [
                        'css' => [
                            'template' => $this->getUrl('assets/css/style.css'),
                        ],
                        'js'  => [],
                    ]
                ),
            ]

        );

        return $this->view($template);
    }

    public function renderInsights(Survey $survey, $sections, $embed, $template = 'insights'): string
    {
        $this->engine->addData(
            [

                'surveyUid' => $survey->uid,
                'survey'    => $survey,
                'sections'  => $sections,
                'embed'     => $embed,
                'customCss' => SurveyCustomCssFilter::apply($survey->getCustomCss()),
                'before'    => '',
                'after'     => '',
                'assets'    => SurveyAssetsFilter::apply(
                    [
                        'css' => [
                            'template' => $this->getUrl('assets/css/style.css'),
                        ],
                        'js'  => [],
                    ]
                ),
            ]

        );

        return $this->view($template);
    }

    public function getEngine()
    {
        return $this->engine;
    }
}
