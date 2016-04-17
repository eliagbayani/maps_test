<?php
namespace php_active_record;
/* This will contain functions to diagnose EOL DWC-A files */
class DWCADiagnoseAPI
{
    function __construct()
    {
        $this->file['taxon']             = "http://rs.tdwg.org/dwc/terms/taxonID";
        $this->file['occurrence']        = "http://rs.tdwg.org/dwc/terms/occurrenceID";
        $this->file['reference']         = "http://purl.org/dc/terms/identifier";
        $this->file['document']          = "http://purl.org/dc/terms/identifier";
        $this->file['agent']             = "http://purl.org/dc/terms/identifier";
        $this->file['vernacularname']    = "http://rs.tdwg.org/dwc/terms/vernacularName";
        $this->file['measurementorfact'] = "http://rs.tdwg.org/dwc/terms/measurementID";
    }

    function check_unique_ids($resource_id, $file_extension = ".tab")
    {
        $harvester = new ContentArchiveReader(NULL, CONTENT_RESOURCE_LOCAL_PATH . $resource_id . "/");
        $tables = $harvester->tables;
        $tables = array_keys($tables);
        // $tables = array_diff($tables, array("http://rs.tdwg.org/dwc/terms/measurementorfact")); //exclude measurementorfact
        $tables = array_diff($tables, array("http://rs.gbif.org/terms/1.0/vernacularname")); //exclude vernacular name
        print_r($tables);
        foreach($tables as $table) self::process_fields($harvester->process_row_type($table), pathinfo($table, PATHINFO_BASENAME));
    }

    private function process_fields($records, $class)
    {
        $temp_ids = array();
        echo "\n[$class]";
        foreach($records as $rec)
        {
            $keys = array_keys($rec);
            if(!($field_index_key = @$this->file[$class]))
            {
                echo "\nnot yet defined [$class]\n";
                print_r($keys);
                print_r($rec);
                return false;
            }

            if(!isset($temp_ids[$rec[$field_index_key]])) $temp_ids[$rec[$field_index_key]] = '';
            else
            {
                if($val = $rec[$field_index_key])
                {
                    // echo "{$val} ";
                    echo "\n -- not unique ID in [$class] - {" . $rec[$field_index_key] . "} - [$field_index_key]" . "";
                    // return false;
                    
                }
            }
            
        }
        echo "\n -- OK\n";
        return true;
    }

    function cannot_delete() // a utility
    {
        $final = array();
        foreach(new FileIterator(DOC_ROOT . "/public/tmp/cant_delete.txt") as $line => $r) $final[pathinfo($r, PATHINFO_DIRNAME)] = '';
        $final = array_keys($final);
        asort($final);
        foreach($final as $e) echo "\n $e";
        echo "\n";
    }

    function get_undefined_uris() // a utility
    {
        $ids = array("872", "886", "887", "892", "893", "894", "885", "42");
        foreach($ids as $id)
        {
            echo "\nprocessing id [$id]";
            if($undefined_uris = Functions::get_undefined_uris_from_resource($id)) print_r($undefined_uris);
            echo "\nundefined uris: " . count($undefined_uris) . "\n";
        }
    }

}
?>
