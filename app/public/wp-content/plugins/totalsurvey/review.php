<?php
! defined( 'ABSPATH' ) && exit();


add_action('admin_notices', function () use ($env) {
	// Current page
	$screen                    = get_current_screen();
	$isDashboard               = $screen->id === 'dashboard';
	$isPlugins                 = $screen->id === 'plugins';
	$isTotalSuiteProduct       = strstr($screen->id, 'toplevel_page_total') !== false;
	$isTotalSuiteLegacyProduct = strstr($screen->post_type, 'poll') !== false || strstr($screen->post_type, 'contest') !== false;

	if (!$isDashboard && !$isPlugins && !($isTotalSuiteProduct || $isTotalSuiteLegacyProduct)) {
		return;
	}

	// Slug
	$pluginSlug = basename(dirname(__FILE__));
	// Option key
	$pluginStateKey = "{$pluginSlug}_review";
	// Option value
	$pluginState = get_option($pluginStateKey) ?: 'uninitiated';

    if($pluginState === 'dismissed'){
        return;
    }

	// Name
	$pluginName = empty($env['product']['name']) ? $env['name'] : $env['product']['name'];
	// Argument
	$pluginActionArgument = "{$pluginSlug}_review_reminder_action";
	// Action value
	$pluginAction = empty($_REQUEST[$pluginActionArgument]) ? '' : $_REQUEST[$pluginActionArgument];
	// Action nonce
	$pluginActionNonce = empty($_GET['_wpnonce']) ? '' : sanitize_text_field($_GET['_wpnonce']);
	// Rate URL
	$pluginRateUrl = add_query_arg(['from' => $screen->id, 'product' => str_replace('-lite', '', $pluginSlug)], "https://totalsuite.net/review/");
	// Dismiss URL
	$pluginDismissUrl = wp_nonce_url(add_query_arg($pluginActionArgument, 'dismiss'), $pluginSlug);
	// Postpone URL
	$pluginPostponeUrl = wp_nonce_url(add_query_arg($pluginActionArgument, 'postpone'), $pluginSlug);
	// Expression
	$pluginRateExpression = esc_html__(
		"Thank you for using {{product}}! If you've been enjoying our plugin, we would be grateful if you could {{link}}leave us a 5-star review{{/link}}. Your feedback means the world to us and helps us improve the plugin for everyone.",
		'totalsuite'
	);

	// Alternative expression (promotion)
	$updatePlugins = get_site_transient('update_plugins');
	if (!empty($updatePlugins->response["{$pluginSlug}/plugin.php"]->banners_rtl) || !empty($updatePlugins->response["{$pluginSlug}-lite/plugin.php"]->banners_rtl)) {
		$pluginRateExpression = esc_html__(
			"Love {{product}}? {{strong}}{{link}}Leave a 5-star review{{/link}}{{/strong}} and get a {{strong}}$20 gift card{{/strong}}! Help us improve and get rewarded. Thank you!",
			'totalsuite'
		);
	}

	// Dismiss action
	if ($pluginAction === 'dismiss') {
		if (wp_verify_nonce($pluginActionNonce, $pluginSlug)) {
			$pluginState = 'dismissed';
			update_option($pluginStateKey, $pluginState);
		}
	}

	// Postpone
	if ($pluginAction === 'postpone') {
		if (wp_verify_nonce($pluginActionNonce, $pluginSlug)) {
			$pluginState = 'later:'.(time() + WEEK_IN_SECONDS);
			update_option($pluginStateKey, $pluginState);
		}
	}

	// Check if we should display the reminder
	if (strstr($pluginState, 'later') !== false) {
		list($first, $timestamp) = explode(':', $pluginState);
		if (time() > $timestamp) {
			$pluginState = 'show';
			update_option($pluginStateKey, $pluginState);
		}
	}

	// Init
	if ($pluginState === 'uninitiated') {
		$pluginState = 'later:'.(time() + (DAY_IN_SECONDS * 2));
		update_option($pluginStateKey, $pluginState);
	}

	if ($pluginState !== 'show') {
		return;
	}

	$pluginCurrentPage         = empty($_GET['page']) ? '' : sanitize_text_field($_GET['page']);
	?>
    <div class="notice is-dismissible notice-info" id="review-<?php echo esc_attr($pluginSlug); ?>"
         style="<?php if (strstr($pluginCurrentPage, 'total')): ?>
                 display: block!important;
                 margin: 0;
                 border: 0;
                 position: absolute;
                 right: 0;
                 left: 0;
                 top: 0;
                 z-index: 10000;
                 padding-right: 120px;
                 box-shadow: 0 3px 12px rgba(0,0,0,0.35);
	     <?php else: ?>
                 padding-right: 120px;
	     <?php endif; ?>
                 ">
        <a href="<?php echo esc_attr($pluginDismissUrl); ?>"
           class="notice-dismiss"
           style="text-decoration: none;">
                <span class="screen-reader-text">
                    <?php esc_html_e('Dismiss this notice.', 'totalsuite'); ?>
                </span>
        </a>
        <a href="<?php echo esc_attr($pluginPostponeUrl); ?>" style="position: absolute; right: 40px;top: 10px;"><?php esc_html_e('Maybe later', 'totalsuite'); ?></a>
        <blockquote>
            <p>
				<?php echo str_replace(
					['{{product}}', '{{link}}', '{{/link}}', '{{strong}}', '{{/strong}}'],
					[$pluginName, sprintf('<a href="%s" target="_blank">', esc_attr($pluginRateUrl)), '</a>', '<strong>', '</strong>'],
					$pluginRateExpression
				); ?>
            </p>
            <p style="opacity: 0.7">&mdash; <cite><?php esc_html_e('Your friends at TotalSuite.net', 'totalsuite'); ?></cite></p>
        </blockquote>
    </div>
<?php });
