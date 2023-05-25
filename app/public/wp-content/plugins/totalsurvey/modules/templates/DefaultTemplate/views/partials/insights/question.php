<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Views\Template;

/**
 * @var \TotalSurvey\Extensions\Insights\Models\SectionItem $section
 * @var Template $template
 * @var int $questionIndex
 */
?>

<survey-insights-question inline-template
                          class="question"
                          index="<?php
                          echo $questionIndex; ?>">
    <div class="card">
        <div class="header">
            <h5 class="title">{{question.title}}</h5>
        </div>
        <div class="body">
            <template v-if="question_empty">
                <section class="questions-group">
                    <p class="text-center">No data to visualize.</p>
                </section>
            </template>
            <template v-else>
                <div class="row">
                    <div class="col-md-5 chart-container">

                        <canvas ref= <?php
                        echo "chart-".$section["uid"]."-".$questionIndex; ?>
                                width="240"
                        ></canvas>
                    </div>
                </div>
            </template>
        </div>
        <div class="footer" v-if="question.type === 'rating' ">
                                                <span
                                                    class="footer-item">Average rating: <strong>{{ question.average }}</strong></span>
            <span
                class="footer-item">Total entries: <strong>{{ question.total  }}</strong></span>
        </div>
    </div>

</survey-insights-question>



