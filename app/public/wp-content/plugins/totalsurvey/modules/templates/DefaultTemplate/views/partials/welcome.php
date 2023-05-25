<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Template;

/**
 * @var Template $template
 * @var Survey $survey
 */

$welcomeBlocks = $survey->getWelcomeBlocks();
if (! empty($welcomeBlocks) ): ?>
    <section-item uid="welcome" inline-template @next="next()">
        <transition name="fade">
            <section class="section welcome" v-show="isVisible">
               
                <?php foreach ($welcomeBlocks as $block): ?>
                    <?php echo $block->render(); ?>
                <?php endforeach; ?>
                <a @click.prevent="next()" class="button -primary"><?php echo __('Start survey', 'totalsurvey') ?></a>
            </section>
        </transition>
    </section-item>
<?php endif; ?>
