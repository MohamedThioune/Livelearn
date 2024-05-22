<?php
define('WP_CACHE', false); // WP-Optimize Cache
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'influid_wp161' );
/** MySQL database username */
define( 'DB_USER', 'influid_wp161' );
/** MySQL database password */
define( 'DB_PASSWORD', 'SG08[9M]ip' );
/** MySQL hostname */
define( 'DB_HOST', 'localhost' );
/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );
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
define( 'AUTH_KEY',         'vxqi2vz8hygrjbymtxuljluwspsdvnhsgcw3uvmtvh62hhfkubifuc6jr1zi6cfh' );
define( 'SECURE_AUTH_KEY',  'lgonqrqpb30gblbr0vccwzva1pih4jgpmduasxcsa9jxiy3js5ete59zgqs4vzdd' );
define( 'LOGGED_IN_KEY',    'u7okbyg9lsz3dhtwx39beuwj3noztuzn5tnanckqgtyl0fwvw7wym1iftld4zdjn' );
define( 'NONCE_KEY',        'd6qzmveeg2uzvpph2fqq0bhndulxccsvkyb5auiwwu973dv18i3wf6lxza0boyw2' );
define( 'AUTH_SALT',        'iwh4nl09bzhh7xisgq6f4t7suu52ftbgd3vrqkr5u0rhlsshts8zskheoly97dex' );
define( 'SECURE_AUTH_SALT', 'xg9gglbjpnygvhrbzfouqwet7bl9afcxbpd88qpd2ha1qwoltsgxwuztnfxzohf8' );
define( 'LOGGED_IN_SALT',   '9xfdgecppvkigneqp4fkhnwspouasggml37zmavtg2rdcze2ooupanr5utz871jr' );
define( 'NONCE_SALT',       'uzr593wkf4ydwl2rtqg92k0r9tutc0wizpmdh2gyppipdr0uix5dyehllncb1jur' );
/**#@-*/
/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpe7_';
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
// Enable WP_DEBUG mode
define( 'WP_DEBUG', true );
// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );
// define( 'WP_DEBUG_LOG', '/logs/errors.log' );
// Disable display of errors and warnings
define( 'WP_DEBUG_DISPLAY', true );
@ini_set( 'display_errors', 1 );
/* Add any custom values between this line and the "stop editing" line. */
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';