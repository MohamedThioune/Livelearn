<?php /** Template Name: Fetch data clean quick */ ?>

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
    ) );

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


if ( isset ($id) ) {
    $input = 'id';
    $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE id = %d", $id);

    $course = $wpdb->get_results( $sql )[0];

    //array typos
    $typos = ['Opleidingen' => 'course', 'Training' => 'training', 'Workshop' => 'workshop', 'Masterclass' => 'masterclass', 'E-learning' => 'elearning', 'Video' => 'video','Podcast'=>'podcast', 'Artikel' => 'article', 'Assessment' => 'assessment', 'Lezing' => 'reading', 'Cursus' => 'cursus' ,'Event' => 'event', 'Webinar' => 'webinar' ];

    //array levels
    $levels = ['NVT' => 'n.v.t', 'MBO1' => 'mbo1', 'MBO2' => 'mbo2', 'MBO3' => 'mbo3', 'MBO4' => 'mbo4', 'HBO' => 'hbo', 'Universiteit' => 'university', 'Certificate' => 'certificate'];

    //array language 
    $languages = ['English', 'Dutch', 'German', 'French'];

    $onderwerpen = explode(',', $course->onderwerpen);
    
    //short description
    $short_description = $course->short_description ? $course->short_description : 'Please fill in the resume';

    //users 
    $users = get_users();

    $company = get_field('company',  'user_' . $course->author_id)[0];

    $args = array(
        'post_type' => 'company', 
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
    );
    $companies = get_posts($args);

    /*
    * * Display forms w/ correct elements
    */

    echo '<input type="hidden" name="id" value="' . $course->id . '">';
    echo '<input type="hidden" name="complete" value="quick">';

    //titel 
    echo '<div class="form-group"> 
          <input type="text" name="titel" id="" class="form-control" value="' . $course->titel . '" placeholder="Titel ...">
          </div>'; 
    
    //type 
    echo '<div class="form-group"> 
          <select class="multipleSelect2" name="type" id="selected_subtopics">';
            foreach($typos as $key=>$typo){
                if($course->type == $key)
                    echo '<option selected value="'. $key . '">' . $key . '</option>';
                else
                    echo '<option value="'. $key . '">' . $key . '</option>';
            }
    echo '</select>
          </div>';

    //prijs 
    echo '<div class="form-group"> 
          <input type="number" name="prijs" id="" class="form-control" value="' . $course->prijs . '" placeholder="Prijs ...">
          </div>';

    //type 
    $onderwerpen = explode(',' , $course->onderwerpen); 
    echo '<div class="form-group"> 
          <select class="multipleSelect2" name="tags[]" id="selected_subtopics" multiple="true">';
            foreach($categorys as $typo){
                if(in_array($typo->cat_ID, $onderwerpen))
                    echo '<option selected value="'. $typo->cat_ID . '">' . $typo->cat_name . '</option>';
                else
                    echo '<option value="'. $typo->cat_ID . '">' . $typo->cat_name . '</option>';
            }
    echo '</select>
          </div>';

    /*
    * * Description 
    */
    echo '<div class="form-group"> 
          <textarea name="short_description" class="form-control" rows="3" cols="30">' . $short_description . '</textarea><br>
          </div>';

    //Expert
    echo '<div class="form-group"> 
    <select class="multipleSelect2" name="author_id" id="selected_subtopics" required>';
    if($course->author_id != 0)
        foreach($users as $user)
            if($user->ID == $course->author_id)
                echo '<option selected value="'. $user->ID . '">' . $user->display_name . '</option>';
            else
                echo '<option value="'. $user->ID . '">' . $user->display_name . '</option>';
    else{
        echo '<option value="">Select the author</option>';
        foreach($users as $user)
            echo '<option value="'. $user->ID . '">' . $user->display_name . '</option>';
    }
    echo '</select>
        </div>';

    //Contributors
    $contributors = explode(',', $course->contributors);

    echo '<div class="form-group"> 
    <select class="multipleSelect2" name="contributors" id="selected_subtopics" multiple>';
    if(!empty($contributors))
        foreach($users as $user)
            if(in_array($user->ID,$contributors))
                echo '<option selected value="'. $user->ID . '">' . $user->display_name . '</option>';
            else
                echo '<option value="'. $user->ID . '">' . $user->display_name . '</option>';
    else{
        echo '<option value="">Select the experts</option>';
        foreach($users as $user)
            echo '<option value="'. $user->ID . '">' . $user->display_name . '</option>';
    }
    echo '</select>
        </div>';

    //Company
    echo '<div class="form-group"> 
        <select class="multipleSelect2" name="company_id" id="selected_subtopics" required>';
        if(!empty($company))
            echo '<option selected value="'. $company->ID . '">' . $company->post_title . '</option>';
        else{
            echo '<option value="">Select the company</option>';
            foreach($companies as $companie)
                echo '<option value="'. $companie->ID . '">' . $companie->post_title . '</option>';
        }
    echo  '</select>
    </div>';

    

}

/*
* *Closing forms
*/

?>


<script id="rendered-js" >
$(document).ready(function () {
    //Select2
    $(".multipleSelect2").select2({
        placeholder: "Maak uw keuze.",
         //placeholder
    });
});
//# sourceURL=pen.js
</script>    
