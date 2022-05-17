



<?php /** Template Name: Fetch subtopics course */ ?>

<?php
if (isset ($_POST['add_subtopics']) && !empty($_POST['add_subtopics']) && $_POST['action'] == 'add_subtopics') {
{
    // getting subtopics for a specific course 
 $course = get_field('categories', $_POST['id_course']);
  $subtopics=array();
  // new subtopics selected by user
  $subtopics=$_POST['add_subtopics'];
  $field='';
  //Adding new subtopics on this course
    update_field('categories', $subtopics, $_POST['id_course']);
    foreach ($subtopics as $key => $value) {
            if ($value!='')
            $field.=(String)get_the_category_by_ID($value).',';
        }
        // this string will contains all the subtopics of this course
    $field=substr($field,0,-1);

  }

}
else if (empty($_POST['add_subtopics']) && $_POST['action'] == 'add_subtopics') 
{
  update_field('categories',[], $_POST['id_course']);
}
// display the subtopics of this course 
echo $field;
$user_connected = get_current_user_id();
$company_connected = get_field('company',  'user_' . $user_connected);
$users_companie = array();
$course = get_field('categories', $_POST['id_course']);
$users = get_users();

foreach($users as $user) {
    $company_user = get_field('company',  'user_' . $user->ID);
    if(!empty($company_connected) && !empty($company_user))
        if($company_user[0]->post_title == $company_connected[0]->post_title)
            array_push($users_companie,$user->ID);
}

$args = array(
    'post_type' => 'course', 
    'posts_per_page' => -1,
    'author__in' => $users_companie,  
);

$courses = get_posts($args);

$user_in = wp_get_current_user();


//bought courses
$order_args = array(
    'customer_id' => get_current_user_id(),
    'post_status' => array_keys(wc_get_order_statuses()), 
    'post_status' => array('wc-processing'),

);
$orders = wc_get_orders($order_args);



/*
    ** Categories - all  * 
    */

    $categories = array();

    $cats = get_categories( 
        array(
        'taxonomy'   => 'course_category',  //Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) 
    );


    
    foreach($cats as $category){
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($categories, $category);
    }

     $subtopics = array();
     
    foreach($categories as $categ){
        //Topics
        $topicss = get_categories(
            array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categ,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ) 
        );

        foreach ($topicss as  $value) {
            $subtopic = get_categories( 
                 array(
                 'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                 'parent'  => $value->cat_ID,
                 'hide_empty' => 0,
                  //  change to 1 to hide categores not having a single post
                ) 
            );
            $subtopics = array_merge($subtopics, $subtopic);  
            //var_dump($subtopics);    
        }
    }



 ?>


<!-- modal-style -->
         
<!-- script-modal -->

      

                <?php
                       if (isset ($_POST['id_course'])  && $_POST['action'] == 'get_course_subtopics') {
                       {
                ?>
                       <select class='multipleSelect2' id="selected_subtopics"   multiple='true'>
                       <?php
                       
                        $course_subtopics = get_field('categories',$_POST['id_course']);
                        $selected_subtopics=array();
                        if (is_array($course_subtopics) || is_object($course_subtopics)){
                            foreach ($course_subtopics as $key =>  $course_subtopic) {
                                if ($course_subtopic!="" && $course_subtopic!="Array")
                                    array_push($selected_subtopics,$course_subtopic['value']);
                        }
                                                        // check subtopics already added on this course 
                                                        foreach($subtopics as $value){
                                                            if (in_array($value->cat_ID,$selected_subtopics))
                                                                echo "<option selected   value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                                            else
                                                                echo "<option   value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";   
                                                            }
                        }
                        else
                        foreach($subtopics as $value){
                                echo "<option    value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                        }
                    }
                }
                        ?>
                        </select>
                    
                        
<!---->
<script id="rendered-js" >
    $(document).ready(function () {
        //Select2
        $(".multipleSelect2").select2({
            placeholder: "Select subtopics",
             //placeholder
        });
    });
    //# sourceURL=pen.js
</script>    
                     
                    