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
define( 'DB_NAME', 'anilla' );

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
define( 'AUTH_KEY',         'jLrG)r][I5L-F9lU( 5;$(s>h(JE`q`$P=Qq{^+rY0>`H?od+iPzN-5|@rTf_A#8' );
define( 'SECURE_AUTH_KEY',  'Ok)d>v%%Z^GuLQCF&#N>|&Zf!(0,)}B@MCBN7;<2p9itg0*SEK(M|9n5c!M<pwSb' );
define( 'LOGGED_IN_KEY',    'rKWR.j-Bn3d[^_%~UmsY8(-e)C^F TmAZZ{>(}Kc<>cIi^2^OnCdna4?),Sf}MR5' );
define( 'NONCE_KEY',        '</x>d%tc_qh{ubR`}u+AdnE[+MpdsL,PlaX`AW+XoLV;U}$p>[as%ZgC.a=W#&m4' );
define( 'AUTH_SALT',        'IO25%$z=%Oxb/WIX+>^b5rch[A}-AtjYF4)cyt4bN$%3zOLaxlx&aih|X0k-64`u' );
define( 'SECURE_AUTH_SALT', 'Q&B.X-2#UbGvJ<<S>S D^xWR^TBVq0]6l~mp(-~Zaah^]8l=0@)JqqLKBr`[Lc-b' );
define( 'LOGGED_IN_SALT',   'eQD@Ki)Tyuty5<N@?~TVf5kC6oi[S@XKwu{kPQAeGq$5*r.6j_{K>^mOfv0<9Tr)' );
define( 'NONCE_SALT',       'O<&5d:vN0Ep/t#!~R+  Se/4puEq[fEH9LF Y:V+N/F4x>><dH&DvPVX0g5xHRE=' );

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
