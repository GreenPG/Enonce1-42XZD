<?php
! defined( 'ABSPATH' ) && exit();


return [
    'name'        => 'Customer Satisfaction',
    'description' => 'Short and precise questions to measure customers\' satisfaction.',
    'category'    => 'Satisfaction',
    'source'      => 'default',
    'thumbnail'   => './assets/images/presets/customer-satisfaction.png',
    'survey'      => [
        'sections' => [
            [
                'name'             => 'Personal information',
                'description'      => '',
                'questions'        => [
                    [
                        'title'       => 'Name',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '1070d45e-fe14-4581-93bb-d3d619265a41',
                        'field'       => [
                            'type'        => 'text',
                            'uid'         => 'a9d596f5-aeff-4195-b0f0-2a6fc46796dd',
                            'options'     => [],
                            'validations' => [
                                'required'  => [
                                    'enabled'  => true,
                                    'options'  => [],
                                    'messages' => [],
                                ],
                                'email'     => [
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
                    [
                        'title'       => 'Email',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '07af51b5-bd63-4b68-999e-f62f691bd586',
                        'field'       => [
                            'type'        => 'text',
                            'uid'         => '0ce336aa-e10c-4ddd-adac-2003936b5370',
                            'options'     => [],
                            'validations' => [
                                'required'  => [
                                    'enabled'  => true,
                                    'options'  => [],
                                    'messages' => [],
                                ],
                                'email'     => [
                                    'enabled'  => true,
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
            [
                'uid'              => '99c4816b-3447-4371-a95b-66df3a08c2df',
                'name'             => 'Satisfaction',
                'description'      => '',
                'questions'        => [
                    [
                        'title'       => 'How satisfied or dissatisfied are you?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => 'c4983e59-c2d4-4b4a-858f-31ff1ff0c932',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => '257074c8-2990-4b63-8b8c-1c0007d039a4',
                            'options'     => [
                                'scale'  => 10,
                                'labels' => [
                                    'least' => 'Not at all satisfied',
                                    'most'  => 'Extremely satisfied',
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
                        'title'       => 'Which of the following attributes would you use to describe our product/service?',
                        'description' => 'Select all that apply.',
                        'label'       => '',
                        'uid'         => '79e82683-30d0-4eb7-9b80-6cbbd6436790',
                        'field'       => [
                            'type'        => 'checkbox',
                            'uid'         => '5673638d-c16b-40b8-89c8-8e6c1c03208a',
                            'options'     => [
                                'choices' => [
                                    [
                                        'uid'   => 'dee7ac60-a41b-4a6b-8294-56bda1238263',
                                        'label' => 'Affordable',
                                    ],

                                    [
                                        'uid'   => '6e6ed473-6dfc-437b-82c3-14749fd882b3',
                                        'label' => 'Inituitive',
                                    ],

                                    [
                                        'uid'   => 'cd6118eb-9a9e-46ce-922d-e773d369ed9c',
                                        'label' => 'Premium',
                                    ],

                                    [
                                        'uid'   => 'd33971f1-7255-4f92-bdb9-98bad6414362',
                                        'label' => 'Overpriced',
                                    ],

                                    [
                                        'uid'   => 'c6d2df2a-30fc-4f38-8e48-ea50cadb3c0e',
                                        'label' => 'Hard to use',
                                    ],

                                    [
                                        'uid'   => '3aaefb90-b20a-4e2c-9b46-6b68bfb65d08',
                                        'label' => 'Unreliable',
                                    ],
                                ],
                            ],
                            'validations' => [
                                'required'     => [
                                    'enabled'  => true,
                                    'options'  => [],
                                    'messages' => [],
                                ],
                                'minSelection' => [
                                    'enabled'  => false,
                                    'options'  => [
                                        'value' => 0,
                                    ],
                                    'messages' => [],
                                ],
                                'maxSelection' => [
                                    'enabled'  => false,
                                    'options'  => [
                                        'value' => 0,
                                    ],
                                    'messages' => [],
                                ],
                            ],
                        ],
                    ],

                    [
                        'title'       => 'How well do our product/service fulfill your needs?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '97f0a7f4-ee68-4791-9004-e3779c1cfb87',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => '7f9f2830-6a8b-45d2-a5dd-ec51b1c9b423',
                            'options'     => [
                                'scale'  => 10,
                                'labels' => [
                                    'least' => 'Not at all well',
                                    'most'  => 'Extremely well',
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
                ],
                'action'           => 'next',
                'next_section_uid' => null,
                'conditions'       => [],
            ],
            [
                'uid'              => 'c554c085-1f5a-4ee8-a676-972e02681cc4',
                'name'             => 'Usage and recommendation',
                'description'      => '',
                'questions'        => [
                    [
                        'title'       => 'How long have you been a customer?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '156e815b-9c92-46ea-9625-443918f79261',
                        'field'       => [
                            'type'        => 'radio',
                            'uid'         => '36542eaf-cfa2-48d0-a114-979a9c045b4f',
                            'options'     => [
                                'choices' => [
                                    [
                                        'uid'   => '52131848-3a24-4433-98c8-fd3025135d7d',
                                        'label' => 'Less than a week',
                                    ],

                                    [
                                        'uid'   => '6cd4bdda-e463-491f-9100-2ebc535d9a9a',
                                        'label' => 'Less than a month',
                                    ],

                                    [
                                        'uid'   => '54c71218-3867-4a66-b49f-504ed4314a29',
                                        'label' => '1-3 months',
                                    ],

                                    [
                                        'uid'   => '3ede550a-d8db-420c-b379-86577fd88a07',
                                        'label' => '6-12 months',
                                    ],

                                    [
                                        'uid'   => 'cdca13ef-ab95-4656-a922-e295aee5522e',
                                        'label' => '1-3 years',
                                    ],

                                    [
                                        'uid'   => '31809a1a-9c8f-496f-a36c-9e5d003382ef',
                                        'label' => '5+ years',
                                    ],
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
                        'title'       => 'How likely are you to going to recommend our product/service?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '9b64c4de-a705-4f22-b073-232caacac9b6',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => 'f66a8d5e-1d81-45ce-9d2a-4fdd72698e20',
                            'options'     => [
                                'scale'  => 10,
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
                ],
                'action'           => 'next',
                'next_section_uid' => null,
                'conditions'       => [],
            ],
            [
                'uid'              => '4f3dfb69-5098-468f-aa30-d21a898d21e5',
                'name'             => 'Comment',
                'description'      => '',
                'questions'        => [
                    [
                        'title'       => 'Do you have any other comments, questions, or concerns?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '3dbb2191-80a9-494f-a051-5489134df1d4',
                        'field'       => [
                            'type'        => 'paragraph',
                            'uid'         => 'd864a168-7dca-421b-9b2d-d3327a1691a5',
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
        ]
    ]
];
