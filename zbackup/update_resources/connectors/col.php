<?php
namespace php_active_record;
include_once(dirname(__FILE__) . "/../../config/environment.php");
require_library('connectors/NCBIConnector');

$resource_id = 999;
$ncbi = new CatalogueOfLifeConnector($resource_id);
$ncbi->build_archive();
Functions::set_resource_status_to_force_harvest($resource_id);

?>