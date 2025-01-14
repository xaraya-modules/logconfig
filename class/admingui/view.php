<?php

/**
 * @package modules\logconfig
 * @category Xaraya Web Applications Framework
 * @version 2.5.7
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
**/

namespace Xaraya\Modules\Logconfig\AdminGui;


use Xaraya\Modules\Logconfig\AdminGui;
use Xaraya\Modules\MethodClass;
use xarSecurity;
use xarMod;
use xarLog;
use DataObjectFactory;
use sys;
use BadParameterException;

sys::import('xaraya.modules.method');

/**
 * logconfig admin view function
 * @extends MethodClass<AdminGui>
 */
class ViewMethod extends MethodClass
{
    /** functions imported by bermuda_cleanup */

    /**
     * View Loggers
     * This will show an overview page with the currently defined loggers.
     * @return array|void Data array for the template.
     */
    public function __invoke(array $args = [])
    {
        // Security check - important to do this as early as possible to avoid
        // potential security holes or just too much wasted processing
        if (!$this->checkAccess('AdminLogConfig')) {
            return;
        }

        // Whether or not the fallback logger is running
        if (xarMod::apiFunc('logconfig', 'admin', 'islogon') && xarLog::fallbackPossible() && empty(xarLog::availables())) {
            $data['fallbackOn'] = true;
        } else {
            $data['fallbackOn'] = false;
        }

        // The name of the file the fallback logger writes to
        $data['fallbackFile'] = xarLog::FallbackFile();

        // The defined loggers
        $definitions = xarMod::apiFunc('logconfig', 'admin', 'get_loggers');

        sys::import('modules.dynamicdata.class.objects.base');
        foreach ($definitions as $logger) {
            $data['loggers'][$logger['id']] = DataObjectFactory::getObject(['name' => $logger['object']]);
            $data['loggers'][$logger['id']] = xarMod::apiFunc('logconfig', 'admin', 'charge_loggerobject', ['logger' => $data['loggers'][$logger['id']]]);
        }
        $data['read_sys'] = is_readable(sys::varpath() . '/config.system.php');
        $data['read_log'] = is_readable(sys::varpath() . '/logs/config.log.php');
        $data['write_sys'] = is_writeable(sys::varpath() . '/config.system.php');
        $data['write_log'] = is_writeable(sys::varpath() . '/logs/config.log.php');
        return $data;
    }
}
