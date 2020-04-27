<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
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
define( 'DB_NAME', 'mi_pagina' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '{fRhzu{@g8B39T,1lmvU)63j^!x.[}dm}0|dnq3u-&U=O>ci6#gdu]%|^>[L6zF#' );
define( 'SECURE_AUTH_KEY',  'dDpv]mR*+m|pzH{bx(2y6H,pM+Ll[clTN>ad_pWCGe6PyR/oH];GJ!L~Jk7)YD^8' );
define( 'LOGGED_IN_KEY',    '-^;oIihr#}lmth8?(B~3-?@@b(~.{ET*up.-B8cd9;Thf}-r&g=QR?roSjd@b:3s' );
define( 'NONCE_KEY',        '=~5B~)qW]tC4[:1;7+:J(*TQhBeq8GzBF93%fvVqhhh:h1aQJ|a.MwAvl( a69!P' );
define( 'AUTH_SALT',        'L63UmYn(jhhav!j)rg#9yR1GRf~O58aFiO3SIL<Dxq2&jq&8}#J0@-A7ZK:C3hJz' );
define( 'SECURE_AUTH_SALT', 'WVSlNLop,kq/n2.O<PYN4%HYa#l4$=oKnM{^GI,o0m~<FUpMX039LS0.O{)~$e~5' );
define( 'LOGGED_IN_SALT',   'F{2)8X.luKfU5Xf%+C]l8w:D4=c$Z*J6 &0[p~Y];7$^QF#YXs~)$bl@!j ezOPl' );
define( 'NONCE_SALT',       'q^sXD)OgcPYI>A_`m51`1Jx)=7dfpe|~yJ;lMZ*iSK^hH_$)>3U;mTCJ^pTlO9.&' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
