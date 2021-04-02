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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'zxfn6OJCJ7hXmqbxifzlYawMBDdEGvoZMe8zrCmgjertn5sgN0HCzLs76P9A8oZ19jIYs3c9+GUVVTD2r//MYA==');
define('SECURE_AUTH_KEY',  'SpalK3+uiXKkw2llKaF1RsLgtuqqwFk0xYFdPRXXMSfhLoKDUsLfVEAWofAjHFfKS9+KDiSe4SsxpTEKwv5nAQ==');
define('LOGGED_IN_KEY',    'FSnlPUK8RWiSrlRulEEi1nG1mv8rxNn6JUZmUGa38fiXet2tiu0llqCQ/YtvsZxuTDzgytTqI5uHJr1k+U2E5Q==');
define('NONCE_KEY',        '7K9nJVNJZ7yoyvysTr0j8JNDVCnFydHvfaB9IC11NJ5NVigj0IqyEpchn3rpMOc/go4Kbe7CtcpqKkzD9yylzg==');
define('AUTH_SALT',        'MYheZBYgZEgaxvkFOIW2/UAIyAPcL7PxoSHDMkMsLs3FmsQaH32fbHtIbEaERXNy/QP0SxnTsdmmU49l5RCzFQ==');
define('SECURE_AUTH_SALT', '0DKu6IJpbCIWdlXN2g7fxWiSNZgeVv9OFwaB6Y1YxkByeX5AOB39/FHIKGP+WU3t0si+88NrGAgj7G5werJVmw==');
define('LOGGED_IN_SALT',   'ycgRjdh4/T6M28tW7PKHt8yyXMX4GTXx+fG/UszhDAimCHBFwpObZcIfBXzEgf5nmrT7g0WCrVuUtG7H7upBGw==');
define('NONCE_SALT',       '2CEBQZge1dzQc10o/9axiPd76oWtveVgdP0ZWRrZR3ta5K8oV3SF+HKfIpgmC9cK/mIwZTb+9REGxdZioEiDXw==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
