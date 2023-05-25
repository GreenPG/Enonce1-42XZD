<?php
! defined( 'ABSPATH' ) && exit();


return [
    'name'        => 'Employee Evaluation',
    'description' => 'Evaluate your employees performance quickly.',
    'category'    => 'Human Resources',
    'source'      => 'default',
    'thumbnail'   => './assets/images/presets/employee-evaluation.png',
    'survey'      => [
        'sections' => [
            [
                'name'             => 'Credentials',
                'description'      => '',
                'questions'        => [
                    [
                        'title'       => 'What is your full name?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '6eb80564-bd9b-4d80-926b-5463f5e24e3f',
                        'field'       => [
                            'type'        => 'text',
                            'uid'         => '89e9b1bf-cdaf-4b2c-8dab-2e78af7d7d17',
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
                        'title'       => 'What is your email address?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '7b91c601-03db-4e02-a0ad-1d5d530e9324',
                        'field'       => [
                            'type'        => 'text',
                            'uid'         => '2bfaa381-e82b-47aa-86ec-e032f84058c7',
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
                    [
                        'title'       => 'What is your job role?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => 'd9e6f241-2cb0-41cb-9d5b-6e174ed781c0',
                        'field'       => [
                            'type'        => 'radio',
                            'uid'         => '4a811945-44f6-4fc2-9a7a-ea5fab213d5e',
                            'options'     => [
                                'choices' => [
                                    [
                                        'uid'   => '32a33b66-364d-497b-86b2-2fff49b29bb6',
                                        'label' => 'Trainee',
                                    ],
                                    [
                                        'uid'   => 'f2dbf0e4-2df4-44b6-8758-315e3f838b2b',
                                        'label' => 'Assistant',
                                    ],
                                    [
                                        'uid'   => '558037dd-8b10-4364-8252-38465eb2385e',
                                        'label' => 'Junior',
                                    ],
                                    [
                                        'uid'   => 'c383d456-0c22-4734-b3c0-9d8bed468187',
                                        'label' => 'Senior',
                                    ],
                                    [
                                        'uid'   => 'f40a8e84-36f5-4c1e-a01e-549f1a7c0b81',
                                        'label' => 'Lead',
                                    ],
                                    [
                                        'uid'   => '1ef19708-e970-4dbe-9b60-ba7c83b0a84f',
                                        'label' => 'Manager',
                                    ],
                                    [
                                        'uid'   => '1acf6d35-e427-4f53-a2b0-846b4262ca13',
                                        'label' => 'Director',
                                    ],
                                    [
                                        'uid'   => '9f2833ae-f9dd-4e02-b400-4bc20966861e',
                                        'label' => 'Executive',
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
                        'title'       => 'What is your job title?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '9ee6cdea-eadc-4a5b-8c14-9a06a4f8bb97',
                        'field'       => [
                            'type'        => 'text',
                            'uid'         => '9fbddfe3-f597-417e-8efc-a6146e550b5d',
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
                        'title'       => 'In which department do your job belongs to?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '29191c71-f3ec-4222-bf7c-8529efde4e87',
                        'field'       => [
                            'type'        => 'radio',
                            'uid'         => '241b39d3-a919-4484-961f-7f9f811d6dc0',
                            'options'     => [
                                'choices' => [
                                    [
                                        'uid'   => 'd4459d5e-ebc4-4a56-bb26-5fe761784c76',
                                        'label' => 'Administration',
                                    ],
                                    [
                                        'uid'   => '1b855ccf-8109-4288-b4b4-ba0865c635fe',
                                        'label' => 'Finance',
                                    ],
                                    [
                                        'uid'   => 'd7fc12e4-bdfd-4545-bb98-8bd3572b4142',
                                        'label' => 'HR',
                                    ],
                                    [
                                        'uid'   => 'b3dce0da-937f-4b3c-b1f4-485e8685534b',
                                        'label' => 'IT',
                                    ],
                                    [
                                        'uid'   => '88b85be0-e7bd-4370-8200-10785954ca2b',
                                        'label' => 'Marketing',
                                    ],
                                    [
                                        'uid'   => 'ff769e2a-5bd6-4b6a-9d52-043e8ff879ec',
                                        'label' => 'Sales',
                                    ],
                                    [
                                        'uid'   => '4cfd5d22-5910-4932-94c1-4cfeb5e00c98',
                                        'label' => 'Research & Development',
                                    ],
                                    [
                                        'uid'   => '1d902122-d2f2-43ac-ad62-cd412e3cb8c6',
                                        'label' => 'Production',
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
                ],
                'action'           => 'next',
                'next_section_uid' => null,
                'conditions'       => [],
            ],
            [
                'uid'              => 'f0de8e21-a80e-43b8-9139-920c7e07c07f',
                'name'             => 'Engagement',
                'description'      => '',
                'questions'        => [
                    [
                        'title'       => 'I am inspired to meet my goals at work.',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '453df1d8-8adc-4687-8d25-6919d47a128c',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => '0dd90c04-a62d-462c-9598-65197779a55d',
                            'options'     => [
                                'scale'  => 5,
                                'labels' => [
                                    'least' => 'Strongly disagree',
                                    'most'  => 'Strongly agree',
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
                        'title'       => 'I feel completely involved in my work.',
                        'description' => '',
                        'label'       => '',
                        'uid'         => 'bf55b4e3-23bf-4ae8-9bb0-72565efbc011',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => '55d28c2e-8bb3-4680-af80-2607de504bf5',
                            'options'     => [
                                'scale'  => 5,
                                'labels' => [
                                    'least' => 'Strongly disagree',
                                    'most'  => 'Strongly agree',
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
                        'title'       => 'I get excited about going to work.',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '86c206c0-905d-471f-be61-92bd25e58cff',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => '22c6a450-ad06-4f50-84b2-19bb9f10c341',
                            'options'     => [
                                'scale'  => 5,
                                'labels' => [
                                    'least' => 'Strongly disagree',
                                    'most'  => 'Strongly agree',
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
                'uid'              => 'dc5554cb-7f83-4a1e-8b80-f5d644db4c07',
                'name'             => 'Performance',
                'description'      => '',
                'questions'        => [
                    [
                        'title'       => 'The work is completed thoroughly and with care, correctly following established Finance processes and procedures.',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '604a3b1f-9740-4e7b-9e81-8b597ff823e2',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => 'd7b98bcc-81f2-4837-a778-ba12841a6c34',
                            'options'     => [
                                'scale'  => 5,
                                'labels' => [
                                    'least' => 'Strongly disagree',
                                    'most'  => 'Strongly agree',
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
                        'title'       => 'I\'m able to communicate consistently well with other people within the company. The intents and purposes are always clear, concise and understood.',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '65ec0d18-116f-4566-ab2c-e34a753b4358',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => 'eced24e5-3ff5-4289-b335-8a9d85d1ce34',
                            'options'     => [
                                'scale'  => 5,
                                'labels' => [
                                    'least' => 'Strongly disagree',
                                    'most'  => 'Strongly agree',
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
                        'title'       => 'I consistently delivers a high quality of work to agreed timeframes and specifications. Rarely, if ever, I misses a deadline or delays a project due to lack of timekeeping.',
                        'description' => '',
                        'label'       => '',
                        'uid'         => 'bd0f9a60-4f52-41dc-b30d-b31fe795d2cc',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => 'b3c4c6a6-3964-45eb-89f0-5898dee7d0da',
                            'options'     => [
                                'scale'  => 5,
                                'labels' => [
                                    'least' => 'Strongly disagree',
                                    'most'  => 'Strongly agree',
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
                'uid'              => 'a914f383-3ec9-4ce6-8555-71254e1d1c12',
                'name'             => 'Benefits',
                'description'      => '',
                'questions'        => [
                    [
                        'title'       => 'I am satisfied with my total benefits package.',
                        'description' => '',
                        'label'       => '',
                        'uid'         => 'f2675850-8ab7-4893-b44e-4156ebcc8435',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => '7f1da667-c5d9-45d8-95a5-51534235eb17',
                            'options'     => [
                                'scale'  => 5,
                                'labels' => [
                                    'least' => 'Strongly disagree',
                                    'most'  => 'Strongly agree',
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
                        'title'       => 'I am satisfied with the amount of paid leave offered by my organization.',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '61cbf3e4-bc86-4ed7-86c3-e4a9ef5bf26c',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => 'f6d971a2-2b08-46cc-b990-9ffb3017e0b0',
                            'options'     => [
                                'scale'  => 5,
                                'labels' => [
                                    'least' => 'Strongly disagree',
                                    'most'  => 'Strongly agree',
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
                        'title'       => 'I am satisfied with the workplace flexibility offered by my organization.',
                        'description' => '',
                        'label'       => '',
                        'uid'         => 'f83d5a51-9b81-44ea-84a7-da3a92c40c38',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => '3af53ba2-4671-4b7c-8ddd-27a087676871',
                            'options'     => [
                                'scale'  => 5,
                                'labels' => [
                                    'least' => 'Strongly disagree',
                                    'most'  => 'Strongly agree',
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
                'uid'              => '87b46e45-4d84-4e7e-b9db-311ff56a6bdd',
                'name'             => 'Overall Assessment',
                'description'      => '',
                'questions'        => [
                    [
                        'title'       => 'How would you rate the overall job performance?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => 'ae83c428-cc29-4a69-a8ca-d18ffbe48f44',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => '7c346ad4-695e-4d47-86ea-4bab2470dddc',
                            'options'     => [
                                'scale'  => 5,
                                'labels' => [
                                    'least' => 'Poor',
                                    'most'  => 'Excellent',
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
                        'title'       => 'Do you have any final comments you would like to raise?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '4dd781a9-8816-4479-9e5b-ea11e857edf5',
                        'field'       => [
                            'type'        => 'paragraph',
                            'uid'         => '9ca49cff-c298-45b9-94d4-8603a03636ec',
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
    ],
];
