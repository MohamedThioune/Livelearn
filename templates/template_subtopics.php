<?php /** Template Name: Subtopics*/ ?>
<?php
    global $wpdb;
    $ids = array_values($_POST);
    // extract($_POST);
    $table = $wpdb->prefix . 'databank';
        foreach ($ids as $key => $id) {
            $sql=$wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE id = %d",$id);
            $artikels = $wpdb->get_results($sql)[0];
            // var_dump ($artikels);
            $where = ['id' => $id];

            $type = 'Artikel';

            $title = explode(' ',trim($artikels->titel));
            $short_description = explode(' ', trim($artikels->short_description));
            $long_description = explode(' ',trim($artikels->long_description));    
            $keywords = array_merge($title, $short_description, $long_description);
            var_dump($keywords);

            $occurrences = array_count_values(($keywords)); //occurrences for each word
            var_dump($occurrences);
            // foreach($keywords as $searchword){
            //     $searchword = strtolower(strval($searchword));
            //     foreach($categorys as $category){
            //         $cat_slug = $category->slug;
            //         $cat_name = $category->cat_name; 
            //         if($occurrences[strtolower($category->cat_name)] >= 1)
            //         if(strpos($searchword, $cat_slug) !== false || in_array($searchword, $cat_name))
            //             if(!in_array($category->cat_ID, $tags))
            //                 array_push($tags, $category->cat_ID);
            //     }
            // }

            // $onderwerpen= join(',',$tags);

            //     $articles=array( 
            //         'onderwerpen' => $onderwerpen
            //     );
                // $updated=$wpdb->update($table,$articles,$where);
            }
            //echo ($updated);//0 au lieu de 1

?>

