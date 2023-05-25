<?php

namespace TotalSurvey\Tasks\Utils;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetLanguages
 *
 * @package TotalSurvey\Tasks
 * @method static array invoke()
 * @method static array invokeWithFallback(array $fallback)
 */
class GetLanguages extends Task
{
    const RTL_LANGUAGES = ['ar', 'ary', 'he_IL', 'azb', 'fa_IR', 'fa_AF', 'ur'];

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
        require_once ABSPATH.'wp-admin/includes/translation-install.php';

        return array_map(
            static function ($language) {
                return [
                    'name' => $language['english_name'],
                    'code' => $language['language'],
                    'dir'  => in_array($language['language'], static::RTL_LANGUAGES, true) ? 'rtl' : 'ltr',
                ];
            },
            array_values(wp_get_available_translations())
        );
    }
}
