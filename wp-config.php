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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'Exertio' );

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
define( 'AUTH_KEY',         'a-&mU>9vkK5:8K`w<$( Y}=nVtAV]pYo#M+<vmJi@>!8_[vr|6Br-<j,%i{>Od,A' );
define( 'SECURE_AUTH_KEY',  'd+x`!E_27Kmk/+t!*&FOyKC|[}6]Aq!QYI?Ifwbm+?TH,-CB4KLE]*}ZrL``M4xL' );
define( 'LOGGED_IN_KEY',    'WX)rt)9+[=8;?@~{!3I]z0:Ep=.*:^2Urz!HP;_CjQnR~gzx}^=rwQKQm.OjoSs;' );
define( 'NONCE_KEY',        'eN=[gt$XWZN,Z0y] a/GD}#Xo};3M8}a67qx;t+#6fuhfFq]ss#M-ocC3=B`Mnw%' );
define( 'AUTH_SALT',        '<z%4NtlX&byWCY_1q6hVgjNIfp|DZ2e7IDdOF5;n) l8]7Edn.n,svEkAoRcw1h;' );
define( 'SECURE_AUTH_SALT', '8t$D`:H g+$A}M@{ ZWk1oct4XuAu%{hE%BcP]ReJ}K5+0ADkA!x5BxA+`mqHIn`' );
define( 'LOGGED_IN_SALT',   'mmT`F!E%Xqm)B`JN&]FKFUN#t^hS>@)oqUb,2W G6r<phk^^26^^N9sppd/l?D2!' );
define( 'NONCE_SALT',       'p|nuDJ[W{OCr24o>sP$AZ}b-rEVLF3FYT| SC.0dBJ#1_l1)$&8[3dj]Ps /@D`a' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_Exertio';

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
