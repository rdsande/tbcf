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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'tbcf' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '@Rodj1234' );

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
define( 'AUTH_KEY',         'ybdossoq83pmaecddpweopze15mh880kdtu7khuvhdflgkpnhtwtazeqzasfhryd' );
define( 'SECURE_AUTH_KEY',  '50jjxdakxpc9kywzix0xkpzukzm9alue3ret69inztjlnbfxoddsstepfxz4nf7y' );
define( 'LOGGED_IN_KEY',    'hoenzgufp4tegahhyiopgyxehgtjy3rw9ujglmmyrcfgycld25wfh0qievcxat0l' );
define( 'NONCE_KEY',        't6wqt46ijrztsxwls6u0pnsabyvttgpcoso8cydkjdyrtod5orgvbhe43v4sf0wm' );
define( 'AUTH_SALT',        'vto4ekulc76eblbnnnrqqxwhrrevri5zb9l8kojskqjywaxuiuwuc1nppfxyefoa' );
define( 'SECURE_AUTH_SALT', 'nfr5qrmzhox0efnszc5wcboyfork0xtkwvwjj9u1btflxi4o7a4aykjvst1vjlhh' );
define( 'LOGGED_IN_SALT',   '5m8ichtfbzowjvxnrlckj6d2m8k2wivwsjgaj1asvvtrutfqgxsd6wcknqtmxojo' );
define( 'NONCE_SALT',       'o3f3yukwfjxmsbf9ro1z0vhnaiuosg6gx3nynxyl9yugfkk2gl1airfi2qkssj59' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp9d_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
