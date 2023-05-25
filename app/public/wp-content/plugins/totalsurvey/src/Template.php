<?php

namespace TotalSurvey;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Filters\SurveyCustomCssFilter;
use TotalSurvey\Models\Survey;
use TotalSurveyVendors\League\Container\Container;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Definition;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Template as BaseTemplate;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;

/**
 * Class Template
 *
 * @package TotalSurvey
 */
abstract class Template extends BaseTemplate
{
    /**
     * @var Options
     */
    protected $options;

    /**
     * @var FieldManager
     */
    protected $fields;

    /**
     * Template constructor.
     *
     * @param Definition $definition
     * @param Container $container
     */
    public function __construct(Definition $definition, Container $container)
    {
        parent::__construct($definition, $container);
        $this->options = $this->container->get(Options::class);
        $this->fields  = $this->container->get(FieldManager::class);
    }

    /**
     * @param Survey $survey
     *
     * @param string $template
     *
     * @return string
     */
    public function render(Survey $survey, $template = 'survey'): string
    {
        // reCaptcha integration
        if ($this->options->get('advanced.recaptcha.enabled', false)) {
            wp_enqueue_script('recaptcha-v3', 'https://www.google.com/recaptcha/api.js?render=' . $this->options->get('advanced.recaptcha.key'), [], null);
        }

        // Generate nonce
        $nonce = is_user_logged_in() ? wp_create_nonce('wp_rest') : null;

        // Share data
        $this->engine->addData(
            [
                'survey'    => $survey,
                'fields'    => $this->fields,
                'options'   => [
                    'recaptcha' => [
                        'enabled' => $this->options->get('advanced.recaptcha.enabled'),
                        'key'     => $this->options->get('advanced.recaptcha.key'),
                    ],
                ],
                'nonce'     => $nonce,
                'apiBase'   => rest_url(Plugin::env('url.apiBase')),
                'customCss' => SurveyCustomCssFilter::apply($survey->getDesignSettings('customCss', '')),
            ]
        );

        return $this->view($template);
    }

    public function getEngine() {
        return $this->engine;
    }
}
