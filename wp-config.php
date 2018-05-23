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
define('DB_NAME', 'ocdb');



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



/* * #@+

 * Authentication Unique Keys and Salts.

 *

 * Change these to different unique phrases!

 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}

 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.

 *

 * @since 2.6.0

 */

define('AUTH_KEY', 'X;nA[A!rd5g7RDE(0U Ba<r6lnO8 }>pc8S+YHwI Z-E$G9q9caBVbJbZ63D)/F[');

define('SECURE_AUTH_KEY', ' MUl&uV0#9YA(<~UG%/muXm2Jd+Ct$O9dIYIRorYPqSZkk{IM4>e8.Lcb$>Q_9vu');

define('LOGGED_IN_KEY', ':K8c}kb5,hFrZ$>z-9%x~{|5wttJ+.{5>RG2*m:w&>p4;*=xR{XlVNS!0ty^;z/=');

define('NONCE_KEY', '!EwD)U.x=EoICZv3w!mK)PGT2~9RQSA21P&DD[G>^uGlB:S[&69R-X@U8KyCjR`_');

define('AUTH_SALT', 'IP`ZMR)_`Za#G+:.o,&qR$9gzU}HNlp8E;NGm}d!Qr6C=Z/AU3Q4Y24T:wHL yi#');

define('SECURE_AUTH_SALT', 'OYv.)wVBzy9|:Ipj$WryGt5zJqUhG:)C3X*eBt=8hV[~;|K/VkZYo5V66ninzoFE');

define('LOGGED_IN_SALT', 'Lx^^$5j{%gnh+0:>2Y3zuR]C={%yn:W]kVG~[1kouk^>}L?AmSh*U!mE3ZdH(6^)');

define('NONCE_SALT', 'nZ` M8PSISF@@vq%!d=u;~$_Xtp$O+2{/Sh`<eH7m2apb`5qhG2S9*IBcfZ@5)f7');



/* * #@- */



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

 * visit the Codex.

 *

 * @link https://codex.wordpress.org/Debugging_in_WordPress

 */
define('WP_DEBUG', false);



/* That's all, stop editing! Happy blogging. */



/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__) . '/');



/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');