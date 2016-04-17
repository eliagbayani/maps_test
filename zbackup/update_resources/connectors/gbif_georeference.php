<?php
namespace php_active_record;
/* */
include_once(dirname(__FILE__) . "/../../config/environment.php");
require_library('connectors/GBIFoccurrenceAPI');
$timestart = time_elapsed();
$resource_id = 1;

/*
echo "\n123456 = [" . (123456 % 100)."]";
echo "\n123406 = [" . (123406 % 100)."]";
echo "\n123400 = [" . (123400 % 100)."]";
exit("\n");
*/

$func = new GBIFoccurrenceAPI($resource_id);
$func->start();
$elapsed_time_sec = time_elapsed() - $timestart;
echo "\n\n";
echo "\n elapsed time = " . $elapsed_time_sec/60 . " minutes";
echo "\n elapsed time = " . $elapsed_time_sec/60/60 . " hours";
echo "\n Done processing.\n";

?>
