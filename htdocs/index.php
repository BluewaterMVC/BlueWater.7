<?php

/**
 * Bluewater 7 MVC index page.
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

namespace Bluewater7;

use \Bluewater7\Config;

    /**
     * Right off the bat, make sure we have the correct version of PHP
     */
    if (! \version_compare(\PHP_VERSION, '7', '>=')) {
        \header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'Bluewater 7 MVC require version PHP 7.0 or greater.';
        exit(1); // EXIT_ERROR
    }

    /**
     * Redefine DIRECTORY_SEPARATOR for easier handling.
     *
     * @name     DS
     * @constant string
     *
     * @since    1.0
     *
     */
    \define('DS', \DIRECTORY_SEPARATOR);

    /**
     * Due to security concerns of domain spoofing, the site domain
     * the domain this service will be running on needs to be defined
     * here as a CONSTANT.
     *
     * Protocol and Port will be discovered as process is run
     *
     * @name     HOST
     * @constant string
     *
     * @since    7.0
     *
     */
    \define('WEB_HOST', 'bluewater7.dev');

    /**
     * This is where all the pathing and relative information
     * is defined and referenced from.
     *
     * All pages need to INCLUDE this file first off to establish
     * relative pathing properly
     *
     * This file should live outside of web accessible directories
     *
     */

    /**
     * This is the OS Path location that contains the root directory.
     * All other path constants are derived from this one.
     *
     * Due to file locations, and procedures within Bluewater 7 MVC,
     * this path must be hand coded here. If the overall structure
     * changes, this value has to change as well.
     *
     * Do not place a slash at the end of this path.
     *
     * @name     SITE_ROOT
     * @constant string
     *
     * @since    1.0
     *
     */
    \define('SITE_ROOT', \DS . 'var' . \DS . 'www' . \DS . 'bluewater7.dev');

    /**
     * APP_ROOT defines where all the Application specific files reside.
     *
     * This should be outside your web accessible directories.
     * Do not place a slash at the end of this path.
     *
     * @name     APP_ROOT
     * @constant string
     *
     * @since    1.0
     *
     */
    \define('APP_ROOT', \SITE_ROOT . \DS . 'application');

    /**
     * CONFIG_ROOT defines where all the Application specific config files reside.
     *
     * Do not place a slash at the end of this path.
     *
     * @name     CONFIG_ROOT
     * @constant string
     *
     * @since    1.0
     *
     */
    \define('CONFIG_ROOT', \APP_ROOT . \DS . 'Config');

    /**
     * CACHE_ROOT defines where all the Application specific cache files reside.
     *
     * Do not place a slash at the end of this path.
     *
     * @name     CACHE_ROOT
     * @constant string
     *
     * @since    1.0
     *
     */
    \define('CACHE_ROOT', \SITE_ROOT . \DS . 'Cache');

    /**
     * LIBRARY defines where all the third-party libraries reside.
     *
     * This should be outside your web accessible directories.
     * Do not place a slash at the end of this path.
     *
     * @name     LIBRARY
     * @constant string
     *
     * @since    1.0
     *
     */
    \define('LIBRARY', \SITE_ROOT . \DS . 'library');

    /**
     * BLUEWATER defines where all the Bluewater 7 MVC Core files reside.
     *
     * This is a child directory of LIBRARY
     * Do not place a slash at the end of this path.
     *
     * @name     BLUEWATER
     * @constant string
     *
     * @since    1.0
     *
     */
    \define('BLUEWATER', \LIBRARY . \DS . 'Bluewater7');

// ******************************************************************
// ******************************************************************

    require_once \LIBRARY . \DS . 'debug.php';

    // Load system initialization data
    require_once \BLUEWATER . \DS . 'bootstrap.php';

    // Load Bluewater 7 CONFIG data
    Config::getInstance();

/*
 * Different environments require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
    switch (\BW_ENV) {
        case 'development':
            \error_reporting(-1);
            \ini_set('display_errors', 1);
            break;

        case 'testing':
        case 'production':
            \error_reporting(\E_ALL & ~\E_NOTICE & ~\E_STRICT & ~\E_USER_NOTICE);
            \ini_set('display_errors', 0);
            break;

        default:
            \header('HTTP/1.1 503 Service Unavailable.', true, 503);
            echo 'The application environment is not set correctly.';
            exit(1); // EXIT_ERROR
    }

//    // Activate Sessions, maybe
//    if (\SESSION !== false) {
//        Bluewater_Session::init();
//    }

    // Dispatch Controller
    Bluewater_Dispatcher::Dispatch();

// eof
