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

namespace Xaraya\Modules\Logconfig;

class Version
{
    /**
     * Get module version information
     *
     * @return array<string, mixed>
     */
    public function __invoke(): array
    {
        return [
            'name' => 'Log Configuration Module',
            'id' => '6969',
            'version' => '1.0.0',
            'displayname' => 'LogConfig',
            'description' => 'Module for Configuration the Logging System',
            'credits' => 'xardocs/credits.txt',
            'help' => 'xardocs/help.txt',
            'changelog' => 'xardocs/changelog.txt',
            'license' => 'xardocs/license.txt',
            'official' => 1,
            'author' => 'nuncanada',
            'contact' => 'http://www.xaraya.com/',
            'admin' => 1,
            'user' => 0,
            'class' => 'Admin',
            'category' => 'System',
            'dependency'
             => [
             ],
            'namespace' => 'Xaraya\\Modules\\Logconfig',
            'twigtemplates' => true,
            'dependencyinfo'
             => [
                 0
                  => [
                      'name' => 'Xaraya Core',
                      'version_ge' => '2.4.1',
                  ],
             ],
        ];
    }
}
