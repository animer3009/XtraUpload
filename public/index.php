<?php
/**
 * XtraUpload
 *
 * A turn-key open source web 2.0 PHP file uploading package requiring PHP v5
 *
 * @package		XtraUpload
 * @author		Matthew Glinski
 * @copyright	Copyright (c) 2006, XtraFile.com
 * @license		http://xtrafile.com/docs/license
 * @link		http://xtrafile.com
 * @since		Version 2.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * XtraUpload Front-Conroller
 *
 * @package		CodeIgniter
 * @author		Matthew Glinski - Codeigniter Dev Team
 */

// ------------------------------------------------------------------------

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
	define('ENVIRONMENT', 'development');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */

if (defined('ENVIRONMENT'))
{
    switch (ENVIRONMENT)
    {
        case 'development':
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
            break;

        case 'testing':
        case 'production':
            error_reporting(0);
            break;

        default:
            exit('The application environment is not set correctly.');
    }
}

// TODO: Move PHP version check to installer. No need for every page load.
// define PHP version ID for versions less then 5.2.7
if(!defined('PHP_VERSION_ID'))
{
    $version = PHP_VERSION;

    define('PHP_VERSION_ID', ($version{0} * 10000 + $version{2} * 100 + $version{4}));
}

if(PHP_VERSION_ID < 50207)
{
    define('PHP_MAJOR_VERSION',     $version{0});
    define('PHP_MINOR_VERSION',     $version{2});
    define('PHP_RELEASE_VERSION',     $version{4});
}

// if the user is running a PHP version less the 5.2.1, WE MUST DIE IN A FIRE!
if(PHP_VERSION_ID < 50201)
{
    $message = "Your installed PHP version is less then 5.2.1. XtraUpload requires at least PHP v5.2.1+ to run correctly. The latest version is highly reccomended. XtraUpload will not run until this basic requirement is met, and has quit.";

    return $message;
}

// TODO: Move this to admin panel. No need for it to happen here.
// Check for setup/upgrade folders and stop running if found
$setup_exists = file_exists('./setup');
$upgrade_exists = file_exists('./upgrade');

// TODO: Move this to a later point in the bootstrap.
// Send user to setup folder to configure script, if exists
if(($setup_exists or $upgrade_exists) and ($_SERVER['HTTP_HOST'] != 'localhost' and substr($_SERVER['HTTP_HOST'], 0, 7) != '192.168' and ENVIRONMENT != 'development'))
{
    echo "<html><head><title>XtraUpload: Fatal Error</title></head><body><h2 style='color:#F00'>WARNING!!!</h2><h3 style='text-decoration:underline'>The <a href='../setup' target='_blank'>Setup</a> and/or <a href='../upgrade' target='_blank'>Upgrade</a> folders exist!</h3><p>This is a BIG security risk and as such XtraUpload will not continue loading until these folders are deleted from your server. If you have just uploaded XtraUpload or are upgrading from a previous version use the above links to either: <ul><li><a href='../setup' target='_blank'>Setup XtraUpload for the first time</a></li><li><a href='../upgrade' target='_blank'>Upgrade XtraUpload from a previous version.</a></li></ul>Once complete please delete the 2 folders and reload this page.</p></body></html>";
    exit();
}

/*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same  directory
 * as this file.
 *
 */
	$system_path = '../system';

/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server.  If
 * you do, use a full server path. For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 *
 */
	$application_folder = realpath('../application');

/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here.  For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT:  If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller.  Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 *
 */
	// The directory name, relative to the "controllers" folder.  Leave blank
	// if your controller is not in a sub-folder within the "controllers" folder
	// $routing['directory'] = '';

	// The controller class file name.  Example:  Mycontroller
	// $routing['controller'] = '';

	// The controller function you wish to be called.
	// $routing['function']	= '';


/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 *
 */
	// $assign_to_config['name_of_config_item'] = 'value of config item';



// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

	// Set the current directory correctly for CLI requests
	if (defined('STDIN'))
    {
        chdir(dirname(__FILE__));
    }

	if (realpath($system_path) !== FALSE)
    {
        $system_path = realpath($system_path).'/';
    }

	// ensure there's a trailing slash
	$system_path = rtrim($system_path, '/').'/';

	// Is the system path correct?
	if ( ! is_dir($system_path))
    {
        exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
    }

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
	// The name of THIS file
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// The PHP file extension
	// this global constant is deprecated.
	define('EXT', '.php');

	// Path to the system folder
	define('BASEPATH', str_replace("\\", "/", $system_path));

	// Path to the front controller (this file)
	define('FCPATH', str_replace(SELF, '', __FILE__));

	// Name of the "system folder"
	define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

    define('VENDORPATH', realpath('./../').'/vendor/');

	// The path to the "application" folder
	if (is_dir($application_folder))
    {
        define('APPPATH', $application_folder.'/');
    }
    else
    {
        if ( ! is_dir(BASEPATH.$application_folder.'/'))
        {
            exit("Your application folder path does not appear to be set correctly. Please open the following file and correct this: ".SELF);
        }

        define('APPPATH', BASEPATH.$application_folder.'/');
    }

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 *
 */
require_once VENDORPATH.'autoload.php';
require_once BASEPATH.'core/CodeIgniter.php';

/* End of file index.php */
/* Location: ./index.php */