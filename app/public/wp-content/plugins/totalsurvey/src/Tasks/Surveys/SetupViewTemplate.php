<?php


namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurvey\Plugin;
use TotalSurveyVendors\League\Plates\Engine;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

class SetupViewTemplate extends Task
{
    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
        add_action('template_redirect', [$this, 'handleTemplateRedirect']);
    }

    public function handleTemplateRedirect()
    {
        if ($surveyUid = get_query_var('survey_uid')) {
            try {
                echo ViewSurvey::invoke(
                    Manager::instance(),
                    Plugin::get(Engine::class),
                    Survey::byUid($surveyUid)
                );
            } catch (\Exception $exception) {
                wp_die($exception->getMessage(), get_bloginfo('name'));
            }

            exit;
        }
    }
}