<?php
namespace php_active_record;
/* DATA-1626
                        Jul-14
measurement_or_fact.tab [18948]
occurrence.tab          [18877]
taxon.tab               [7044]
*/
include_once(dirname(__FILE__) . "/../../config/environment.php");
require_library('connectors/AmphibiawebDataAPI');
$timestart = time_elapsed();
$resource_id = 959;
$func = new AmphibiawebDataAPI($resource_id);
$func->get_all_taxa();
Functions::finalize_dwca_resource($resource_id);
$elapsed_time_sec = time_elapsed() - $timestart;
echo "\n\n";
echo "\n elapsed time = " . $elapsed_time_sec/60 . " minutes";
echo "\n elapsed time = " . $elapsed_time_sec/60/60 . " hours";
echo "\n Done processing.\n";
?>