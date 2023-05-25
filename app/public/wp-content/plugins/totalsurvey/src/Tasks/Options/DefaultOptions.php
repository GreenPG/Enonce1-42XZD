<?php


namespace TotalSurvey\Tasks\Options;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Task;

//@TODO: Extract this task to the foundation framework

/**
 * Class DefaultOptions
 *
 * @package TotalSurvey\Tasks\Options
 */
class DefaultOptions extends Task
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
            'expressions' => [
                'Start survey'                                                => [
                    'translations' => [],
                ],
                'Entry received. Thank you for participating in this survey!' => [
                    'translations' => [],
                ],
                'Submit another entry'                                        => [
                    'translations' => [],
                ],
                'Submit'                                                      => [
                    'translations' => [],
                ],
                'Next'                                                        => [
                    'translations' => [],
                ],
                'Previous'                                                    => [
                    'translations' => [],
                ],
                'Other'                                                       => [
                    'translations' => [],
                ],
                'Choose'                                                      => [
                    'translations' => [],
                ],
                'Done'                                                        => [
                    'translations' => [],
                ],
                'This survey is not available at the moment.'                 => [
                    'translations' => [],
                ],
                'You cannot participate in this survey.'                      => [
                    'translations' => [],
                ],
            ],
            'general'     => [
                'showCredits' => false,
            ],
            'uninstall'   => [
                'wipeOnUninstall' => false,
            ],
        ];
    }
}
