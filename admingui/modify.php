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
use Xaraya\Modules\Logconfig\AdminApi;
use Xaraya\Modules\MethodClass;
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
     * @see AdminGui::modify()
     */
    public function __invoke(array $args = [])
    {
        /** @var AdminApi $adminapi */
        $adminapi = $this->adminapi();
        $this->var()->find('logger', $logger, 'str', '');
        $this->var()->find('confirm', $data['confirm'], 'checkbox', false);
        $this->var()->find('exit', $data['exit'], 'checkbox', false);

        if (empty($logger)) {
            $msg = $this->ml(
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
        $data['object'] = $this->data()->getObject(['name' => $objectname]);
        $data['object'] = $adminapi->charge_loggerobject(['logger' => $data['object']]);

        $data['tplmodule'] = 'logconfig';

        if ($data['confirm']) {
            // Check for a valid confirmation key
            if (!$this->sec()->confirmAuthKey()) {
                return;
            }

            // Get the data from the form
            $isvalid = $data['object']->checkInput();

            if (!$isvalid) {
                // Bad data: redisplay the form with error messages
                $data['context'] ??= $this->getContext();
                return $this->mod()->template('modify', $data);
            } else {
                // Good data: save the data
                $adminapi->discharge_loggerobject(['logger' => $data['object']]);

                if ($data['exit']) {
                    // Jump to the next page
                    $this->ctl()->redirect($this->mod()->getURL( 'admin', 'view'));
                    return true;
                }
            }
        }
        return $data;
    }
}
