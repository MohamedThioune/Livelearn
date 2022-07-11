<?php /** Template Name: Edit Databank */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>

<?php

extract($_GET);

global $wpdb;

$table = $wpdb->prefix . 'databank';

$sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE id = %d", $id);

$course = $wpdb->get_results( $sql )[0];

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

//array typos
$typos = ['Opleidingen' => 'course', 'Training' => 'training', 'Workshop' => 'workshop', 'Masterclass' => 'masterclass', 'E-learning' => 'elearning', 'Video' => 'video', 'Artikel' => 'article', 'Assessment' => 'assessment', 'Lezing' => 'reading', 'Cursus' => 'cursus' ,'Event' => 'event', 'Webinar' => 'webinar' ];

//array levels
$levels = ['NVT' => 'n.v.t', 'MBO1' => 'mbo1', 'MBO2' => 'mbo2', 'MBO3' => 'mbo3', 'MBO4' => 'mbo4', 'HBO' => 'hbo', 'Universiteit' => 'university', 'Certificate' => 'certificate'];

//array language 
$languages = ['English', 'Dutch', 'German', 'French'];

$onderwerpen = explode(',', $course->onderwerpen);

$users = get_users();

$short_description = $course->short_description ? $course->short_description : 'Please fill in the resume';
$long_description = $course->long_description ? $course->long_description : 'Please fill in the content';
$for_who = $course->for_who ? $course->for_who : 'Please fill in the content';
$agenda = $course->agenda ? $course->agenda : 'Please fill in the content';
$results = $course->results ? $course->results : 'Please fill in the content';


$company = get_field('company',  'user_' . $course->author_id)[0];

$args = array(
    'post_type' => 'company', 
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',
);
$companies = get_posts($args);

?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<!-- Content -->
<body>

   <div class="contentDetailCourseDataBank">
       <div class="container-fluid">
           <div class="">
               <h2>Modife Course Databank</h2>
               <form action="/dashboard/user/" method="POST">
                   <input type="hidden" name="complete">
                   <input type="hidden" name="id" value="<?= $course->id ?>">

                   <div class="groupInputDate">
                       <div class="input-group">
                           <label for="">Title</label>
                           <input type="text" name="titel" id="" value="<?= $course->titel; ?>" placeholder="Titel ...">
                       </div>
                       <div class="input-group">
                           <label for="">Course type</label>
                           <select name="type" id="">
                           <?php
                            foreach($typos as $key=>$typo){
                                if($course->type == $key)
                                    echo '<option selected value="'. $key . '">' . $key . '</option>';
                                else
                                    echo '<option value="'. $key . '">' . $key . '</option>';
                            }
                            ?>
                           </select>
                       </div>

                   </div>
        
                   <div class="groupInputDate">
                       <div class="input-group">
                           <label for="">Price </label>
                           <input type="number" name="prijs" value="<?= $course->prijs ?>" placeholder="Prijs ...">
                       </div>
                       <div class="input-group">
                           <label for=""> Price VAT </label>
                           <input type="number" name="prijs_vat" value="<?= $course->prijs_vat ?>" placeholder="Prijs VAT...">
                       </div>
                   </div>
                    
                   <div class="groupInputDate">
                        <div class="input-group">
                            <label for="">Certificate</label>
                            <select name="level" id="">
                                <?php
                                foreach($levels as $key=>$level){
                                    if($course->level == $key)
                                        echo '<option selected value="'. $key . '">' . $key . '</option>';
                                    else
                                        echo '<option value="'. $key . '">' . $key . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="input-group">
                            <label for="">Language</label>
                            <select name="language" id="">
                                <?php
                                foreach($languages as $language){
                                    if($course->language == $language)
                                        echo '<option selected value="'. $language . '">' . $language . '</option>';
                                    else
                                        echo '<option value="'. $language . '">' . $language . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="groupInputDate">
                        <div class="input-group">
                            <label for="">Onderwerpen</label>
                            <select name="" id="">
                                <?php
                                    foreach($categorys as $typo){
                                        foreach($categorys as $typo){
                                            if(in_array($typo->cat_ID, $onderwerpen))
                                                echo '<option selected value="'. $typo->cat_ID . '">' . $typo->cat_name . '</option>';
                                            else
                                                echo '<option value="'. $typo->cat_ID . '">' . $typo->cat_name . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="">Date_multiple</label>
                            <input type="text" id="" class="datepicker Txt_Date" placeholder="Pick the multiple dates" style="cursor: pointer;">
                        </div>
                    </div>

                   <div class="groupInputDate">
                       <div class="input-group">
                           <label for="">Author</label>
                           <select name="author_id" id="">
                              <?php
                               if($course->author_id != 0)
                                    foreach($users as $user)
                                        if($user->ID == $course->author_id)
                                            echo '<option selected value="'. $user->ID . '">' . $user->display_name . '</option>';
                                        else
                                            echo '<option value="'. $user->ID . '">' . $user->display_name . '</option>';
                                else{
                                    echo '<option value=""></option>';
                                    foreach($users as $user)
                                        echo '<option value="'. $user->ID . '">' . $user->display_name . '</option>';
                                }
                              ?>
                           </select>
                       </div>
                       <div class="input-group">
                           <label for="">Company</label>
                           <select name="company_id" id="">
                            <?php
                               if(!empty($company))
                                 echo '<option selected value="'. $company->ID . '">' . $company->post_title . '</option>';
                               else{
                                 echo '<option value=""></option>';
                                 foreach($companies as $companie)
                                     echo '<option value="'. $companie->ID . '">' . $companie->post_title . '</option>';
                               }
                                 
                            ?>
                           </select>
                       </div>
                   </div>

                   <div class="groupInputDate">
                       <div class="input-group">
                           <label for="">Duration</label>
                           <input type="text" name="duration" id="" value="<?= $course->duration; ?>" placeholder="Duration(Days)">
                       </div>
                       <div class="input-group">
                           <label for="">Course type</label>
                           <select name="type" id="">
                           <?php
                            foreach($typos as $key=>$typo){
                                if($course->type == $key)
                                    echo '<option selected value="'. $key . '">' . $key . '</option>';
                                else
                                    echo '<option value="'. $key . '">' . $key . '</option>';
                            }
                            ?>
                           </select>
                       </div>
                   </div>

                   <div class="input-group-course">
                       <label for="">Short description</label>
                       <textarea name="" id="" cols="30" rows="6">
                       <?= $course->short_description ?> 
                       </textarea>
                   </div>

                   <div class="input-group-course">
                       <label for="">Long description</label>
                       <textarea name="" id="" cols="30" rows="6">
                       <?= $course->long_description ?> 
                       </textarea>
                   </div>

                   <div class="input-group-course">
                       <label for="">For who</label>
                       <textarea name="" id="" cols="30" rows="6">
                       <?= $course->for_who ?> 
                       </textarea>
                   </div>

                   <div class="input-group-course">
                       <label for="">Agenda</label>
                       <textarea name="" id="" cols="30" rows="6">
                       <?= $course->for_who ?> 
                       </textarea>
                   </div>

                   <div class="input-group-course">
                       <label for="">Results</label>
                       <textarea name="" id="" cols="30" rows="6">
                       <?= $course->results ?> 
                       </textarea>
                   </div>

                   <button type="submit" name="databank" class="btn btn-newDate" data-toggle="modal" data-target="#exampleModalDate">
                       Change
                   </button>

               </form>

           </div>
       </div>
   </div>

</body>

<?php get_footer(); ?>
<?php wp_footer(); ?>



