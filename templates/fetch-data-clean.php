<?php /** Template Name: Fetch data clean */ ?>

<?php

global $wpdb;

$table = $wpdb->prefix . 'databank';

extract($_POST);

if ( isset ($key) ) {

$id = $key + 1;
$input = 'id';
$sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE id = %d", $id);

$course = $wpdb->get_results( $sql );

//array typos
$typos = ['Opleidingen' => 'course', 'Training' => 'training', 'Workshop' => 'workshop', 'Masterclass' => 'masterclass', 'E-learning' => 'elearning', 'Video' => 'video', 'Atrtikel' => 'article', 'Assessment' => 'assessment', 'Lezing' => 'reading', 'Cursus' => 'cursus' ,'Event' => 'event', 'Webinar' => 'webinar' ];
$type = ['Opleidingen', 'Training', 'Workshop', 'Masterclass', 'E-learning', 'Video', 'Atrtikel', 'Assessment', 'Lezing', 'Cursus', 'Event', 'Webinar' ];

/*
* * Display forms w/ correct elements
*/

//Starting forms
echo '<form action="" method="">';

    //titel 
    echo '<input type="text" name="titel" id="" class="form-control" value="' . $course->titel . '">';

    //type 
    echo '<select class="multipleSelect2" id="selected_subtopics" multiple="true">';
    foreach($typos as $key=>$typo){
        if(in_array($course->type,$type))
            echo '<option selected value="'. $typo . '">' . $key . '</option>';
        else
            echo '<option value="'. $typo . '">' . $key . '</option>';
    }
    echo '</select>';

//Closing forms
echo '</form>';

}