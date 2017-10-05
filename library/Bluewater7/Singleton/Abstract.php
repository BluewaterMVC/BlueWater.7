<?php

/**
 * PHP Singleton Control Class
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
 * @subpackage  Bluewater_Singleton
 * @link        http://web.bluewatermvc.org
 *
 * @copyright   Copyright (c) 2006 - 2017 Walter Torres <walter@torres.ws>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @filesource
 *
 */

declare(strict_types=1); // strict mode
namespace Bluewater7;

/**
 * PHP Singleton Control Class
 *
 * @author Grzegorz Synowiec - https://gist.github.com/Mikoj
 * @link https://gist.github.com/Mikoj
 *
 * @package     Bluewater_Core
 * @subpackage  Bluewater_Singleton
 *
 * @PHPUnit Not Defined
 *
 * @tutorial tutorial.pkg description
 * @example url://path/to/example.php description
 *
 */
abstract class Singleton_Abstract
{
// ==========================================================
// Class Constants

// ==========================================================
// Class Properties

// ==========================================================
// Class Methods


   /**
    * Class constructor
    *
    * This is passed up to the parent class
    *
    * @access final
    * @private
    *
    * @since 1.0
    *
    * @param void
    * @return void
    *
    */
    final private function __construct()
    {
        // Empty on purpose
    }


   /**
    * Singleton instance
    *
    * @param boolean $force Force a new instance regardless of previous state
    *
    * @return object Object
    */
    final public static function getInstance(bool $force = null)
    {
        /** @var array $ao_instance */
        static $ao_instance = [];

        $called_class = static::class;

        if (($force === true) || (isset($ao_instance[$called_class]) === false)) {
            $ao_instance[$called_class] = new $called_class();
        }

        return $ao_instance[$called_class];
    }

   /**
    * Prevent singletons from being cloned
    *
    * @access final
    * @private
    *
    * @since 1.0
    *
    * @param  void
    * @return void
    *
    */
    final private function __clone()
    {
        // Empty on purpose
    }

   /**
    * Prevent singletons from being serialized
    *
    * @access final
    * @private
    *
    * @since 1.0
    *
    * @param  void
    * @return void
    *
    */
    final private function __wakeup()
    {
        // Empty on purpose
    }
}

// eof
