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
use xarVar;
use xarMod;
use xarSec;
use xarTpl;
use xarController;
use DataObjectFactory;
use sys;
use BadParameterException;

sys::import('xaraya.modules.method');

/**
 * logconfig admin modify function
 * @extends MethodClass<AdminGui>
 */
class ModifyMethod extends MethodClass
{
    /** functions imported by bermuda_cleanup */

    /**
     * Configure a logger
     */
    public function __invoke(array $args = [])
    {
        if (!$this->fetch('logger', 'str', $logger, '', xarVar::NOT_REQUIRED)) {
            return;
        }
        if (!$this->fetch('confirm', 'checkbox', $data['confirm'], false, xarVar::NOT_REQUIRED)) {
            return;
        }
        if (!$this->fetch('exit', 'checkbox', $data['exit'], false, xarVar::NOT_REQUIRED)) {
            return;
        }

        if (empty($logger)) {
            $msg = $this->translate(
                'Invalid #(1) for #(2) function #(3)() in module #(4)',
                'item id',
                'admin',
                'modify',
                'logconfig'
            );
            throw new BadParameterException(null, $msg);
        }

        sys::import('modules.dynamicdata.class.objects.base');
        $objectname = 'logconfig_' . $logger;
        $data['object'] = DataObjectFactory::getObject(['name' => $objectname]);
        $data['object'] = xarMod::apiFunc('logconfig', 'admin', 'charge_loggerobject', ['logger' => $data['object']]);

        $data['tplmodule'] = 'logconfig';

        if ($data['confirm']) {
            // Check for a valid confirmation key
            if (!$this->confirmAuthKey()) {
                return;
            }

            // Get the data from the form
            $isvalid = $data['object']->checkInput();

            if (!$isvalid) {
                // Bad data: redisplay the form with error messages
                $data['context'] ??= $this->getContext();
                return xarTpl::module('logconfig', 'admin', 'modify', $data);
            } else {
                // Good data: save the data
                xarMod::apiFunc('logconfig', 'admin', 'discharge_loggerobject', ['logger' => $data['object']]);

                if ($data['exit']) {
                    // Jump to the next page
                    $this->redirect($this->getUrl( 'admin', 'view'));
                    return true;
                }
            }
        }
        return $data;
    }
}
