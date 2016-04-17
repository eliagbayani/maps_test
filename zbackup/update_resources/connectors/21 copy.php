<?php
namespace php_active_record;
/* connector for AmphibiaWeb 
execution time: 2.5 minutes
Partner provided a non EOL-compliant XML file for all their species.
Connector parses this XML and generates the EOL-compliant XML.
<taxon> and <dataObject> have dc:identifier
*/

$timestart = microtime(1);
include_once(dirname(__FILE__) . "/../../config/environment.php");


$text = "A strange string to pass, maybe with some ø, æ, å characters.";

// foreach(mb_list_encodings() as $chr)
// {
//         echo mb_convert_encoding($text, 'UTF-8', $chr)." : ".$chr."\n";   
// }
// exit;

$resource_id = 21;
$new_resource_path = DOC_ROOT . "temp/".$resource_id.".xml";
// $file = 'http://localhost/cp/Amphibiaweb/amphib_dump.xml';
$file = 'http://amphibiaweb.org/amphib_dump.xml';
if(!$new_resource_xml = Functions::lookup_with_cache($file, array('timeout' => 1200, 'download_attempts' => 5, 'expire_seconds' => 86400))) //cache expires in 1 day
{
    echo("\n\n Content partner's server is down, connector will now terminate.\n");
}else
{
    // These may look like the same wrong characters - but they are several different wrong characters
    $new_resource_xml = str_replace("", "\"", $new_resource_xml);
    $new_resource_xml = str_replace("", "\"", $new_resource_xml);
    $new_resource_xml = str_replace("", "-", $new_resource_xml);

    $new_resource_xml = iconv('UTF-8', 'UTF-8//IGNORE', $new_resource_xml);

    $new_resource_xml = format_utf8($new_resource_xml);
    
    // $new_resource_xml = str_replace(array(0xE2, 0x80, 0xE2, 0x80), " ", $new_resource_xml);
    
    // $new_resource_xml = fix_latin1_mangled_with_utf8_maybe_hopefully_most_of_the_time($new_resource_xml);
    $new_resource_xml = format_utf8($new_resource_xml);

// 0xE2 0x80 0xC2 0xA6
    
    // $new_resource_xml = str_replace(chr(0xE2)." ".chr(0x80)." ".chr(0xE2)." ".chr(0x80), " ", $new_resource_xml);
       
    
    $new_resource_xml = str_replace(array(0xE2, 0x80, 0xC2, 0xA6), " ", $new_resource_xml);
    
    echo "\n===========";
    echo "\n" . mb_detect_encoding($new_resource_xml);
    echo "\n" . mb_detect_encoding($new_resource_xml, "auto");
    echo "\n===========";

    $new_resource_xml = iconv('UTF-8', 'UTF-8//IGNORE', $new_resource_xml);
    // $new_resource_xml = fix_latin1_mangled_with_utf8_maybe_hopefully_most_of_the_time($new_resource_xml);
    $new_resource_xml = format_utf8($new_resource_xml);
    
    $new_resource_xml = str_replace(array(0x73, 0x20, 0x61, 0x6E), " ", $new_resource_xml);
    
    $new_resource_xml = mb_convert_encoding($new_resource_xml, "UTF-8", mb_detect_encoding($new_resource_xml, "UTF-8, ISO-8859-1, ISO-8859-15", true));
    
    // 0xE2 0x80 0xE2 0x80
    
    // $new_resource_xml = str_replace(array(0x20, 0x36, 0x2E, 0x38), " ", $new_resource_xml);
    // $new_resource_xml = str_replace(array(0x6E, 0x2C, 0x20, 0x47), " ", $new_resource_xml);
    // $new_resource_xml = str_replace(array(0x61, 0x2D, 0x50, 0x61), " ", $new_resource_xml);
    // $new_resource_xml = str_replace(array(0x74, 0x74, 0x65, 0x72), " ", $new_resource_xml);
    // $new_resource_xml = str_replace(array(0x20, 0x2E, 0x34, 0x20), " ", $new_resource_xml);
    // $new_resource_xml = str_replace(array(0x43, 0x2E, 0x20, 0x54), " ", $new_resource_xml);
    // $new_resource_xml = str_replace(array(0x73, 0x20, 0x62, 0x61), " ", $new_resource_xml);
    // $new_resource_xml = str_replace(array(0x73, 0x20, 0x68, 0x61), " ", $new_resource_xml);
    // $new_resource_xml = str_replace(array(0x73, 0x20, 0x68, 0x6F), " ", $new_resource_xml);
    
    // 0x73 0x20 0x68 0x6F
    
    // $xml = str_replace(chr(0x73)." ".chr(0x20)." ".chr(0x68)." ".chr(0x61), " ", $xml);
    
    // $new_resource_xml = str_replace(array(0x77, 0x65, 0x72, 0x65), " ", $new_resource_xml);
    
    
    

    if(!($OUT = Functions::file_open($new_resource_path, "w+"))) return;
    fwrite($OUT, $new_resource_xml);
    fclose($OUT);
    unset($new_resource_xml);

    $taxa = array();
    $xml = simplexml_load_file($new_resource_path);
    $total = count($xml->species);

    $i=0;
    foreach(@$xml->species as $species)
    {
        $i++;
        
        //print "\n $i of $total";
        
        $amphibID = (int) trim($species->amphib_id);
        $genus = format_utf8((string) trim($species->genus));
        $speciesName = format_utf8((string) trim($species->species));
        $order = format_utf8((string) trim($species->ordr));
        $family = format_utf8((string) trim($species->family));
        
        $commonNames = format_utf8((string) trim($species->common_name));
        $commonNames = explode(",", $commonNames);
        
        $submittedBy = format_utf8((string) trim($species->submittedby));
        $editedBy = format_utf8((string) trim($species->editedby));
        $description = format_utf8((string) trim($species->description));
        $distribution = format_utf8((string) trim($species->distribution));
        $life_history = format_utf8((string) trim($species->life_history));
        $trends_and_threats = format_utf8((string) trim($species->trends_and_threats));
        $relation_to_humans = format_utf8((string) trim($species->relation_to_humans));
        $comments = format_utf8((string) trim($species->comments));

        $ref = format_utf8((string) trim($species->refs));
        $separator = "&lt;p&gt;";
        $separator = "<p>";
        $ref = explode($separator, $ref);

        $refs = array();
        foreach($ref as $r) $refs[] = array("fullReference" => trim($r));

        $description = fix_article($description);
        $distribution = fix_article($distribution);
        $life_history = fix_article($life_history);
        $trends_and_threats = fix_article($trends_and_threats);
        $relation_to_humans = fix_article($relation_to_humans);
        $comments = fix_article($comments);

        $pageURL = "http://amphibiaweb.org/cgi/amphib_query?where-genus=".$genus."&where-species=".$speciesName."&account=amphibiaweb";
        if(!$submittedBy) continue;
        $agents = array();
        if($submittedBy)
        {
            $parts = preg_split("/(,| and )/",$submittedBy);
            while(list($key,$val)=each($parts))
            {
                $val = trim($val);
                if(!$val) continue;
                $agentParameters = array();
                $agentParameters["role"] = "author";
                $agentParameters["fullName"] = $val;
                $agents[] = new \SchemaAgent($agentParameters);
            }
        }
        $nameString = trim($genus." ".$speciesName);
        $taxonParameters = array();
        $taxonParameters["identifier"] = $amphibID;
        $taxonParameters["source"] = $pageURL;
        $taxonParameters["kingdom"] = "Animalia";
        $taxonParameters["phylum"] = "Chordata";
        $taxonParameters["class"] = "Amphibia";
        $taxonParameters["order"] = $order;
        $taxonParameters["family"] = $family;
        $taxonParameters["scientificName"] = $nameString;
        
        foreach($commonNames as $common_name)
        {
            $taxonParameters['commonNames'][] = new \SchemaCommonName(array("name" => $common_name, "language" => "en"));
        }
        
        $taxonParameters["dataObjects"] = array();

        $dataObjects = array();
        if($distribution)       $dataObjects[] = get_data_object($amphibID . "_distribution","Distribution and Habitat", $distribution, "http://rs.tdwg.org/ontology/voc/SPMInfoItems#Distribution", $refs, $agents, $pageURL);
        if($life_history)       $dataObjects[] = get_data_object($amphibID . "_life_history","Life History, Abundance, Activity, and Special Behaviors", $life_history, "http://rs.tdwg.org/ontology/voc/SPMInfoItems#Trends", $refs, $agents, $pageURL);
        if($trends_and_threats) $dataObjects[] = get_data_object($amphibID . "_trends_threats","Life History, Abundance, Activity, and Special Behaviors", $trends_and_threats, "http://rs.tdwg.org/ontology/voc/SPMInfoItems#Threats", $refs, $agents, $pageURL);
        if($relation_to_humans) $dataObjects[] = get_data_object($amphibID . "_relation_to_humans","Relation to Humans", $relation_to_humans, "http://rs.tdwg.org/ontology/voc/SPMInfoItems#RiskStatement", $refs, $agents, $pageURL);    

        if($description != "") if($comments != "") $description .=  $comments;
        else if($comments != "" ) $description = $comments;    
        if($description) $dataObjects[] = get_data_object($amphibID . "_description", "Description", $description, "http://rs.tdwg.org/ontology/voc/SPMInfoItems#GeneralDescription", $refs, $agents, $pageURL);

        /* we didn't get <comments>
        if($comments)       $dataObjects[] = get_data_object("Comments", $comments, "http://rs.tdwg.org/ontology/voc/SPMInfoItems#GeneralDescription", $refs, $agents, $pageURL);        
        */

        foreach($dataObjects as $k => $v)
        {
            $taxonParameters["dataObjects"][] = new \SchemaDataObject($v);
            unset($v);
        }
        $taxa[] = new \SchemaTaxon($taxonParameters);
        //if($i >= 5) break; //debug
    }

    $new_resource_xml = \SchemaDocument::get_taxon_xml($taxa);
    $old_resource_path = CONTENT_RESOURCE_LOCAL_PATH . $resource_id .".xml";
    if(!($OUT = Functions::file_open($old_resource_path, "w+"))) return;
    fwrite($OUT, $new_resource_xml);
    fclose($OUT);
    Functions::set_resource_status_to_force_harvest($resource_id);
    shell_exec("rm ".$new_resource_path);
    
    //--------
    
    // 0x73 0x20 0x68 0x61
    $xml_path = CONTENT_RESOURCE_LOCAL_PATH . $resource_id.".xml";
    if($xml = Functions::lookup_with_cache($xml_path, array('timeout' => 1200, 'download_attempts' => 5, 'expire_seconds' => true)))
    {
        // $xml = str_replace(chr(0x73)." ".chr(0x20)." ".chr(0x73)." ".chr(0x6B), " ", $xml);
        // $xml = str_replace(array(chr(0x73), chr(0x20), chr(0x68), chr(0x61)), " ", $xml);
        
        $xml = str_replace(array(0x73, 0x20, 0x73, 0x6B), " ", $xml);
        $xml = str_replace(array(0x32, 0x35, 0x2E, 0x35), " ", $xml);
        $xml = str_replace(array(0x32, 0x33, 0x20, 0x6D), " ", $xml);
        
        $xml = str_replace(chr(0x32)." ".chr(0x33)." ".chr(0x20)." ".chr(0x6D), " ", $xml);

        $xml = str_replace(array(0x20, 0x4E, 0x61, 0x74), " ", $xml);
        $xml = str_replace(array(0x73, 0x20, 0x68, 0x6F), " ", $xml);
        
        $xml = str_replace(chr(0x73)." ".chr(0x20)." ".chr(0x68)." ".chr(0x6F), " ", $xml);
        
        $xml = str_replace(array(0x77, 0x65, 0x72, 0x65), " ", $xml);
        $xml = str_replace(array(0xE2, 0x80, 0xC2, 0xA6), " ", $xml);
        
           
        $xml = str_replace(array(0x6E, 0x20, 0x32, 0x30), " ", $xml);
        $xml = str_replace(array(0x67, 0x75, 0x65, 0x7A), " ", $xml);
        $xml = str_replace(array(0x73, 0x20, 0x61, 0x6E), " ", $xml);
        $xml = str_replace(array(0x74, 0x7A, 0x3C, 0x2F), " ", $xml);
        
        // 0x74 0x7A 0x20 0x77
        
        $xml = format_utf8($xml);
        $xml = mb_convert_encoding($xml, "UTF-8", mb_detect_encoding($xml, "UTF-8, ISO-8859-1, ISO-8859-15", true));
        
        //    
        $xml = str_replace(array(0x74, 0x7A, 0x3C, 0x2F), " ", $xml);
        $xml = str_replace(array(0x74, 0x7A, 0x20, 0x77), " ", $xml);
        
        
        
        
        // 0x73 0x20 0x68 0x6F
        
        if(!($OUT = Functions::file_open($xml_path, "w"))) return;
        fwrite($OUT, $xml);
        fclose($OUT);
        echo "\nSaved [$xml_path]...\n";
    }
    

    
    
    //--------
    
    Functions::gzip_resource_xml($resource_id);
    $elapsed_time_sec = microtime(1)-$timestart;
    echo "\n";
    echo "elapsed time = $elapsed_time_sec sec                 \n";
    echo "elapsed time = " . $elapsed_time_sec/60 . " minutes  \n";
    echo "elapsed time = " . $elapsed_time_sec/60/60 . " hours \n";
    echo "\n\n Done processing.";
}

function fix_article($article)
{
    $article = str_ireplace(array("\n", "\t", "</p>"), "", $article);
    if(substr($article, 0, 3) == "<p>") $article = trim(substr($article, 3, strlen($article)));
    $article = str_ireplace("<p>", "------", $article);

    // bring back <p> and </p>
    $article = trim(str_ireplace("------", "</p><p>", $article));
    if($article == "") return;
    $article = "<p>" . $article . "</p>";
    $article = str_ireplace(array("<br><br>", "<p></p>"), "", $article);
    $article = str_ireplace(array("<BR></p>"), "</p>", $article);

    // make <img src=''> and <a href=''> work
    $article = str_ireplace('href="/amazing_amphibians', 'href="http://amphibiaweb.org/amazing_amphibians', $article);
    $article = str_ireplace('src="/images', 'src="http://amphibiaweb.org/images', $article);

    return trim($article);
}

function get_data_object($id, $title, $description, $subject, $refs, $agents, $pageURL)
{
    $dataObjectParameters = array();
    $dataObjectParameters["identifier"] = $id;
    $dataObjectParameters["title"] = $title;
    $dataObjectParameters["description"] = $description;
    $dataObjectParameters["dataType"] = "http://purl.org/dc/dcmitype/Text";
    $dataObjectParameters["mimeType"] = "text/plain";
    $dataObjectParameters["language"] = "en";
    $dataObjectParameters["license"] = "http://creativecommons.org/licenses/by/3.0/";
    $dataObjectParameters["source"] = $pageURL;
    $dataObjectParameters["agents"] = $agents;
    $dataObjectParameters["audiences"] = array();
    $audienceParameters = array();
    $audienceParameters["label"] = "Expert users";
    $v["audiences"][] = new \SchemaAudience($audienceParameters);
    $audienceParameters["label"] = "General public";
    $v["audiences"][] = new \SchemaAudience($audienceParameters);
    $dataObjectParameters["subjects"] = array();
    $subjectParameters = array();
    $subjectParameters["label"] = $subject;
    $dataObjectParameters["subjects"][] = new \SchemaSubject($subjectParameters);
    $rec["reference"] = $refs;
    // $dataObjectParameters = Functions::prepare_reference_params($rec, $dataObjectParameters);
    return $dataObjectParameters;
}


function format_utf8($value)
{
    // return $value;
    $ret = "";
    $current = "";
    if (empty($value))
    {
        return $ret;
    }

    $length = strlen($value);
    for ($i=0; $i < $length; $i++)
    {
        $current = ord($value{$i});
        // if (($current == 0x9) ||
        //     ($current == 0xA) ||
        //     ($current == 0xD) ||
        //     (($current >= 0x20) && ($current <= 0xD7FF)) ||
        //     (($current >= 0xE000) && ($current <= 0xFFFD)) ||
        //     (($current >= 0x10000) && ($current <= 0x10FFFF))
        //     )

        if (($current == 0x9) ||
            ($current == 0xA) ||
            ($current == 0xD) ||

            (($current >= 0x20) && ($current <= 0xD7FF)) ||
            (($current >= 0xE000) && ($current <= 0xFFFD)) ||
            (($current >= 0x10000) && ($current <= 0x10FFFF)))
        {
            $ret .= chr($current);
        }
        else
        {
            /*
            if(in_array($current, array(0x72, 0x72, 0x65, 0x7A, 0x20, 0x36, 0x2E, 0x38, 0x6E, 0x2C, 0x20, 0x47, 0x61, 0x2D, 0x50, 0x61, 0x74, 0x74, 0x65, 0x72)))
            {
                $ret .= " ";
            }
            else $ret .= " ";
            */
            
            $ret .= " ";
        }
        
        // if(in_array($current, array(0x72, 0x72, 0x65, 0x7A, 0x20, 0x36, 0x2E, 0x38, 0x6E, 0x2C, 0x20, 0x47, 0x61, 0x2D, 0x50, 0x61, 0x74, 0x74, 0x65, 0x72)))
        // {
        //     $ret .= "";
        // }
        // else $ret .= chr($current);
        
        
    }
    
    $ret = mb_convert_encoding($ret, "UTF-8", mb_detect_encoding($ret, "UTF-8, ISO-8859-1, ISO-8859-15", true));
    
    return $ret;
}

/*
function format_utf8($str)
{
    return $str;
    if(Functions::is_utf8($str))
    {
        $str = utf8_decode($str);
        $str = utf8_encode($str);
        return $str;
    }
    else 
    {
        $str = utf8_encode($str);
        $str = utf8_decode($str);
        return utf8_encode($str);
    }
}
*/


/**
 * Removes invalid XML
 *
 * @access public
 * @param string $value
 * @return string
 */
function sanitize_for_xml($input) {
  // Convert input to UTF-8.
  $old_setting = ini_set('mbstring.substitute_character', '"none"');
  $input = mb_convert_encoding($input, 'UTF-8', 'auto');
  ini_set('mbstring.substitute_character', $old_setting);

  // Use fast preg_replace. If failure, use slower chr => int => chr conversion.
  $output = preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', '', $input);
  if (is_null($output)) {
    // Convert to ints.
    // Convert ints back into a string.
    $output = ords_to_utfstring(utfstring_to_ords($input), TRUE);
  }
  return $output;
}

/**
 * Given a UTF-8 string, output an array of ordinal values.
 *
 * @param string $input
 *   UTF-8 string.
 * @param string $encoding
 *   Defaults to UTF-8.
 *
 * @return array
 *   Array of ordinal values representing the input string.
 */
function utfstring_to_ords($input, $encoding = 'UTF-8'){
  // Turn a string of unicode characters into UCS-4BE, which is a Unicode
  // encoding that stores each character as a 4 byte integer. This accounts for
  // the "UCS-4"; the "BE" prefix indicates that the integers are stored in
  // big-endian order. The reason for this encoding is that each character is a
  // fixed size, making iterating over the string simpler.
  $input = mb_convert_encoding($input, "UCS-4BE", $encoding);

  // Visit each unicode character.
  $ords = array();
  for ($i = 0; $i < mb_strlen($input, "UCS-4BE"); $i++) {
    // Now we have 4 bytes. Find their total numeric value.
    $s2 = mb_substr($input, $i, 1, "UCS-4BE");
    $val = unpack("N", $s2);
    $ords[] = $val[1];
  }
  return $ords;
}

/**
 * Given an array of ints representing Unicode chars, outputs a UTF-8 string.
 *
 * @param array $ords
 *   Array of integers representing Unicode characters.
 * @param bool $scrub_XML
 *   Set to TRUE to remove non valid XML characters.
 *
 * @return string
 *   UTF-8 String.
 */
function ords_to_utfstring($ords, $scrub_XML = FALSE) {
  $output = '';
  foreach ($ords as $ord) {
    // 0: Negative numbers.
    // 55296 - 57343: Surrogate Range.
    // 65279: BOM (byte order mark).
    // 1114111: Out of range.
    if (   $ord < 0
        || ($ord >= 0xD800 && $ord <= 0xDFFF)
        || $ord == 0xFEFF
        || $ord > 0x10ffff) {
      // Skip non valid UTF-8 values.
      continue;
    }
    // 9: Anything Below 9.
    // 11: Vertical Tab.
    // 12: Form Feed.
    // 14-31: Unprintable control codes.
    // 65534, 65535: Unicode noncharacters.
    elseif ($scrub_XML && (
               $ord < 0x9
            || $ord == 0xB
            || $ord == 0xC
            || ($ord > 0xD && $ord < 0x20)
            || $ord == 0xFFFE
            || $ord == 0xFFFF
            )) {
      // Skip non valid XML values.
      continue;
    }
    // 127: 1 Byte char.
    elseif ( $ord <= 0x007f) {
      $output .= chr($ord);
      continue;
    }
    // 2047: 2 Byte char.
    elseif ($ord <= 0x07ff) {
      $output .= chr(0xc0 | ($ord >> 6));
      $output .= chr(0x80 | ($ord & 0x003f));
      continue;
    }
    // 65535: 3 Byte char.
    elseif ($ord <= 0xffff) {
      $output .= chr(0xe0 | ($ord >> 12));
      $output .= chr(0x80 | (($ord >> 6) & 0x003f));
      $output .= chr(0x80 | ($ord & 0x003f));
      continue;
    }
    // 1114111: 4 Byte char.
    elseif ($ord <= 0x10ffff) {
      $output .= chr(0xf0 | ($ord >> 18));
      $output .= chr(0x80 | (($ord >> 12) & 0x3f));
      $output .= chr(0x80 | (($ord >> 6) & 0x3f));
      $output .= chr(0x80 | ($ord & 0x3f));
      continue;
    }
  }
  return $output;
}
//============

function fix_latin1_mangled_with_utf8_maybe_hopefully_most_of_the_time($str)
{
    return preg_replace_callback('#[\\xA1-\\xFF](?![\\x80-\\xBF]{2,})#', 
    Function ($m) 
    {
        
        // utf8_encode($m[0]);
        
        if(Functions::is_utf8($m[0]))
        {
            $str = utf8_decode($m[0]);
            $str = utf8_encode($str);
            return $str;
        }
        else 
        {
            return utf8_encode($m[0]);
        }
        
        
        
    }
    , $str);
}

function utf8_encode_callback($m)
{
    return utf8_encode($m[0]);
}

// $line = preg_replace_callback(
//         '|<p>\s*\w|',
//         function ($matches) {
//             return strtolower($matches[0]);
//         },
//         $line
//     );

?>
