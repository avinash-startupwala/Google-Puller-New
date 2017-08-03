<?php
ini_set('max_execution_time', 240);
define("TITLE", "h3 class=\".r\"");
require_once("html_parser.php");
require_once("simple_html_dom.php");
require_once("regex_parser.php");
$titlesarray        = array();
$descriptionarray   = array();
$linksarray         = array();
$count              = 0;
$sorted_links_array = array();

$total_titles;
$page_number   = 0;
$count_tracker = 0;

$accessdatabase = new AccessDatabase();
$htmlparser     = new HtmlParser();
class GooglePuller
{
    
    public $user_search_query;
    public function __construct($user_search_new)
    {
        $this->user_search_query = "$user_search_new";
    }
    function get_html($page_no)
    {
        
        $user_search_new = str_replace(" ", "+", $this->user_search_query);
        
        $url = "https://www.google.co.in/search?q={$user_search_new}&start={$page_no}";
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
        $query = curl_exec($ch);
        curl_close($ch);
        return $this->html = str_get_html($query);
    }
    
    
    
    public function getTextBetweenTags($string, $tagname)
    {
        $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
        preg_match($pattern, $string, $matches);
        
        return $matches;
    }
    
    public function start()
    {
        $regexparser = new RegexParser();
        $htmlparser  = new HtmlParser();
        global $page_number;
        global $showjsondata;
        global $accessdatabase;
        
        for ($x = 0; $x <= 3; $x++) {
            $html               = $this->get_html($page_number);
            $parsed_regex_array = array();
            
            
            
            
            
            
            
            
            
            
            
            
            
            $return_array     = $htmlparser->parse_html($html, $this->user_search_query);
            $json_data_google = $showjsondata->convert_arrays_to_json($return_array[0]);
            
            $accessdatabase->save_to_database($return_array[0], $this->user_search_query, $return_array[1]);
            $showjsondata->display_results($json_data_google);
            
            
            $page_number = $page_number + 10;
        }
        echo "<br><br>";
        
        
    }
    
}
?> 