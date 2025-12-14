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

/**
 * logconfig admin overview function
 * @extends MethodClass<AdminGui>
 */
class OverviewMethod extends MethodClass
{
    /** functions imported by bermuda_cleanup */

    /**
     * the main administration function
     * This function will show the overview page with information on this module.
     * @return array|string|void
     * @see AdminGui::overview()
     */
    public function __invoke(array $args = [])
    {
        if (!$this->sec()->checkAccess('AdminLogConfig')) {
            return;
        }

        $data = [];

        return $this->render('main', $data);
    }
}
