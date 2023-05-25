<?php
namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Filters\SurveyLinkFilter;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

class RegisterRewriteRules extends Task
{

    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
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
                flush_rewrite_rules();
            }
        );
    }
}
