<?php

namespace TotalSurvey\Pages;
! defined( 'ABSPATH' ) && exit();


use Exception;
use TotalSurvey\Capabilities\UserCanCreateSurvey;
use TotalSurvey\Capabilities\UserCanDeleteEntries;
use TotalSurvey\Capabilities\UserCanDeleteSurvey;
use TotalSurvey\Capabilities\UserCanExportData;
use TotalSurvey\Capabilities\UserCanExportEntries;
use TotalSurvey\Capabilities\UserCanManageModules;
use TotalSurvey\Capabilities\UserCanManageOptions;
use TotalSurvey\Capabilities\UserCanUpdateSurvey;
use TotalSurvey\Capabilities\UserCanViewData;
use TotalSurvey\Capabilities\UserCanViewEntries;
use TotalSurvey\Capabilities\UserCanViewSurveys;
use TotalSurvey\Events\Backoffice\OnBackofficeAssetsEnqueued;
use TotalSurvey\Models\Block;
use TotalSurvey\Models\Section;
use TotalSurvey\Models\Survey;
use TotalSurvey\Plugin;
use TotalSurvey\Services\WorkflowRegistry;
use TotalSurvey\Tasks\Presets\GetDefaultPresets;
use TotalSurvey\Tasks\Surveys\GetSurveyDefaults;
use TotalSurvey\Tasks\Utils\GetExpressions;
use TotalSurvey\Tasks\Utils\GetLanguages;
use TotalSurvey\Tasks\Utils\GetRoles;
use TotalSurveyVendors\TotalSuite\Foundation\License;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Admin\Page;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Promotion\GetModules;

/**
 * Class Dashboard
 *
 * @package TotalSurvey\Pages
 */
class Dashboard extends Page
{
    public function register()
    {
        parent::register();

        $slug    = $this->slug();
        $submenu = [
            "{$slug}#/dashboard"         => __('Dashboard', 'totalsurvey'),
            "{$slug}#/surveys"           => __('Surveys', 'totalsurvey'),
            "{$slug}#/modules/template"  => __('Templates', 'totalsurvey'),
            "{$slug}#/modules/extension" => __('Extensions', 'totalsurvey'),
            "{$slug}#/options"           => __('Options', 'totalsurvey'),
            "{$slug}#/support"           => __('Support', 'totalsurvey'),
        ];
        foreach ($submenu as $slug => $label) {
            add_submenu_page(
                $this->slug(),
                $label,
                $label,
                $this->capability(),
                $slug,
                [$this, 'render']
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function assets()
    {
        // Disable emoji
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');

        $baseUrl = Plugin::env('url.base', '');

        OnBackofficeAssetsEnqueued::emit();

        wp_enqueue_media();
        wp_enqueue_style('material-font', 'https://fonts.googleapis.com/icon?family=Material+Icons');
        wp_enqueue_script('runtime', $baseUrl.'/assets/backoffice/runtime.js', [], Plugin::env('version'));
        wp_enqueue_script('polyfills', $baseUrl.'/assets/backoffice/polyfills.js', [], Plugin::env('version'));
        wp_enqueue_script('vendor', $baseUrl.'/assets/backoffice/vendor.js', [], Plugin::env('version'));

        wp_enqueue_style('styles', $baseUrl.'/assets/backoffice/styles.css', [], Plugin::env('version'));
        wp_enqueue_script('main', $baseUrl.'/assets/backoffice/main.js', [], Plugin::env('version'), true);
        wp_localize_script('main', 'APP_CONFIG', $this->getConfig());
    }

    /**
     * @inheritDoc
     */
    public function icon(): string
    {
        return 'dashicons-index-card';
    }

    /**
     * @inheritDoc
     */
    public function capability(): string
    {
        return UserCanViewSurveys::NAME;
    }

    /**
     * @inheritDoc
     */
    public function title(): string
    {
        return __('TotalSurvey', 'totalsurvey');
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function data(): array
    {
        return [
            'baseUrl'  => Plugin::env('url.base'),
            'config'   => $this->getConfig(),
            'basePath' => Plugin::env('path.base'),
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getConfig(): array
    {
        $baseUrl    = Plugin::env('url.base').'/';
        $apiBaseUrl = rest_url(Plugin::env('url.apiBase'));
        $wpBaseUrl  = rest_url();
        $wpNonce    = wp_create_nonce('wp_rest');

        $postTypes = [
            [
                'icon'  => 'select_all',
                'name'  => 'Site-wide',
                'value' => 'all',
            ],
            [
                'icon'  => 'home',
                'name'  => 'Home',
                'value' => 'home',
            ],
            [
                'icon'  => 'description',
                'name'  => 'Post',
                'value' => 'post',
            ],
            [
                'icon'  => 'class',
                'name'  => 'Page',
                'value' => 'page',
            ],
        ];

        foreach ((array) get_post_types(['public' => true, '_builtin' => false], 'objects') as $postType) {
            $postTypes[] = [
                'icon'  => 'insert_drive_file',
                'name'  => $postType->labels->singular_name,
                'value' => $postType->name,
            ];
        }

        return [
            'baseUrl'     => $baseUrl,
            'api'         => [
                'wp'    => $wpBaseUrl,
                'base'  => $apiBaseUrl,
                'nonce' => $wpNonce,
            ],
            'presets'     => GetDefaultPresets::invoke(),
            'postTypes'   => $postTypes,
            'defaults'    => GetSurveyDefaults::invoke(),
            'languages'   => GetLanguages::invoke(),
            'expressions' => GetExpressions::invoke(),
            'workflows'   => WorkflowRegistry::instance()->toArray(),
            'modules'     => GetModules::invoke(),
            'currentUser' => [
                'name'  => wp_get_current_user()->display_name,
                'email' => wp_get_current_user()->user_email,
            ],

            'support'       => [
                'url'           => 'https://totalsuite.net/support/?utm_source=support-panel&utm_medium=in-app&utm_campaign=totalsurvey',
                'documentation' => 'https://totalsuite.net/product/totalsurvey/documentation/?utm_source=support-panel&utm_medium=in-app&utm_campaign=totalsurvey',
                'search'        => 'https://totalsuite.net/search/?utm_source=support-panel&utm_medium=in-app&utm_campaign=totalsurvey',
                'sections'      => [
                    [
                        'title' => 'Get started',
                        'items' => [
                            [
                                'title' => 'How to install TotalSurvey',
                                'url'   => 'https://totalsuite.net/documentation/totalsurvey/basics-totalsurvey/how-to-install-totalsurvey/?utm_source=support-panel&utm_medium=in-app&utm_campaign=totalsurvey',
                            ],
                            [
                                'title' => 'How to create a survey',
                                'url'   => 'https://totalsuite.net/documentation/totalsurvey/basics-totalsurvey/how-to-create-a-survey/?utm_source=support-panel&utm_medium=in-app&utm_campaign=totalsurvey',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Take a step further',
                        'items' => [
                            [
                                'title' => 'How to integrate the survey',
                                'url'   => 'https://totalsuite.net/documentation/totalsurvey/basics-totalsurvey/how-to-integrate-the-survey/?utm_source=support-panel&utm_medium=in-app&utm_campaign=totalsurvey',
                            ],
                            [
                                'title' => 'How to customize the appearance of the survey',
                                'url'   => 'https://totalsuite.net/documentation/totalsurvey/basics-totalsurvey/how-to-customize-the-appearance-of-the-survey/?utm_source=support-panel&utm_medium=in-app&utm_campaign=totalsurvey',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Entries management',
                        'items' => [
                            [
                                'title' => 'How to browse entries',
                                'url'   => 'https://totalsuite.net/documentation/totalsurvey/basics-totalsurvey/how-to-browse-entries/?utm_source=support-panel&utm_medium=in-app&utm_campaign=totalsurvey',
                            ],
                            [
                                'title' => 'How to delete or reset entries',
                                'url'   => 'https://totalsuite.net/documentation/totalsurvey/basics-totalsurvey/how-to-delete-or-reset-entries/?utm_source=support-panel&utm_medium=in-app&utm_campaign=totalsurvey',
                            ],
                        ],
                    ],
                ],
                'codex'         => 'https://totalsuite.net/documentation/totalsurvey/codex/?utm_source=support-panel&utm_medium=in-app&utm_campaign=totalsurvey',
            ],
            'roles'         => GetRoles::invoke(),
            'product'       => Plugin::env('product'),
            'customer'      => Plugin::options(
                'customer',
                [
                    'status'     => 'init',
                    'email'      => '',
                    'signup'     => false,
                    'audience'   => 'other',
                    'usage'      => 'other',
                    'tracking'   => false,
                    'newsletter' => false,
                ]
            ),
            'license'       => License::instance()->toArray(),
            'onboarding'    => [
                'url'   => [
                    'documentation' => 'https://totalsuite.net/product/totalsurvey/documentation/',
                    'store'         => 'https://totalsuite.net/product/totalsurvey/add-ons/',
                ],
                'steps' => [
                    'welcome'      => [
                        'title' => __('Hey mate!', 'totalsurvey'),
                        'text'  => __(
                            'We are delighted to see you started using TotalSurvey, <br> TotalSurvey will impress you, we promise!',
                            'totalsurvey'
                        ),
                        'tabs'  => [
                            [
                                'icon'  => 'touch_app',
                                'title' => __('User Friendly', 'totalsurvey'),
                                'text'  => __(
                                    "Crafting surveys isn't easy but with TotalSurvey, it's a joyful experience.",
                                    'totalsurvey'
                                ),
                            ],
                            [
                                'icon'  => 'style',
                                'title' => __('Elegant Design', 'totalsurvey'),
                                'text'  => __(
                                    "A good-looking survey could help you achieve a better response rate.",
                                    'totalsurvey'
                                ),
                            ],
                            [
                                'icon'  => 'power',
                                'title' => __('Flexibility & Extensibility', 'totalsurvey'),
                                'text'  => __(
                                    "Build highly flexible surveys to achieve unprecedented results.",
                                    'totalsurvey'
                                ),
                            ],
                        ],
                    ],
                    'introduction' => [
                        'title' => __('Get started', 'totalsurvey'),
                        'text'  => __(
                            "We've prepared some materials for you to ease your learning curve.",
                            'totalsurvey'
                        ),
                        'posts' => [
                            [
                                'title' => __("How to create a survey", "totalsurvey"),
                                'text'  => __(
                                    "Learn how to create a survey in no time using TotalSurvey.",
                                    "totalsurvey"
                                ),
                                'image' => "assets/images/onboarding/create.svg",
                                'url'   => "https://totalsuite.net/documentation/totalsurvey/basics-totalsurvey/how-to-create-a-survey/",
                            ],
                            [
                                'title' => __("How to integrate a survey", "totalsurvey"),
                                'text'  => __(
                                    "Once your survey is ready, we'll show you how to integrate it into your site.",
                                    "totalsurvey"
                                ),
                                'image' => "assets/images/onboarding/integrate.svg",
                                'url'   => "https://totalsuite.net/documentation/totalsurvey/basics-totalsurvey/how-to-integrate-the-survey/",
                            ],
                            [
                                'title' => __("How to customize appearance", "totalsurvey"),
                                'text'  => __(
                                    "Learn how to customize the appearance of the survey to match your brand.",
                                    "totalsurvey"
                                ),
                                'image' => "assets/images/onboarding/integrate.svg",
                                'url'   => "https://totalsuite.net/documentation/totalsurvey/basics-totalsurvey/how-to-customize-the-appearance-of-the-survey/",
                            ],
                        ],
                    ],
                    'connect'      => [
                        'title'       => __('Get started', 'totalsurvey'),
                        'text'        => __(
                            "We've prepared some materials for you to ease your learning curve.",
                            'totalsurvey'
                        ),
                        'information' => [
                            __('Let you know about the upcoming features.', 'totalsurvey'),
                            __('Inform you about important updates.', 'totalsurvey'),
                            __('Adjust recommendations.', 'totalsurvey'),
                            __('Adapt product settings.', 'totalsurvey'),
                            __('Send you exclusive offers.', 'totalsurvey'),
                        ],
                    ],
                    'finish'       => [
                        'title'       => __('Bravo! You did it!', 'totalsurvey'),
                        'text'        => __(
                            "You are all set to start making informed decisions! One last thing, we'd like to collect some anonymous usage information that will help us shape up TotalSurvey.",
                            'totalsurvey'
                        ),
                        'information' => [
                            __('Make TotalSurvey stable and bug-free.', 'totalsurvey'),
                            __('Get an overview of environments.', 'totalsurvey'),
                            __('Optimize performance.', 'totalsurvey'),
                            __('Adjust default parameters.', 'totalsurvey'),
                        ],
                    ],
                ],
            ],
            'translatables' => [
                'survey'  => Survey::getTranslatableAttributes(),
                'section' => Section::getTranslatableAttributes(),
                'block'   => Block::getTranslatableAttributes(),
            ],
            'capabilities'  => [
                'create_survey'  => UserCanCreateSurvey::check(),
                'delete_entries' => UserCanDeleteEntries::check(),
                'delete_survey'  => UserCanDeleteSurvey::check(),
                'export_data'    => UserCanExportData::check(),
                'export_entries' => UserCanExportEntries::check(),
                'manage_modules' => UserCanManageModules::check(),
                'manage_options' => UserCanManageOptions::check(),
                'update_survey'  => UserCanUpdateSurvey::check(),
                'view_data'      => UserCanViewData::check(),
                'view_entries'   => UserCanViewEntries::check(),
                'view_surveys'   => UserCanViewSurveys::check(),
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function template(): string
    {
        return 'dashboard';
    }
}
