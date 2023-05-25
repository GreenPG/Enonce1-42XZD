<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '67HedbBG/XYtojV37diZxzgm+iyXk4Ob7WebtozF8p8CeeQU5He62Xzeg94vTGvMLRg3FUqdFZklpXww0gcluw==');
define('SECURE_AUTH_KEY',  'DayO5kBWCIRCO0eA685wEFUs1eVsisgaI19NBhAFZh7uQvVqk0O/Vy9Bvb/Ss4l9K76ipM3i2iKJFDc967jn3w==');
define('LOGGED_IN_KEY',    'z0fVm3le6w0VodL4Nzhmh9is1Yudp0Nfb6ip0as0hAtXuFFrwcH1u243EFRMhSo9/samRbd9zTKRVMLbuvm7kA==');
define('NONCE_KEY',        'e6B0yX2fbFEp892nYPX5C8NtdWPg3lZ/YAlXUl39maNCvtxePT7EApK10Sq7yBBDfi3++Kxul7JGu5WJoV1fbw==');
define('AUTH_SALT',        '1HRdB8wJ+FleS54tayqrGOErshTzJOSaI3Bwmnvb3uD76riLwnk0bcPjR0FsUkED4ulSX2L6GLv7qWWpvBuIaQ==');
define('SECURE_AUTH_SALT', '+9q3h97BfVQAr7sFFb3LIrhEV/9haqHALovq+18dH82sQ76Q+8vSbyl+wjP2pMF4wetPuNgVnM7qJeNnEZangA==');
define('LOGGED_IN_SALT',   'zZ1xcCcwc+cLE1GuL148yXFqlfzui0Ges7MdyIy10FRgWVslTYes3sTvLRKnzf7S3jUkfesvJFDTQVX2qHUBGQ==');
define('NONCE_SALT',       '8UqPG7VTEa5XM7Fh0jreXJAxPDiOc0SD9RtgBOVH+lq5ANTXvy2tY7O67qfVNFI8yYL9nRTU29ER/B4GU2bSZQ==');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
