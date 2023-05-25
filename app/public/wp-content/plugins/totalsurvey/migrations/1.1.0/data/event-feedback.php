<?php
! defined( 'ABSPATH' ) && exit();


return [
    'name'        => 'Event Feedback',
    'description' => 'Know more about your event and visitors\' impression.',
    'category'    => 'Events',
    'source'      => 'default',
    'thumbnail'   => './assets/images/presets/event-feedback.png',
    'survey'      => [
        'settings' => [
            'contents' => [
                'welcome' => [
                    'enabled' => true,
                    'content' => 'Thank you for participating in our event. We hope you had as much fun attending as we did organizing it. We want to hear your feedback so we can keep improving our logistics and content. Please fill this quick survey and let us know your thoughts (your answers will be anonymous).',
                ],
            ],
        ],
        'sections' => [
            [
                'uid'              => '637ac81e-9636-46e5-9643-c492afde1448',
                'name'             => 'Relevancy',
                'description'      => '',
                'questions'        => [
                    [
                        'title'       => 'How relevant and helpful do you think it was for your job?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => 'd6d32b59-9fe5-40aa-b3b3-a80ab441a334',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => 'bee353bb-e963-4172-8571-48a52ea4751f',
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
                        'title'       => 'What were your key takeaways from this event?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '2e198101-dd0e-4942-99e7-ff8c9b00fd30',
                        'field'       => [
                            'type'        => 'paragraph',
                            'uid'         => 'a392e026-cb72-4cf1-8363-29dc5c9052fd',
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

                    [
                        'title'       => 'Which sessions did you find most relevant?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '64f7260c-9942-49b9-8ae6-ba73716daeb2',
                        'field'       => [
                            'type'        => 'checkbox',
                            'uid'         => 'affb844c-afc5-4f37-9c60-f75cf7b97302',
                            'options'     => [
                                'choices'    => [

                                    [
                                        'uid'   => 'fd65c05c-0fcc-44dc-8a04-d905e310a3d1',
                                        'label' => 'Welcome activity',
                                    ],

                                    [
                                        'uid'   => 'bb582f01-d9e7-4d43-8b40-82c0db7bba59',
                                        'label' => 'Speaker #1',
                                    ],

                                    [
                                        'uid'   => 'f552f8a4-4189-4542-a446-7ca519b30f72',
                                        'label' => 'Activity #1',
                                    ],

                                    [
                                        'uid'   => '7c9d0ddc-12c3-4739-844d-be1cf045547d',
                                        'label' => 'Speaker #2',
                                    ],

                                    [
                                        'uid'   => 'aaa85eaf-34f5-4d91-af10-0bf5ce112e29',
                                        'label' => 'Activity #2',
                                    ],

                                    [
                                        'uid'   => 'c39b5e9d-7716-4199-a4e1-ec2bd679e55e',
                                        'label' => 'Closing activity',
                                    ],
                                ],
                                'allowOther' => false,
                            ],
                            'validations' => [
                                'required'     => [
                                    'enabled'  => true,
                                    'options'  => [],
                                    'messages' => [],
                                ],
                                'minSelection' => [
                                    'enabled'  => true,
                                    'options'  => [
                                        'value' => '1',
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
                ],
                'action'           => 'next',
                'next_section_uid' => null,
                'conditions'       => [],
            ],
            [
                'uid'              => '9e9ea36c-8f7e-497c-9049-f560fac3be23',
                'name'             => 'Satisfaction',
                'description'      => '',
                'questions'        => [

                    [
                        'title'       => 'How satisfied were you with the event?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '5fe393cf-824a-4ec7-ac27-e343ba060b31',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => '719d800d-078a-45ac-afe0-0de0b2a98c4b',
                            'options'     => [
                                'scale'  => 5,
                                'labels' => [
                                    'least' => 'Not very',
                                    'most'  => 'Very much',
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
                        'title'       => 'How satisfied were you with the session content?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => 'c82c83d1-1a10-4f69-87f1-91f370977bd0',
                        'field'       => [
                            'type'        => 'scale',
                            'uid'         => '8b427bb6-8de2-44d4-bf23-af0783de362b',
                            'options'     => [
                                'scale'  => 5,
                                'labels' => [
                                    'least' => 'Poor',
                                    'most'  => 'Excellent',
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
                ],
                'action'           => 'next',
                'next_section_uid' => null,
                'conditions'       => [],
            ],
            [
                'uid'              => 'b6a4a742-8879-4155-993c-7e61a62ef657',
                'name'             => 'Other',
                'description'      => '',
                'questions'        => [

                    [
                        'title'       => 'Any additional comments regarding the sessions or overall agenda?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => 'd4a349a5-3c12-4d01-afcc-1aedf4cc4dfc',
                        'field'       => [
                            'type'        => 'paragraph',
                            'uid'         => '1072068f-2bb0-47a2-928f-6a0a3380760c',
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

                    [
                        'title'       => 'Any overall feedback for the event?',
                        'description' => '',
                        'label'       => '',
                        'uid'         => 'ac2508b8-03ef-4358-a3e0-42bf4790bb9a',
                        'field'       => [
                            'type'        => 'paragraph',
                            'uid'         => '8f9064ee-c1ea-4cf9-8187-bfbf6ef17ff7',
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
            [
                'uid'              => '177d5955-c296-4a0a-a674-50852fd75018',
                'name'             => 'Personal infomation',
                'description'      => '',
                'questions'        => [

                    [
                        'title'       => 'Name',
                        'description' => '',
                        'label'       => '',
                        'uid'         => 'c8d1e635-43bd-43c5-bf80-fdca8b9805c8',
                        'field'       => [
                            'type'        => 'text',
                            'uid'         => 'b1ce5531-90bb-478c-80c0-1568e78ff57d',
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
                        'uid'         => '3a34d1ee-d7cd-4b7b-9c95-2d77efd8985b',
                        'field'       => [
                            'type'        => 'text',
                            'uid'         => '6e315253-602b-4cd7-9eb1-533ce7fadf74',
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
                        'title'       => 'Ticket ID',
                        'description' => '',
                        'label'       => '',
                        'uid'         => '14cf0c02-ab89-413c-8dac-47d3ec0e17dd',
                        'field'       => [
                            'type'        => 'text',
                            'uid'         => '62479eff-6186-4c6b-b359-009058f6a31f',
                            'options'     => [],
                            'validations' => [
                                'required'  => [
                                    'enabled'  => false,
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
                ],
                'action'           => 'next',
                'next_section_uid' => null,
                'conditions'       => [],
            ],
        ],
    ]
];
