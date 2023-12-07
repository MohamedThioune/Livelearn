<?php /** Template Name: Subtopics */ ?>
<?php
    // function strip_html_tags($text) {
        // $allowed_tags = ['h2', 'br', 'strong', 'em', 'u', 'blockquote', 'ul', 'ol', 'li', 'img', 'mark'];
    //     $text = preg_replace("/\n{1,}/", "\n", $text); 
    //     $text = str_replace("\n"," ",$text);
    //     $text = str_replace("/"," ",$text);
    //     $text = str_replace("&amp;"," ",$text);
    //     $text = str_replace("&lt;"," ",$text);
    //     $text = str_replace("&gt;"," ",$text);
    //     $text = str_replace(['h1','h3','h4','h5','h6'],'h2',$text);
    //     $pattern = '/<(?!\/?(?:' . implode('|', $allowed_tags) . ')\b)[^>]*>/';
    //     return preg_replace($pattern, '', $text);
    // }
    global $wpdb;
    $ids = array_values($_POST);
    $table = $wpdb->prefix . 'databank';
    // var_dump($ids);
    foreach ($ids as $key => $id) {
        $sql=$wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE id = %d",$id);
        $artikels = $wpdb->get_results($sql)[0];
        // var_dump ($artikels);
        $where = ['id' => $id];
        
        // $type = 'Artikel';
        $tit = strip_tags($artikels->titel);
        $title = explode(' ',$tit);
        $descrip = strip_tags($artikels->short_description);
        $description = explode(' ', $descrip);
        $long_desc = strip_tags($artikels->long_description);
        $long_description = explode(' ',$long_desc);    
        $keywords = array_merge($title, $description, $long_description);
        // var_dump($keywords);
        $tags = array();
        $onderwerpen = "";
        $categories = array(); 
        $cats = get_categories(
            array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'orderby'    => 'name',
                'exclude' => 'Uncategorized',
                'parent'     => 0,
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            )
        );
        
        foreach($cats as $item){
            $cat_id = $item->cat_ID;
            array_push($categories, $cat_id);
        }
        
        $bangerichts = get_categories( array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent'  => $categories[1],
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            )
        );
        
        $functies = get_categories( array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent'  => $categories[0],
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ) 
        );  
        
        $skills = get_categories( array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent'  => $categories[3],
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            )
        );
            
        $interesses = get_categories( array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent'  => $categories[2],
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            )
        );
                
        $categorys = array(); 
        foreach($categories as $categ){
            //Topics
            $topics = get_categories(
                array(
                'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent'  => $categ,
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
                ) 
            );
            // var_dump($topics);
            foreach ($topics as $value) {
                $tag = get_categories(
                    array(
                    'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                    'parent'  => $value->cat_ID,
                    'hide_empty' => 0,
                    )
                );
                $categorys = array_merge($categorys, $tag);      
            }
        }
        $words_not_goods=[];
        foreach($categorys as $cat){
            // var_dump($cat->cat_name);
            if(str_contains($cat->cat_name,' ')){
                $words_not_goods[]=$cat->cat_name;
            }
        }

        $occurrence = array_count_values(array_map('strtolower', $keywords));
        //    foreach($keywords as $wo){
        //     var_dump($wo);
        //    }
        // var_dump($categorys);
        foreach($keywords as $key => $searchword){
            $searchword = trim(strtolower(strval($searchword)));
            if ($searchword=='' || $searchword=='\n' || $searchword==' '|| $searchword=='\t'){    
                unset($keywords[$key]);
                continue;
            }
            foreach($categorys as $i=>$category){
                if ($i >50) {
                        break;
                    }
                $cat_slug = $category->slug;
                $cat_name = $category->cat_name; 
                if($occurrence[strtolower($category->cat_name)] >= 1)
                    if(strpos($searchword, $cat_slug) !== false || strpos($searchword, $cat_name))
                        if(!in_array($category->cat_ID, $tags))
                            array_push($tags, $category->cat_ID);
            }
        }
        // var_dump($tags);
        if(empty($tags)){
            $occurrence = array_count_values(array_map('strtolower', $keywords));
            arsort($occurrence);
            foreach($categorys as $value)
                if($occurrence[strtolower($value->cat_name)] >= 1)
                    if(!in_array($value->cat_ID, $tags))
                        array_push($tags, $value->cat_ID);
        }
        $onderwerpen = join(',',$tags);
        // var_dump($onderwerpen);
        $articles=array( 
            'onderwerpen' => $onderwerpen
        );
        $updated=$wpdb->update($table,$articles,$where);
    }
    //echo ($updated);//0 au lieu de 1

?>

