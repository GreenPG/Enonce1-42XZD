<?php ! defined( 'ABSPATH' ) && exit(); ?><!DOCTYPE html>
<html <?php use TotalSurveyVendors\TotalSuite\Foundation\Support\Strings;

language_attributes(); ?>>
<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

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
            background: #eeeeee !important;
        }

        .totalsurvey-content {
            padding: 24px;
            margin: 30px auto;
            max-width: 620px;
            background: #ffffff;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.05);
            border-radius: 6px;
        }

        .totalsurvey-footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            padding: 12px;
        }

        @media screen and (max-width: 782px) {
            .totalsurvey-content {
                border-radius: 0;
                margin: auto;
            }
        }

    </style>
    <title><?php esc_html_e('Survey report', 'totalsurvey') ?></title>

</head>
<body>

<!-- body -->

<!-- content -->

<main class="totalsurvey-content">
    <?php echo wp_kses($content, \TotalSurvey\Tasks\Utils\GetAllowedSurveyTags::invoke()); ?>
</main>


<!-- /content -->


<!-- /body -->
<footer class="totalsurvey-footer">
    <?php echo esc_attr(
        Strings::template(
        esc_html__('Generated on {{date}} at {{time}}', 'totalsurvey'),
        [
            'date' => mysql2date(get_option('date_format'), date('Y-m-d H:i:s' )),
            'time' => mysql2date(get_option('time_format'), date('Y-m-d H:i:s' ))
        ]
        )
    );
    ?>
</footer>
</body>
</html>
