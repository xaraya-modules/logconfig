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
use xarSecurity;
use xarVar;
use xarMod;
use xarSec;
use xarTpl;
use xarController;
use sys;
use BadParameterException;

sys::import('xaraya.modules.method');

/**
 * logconfig admin modifyconfig function
 * @extends MethodClass<AdminGui>
 */
class ModifyconfigMethod extends MethodClass
{
    /** functions imported by bermuda_cleanup */

    /**
     * Main configuration page for the logconfig module
     * @see AdminGui::modifyconfig()
     */
    public function __invoke(array $args = [])
    {
        // Security Check
        if (!$this->sec()->checkAccess('AdminLogconfig')) {
            return;
        }
        if (!$this->var()->find('phase', $phase, 'str:1:100', 'modify')) {
            return;
        }
        if (!$this->var()->find('tab', $data['tab'], 'str:1:100', 'general')) {
            return;
        }

        $data['module_settings'] = xarMod::apiFunc('base', 'admin', 'getmodulesettings', ['module' => 'logconfig']);
        $data['module_settings']->setFieldList('items_per_page, use_module_alias, module_alias_name, enable_short_urls');
        $data['module_settings']->getItem();

        switch (strtolower($phase)) {
            case 'modify':
            default:
                switch ($data['tab']) {
                    case 'general':
                        break;
                    case 'tab2':
                        break;
                    case 'tab3':
                        break;
                    default:
                        break;
                }

                break;

            case 'update':
                // Confirm authorisation code
                if (!$this->sec()->confirmAuthKey()) {
                    return;
                }
                switch ($data['tab']) {
                    case 'general':
                        /* Remove this for now
                            $isvalid = $data['module_settings']->checkInput();
                            if (!$isvalid) {
                                $data['context'] ??= $this->getContext();
                                return $this->mod()->template('modifyconfig', $data);
                            } else {
                                $itemid = $data['module_settings']->updateItem();
                            }
                        */
                        // The overall switch to enable logging
                        if (!$this->var()->find('logenabled', $logenabled, 'int', 0)) {
                            return;
                        }

                        // Update the config.system file
                        $variables = ['Log.Enabled' => $logenabled];
                        xarMod::apiFunc('installer', 'admin', 'modifysystemvars', ['variables' => $variables]);

                        $this->ctl()->redirect($this->mod()->getURL(
                            'admin',
                            'modifyconfig',
                            ['tab' => 'general']
                        ));
                        break;
                    case 'tab2':
                        break;
                    case 'tab3':
                        break;
                    default:
                        break;
                }

                $this->ctl()->redirect($this->mod()->getURL(
                    'admin',
                    'modifyconfig',
                    ['tab' => $data['tab']]
                ));
                // Return
                return true;
        }
        $data['authid'] = $this->sec()->genAuthKey();
        $data['read_sys'] = is_readable(sys::varpath() . '/config.system.php');
        $data['read_log'] = is_readable(sys::varpath() . '/logs/config.log.php');
        $data['write_sys'] = is_writeable(sys::varpath() . '/config.system.php');
        $data['write_log'] = is_writeable(sys::varpath() . '/logs/config.log.php');

        return $data;
    }
}
