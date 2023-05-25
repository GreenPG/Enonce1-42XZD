<?php
! defined( 'ABSPATH' ) && exit();

/**
 * @var \TotalSurvey\Models\Survey $survey
 * @var string $content
 */

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

    <style type="text/css">
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
            padding: 30px;
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
    </style>
</head>

<body <?php body_class(); ?>>

<?php if ( ! $survey->enabled): ?>
    <p class="totalsurvey-warning">
        <?php _e('This survey is disabled. You need to enable it to make it publicly accessible.'); ?>
    </p>
<?php endif; ?>

<main class="totalsurvey-content">
    <?php echo $content; ?>
</main>

<?php wp_footer(); ?>

</body>
</html>
