<?php /** Template Name: Subtopics*/ ?>
<?php
    global $wpdb;

    extract($_POST);

    $table = $wpdb->prefix . 'databank';

    if (isset($ids)) {
        foreach ($ids as $key => $id) {
            $sql=$wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE id = %d",$id);
            $artikels = $wpdb->get_results($sql)[0];

            $where = ['id' => $id];
            
            $type = 'Artikel';

            $title = explode(' ', $article['title']['rendered']);
            $description = explode(' ', trim(strip_tags($article['excerpt']['rendered'])));
            $long_description = explode(' ',trim(strip_tags($article['content']['rendered'])));    
            $keywords = array_merge($title, $description, $long_description);
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
                $cat_id = strval($item->cat_ID);
                $item = intval($cat_id);
                array_push($categories, $item);
            };

            $bangerichts = get_categories( 
                array(
                    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                    'parent'  => $categories[1],
                    'hide_empty' => 0, // change to 1 to hide categores not having a single post
                ) 
            );

            $functies = get_categories( 
                array(
                    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                    'parent'  => $categories[0],
                    'hide_empty' => 0, // change to 1 to hide categores not having a single post
                ) 
            );

            $skills = get_categories( array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent'  => $categories[3],
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ) );

            $interesses = get_categories( array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent'  => $categories[2],
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ) );

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

                if(empty($tags)){
                $occurrence = array_count_values(array_map('strtolower', $keywords));
                arsort($occurrence);
                foreach($categorys as $value)
                    if($occurrence[strtolower($value->cat_name)] >= 1)
                    array_push($tags, $value->cat_ID);
                }
            }

            $occurrence = array_count_values(array_map('strtolower', $keywords));
            foreach($keywords as $searchword){
                $searchword = strtolower(strval($searchword));
                foreach($categorys as $category){
                    $cat_slug = $category->slug;
                    $cat_name = $category->cat_name; 
                    if($occurrence[strtolower($category->cat_name)] >= 1)
                    if(strpos($searchword, $cat_slug) !== false || in_array($searchword, $cat_name))
                        if(!in_array($category->cat_ID, $tags))
                            array_push($tags, $category->cat_ID);
                }
            }

            $onderwerpen= join(',',$tags);

                $articles=array( 
                    'onderwerpen' => $onderwerpen
                );

                $updated=$wpdb->update($table,$articles,$where);

            }
        }
?>