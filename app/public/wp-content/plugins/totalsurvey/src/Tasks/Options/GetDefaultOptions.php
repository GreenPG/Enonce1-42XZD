<?php


namespace TotalSurvey\Tasks\Options;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Tasks\Utils\GetExpressions;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

//@TODO: Extract this task to the foundation framework

/**
 * Class DefaultOptions
 *
 * @package TotalSurvey\Tasks\Options
 */
class GetDefaultOptions extends Task
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
        return [
            'privacy'     => [
                'hashIP'    => false,
                'hashAgent' => false,
                'honorDNT'  => false,
            ],
            'advanced'    => [
                'cacheCompatibility' => true,
                'recaptcha'          => [
                    'enabled'   => false,
                    'key'       => '',
                    'secret'    => '',
                    'threshold' => 0.5,
                ],
            ],
            'expressions' => array_map(
                static function ($item) {
                    $item['translations'] = [];

                    return $item;
                },
                GetExpressions::invoke()
            ),
            'general'     => [
                'showCredits' => false,
            ],
            'uninstall'   => [
                'wipeOnUninstall' => false,
            ],
        ];
    }
}
