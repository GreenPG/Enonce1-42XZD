<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();



use Exception;
use TotalSurvey\Filters\Surveys\SurveyPreRenderFilter;
use TotalSurvey\Models\Survey;
use TotalSurvey\Plugin;
use TotalSurvey\Tasks\Utils\GetAllowedSurveyTags;
use TotalSurvey\Views\Template;
use TotalSurveyVendors\TotalSuite\Foundation\Contracts\Support\HTMLRenderable;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class RenderSurvey
 *
 * @package TotalSurvey\Tasks\Survey
 */
class RenderSurvey extends Task
{
    /**
     * @var Survey
     */
    protected $survey;
    /**
     * @var Template
     */
    protected $template;

    /**
     * RenderSurvey constructor.
     *
     * @param  Template  $template
     * @param  Survey  $survey
     */
    public function __construct(Template $template, Survey $survey)
    {
        $this->survey   = $survey;
        $this->template = $template;
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
     */
    protected function execute()
    {
        try {
            $survey   = SurveyPreRenderFilter::apply($this->survey);
            $rendered = $this->template->render($survey);
        } catch (Exception $exception) {
            if ($exception instanceof HTMLRenderable) {
                $rendered = $exception->toHTML();
            } else {
                $rendered = Html::create('p', [], $exception->getMessage());
            }
        }

        $wrapper = Html::create(
            'div',
            [
                'id'              => "totalsurvey-{$this->survey->uid}",
                'data-survey-uid' => $this->survey->uid,
                'class'           => 'totalsurvey-wrapper',
            ],
            Html::create(
                'div',
                ['class' => 'totalsurvey-loading',],
                Html::create('div', ['class' => 'totalsurvey-loading-spinner',])
            )
        );

        wp_enqueue_style('totalsurvey-loading');

        $callback = function () use ($rendered, $survey) {
            echo wp_kses($rendered, GetAllowedSurveyTags::invoke());
        };

        add_action('wp_footer', $callback); // Frontend
        add_action('admin_footer', $callback); // Backoffice

        if (Plugin::options('general.showCredits', false)) {
            $credit = Html::create(
                'div',
                [
                    'class' => 'totalsurvey-credits',
                    'style' => 'font-family: sans-serif; font-size: 9px; text-transform: uppercase;text-align: center; padding: 10px 0;',
                ],
                sprintf(
                    __('Powered by %s', 'totalsurvey'),
                    Html::create('a', ['href' => 'https://totalsuite.net/products/totalsurvey'], 'totalsurvey')
                )
            );

            return $wrapper->addContent($credit);
        }

        return $wrapper->render();
    }
}
