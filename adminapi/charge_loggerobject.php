<?php

/**
 * @package modules\logconfig
 * @category Xaraya Web Applications Framework
 * @version 2.5.7
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
**/

namespace Xaraya\Modules\Logconfig\AdminApi;

use Xaraya\Modules\Logconfig\AdminApi;
use Xaraya\Modules\MethodClass;
use xarLog;

/**
 * logconfig adminapi charge_loggerobject function
 * @extends MethodClass<AdminApi>
 */
class ChargeLoggerobjectMethod extends MethodClass
{
    /** functions imported by bermuda_cleanup */

    /**
     * Get the saved values and insert them into an object
     * @see AdminApi::chargeLoggerobject()
     */
    public function __invoke(array $args = [])
    {
        /** @var AdminApi $adminapi */
        $adminapi = $this->adminapi();
        if (!xarLog::configReadable()) {
            $this->exit($this->ml('Cannot read the configuration file'));
        }
        if (!isset($args['logger'])) {
            $this->exit($this->ml('No logger object passed'));
        }

        // Get the $systemConfiguration array from the configuration file
        require(xarLog::configFile());

        // Get the available loggers
        $availables = xarLog::availables();

        // Get all the fields used by our loggers
        $fields = $adminapi->get_variables();

        // Get the type of this logger
        $loggertype = $args['logger']->properties['type']->value;

        // Get this logger's property names
        $propertynames = array_keys($args['logger']->properties);

        // Run through each of the logger object's properties and get the saved value
        $values = [];
        foreach ($propertynames as $propertyname) {
            if ($propertyname == 'state') {
                // The state is different. It corresponds to whether or not the logger is in the list of available loggers
                if (in_array($loggertype, $availables)) {
                    $value = 3;
                } else {
                    $value = 1;
                }
            } else {
                $type = ucwords($loggertype);
                if (!isset($fields[$propertyname])) {
                    continue;
                }
                $variable = $fields[$propertyname];

                // The full address of how variables are stored in the $systemConfiguration array, e.g. Log.Simple.Filename
                $address = 'Log.' . $type . '.' . $variable;

                if (isset($systemConfiguration[$address])) {
                    $value = $systemConfiguration[$address];
                } else {
                    $value = null;
                }
            }
            // If the value != null, add it to the values to be loaded into the logger object
            if (null != $value) {
                $values[$propertyname] = $value;
            }
        }
        // Load the values into the logger object
        $args['logger']->setFieldValues($values, 1);
        return $args['logger'];
    }
}
