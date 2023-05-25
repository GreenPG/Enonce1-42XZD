<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Tasks\Options\GetDefaultOptions;

return [
    'version'    => '1.7.1',
    'loader'     => (require 'vendor/autoload.php'),
    'textdomain' => 'totalsurvey',
    'source'     => 'totalsuite.net',
    'product'    => [
        'id'   => 'totalsurvey',
        'name' => 'TotalSurvey',
        'url'  => 'https://totalsuite.net/products/totalsurvey',
    ],
    'namespaces' => [
        'rest'      => 'totalsurvey',
        'extension' => 'TotalSurvey\\Extensions',
        'template'  => 'TotalSurvey\\Templates',
    ],
    'path'       => [
        'base'        => wp_normalize_path(plugin_dir_path(__FILE__)),
        'languages'   => wp_normalize_path(plugin_dir_path(__FILE__)).'languages',
        'uploads'     => wp_normalize_path(wp_get_upload_dir()['basedir']),
        'userUploads' => wp_normalize_path(wp_get_upload_dir()['basedir'].'/totalsurvey/uploads'),
        'userReports' => wp_normalize_path(wp_get_upload_dir()['basedir'].'/totalsurvey/reports'),
        'modules'     => wp_normalize_path(plugin_dir_path(__FILE__).'modules'),
        'userModules' => wp_normalize_path(wp_get_upload_dir()['basedir'].'/totalsurvey/modules'),
        'presets'     => wp_normalize_path(plugin_dir_path(__FILE__).'presets'),
        'userPresets' => wp_normalize_path(wp_get_upload_dir()['basedir'].'/totalsurvey/presets'),
        'migrations'  => plugin_dir_path(__FILE__).'migrations',

    ],
    'url'        => [
        'base'        => plugins_url('', __FILE__),
        'apiBase'     => '/totalsurvey',
        'modules'     => [
            'base'  => plugins_url('modules', __FILE__),
            'store' => 'https://totalsuite.net/api/v3/modules?for=totalsurvey',
        ],
        'userModules' => [
            'base' => wp_get_upload_dir()['baseurl'].'/totalsurvey/modules',
        ],
        'userUploads' => [
            'base' => wp_get_upload_dir()['baseurl'].'/totalsurvey/uploads',
        ],
        'userReports' => [
            'base' => wp_normalize_path(wp_get_upload_dir()['baseurl'].'/totalsurvey/reports'),
        ],
        'blogFeed'    => 'https://totalsuite.net/wp-json/wp/v2/blog_article',
        'tracking'    => [
            'nps'         => 'https://collect.totalsuite.net/nps',
            'uninstall'   => 'https://collect.totalsuite.net/uninstall',
            'environment' => 'https://collect.totalsuite.net/env',
            'events'      => 'https://collect.totalsuite.net/event',
            'log'         => 'https://collect.totalsuite.net/log',
            'onboarding'  => 'https://collect.totalsuite.net/onboarding',
        ],
        'activation'  => [
            'activate' => 'https://totalsuite.net/api/v3/activate',
            'license'  => 'https://totalsuite.net/api/v3/license',
        ],

    ],
    'db'         => [
        'prefix' => $GLOBALS['wpdb']->prefix,
    ],
    'stores'     => [
        'optionsKey'  => 'totalsurvey_options',
        'modulesKey'  => 'totalsurvey_modules',
        'versionKey'  => 'totalsurvey_version',
        'trackingKey' => 'totalsurvey_tracking',
    ],
    'defaults'   => [
        'options' => GetDefaultOptions::invoke(),
    ],
];
