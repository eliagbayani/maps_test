<?php
namespace php_active_record;
/**/
include_once(dirname(__FILE__) . "/../../config/environment.php");
$timestart = time_elapsed();





$elapsed_time_sec = time_elapsed() - $timestart;
echo "\n\nelapsed time = " . $elapsed_time_sec/60 . " minutes \n";
echo "elapsed time = " . $elapsed_time_sec/60/60 . " hours \n";
?>