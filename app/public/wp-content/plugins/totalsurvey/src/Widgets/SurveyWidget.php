<?php

namespace TotalSurvey\Widgets;
! defined( 'ABSPATH' ) && exit();


use Exception;
use TotalSurvey\Models\Survey;
use TotalSurvey\Tasks\Surveys\DisplaySurvey;
use TotalSurvey\Tasks\Surveys\GetSurveys;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Widget;

class SurveyWidget extends Widget
{
    public function __construct()
    {
        parent::__construct('totalsurvey-survey', __('Survey', 'totalsurvey'), [], []);
    }

    public function form($instance)
    {
        $surveys = GetSurveys::invoke(['per_page' => -1]);
        ?>
        <p>
            <label for="<?php
            echo esc_attr($this->get_field_id('survey')); ?>">
                <?php
                esc_attr_e('Survey:', 'totalsurvey'); ?>
            </label>
            <select class="widefat"
                    id="<?php
                    echo esc_attr($this->get_field_id('surveyId')); ?>"
                    name="<?php
                    echo esc_attr($this->get_field_name('surveyId')); ?>">
                <option value="0"><?php
                    _e('None', 'totalsurvey'); ?></option>
                <?php
                foreach ($surveys as $survey): ?>
                    <option value="<?php
                    echo esc_attr($survey->id); ?>"
                        <?php
                        echo selected($instance['surveyId'] ?? 0, $survey->id); ?>>
                        <?php
                        echo esc_html($survey->name); ?>
                    </option>
                <?php
                endforeach; ?>
            </select>
        </p>
        <?php
    }

    public function update($newInstance, $oldInstance)
    {
        return ['surveyId' => (int)($newInstance['surveyId'] ?? null)];
    }

    public function widget($args, $instance)
    {
        if ( ! empty($instance['surveyId'])) {
            try {
                $survey = Survey::byIdAndActive($instance['surveyId']);
                echo DisplaySurvey::invoke($survey);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public static function register()
    {
        add_action(
            'widgets_init',
            function () {
                register_widget(static::class);
            }
        );
    }
}
