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

declare(strict_types=1);

namespace Bluewater7;

//use Bluewater7\Helper;

/**
 * Allows for multi-dimensional ini files.
 *
 * The native parse_ini_file() function will convert the following ini file:...
 *
 * [production]
 * localhost.database.host = 192.168.0.500
 * localhost.database.user = my_id
 * localhost.database.password = myPassword
 *
 * [development:production]
 * localhost.database.host = localhost
 *
 * This class allows you to convert the specified ini file into a multi-dimensional
 * array. In this case the structure generated will be:
 *
 * array
 *   'localhost' =>
 *     array
 *       'database' =>
 *         array
 *           'host' => 'localhost'
 *           'user' => 'root'
 *           'password' => 'myPassword'
 *
 * As you can also see you can have sections that extend other sections (use ":" for that).
 * The extendable section must be defined BEFORE the extending section or otherwise
 * you will get an exception.
 *
 * BOOLEANS are also a special case.
 * debug_enabled = 'true' will be converted into a true BOOLEAN, where as
 * debug_enabled = true will be converted to an INT of '1'
 *
 * This class also allows for string substitution.
 * location = {APP_ROOT}/locale will be converted to the value defined in APP_ROOT
 */


 /**
  * Configuration Class to process Bluewater 7 MVC Core config file
  * and an application level config file.
  *
  * Configuration files are standard INI format file with additional features of:
  *  - string substitution
  *  - true boolean conversion
  *  - multi-dimensional arrays from DOT delimited strings
  *
  * @package     Bluewater7_Core
  * @subpackage  Support
  * @link        http://web.bluewatermvc.org
  *
  * @howto {@link http://guides.bluewatermvc.org/doku.php/dev/classes/general/config#configuration_class}
  * @example url://path/to/example.php description
  *
  * @PHPUnit Not Defined
  *
  * @todo Create PHPUnit test, tutorials and example files for this class
  * @todo look into converting this into a DBA access type class via SPL
  * @todo Change __construct so that it respects the singleton instance of Bluewater_Helper
  *
  */
class Config
{
// ==========================================================
// Class Constants

// ==========================================================
// Class Properties

   /**
    * Class instance
    *
    * @var \Bluewater7\Config
    * @access private
    * @static
    *
    * @since 1.0
    */
    private static $instance = false;

   /**
    * Config data in named array
    *
    * @var array
    * @access private
    * @static
    *
    * @since 1.0
    */
    private static $conf = [];

   /**
    * Helper Object Container
    *
    * @var \Bluewater7\Helper
    * @access private
    * @static
    *
    * @since 1.0
    */
    private static $helper;

   /**
    * Internal storage array
    *
    * @var array
    * @access private
    * @static
    *
    * @since 1.0
    */
    private static $result = [];


// ==========================================================
// Class Methods


    /**
     * Config constructor.
     *
     * If config files are not defined, no error is thrown.
     *
     * @author Walter Torres <walter@torres.ws>
     *
     * @uses class Bluewater_Helper
     * @uses class Helper_Array_Insert
     *
     * @uses classmethod self::_load()
     * @uses classmethod self::_parse_constants()
     * @uses classmethod self::_parse_fields()
     * @uses classmethod self::local()
     *
     * @uses classmethod self::$process_sections
     * @uses classmethod self::$helper
     * @uses classmethod self::$conf
     *
     * @uses const BLUEWATER
     * @uses const APP_ROOT
     *
     * @final
     * @access private
     *
     * @param boolean $process_sections    By setting the process_sections parameter to TRUE,
     *                                    you get a multidimensional array, with the section
     *                                    names and settings included. The default for
     *                                    process_sections is FALSE
     *
     * @return void
     *
     * @throws void
     *
     * @since 1.0
     *
     * @PHPUnit Not Defined
     */
    final private function __construct(bool $process_sections = true)
    {
        // Load Helper Support Class
        self::$helper = new Helper;

        // Path to main Config file to load raw data
        self::load(\BLUEWATER . '/Bluewater.ini.php', $process_sections);

        // Load all INI files in APP Config directory
        foreach (new \DirectoryIterator(\APP_ROOT . '/Config') as $ini_file) {
            if ($ini_file->isFile()) {
                if (\substr($ini_file->getFilename(), -7) === 'ini.php') {
                    self::load(\APP_ROOT . '/Config/' . $ini_file->getFilename(), $process_sections);
                }
            }
        }

        // Parse config data
        self::parse();

        // Transfer temp data into config array
        self::$conf = self::$result;
        self::$result = null;

        // Process i18n settings
        /**
         * @TODO get bindtextdomain/gnu_gettext.dll to work
         */
//        self::setLocale();


        /**
         * @TODO need to thrown an exception if TZ is not defined
         */
        if (self::config('general', 'tz')) {
            // Set default TZ
            \date_default_timezone_set(self::config('general', 'tz'));
        }
    }

    /**
     * A private 'clone' method it ensure that this singleton class
     * can not be duplicated.
     *
     * @author Walter Torres <walter@torres.ws>

     * @access private
     *
     * @param void
     * @return void
     *
     * @throws void
     *
     * @since 1.0
     *
     * @PHPUnit Not Defined
     */
    private function __clone()
    {
    }

    /**
     * Makes sure that this call is a single instance and returns that instance
     *
     * @author Walter Torres <walter@torres.ws>
     *
     * @uses class Bluewater_Config
     *
     * @final
     * @access public
     * @static
     *
     * @param boolean $processSections    By setting the process_sections parameter to TRUE,
     *                                    you get a multidimensional array, with the section
     *                                    names and settings included. The default for
     *                                    process_sections is FALSE
     * @return Config $instance           Class instance
     *
     * @throws void
     *
     * @since 1.0
     *
     * @PHPUnit Not Defined
     */
    final public static function init(bool $processSections = true): Config
    {
        // If we don't have an instance, make one
        if (null!==self::$instance) {
            self::$instance = new self($processSections);
        }

        return self::$instance;
    }

   /**
    * Retrieve section of config data or specific config element.
    *
    * @author Walter Torres <walter@torres.ws>
    *
    * @uses property self::$conf
    *
    * @final
    * @access public
    * @static
    *
    * @param string  $section  Which section to pull
    * @param string  $field    Specific config element to pull info
    * @return mixed  $conf     Config info array
    *
    * @throws void
    *
    * @since 1.0
    *
    * @PHPUnit Not Defined
    */
    final public static function config(string $section = null, string $field = null)
    {
        // assume we fail
        // Give back a NULL, as FALSE could be an expected value
        // But then so can NULL :/
        $config = null;

        // If a SECTION is requested, see if we have it
        if ($section) {
            // give back the entire enchilada
            if ($section === '*') {
                /** @var \ArrayObject $config */
                $config = self::$conf;
            }

            // If SECTION exists, pull it
            else if (\array_key_exists($section, self::$conf)) {
                // If a specific FIELD is requested
                if ($field) {
                    // See if that FIELD exists
                    if (\array_key_exists($field, self::$conf[$section])) {
                        $config = self::$conf[$section][$field];
                    }
                }

                // Otherwise return the entire SECTION
                else {
                    /** @var \ArrayObject $config */
                    $config = self::$conf[$section];
                }
            }
        }

        // Otherwise just give back the entire config array
        else
            /** @var \ArrayObject $array */
            $config = self::$conf;

        return $config;
    }

   /**
    * Loads the LOCALE config setting, defines 'locale' and activates
    * get_text and its settings
    *
    * @author Walter Torres <walter@torres.ws>
    *
    * @uses get_text
    * @uses const APP_ROOT
    * @uses property self::config()
    * @uses property self::setConfig()
    *
    * @link http://en.wikipedia.org/wiki/Internationalization_and_localization
    * @link http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
    * @link http://www.iso.org/iso/english_country_names_and_code_elements
    *
    * @final
    * @access public
    * @static
    *
    * @param  string $locale  language and country code: en_US default
    * @param  string $domain  Which 'domain' of messages to use for translation
    * @return void
    *
    * @throws void
    *
    * @todo This section has not been implemented yet
    *
    * @since 1.0
    *
    * @PHPUnit Not Defined
    */
    final public static function setLocale(string $locale, string $domain)
    {

        // This is not defined on WINDOWS
        if (!\defined('LC_MESSAGES')) {
            \define('LC_MESSAGES', 6);
        }

         // Define GETTEXT domain, if not defined
        if ($domain === false) {
            $domain = self::config('locale', 'domain');
        }

        // Pull data from INI data, if not defined
        if ($locale === false) {
            $locale = self::config('locale');

            $locale = $locale['lang'] . '_' . $locale['country'];
        }

        self::setConfig('locale', 'i18n', $locale);

        // Different servers expect different things.
        // We hope this covers the bases
        \putenv('LANGUAGE='   . $locale); // for some Linux systems
        \putenv('LANG='       . $locale);
        \putenv('\LC_ALL='     . $locale); // for everyone else
        \putenv('LC_MESSAGES='. $locale);

        // setlocale is case-sensitive: setlocale(LC_ALL, $locale);
        // Depending on the system, 'setlocale' expects different things
        // If this does not work for you, experiment with new locale types
        // and let us know so we can add them to this file.

        /** @todo pull these definitions out into an INI file */
        switch ($locale) {
            case 'de_DE':
                $locale_set = \setlocale(\LC_ALL, 'de_DE.UTF-8', 'de_DE', 'deu_deu');
                \setlocale(\LC_NUMERIC, 'DEU');
                \setlocale(\LC_CTYPE,   'DEU');
            break;

            case 'es_ES':
                $locale_set = \setlocale(\LC_ALL, 'es_ES.UTF-8', 'es_ES', 'spanish_spain');
                \setlocale(\LC_NUMERIC, 'ESL');
                \setlocale(\LC_CTYPE,   'ESL');
            break;

            case 'hi_IN':
                $locale_set = \setlocale(\LC_ALL, 'hi_IN.UTF-8', 'hi_IN', 'hindi_india');
                \setlocale(\LC_NUMERIC, 'IND');
                \setlocale(\LC_CTYPE,   'IND');
            break;

            case 'ru_RU':
                $locale_set = \setlocale(\LC_ALL, 'ru_RU.UTF-8', 'ru_RU', 'rus_rus', 'russian_russia');
                \setlocale(\LC_NUMERIC, 'RUS');
                \setlocale(\LC_CTYPE,   'RUS');
            break;

            default:
                $locale_set = \setlocale(\LC_ALL, 'en_US.UTF-8', 'en_US', 'english_us');
                break;
        }

        // bindtextdomain is dependent on gnu_gettext.dll
        \bindtextdomain($domain, \APP_ROOT . '/locale');
        \bind_textdomain_codeset($domain, 'UTF-8');
        \textdomain($domain);
    }

   /**
    * Add or update specific config element
    *
    * @author Walter Torres <walter@torres.ws>
    *
    * @uses property self::$conf
    *
    * @final
    * @access public
    * @static
    *
    * @param  string $section  Which section to place config element into
    * @param  string $field    Specific config element to place value into
    * @param  string $value    Value to place into config element
    * @return void
    *
    * @throws void
    *
    * @since 1.0
    *
    * @PHPUnit Not Defined
    */
    final public static function setConfig(string $section = null, string $field = null, string $value = null)
    {
        if (! isset(self::$conf[$section])) {
            self::$conf[$section] = [];
        }

        self::$conf[$section][$field] = $value;
    }

    /**
     * Load raw config data into Class property array
     *
     * @author Walter Torres <walter@torres.ws>
     *
     * @uses property self::$process_sections
     *
     * @final
     * @access public
     * @static
     *
     * @param string  $config_file INI file to load
     * @param bool    $process_sections
     * @return void
     *
     * @throws void
     *
     * @since 1.0
     *
     * @PHPUnit Not Defined
     */
    final public static function load(string $config_file = null, bool $process_sections = true)
    {
        // Try to load main file config file into class instance
        if ($config_file && \file_exists($config_file)) {
            // load the raw ini file, even utf-8
            $ini_data = \parse_ini_string(\file_get_contents($config_file), $process_sections);

            // Recursively merge arrays
            /** @var \ArrayObject $conf */
            self::$conf = self::$helper->array_insert(self::$conf, $ini_data);
        }
    }

   /**
    * Loads in the ini file specified in filename, and returns the settings in
    * it as an associative multi-dimensional array
    *
    * @author Walter Torres <walter@torres.ws>
    *
    * @uses classmethod self::processConstants()
    * @uses classmethod self::processSection()
    * @uses classmethod self::tempCleanup()
    * @uses property self::$conf
    * @uses property self::$result
    *
    * @access private
    * @static
    *
    * @param void
    * @return void
    *
    * @throws void
    *
    * @since 1.0
    *
    * @PHPUnit Not Defined
    */
    private static function parse()
    {
        // reset the result array
        self::$result = [];

        // CONSTANTS *must* be processed separately from other sections.
        // And they have to be processed first.
        if (isset(self::$conf['constants'])) {
            self::processConstants(self::$conf['constants']);

            // Dump 'constants' section
            unset(self::$conf['constants']);
        }

        // loop through each section
        foreach (self::$conf as $section => $contents) {
            // process sections contents
            self::processSection($section, $contents);
        }

        // Clean up temp subsections
        self::tempCleanup();
    }

   /**
    * Process Constants section
    *
    * @author Walter Torres <walter@torres.ws>
    *
    * @uses classmethod self::convertDataType()
    * @uses classmethod self::expandConstants()
    *
    * @access private
    * @static
    *
    * @param array $constants Constants to parse
    * @return void
    *
    * @throws void
    *
    * @since 1.0
    *
    * @PHPUnit Not Defined
    */
    private static function processConstants(array &$constants)
    {
        // Cycle through CONSTANTS list
        foreach ($constants as $constant => &$value) {
            // Need to handle COMMA delimited strings differently
            if (\strpos($value, ',') !== false) {
                // Forward slash strings will not be converted to array
                // Find and strip, or ignore
                if ($value !== $new = \preg_replace('{^/|/$}', '', $value)) {
                    $value = $new;
                    if (\strpos($value, '{')) {
                        /** @var string $value */
                        $value = self::expandConstants($value);
                    }
                }

                // Convert COMMA delimited string into array
                else {
                    // Split and trim at the same time!
                    /** @var array $value */
                    $value = \preg_split('/\s*[,]\s*/', $value);

                    foreach ($value as $i => $values) {
                        // convert booleans and nulls
                        $value[$i] = self::convertDataType($value[$i]);
                        if (is_string($value[$i]) && (\strstr($value[$i], '{'))) {
                            $value[$i] = self::expandConstants($value[$i]);
                        }
                    }
                }
            }

            // simple data type conversion
            else {
                $value = self::convertDataType($value);

                if (\is_string($value) && (\strpos($value, '{') !== false)) {
                    $value = self::expandConstants($value);
                }

            }
            if (! \defined(\strtoupper($constant))) {
                \define(\strtoupper($constant), $value);
            }
        }
    }

   /**
    * Process contents of the specified section
    *
    * @author Walter Torres <walter@torres.ws>
    *
    * @access private
    * @static
    *
    * @since 1.0
    *
    * @param string $section Section name
    * @param array $contents Section contents
    * @return void
    *
    * @throws void
    *
    * @since 1.0
    *
    * @PHPUnit Not Defined
    */
    private static function processSection(string $section, array $contents)
    {
        /** @var array $contents */
        $contents = self::processSectionContents($contents);

        $temp_section = [];
        // the section extends another section
        if (\strpos($section, ':') !== false) {
            $sub_sections = \explode(':', $section);

            /** The ordinal solution was found on daniweb.com created by
             * https://www.daniweb.com/members/479282/jkon
             */
            $temp_section[$sub_sections[\count($sub_sections) - 1]] = $contents;

            for ($i = \count($sub_sections) - 2; $i > -1; $i--) {
                $temp_section[$sub_sections[$i]] = $temp_section;
                unset($temp_section[$sub_sections[$i + 1]]);
            }

        } else {
            self::$result[$section] = $contents;
        }

        self::$result = self::arrayMergeRecursive(self::$result, $temp_section);
    }

   /**
    * Process contents of a section
    *
    * @author Walter Torres <walter@torres.ws>
    *
    * @final
    * @access private
    * @static
    *
    * @param array $contents Section contents
    * @return array
    *
    * @throws void
    *
    * @since 1.0
    *
    * @PHPUnit Not Defined
    */
    final private static function processSectionContents(array $contents) : array
    {
        $result = [];

        // loop through each line and put it to an array
        foreach ($contents as $element => $value) {
            $process = self::processContentEntry($element, $value);

            // merge the current line with all previous ones
            $result = self::arrayMergeRecursive($result, $process);
        }

        return $result;
    }

    /**
     * Converts DOT delimited string into multi-dimensional array
     *
     * @author Walter Torres <walter@torres.ws>
     *
     * @uses classmethod self::parseValue()
     * @uses classmethod self::processContentEntry()
     *
     * @final
     * @access private
     * @static
     *
     * @param string      $element Current ini file's line's key
     * @param string      $value Current ini file's line's value
     * @param bool|string $section
     *
     * @return array $entry
     *
     * @throws void
     *
     * @since 1.0
     *
     * @PHPUnit Not Defined
     */
    final private static function processContentEntry(string $element, string $value, string $section = null) : array
    {
        $needle_pos = \strpos($element, '.');

        if ($needle_pos === false) {
            $entry = [$element => self::parseValue($value, $section)];
        } else {
            $key = \substr($element, 0, $needle_pos);
            $element = \substr($element, $needle_pos + 1);

            $entry =  [$key => self::processContentEntry($element, $value)];
        }

        return $entry;
    }

   /**
    * Recursive method to parse individual value of a variable
    * and convert it into its PHP datatype equivalent
    *
    * @author Walter Torres <walter@torres.ws>
    *
    * @uses classmethod self::convertDataType()
    * @uses classmethod self::expandConstants()
    *
    * @access private
    * @static
    *
    * @param  string   $value   Value of name/value pair to convert
    * @return mixed    $value   Converted value
    *
    * @throws void
    *
    * @since 1.0
    *
    * @PHPUnit Not Defined
    */
    private static function parseValue(string $value)
    {
        // This only has to process if $value has anything
        //else
        if (isset($value{0})) {
            // Remove leading and trailing white space
            $value = \trim($value);

            // Anything inside curly braces [{}] is understood to be a constant
            if (\strpos($value, '{') !== false) {
                $value = self::expandConstants($value);
            }

            // COMMA means this needs to be a list
            if (\strpos($value, ',') !== false) {
                // FORWARD SLASH means leave as COMMA string
                if (\strpos($value, '/') === 0) {
                    $value = \preg_replace('{/}', '', $value);
                }

                // If $value contains a COMMA, than $value is really an array
                else if (\strpos($value, ',') !== false) {
                    // Split and trim at the same time!
                    /** @var array $value */
                    $value = \explode(',', $value);

                    foreach ($value as $i => $values) {
                        // convert booleans and nulls
                        $value[$i] = self::convertDataType($value[$i]);
                    }
                }
            }

        }

        return $value;
    }

   /**
    * Anything inside curly braces [{}] is understood to be a
    * CONSTANT and should be expanded as such
    *
    * @author Brian Gisseler <bgisseler@zacks.com>
    *
    * @access private
    * @static
    *
    * @param  string   $value   Value of name/value pair to convert
    * @return string   $value   expanded value
    *
    * @throws void
    *
    * @todo   we should log a warning when a config value reaches the recursion depth limit
    *
    * @since 1.0
    *
    * @PHPUnit Not Defined
    */
    private static function expandConstants(string $value) : string
    {
        $m = [];
        $offset = 0;
        $depth = 30; // our safety timer -- if this reaches 0, we abort further replacement

        // Loop through and perform replacements on constants
        while (--$depth && \preg_match('/(\{([^{}]*)\})/', $value, $m, PREG_OFFSET_CAPTURE, $offset) > 0) {
            // $m[1][0] == original key text with curly braces
            // $m[1][1] == offset of original key text with curly braces
            // $m[2][0] == key name (key text without curly braces)
            // $m[3][1] == offset of trailing char[s], if any

            // Reassign to CONSTANT value, if it exists
            if (\defined($m[2][0])) {
                $expanded = \constant($m[2][0]);
            }

            // if its assigned in the self::$conf['constants'] array, use that
            elseif (isset(self::$conf['constants'][$m[2][0]]{0})) {
                $expanded = self::$conf['constants'][$m[2][0]];

                // if our replacement matches our search key, skip past this due to recursion
                if ($expanded === $m[1][1]) {
                    $offset = $m[3][1];
                }
            }

            // if we can't resolve it, we skip it
            else
            {
                $expanded = $m[1][0];
                $offset = $m[3][1];
            }

            // rebuild string
            $value = \str_replace($m[1][0], $expanded, $value);

            // move on to the next entry...
        }

        if ($depth === 0) {
            //TODO: we should log a warning that this config value hit the recursion depth limit.
        }

        return $value;
    }

   /**
    * Converts individual value of a variable into its proper data type
    *
    * @author Walter Torres <walter@torres.ws>
    *
    * @access private
    * @static
    *
    * @param  string   $value   Value of name/value pair to convert
    * @return mixed    $value   Converted value
    *
    * @throws void
    *
    * @since 1.0
    *
    * @todo make this into a HELPER class
    *
    * @PHPUnit Not Defined
    */
    private static function convertDataType(string $value)
    {
        switch (\strtolower($value)) {
            case 't':
            case 'true':
                $value = true;
                break;

            case 'f':
            case 'false':
                $value = false;
                break;

            case 'null':
                $value = null;
                break;

            case ((string)(int)$value === $value):
                $value = (int)$value;
                break;

            case ((string)(float)$value === $value):
                $value = (float)$value;
                break;
        }

        return $value;
    }

   /**
    * Merge two arrays recursively overwriting the keys in the first array
    * if such key already exists
    *
    * @author lost reference from net
    *
    * @final
    * @access private
    * @static
    *
    * @param mixed $a Left array to merge right array into
    * @param mixed $b Right array to merge over the left array
    * @return mixed
    *
    * @throws void
    *
    * @since 1.0
    *
    * @todo make this into a HELPER class
    *
    * @PHPUnit Not Defined
    */
    final private static function arrayMergeRecursive($a, $b)
    {
        // merge arrays if both variables are arrays
        if (\is_array($a) && \is_array($b)) {
            // loop through each right array's entry and merge it into $a
            foreach ($b as $key => $value) {
                if (isset($a[$key])) {
                    $a[$key] = self::arrayMergeRecursive($a[$key], $value);
                } else {
                    if ($key === 0) {
                        $a= array(0 => self::arrayMergeRecursive($a, $value));
                    } else {
                        $a[$key] = $value;
                    }
                }
            }
        } else {
            // one of values is not an array
            $a = $b;
        }

        return $a;
    }

   /**
    * Remove temp subsections, if any
    *
    * @author Walter Torres <walter@torres.ws>
    *
    * @access private
    * @static
    *
    * @param void
    * @return void
    *
    * @throws void
    *
    * @since 1.0
    *
    * @PHPUnit Not Defined
    */
    private static function tempCleanup()
    {
        $keys = \array_keys(self::$result);

        foreach ($keys as $index => $key) {
            if (\strrpos($key, ':') !== false) {
                unset(self::$result[$key]);
            }
        }
    }
}

// eof
