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

/**
 * Bunch of courses 
 */
$args = array(
    'post_type' => 'course', 
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'post_type' => 'course', 
);
$courses = get_posts($args);

/**
 * Bunch of topics ?
 */



$output = "";
$row_opleidingen = "";
$row_onderwerpen = "";
$row_opleiders = "";

$ro = 0;
$rx = 0;

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
    echo "<center> <i class='hasNoResults'>No matching results</i> </center>"

?>