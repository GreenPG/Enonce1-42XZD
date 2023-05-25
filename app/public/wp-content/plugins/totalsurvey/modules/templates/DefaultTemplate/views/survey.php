<?php
! defined( 'ABSPATH' ) && exit();
 use TotalSurvey\Models\Section;
use TotalSurvey\Models\Survey;
use TotalSurvey\Tasks\Utils\GetAllowedSurveyTags;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Template;

/**
 * @var string $apiBase
 * @var string $nonce
 * @var Template $template
 * @var Survey $survey
 * @var string $customCss
 * @var string $language
 * @var Collection | Section $sections
 * @var string $survey
 * @var Section $section
 * @var Template $template
 */
?>
<template data-survey-uid="<?php echo esc_attr($survey->uid); ?>" class="totalsurvey-template">
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

    <!--  survey  -->
    <survey
            inline-template
            v-bind:survey="<?php echo esc_attr(htmlentities(json_encode($survey), ENT_QUOTES)) ?>"
            nonce="<?php echo esc_attr($nonce); ?>"
            language="<?php echo esc_attr($language); ?>"
            v-bind:api-base="'<?php echo esc_attr($apiBase); ?>'"
            id="survey">
        <div class="survey" v-bind:class="{'is-done': isFinished}" <?php language_attributes(); ?>>
            <h1 class="survey-title" v-text="survey.name"><?php echo esc_html($survey->name) ?></h1>
            <p class="survey-description" v-text="survey.description"><?php echo esc_html($survey->description) ?></p>
            <div class="loader" v-bind:class="{'is-loading': isLoading}"></div>

            <progress-status inline-template>
                <div class="survey-progress">
                    <span class="survey-progress-done" v-bind:class="{'-done': isCompleted}"></span>
                    <span class="survey-progress-bar" v-bind:style="{width: progressPercentage}"></span>
                </div>
            </progress-status>

            <error-message inline-template>
                <div class="survey-error" v-show="error">
                    <span v-text="error"></span>
                    <span class="survey-error-button" v-on:click.prevent="dismiss()"></span>
                </div>
            </error-message>

            <sections inline-template>
                <div class="sections">

                    <?php /**
                     * @var Template $template
                     * @var Survey $survey
                     */

                    $welcomeBlocks = $survey->getWelcomeBlocks();
                    if (! empty($welcomeBlocks) ): ?>
                        <section-item uid="welcome" inline-template v-on:next="next()">
                            <transition name="fade">
                                <section class="section welcome" v-show="isVisible">

                                    <?php foreach ($welcomeBlocks as $block): ?>
                                        <?php echo wp_kses($block->render(), GetAllowedSurveyTags::invoke()); ?>
                                    <?php endforeach; ?>
                                    <a v-on:click.prevent="next()" class="button -primary"><?php echo esc_html__('Start survey', 'totalsurvey') ?></a>
                                </section>
                            </transition>
                        </section-item>
                    <?php endif; ?>

                    <?php foreach ($survey->sections as $sectionIndex => $section) : ?>
                        <section-item
                            inline-template
                            uid="<?php echo esc_attr($section->uid); ?>"
                            v-bind:index="<?php echo esc_attr($sectionIndex); ?>"
                            v-on:submit="validate($event)"
                            v-on:previous="previous($event)"
                            v-on:restart="restart($event)"
                            v-on:input="input($event)">
                            <transition name="fade" mode="in-out" appear>
                                <form class="section"
                                      v-on:submit.prevent="submit($event)"
                                      v-on:input="input($event)"
                                      v-show="isVisible">
                                    <h3 class="section-title"><?php echo esc_html($section['title']); ?></h3>
                                    <p class="section-description"><?php echo nl2br(esc_html($section['description'])); ?></p>

                                    <?php foreach ($section->blocks as $blockIndex => $block): ?>

                                        <?php if($block->isQuestion()): ?>
                                            <question inline-template
                                                      uid="<?php echo esc_attr($block->uid); ?>"
                                                      v-bind:index="<?php echo esc_attr($blockIndex); ?>">
                                                <div class="question">
                                                    <label for="<?php echo esc_attr($block->uid) ?>"
                                                           class="question-title"
                                                           v-bind:class="{required: isRequired, '-error': error}">
                                                        <?php echo strip_tags($block->title, '<br>'); ?>
                                                    </label>
                                                    <p class="question-description">
                                                        <?php echo esc_html($block->description) ?>
                                                    </p>
                                                    <div class="question-field" <?php if ($block->field->allowOther()): ?>v-other<?php endif; ?>>
                                                        <?php echo wp_kses($block->render(), GetAllowedSurveyTags::invoke()); ?>
                                                        <p class="question-error">{{ error }}</p>
                                                    </div>
                                                </div>
                                            </question>
                                        <?php else: ?>
                                            <?php echo wp_kses($block->render(), GetAllowedSurveyTags::invoke()); ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>


                                    <div class="section-buttons">
                                        <template v-if="index != 0">
                                            <button tabindex="-1" class="button -link section-reset"
                                                    v-on:click.prevent="restart()">
                                                <?php esc_html_e('Start over', 'totalsurvey'); ?>
                                            </button>
                                            <button class="button section-previous"
                                                    v-on:click.prevent="previous()">
                                                <?php esc_html_e('Previous', 'totalsurvey'); ?>
                                            </button>
                                        </template>
                                        <button class="button -primary section-submit">
                                            <template v-if="shouldSubmit">

                                                <?php esc_html_e('Submit', 'totalsurvey'); ?>
                                            </template>
                                            <template v-else>
                                                <?php esc_html_e('Next', 'totalsurvey'); ?>
                                            </template>
                                        </button>
                                    </div>
                                </form>
                            </transition>
                        </section-item>
                    <?php endforeach; ?>

                    <?php /**
                     * @var Template $template
                     * @var Survey $survey
                     */
                    $thankYouBlocks = $survey->getThankYouBlocks();
                    ?>
                    <section-item uid="thankyou" inline-template v-on:reload="reload($event)">
                        <transition name="fade">
                            <section class="section thankyou" v-show="isVisible">
                                <p v-if="lastEntry.customThankYouMessage" v-html="lastEntry.customThankYouMessage"></p>
                                <template v-else>
                                    <?php foreach ($thankYouBlocks as $block): ?>
                                        <?php echo wp_kses($block->render(), GetAllowedSurveyTags::invoke()); ?>
                                    <?php endforeach; ?>
                                </template>

                                <div class="section-buttons">
                                    <button type="button" v-on:click="reload()" class="button -primary" v-if="canRestart">
                                        <?php echo esc_html__('Submit another entry', 'totalsurvey') ?>
                                    </button>
                                    <div class="alt-actions" v-if="canViewEntry">
                                        <a v-bind:href="lastEntry.url"
                                           v-print
                                           target="_blank"
                                           class="button print">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg>
                                            <?php echo esc_html__('Print', 'totalsurvey') ?>
                                        </a>
                                        <a v-bind:href="lastEntry.url"
                                           target="_blank"
                                           class="button">

                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
                                            <?php echo esc_html__('View', 'totalsurvey') ?>
                                        </a>
                                    </div>
                                </div>
                            </section>
                        </transition>
                    </section-item>

                </div>
            </sections>

        </div>
    </survey>

    <?php echo esc_html($after); ?>
</template>
