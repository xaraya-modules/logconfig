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
 * logconfig adminapi discharge_loggerobject function
 * @extends MethodClass<AdminApi>
 */
class DischargeLoggerobjectMethod extends MethodClass
{
    /** functions imported by bermuda_cleanup */

    /**
     * Save the values of a logger object to the configuration files
     * @see AdminApi::dischargeLoggerobject()
     */
    public function __invoke(array $args = [])
    {
        /** @var AdminApi $adminapi */
        $adminapi = $this->adminapi();
        if (!isset($args['logger'])) {
            $this->exit($this->ml('No logger object passed'));
        }

        if (!xarLog::configReadable()) {
            $this->exit($this->ml('Cannot read the configuration file'));
        }

        // Load the configuration file
        require(xarLog::configFile());

        // This holds the values to be saved
        $to_be_saved = [];
        // Get the loggers variables and their values
        $variables = $args['logger']->getFieldValues([], 1);

        // Remove the state: we handle that separately
        $state = $variables['state'];
        unset($variables['state']);
        // Get the type
        $type = ucwords($variables['type']);
        // Get all the fields used by our loggers
        $fields = $adminapi->get_variables();

        // Run through each of the object's properties and get the values to be saved
        foreach ($variables as $variable => $value) {
            if (!isset($fields[$variable])) {
                continue;
            }
            $fieldname = $fields[$variable];
            $address = 'Log.' . $type . '.' . $fieldname;

            // If this variable exists in the configuration file, then add it to those to be saved
            if (isset($systemConfiguration[$address])) {
                $to_be_saved[$address] = $value;
            }
        }
        // Save the values to the configuration file
        $this->mod()->apiFunc('installer', 'admin', 'modifysystemvars', ['variables' => $to_be_saved, 'scope' => 'Log']);

        // Handle state property.

        // Get the available loggers
        $availables = xarLog::availables();
        if ($state == 1) {
            if (in_array($variables['type'], $availables)) {
                if (($key = array_search($variables['type'], $availables)) !== false) {
                    unset($availables[$key]);
                }
            }
        } elseif ($state == 3) {
            if (!in_array($variables['type'], $availables)) {
                array_push($availables, $variables['type']);
            }
        }
        $active_loggers['Log.Available'] = implode(',', $availables);
        // Save the values to the configuration file
        $this->mod()->apiFunc('installer', 'admin', 'modifysystemvars', ['variables' => $active_loggers, 'scope' => 'System']);
        return true;
    }
}
