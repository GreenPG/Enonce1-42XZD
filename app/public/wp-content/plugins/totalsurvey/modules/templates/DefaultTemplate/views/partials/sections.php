<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Section;
use TotalSurvey\Views\Template;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

/**
 * @var Collection | Section $sections
 * @var string $survey
 * @var Section $section
 * @var Template $template
 */
?>
<sections inline-template>
    <div class="sections">
        <?php echo $template->view('partials/welcome') ?>
        <?php foreach ($survey->sections as $sectionIndex => $section) : ?>
            <section-item
                    inline-template
                    uid="<?php echo $section->uid; ?>"
                    :index="<?php echo $sectionIndex ?>"
                    @submit="validate($event)"
                    @previous="previous($event)"
                    @restart="restart($event)"
                    @input="input($event)">
                <transition name="fade" mode="in-out" appear>
                    <form class="section"
                          @submit.prevent="submit($event)"
                          @input="input($event)"
                          v-show="isVisible">
                        <h3 class="section-title"><?php echo $section['title']; ?></h3>
                        <p class="section-description"><?php echo nl2br($section['description']); ?></p>
                        <?php echo $template->view('partials/blocks', ['section' => $section]) ?>

                        <div class="section-buttons">
                            <template v-if="index > 0">
                                <button tabindex="-1" class="button -link section-reset"
                                        @click.prevent="restart()">
                                    <?php esc_html_e('Start over', 'totalsurvey'); ?>
                                </button>
                                <button class="button section-previous"
                                        @click.prevent="previous()">
                                    <?php esc_html_e('Previous', 'totalsurvey'); ?>
                                </button>
                            </template>
                            <button class="button -primary section-submit">
                                <template v-if="shouldSubmit">

                                    <?php  esc_html_e('Submit', 'totalsurvey'); ?>
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
        <?php echo $template->view('partials/thankyou') ?>
    </div>
</sections>
