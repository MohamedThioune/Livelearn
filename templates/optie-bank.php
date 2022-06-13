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

if($optie == "accept"){
    if($class != 'already'){
        null;
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