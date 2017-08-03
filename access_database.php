<?php
require_once("database_config.php");

require_once("database.php");
require_once("json_data.php");
$showjsondata = new ShowJsonData();
class AccessDatabase
{
   
    public function save_to_database($title_description_array,$user_search,$total_titles)
    {



       // global $user_search;
        global $mysqldatabase;
       // global $total_titles;
       // global $title_description_array;
      
        for ($i = 0, $j = 1; $i < $total_titles; $i++, $j++) {
           
            $temp_title         = $title_description_array[$i][0][0];
            $save_title_db      = $mysqldatabase->escape_value($temp_title);
        
            $save_link_db       = $title_description_array[$i][1];
         
            $temp_description   = $title_description_array[$i][2][0];
            $save_descriptions  = $mysqldatabase->escape_value($temp_description);
            $insertdata         = "INSERT INTO googleresults (search_query,title,url,description) 
							 values
							 
							  ('$user_search','$save_title_db','$save_link_db','$save_descriptions')";
            $insertintodatabase = $mysqldatabase->query($insertdata);
        } 
    } 
    public function check_database($search_query)
    {
        global $mysqldatabase;
        
        $show_data_query = "SELECT title,url,description FROM googleresults WHERE search_query ='$search_query'";
        $show_data       = $mysqldatabase->query($show_data_query);
        $rowcount        = $mysqldatabase->num_rows($show_data);
        $ret_value       = 0;
        if ($rowcount > 0) {
            $return_info = array(
                $show_data,
                1
            );

             $mysqldatabase->close_connection();
            return $return_info;
        } 
    }


    public function save_json_data_to_database($json_data_regex,$user_search)
    {
             global $mysqldatabase;

                $json_obj = json_decode($json_data_regex);

        foreach($json_obj->result as $key) {
              $save_title_db = $key->title;
               $save_link_db = $key->url;
               $save_descriptions = $key->description;
                

   $insertdata         = "INSERT INTO googleresults (search_query,title,url,description) 
                             values
                             
       ('$user_search','$save_title_db','$save_link_db','$save_descriptions')";
            $insertintodatabase = $mysqldatabase->query($insertdata);
        }




    }
}
?>