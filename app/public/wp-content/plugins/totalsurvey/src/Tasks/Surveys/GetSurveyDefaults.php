<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use Exception;
use TotalSurvey\Tasks\Utils\GetRoles;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Strings;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetSurveyDefaults
 *
 * @package TotalSurvey\Tasks\Survey
 * @method static array invoke()
 * @method static array invokeWithFallback($fallback)
 */
class GetSurveyDefaults extends Task
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
     * @throws Exception
     */
    protected function execute()
    {
        return [
            'name'        => 'Untitled Survey',
            'description' => '',
            'settings'    => [
                'limitations' => [
                    'authentication' => [
                        'enabled' => false,
                        'options' => [
                            'specificRoles' => false,
                            'roles'         => wp_list_pluck(GetRoles::invoke(), 'name', 'id'),
                        ],
                    ],
                ],
                'contents'    => [
                    'welcome'  => [
                        'enabled' => false,
                        'title'   => '',
                        'blocks'  => [],
                    ],
                    'thankyou' => [
                        'enabled' => false,
                        'title'   => __('Thank you!'),
                        'blocks'  => [
                            [
                                'type'    => 'content',
                                'typeId'  => 'content:title',
                                'uid'     => Strings::uid(),
                                'content' => [
                                    'value'   => __('Thank you!'),
                                    'options' => [],
                                    'type'    => 'title',
                                ],
                            ],
                            [
                                'type'    => 'content',
                                'typeId'  => 'content:paragraph',
                                'uid'     => Strings::uid(),
                                'content' => [
                                    'value'   => __('Entry received. Thank you for participating in this survey!'),
                                    'options' => [],
                                    'type'    => 'paragraph',
                                ],
                            ],
                        ],
                    ],
                ],
                'design'      => [
                    'template' => 'default-template',
                    'colors'   => [
                        'primary'    => [
                            'base'     => '#3A9278',
                            'contrast' => '#FFFFFF',
                        ],
                        'secondary'  => [
                            'base'     => '#364959',
                            'contrast' => '#FFFFFF',
                        ],
                        'background' => [
                            'base'     => '#f6f6f6',
                            'contrast' => '#FFFFFF',
                        ],
                        'dark'       => [
                            'base'     => '#263440',
                            'contrast' => '#FFFFFF',
                        ],
                        'error'      => [
                            'base'     => '#F26418',
                            'contrast' => '#FFFFFF',
                        ],
                        'success'    => [
                            'base'     => '#90BE6D',
                            'contrast' => '#FFFFFF',
                        ],
                    ],
                    'size'     => 'regular',
                    'space'    => 'normal',
                    'radius'   => 'rounded',
                ],
                'workflow'    => [
                    'rules' => [],
                ],
                'redirection'   => [
                    'enabled' => false,
                    'url'      => '',
                    'blank_target' => false

                ],
                'can_view_entry' => [
                    'enabled' => false,
                ],
                'reports' => [
                    'enabled' => false,
                    'email'   => wp_get_current_user()->user_email,
                    'interval' => '7',
                    'sections' => [],
                ],
            ],
            'sections'    => [
                [
                    'uid'              => Strings::uid(),
                    'title'             => 'Sample section',
                    'description'      => '',
                    'blocks'           => [],
                    'action'           => 'next',
                    'next_section_uid' => null,
                    'conditions'       => [],
                ],
            ],
            'status'      => 'open',
            'enabled'     => true,
        ];
    }
}
