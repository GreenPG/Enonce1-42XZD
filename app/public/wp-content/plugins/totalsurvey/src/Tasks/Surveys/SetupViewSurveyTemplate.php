<?php


namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Filters\Surveys\SurveyLinkFilter;
use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\View\Engine;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

class SetupViewSurveyTemplate extends Task
{
    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
        add_filter(
            'query_vars',
            static function ($queryVars) {
                $queryVars[] = 'survey_uid';
                $queryVars[] = 'survey_preset_uid';

                return $queryVars;
            }
        );
        add_action(
            'init',
            static function () {
                $base = SurveyLinkFilter::apply('survey');
                add_rewrite_rule("{$base}/([a-z0-9-]+)[/]?$", 'index.php?survey_uid=$matches[1]', 'top');
                add_rewrite_rule('survey-preset/([a-z0-9-]+)[/]?$', 'index.php?survey_preset_uid=$matches[1]', 'top');
            }
        );
        add_filter('template_include', [$this, 'handleTemplateRedirect']);
    }

    public function handleTemplateRedirect($template)
    {
        if ($surveyUid = get_query_var('survey_uid')) {
            try {
                echo ViewSurvey::invoke(
                    Manager::instance(),
                    Engine::instance(),
                    Survey::byUidAndActiveForRendering($surveyUid)
                );
            } catch (\Exception $exception) {
                wp_die($exception->getMessage(), get_bloginfo('name'));
            }

            exit;
        }

        return $template;
    }
}
