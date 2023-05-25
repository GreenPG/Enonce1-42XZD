<?php


namespace TotalSurvey\Gutenberg;
! defined( 'ABSPATH' ) && exit();


use Exception;
use TotalSurvey\Models\Survey;
use TotalSurvey\Plugin;
use TotalSurvey\Tasks\Surveys\DisplaySurvey;

class SurveyBlock
{
    /**
     * Register assets.
     */
    protected static function registerAssets()
    {
        if (is_admin()) {
            wp_register_script(
                'totalsurvey-survey-block-editor',
                Plugin::env('url.base') . '/assets/js/survey-block.js',
                [
                    'wp-blocks',
                    'wp-element'
                ],
                null
            );
        }
    }

    /**
     * Register block type.
     */
    protected static function registerType()
    {
        register_block_type(
            'totalsurvey/survey',
            [
                'editor_script'   => 'totalsurvey-survey-block-editor',
                'editor_style'    => 'totalsurvey-survey-block-editor',
                'render_callback' => function ($attributes = [], $content = null, $block = null) {
                    if ( ! empty($attributes['surveyId']) && ! is_admin()) {
                        try {
                            $id     = (int)$attributes['surveyId'];
                            $survey = Survey::byIdAndActive($id);

                            return DisplaySurvey::invoke($survey);
                        } catch (Exception $e) {
                            return $e->getMessage();
                        }
                    }

                    return '';
                },
            ]
        );
    }

    /**
     * Prepare some data for the block.
     */
    protected static function provideValues()
    {
        add_action(
            'admin_head-post.php',
            static function () {
                if (wp_script_is('totalsurvey-survey-block-editor', 'done')) {
                    $surveys = Survey::all()
                                     ->map(
                                         static function (Survey $survey) {
                                             return ['id' => $survey->id, 'name' => $survey->name];
                                         }
                                     );

                    printf(
                        '<script type="text/javascript">var TotalSurveyData = %s</script>',
                        json_encode(['surveys' => $surveys], JSON_UNESCAPED_UNICODE)
                    );
                }
            }
        );
    }

    /**
     * Register the block.
     */
    public static function register()
    {
        add_action(
            'init',
            static function () {
                if (function_exists('register_block_type')) {
                    self::registerAssets();
                    self::registerType();
                    self::provideValues();
                }
            }
        );
    }
}
