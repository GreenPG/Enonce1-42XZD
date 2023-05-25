<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurvey\Models\Entry;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Template;

/**
 * @var Template $template
 * @var Survey $survey
 */
$thankYouBlocks = $survey->getThankYouBlocks();
?>
<section-item uid="thankyou" inline-template @reload="reload($event)">
    <transition name="fade">
        <section class="section thankyou" v-show="isVisible">
            <p v-if="lastEntry.customThankYouMessage" v-html="lastEntry.customThankYouMessage"></p>
            <template v-else>
                <?php
                foreach ($thankYouBlocks as $block): ?>
                    <?php
                    echo $block->render(); ?>
                <?php
                endforeach;
                ?>
            </template>

            <div class="section-buttons">
                <button type="button" @click="reload()" class="button -primary" v-if="canRestart">
                    <?php echo __('Submit another entry', 'totalsurvey') ?>
                </button>
                <div class="alt-actions" v-if="canViewEntry">
                    <a :href="lastEntry.url"
                       onclick="window.open(this.href).print()"
                       target="_blank"
                       class="button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg>
                        <?php echo __('Print', 'totalsurvey') ?>
                    </a>
                    <a :href="lastEntry.url"
                       target="_blank"
                       class="button">

                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
                        <?php echo __('View', 'totalsurvey') ?>
                    </a>
                </div>
            </div>
        </section>
    </transition>
</section-item>
