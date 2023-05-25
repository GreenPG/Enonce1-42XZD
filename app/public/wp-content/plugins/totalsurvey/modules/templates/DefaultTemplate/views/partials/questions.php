<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\FieldManager;
use TotalSurvey\Models\Question;
use TotalSurvey\Models\Section;
use TotalSurvey\Template;

/**
 * @var Section $section
 * @var Question $question
 * @var Template $template
 * @var FieldManager $fields
 */
?>

<?php foreach ($section->questions as $questionIndex => $question): ?>
    <question inline-template
              uid="<?php echo $question->uid; ?>"
              :index="<?php echo $questionIndex; ?>">
        <div class="question">
            <label for="<?php echo esc_attr($question->field->uid) ?>"
                   class="question-title"
                   :class="{required: isRequired, '-error': error}">
                <?php echo strip_tags($question->title, '<br>'); ?>
            </label>
            <p class="question-description">
                <?php echo esc_html($question->description) ?>
            </p>
            <div class="question-field"
                 <?php if ($question->field->allowOthers()): ?>v-other<?php endif; ?>>
                <?php echo $fields->render($question->field); ?>
                <p class="question-error">{{ error }}</p>
            </div>
        </div>
    </question>
<?php endforeach; ?>