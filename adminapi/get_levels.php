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
use xarLogger;

/**
 * logconfig adminapi get_levels function
 * @extends MethodClass<AdminApi>
 */
class GetLevelsMethod extends MethodClass
{
    /** functions imported by bermuda_cleanup */

    /**
     * Gets the log levels Xaraya recognizes
     * @see AdminApi::getLevels()
     */
    public function __invoke(array $args = [])
    {
        $levels = xarLogger::$levels;

        return $levels;
    }
}
