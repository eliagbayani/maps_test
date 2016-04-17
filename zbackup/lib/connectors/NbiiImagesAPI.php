<?php
namespace php_active_record;
/* connector: [679]
This is a one-time import of images from NBII. The site is no longer online but the images are still being hosted from the partner's server.
EOL was just given the time to download the images. The partner's server may not be online anymore soon.
*/
class NbiiImagesAPI
{
    function __construct($folder)
    {
        $this->taxa = array();
        $this->path_to_archive_directory = CONTENT_RESOURCE_LOCAL_PATH . '/' . $folder . '_working/';
        $this->archive_builder = new \eol_schema\ContentArchiveBuilder(array('directory_path' => $this->path_to_archive_directory));
        $this->resource_reference_ids = array();
        $this->resource_agent_ids = array();
        $this->vernacular_name_ids = array();
        $this->taxon_ids = array();
        $this->object_ids = array();
        $this->zip_path = "http://www1.usgs.gov/archive/images/all.xml.zip";
        $this->zip_path = "http://localhost/eol_php_code/update_resources/connectors/files/NBII/all.xml.zip";
        $this->eol_defined_image_path = "http://ubio.org/NBII_images/";
        $this->missing_filenames_text_file = DOC_ROOT . "update_resources/connectors/files/NBII/offline_filenames.txt";
        /* a copy of the file: https://dl.dropboxusercontent.com/u/7597512/NBII/offline_filenames.txt */
        $this->debug_archives = array();
        $this->debug_exists = 0;
        $this->debug_copied = 0;
        // for stats
        $this->copyrighted = 0;
        $this->resourceids = array();
    }

    function get_all_taxa($xml_file_path = FALSE)
    {
        $remove_temp_dir = FALSE;
        if(!$xml_file_path)
        {
            if(!self::load_zip_contents()) return FALSE;
            else $xml_file_path = $this->TEMP_FILE_PATH . "/all.xml";
            $remove_temp_dir = TRUE;
        }
        echo "\n xml_file_path: $xml_file_path \n";
        self::process_text_files($xml_file_path);
        $this->create_archive();
        if($remove_temp_dir)
        {
            $parts = pathinfo($xml_file_path);
            recursive_rmdir($parts["dirname"]);
            debug("\n temporary directory removed: " . $parts["dirname"]);
        }
        /* self::unzip_then_move_images_to_temp_folder(); // debug 1of2 -- utility */
        echo "\n\n copied: " . $this->debug_copied;
        echo "\n\n exists: " . $this->debug_exists;
        echo "\n\n copyrighted: " . $this->copyrighted;
    }

    private function process_text_files($file)
    {
        $missing_filenames = self::get_missing_filenames();
        /* $missing_filenames = array(); //debug 2of2 -- uncomment this only when debug 1of2 is uncommented as well */
        $xml = simplexml_load_file($file);
        foreach($xml->Image as $rec)
        {
            echo "\n" . $rec->Filename;
            if($taxon_id = $this->create_instances_from_taxon_object($rec))
            {
                if($missing_filenames)
                {
                    if(!in_array($rec->Filename, $missing_filenames)) self::get_images($taxon_id, $rec);
                    else echo " -- in missing filenames: " . $rec->Filename;
                }
                else self::get_images($taxon_id, $rec);
            }
        }
    }
    
    private function get_missing_filenames()
    {
        $filename = $this->missing_filenames_text_file; // this was generated by a utility function
        if(!($READ = fopen($filename, "r")))
        {
          debug(__CLASS__ .":". __LINE__ .": Couldn't open file: " . $filename);
          return;
        }
        $contents = fread($READ, filesize($filename));
        fclose($READ);
        $missing_filenames = json_decode($contents, true);
        echo "\n\n from text file (missing filenames): " . count($missing_filenames);
        return $missing_filenames;
    }

    private function get_images($taxon_id, $rec, $reference_ids = null, $agent_ids = null)
    {
        if(!$rec->Filename) return;
        $exclude = array("Animals_Birds_00787.jpg", "Animals_Crustaceans_00008.jpg", "Management_ParksProtectedAreas_OtherProtections_00026.jpg");
        if(in_array($rec->Filename, $exclude)) return;
        $mediaURL = trim($this->eol_defined_image_path . $rec->Filename);
        $description = "";
        if($rec->navigationalCategoryHierarchy) $description .= "<br>Category hierarchy: " . str_replace("|" , " | ", $rec->navigationalCategoryHierarchy);
        if($rec->description) $description .= "<br>Description: " . $rec->description;
        if($rec->captureDevice) $description .= "<br>Capture device: " . $rec->captureDevice;
        if($rec->captureDetails) $description .= "<br>Capture details: " . $rec->captureDetails;
        if($rec->dateOriginal) 
        {
            if(stripos($rec->dateOriginal, "null") === false) $description .= "<br>Original date: " . $rec->dateOriginal;
        }
        $locality = "";
        if($rec->Geo_latitude) $locality .= "Latitude: " . $rec->Geo_latitude;
        if($rec->Geo_longitude) $locality .= "; Longitude: " . $rec->Geo_longitude;
        if($locality) $description .= "<br><br>Locality: " . $locality;
        if($life_stage = self::get_lifestage($rec)) $description .= "<br><br>Life stage: " . $life_stage;
        // if($related_media = self::get_related_media($rec)) $description .= "<br><br>Related media: " . $related_media;
        $location_created = "";
        if($rec->Geo_description)    $location_created .= "Locality: " . $rec->Geo_description . ". ";
        if($rec->Geo_subprovince)    $location_created .= "Sub-province: " . $rec->Geo_subprovince . ". ";
        if($rec->Geo_stateProvince)  $location_created .= "State Province: " . $rec->Geo_stateProvince . ". ";
        if($rec->Geo_country)        $location_created .= "Country: " . $rec->Geo_country . ". ";
        if($rec->Geo_continentOcean) $location_created .= "Continent Ocean: " . $rec->Geo_continentOcean . ". ";
        $mr = new \eol_schema\MediaResource();
        if($reference_ids)  $mr->referenceID = implode("; ", $reference_ids);
        if($agent_ids)      $mr->agentID = implode("; ", $agent_ids);
        $mr->taxonID        = (string) $taxon_id;
        $mr->identifier     = (string) $rec->Filename;
        $mr->type           = "http://purl.org/dc/dcmitype/StillImage";
        $mr->language       = 'en';
        $mr->format         = Functions::get_mimetype($mediaURL);
        if($mr->format != "image/jpeg") echo "\n investigate: not jpg: $mediaURL [$mr->format] \n";
        $mr->title          = (string) $rec->title;
        $mr->CreateDate     = (string) $rec->dateOriginal;
        $mr->CVterm         = "";
        // $mr->rights         = "";
        $info = self::process_credit_line((string) $rec->creditLine);
        $mr->Owner          = $info["creditLine"];
        $mr->UsageTerms     = $info["license"];
        $mr->audience       = 'Everyone';
        $mr->description    = (string) $description;
        $mr->LocationCreated = (string) $location_created;
        $mr->accessURI      = $mediaURL;
        
        // for stats
        if(stripos($rec->originalFileName, "(c)") !== false) $this->copyrighted++;
        
        $resourceid = (string) $rec->resourceid;
        if(!in_array($resourceid, $this->resourceids)) $this->resourceids[] = $resourceid;
        else return;
        
        if(!in_array($mr->identifier, $this->object_ids))
        {
           $this->object_ids[] = $mr->identifier;
           $this->archive_builder->write_object_to_file($mr);
           // for stats
           $archiveName = (string) $rec->archiveName;
           if($archiveName) $this->debug_archives[$archiveName][] = (string) $rec->Filename;
        }
    }

    private function process_credit_line($creditLine)
    {
        // "filter the objects with "Public Domain" somewhere in that field, strip out the (c) and assign PD in the license field"
        if(stripos($creditLine, "Public Domain") === false)
        {
            $info["license"] = "http://creativecommons.org/licenses/by-nc-sa/3.0/";
            $info["creditLine"] = $creditLine;
        }
        else
        {
            $info["license"] = "http://creativecommons.org/licenses/publicdomain/";
            $info["creditLine"] = str_ireplace(array("©", "(c)", "copyright"), "", $creditLine);
        }
        return $info;
    }
    
    function save_before_site_goes_dark($xml_file_path = FALSE)
    {
        if(!$xml_file_path)
        {
            if(!self::load_zip_contents()) return FALSE;
            else $xml_file_path = $this->TEMP_FILE_PATH . "/all.xml";
        }
        echo "\n xml_file_path: $xml_file_path \n";
        $zip_files_to_download = self::get_what_zip_files_to_download($xml_file_path);
        set_time_limit(0);
        $paths[] = array("url"       => "http://www1.usgs.gov/archive/images/zip_files/",
                         "extension" => ".zip",
                         "temp_dir"  => "/Volumes/Time_Machine_Backups/dir_nbii_zip/",
                         "bracket"   => '\[   \]');
        $paths[] = array("url"       => "http://www1.usgs.gov/archive/images/xml_files/", 
                         "extension" => ".xml", 
                         "temp_dir"  => DOC_ROOT . "/public/tmp/dir_nbii_xml/",
                         "bracket"   => '\[TXT\]');
        $excluded_downloaded_already = array();
        foreach($paths as $path)
        {
            if($html = Functions::get_remote_file($path["url"], array('timeout' => 999999, 'download_attempts' => 5)))
            {
                if(preg_match_all("/" . $path["bracket"] . "\"><\/td><td><a href=\"(.*?)" . $path["extension"] . "\">/ims", $html, $arr))
                {
                    $temp_path = $path["temp_dir"];
                    echo("\n\n Temporary folder: " . $temp_path . "\n\n");
                    foreach($arr[1] as $filename)
                    {
                        $url = $path["url"] . $filename . $path["extension"];
                        $destination = $temp_path . $filename . $path["extension"];
                        if($path["url"] == "http://www1.usgs.gov/archive/images/zip_files/")
                        {
                            if(!in_array($filename.".zip", $zip_files_to_download)) 
                            {
                                echo "\n not to download: $filename.zip \n";
                                continue;
                            }
                        }
                        if(in_array($filename, $excluded_downloaded_already))
                        {
                            echo "\n -- $filename already downloaded \n";
                            continue;
                        }
                        else
                        {
                            if(!file_exists($destination))
                            {
                                echo "\n does not exist: $destination";
                                echo "\n -- $filename processing... \n";
                                self::save_big_file_to_local($url, $destination);
                            }
                        }
                    }
                }
                else echo "\n\n no pregmatch \n";
            }
        }
    }
    
    private function save_big_file_to_local($source, $destination) // utility
    {
        $timestart = time_elapsed();
        $handles = self::prepare_file_handles($source, $destination);
        $source_handle = $handles["source"];
        $destination_handle = $handles["destination"];
        $contents = '';
        $i = 0;
        while(!feof($source_handle))
        {
            $i++;
            echo "$i ";
            if($contents = fread($source_handle, 8192)) fwrite($destination_handle, $contents);
            else
            {
                echo "\n fread error \n";
                sleep(300); // sleep for 5 minutes
                fclose($source_handle);
                fclose($destination_handle);
                $handles = self::prepare_file_handles($source, $destination);
                $source_handle = $handles["source"];
                $destination_handle = $handles["destination"];
                $contents = '';
                $i = 0;
            }
        }
        fclose($source_handle);
        fclose($destination_handle);
        $elapsed_time_sec = time_elapsed() - $timestart;
        echo "\n\n";
        echo "elapsed time = " . $elapsed_time_sec/60 . " minutes \n";
        echo "elapsed time = " . $elapsed_time_sec/60/60 . " hours \n";
        echo "\nDone processing.\n";
    }

    private function prepare_file_handles($source, $destination)
    {
        sleep(20);
        // initialize destination file
        if(!($destination_handle = fopen($destination, "w")))
        {
          debug(__CLASS__ .":". __LINE__ .": Couldn't open file: " . $destination);
          return;
        }
        fclose($destination_handle);
        sleep(20);
        // prepares destination file for appends
        if(!($destination_handle = fopen($destination, "a")))
        {
          debug(__CLASS__ .":". __LINE__ .": Couldn't open file: " . $destination);
          return;
        }
        // opens source file
        if(!($source_handle = fopen($source, "rb")))
        {
          debug(__CLASS__ .":". __LINE__ .": Couldn't open file: " . $source);
          return;
        }
        sleep(20);
        return array("source" => $source_handle, "destination" => $destination_handle);
    }
    
    private function get_what_zip_files_to_download($file)
    {
        $xml = simplexml_load_file($file);
        $arr = array();
        foreach($xml->Image as $rec)
        {
            $archiveName = (string) $rec->archiveName;
            if(isset($rec->SpeciesData->SpeciesRecord->scientificName))
            {
                if(!$rec->Filename) continue;
                $arr[$archiveName] = 1;
            }
        }
        return array_keys($arr);
    }

    function create_instances_from_taxon_object($rec, $reference_ids = array())
    {
        $sciname = @$rec->SpeciesData->SpeciesRecord->scientificName;
        if(!$sciname) return;
        if(!$taxon_id = $rec->SpeciesData->SpeciesRecord->tsn) $taxon_id = str_ireplace(" ", "_", $sciname);
        $temp = explode(" ", $sciname);
        $genus = $temp[0];
        $taxon = new \eol_schema\Taxon();
        if($reference_ids) $taxon->referenceID = implode("; ", $reference_ids);
        $taxon->taxonID                     = (string) $taxon_id;
        $taxon->taxonRank                   = "species";
        $taxon->scientificName              = (string) $sciname;
        $taxon->genus                       = (string) $genus;
        $this->taxa[$taxon->taxonID] = $taxon;
        /* self::get_vernaculars($taxon_id, $rec);  -- working but now excluded for the meantime */
        return $taxon_id;
    }
    
    private function get_lifestage($rec)
    {
        $life_stage = "";
        if(!$rec->LifeStages->stage) return;
        foreach($rec->LifeStages->stage as $l)
        {
            if($life_stage) $life_stage .= ", " . $l->description;
            else $life_stage = $l->description;
        }
        if(in_array($life_stage, array("Animals", "Plants"))) return "";
        if($life_stage) return $life_stage;
    }
    
    private function get_related_media($rec)
    {
        /* <Attribute>
            <AttributeType>related media</AttributeType>
            <url1>http://life.nbii.gov/dml/mediadetail.do?id=6308</url1>
            <url2>http://images.nbii.gov/mosesso/nbii_jjmo_t00055.jpg</url2> */
        $urls = array();
        $records = array();
        $more_info = "";
        foreach($rec->Attributes->Attribute as $a)
        {
            if($a->AttributeType == "related media")
            {
                $info = "";
                if(!in_array($a->url1, $urls))
                {
                    if($a->url1) $info .= self::parse_related_media_url($a->url1, $info);
                    $urls[] = $a->url1;
                }
                if(!in_array($a->url2, $urls))
                {
                    if($a->url2) $info .= self::parse_related_media_url($a->url2, $info);
                    $urls[] = $a->url2;
                }
                if($info) $more_info .= "<br>$info";
            }
        }
        return $more_info;
    }
    
    private function parse_related_media_url($url, $info)
    {
        $path = pathinfo($url);
        return $info . "<a href='" . $url . "'>" . $path["dirname"] . "</a><br>";
    }
    
    private function get_vernaculars($taxon_id, $rec)
    {
        foreach($rec->Attributes->Attribute as $a)
        {
            if($a->AttributeType == "common name")
            {
                if($records = self::parse_common_name($a->description))
                {
                    foreach($records as $info)
                    {
                        $vernacular = new \eol_schema\VernacularName();
                        $vernacular->taxonID = $taxon_id;
                        $vernacular->vernacularName = $info["vernacular"];
                        $vernacular->language = $info["lang_code"];
                        $vernacular_id = md5("$vernacular->taxonID|$vernacular->vernacularName|$vernacular->language");
                        if(!$vernacular->vernacularName) continue;
                        if(!isset($this->vernacular_name_ids[$vernacular_id]))
                        {
                            $this->archive_builder->write_object_to_file($vernacular);
                            $this->vernacular_name_ids[$vernacular_id] = 1;
                        }
                    }
                }
            }
        }
    }

    private function parse_common_name($string)
    {
        // Eastern Bluebird [English]
        $records = array();
        $strings = explode(";", $string);
        foreach($strings as $string)
        {
            $parts = explode("[", $string);
            if($vernacular = trim($parts[0]))
            {
                $lang_code = self::get_language_code(trim(@$parts[1]));
                $records[] = array("vernacular" => $vernacular, "lang_code" => $lang_code);
            }
        }
        return $records;
    }
    
    private function get_language_code($lang)
    {
        $lang = trim(str_replace("]", "", $lang));
        switch ($lang) {
            case "English":
                return "en";
                break;
            case "Eng":
                return "en";
                break;
            case "Spanish":
                return "es";
                break;
            case "French":
                return "fr";
                break;
            default:
                if($lang) echo "\n investigate: language code not yet initialized [$lang]\n";
                return "en";
        }
    }
    
    function create_archive()
    {
        foreach($this->taxa as $t)
        {
            $this->archive_builder->write_object_to_file($t);
        }
        $this->archive_builder->finalize(TRUE);
    }

    function load_zip_contents()
    {
        $this->TEMP_FILE_PATH = create_temp_dir() . "/";
        if($file_contents = Functions::get_remote_file($this->zip_path, array('timeout' => 999999, 'download_attempts' => 5)))
        {
            $parts = pathinfo($this->zip_path);
            $temp_file_path = $this->TEMP_FILE_PATH . "/" . $parts["basename"];
            if(!($TMP = fopen($temp_file_path, "w")))
            {
              debug(__CLASS__ .":". __LINE__ .": Couldn't open file: " . $temp_file_path);
              return;
            }
            fwrite($TMP, $file_contents);
            fclose($TMP);
            $output = shell_exec("unzip $temp_file_path -d $this->TEMP_FILE_PATH");
            if(file_exists($this->TEMP_FILE_PATH . "/all.xml")) return TRUE;
            else return FALSE;
        }
        else
        {
            debug("\n\n Connector terminated. Remote files are not ready.\n\n");
            return FALSE;
        }
    }

    function unlink_files() // utility
    {
        $files = array(
        // "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_Insects.zip",
        //  "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_Mammals2.zip",
        //  "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_Mammals3.zip",
        //  "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_Mammals4.zip",
        //  "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_Mammals5.zip",
        //  "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_Mammals6.zip",
        //  "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_Mammals7.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_Reproduction_ParentalBehavior.zip",
         // "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_Reptiles.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_SignsStructuresEtc_AnimalProducts.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_SignsStructuresEtc_Structures.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_SignsStructuresEtc_Structures2.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_SignsStructuresEtc_TracksTrails.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Biomes_AridandDesertEnvironments.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Biomes_Forests_UnderstoriesForestFloor.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Biomes_Geology_RocksMinerals.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Biomes_MountainsMesas.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Biomes_TropicalEnvironments.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Biomes_UrbanEnvironments.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Biomes_VolcanicEnvironments.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Biomes_WaterWetlands_CoastalEnvironments3.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Biomes_WaterWetlands_InlandWaters.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Biomes_WaterWetlands_InlandWaters2.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Biomes_WaterWetlands_Oceans.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Biomes_WaterWetlands_PoolsPuddles.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/EnvironmentalTopics_HumanImpact_Agriculture.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/EnvironmentalTopics_HumanImpact_DevelopmentUrbanization.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/EnvironmentalTopics_HumanImpact_IntroducedSpecies.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/EnvironmentalTopics_InvasiveSpecies.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/EnvironmentalTopics_Pollinators.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/EnvironmentalTopics_ThreatenedEndangeredSpecies.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/EnvironmentalTopics_ThreatenedEndangeredSpecies2.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/InteractionsAmongSpecies_Pollination.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Management_ParksProtectedAreas_BotanicalGardensZoosEtc.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Management_ParksProtectedAreas_NatureReserves.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Management_ParksProtectedAreas_NatureReserves2.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Management_ParksProtectedAreas_NatureReserves3.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Management_ParksProtectedAreas_OtherProtections.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Management_WildlifeManagement.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Microorganisms_Microflora.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Microorganisms_Plankton.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Plants_AquaticPlants_Diatoms.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Plants_Herbs2.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Plants_PlantStructures_BranchesStemsLeaves.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Plants_PlantStructures_FlowersEtc.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Plants_PlantStructures_FlowersEtc4.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Plants_PlantStructures_FruitsNutsSeeds.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Plants_Trees_Magnolias.zip",
         "/Volumes/Time_Machine_Backups/dir_nbii_zip/Research.zip"
         // "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_Birds3.zip",
         // "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_Birds4.zip",
         // "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_Birds7.zip",
         // "/Volumes/Time_Machine_Backups/dir_nbii_zip/Animals_Birds8.zip"
         );
         foreach($files as $file) unlink($file);
    }

    private function unzip_then_move_images_to_temp_folder() // utility
    {
        echo "\n count: " . count($this->debug_archives);
        $i = 0;
        $source_dir  = "/Volumes/Time_Machine_Backups/dir_nbii_zip/";
        $target_dir  = "/Volumes/Time_Machine_Backups/dir_nbii_images/";
        $not_ok = array();
        $failed = array();
        $failed2 = array();
        $missing_filenames = array();
        foreach($this->debug_archives as $zip => $images)
        {
            $temp_dir = create_temp_dir() . "/";
            // $zip = "Animals_Amphibians_FrogsToads.zip"; //debug
            $zip_file = $source_dir . $zip;
            $parts = pathinfo($zip);
            echo "\n opening $zip_file ...";
            $output = shell_exec("unzip $zip_file -d $temp_dir");
            // $images[0] =  "Animals_Amphibians_FrogsToads_00035.jpg"; //debug
            foreach($images as $image)
            {
                $i++;
                $file = $temp_dir . $parts["filename"] . "/" . trim($image);
                $newfile = $target_dir . "" . $image;
                if(!file_exists($newfile))
                {
                    echo "\n $i. $newfile";
                    if(!copy($file, $newfile))
                    {
                        echo "\n failed to copy [$file] [$zip_file]...\n";
                        $failed[$zip_file] = 1;
                        $failed2[$zip_file][] = $file;
                        $missing_filenames[$image] = 1;
                    }
                    else $this->debug_copied++;
                }
                else $this->debug_exists++;
            }
            recursive_rmdir($temp_dir);
        }
        echo "\n\n not ok zip files: \n";
        print_r($not_ok);
        print_r($failed);
        print_r($failed2);
        if($missing_filenames)
        {
            if(!($WRITE = fopen($this->missing_filenames_text_file, "w")))
            {
              debug(__CLASS__ .":". __LINE__ .": Couldn't open file: " . $this->missing_filenames_text_file);
              return;
            }
            $missing_filenames = array_keys($missing_filenames);
            echo "\n\n count missing filenames: " . count($missing_filenames);
            fwrite($WRITE, json_encode($missing_filenames));
            fclose($WRITE);
        }
    }

}
?>
