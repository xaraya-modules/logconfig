<?php

/**
 * Handle module installer functions
 *
 * @package modules\logconfig
 * @category Xaraya Web Applications Framework
 * @version 2.5.7
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
**/

namespace Xaraya\Modules\Logconfig;

use Xaraya\Modules\InstallerClass;
use xarMod;
use xarMasks;
use PropertyRegistration;
use sys;

sys::import('xaraya.modules.installer');

/**
 * Handle module installer functions
 *
 * @todo add extra use ...; statements above as needed
 * @todo replaced logconfig_*() function calls with $this->*() calls
 */
class Installer extends InstallerClass
{
    /**
     * Configure this module - override this method
     *
     * @todo use this instead of init() etc. for standard installation
     * @return void
     */
    public function configure()
    {
        $this->objects = [
            // add your DD objects here
            //'logconfig_object',
        ];
        $this->variables = [
            // add your module variables here
            'hello' => 'world',
        ];
        $this->oldversion = '2.4.1';
    }

    /** xarinit.php functions imported by bermuda_cleanup */

    /**
     * initialise the logconfig module
     * This function is only ever called once during the lifetime of a particular
     * module instance
     * @return bool|void true on success
     */
    public function init()
    {
        # --------------------------------------------------------
        #
        # Create DD objects
        #
        PropertyRegistration::importPropertyTypes(false, ['modules/logconfig/xarproperties']);

        $module = 'logconfig';
        $objects = [
            'logconfig_errorlog',
            'logconfig_html',
            'logconfig_javascript',
            'logconfig_mail',
            'logconfig_mozilla',
            'logconfig_simple',
            'logconfig_sql',
            'logconfig_syslog',
        ];
        if (!xarMod::apiFunc('modules', 'admin', 'standardinstall', ['module' => $module, 'objects' => $objects])) {
            return;
        }

        xarMasks::register('ManageLogConfig', 'All', 'logconfig', 'Item', 'All', 'ACCESS_DELETE');
        xarMasks::register('AdminLogConfig', 'All', 'logconfig', 'Item', 'All', 'ACCESS_ADMIN');

        // Initialisation successful
        return $this->upgrade('0.1.1');
    }

    /**
     * upgrade the logconfig module from an old version
     * This function can be called multiple times
     * @param string oldversion
     * @return bool true on success
     */
    public function upgrade($oldversion)
    {
        // Upgrade dependent on old version number
        switch ($oldversion) {
            case '0.1.0':
                $logConfigFile = sys::varpath() . '/cache/config.log.php';
                if (file_exists($logConfigFile)) {
                    unlink($logConfigFile);
                }
                //When people turn it on again it will produce the config in the
                //new directory, no need to do it in here.
                // no break
            case '0.1.1':
                break;
        }

        // Update successful
        return true;
    }

    /**
     * delete the logconfig module
     * This function is only ever called once during the lifetime of a particular
     * module instance
     * @return bool true on success
     */
    public function delete()
    {
        $module = 'logconfig';
        return xarMod::apiFunc('modules', 'admin', 'standarddeinstall', ['module' => $module]);
    }
}
