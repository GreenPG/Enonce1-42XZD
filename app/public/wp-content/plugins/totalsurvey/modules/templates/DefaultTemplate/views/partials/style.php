<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Colors;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Template;

/**
 * @var Template $template
 * @var Survey   $survey
 * @var array   $assets
 * @var string $customCss
 */

?>
<?php foreach ($assets['css'] as $css): ?>
<survey-link rel="stylesheet" href="<?php echo esc_attr($css); ?>" type="text/css"></survey-link>
<?php endforeach; ?>
<survey-style hidden>
    :host {
    --color-primary: <?php echo esc_html($survey->getDesignSettings('colors.primary.base')); ?>;
    --color-primary-dark: <?php echo esc_html(Colors::darken($survey->getDesignSettings('colors.primary.base'), 20)); ?>;
    --color-primary-light: <?php echo esc_html(Colors::lignten($survey->getDesignSettings('colors.primary.base'), 88)); ?>;
    --color-primary-alpha: <?php echo esc_html(Colors::opacity($survey->getDesignSettings('colors.primary.base'), 0.25)); ?>;
    --color-primary-contrast: <?php echo esc_html($survey->getDesignSettings('colors.primary.contrast')); ?>;

    --color-secondary: <?php echo esc_html($survey->getDesignSettings('colors.secondary.base')); ?>;
    --color-secondary-dark: <?php echo esc_html(Colors::darken($survey->getDesignSettings('colors.secondary.base'), 20)); ?>;
    --color-secondary-contrast: <?php echo esc_html($survey->getDesignSettings('colors.secondary.contrast')); ?>;
    --color-secondary-alpha: <?php echo esc_html(Colors::opacity($survey->getDesignSettings('colors.secondary.base'), 0.25)); ?>;
    --color-secondary-light: <?php echo esc_html(Colors::lignten($survey->getDesignSettings('colors.secondary.base'), 88)); ?>;

    --color-success: <?php echo esc_html($survey->getDesignSettings('colors.success.base')); ?>;
    --color-success-dark: <?php echo esc_html(Colors::darken($survey->getDesignSettings('colors.success.base'), 20)); ?>;
    --color-success-light: <?php echo esc_html(Colors::lignten($survey->getDesignSettings('colors.success.base'), 33)); ?>;

    --color-error: <?php echo esc_html($survey->getDesignSettings('colors.error.base')); ?>;
    --color-error-dark: <?php echo esc_html(Colors::darken($survey->getDesignSettings('colors.error.base'), 20)); ?>;
    --color-error-alpha: <?php echo esc_html(Colors::opacity($survey->getDesignSettings('colors.error.base'), 0.25)); ?>;
    --color-error-light: <?php echo esc_html(Colors::lignten($survey->getDesignSettings('colors.error.base'), 90)); ?>;

    --color-background: <?php echo esc_html($survey->getDesignSettings('colors.background.base')); ?>;
    --color-background-dark: <?php echo esc_html(Colors::darken($survey->getDesignSettings('colors.background.base'), 20)); ?>;
    --color-background-contrast: <?php echo esc_html($survey->getDesignSettings('colors.background.contrast')); ?>;
    --color-background-light: <?php echo esc_html(Colors::lignten($survey->getDesignSettings('colors.background.base'), 95)); ?>;

    --color-dark: <?php echo esc_html($survey->getDesignSettings('colors.dark.base')); ?>;
    --color-dark-contrast: <?php echo esc_html($survey->getDesignSettings('colors.dark.contrast')); ?>;
    --color-dark-alpha: <?php echo esc_html(Colors::opacity($survey->getDesignSettings('colors.dark.base'), 0.05)); ?>;

    --size: var(<?php echo esc_html(sprintf('--size-%s', $survey->getDesignSettings('size'))); ?>);
    --space: var(<?php echo esc_html(sprintf('--space-%s', $survey->getDesignSettings('space'))); ?>);
    --radius: var(<?php echo esc_html(sprintf('--radius-%s', $survey->getDesignSettings('radius'))); ?>);
    }
</survey-style>
<survey-style hidden><?php echo esc_html($customCss); ?></survey-style>
