<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u477237166_watchrepkings' );

/** Database username */
define( 'DB_USER', 'u477237166_watchrepkings' );

/** Database password */
define( 'DB_PASSWORD', 's3S$qsD1shJ' );

/** Database hostname */
define( 'DB_HOST', '' );

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
define( 'AUTH_KEY',         'A,yE|FzjNutktCsk;Ly$mjZ{i**YY)3+N|QOz>o2YNdW84~H[03GffaEdE2_IYq@' );
define( 'SECURE_AUTH_KEY',  'K8%&-bSD{]3(-`H[!}]g@@1 ~$nZ}o0k=p@Zh<dlgQaK3?!)ds,Pe4{DMTY_E0vn' );
define( 'LOGGED_IN_KEY',    ' v&T2!T:5JvxR=k8UAZl#[ uuOvp6&]&->!_&P3FT]R.9HH?q#TP:*nTz@J@RI?U' );
define( 'NONCE_KEY',        'fvvhoUY&hHS1%;~^,G@x1>RgxZwzuRl`M<wtKs#)dghfU7n)7ixr()yHXlwBavog' );
define( 'AUTH_SALT',        'Zvrh&(@MiUZ5a`]xyYW4^$S][{NdHPwpea)G},Ae2G6jKrO:&rE,<H`TJxDA3h%F' );
define( 'SECURE_AUTH_SALT', 'W1C@`ru(%>%_=Q9={hA(/37laV bL3R{AgYB>$~E5]nlomb&Dn/DPjHYQY08auE{' );
define( 'LOGGED_IN_SALT',   'Yni(%JaYD8%}tcdq-mo>KmrO ;vH$us&PF^uW-vZ{?KVx>R7qcQ-5KV{4!02lLn+' );
define( 'NONCE_SALT',       '=Mv#jVvi<HFk]9SlsA/n8Pu;9KUpBl]&1&,^eEcD].G.<_OqGMn&lUQ#<>!WiedL' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
