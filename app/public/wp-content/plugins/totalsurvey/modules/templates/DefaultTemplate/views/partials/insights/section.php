<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Section;
use TotalSurvey\Views\Template;

/**
 * @var Section $section
 * @var Template $template
 */
?>
<survey-insights-section inline-template
                         class="section"
                         uid="<?php
                         echo $section["uid"]; ?>"
>

    <div>
        <template v-if="empty">
            <section class="questions-group">
                <p class="text-center">No data available</p>
            </section>
        </template>

        <template v-else>
            <h3 class="section-title"> {{section.title}}</h3>
            <?php
            foreach ($section['blocks'] as $questionIndex => $question) : ?>
                <?php
                echo $template->view(
                    'partials/insights/question',
                    ['questionIndex' => $questionIndex, 'section' => $section, 'question' => $question]
                ) ?>


            <?php
            endforeach; ?>
        </template>
    </div>
</survey-insights-section>
