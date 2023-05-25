<?php


namespace TotalSurvey\Tasks\Presets;
! defined( 'ABSPATH' ) && exit();


use Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

class SetupPreviewPreset extends Task
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
        if ($presetUid = get_query_var('survey_preset_uid')) {
            try {
                echo PreviewPreset::invoke($presetUid);
            } catch (Exception $exception) {
                wp_die($exception->getMessage(), get_bloginfo('name'));
            }

            exit;
        }
    }
}