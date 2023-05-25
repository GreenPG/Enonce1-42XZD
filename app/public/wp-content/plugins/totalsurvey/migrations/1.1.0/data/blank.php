<?php
! defined( 'ABSPATH' ) && exit();


return [
    'name'        => 'Blank',
    'description' => 'Just plain empty survey to start fresh.',
    'category'    => 'Default',
    'source'      => 'default',
    'thumbnail'   => './assets/images/presets/blank.png',
    'survey'      => [
        'sections' => [
            [
                'name'             => 'First section',
                'description'      => '',
                'questions'        => [],
                'action'           => 'next',
                'next_section_uid' => null,
                'conditions'       => [],
            ],
        ]
    ],
];
