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
use sys;
use BadParameterException;

sys::import('xaraya.modules.method');

/**
 * logconfig adminapi get_loggers function
 * @extends MethodClass<AdminApi>
 */
class GetLoggersMethod extends MethodClass
{
    /** functions imported by bermuda_cleanup */

    /**
     * A central registry of all our loggers
     */
    public function __invoke(array $args = [])
    {
        $loggers = [
            ['id' => 'error_log',   'name' => 'Error Log',      'object' => 'logconfig_errorlog'],
            ['id' => 'html',        'name' => 'HTML',           'object' => 'logconfig_html'],
            ['id' => 'javascript',  'name' => 'Javascript Log', 'object' => 'logconfig_javascript'],
            ['id' => 'mail',        'name' => 'Mail',           'object' => 'logconfig_mail'],
            ['id' => 'mozilla',     'name' => 'Mozilla',        'object' => 'logconfig_mozilla'],
            ['id' => 'simple',      'name' => 'Simple',         'object' => 'logconfig_simple'],
            ['id' => 'sql',         'name' => 'SQL',            'object' => 'logconfig_sql'],
            ['id' => 'syslog',      'name' => 'System Log',     'object' => 'logconfig_syslog'],
        ];

        return $loggers;
    }
}
