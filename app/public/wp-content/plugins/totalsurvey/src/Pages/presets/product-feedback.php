<?php
! defined( 'ABSPATH' ) && exit();


return [
    'name'     => 'Product Feedback',
    'sections' => [
        [
            'uid'              => '5abb52f1-510b-4979-b25d-fe9339aeed96',
            'name'             => 'Assessment',
            'description'      => '',
            'questions'        => [
                [
                    'title'       => 'What was your first impression of our product?',
                    'description' => '',
                    'label'       => '',
                    'uid'         => '19a47313-ecfa-43d3-a21f-027d524e2630',
                    'field'       => [
                        'type'        => 'scale',
                        'uid'         => 'ecaf7b7e-88d0-408f-afce-d78d7ef9d796',
                        'options'     => [
                            'scale'  => 5,
                            'labels' => [
                                'least' => 'Really negative',
                                'most'  => 'Really positive',
                            ],
                        ],
                        'validations' => [
                            'required' => [
                                'enabled'  => true,
                                'options'  => [],
                                'messages' => [],
                            ],
                        ],
                    ],
                ],
                [
                    'title'       => 'How would you rate the quality of our product?',
                    'description' => '',
                    'label'       => '',
                    'uid'         => '740b17d2-cbf3-40cd-bf4a-512802534a87',
                    'field'       => [
                        'type'        => 'scale',
                        'uid'         => '50734ec2-ee82-4ed1-8817-77e7d1db2f2f',
                        'options'     => [
                            'scale'  => 5,
                            'labels' => [
                                'least' => 'Terrible',
                                'most'  => 'Outstanding',
                            ],
                        ],
                        'validations' => [
                            'required' => [
                                'enabled'  => true,
                                'options'  => [],
                                'messages' => [],
                            ],
                        ],
                    ],
                ],
                [
                    'title'       => 'How intuitive is our product?',
                    'description' => '',
                    'label'       => '',
                    'uid'         => '249e2685-2576-4e0b-bdf8-04929bbfea36',
                    'field'       => [
                        'type'        => 'scale',
                        'uid'         => 'd844f886-d92a-4acd-87a9-10ec7ef15182',
                        'options'     => [
                            'scale'  => 5,
                            'labels' => [
                                'least' => 'Not at all intuitive',
                                'most'  => 'Extremely intuitive',
                            ],
                        ],
                        'validations' => [
                            'required' => [
                                'enabled'  => true,
                                'options'  => [],
                                'messages' => [],
                            ],
                        ],
                    ],
                ],
                [
                    'title'       => 'How much do you need our product?',
                    'description' => '',
                    'label'       => '',
                    'uid'         => '4cdcf79d-aedd-4b28-9dc9-b01bc0fed3a2',
                    'field'       => [
                        'type'        => 'scale',
                        'uid'         => '55be7751-e27e-4d3a-b055-0da07c4dd86c',
                        'options'     => [
                            'scale'  => 5,
                            'labels' => [
                                'least' => 'Very occasionally ',
                                'most'  => 'Very frequently',
                            ],
                        ],
                        'validations' => [
                            'required' => [
                                'enabled'  => false,
                                'options'  => [],
                                'messages' => [],
                            ],
                        ],
                    ],
                ],
                [
                    'title'       => 'How would you rate the value for money of our product?',
                    'description' => '',
                    'label'       => '',
                    'uid'         => '59f3d6a3-493a-4394-97af-ffa6818b2c23',
                    'field'       => [
                        'type'        => 'scale',
                        'uid'         => 'a1a9841b-2aa0-4225-b2a3-366785844818',
                        'options'     => [
                            'scale'  => 5,
                            'labels' => [
                                'least' => 'Not at all worthy',
                                'most'  => 'Very worthy',
                            ],
                        ],
                        'validations' => [
                            'required' => [
                                'enabled'  => true,
                                'options'  => [],
                                'messages' => [],
                            ],
                        ],
                    ],
                ],
                [
                    'title'       => 'How likely is it that you would recommend our product to a friend or colleague?',
                    'description' => '',
                    'label'       => '',
                    'uid'         => '0c9b674a-763d-4c62-bacd-9cf0678e6b78',
                    'field'       => [
                        'type'        => 'scale',
                        'uid'         => 'badaaeb7-bd6b-4a31-bf0f-8fc9ce6fc04a',
                        'options'     => [
                            'scale'  => 5,
                            'labels' => [
                                'least' => 'Not at all likely',
                                'most'  => 'Extremely likely',
                            ],
                        ],
                        'validations' => [
                            'required' => [
                                'enabled'  => true,
                                'options'  => [],
                                'messages' => [],
                            ],
                        ],
                    ],
                ],
                [
                    'title'       => 'What are the points that you would most like to improve in our product?',
                    'description' => '',
                    'label'       => '',
                    'uid'         => 'ba079007-c270-4785-b6e9-bad6ae3a3737',
                    'field'       => [
                        'type'        => 'paragraph',
                        'uid'         => '689cb3ad-b7bc-44ac-98f4-89bd8449565d',
                        'options'     => [],
                        'validations' => [
                            'required'  => [
                                'enabled'  => false,
                                'options'  => [],
                                'messages' => [],
                            ],
                            'minLength' => [
                                'enabled'  => false,
                                'options'  => [
                                    'value' => 0,
                                ],
                                'messages' => [],
                            ],
                            'maxLength' => [
                                'enabled'  => false,
                                'options'  => [
                                    'value' => 0,
                                ],
                                'messages' => [],
                            ],
                        ],
                    ],
                ],
            ],
            'action'           => 'next',
            'next_section_uid' => null,
            'conditions'       => [],
        ],
    ],
];