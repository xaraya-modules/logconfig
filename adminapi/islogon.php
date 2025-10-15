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
use xarSystemVars;
use xarLog;
use sys;

sys::import('xaraya.modules.method');

/**
 * logconfig adminapi islogon function
 * @extends MethodClass<AdminApi>
 */
class IslogonMethod extends MethodClass
{
    /** functions imported by bermuda_cleanup */

    /**
     * Is log currently on?
     * @see AdminApi::islogon()
     */
    public function __invoke(array $args = [])
    {
        $logon = xarSystemVars::get(sys::CONFIG, 'Log.Enabled') && xarLog::configReadable();
        return $logon;
    }
}
