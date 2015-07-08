<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'image');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '}GRG|f|*mW>|er1<-/1Vrr[5c$A,v4] wlTug3sk];6obhrkQm_mYK.<T-hi;(bT');
define('SECURE_AUTH_KEY',  '+yZvO3[l/9Jyzf_b/nC2Fpcc;+_9NNn!o>c/UxC3L48WG|>ts]|-dZx=0yyt2o)0');
define('LOGGED_IN_KEY',    'B+&ADXEu^8G3v+nvf(Hk+T&Rj&;X(fVk({0YHB=SpxA4D2pv;ZCU!A}MGb$AmG`l');
define('NONCE_KEY',        'kXy~bWBEuRT1Bs{rfXs_VlY4}xVFF HW0i(C+|yqZ1S/!G[V)Af]0+XRs{!j=/]<');
define('AUTH_SALT',        '0F>/w|Qr6jgM,|Pn.yVTpb*u|^+KP_SC4d@ky77Ugl?OXNGu~-,[|r1-)=4b*L(/');
define('SECURE_AUTH_SALT', 'Q0+Lxx|3PPTURADjaL)%1MEew,ME6?H=OLI9q1I]iDcY5y~ut>%0U8ZRGr&ZIU$@');
define('LOGGED_IN_SALT',   'It4Ha4l;LJ2}yp31b!S.llS5{YT?f$)`^;=--% m.:W^aVS-t.g>vg.TAj9vhH)7');
define('NONCE_SALT',       '4A]u_IOk]ub&|[$S&BZS`ysO@IB=eIyK(p2bb|-qlm</&~52;tUQRtv=i^ Z.QLx');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define('FS_METHOD', 'direct');
