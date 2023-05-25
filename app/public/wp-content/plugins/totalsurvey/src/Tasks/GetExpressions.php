<?php

namespace TotalSurvey\Tasks;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetExpressions
 *
 * @package TotalSurvey\Tasks
 * @method static array invoke()
 * @method static array invokeWithFallback(array $fallback)
 */
class GetExpressions extends Task
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
            'Start survey'                                                => [
                'translations' => [
                    __('Start survey', 'totalsurvey'),
                ],
            ],
            'Entry received. Thank you for participating in this survey!' => [
                'translations' => [
                    __('Entry received. Thank you for participating in this survey!', 'totalsurvey'),
                ],
            ],
            'Submit another entry'                                        => [
                'translations' => [
                    __('Submit another entry', 'totalsurvey'),
                ],
            ],
            'Submit'                                                      => [
                'translations' => [
                    __('Submit', 'totalsurvey'),
                ],
            ],
            'Next'                                                        => [
                'translations' => [
                    __('Next', 'totalsurvey'),
                ],
            ],
            'Previous'                                                    => [
                'translations' => [
                    __('Previous', 'totalsurvey'),
                ],
            ],
            'Other'                                                       => [
                'translations' => [
                    __('Other', 'totalsurvey'),
                ],
            ],
            'Choose'                                                      => [
                'translations' => [
                    __('Choose', 'totalsurvey'),
                ],
            ],
            'Done'                                                        => [
                'translations' => [
                    __('Done', 'totalsurvey'),
                ],
            ],
            'This survey is not available at the moment.'                 => [
                'translations' => [
                    __('This survey is not available at the moment.', 'totalsurvey'),
                ],
            ],
            'This survey is limited to authenticated users.'              => [
                'translations' => [
                    __('This survey is limited to authenticated users.', 'totalsurvey'),
                ],
            ],
            'Must be one of: {{allowedValues}}'                           => [
                'translations' => [
                    __('Must be one of: {{allowedValues}}', 'totalsurvey'),
                ]
            ],
            'Required'                                                    => [
                'translations' => [
                    __('Required', 'totalsurvey'),
                ]
            ],
            'Must be a valid email'                                       => [
                'translations' => [
                    __('Must be a valid email', 'totalsurvey'),
                ]
            ],
            'Minimum is {{min}}'                                          => [
                'translations' => [
                    __('Minimum is {{min}}', 'totalsurvey'),
                ]
            ],
            'Maximum is {{max}}'                                          => [
                'translations' => [
                    __('Maximum is {{max}}', 'totalsurvey'),
                ]
            ],
            'Must be a date before {{time}}'                              => [
                'translations' => [
                    __('Must be a date before {{time}}', 'totalsurvey'),
                ]
            ],
            'Must be a date after {{time}}'                               => [
                'translations' => [
                    __('Must be a date after {{time}}', 'totalsurvey'),
                ]
            ],
            'Must be numeric'                                             => [
                'translations' => [
                    __('Must be numeric', 'totalsurvey'),
                ]
            ],
            'Must be a valid date format'                                 => [
                'translations' => [
                    __('Must be a valid date format', 'totalsurvey'),
                ]
            ],
            'Must be between {{min}} and {{max}}'                         => [
                'translations' => [
                    __('Must be between {{min}} and {{max}}', 'totalsurvey'),
                ]
            ],
            'Must be a valid uploaded file'                               => [
                'translations' => [
                    __('Must be a valid uploaded file', 'totalsurvey'),
                ]
            ],
            'File type must be {{allowedTypes}}'                          => [
                'translations' => [
                    __('File type must be {{allowedTypes}}', 'totalsurvey'),
                ]
            ],
        ];
    }
}