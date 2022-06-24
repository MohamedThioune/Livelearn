<?php /** Template Name: Optie bank */ ?>

<?php

global $wpdb;

$table = $wpdb->prefix . 'databank'; 

extract($_POST);

if($class == 'already'){
    $course = get_post($id);
    $input = 'course_id';
    $id = $course->ID;
}
else{
    $id+=1;
    $input = 'id';
    $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE id = %d", $id);
    $course = $wpdb->get_results( $sql );
}
	
$data = [ 'state' => 1, 'optie' =>  $optie ]; // NULL value.
$where = [ $input => $id ]; // NULL value in WHERE clause.

if($optie == "accept")
{
    if($class != 'already')
    {
        //Insert Artikel
        if ($course[0]->type=="Artikel")
        {
            $args=array(
                'post_type' => 'course',
                'post_author' => 0,
                'post_status' => 'publish',
                'post_title' => $course[0]->titel
            );
            
            $id_post_article=wp_insert_post($arg);
            update_field('short_description', $course[0]->short_description, $id_post_article);
            update_field('long_description', $course[0]->long_description, $id_post_article);
            update_field('image_xml', $course[0]->image_xml, $id_post_article);
            update_field('date_multiple', $course[0]->date_multiple, $id_post_article);
            update_field('onderwerpen', $course[0]->onderwerpen, $id_post_article);
            update_field('course_id', $course[0]->course_id, $id_post_article);
            update_field('author_id', $course[0]->author_id, $id_post_article);
            update_field('status', $course[0]->status, $id_post_article);
            update_field('optie', $course[0]->optie, $id_post_article);
            update_field('type', $course[0]->type, $id_post_article);
        }

    }
 
}     
else if($optie == "decline"){
    if($class != 'already')
        null;
    else
        wp_trash_post($id);
}

$updated = $wpdb->update( $table, $data, $where );

if($updated === false)
    return false; 
else 
    return true;

?>