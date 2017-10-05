<?php declare

/**
 * Controller Helper Class
 *
 * This file is part of Bluewater 7 MVC.<br />
 * <i>Copyright (c) 2006 - 2011 Walter Torres <walter@torres.ws></i>
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
 * @subpackage  Helper
 * @link        http://web.bluewatermvc.org
 *
 * @copyright   Copyright (c) 2006 - 2017 Walter Torres <walter@torres.ws>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @filesource
 *
 */

(strict_types=1); // strict mode
namespace Bluewater7;

/**
 * Controller Helper Class
 *
 * Multiline description can go here and
 * it will be picked up as written.
 * DON'T!! but a blank line between the desc text and the CVS/SVN
 * info below, unless you don't this info in your phpDocs
 *
 * @package     Bluewater_Core
 * @subpackage  Helper
 *
 * @PHPUnit Not Defined
 *
 * @example /examples
 *
 * @author Walter Torres <walter@torres.ws>
 * @version $Revision: 1.0 $
 *
 */
class Helper extends Singleton_Abstract
{

// ==========================================================
// Class Constants

// ==========================================================
// Class Properties

   /**
    * Helper Class name
    *
    * @var string
    * @access protected
    * @static
    *
    * @since 1.0
    */
    static protected $helper = false;

    /**
     * New Helper Class name
     *
     * @var string
     * @access private
     * @static
     *
     * @since 1.0
     */
    static private $newHelper;



// ==========================================================
// Class Methods

    /**
     * Magical PHP Method to call unknown methods within
     * an unknown class.
     *
     * @author Walter Torres <walter@torres.ws>
     *
     * @uses classmethod self::loadHelper()
     * @uses property self::new_helper
     *
     * @final
     * @access public
     *
     * @PHPUnit Not Defined
     *
     * @since 1.0
     *
     * @param  string $_method Method to call
     * @param  array  $_args An array of arguments to send to method
     *
     * @return mixed $helper  Whatever operation Helper Class performs
     *
     * @throws \Exception
     */
    final public function __call(string $_method, array $_args)
    {
        // Attempt to load Controller
        $this->loadHelper($_method);

        // Attempt to instantiate new class object
        if (\class_exists(self::$newHelper, false)) {
            $new_helper = new self::$newHelper;

            // Load Helper Support Class, so Helpers can use Helpers!!!
            $new_helper->helper = self::getInstance(true);
        } else {
            // Now we THROW an exception to handle this failure on our
            // own terms.
            throw new \Exception('Helper: "' . $_method . '" method could not be located.');
        }

        // Call Method with parameters
        return $new_helper->helper($_args);
    }

   /**
    * Load HELP Class files
    *
    * Each file corresponds to an individual Helper Method.
    * The Class name of these "helper" files should be defined as:
    *    class Helper_{Helper_Name}
    * Each Helper class must have a "helper" method defined. This
    * method does the setup or actual work.
    *
    * @uses classmethod self::upperFirst()
    * @uses property self::new_helper
    * @uses const APP_ROOT
    * @uses constBLUEWATER
    *
    * @access private
    *
    * @param string $_helperName Name of Helper Class to utilize
    * @return void
    *
    * @throws void
    */
    private function loadHelper(string $_helperName)
    {
        // Tear apart helper name, capitalize first letter, and put back together
        /** @var string $filename */
        $filename = \implode('_', \array_map([$this, 'upperFirst'], \explode('_', $_helperName)));

        // Create Class name
        self::$newHelper = 'Helper_' . $filename;

        /** @var string $app_helper_path */
        $app_helper_path  = \APP_ROOT  . '/Helper/' . $filename . '.php';

        /** @var string $helper_path */
        $helper_path = \BLUEWATER . '/Helper/' . $filename . '.php';

        // Try to load Application level Helper first, as this will supersede
        // Bluewater 7 MVC Library Helpers
        /** @var string $app_helper_path */
        if (\file_exists($app_helper_path)) {
            $helper_path = $app_helper_path;
        }
        // Otherwise try to load Bluewater Library Helper
        else if (\file_exists($helper_path) === false) {
            \Exception($helper_path . 'Helper not defined.');
        }

        require_once($helper_path);

        // As an aside, if the new class has a 'destruct' method defined,
        // it will be added to the shutdown functions list.
        // This is not to be confused with the magic '__destruct()'
        // method within PHP 5
        if (\method_exists($_helperName, 'destruct')) {
            \register_shutdown_function([$_helperName, 'destruct']);
        }
    }

   /**
    * Helper class to capitalize first letter of sentence/word.
    *
    * Simple quick function to make a sentence/word into a Sentence Case,
    * first letter is capitalize all others are lower case. Yes, PHP
    * has "ucfirst()", but it has a flaw; it does not effect any other
    * letters of a given string. If any of them are uppercase, they stay
    * uppercase. This method forces all letters to lower and then caps
    * the first.
    *
    * Yes, this should, and is, a HELPER, but this class doesn't have
    * access to the HELPERs.
    *
    * @access private
    *
    * @param  string $_str String to change word case on
    * @return string $_str String that was changed
    */
    private function upperFirst($_str) : string
    {
        return \ucfirst(\strtolower($_str));
    }
}

// eof
