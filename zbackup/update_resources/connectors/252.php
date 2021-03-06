<?php
namespace php_active_record;

/* connector for DiscoverLife ID keys
estimated execution time: 4.27 hours
*/

include_once(dirname(__FILE__) . "/../../config/environment.php");
$timestart = time_elapsed();

require_library('connectors/DiscoverLife_KeysAPI');

$resource_id = 252;
DiscoverLife_KeysAPI::get_all_taxa_keys($resource_id);

Functions::set_resource_status_to_force_harvest($resource_id);

$elapsed_time_sec = time_elapsed() - $timestart;
echo "\n";
echo "elapsed time = " . $elapsed_time_sec/60 . " minutes   \n";
echo "elapsed time = " . $elapsed_time_sec/60/60 . " hours \n";
echo "\n\n Done processing.";
?>