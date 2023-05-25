<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Block;
use TotalSurvey\Models\Section;
use TotalSurvey\Views\Template;

/**
 * @var Section $section
 * @var Block $block
 * @var Template $template
 */
?>

<?php foreach ($section->blocks as $blockIndex => $block): ?>

    <?php if($block->isQuestion()): ?>
    <question inline-template
              uid="<?php echo $block->uid; ?>"
              :index="<?php echo $blockIndex; ?>">
        <div class="question">
            <label for="<?php echo esc_attr($block->uid) ?>"
                   class="question-title"
                   :class="{required: isRequired, '-error': error}">
                <?php echo strip_tags($block->title, '<br>'); ?>
            </label>
            <p class="question-description">
                <?php echo esc_html($block->description) ?>
            </p>
            <div class="question-field" <?php if ($block->field->allowOther()): ?>v-other<?php endif; ?>>
                <?php echo $block->render(); ?>
                <p class="question-error">{{ error }}</p>
            </div>
        </div>
    </question>
    <?php else: ?>
        <?php echo $block->render(); ?>
    <?php endif; ?>
<?php endforeach; ?>
