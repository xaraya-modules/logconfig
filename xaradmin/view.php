<?php
/**
 * @package modules
 * @subpackage logconfig
 * @category Third Party Xaraya Module
 * @version 1.0.0
 * @copyright (C) 2002-2022 The Digital Development Foundation
 * @copyright (C) 2022 Luetolf-Carroll GmbH
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @author Logconfig module development team
 * @author Marc Lutolf <marc@luetolf-carroll.com>
 */
/**
 * View Loggers
 * This will show an overview page with the currently defined loggers.
 * @return array|void Data array for the template.
 */
function logconfig_admin_view(array $args = [], $context = null)
{
    // Security check - important to do this as early as possible to avoid
    // potential security holes or just too much wasted processing
    if (!xarSecurity::check('AdminLogConfig')) {
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
