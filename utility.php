<?php
/* utility for logging */
if (!function_exists('debug_log')) {

    function debug_log($log) {
        $filename = realpath(dirname(__FILE__)).'/'.EEP_DEBUG_FILE;
        if (true === EEP_DEBUG) {
	    
            $size = filesize($filename);
            if($size > EEP_DEBUG_MAX_FILE_SIZE){
                $file = fopen($filename, "a+");
                ftruncate($file,100);
                fclose($file);
            }
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true),3,$filename);
            } else {
                error_log($log."\n",3,$filename);
            }
        }
    }
}
?>
