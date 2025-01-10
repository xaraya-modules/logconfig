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

use Xaraya\Modules\MethodClass;
use sys;
use BadParameterException;

sys::import('xaraya.modules.method');

/**
 * logconfig adminapi get_variables function
 */
class GetVariablesMethod extends MethodClass
{
    /** functions imported by bermuda_cleanup */

    /**
     * A central registry of all the variables our loggers use
     * The keys are the logger object properties, the values are the corresponding fields in the configuration file
     */
    public function __invoke(array $args = [])
    {
        $vars = [
            'filename'    => 'Filename',
            'maxfilesize' => 'MaxFileSize',
            'loglevel'    => 'Level',
            'mode'        => 'Mode',
            'recipient'   => 'Recipient',
            'sender'      => 'Sender',
            'subject'     => 'Subject',
            'timeformat'  => 'Timeformat',
            'sqltable'    => 'SQLTable',
            'facility'    => 'Facility',
            'options'     => 'Options',
            'sqltable'    => 'SQLTable',
        ];

        return $vars;
    }
}
