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
define( 'DB_NAME', 'wordpress' );

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
define('FS_METHOD','direct');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '-hJCXQ4|~7 c~ibOC~>a&p`Zp:RgQ:V|gUHWtg;6+7jGMi@f1kjHoNC@ck<[p3?<' );
define( 'SECURE_AUTH_KEY',  ')im8zg:+OIv@t>6n ]Vx*39%o++A@H<2;/5[&{cPFn4u!UR7,Kze,;]_7KQ7eab`' );
define( 'LOGGED_IN_KEY',    'nKd0lK)+ocWYrcxI ]d (2V!>%H1IG~KR/`.=(=j667C>fr@=n:D2o!lga$W.|Bg' );
define( 'NONCE_KEY',        'q uZB<Spi8I)~F|+ONOH-M%IDP,S$cmkn$]L$MwNEqk{~&XJtiw^CDuh@0.*Euh?' );
define( 'AUTH_SALT',        '43LU<.$~-L{4Gz{hdzhfO@_T2e0pGhX ou[r{eFt?#MH=<Csva[qq(c_n>wzD(_|' );
define( 'SECURE_AUTH_SALT', 'R$2$<NME6;tuOL x5>m@x(.~*)-Zq[ZZwadreG;Q[8Bup8dAk!!,t&`X4imH{[6#' );
define( 'LOGGED_IN_SALT',   '_#ZG4l&vt4@bRJ*zl_aMUp.M})cK?A6%(mL&t}q^u*qa1%r:w585&?%-^j:a2(T9' );
define( 'NONCE_SALT',       '&^w GF!<v:]cbqx5=l/bZt31^AY-nZb}HcRGl,-9CjzR0;=O67VK;;mm$O.h1<7,' );

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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
