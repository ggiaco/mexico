<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'centralm_wor3');

/** MySQL database username */
define('DB_USER', 'centralm_wor3');

/** MySQL database password */
define('DB_PASSWORD', 'k2JAIS7n');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         ']A$my3ScQN/4-2HcR$#+#_=km3whn.{QP8>5g*Uuu9q*WI[j_pux:G;mk:9b_SPe');
define('SECURE_AUTH_KEY',  'A12Z4[-a-[H*KY0aj^l52teKC1d([6)uxE,JsUCW-tBeNu|-,ywx5i@D-v_zJ5tU');
define('LOGGED_IN_KEY',    'HK[6}</04}hgrt$UMBkd[bh8#6(L)f!u|P9|;MCb_r:2tycD9k)`BBbr(t#u8jpc');
define('NONCE_KEY',        'P|%h96w{8?/p3D|5M]4U$8k,exCl8RM#2lhQKX~SPB8M}{G!)he>#2V?MwBdASQz');
define('AUTH_SALT',        'i,L-86%K!MX{F//[ZrzWs#xd6!1sF~7:K4cF8MD5*<,yV +/dHpB_Ea*S;u%QYk+');
define('SECURE_AUTH_SALT', 'VQB/gOmzPlm#)ycf6c=Oms-GV7R)f4.T6b>N/Hj+NwSQf]lRazfzK^lRu8iLXILe');
define('LOGGED_IN_SALT',   'p-5V2W&D,PI3onbX-bad=;sn,Whp!<4:+2eyR/u3U1Qz;Gz~TsDOAt2):D+-vT4U');
define('NONCE_SALT',       'Jx] `)2 &;_jR?JFK|E!](jDxMUose>!L%|J~bhRuCy[$Yvb+osHkh^]eX){ wJ#');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'xlx_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'es_ES');

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
