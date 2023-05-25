<?php
! defined( 'ABSPATH' ) && exit();
 /**
 * @var \TotalSurvey\Models\Survey $survey
 * @var \TotalSurvey\Models\Entry $entry
 * @var string $content
 */

use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Colors;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php echo is_admin_bar_showing() ? 'with-admin-bar' : 'without-admin-bar'; ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>

    <style>
        :root {
            --color-primary: <?php echo esc_html($survey->getDesignSettings('colors.primary.base')); ?>;
            --color-primary-dark: <?php echo esc_html(Colors::darken($survey->getDesignSettings('colors.primary.base'), 20)); ?>;
            --color-primary-darker: <?php echo esc_html(Colors::darken($survey->getDesignSettings('colors.primary.base'), 40)); ?>;
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
            --color-darker: <?php echo esc_html(Colors::darken($survey->getDesignSettings('colors.dark.base'), 20)); ?>;
            --color-dark-contrast: <?php echo esc_html($survey->getDesignSettings('colors.dark.contrast')); ?>;
            --color-dark-alpha: <?php echo esc_html(Colors::opacity($survey->getDesignSettings('colors.dark.base'), 0.05)); ?>;

            --size: var(<?php echo esc_html(sprintf('--size-%s', $survey->getDesignSettings('size'))); ?>);
            --space: var(<?php echo esc_html(sprintf('--space-%s', $survey->getDesignSettings('space'))); ?>);
            --radius: var(<?php echo esc_html(sprintf('--radius-%s', $survey->getDesignSettings('radius'))); ?>);
        }
    </style>
    <style><?php echo esc_html($survey->getCustomCss()); ?></style>
    <style>
        html {
            overflow: auto;
        }

        body::before, body::after {
            display: none !important;
        }

        body {
            background: #eeeeee !important;
        }

        .totalsurvey-content {
            margin: 30px auto;
            max-width: 620px;
            background: #ffffff;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.05);
            border-radius: 6px;
        }

        .totalsurvey-warning {
            padding: 15px;
            background: #EF6C00;
            color: #FFFFFF;
            text-align: center;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.1);
        }

        @media screen and (max-width: 782px) {
            .totalsurvey-content {
                border-radius: 0;
                margin: auto;
            }
        }

        #totalsurvey-entry .section {
            padding: 24px;
            border-bottom: 1px solid #eeeeee;
        }

        #totalsurvey-entry .section > .title {
            color: var(--color-primary, #0288D1);
            margin-bottom: 24px;
            font-weight: normal;
        }

        #totalsurvey-entry .blocks {
            margin-top: 0;
            background: #f5f5f5;
            border-radius: 4px;
            padding: 6px;
        }

        #totalsurvey-entry .blocks + .blocks {
            margin-top: 12px;
        }

        #totalsurvey-entry .blocks .title {
            padding: 6px;
            color: #747474;
            font-weight: normal;
            font-size: 14px;
        }

        #totalsurvey-entry .blocks .text {
            margin: 0;
            background: white;
            border-radius: 4px;
            padding: 6px 12px;
            font-size: 16px;
        }

        #totalsurvey-entry .blocks .text:empty::before {
            content: "<?php esc_html('Not provided', 'totalsurvey'); ?>";
            opacity: 0.5;
            font-size: 14px;
        }

        #totalsurvey-entry .date {
            display: block;
            padding: 24px;
            line-height: 1;
        }

        #totalsurvey-entry .share {
            display: flex;
            padding: 24px;
            border-top: 1px solid #eeeeee;
        }

        #totalsurvey-entry .share .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            text-align: center;
            background: var(--color-primary, #0288D1);
            color: var(--color-primary-contrast, #FFFFFF);
            text-decoration: none;
            padding: 6px 0;
            border-radius: 4px;
            border: 0;
            font-size: 16px;
        }

        #totalsurvey-entry .share .button svg {
            margin-right: 6px;
            fill: currentColor;
        }

        #totalsurvey-entry .share .button:hover, #totalsurvey-entry .share .button:focus {
            background: var(--color-primary-dark, #0169a1);
        }

        #totalsurvey-entry .share .button:active {
            background: var(--color-primary-darker, #024a70);
        }

        #totalsurvey-entry .share .print {
            background: var(--color-dark, #444444);
        }

        #totalsurvey-entry .share .print:hover,
        #totalsurvey-entry .share .print:focus,
        #totalsurvey-entry .share .print:active {
            background: var(--color-darker, #333333);
        }

        #totalsurvey-entry .share .button + .button {
            margin-left: 6px;
        }

        #totalsurvey-entry .date {
            color: #a7a7a7;
            font-size: 14px;
            text-align: center;
        }

        #totalsurvey-entry .scoring {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px;
            border-bottom: 1px solid #eeeeee;
            font-size: 16px;
        }

        #totalsurvey-entry .scoring .item {
            flex: 1;
            text-align: center;
        }

        #totalsurvey-entry .scoring .item + .item {
            border-left: 1px solid #eeeeee;
        }

        @media print {
            #totalsurvey-entry .share {
                display: none;
            }

            #totalsurvey-entry .section {
                padding: 0 0 24px;
                border: 0;
            }

            #totalsurvey-entry .blocks,
            #totalsurvey-entry .blocks .title,
            #totalsurvey-entry .date {
                padding: 0;
                margin: 0;
                text-align: left;
                border: 0;
            }

            #totalsurvey-entry .date {
                margin-top: 16px;
            }

            #totalsurvey-entry .scoring {
                border: 1px solid #eeeeee;
            }

            .totalsurvey-content {
                box-shadow: none;
                padding: 0;
            }
        }


    </style>

</head>

<body <?php body_class(); ?>>

<main class="totalsurvey-content">
    <?php echo wp_kses($content, [
        'div'      => [
            'id'         => [],
            'class'         => [],
        ],
        'article'      => [
            'id'         => [],
            'class'         => [],
        ],
        'section'      => [
            'id'         => [],
            'class'         => [],
        ],
        'footer'      => [
            'id'         => [],
            'class'         => [],
        ],
        'dl'      => [
            'id'         => [],
            'class'         => [],
        ],
        'dd'      => [
            'id'         => [],
            'class'         => [],
        ],
        'dt'      => [
            'id'         => [],
            'class'         => [],
        ],
        'time'      => [
            'id'         => [],
            'class'         => [],
            'height'        => [],
        ],
        'form'     => [
            'action'              => [],
            'ref'                 => [],
            'method'              => [],
            'novalidate'          => [],
        ],
        'style'    => [],
        'a'    => ['class' => [], 'href' => [], 'id' => [], 'rel' => [], 'target' => []],
        'strong'       => ['class' => [], 'id' => []],
        'svg'       => ['class' => [], 'id' => [], 'xmlns' => [], 'enable-background' => [], 'height' => [], 'width' => [], 'viewBox' => [], 'fill' => []],
        'g'       => ['class' => [], 'id' => [], 'd' => [],  'height' => [], 'width' => [], 'fill' => []],
        'rect'       => ['class' => [], 'id' => [], 'x' => [], 'y' => [],  'height' => [], 'width' => [], 'fill' => [] ],
        'path'       => ['class' => [], 'id' => [], 'd' => [],  'height' => [], 'width' => [], 'fill' => []],
        'hr'       => ['class' => [], 'id' => []],
        'br'       => ['class' => [], 'id' => []],
        'h1'       => ['class' => [], 'id' => []],
        'h2'       => ['class' => [], 'id' => []],
        'h3'       => ['class' => [], 'id' => []],
        'h4'       => ['class' => [], 'id' => []],
        'h5'       => ['class' => [], 'id' => []],
        'h6'       => ['class' => [], 'id' => []],
        'p'        => ['class' => [], 'id' => []],
        'label'    => ['class' => [], 'name' => [], 'id' => [], 'ref' => [], 'for' => []],
        'span'     => ['class' => [], 'name' => [], 'id' => [], 'ref' => []],
        'table'    => ['class' => [], 'id' => [], 'ref' => []],
        'thead'    => ['class' => [], 'id' => [], 'ref' => []],
        'tbody'    => ['class' => [], 'id' => [], 'ref' => []],
        'tfoot'    => ['class' => [], 'id' => [], 'ref' => []],
        'th'       => ['class' => [], 'id' => [], 'ref' => []],
        'tr'       => ['class' => [], 'id' => [], 'ref' => []],
        'td'       => ['class' => [], 'id' => [], 'ref' => []],
        'iframe'   => [
            'class'           => [],
            'id'              => [],
            'src'             => [],
            'frameborder'     => [],
            'allowfullscreen' => [],
            'allow'           => [],
            'width'           => [],
            'height'          => [],
        ],
        'figure'   => [
            'class' => [],
            'id'    => [],
            'ref'   => [],
        ],
        'img'      => [
            'class'  => [],
            'id'     => [],
            'src'    => [],
            'srcset' => [],
            'alt'    => [],
            'width'  => [],
            'height' => [],
        ],
        'input'    => [
            'class'  => [],
            'name'   => [],
            'id'     => [],
            'ref'    => [],
            'value'  => [],
            'type'   => [],
            'accept' => [],
        ],
        'button'   => ['class' => [], 'name' => [], 'id' => [], 'ref' => [], 'value' => [], 'type' => []],
        'textarea' => ['class' => [], 'name' => [], 'id' => [], 'ref' => [], 'value' => [], 'rows' => []],
        'select'   => ['class' => [], 'name' => [], 'id' => [], 'ref' => [], 'value' => []],
        'option'   => ['class' => [], 'name' => [], 'id' => [], 'ref' => [], 'value' => []],
        'template' => ['ref' => []],
    ]); ?>
</main>

<script>
    document.querySelector('.button.print').addEventListener('click', function (){
        window.print();
    });
</script>

<?php wp_footer(); ?>

</body>
</html>
