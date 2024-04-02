<?php
define( 'WP_CACHE', false /* Modified by NitroPack */ );
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
define( 'DB_NAME', 'finbud' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         'L*q3iP/!#}-V/C*a]]kPQb-t)>AG-yZ;!WE+*31*Jyzjqu;wYG5a1}x>6xGaXe;s' );
define( 'SECURE_AUTH_KEY',  'Sz7MGg,&Ch KSfD5%{<MotT]k#N-UQHnaBh#[vA^#c`uT$U{)pLnO1hO5asn5bR+' );
define( 'LOGGED_IN_KEY',    'z|p.i%(O{iB:a2[CVTa0L=O-:.<3=k>*q6z~iu<-fx3Q]!0P<_@R%iNA!n/lXj6q' );
define( 'NONCE_KEY',        '[%Z7Q?U(sYj*61yJf<WJYPd9IwG|)W@o}*C6EXq8ZSDFRXfXXOXZdv|(`JJF-~R4' );
define( 'AUTH_SALT',        'Ikecnsp(9=yZQLn5$} eQKi-}){`Jxi}OAzh@E)f6~4Da%]?CHA~X<>io6[87Fps' );
define( 'SECURE_AUTH_SALT', 'Nwt]_Tr0ZP*D2Cg4f0$-b~/9.oiZEIK28MQUum,,%mY7:>7+)i$o>9M_UXw*[g8]' );
define( 'LOGGED_IN_SALT',   '<U-{1{O^q8QT_a%/IEhN HO_N]/i#aKgXEVcAzKX@,>h:4 <l4WXGfr8u47r],+f' );
define( 'NONCE_SALT',       ' %) LG6]&@@GiN tB1lw,uoPTBc;J$2c>^7XVDc@SF.578TePX+66*[otxV*7nBb' );

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
define( 'WP_DEBUG_LOG', false );
define('WP_ALLOW_MULTISITE', true);
// Disable all types of automatic updates
define( 'AUTOMATIC_UPDATER_DISABLED', true );
// Disable core updates
define( 'WP_AUTO_UPDATE_CORE', false );
define('FS_METHOD', 'direct');
/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
