<?php
! defined( 'ABSPATH' ) && exit();
 use TotalSurvey\Extensions\Insights\Models\QuestionItem;
use TotalSurvey\Extensions\Insights\Models\SectionItem;
use TotalSurvey\Models\Section;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Template;

/**
 * @var Template $template
 * @var string $surveyUid
 * @var bool $embed
 * @var Collection | SectionItem $sections
 * @var SectionItem $section
 * @var QuestionItem $question
 * @var array $assets
 */

/**
 * @var Section $section
 * @var Template $template
 */

?>
<template class="totalsurvey-insights-template">

    <!--  style   -->
    <?php echo wp_kses(
        $template->view('partials/style'), [
        'survey-link'      => [
            'rel'         => [],
            'href'         => [],
            'type'         => [],
        ],
        'survey-style'      => [
            'hidden'         => [],
        ],
    ]);
    ?>

    <?php echo esc_html($before); ?>

    <survey-insights inline-template
                     id="survey-insights"
                     class="insights-sections"
                     v-bind:sections="<?php echo esc_attr(htmlentities(json_encode($sections), ENT_QUOTES)) ?>"
                     survey_uid="<?php echo esc_attr(htmlentities($surveyUid, ENT_QUOTES)) ?>"
                     embed="<?php echo esc_attr($embed ? 1 : 0) ?>">
        <div>

            <?php foreach ($sections as $sectionIndex => $section) : ?>
                <survey-insights-section inline-template
                                         class="section"
                                         uid="<?php echo esc_attr($section["uid"]); ?>">
                    <div>
                        <template v-if="empty">
                            <section class="questions-group">
                                <p class="text-center"><?php esc_html_e('No data available.', 'totalsurvey'); ?></p>
                            </section>
                        </template>

                        <template v-else>
                            <h3 class="section-title"> {{section.title}}</h3>
                            <?php foreach ($section['blocks'] as $questionIndex => $question) : ?>
                                <survey-insights-question inline-template
                                                          class="question"
                                                          index="<?php echo esc_attr($questionIndex); ?>">
                                    <div class="card">
                                        <div class="header">
                                            <h5 class="title">{{question.title}}</h5>
                                        </div>
                                        <div class="body">
                                            <template v-if="question_empty">
                                                <section class="questions-group">
                                                    <p class="text-center"><?php esc_html_e('No data to visualize.', 'totalsurvey'); ?></p>
                                                </section>
                                            </template>
                                            <template v-else>
                                                <div class="row">
                                                    <div class="col-md-5 chart-container">
                                                        <canvas
                                                            ref="<?php echo esc_attr( "chart-".$section["uid"]."-".$questionIndex ); ?>"
                                                            width="240">
                                                        </canvas>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="footer" v-if="question.type === 'rating' ">
                                                <span
                                                    class="footer-item"><?php esc_html_e('Average rating:', 'totalsurvey'); ?> <strong>{{ question.average }}</strong></span>
                                            <span
                                                class="footer-item"><?php esc_html_e('Total entries:', 'totalsurvey'); ?> <strong>{{ question.total  }}</strong></span>
                                        </div>
                                    </div>

                                </survey-insights-question>
                            <?php endforeach; ?>
                        </template>
                    </div>
                </survey-insights-section>
            <?php endforeach; ?>

        </div>
    </survey-insights>

    <?php echo esc_html($after); ?>
</template>
