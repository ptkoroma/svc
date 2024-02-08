<?php
# BEGIN WP Cache by 10Web
define( 'WP_CACHE', true );
define( 'TWO_PLUGIN_DIR_CACHE', '/home/pkoroma/public_html/svcus.org/wp-content/plugins/tenweb-speed-optimizer/' );
# END WP Cache by 10Web
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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'pkoroma_wp3' );

/** Database username */
define( 'DB_USER', 'pkoroma_wp3' );

/** Database password */
define( 'DB_PASSWORD', 'N.2T89H1ZEeeKgxJkLG47' );

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
define('AUTH_KEY',         'DXezlEWu1cZMVRy2lUJF3ruIYs34EjmPfo0znUZ5emd5pgOmupZ5aasObo6M6Oub');
define('SECURE_AUTH_KEY',  'ZOJPTaZLOmuibVdRlnRznL0zD1mygDgofiVlwYtorbY5uqeBcBzMGVCTysBhjEHG');
define('LOGGED_IN_KEY',    'cTng9mGGeODwYSobmIr1jVtOH2hdOz91DbNnRSP2OIa571sWOdgcqqrYRHV2KffY');
define('NONCE_KEY',        'oCcvu1JmOVG2K7xOjWc12XYgVd9jMzZxCD8G1n5sWnI8LR7rhXEh6gym2Ornkkg0');
define('AUTH_SALT',        'WuSyxrV92pbZioJdg1YLyKUmXhlIAHD4FwxfTcqRBvQXdPcGFfZ8ncBvpstSTPB7');
define('SECURE_AUTH_SALT', '6Pw1JdHt1rUlFiWjwmVmGGVUywcLwsW4efFkZgwbryIyTIPsi6Ppz1QOpTIzuN7B');
define('LOGGED_IN_SALT',   'spEmKvT6PlZp09iLw9Zpphgthg2QAKlQHq4fef76mkpBLvowS2FMVSw46zUBkQfL');
define('NONCE_SALT',       'Dh7j9gkecEQ2PrzmrddtjaTovSoN6hosGdfLbmeb2fQCvFMDs40etqWHc9Mo0Quq');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
