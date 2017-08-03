<?php


class RegexParser
{
    
    public function parse_with_regex($html, $user_search_query)
    {
        
        
        global $accessdatabase;
        
        preg_match_all('#<h3.*?><a href="(.*?)".*?</h3>#', $html, $matches);
        
        preg_match_all('#<span class="st">.*?</span>#', $html, $descriptionss);
        $links_array_by_regex = $matches[1];
        
        $title_array_by_regex = $matches[0];
        
        
        
        $description_array_by_regex = $descriptionss[0];
        
        $k = 0;
        foreach ($title_array_by_regex as $key) {
            
            
            
            
            if (strpos($key, "News for") !== false) {
                
                
                
                
                unset($title_array_by_regex[$k]);
                if ($k > 0) {
                    unset($description_array_by_regex[$k]);
                    $description_array_by_regex = array_values($description_array_by_regex);
                }
                if ($k == 0) {
                    unset($description_array_by_regex[$k]);
                    
                    $description_array_by_regex = array_values($description_array_by_regex);
                    
                }
            }
            
            
            $k++;
        }
        
        $title_array_by_regex = array_values($title_array_by_regex);
        
        $i = 0;
        foreach ($title_array_by_regex as $key) {
            
            
            
            if (strpos($key, 'Images for') !== false) {
                
                
                
                unset($title_array_by_regex[$i]);
            }
            
            
            $i++;
        }
        $title_array_by_regex = array_values($title_array_by_regex);
        
        
        $z                    = 0;
        $formated_title_array = array();
        foreach ($title_array_by_regex as $key) {
            
            
            
            $key = str_replace("(", "", $key);
            $key = str_replace(")", "", $key);
            $key = str_replace(",", "", $key);
            $key = str_replace("'", "", $key);
            
            
            $formated_title = explode("<b>", $key);
            
            if (isset($formated_title[1]) && !empty($formated_title[1])) {
                
                $formated_title_array[$z] = $formated_title[1];
            } else {
                $formated_title_array[$z] = $formated_title[0];
                
            }
            if (strlen($formated_title_array[$z]) > 1000) {
                unset($formated_title_array[$z]);
            }
            
            
            
            $z++;
        }
        
        $j = 0;
        foreach ($links_array_by_regex as $key) {
            
            
            if (strpos($key, 'http') !== false) {
                
                
                
                
            }
            
            
            else {
                
                
                unset($links_array_by_regex[$j]);
                
            }
            
            $j++;
        }
        $links_array_by_regex = array_values($links_array_by_regex);
        
        $x = 0;
        foreach ($links_array_by_regex as $key) {
            $single_link = explode("sa", $key);
            
            $link = $single_link[0];
            
            $link = str_replace("&", "", $link);
            
            $link = str_replace("amp;", "", $link);
            
            $regex_links[$x] = $link;
            
            $x++;
            
        }
        
        
        
        $l                    = 0;
        $formated_links_array = array();
        foreach ($regex_links as $key) {
            $key                      = str_replace("/url?q=", "", $key);
            $formated_links_array[$l] = $key;
            $l++;
        }
        
        
        
        
        $all_data = array();
        
        $i = 0;
        foreach ($formated_title_array as $temp[$i]) {
            $all_data[] = array(
                $formated_title_array[$i],
                $formated_links_array[$i],
                $description_array_by_regex[$i]
            );
            $i          = $i + 1;
        }
        
        $total_titles = count($formated_title_array);
        
        
        
        return $all_data;
        
    }
    
    
}


?>