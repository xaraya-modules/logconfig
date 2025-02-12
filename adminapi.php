<?php

/**
 * @package modules\logconfig
 * @category Xaraya Web Applications Framework
 * @version 2.5.7
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
**/

namespace Xaraya\Modules\Logconfig;

use Xaraya\Modules\AdminApiClass;
use sys;

sys::import('xaraya.modules.adminapi');

/**
 * Handle the logconfig admin API
 *
 * @method mixed chargeLoggerobject(array $args)
 * @method mixed dischargeLoggerobject(array $args)
 * @method mixed getLevels(array $args = [])
 * @method mixed getLoggers(array $args)
 * @method mixed getVariables(array $args)
 * @method mixed islogon(array $args = [])
 * @extends AdminApiClass<Module>
 */
class AdminApi extends AdminApiClass
{
    // ...
}
