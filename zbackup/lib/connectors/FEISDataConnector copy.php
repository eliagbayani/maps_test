<?php
namespace php_active_record;
/* connector: [750]
DATA-1413 FEIS structured data 
The FEIS portal export features provide 12 csv files: http://www.feis-crs.org/beta/faces/SearchByOther.xhtml
This connector parses the csv files, gets the invasiveness, nativity and life_form info and other metadata and generates the EOL archive file.
*/

trying to automate but no success yet... http://localhost/~eolit/ReviewResults.html

class FEISDataConnector
{
    function __construct($folder)
    {
        $this->taxa = array();
        $this->path_to_archive_directory = CONTENT_RESOURCE_LOCAL_PATH . '/' . $folder . '_working/';
        $this->archive_builder = new \eol_schema\ContentArchiveBuilder(array('directory_path' => $this->path_to_archive_directory));
        $this->occurrence_ids = array();
        $this->debug = array();
        $this->export_basenames = array("Invasive"      => "http://eol.org/schema/terms/InvasiveRange",
                                        "Noninvasive"   => "http://eol.org/schema/terms/NonInvasiveRange",
                                        "Native"        => "http://eol.org/schema/terms/NativeRange",
                                        "Nonnative"     => "http://eol.org/schema/terms/IntroducedRange",
                                        "Vine"          => "http://eol.org/schema/terms/vine",
                                        "Tree"          => "http://eol.org/schema/terms/tree",
                                        "Shrub"         => "http://eol.org/schema/terms/shrub",
                                        "Graminoid"     => "http://eol.org/schema/terms/graminoid",
                                        "Forb"          => "http://eol.org/schema/terms/forbHerb",
                                        "Fern"          => "http://eol.org/schema/terms/forbHerb",
                                        "Bryophyte"     => "http://eol.org/schema/terms/nonvascular"
                                        ); // "Cactus" is excluded (DATA-1413)


// <input type="radio" name="SelectNativity" id="SelectNativity:0" value="1" /><label for="SelectNativity:0"> Native</label></td>
// <input type="radio" name="SelectNativity" id="SelectNativity:1" value="2" /><label for="SelectNativity:1"> Nonnative</label></td>
// 
// <input type="radio" name="SelectInvasiveness" id="SelectInvasiveness:0" value="1" /><label for="SelectInvasiveness:0"> Invasive</label></td>
// <input type="radio" name="SelectInvasiveness" id="SelectInvasiveness:1" value="2" /><label for="SelectInvasiveness:1"> Noninvasive</label></td>
// 
// <input name="selectedPlants" id="selectedPlants:0" value="12" type="checkbox" /><label for="selectedPlants:0" class=""> Bryophyte</label></td>
// <input name="selectedPlants" id="selectedPlants:1" value="13" type="checkbox" /><label for="selectedPlants:1" class=""> Cactus</label></td>
// <input name="selectedPlants" id="selectedPlants:2" value="11" type="checkbox" /><label for="selectedPlants:2" class=""> Fern or Fern Ally</label></td>
// <input name="selectedPlants" id="selectedPlants:3" value="6" type="checkbox" /><label for="selectedPlants:3" class=""> Forb</label></td>
// <input name="selectedPlants" id="selectedPlants:4" value="5" type="checkbox" /><label for="selectedPlants:4" class=""> Graminoid</label></td>
// <input name="selectedPlants" id="selectedPlants:5" value="2" type="checkbox" /><label for="selectedPlants:5" class=""> Shrub</label></td>
// <input name="selectedPlants" id="selectedPlants:6" value="1" type="checkbox" /><label for="selectedPlants:6" class=""> Tree</label></td>
// <input name="selectedPlants" id="selectedPlants:7" value="10" type="checkbox" /><label for="selectedPlants:7" class=""> Vine or liana</label></td>

// http://www.feis-crs.org/beta/faces/SearchByOther.xhtml?frmSearchByOther=frmSearchByOther&btnSearch=Search&j_idt25=on&selectedPlants=12&javax.faces.ViewState=H4sIAAAAAAAAAK1YT2zbVBh%2FTduNlmka61pWQaaudEOTgts0aZNqTDTbWhqRtlnThbU7dK%2F2a%2BLWsb3n58TZWDWEuIAQSBwQ0hAHLjvAaaddQGhCSJM2xKQJiYkDEhLiAJoQHIAL79mJnT9267TzwX21v8%2Fv9%2F2%2B3%2Fu%2Br%2F38d9Cpahg8sw6LkNOJKHEzUMvPQrVz749f3%2Bm79H07CEyDbkmBwjTkiYKToIvkMdLyiiQY6iuTgF0jpafona2DBOxdXxEFEonpGPRcTJkflqCc4%2BZX1xFPTn5w%2F8KnB7QTUgAAQ6UeHSq9bK8R%2FTLYBO2Nz%2BORxufdBUmRcyLRBeTuEhlrfL5fQxJFgIQ0xUM0d7dYjZu9CtirTnvV5rylBL7EKwVO02VuDfJIM%2B8SIhqHJG4R5mYRySvClKFS4jRRkYF1te2jHGDQzzgymGmj3eXUs08vv%2F%2Fz44Bp12PbORafvf1O5s%2FlBy%2BbbFIcgwrOcVCFfB65fTBZUKXkP%2FCRFH7jKNuchdBXOgaOvnBVQxDz%2BdMIyhzMIZkvZ0y2zuRp7pBwDYDGfGYIFuXcyS8eZH%2F9LXj11Wo%2B2wgYtIBaVKAikgmXhZKOrG9NsQeqapSyYHE4Y%2B1anid5hDkjTwrSwGQ4OhGKTQwUHZ%2BUqBEkI3xqcFugg4bGouovRfxEtd%2BJJ6uIgpnT51huKEC1chHQVZAg2UJrY9EdiIateitYGzMgykWoiZQomraaDFTRtbFFcGsOR%2BKhWNwHh25beXLoissfh5XjFX%2FCTGGUo7pu0morTI3F%2FanNbStPplxx%2BWOq1%2FKiRdjCuwAFUW8qVwctq2RNRjzEObFLygfA83Wh5ZCSwAhuyfY5MO%2FB9uhIKBbxwXbDLjbR3DZoWlHjRHOPsFido8e9KJKyO6PR3Yr4KAjWxSBXttsZpRPRUCzqg9HGXWxKh7eD44%2FTPZbc3BhRafM4dNFlGjj81X%2BZXzYe3bW7h%2BNdxGCouZGkFY0kBGFRyYqoZLaSx%2B%2Fe%2FuaHA7duW03yeLPLGaWgKjJdZcqUl4Lp9GUu%2Flf2fna%2F5RRsdqqxPbbx0R3xp%2F77lm2vMyqZb61AUu91zR0uXLtZ7cM9jlUCY1hmKTHefBD8%2BFv4STtoS4IOTbyCzJADpY7KEFGHna%2Bipo0WEjRD5y2EM7CI8NLdW6c%2BvHFvNgACKdDFS1DT5mAB0ZJg8jvM%2BB2udOcU6Naoj2B%2Bg4A%2By0JUqJKwCCXxClyV0EmaxCLjHZqC4AmYckdyPmlzOeTGalV4CQGqBOEG9dPvjtWPSRjJNKgNkXBMySurtJLxNNyyROdLhMiC%2BRphlUrhiBeieZ2oOgHOZViarOpx3FWP9HJ%2B28SA2z7gNFZUhEn5NVTWqnsdNCVRczymZL1Q%2B5JNqpDQXKzqhFZok2T6qt3MebtFi8U9qPxCwBGPWTKRTqeSU2crdlQvYx6GIp3yuLNoDeoSmbYeDiVUVSovKhtI%2FvtmaOnG5Pokm%2F%2FU0osgOEzTp9IBB2nDBUgTiFOwrOjEKi%2F0SM689fDcZcOgLI21xlIai0X62Vo%2BGHZCwCGHk8U8JLSAZyjwKjvVE2EFyu65mvVVw6nEozuZ1reqxJK4hqYVXNiyEi%2BAtHslHg%2BHwhN%2BSnHjNp6luAlPS%2B1tZJfsHAf1sIsot1hWkY9p63Vw3qP%2Fx8Oh%2BIgPilz3snmK%2BkLWClnRsHuzHx11b2hsuVTPHVtc2l7F7CY218awn9rIY1F16iLzlI26%2BdojimjTpFP5wzq2S4mcAMfqEqHKxdyC35l8GVzwUEksGor7mRK9trOFEvOLrxWtjEee8MGqDLG7OlijcX8Hy3Uvz4PljqyVgTDien7qGjBb6B7Nkd3LteW%2FZr1p9pPrLTWOTgbKOSUB9sz6D8yKefBWJIWn868ir8xMJc7adnvqEO%2FdOeJN9kMjYB%2BunGJWt%2BiA01GkRNaNMa3FZv8Xz8zKaUWRaPruDeDrD2%2F8%2B0cAtC2DTlMbdOZkDt8Z%2FwOdjB%2Fl%2FBMAAA%3D%3D

        // http://www.feis-crs.org/beta/faces/ReviewResults.xhtml?SelectInvasiveness=2
        

        $this->life_forms = array("Vine", "Tree", "Shrub", "Graminoid", "Forb", "Fern", "Bryophyte");
        $this->species_list_export = "http://localhost/~eolit/cp/FEIS/FEIS.zip";
        $this->species_list_export = "https://dl.dropboxusercontent.com/u/7597512/FEIS/FEIS.zip";
    }
    
    // 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

    function generate_FEIS_data()
    {
        
        $url = "http://www.feis-crs.org/beta/faces/SearchByOther.xhtml?frmSearchByOther=frmSearchByOther&btnSearch=Search&j_idt25=on&selectedPlants=12&javax.faces.ViewState=H4sIAAAAAAAAAK1YT2zbVBh%2FTduNlmka61pWQaaudEOTgts0aZNqTDTbWhqRtlnThbU7dK%2F2a%2BLWsb3n58TZWDWEuIAQSBwQ0hAHLjvAaaddQGhCSJM2xKQJiYkDEhLiAJoQHIAL79mJnT9267TzwX21v8%2Fv9%2F2%2B3%2Fu%2Br%2F38d9Cpahg8sw6LkNOJKHEzUMvPQrVz749f3%2Bm79H07CEyDbkmBwjTkiYKToIvkMdLyiiQY6iuTgF0jpafona2DBOxdXxEFEonpGPRcTJkflqCc4%2BZX1xFPTn5w%2F8KnB7QTUgAAQ6UeHSq9bK8R%2FTLYBO2Nz%2BORxufdBUmRcyLRBeTuEhlrfL5fQxJFgIQ0xUM0d7dYjZu9CtirTnvV5rylBL7EKwVO02VuDfJIM%2B8SIhqHJG4R5mYRySvClKFS4jRRkYF1te2jHGDQzzgymGmj3eXUs08vv%2F%2Fz44Bp12PbORafvf1O5s%2FlBy%2BbbFIcgwrOcVCFfB65fTBZUKXkP%2FCRFH7jKNuchdBXOgaOvnBVQxDz%2BdMIyhzMIZkvZ0y2zuRp7pBwDYDGfGYIFuXcyS8eZH%2F9LXj11Wo%2B2wgYtIBaVKAikgmXhZKOrG9NsQeqapSyYHE4Y%2B1anid5hDkjTwrSwGQ4OhGKTQwUHZ%2BUqBEkI3xqcFugg4bGouovRfxEtd%2BJJ6uIgpnT51huKEC1chHQVZAg2UJrY9EdiIateitYGzMgykWoiZQomraaDFTRtbFFcGsOR%2BKhWNwHh25beXLoissfh5XjFX%2FCTGGUo7pu0morTI3F%2FanNbStPplxx%2BWOq1%2FKiRdjCuwAFUW8qVwctq2RNRjzEObFLygfA83Wh5ZCSwAhuyfY5MO%2FB9uhIKBbxwXbDLjbR3DZoWlHjRHOPsFido8e9KJKyO6PR3Yr4KAjWxSBXttsZpRPRUCzqg9HGXWxKh7eD44%2FTPZbc3BhRafM4dNFlGjj81X%2BZXzYe3bW7h%2BNdxGCouZGkFY0kBGFRyYqoZLaSx%2B%2Fe%2FuaHA7duW03yeLPLGaWgKjJdZcqUl4Lp9GUu%2Flf2fna%2F5RRsdqqxPbbx0R3xp%2F77lm2vMyqZb61AUu91zR0uXLtZ7cM9jlUCY1hmKTHefBD8%2BFv4STtoS4IOTbyCzJADpY7KEFGHna%2Bipo0WEjRD5y2EM7CI8NLdW6c%2BvHFvNgACKdDFS1DT5mAB0ZJg8jvM%2BB2udOcU6Naoj2B%2Bg4A%2By0JUqJKwCCXxClyV0EmaxCLjHZqC4AmYckdyPmlzOeTGalV4CQGqBOEG9dPvjtWPSRjJNKgNkXBMySurtJLxNNyyROdLhMiC%2BRphlUrhiBeieZ2oOgHOZViarOpx3FWP9HJ%2B28SA2z7gNFZUhEn5NVTWqnsdNCVRczymZL1Q%2B5JNqpDQXKzqhFZok2T6qt3MebtFi8U9qPxCwBGPWTKRTqeSU2crdlQvYx6GIp3yuLNoDeoSmbYeDiVUVSovKhtI%2FvtmaOnG5Pokm%2F%2FU0osgOEzTp9IBB2nDBUgTiFOwrOjEKi%2F0SM689fDcZcOgLI21xlIai0X62Vo%2BGHZCwCGHk8U8JLSAZyjwKjvVE2EFyu65mvVVw6nEozuZ1reqxJK4hqYVXNiyEi%2BAtHslHg%2BHwhN%2BSnHjNp6luAlPS%2B1tZJfsHAf1sIsot1hWkY9p63Vw3qP%2Fx8Oh%2BIgPilz3snmK%2BkLWClnRsHuzHx11b2hsuVTPHVtc2l7F7CY218awn9rIY1F16iLzlI26%2BdojimjTpFP5wzq2S4mcAMfqEqHKxdyC35l8GVzwUEksGor7mRK9trOFEvOLrxWtjEee8MGqDLG7OlijcX8Hy3Uvz4PljqyVgTDien7qGjBb6B7Nkd3LteW%2FZr1p9pPrLTWOTgbKOSUB9sz6D8yKefBWJIWn868ir8xMJc7adnvqEO%2FdOeJN9kMjYB%2BunGJWt%2BiA01GkRNaNMa3FZv8Xz8zKaUWRaPruDeDrD2%2F8%2B0cAtC2DTlMbdOZkDt8Z%2FwOdjB%2Fl%2FBMAAA%3D%3D&";
        // $html = Functions::curl_post_request($file, array('timeout' => 999999));
        
        // $html = "";
        // if($handle = fopen($file, "r"))
        // {
        //     while(!feof($handle))
        //     {
        //         if($line = fgets($handle)) $html .= $line;
        //     }
        //     fclose($handle);
        // }

        // sleep(10);
        // $html = Functions::curl_post_request($file, array('timeout' => 999999));

        // $html = "";
        // if($handle = fopen($file, "r"))
        // {
        //     while(!feof($handle))
        //     {
        //         if($line = fgets($handle)) $html .= $line;
        //     }
        //     fclose($handle);
        // }


        $ch = curl_init();
        $fp = fopen(DOC_ROOT . "/example_homepage.txt", "w");
        curl_setopt($ch, CURLOPT_FILE, $fp);
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        if(isset($parameters_array) && is_array($parameters_array)) curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters_array);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        debug("Sending post request to $url with params ".print_r($parameters_array, 1).": only attempt");
        $html = curl_exec($ch);
        if(0 == curl_errno($ch))
        {
            // curl_close($ch);
        }
        else echo "Curl error ($url): " . curl_error($ch);


        // $ch = curl_init($url);
        // $fp = fopen(DOC_ROOT . "/example_homepage.txt", "w");
        // curl_setopt($ch, CURLOPT_FILE, $fp);
        // curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_exec($ch);
        // // curl_close($ch);
        // fclose($fp);
        // sleep(10);
        // $ch = curl_init($url);
        // $fp = fopen(DOC_ROOT . "/example_homepage.txt", "w");
        // curl_setopt($ch, CURLOPT_FILE, $fp);
        // curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_exec($ch);
        // curl_close($ch);
        // fclose($fp);
        
        $ch = curl_init();
        $fp = fopen(DOC_ROOT . "/example_homepage.txt", "w");
        curl_setopt($ch, CURLOPT_FILE, $fp);
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        if(isset($parameters_array) && is_array($parameters_array)) curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters_array);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        debug("Sending post request to $url with params ".print_r($parameters_array, 1).": only attempt");
        $html = curl_exec($ch);
        if(0 == curl_errno($ch))
        {
            // curl_close($ch);
        }
        else echo "Curl error ($url): " . curl_error($ch);

        print $html;
        exit("\n-ditox-\n");

        $basenames = array_keys($this->export_basenames);
        $text_path = self::load_zip_contents($this->species_list_export, array('timeout' => 3600, 'download_attempts' => 1, 'delay_in_minutes' => 1), $basenames, ".csv");
        print_r($text_path);
        foreach($this->export_basenames as $type => $uri) self::csv_to_array($text_path[$type], $type, $uri);
        $this->archive_builder->finalize(TRUE);
        // remove temp dir
        $basename = $basenames[0];
        $path = $text_path[$basename];
        $parts = pathinfo($path);
        $parts["dirname"] = str_ireplace($basename, "", $parts["dirname"]);
        recursive_rmdir($parts["dirname"]);
        debug("\n temporary directory removed: " . $parts["dirname"]);
        print_r($this->debug);
    }

    private function csv_to_array($csv_file, $type, $uri)
    {
        $i = 0;
        $file = fopen($csv_file, "r");
        if(!$file) return;
        while(!feof($file))
        {
            $temp = fgetcsv($file);
            $i++;
            echo "\n $i - ";
            if($i == 1) continue;   // ignore first line of CSV file
            if($i == 2)             // 2nd row gets the field labels
            {
                $fields = $temp;
                if(count($fields) != 5)
                {
                    $this->debug["not5"][$fields[0]] = 1;
                    continue;
                }
            }
            else
            {
                $rec = array();
                $k = 0;
                // 2 checks if valid record
                if(!$temp) continue;
                if(count($temp) != 5)
                {
                    $this->debug["not5"][$temp[0]] = 1;
                    continue;
                }
                foreach($temp as $t)
                {
                    $rec[$fields[$k]] = $t;
                    $k++;
                }
                
                $rec["type"] = $type;
                $rec["uri"] = $uri;
                $rec = self::manual_adjustment_on_names($rec);
                $this->create_instances_from_taxon_object($rec);
                $this->process_structured_data($rec);
            }
        }
        fclose($file);
    }

    private function manual_adjustment_on_names($rec)
    {
        switch($rec["Scientific Name"])
        {
            case "Vaccinium alaskensis":                $rec["Scientific Name"] = "Vaccinium ovalifolium"; break;
            case "Vaccinium alaskaense":                $rec["Scientific Name"] = "Vaccinium ovalifolium"; break;
            case "Taxus candensis":                     $rec["Scientific Name"] = "Taxus canadensis"; break;
            case "Symphiotrichum leave":                $rec["Scientific Name"] = "Symphyotrichum laeve"; break;
            case "Sporobolus flexuous":                 $rec["Scientific Name"] = "Sporobolus flexuosus"; break;
            case "Schoenoplectus actus":                $rec["Scientific Name"] = "Schoenoplectus acutus"; break;
            case "Populus deltoides var. mislizeni":    $rec["Scientific Name"] = "Populus deltoides subsp. wislizeni"; break;
            case "Pinus leiophylla var. chihuahuan":    $rec["Scientific Name"] = "Pinus leiophylla var. chihuahuana"; break;
            case "Cladonia rangeferia":                 $rec["Scientific Name"] = "Cladonia rangiferina"; break;
            case "Cladonia rangiferia":                 $rec["Scientific Name"] = "Cladonia rangiferina"; break;
            case "Baccharis piluaris":                  $rec["Scientific Name"] = "Baccharis pilularis"; break;
            case "Achnatherum thurberiana":             $rec["Scientific Name"] = "Achnatherum thurberianum"; break;
            case "Cushenbury milkvetch":                $rec["Scientific Name"] = "Astragalus albens";
                                                        $rec["Common Name"] = "Cushenbury milkvetch"; 
                                                        break;
            /*
            case "Botrychium matricariaefolium":        $rec["Scientific Name"] = "Botrychium matricariifolium"; 
            Leo decided to leave it as is and just use "Botrychium matricariaefolium"
            */
        }
        $rec["taxon_id"] = strtolower(str_replace(" ", "_", $rec["Scientific Name"]));
        return $rec;
    }
    
    private function create_instances_from_taxon_object($rec)
    {
        $taxon = new \eol_schema\Taxon();
        $taxon->taxonID                 = $rec["taxon_id"];
        $taxon->scientificName          = $rec["Scientific Name"];
        $taxon->furtherInformationURL   = $rec["Link"];
        echo " - " . $taxon->scientificName . " [$taxon->taxonID]";
        if(!isset($this->taxa[$taxon->taxonID]))
        {
            $this->archive_builder->write_object_to_file($taxon);
            $this->taxa[$taxon->taxonID] = 1;
        }
    }

    private function process_structured_data($record)
    {
        $rec = array();
        $rec["taxon_id"] = $record["taxon_id"];
        $rec["source"] = $record["Link"];
        $rec["catnum"] = $record["type"];
        
        /* previous implementation by Leo:
        "http://eol.org/schema/terms/InvasiveNoxiousStatus"
            - "http://eol.org/schema/terms/feisInvasive";
            - "http://eol.org/schema/terms/feisNotInvasive";
        */
        
        $data = array();
        if(in_array($record["type"], $this->life_forms))
        {
            $data["uri"] = "http://eol.org/schema/terms/PlantHabit";
            $data["value"] = $record["uri"];
            $data["remarks"] = self::life_form_remarks($record["type"]);
        }
        else
        {
            $data["uri"] = $record["uri"];
            $data["value"] = "United States (USA)";
        }
        
        $remarks = "FEIS taxon abbreviation: " . $record["Review Acronym"];
        if($val = @$data["remarks"]) $remarks .= ". " . $val;
        
        self::add_string_types("true", $rec, "", $data["value"], $data["uri"], $remarks);
        if($val = $record["Scientific Name"])  self::add_string_types(null, $rec, "Scientific name", $val, "http://rs.tdwg.org/dwc/terms/scientificName");
        if($val = $record["Review Date"])      self::add_string_types(null, $rec, "Review Date", $val, "http://rs.tdwg.org/dwc/terms/measurementDeterminedDate");
    }
    
    private function add_string_types($measurementOfTaxon, $rec, $label, $value, $mtype, $measurementRemarks = null)
    {
        echo "\n [$label]:[$value]:[$mtype]\n";
        $taxon_id = $rec["taxon_id"];
        $catnum = $rec["catnum"];
        $m = new \eol_schema\MeasurementOrFact();
        $occurrence = $this->add_occurrence($taxon_id, $catnum);
        $m->occurrenceID = $occurrence->occurrenceID;
        
        if($mtype)  $m->measurementType = $mtype;
        else        $m->measurementType = "http://feis.org/". SparqlClient::to_underscore($label); // currently won't pass here
            
        $m->measurementValue = $value;
        if($val = $measurementOfTaxon) $m->measurementOfTaxon = $val;
        if($measurementOfTaxon)
        {
            $m->source = $rec["source"];
            $m->measurementRemarks = $measurementRemarks;
            // not used... $m->contributor, $m->measurementMethod
        }
        $this->archive_builder->write_object_to_file($m);
    }

    private function add_occurrence($taxon_id, $catnum)
    {
        $occurrence_id = $taxon_id . '_' . $catnum;
        if(isset($this->occurrence_ids[$occurrence_id])) return $this->occurrence_ids[$occurrence_id];
        $o = new \eol_schema\Occurrence();
        $o->occurrenceID = $occurrence_id;
        $o->taxonID = $taxon_id;
        $this->archive_builder->write_object_to_file($o);
        $this->occurrence_ids[$occurrence_id] = $o;
        return $o;
    }

    private function life_form_remarks($type)
    {
        switch($type)
        {
            case "Bryophyte":   return "Source value: Bryophyte";
            case "Fern":        return "Source value: Fern or Fern Ally";
            case "Forb":        return "Source value: Forb";
            case "Vine":        return "Source value: Vine or liana";
        }
    }

    private function load_zip_contents($zip_path, $download_options, $files, $extension)
    {
        $text_path = array();
        $temp_path = create_temp_dir();
        if($file_contents = Functions::get_remote_file($zip_path, $download_options))
        {
            $parts = pathinfo($zip_path);
            $temp_file_path = $temp_path . "/" . $parts["basename"];
            $TMP = fopen($temp_file_path, "w");
            fwrite($TMP, $file_contents);
            fclose($TMP);
            $output = shell_exec("tar -xzf $temp_file_path -C $temp_path");
            if(file_exists($temp_path . "/" . $files[0] . $extension))
            {
                foreach($files as $file) $text_path[$file] = $temp_path . "/" . $file . $extension;
            }
            else return;
        }
        else debug("\n\n Connector terminated. Remote files are not ready.\n\n");
        return $text_path;
    }

}
?>