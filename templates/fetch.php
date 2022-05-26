<?php /** Template Name: Fetch ajax */ ?>

<?php
extract($_POST);
/**
 * Bunch of users 
 */
$args = array(
    'role' => 'Administrator'
);
$users = get_users($args);

$user_id = get_current_user_id();

/*
** Courses - owned * 
*/
$courses = array();

$args = array(
    'post_type' => 'course',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',
);

$global_courses = get_posts($args);

foreach($global_courses as $course)
{  
    $experts = get_field('experts', $course->ID);    
    if($course->post_author == $user_id || in_array($user_id, $experts) ){
        array_push($courses, $course);
    }

}
/**
 * Bunch of topics ?
 */



$output = "";
$row_opleidingen = "";
$row_onderwerpen = "";
$row_opleiders = "";

$row_path = "";

$ro = 0;
$rx = 0;
if(isset($_POST['search_path'])){
    foreach($courses as $course)
        if(stristr($course->post_title, $_POST['search_path']) || $_POST['search_path'] == ''){

            $type_course = get_field('course_type', $course->ID);
            $short_description = get_field('short_description', $course->ID);

            /*
            * Experts
            */
            $expert = get_field('experts', $course->ID);
            $author = array($course->post_author);
            $experts = array_merge($expert, $author);

            $experts_strength = ""; 

            foreach($experts as $expert){
                $image_author = get_field('profile_img',  'user_' . $expert);
                if(!$image_author)
                    $image_author = get_stylesheet_directory_uri() ."/img/placeholder_user.png";
                $experts_strength .= '<img class="euroImg" src="' . $image_author . '" alt="">'; 
            }
            

            /*
            * Thumbnails
            */
            $image = get_field('preview', $course->ID)['url'];
            if(!$image){
                $image = get_field('url_image_xml', $course->ID);
                if(!$image)
                    $image = "https://cdn.pixabay.com/photo/2021/09/18/12/40/pier-6635035_960_720.jpg";
            }
          
            $output .= '
                <tr>
                    <td>
                        <div class="checkbox table-checkbox">
                            <label class="block-label selection-button-checkbox">
                                <input type="checkbox" name="road_path[]" value="' . $course->ID . '"> </label>
                        </div>
                    </td>
                    <td>
                        <div class="blockCardCoursRoad">
                            <div class="imgCoursRoad">
                                <img class="" src="' . $image . '" alt="">
                            </div>
                            <div class="">
                                <p class="titleCoursRoad">' . $course->post_title . '</p>
                                <div class="sousBlockCategorieRoad ">
                                    <img class="euroImg" src="' . get_stylesheet_directory_uri() . '/img/grad-search.png" alt="">
                                    <p class="categoryText">' . $type_course .'</p>
                                </div>
                                <p class="descriptionTextRoad">' . $short_description . '</p>
                                <div class="contentImgCardCour">
                                '
                                    . $experts_strength .
                                '
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>';
        }
    if($output != "" )
        echo $output;
    else 
        echo "<center> <i class='hasNoResults'>No matching results</i> </center>";
 
}else{
    if(strlen($_POST['search']) >= 2){
        foreach($users as $user){
            $filter = $user->data->display_name;
            if(stristr($filter, $_POST['search'])){
                $rx++;
                $row_opleiders .= "<a href='user-overview/?id=". $user->ID ."' class='dropdown-item'><img class='icon9' src='". get_stylesheet_directory_uri() ."/img/fic_student.png'  alt=''> " . $user->display_name."</a>";
            }
            if($rx == 3)
                break;
        }

    /*  foreach($_SESSION['filter_subtopic'] as $filter)
            if(stristr($filter['name'], $_POST['search']))
                $row_onderwerpen .= "<a href='web6.php?sub=".$filter['id']."' style='color:black'><img class='icon9' src='img/fic_search.png' alt=''>" . $filter['name'] ."</a>"; */
    }

    if(strlen($_POST['search']) >= 3)
        foreach($courses as $course){
            if(stristr($course->post_title, $_POST['search'])){
                $row_opleidingen .= "<a href='". get_permalink($course->ID) ."' class='dropdown-item'><img class='icon9' src='". get_stylesheet_directory_uri() ."/img/fic_book.png' alt=''>" . $course->post_title ."</a>";
                $ro++;
            }
            if($ro == 4)
                break;
        }


    //theme-mastersearch-divider
    if($row_opleidingen != "" || $row_onderwerpen != "" || $row_opleiders != ""){
        if($row_opleidingen != "")
            $output .= "<p class='theme-mastersearch-divider' style='color:black'>Opleidingen</p>" . $row_opleidingen;  
        if($row_onderwerpen != "")
            $output .= "<p class='theme-mastersearch-divider' style='color:black'>Onderwerpen</p>" . $row_onderwerpen;
        if($row_opleiders != "")
            $output .= "<p class='theme-mastersearch-divider' style='color:black'>Opleiders</p>" . $row_opleiders;
        echo $output;
    }else 
        echo "<center> <i class='hasNoResults'>No matching results</i> </center>";
}

?>