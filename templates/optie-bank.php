<?php /** Template Name: Optie bank */ ?>

<?php

global $wpdb;

$table = $wpdb->prefix . 'databank'; 

extract($_POST);

/*
* * Tags *
*/ 

$tags = array();
$categories = array(); 

$cats = get_categories( array(
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

$bangerichts = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent'  => $categories[1],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
) );

$functies = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent'  => $categories[0],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
) );

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
}

/*
* * End tags *
*/ 

$sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE id = %d", $id);
$course = $wpdb->get_results( $sql )[0];

$where = [ 'id' => $id ]; // NULL value in WHERE clause.

if($optie == "accept"){
    if($class == 'missing')
    {
        $args = array(
            'post_type'   => 'post',
            'post_author' => $course->author_id,
            'post_status' => 'publish',
            'post_title'  => $course->titel
        );
        
        $id_post = wp_insert_post($args);

        //Insert Artikel
        if (strval($course->type) == "Artikel"){
            update_field('course_type', 'article', $id_post);
            update_field('article_itself', nl2br($course->long_description), $id_post);
        }

        //Insert YouTube
        if (strval($course->type) == "Video"){
            $videos = explode(';', $course->videos);
            
            $youtube_video = array();
            $youtube_videos = array();
            foreach($videos as $item){
                $video = explode('~', $item);
                
                if(!isset($video[1]))
                    continue;

                $youtube_video['id'] = $video[0];
                $youtube_video['title'] = $video[1];
                $youtube_video['thumbnail_url'] = $video[2];

                array_push($youtube_videos, $youtube_video);
            }

            update_field('course_type', 'video', $id_post);
            update_field('youtube_videos', $youtube_videos, $id_post);
        }

        //Insert some other course type
        $type = ['Opleidingen', 'Training', 'Masterclass', 'E-learning', 'Webinar'];
        
        if(in_array(strval($course->type), $type)){
            $coursetype = "";
            foreach($typos as $key => $typo)
                if($course->type == $key)
                    $coursetype == $typo;
            
            update_field('course_type', 'video', $id_post);
        }

        /*
        ** UPDATE COMMON FIELDS
        */
        $onderwerpen = array();

        update_field('short_description', nl2br($course->short_description), $id_post);
        update_field('long_description', nl2br($course->long_description), $id_post);
        update_field('url_image_xml', $course->image_xml, $id_post);

        //Categories
        foreach($categorys as $type)
            if(stristr($course->onderwerpen, $type->cat_name) !== false)
                array_push($onderwerpen, $type->cat_ID);
        
        update_field('categories', $onderwerpen, $id_post);

        if( $course->company_id != 0 && $course->author_id != 0 ){
            $company = get_post($course->company_id);
            update_field('company', $company, 'user_' . $course->author_id);
        }

        //Date
        $data_locaties = explode('~', strval($course->date_multiple));
        if($data_locaties)
            update_field('data_locaties_xml', $data_locaties, $id_post);

        /*
        ** END
        */
        
        $data = [ 'course_id' => $id_post]; // NULL value.
        $wpdb->update( $table, $data, $where );

    }
}     
else if($optie == "decline"){
    if ($class == 'missing')
        null;
    else if ($class == 'present' )
        wp_trash_post($course->course_id);
}
$data = [ 'state' => 1, 'optie' =>  $optie ]; // NULL value.

$updated = $wpdb->update( $table, $data, $where );
echo $wpdb->last_error;

if($updated === false)
    return false; 
else 
    return true;

?>