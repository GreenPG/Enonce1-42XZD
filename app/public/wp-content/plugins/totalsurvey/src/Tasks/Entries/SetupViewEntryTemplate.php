<?php


namespace TotalSurvey\Tasks\Entries;
! defined( 'ABSPATH' ) && exit();


use ErrorException;
use TotalSurvey\Filters\Surveys\SurveyLinkFilter;
use TotalSurvey\Models\Entry;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\NotFoundException;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\View\Engine;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

class SetupViewEntryTemplate extends Task
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
                $queryVars[] = 'entry_uid';

                return $queryVars;
            }
        );
        add_action(
            'init',
            static function () {
                $base = 'entry';
                add_rewrite_rule("{$base}/([a-z0-9-]+)[/]?$", 'index.php?entry_uid=$matches[1]', 'top');
            }
        );
        add_filter('template_include', [$this, 'handleTemplateRedirect']);
    }

    public function handleTemplateRedirect($template)
    {
        if ($entryUid = get_query_var('entry_uid')) {
            try {
                NotFoundException::throwUnless(
                    Entry::byUid($entryUid)->survey()->canViewEntry(),
                    __('You do not have the right to access this page.', 'totalsurvey')
                );
                echo ViewEntry::invoke(
                    Manager::instance(),
                    Engine::instance(),
                    Entry::byUid($entryUid)
                );
            } catch (\Exception $exception) {
                wp_die($exception->getMessage(), get_bloginfo('name'));
            }

            exit;
        }

        return $template;
    }
}
