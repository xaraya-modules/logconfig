<?php

/**
 * Turn logging off 
 */
function logconfig_adminapi_turnoff ()
{
    $filename = xarModAPIFunc('logconfig','admin','filename');
    
    if (file_exists($filename)) {
        //Turn off

        //In a busy site, this might be dificult to delete.
        $time = time();
        while (!unlink($filename) && ( ($time-time()) < 3) ) {}

         if (file_exists($filename)) {
            $msg = xarML('Unable to delete file (#(1))', $filename);
            xarErrorSet(XAR_SYSTEM_MESSAGE, 'UNABLE_DELETE_FILE', $msg);
            return;
         }
    }
    
    return true;
}

?>