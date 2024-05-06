<?php /** Template Name: Edit Databank */ 
require_once 'add-author.php';
?>
<?php wp_head(); ?>
<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/bootstrap-datepicker.min.css" />
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css'>
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
$languages = ['Dutch', 'English', 'German', 'French'];

$onderwerpen = explode(',', $course->onderwerpen);

$users = get_users();

$short_description = $course->short_description ? $course->short_description : 'Please fill in the resume';
$long_description = $course->long_description ? $course->long_description : 'Please fill in the content';
$for_who = $course->for_who ? $course->for_who : 'Please fill in the content';
$agenda = $course->agenda ? $course->agenda : 'Please fill in the content';
$results = $course->results ? $course->results : 'Please fill in the content';


$contributors = explode(',', $course->contributors);

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

   <div class="contentDetailCourseDataBank">
       <div class="container-fluid">
           <div class="">
            <?php 
                if(isset($_GET["message"]))
                    echo "<span class='alert alert-info'>" . $_GET['message'] . "</span><br><br>";
                ?>
               <h2>Modife Course Databank</h2>
               <form action="/dashboard/user/" method="POST">
                   <input type="hidden" name="complete" value="all">
                   <input type="hidden" name="id" value="<?= $course->id ?>">

                   <div class="groupInputDate">
                       <div class="input-group">
                           <label for="">Title</label>
                           <input type="text" name="titel" id="" value="<?= $course->titel; ?>" placeholder="Titel ...">
                       </div>
                       <div class="input-group">
                           <label for="">Company</label>
                           <select class="multipleSelect2" name="company_id" id="">
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
                            <select  class="multipleSelect2" name="level" id="">
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
                            <select  class="multipleSelect2" name="language" id="">
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
                        <div class="input-group">
                            <label for="">Onderwerpen</label>
                            <select class="multipleSelect2" name="tags[]" id="" multiple>
                                <?php
                                    foreach($categorys as $typo){
                                        if(in_array($typo->cat_ID, $onderwerpen))
                                            echo '<option selected value="'. $typo->cat_ID . '">' . $typo->cat_name . '</option>';
                                        else
                                            echo '<option value="'. $typo->cat_ID . '">' . $typo->cat_name . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                   <div class="groupInputDate">
                       <div class="input-group">
                           <label for="">Author</label>
                           <select class="multipleSelect2" name="author_id" id="" required>
                              <?php
                               if($course->author_id != 0){
                                    $userswithCompany=usersWithCompany($users);
                                    foreach($userswithCompany as $user)
                                        if($user->ID == $course->author_id)
                                            echo '<option selected value="'. $user->ID . '">' . $user->display_name . '</option>';
                                        else
                                            echo '<option value="'. $user->ID . '">' . $user->display_name . '</option>';
                               }            
                                else{
                                    echo '<option value=""></option>';
                                     $userswithCompany=usersWithCompany($users);
                                    foreach($userswithCompany as $user)
                                        echo '<option value="'. $user->ID . '">' . $user->display_name . '</option>';
                                }
                              ?>
                           </select>
                       </div>

                       <div class="input-group">
                           <label for="">Contributors : </label>
                           <select class="multipleSelect2" name="experts[]" id="" multiple>
                              <?php
                               if(!empty($contributors))
                                    foreach($users as $user)
                                        if(in_array($user->ID, $contributors))
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
                   </div>

                   <div class="input-group-course">
                       <label for="">Short description</label>
                       <textarea  name="short_description" id="" cols="30" rows="6"><?= strip_html_tags($course->short_description) ?>
                       </textarea>
                   </div>

                   <div class="input-group-course">
                       <label for="">Long description</label>
                       <textarea class="editor" id="summernote-long" name="long_description"><?= strip_html_tags($long_description) ?></textarea>
                   </div>

                   <div class="input-group-course">
                       <label for="">For who</label>
                       <textarea name="for_who" class="editor" >
                       <?= $course->for_who ?> 
                       </textarea>
                   </div>

                   <div class="input-group-course">
                       <label for="">Agenda</label>
                       <textarea name="agenda" class="editor">
                       <?= $course->agenda ?> 
                       </textarea>
                   </div>

                   <div class="input-group-course">
                       <label for="">Results</label>
                       <textarea name="results" class="editor">
                       <?= $course->results ?> 
                       </textarea>
                   </div>

                   <?php
                    $data_en = explode('~', $course->date_multiple);
                    if($data_en[0]){
                        foreach($data_en as $key => $datum){
                            $data_between = "";
                            $data = explode(';', $datum);

                            $data_first = $data[0];

                            $location = explode('-', $data_first)[2];
                            $adress = explode('-', $data_first)[3];

                            $data_first = explode(' ', explode('-', $data_first)[0])[0];
                            
                            $max = intval(count($data)-1);
                            $data_last = $data[$max];
                            $data_last = explode(' ', explode('-', $data_last)[0])[0];

                            $data_first = str_replace('/', '.', $data_first);
                            $data_last = str_replace('/', '.', $data_last);

                            //Conversion str to date
                            $data_first = date('Y-m-d', strtotime($data_first));
                            $data_last = date('Y-m-d', strtotime($data_last));

                            $max++;

                            if($max > 3){
                                $slice_array = array_slice( $data, 1, $max-2 );
                                foreach($slice_array as $key => $slice){
                                    $slice = explode(' ', explode('-', $slice)[0])[0];
                                    $data_between .= $slice;
                                    if(isset($slice_array[$key + 1])) 
                                        $data_between .= ','; 
                                }
                            }
                        ?>
                        <div class="groupInputDate">
                            <div class="input-group form-group">
                                <label for="">Start date</label>
                                <input type="date" name="start_date[]" value="<?= $data_first ?>" required>
                            </div>
                        </div>
                        <div class="input-group-course">
                            <label for="">Dates between</label>
                            <input type="text" name="between_date[]"  id="" value="<?= $data_between ?>" class="datepicker Txt_Date" placeholder="Pick the multiple dates" style="cursor: pointer;">
                        </div>
                        <div class="groupInputDate">
                            <div class="input-group">
                                <label for="">End date</label>
                                <input type="date" name="end_date[]" value="<?= $data_last ?>"  required>
                            </div>
                        </div>
                        <div class="input-group-course">
                            <label for="">Location</label>
                            <input type="text" name="location[]" value="<?= $location ?>">
                        </div>
                        <div class="input-group-course">
                            <label for="">Adress</label>
                            <input type="text" name="adress[]" value="<?= $adress ?>">
                        </div>
                        <?php
                        }
                    }
                    else{
                    ?>
                        <div class="">
                            <div class="groupInputDate">
                                <div class="input-group form-group colM">
                                    <label for="">Start date</label>
                                    <input type="date" name="start_date[]">
                                </div>
                            </div>
                            <div class="input-group-course">
                                <label for="">Dates between</label>
                                <input type="text" name="between_date[]" id="" class="datepicker Txt_Date" placeholder="Pick the multiple dates" style="cursor: pointer;">
                            </div>
                            <div class="groupInputDate ">
                                <div class="input-group colM">
                                    <label for="">End date</label>
                                    <input type="date" name="end_date[]">
                                </div>
                            </div>
                            <div class="input-group-course">
                                <label for="">Location</label>
                                <input type="text" name="location[]">
                            </div>
                            <div class="input-group-course">
                                <label for="">Adress</label>
                                <input type="text" name="adress[]">
                            </div>
                        </div>

                    <?php
                    }
                    ?>
                    <div class="results"></div>
                    <div class="buttons groupBtnData">
                        <button type="button" class="add btn-newDate"> Complete with another section</button>
                    </div><br><br>

                    <!-- element for clone -->
                    <div class="blockForClone">
                        <div class="attr">
                            <div class="groupInputDate">
                                <div class="input-group form-group colM">
                                    <label for="">Start date</label>
                                    <input type="date" name="start_date[]">
                                </div>
                            </div>
                            <div class="input-group-course">
                                <label for="">Dates between</label>
                                <input type="text" name="between_date[]"  id="" class="datepicker Txt_Date" placeholder="Pick the multiple dates" style="cursor: pointer;">
                            </div>
                            <div class="groupInputDate">
                                <div class="input-group colM">
                                    <label for="">End date</label>
                                    <input type="date" name="end_date[]">
                                </div>
                            </div>
                            <div class="input-group-course">
                                <label for="">Location</label>
                                <input type="text" name="location[]">
                            </div>
                            <div class="input-group-course">
                                <label for="">Adress</label>
                                <input type="text" name="adress[]">
                            </div>
                            <button class="btn btn-danger remove" type="button">Remove</button>
                        </div>
                    </div>

                   <button type="submit" name="databank" class="btn btn-newDate" >
                       Change
                   </button>

               </form>

           </div>
       </div>
   </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src='https://unpkg.com/@ckeditor/ckeditor5-build-classic@12.2.0/build/ckeditor.js'></script>


<script src='https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.0.8/purify.min.js'></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri();?>/bootstrap-datepicker.js"></script>

<script type="text/javascript">
    $(function () {
        var selectedDates = [];
        datePicker = $('[class*=Txt_Date]').datepicker({
            multidate: true,
            format: 'dd/mm/yyyy ',
            todayHighlight: true,
            language: 'en'
        });
        datePicker.on('changeDate', function (e) {
            if (e.dates.length <= 10) {
                selectedDates = e.dates;
            } else {
                datePicker.data('datepicker').setDates(selectedDates);
                alert('You can only select 10 dates.');
            }
        });
    });
</script>

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
<script>
    ClassicEditor
        .create( document.querySelector( '.editor' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );

</script>
<script src="<?php echo get_stylesheet_directory_uri();?>/customSurmmote.js"></script>
<?php get_footer(); ?>
<?php wp_footer(); ?>
