<?php

/**
 * Bluewater 7 MVC Core Bootstrap file.

 * This is where all the pathing and relative information
 * is defined and referenced from.
 *
 * Your application index.php must INCLUDE this file first off to
 * establish relative pathing properly
 *
 * This file should live outside of web accessible directories
 *
 * This file is part of Bluewater 7 MVC.<br />
 * <i>Copyright (c) 2006 - 2017 Walter Torres <walter@torres.ws></i>
 *
 * <b>NOTICE OF LICENSE</b><br />
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at:
 * {@link http://opensource.org/licenses/osl-3.0.php}.<br />
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@bluewatermvc.org so one can sent to you immediately.
 *
 * <b>DISCLAIMER</b><br />
 * Do not modify to this file if you wish to upgrade Bluewater 7 MVC
 * in the future. If you wish to customize Bluewater 7 MVC for your needs
 * please refer to {@link http://web.bluewatermvc.org} for more information.
 *
 * PHP version 7+
 *
 * @package     Bluewater7_Core
 * @subpackage  Support
 * @link        http://web.bluewatermvc.org
 *
 * @author      Walter Torres <walter@torres.ws>
 * @version     v.7.0 (06/12/2017)
 *
 * @copyright   Copyright (c) 2006 - 2017 Walter Torres <walter@torres.ws>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @filesource
 *
 */

declare(strict_types=1); // strict mode
// namespace Bluewater7;

// ******************************************************************
// ******************************************************************

// No need to change anything below this point.
// Just make sure you know what this is doing if you decide to
// change anything!

// ******************************************************************
// ******************************************************************

// NOTE: The CONSTANTS "SITE_ROOT", "APP_ROOT", "CACHE_ROOT"
//       "BLUEWATER" and "LIBRARY" must be defined in the
//       "index.php" located in your application web root.

/**
 * MODEL defines where all the Application specific Database support
 * files reside.
 *
 * This is a child directory of APP_ROOT
 * Do not place a slash at the end of this path.
 *
 * @name     MODEL
 * @constant string
 *
 * @since    1.0
 *
 */
\define('APP_MODEL', \APP_ROOT . \DS . 'Model');

/**
 * CONTROL defines where all the Application specific Controllers
 * and business logic files reside.
 *
 * This is a child directory of APP_ROOT
 * Do not place a slash at the end of this path.
 *
 * @name     CONTROL
 * @constant string
 *
 * @since    1.0
 *
 */
\define('APP_CONTROL', \APP_ROOT . \DS . 'Controller');

/**
 * VIEW defines where all the Application specific View/GUI pages reside.
 *
 * This is a child directory of APP_ROOT
 * Do not place a slash at the end of this path.
 *
 * @name     VIEW
 * @constant string
 *
 * @since    1.0
 *
 */
\define('APP_VIEW', \APP_ROOT . \DS . 'View');

/**
 * APP_PLUGIN defines where all the Plugin page reside.
 *
 * This is a child directory of APP_ROOT
 * Do not place a slash at the end of this path.
 *
 * @name     APP_PLUGIN
 * @constant string
 *
 * @since    1.0
 *
 */
\define('APP_PLUGIN', \APP_ROOT . \DS . 'Plugin');

/**
 * TEMPLATE defines where all the Application specific GUI templates reside.
 *
 * This is a child directory of VIEW
 * Do not place a slash at the end of this path.
 *
 * @name     TEMPLATE
 * @constant string
 *
 * @since    1.0
 *
 */
\define('APP_TEMPLATE', \APP_VIEW . \DS . 'Templates');

/**
 * MOD_ROOT defines where all the Application modules reside.
 *
 * This is a child directory of VIEW
 * Do not place a slash at the end of this path.
 *
 * @name     APP_ROOT
 * @constant string
 *
 * @since    1.0
 *
 */
\define('MOD_ROOT', \APP_ROOT . \DS . 'Modules');

/**
 * LOG_ROOT defines where all the Application specific log files reside.
 *
 * This is a child directory of APP_ROOT
 * Do not place a slash at the end of this path.
 *
 * @name     LOG_ROOT
 * @constant string
 *
 * @since    1.0
 *
 */
\define('LOG_ROOT', \APP_ROOT . \DS . 'Logs');


// ******************************************************************
// Define default path values in case this is not run via Web Server
$webRoot = '/';
$loginRedirect = false;
$is_IIS = false;
$protocol = '';


// This section is only run if the script is called from a webserver
if (isset($_SERVER['HTTP_HOST']{0})) {
   /**
    * Defines relative pathing of the web server
    *
    * Similar to SITE_ROOT, except this defines relative pathing from
    * the web server POV. This allows files to be moved, or the entire
    * site to be relocated and all pathing will be uneffected.
    *
    * @author Walter Torres <walter@torres.ws>
    *
    * @access public
    *
    * @param  string $webRoot default value of web root
    *
    * @return void
    *
    * @since 1.0
    */

    // default values
    $webRoot = '';
    $protocol = '';
    $httpPort = '';

    // Determine which protocol was used
    $protocol = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

    // See if the $_SERVER['SERVER_PORT'] was defined
    if (isset($_SERVER['SERVER_PORT']{0})) {
        // We don't need PORT if it is using standard httpPort numbers
        if ((($_SERVER['SERVER_PORT'] !== '80' ) && ($protocol === 'http'))
        ||  (($_SERVER['SERVER_PORT'] !== '443') && ($protocol === 'https'))) {
            $httpPort = ':' . $_SERVER['SERVER_PORT'];
        }
    }

    // Build the URL sting
    $webRoot = $protocol . '://' . WEB_HOST . $httpPort . $webRoot;

    // Correct DIR BOUNDARIES
    $webRoot = str_ireplace('\\', '/', $webRoot). '/';

   /**
    * Boolean indicating whether this server is IIS or not
    *
    * @name $is_IIS
    * @var  boolean
    *
    */
    $is_IIS = false !== strpos($_SERVER['SERVER_SOFTWARE'], 'IIS') ;


   /**
    * Web based path to login screen
    *
    * @name $loginRedirect
    * @var  string
    *
    */
    $loginRedirect = $webRoot . '/login';

}


/**
 * HTTP_PROTOCOL is set with 'http' or 'https' .
 *
 * @name     HTTP_PROTOCOL
 * @constant string
 *
 * @since    1.0
 *
 */
\define('HTTP_PROTOCOL', $protocol);

/**
 * HTTP_PORT is set with server httpPort that was accessed.
 *
 * @name     HTTP_PORT
 * @constant string
 *
 * @since    1.0
 *
 */
\define('HTTP_PORT', $httpPort);


/**
 * WIN_IIS indicates if current server is Windows IIS
 *
 * @name     WIN_IIS
 * @constant boolean
 *
 * @since    1.0
 *
 */
\define('WIN_IIS', $is_IIS);

/**
 * WEB_ROOT defines the actual URL used by the current application.
 *
 * Use this constant to ensure proper pathing on all application links.
 *
 * @name     WEB_ROOT
 * @constant string
 *
 * @since    1.0
 *
 */
\define('WEB_ROOT', $webRoot);

/**
 * JS_PATH defines where Javascript files are to be served from.
 *
 * Use this constant to ensure quick access to the script files.
 *
 * @name     JS_PATH
 * @constant string
 *
 * @since    1.0
 *
 */
\define('JS_PATH', \WEB_ROOT . 'js');

/**
 * CSS_PATH defines where CSS files are to be served from.
 *
 * Use this constant to ensure quick access to the CSS files.
 *
 * @name     CSS_PATH
 * @constant string
 *
 * @since    1.0
 *
 */
\define('CSS_PATH', \WEB_ROOT . 'css');

/**
 * IMAGE_PATH defines where image files are to be served from.
 *
 * Use this constant to ensure quick access to the image files.
 *
 * @name     IMAGE_PATH
 * @constant string
 *
 * @since    1.0
 *
 */
\define('IMAGE_PATH', \WEB_ROOT . 'images');

// Release vars
unset($webRoot, $protocol, $httpPort, $is_IIS, $loginRedirect);



// ******************************************************************

// Remove any existing autoloads
\spl_autoload_register(null, false);

// specify extensions that may be loaded
\spl_autoload_extensions('.php');

/**
 * Class library autoloader using a pseudo namespace format.
 *
 * If a Class is not already loaded within PHP, this magic
 * function will attempt to load the class from within the Library
 * directory.
 *
 * Class names are in a pseudo namespace format: 'First_Second_Third',
 * where each part of the class name is used to build a pathname
 * for the class. The example here would be parsed into:
 *    /library/First/Second/Third.php
 * The last word after the last underscore is assumed to be the
 * actual file name of the class
 *
 * If the class file can't be located, than a dummy class is created
 * and an Exception is thrown.
 *
 * @author Walter Torres <walter@torres.ws>
 *
 * @access   public
 * @uses     Exception
 *
 * @uses LIBRARY path to Library Class files
 *
 * @param  string $className Class to load
 * @return void
 *
 */
//function library_loader($className)
//{
//    $classPath = \LIBRARY . \DS
//    . \str_replace('_', \DS, $className)
//    . '.php';
//
//    // If the file is where we think it should be, load it
//    class_loader($classPath, $className);
//}


/**
 * Application Model Class autoloader using a pseudo namespace format.
 *
 * Model Files are located in the model directory under the name of the
 * Database they represent. Each file corresponds to an individual table.
 * The Class name of these "model" files should be defined as:
 *    class {dbName}_{tableName}
 * Using this method, multiple databases can be accessed within a single
 * application. We are only concerned about the first part of the name,
 * before the first underscore '_', all other underscores are ignored.
 *
 * If the class file can't be located, than a dummy class is created
 * and an Exception is thrown.
 *
 * @author Walter Torres <walter@torres.ws>
 *
 * @access   public
 * @uses     Exception
 *
 * @uses MODEL path to Application Model Class files
 *
 * @param  string $className Class to load
 * @return void
 */
//function module_loader($className)
//{
//    // Tear apart class name
//    $parts = \explode('_', $className);
//
//    // Put the Class/Table name back together
//    $className = \implode('_', $parts);
//
//    $classPath = \MOD_ROOT . \DS
//    . \str_replace('_', \DS, $className)
//    . '.php';
//
//    // If the file is where we think it should be, load it
//    class_loader($classPath, $className);
//}

/**
 * Application Model Class autoloader using a pseudo namespace format.
 *
 * Model Files are located in the model directory under the name of the
 * Database they represent. Each file corresponds to an individual table.
 * The Class name of these "model" files should be defined as:
 *    class {dbName}_{tableName}
 * Using this method, multiple databases can be accessed within a single
 * application. We are only concerned about the first part of the name,
 * before the first underscore '_', all other underscores are ignored.
 *
 * If the class file can't be located, than a dummy class is created
 * and an Exception is thrown.
 *
 * @author Walter Torres <walter@torres.ws>
 *
 * @access   public
 * @uses     Exception
 *
 * @uses MODEL path to Application Model Class files
 *
 * @param  string $className Class to load
 * @return void
 */
//function model_loader($className)
//{
//    $classPath = APP_MODEL . \DS
//    . \str_replace('_', \DS, $className)
//    . '.php';
//
//    // If the file is where we think it should be, load it
//    \class_loader($classPath, $className);
//}


/**
 * Brief Desc line, one line. Next line MUST be blank
 *
 * Multiline description can go here and
 * it will be picked up as written.<br>
 * If you <i>want</i> formatting, you <b>need</b> to add HTML tags.
 *
 * @author Walter Torres <walter@torres.ws>
 *
 * @param $classPath
 * @param $className
 *
 * @since version 1
 *
 * @PHPUnit Not Defined
 */
//function class_loader($classPath, $className)
//{
//    if ($classPath && \file_exists($classPath)) {
//        require_once($classPath);
//
//        // As an aside, if the new class has a 'destruct' method defined,
//        // it will be added to the shutdown functions list.
//        // This is not to be confused with the magic '__destruct()'
//        // method within PHP 5
//        if (\method_exists($className, 'destruct')) {
//            \register_shutdown_function([$className, 'destruct']);
//        }
//    }
//}

    // Register the loader functions, but don't throw an exception on failure
//    \spl_autoload_register('library_loader', false);
//    \spl_autoload_register('module_loader', false);
//    \spl_autoload_register('model_loader', false);

spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'Bluewater7\\';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = \BLUEWATER . \DS . str_replace('/', \DS, $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require_once $file;
    }
});

/**
 * Brief Desc line, one line. Next line MUST be blank
 *
 * Multiline description can go here and
 * it will be picked up as written.
 * DON'T!! but a blank line between the desc text and the CVS/SVN
 * info below, unless you don't this info in your phpDocs
 *
 * @package Error handling
 *
 * @param int    $errno Error Number
 * @param string $errstr Error String
 * @param string $errfile File error occurred
 * @param int    $errline Line number error occurred
 *
 * @return bool|void
 * @throws \ErrorException
 *
 * @author Walter Torres <walter@torres.ws>
 *
 */
function bw_exception_error_handler($errno, $errstr, $errfile, $errline)
{
    // Since this is a generic error handler, determine which specific handler
    // to use based on file path
    $path = \explode('\\', $errfile);

    // Make values into keys.
    $path = \array_flip($path);

    // isset is 300% faster than 'in_array'
    if (isset($path['adodb5'])) {
        throw new Bluewater_Model_DB_Exception($errstr, $errno);
    }

    // No idea on this one
    else
    {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

    return true;
}

  //  set_error_handler('bluewater_exception_error_handler');

// eof
