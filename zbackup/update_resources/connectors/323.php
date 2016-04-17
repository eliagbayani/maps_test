<?php
namespace php_active_record;
/* connector for YouTube 
estimated execution time: 1 minute. But this will change as the number of EOL YouTube subscriptions increase.

2015-05-30
taxon 		= 497
commonName 	= 16
videos 		= 497

*/

// setting a 2 second wait time because we were getting yt:quota, too_many_recent_calls errors
define('DOWNLOAD_WAIT_TIME', 2000000);
include_once(dirname(__FILE__) . "/../../config/environment.php");
$timestart = time_elapsed();
require_library('connectors/YouTubeAPI');
$resource_id = 323;
if(!Functions::can_this_connector_run($resource_id)) return;

$func = new YouTubeAPI();
$taxa = $func->get_all_taxa();
$xml = \SchemaDocument::get_taxon_xml($taxa);

$resource_path = CONTENT_RESOURCE_LOCAL_PATH . $resource_id . ".xml";
if(!($OUT = Functions::file_open($resource_path, "w"))) return;
fwrite($OUT, $xml);
fclose($OUT);

Functions::set_resource_status_to_force_harvest($resource_id);
Functions::gzip_resource_xml($resource_id);

$elapsed_time_sec = time_elapsed() - $timestart;
echo "\n";
echo "elapsed time = $elapsed_time_sec seconds              \n";
echo "elapsed time = " . $elapsed_time_sec/60 . " minutes   \n";
echo "\n\n Done processing.";
?>