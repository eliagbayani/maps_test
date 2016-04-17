<?php
namespace php_active_record;
/* */
include_once(dirname(__FILE__) . "/../../config/environment.php");
require_library('connectors/DWCADiagnoseAPI');
$timestart = time_elapsed();



// $source      = DOC_ROOT . "temp/" . "folder2/yyy";
// $destination = DOC_ROOT . "temp/" . "folder2/zzz";
// 

/*
$source      = DOC_ROOT . "temp/";
$destination = DOC_ROOT . "temp2/";
Functions::recursive_copy($source, $destination);
exit("\n\n");
*/

/*
$source      = DOC_ROOT . "app/";
$destination = DOC_ROOT . "app/app2";
echo "\n" . filetype($source) . "\n";
echo "\n" . filetype($destination) . "\n";
exit;
*/

/*
$folder = "/";
$folder = DOC_ROOT . "/temp" . "/folder2";
$folder = CONTENT_RESOURCE_LOCAL_PATH;
Functions::file_rename($source, $destination);
exit("\n\n");
*/


// /*
$resource_id = "Coral_Skeletons";//355;
$func = new DWCADiagnoseAPI();
// Functions::count_resource_tab_files($resource_id);
// names_breakdown(355);
// exit;
// */

//=========================================================
$func->check_unique_ids($resource_id); return;
//=========================================================
// $func->cannot_delete(); return;
//=========================================================
// $func->get_undefined_uris(); return;
//=========================================================

$elapsed_time_sec = time_elapsed() - $timestart;
echo "\n\n";
echo "elapsed time = " . $elapsed_time_sec/60 . " minutes \n";
echo "elapsed time = " . $elapsed_time_sec/60/60 . " hours \n";
echo "\nDone processing.\n";

function names_breakdown($resource_id)
{
    $filename = CONTENT_RESOURCE_LOCAL_PATH . "/$resource_id/taxon.tab";
    $i = 0;
    foreach(new FileIterator($filename) as $line_number => $line)
    {
        $i++;
        $arr = explode("\t", $line);
        if($i == 1) $fields = $arr;
        else
        {
            $k = 0;
            $rec = array();
            foreach($fields as $field)
            {
                $rec[$field] = $arr[$k];
                $k++;
            }
            // print_r($rec); exit;
            
            //start investigation here
            $debug[$rec['taxonomicStatus']]++;
        } 
    }
    
    print_r($debug);
}

function fix_latin1_mangled_with_utf8_maybe_hopefully_most_of_the_time($str)
{
    return preg_replace_callback('#[\\xA1-\\xFF](?![\\x80-\\xBF]{2,})#', 'utf8_encode_callback', $str);
}

function utf8_encode_callback($m)
{
    return utf8_encode($m[0]);
}
/**
   * This method ensures that the output String has only
   * valid XML unicode characters as specified by the
   * XML 1.0 standard. For reference, please see
   * <a href=”http://www.w3.org/TR/2000/REC-xml-20001006#NT-Char”>the
   * standard</a>. This method will return an empty
   * String if the input is null or empty.
   *
   * @param in The String whose non-valid characters we want to remove.
   * @return The in String, stripped of non-valid characters.
   */

Function stripNonValidXMLCharacters($in) 
{
    $out = (string) '';
    $current = ''; // Used to reference the current character.

    for ($i = 0; $i < strlen($in); $i++) 
    {
        $orig = substr($in,0,$i);
        $current = ord($orig);
        if (($current == 0x9) || ($current == 0xA) || ($current == 0xD) ||
        (($current >= 0x20) && ($current <= 0xD7FF)) ||
        (($current >= 0xE000) && ($current <= 0xFFFD)) ||
        (($current >= 0x10000) && ($current <= 0x10FFFF))) $out .= $orig;
    }
    return $out;

}

?>
