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

use Xaraya\Modules\MethodClass;
use xarSecurity;
use sys;
use BadParameterException;

sys::import('xaraya.modules.method');

/**
 * logconfig admin main function
 */
class MainMethod extends MethodClass
{
    /** functions imported by bermuda_cleanup */

    /**
     * the main administration function
     */
    public function __invoke(array $args = [])
    {
        if (!xarSecurity::check('ManageLogConfig')) {
            return;
        }

        // Return the template variables defined in this function
        return [];
    }
}