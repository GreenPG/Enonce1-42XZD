<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            border: 0;
            font-family: sans-serif;
        }

        html {
            overflow: auto;
        }

        body::before, body::after {
            display: none !important;
        }

        body {
            background: transparent !important;
        }


        <?php if (isset($embed) && $embed == '1'): ?>
        html {
            margin: 0 !important;
        }

        .totalsurvey-content {
            font-size: 14px;
            font-weight: 400;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            line-height: 1.5;
            color: #8c8f94;
            background: #fff;
            border: 1px solid #dcdcde;
            box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
            overflow: auto;
            zoom: 1;
        }

        <?php endif; ?>
    </style>
    <title><?php esc_html_e('Survey insights', 'totalsurvey') ?></title>

</head>
<body>

<main class="totalsurvey-content">
    <?php echo wp_kses($content, [
        'div'                      => [
            'id'    => [],
            'class' => [],
        ],
        'article'                  => [
            'id'    => [],
            'class' => [],
        ],
        'section'                  => [
            'id'    => [],
            'class' => [],
        ],
        'footer'                   => [
            'id'    => [],
            'class' => [],
        ],
        'dl'                       => [
            'id'    => [],
            'class' => [],
        ],
        'dd'                       => [
            'id'    => [],
            'class' => [],
        ],
        'dt'                       => [
            'id'    => [],
            'class' => [],
        ],
        'time'                     => [
            'id'     => [],
            'class'  => [],
            'height' => [],
        ],
        'form'                     => [
            'action'     => [],
            'ref'        => [],
            'method'     => [],
            'novalidate' => [],
        ],
        'style'                    => [],
        'a'                        => ['class' => [], 'href' => [], 'id' => [], 'rel' => [], 'target' => []],
        'strong'                   => ['class' => [], 'id' => []],
        'svg'                      => [
            'class'             => [],
            'id'                => [],
            'xmlns'             => [],
            'enable-background' => [],
            'height'            => [],
            'width'             => [],
            'viewBox'           => [],
            'fill'              => [],
        ],
        'g'                        => [
            'class'  => [],
            'id'     => [],
            'd'      => [],
            'height' => [],
            'width'  => [],
            'fill'   => [],
        ],
        'rect'                     => [
            'class'  => [],
            'id'     => [],
            'x'      => [],
            'y'      => [],
            'height' => [],
            'width'  => [],
            'fill'   => [],
        ],
        'path'                     => [
            'class'  => [],
            'id'     => [],
            'd'      => [],
            'height' => [],
            'width'  => [],
            'fill'   => [],
        ],
        'hr'                       => ['class' => [], 'id' => []],
        'br'                       => ['class' => [], 'id' => []],
        'h1'                       => ['class' => [], 'id' => []],
        'h2'                       => ['class' => [], 'id' => []],
        'h3'                       => ['class' => [], 'id' => []],
        'h4'                       => ['class' => [], 'id' => []],
        'h5'                       => ['class' => [], 'id' => []],
        'h6'                       => ['class' => [], 'id' => []],
        'p'                        => ['class' => [], 'id' => []],
        'label'                    => ['class' => [], 'name' => [], 'id' => [], 'ref' => [], 'for' => []],
        'span'                     => ['class' => [], 'name' => [], 'id' => [], 'ref' => []],
        'table'                    => ['class' => [], 'id' => [], 'ref' => []],
        'thead'                    => ['class' => [], 'id' => [], 'ref' => []],
        'tbody'                    => ['class' => [], 'id' => [], 'ref' => []],
        'tfoot'                    => ['class' => [], 'id' => [], 'ref' => []],
        'th'                       => ['class' => [], 'id' => [], 'ref' => []],
        'tr'                       => ['class' => [], 'id' => [], 'ref' => []],
        'td'                       => ['class' => [], 'id' => [], 'ref' => []],
        'iframe'                   => [
            'class'           => [],
            'id'              => [],
            'src'             => [],
            'frameborder'     => [],
            'allowfullscreen' => [],
            'allow'           => [],
            'width'           => [],
            'height'          => [],
        ],
        'figure'                   => [
            'class' => [],
            'id'    => [],
            'ref'   => [],
        ],
        'img'                      => [
            'class'  => [],
            'id'     => [],
            'src'    => [],
            'srcset' => [],
            'alt'    => [],
            'width'  => [],
            'height' => [],
        ],
        'input'                    => [
            'class'  => [],
            'name'   => [],
            'id'     => [],
            'ref'    => [],
            'value'  => [],
            'type'   => [],
            'accept' => [],
        ],
        'button'                   => [
            'class' => [],
            'name'  => [],
            'id'    => [],
            'ref'   => [],
            'value' => [],
            'type'  => [],
        ],
        'textarea'                 => [
            'class' => [],
            'name'  => [],
            'id'    => [],
            'ref'   => [],
            'value' => [],
            'rows'  => [],
        ],
        'select'                   => ['class' => [], 'name' => [], 'id' => [], 'ref' => [], 'value' => []],
        'option'                   => ['class' => [], 'name' => [], 'id' => [], 'ref' => [], 'value' => []],
        'template'                 => ['ref' => [], 'v-if' => [], 'v-for' => [], 'v-else' => []],
        'canvas'                   => ['ref' => [], 'v-if' => [], 'v-for' => [], 'v-else' => []],
        'survey-insights'          => [
            'inline-template' => [],
            'class'           => [],
            'name'            => [],
            'id'              => [],
            'v-bind:sections' => [],
            'survey_uid'      => [],
            'embed'           => [],
        ],
        'survey-insights-section'  => [
            'inline-template' => [],
            'class'           => [],
            'name'            => [],
            'uid'             => [],
            ':sections'       => [],
            'survey_uid'      => [],
            'embed'           => [],
        ],
        'survey-insights-question' => [
            'inline-template' => [],
            'class'           => [],
            'name'            => [],
            'index'           => [],
            ':sections'       => [],
            'survey_uid'      => [],
            'embed'           => [],
        ],
        'survey-link'              => [
            'rel'  => [],
            'href' => [],
            'type' => [],
        ],
        'survey-style'             => [
            'hidden' => [],
        ],
    ]); ?>
</main>

<?php
! defined( 'ABSPATH' ) && exit();
 wp_footer(); ?>
</body>
</html>
