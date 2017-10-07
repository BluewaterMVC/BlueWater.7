<?php

/**
 * Configuration Class to process Bluewater 7 MVC Core config file
 * and an application level config file.
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
 * @subpackage  Helper
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

declare(strict_types=1);

namespace Bluewater7\Helper;

/**
 * Helper class to recursively merges arrays.
 *
 * If one of the Arguments isn't an Array, first Argument is returned.
 * If an Element is an Array in both Arrays, Arrays are merged recursively,
 * otherwise the element in $ins will overwrite the element in $arr
 * (regardless if key is numeric or not). This also applies to Arrays in
 * $arr, if the Element is scalar in $ins (in difference to the previous
 * approach).
 *
 * @package     Bluewater_Core
 * @subpackage  Helper
 *
 * @example /examples
 *
 * @author Walter Torres <walter@torres.ws>
 * @version $Revision: 1.0 $
 *
 */
class Helper_Array_Insert
{
// ==========================================================
// Class Constants

// ==========================================================
// Class Properties

// ==========================================================
// Class Methods
   /**
    * Each Helper class has to have an empty __construct method
    *
    * @access public
    * @final
    *
    * @param void
    * @return void
    *
    */
    public final function __construct()
    {
        // Empty on purpose.
    }


   /**
    * Recursively merges arrays
    *
    * Setup inbound parameters for actual method call.
    *
    * Method arguments are actually sent within an indexed array.
    *
    * @uses classmethod Helper_Array_Insert::arrayInsert()
    *
    * @access public
    *
    * @param array $_args Method arguments are sent within an indexed array
    * @return array $arr Merges arrays
    */
    final public function helper(array $_args = null) : array
    {
        // Array to merge into
        /** @var array $target */
        $target = $_args[0] ?? [];

        // Array to merge from
        /** @var array $source */
        $source = $_args[1] ?? [];

        // Send off to recursive method
        return $this->array_insert($source, $target);
    }

   /**
    * Recursively merges arrays
    *
    * This method does the actual work.
    *
    * @author thomas@thoftware.de
    * @link http://us2.php.net/manual/en/function.array-merge-recursive.php#82976
    *
    * @uses Helper_Array_Insert::_array_insert()
    *
    * @access private
    *
    * @param array $target Array to merge into
    * @param array $source Array to merge from
    *
    * @return array $target Merges arrays
    */
    private function array_insert(array $target = null, array $source = null) : array
    {
        // Loop through all Elements in $ins:
        if (\is_array($target) && \is_array($source)) {
            foreach ($source as $k => $v) {
                # Key exists in $arr and both Elements are Arrays: Merge recursively.
                if (isset($target[$k]) && \is_array($v) && \is_array($target[$k])) {
                    $target[$k] = $this->array_insert($target[$k], $v);
                }
                // Place more Conditions here (see below)
                elseif (\is_int($k)) {
                    $target[] = $v;
                }
                // Otherwise replace Element in $arr with Element in $target:
                else {
                    $target[$k] = $v;
                }
            }
        }

        # Return merged Arrays:
        return $target;
    }
}

// eof
