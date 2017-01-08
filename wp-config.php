<?php
/**
 * SUPERCHARGED WP-CONFIG. All useful wordpress globals in a wp-config.php,
 * ready for a new project.
 *
 * Usage 	Adapt the settings to your need.
 * 		There is a switch allowing you to use different configurations
 * 		(e.g: "local", "staging", "production").
 * 		Set your variables and just remove what you don't need.
 *
 * Learn 	Basic:		@link http://codex.wordpress.org/Editing_wp-config.php
 * 		Advanced:	@link http://premium.wpmudev.org/blog/wordpress-wp-config-file-guide/
 *
 * Discuss 	@link https://github.com/pixeline/wp-config-supercharged/issues
 *
 * @author 	Alexandre Plennevaux <alexandre@pixeline.be> - https://pixeline.be/
 * @author 	Julien Bosuma <contact@lianzadesign.com> - http://www.lianzadesign.com/
 */


// ------------------------  GLOBAL SWITCH & CONDITIONAL FLAGS  --------------------- //

// The Main Switch: 'local' or 'live'
define('CURRENT_SERVER','local');

// Conditional Flag - Using Debian/Raspbian Development Server?
define('LINUX_DEV_SERVER', false);

// Conditional Flag - Using WP Siteurl and Home Url Overrides?

/**
 * About WP_SITEURL and WP_HOME in wp-config.php
 *
 * @link   https://codex.wordpress.org/Editing_wp-config.php#WP_SITEURL
 * @link   https://codex.wordpress.org/Changing_The_Site_URL#Relocate_method
 *
 * Adding this in can reduce the number of database calls when loading your site.
 * NOTE: This will 'not' change the database stored value. The url will revert to
 * the old database value if this line is ever removed from wp-config.
 * You can use the RELOCATE constant to change the siteurl value in the database.
 */
define('HARDCODE_SITEURL', false);

/*
 * Conditional Flag - Unable to edit the server's php.ini configuration file?
 * Set PHP's error reporting settings at runtime, in this file,
 * only if you don't have access to the server's 'php.ini' config file (prefered method).
 */
define('CANNOT_EDIT_PHP_INI', true);


// ------------------------  SERVER CONFIGURATIONS  --------------------- //

switch( CURRENT_SERVER )
{
	case 'local':
		/***********************************************
		 * DEVELOPMENT SERVER. OPTIMIZED FOR DEBUGGING *
		 ***********************************************/
		
		define('WP_CACHE', false);
		
		// DEBUG
		define('WP_DEBUG', true);
		
		// php.ini runtime overrides
		if ( CANNOT_EDIT_PHP_INI && WP_DEBUG )
		{
			// Set these to your convenience.
			@ini_set( 'log_errors',     'Off' );
			@ini_set( 'display_errors', 'On' );
			// @ini_set( 'error_log',      '/home/example.com/logs/php_error.log' );
		
		} elseif ( !WP_DEBUG )
		{
			@ini_set( 'log_errors',     'Off' );
			@ini_set( 'display_errors', 'Off' );
		}
		
		define('WP_DEBUG_LOG',     false); 	// Used only when WP_DEBUG is true.
		define('WP_DEBUG_DISPLAY', true);	// Used only when WP_DEBUG is true.
		
		/**
		 * The SAVEQUERIES definition saves the database queries to an array to help analyze those queries.
		 * @see http://codex.wordpress.org/Editing_wp-config.php on how to use it.
		 */
		define( 'SAVEQUERIES',  false );
		define( 'SCRIPT_DEBUG', true );
		define( 'CONCATENATE_SCRIPTS', false );
		
		// DATABASE
		define('DB_NAME',     'database_name_here');
		define('DB_USER',     'username_here');
		define('DB_PASSWORD', 'password_here');
		define('DB_HOST',     'localhost');
		
		// DOMAIN & URL
		define('PROTOCOL',    'http://');
		define('DOMAIN_NAME', $_SERVER['HTTP_HOST']);
		define('PATH_TO_WP',  '/wp/');                     // Use "/" if wp core files are not in a subdirectory.
		
		/**
		 * Development Server Document Root - Project Subfolder.
		 * The subfolder under @see '/Applications/MAMP/htdocs/' (OSX) or under @see '/var/www/html/' (Raspbian).
		 * Use an empty string if no subfolder is used.
		 */
		define('DEV_SERVER_SUBFOLDER', '/subfolder_name_here');
		
		if (LINUX_DEV_SERVER || HARDCODE_SITEURL) {
			// Path to WP Core files folder:
			define('WP_SITEURL', PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER . PATH_TO_WP);
			// Root of your WordPress site:
			define('WP_HOME',    PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER);
		}
		
		break;
		
	case 'live':
	default:
		/********************************************************
		 * PRODUCTION SERVER. OPTIMIZED FOR SPEED AND SECURITY. *
		 ********************************************************/
		
		define('WP_CACHE', true);
		
		// DEBUG
		define('WP_DEBUG', false);
		
		if ( CANNOT_EDIT_PHP_INI )
		{
			@ini_set( 'log_errors',     WP_DEBUG ? 'On' : 'Off' );
			@ini_set( 'display_errors', 'Off' );
			// @ini_set( 'error_log',      '/home/example.com/logs/php_error.log' );
		}
		
		define( 'SAVEQUERIES',  false );
		define( 'SCRIPT_DEBUG', false );
		define( 'CONCATENATE_SCRIPTS', true );
		
		/*
		 * When WP_DEBUG is true: log errors in a file (wp-content/debug.log OR custom ini_set()),
		 * don't show them to end-users.
		 */
		define('WP_DEBUG_LOG',     true);	// Used only when WP_DEBUG is true.
		define('WP_DEBUG_DISPLAY', false);	// Used only when WP_DEBUG is true.
		define('ENFORCE_GZIP', true);
		
		// DATABASE
		define('DB_NAME',     'database_name_here');
		define('DB_USER',     'username_here');
		define('DB_PASSWORD', 'password_here');
		define('DB_HOST',     'localhost');
		
		// DOMAIN & URL
		define('PROTOCOL',    'http://');
		define('DOMAIN_NAME', $_SERVER['HTTP_HOST']);
		define('PATH_TO_WP',  '/wp/'); // If WordPress Core is in a subdirectory. Empty string otherwise.
		
		/*
		 * Development Server Document Root's Subfolder.
		 * Usually empty on a production site, unless its root is in a subdirectory.
		 */
		define('DEV_SERVER_SUBFOLDER', '');
		
		if ( HARDCODE_SITEURL ) {
			define('WP_SITEURL', PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER . PATH_TO_WP); // path to WP Core files folder
			define('WP_HOME',    PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER);              // root of your whole WordPress site
		}
		
		/*
		 * Using subdomains to serve static content (CDN) ?
		 * To prevent WordPress cookies from being sent with each request to static content on your subdomain,
		 * set the cookie domain to your non-static domain only.
		 */
		// define('COOKIE_DOMAIN', DOMAIN_NAME);
		
		/**
		 * FTP: On some webhosting configurations, Wordpress automatic updates fail. Try the FTP method.
		 * If still a no-go, @see: http://codex.wordpress.org/Editing_wp-config.php#Override_of_default_file_permissions
		 * for alternative methods.
		 */
		// define('FS_METHOD', 'ftpext');
		// define('FTP_USER', 'YOUR FTP LOGIN');
		// define('FTP_PASS', 'YOUR FTP PASSWORD');
		// define('FTP_HOST', 'YOUR FTP HOST (without http:// or ftp://)');
		// define('FTP_SSL', false);
		
		break;
}


// ------------------------  SETTINGS COMMON TO ALL SERVERS  --------------------- //

define('TABLE_PREFIX',      'cstmr_'); // Something else than the default wp_. Only numbers, letters, and underscores.
define('WP_POST_REVISIONS', 10 );      // How many revisions to keep at max.
define('AUTOSAVE_INTERVAL', 60);       // in seconds
define('EMPTY_TRASH_DAYS',  30);       // in days (use 0 to disable trash)

/*
 * WPLANG. Default is 'en_EN'.
 * NOTE: Is now obsolete and handled through the admin UI (under Settings > General) but
 * used here to later set the server's locale.
 */
define('WPLANG', 'fr_FR');

// DB INTERNALS
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

// Set the following to true to have WP repairs its database tables, refresh page, set back to false.
// define('WP_ALLOW_REPAIR', false);

/*
 * DIRECTORY CUSTOMIZATION:
 * Make it less obvious that your site is using wordpress.
 */

// Rename 'wp-content' folder to 'app' AND change its location.
define( 'WP_CONTENT_DIR', dirname(__FILE__) . '/app' );
define( 'WP_CONTENT_URL', PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER . '/app');

// Rename uploads folder.
// define( 'UPLOADS', '/app/uploads' );

// Rename plugins folder.
// define( 'WP_PLUGIN_DIR', dirname(__FILE__)  . '/app/plugins' );
// define( 'WP_PLUGIN_URL', PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER . '/app/plugins');

// You cannot move the Themes folder, but your can register an additional theme directory.
// register_theme_directory( dirname( __FILE__ ) . '/themes-dev' );

// Prevent users from editing themes and plugins via the UI.
define( 'DISALLOW_FILE_MODS', false ); // Warning: this hides access to "add new plugins" functionality.
define( 'DISALLOW_FILE_EDIT', false );

// Cron system - If you can, disable wp_cron and use a real cronjob to trigger /wp-cron.php.
// define( 'DISABLE_WP_CRON', true );

// SSL
if ( PROTOCOL === 'https://' ){
	define( 'FORCE_SSL_LOGIN', true );
	define( 'FORCE_SSL_ADMIN', true );
}

// If you don't plan to post via email, decrease this.
// define('WP_MAIL_INTERVAL', 86400); // 1 day (instead of 5 minutes)

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'put something here');
define('SECURE_AUTH_KEY',  'put something here');
define('LOGGED_IN_KEY',    'put something here');
define('NONCE_KEY',        'put something here');
define('AUTH_SALT',        'put something here');
define('SECURE_AUTH_SALT', 'put something here');
define('LOGGED_IN_SALT',   'put something here');
define('NONCE_SALT',       'put something here');


// ------------------------  MULTISITE MODE  --------------------- //

// define('WP_ALLOW_MULTISITE',   true );               // Enable multisite mode.
// define('SUBDOMAIN_INSTALL',    false);               // Leave false to use subdirectories.
// define('DOMAIN_CURRENT_SITE',  DOMAIN_NAME);
// define('PATH_CURRENT_SITE',    '/');
// define('SITE_ID_CURRENT_SITE', 1);
// define('BLOG_ID_CURRENT_SITE', 1);

// Must-use Plugins. These plugins are loaded by default before any other plugins.
// define( 'WPMU_PLUGIN_DIR', dirname(__FILE__) . '/extensions/builtin' );
// define( 'WPMU_PLUGIN_URL', 'http://mywebsite.com/extensions/builtin' );

// Where to redirect users stumbling on a 404 website?
// define( 'NOBLOGREDIRECT', 'http://mainwebsite.com' );


/*  ------------------------ OTHER CONSTANTS YOU COULD NEED  --------------------- */

// MEMORY ALLOCATION
// define('WP_MEMORY_LIMIT',     '32M');
// define('WP_MAX_MEMORY_LIMIT', '32M');                // Admin area specifically.
// define('WP_DEFAULT_THEME',    'twentyeleven');       // Custom Default Theme.

// Custom Database Table for Users
// define( 'CUSTOM_USER_TABLE',      $table_prefix . 'peeps' );
// define( 'CUSTOM_USER_META_TABLE', $table_prefix . 'peepmeta' );

// More Cron
// define( 'WP_CRON_LOCK_TIMEOUT', 120 );               // cron repeat interval
// define( 'ALTERNATE_WP_CRON',    true );              // Issues with cron? Try this setting as a last resort.

// Auto-updates
// define( 'AUTOMATIC_UPDATER_DISABLED',   true );      // Disable all automatic updates
// define( 'WP_AUTO_UPDATE_CORE',          false );     // Disable all core updates
// define( 'WP_AUTO_UPDATE_CORE',          true );      // Enable all core updates, including minor and major
// define( 'WP_AUTO_UPDATE_CORE',          'minor' );   // Enable core updates for minor releases (default)
// define( 'DO_NOT_UPGRADE_GLOBAL_TABLES', true );      // Disable DB Tables auto-update


// --------------------------  STOP EDITING PAST THIS POINT  --------------------- //

$table_prefix = TABLE_PREFIX;

// Adapt your servers to the chosen locale.
setlocale(LC_ALL, WPLANG);

// For compatibility with old plugins - DNU - ERROR 500 (crashes the server) !!!
// if (isset(WP_PLUGIN_DIR)) define( 'PLUGINDIR',  WP_PLUGIN_DIR );

// Absolute path to WordPress.
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . PATH_TO_WP);
require_once(ABSPATH . 'wp-settings.php');
?>
