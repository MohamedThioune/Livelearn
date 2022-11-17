<?php

$user = get_users(array('include'=> get_current_user_id()))[0]->data;

$image = get_field('profile_img',  'user_' . $user->ID);
if(!$image)
    $image = get_stylesheet_directory_uri() . '/img/Ellipse17.png';

$company = get_field('company',  'user_' . $user->ID);
$function = get_field('role',  'user_' . $user->ID);

$biographical_info = get_field('biographical_info',  'user_' . $user->ID);

if(!empty($company))
    $company = $company[0]->post_title;

/*
* * Get interests topics and experts
*/

$topics = get_user_meta($user->ID, 'topic');
$experts = get_user_meta($user->ID, 'expert');

/*
* * End
*/


// Saved courses
$raw_saved = get_user_meta($user->ID, 'course');
$saved = array();
foreach($raw_saved as $save)
    if(get_post($save))
        array_push($saved, $save);

//Orders - enrolled courses  
$args = array(
    'customer_id' => $user->ID,
    'order' => 'DESC',
    'limit' => -1,
);


$bunch_orders = wc_get_orders($args);

$orders = array();
$item_order = array();
$enrolled = array();
$enrolled_courses = array();

foreach($bunch_orders as $order){
    foreach ($order->get_items() as $item_id => $item ) {
        $course_id = intval($item->get_product_id()) - 1;
        if(!in_array($course_id, $enrolled))
            array_push($enrolled, $course_id);
    }
}

/*
* * Pagination
*/
$max_saved = 6;
$max_opgedane = 2;

$const_saved = count($saved);
$const_opgedane = count($enrolled);

if( $const_saved % $max_saved == 0)
    $save_pages = $const_saved/$max_saved;
else
    $save_pages = intval($const_saved/$max_saved) + 1;

if( $const_opgedane % $max_opgedane == 0)
    $save_enrolls = $const_opgedane/$max_opgedane;
else
    $save_enrolls = intval($const_opgedane/$max_opgedane) + 1;

if(isset($_GET['saved'])){
    $saved_number = ($_GET['page1'] - 1) * $max_saved;
    $saved = array_slice($saved, $saved_number, $max_saved);
}

if(isset($_GET['opgedane'])){
    $saved_number = ($_GET['page2'] - 1) * $max_opgedane;
    $enrolled = array_slice($enrolled, $saved_number, $max_opgedane);
}

/*
* * Get courses
*/
$args = array(
    'post_type' => 'course', 
    'posts_per_page' => -1,
    'author' => $user->ID,  
);

$courses = get_posts($args);


if(!empty($saved)){
    $args = array(
        'post_type' => array('course', 'post'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'include' => $saved,  
    );

    $courses_favorite = get_posts($args);
}

/*
* * Feedbacks
*/

$args = array(
    'post_type' => 'feedback', 
    'author' => $user->ID,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'posts_per_page' => -1,
);

$todos = get_posts($args);

/*
* * Enrolled courses
*/
//$kennis_video = get_field('kennis_video', 'user_' . $user->ID);

if(!empty($enrolled))
{
    $args = array(
        'post_type' => 'course', 
        'posts_per_page' => -1,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'include' => $enrolled,  
    );

    $enrolled_courses = get_posts($args);

    // if(!empty($kennis_video))
    //     $enrolled_courses = array_merge($kennis_video, $enrolled_courses);
}

//Statistic views
//Views
$user_post_view = get_posts(
    array(
        'post_type' => 'view',
        'post_status' => 'publish',
        'author' => $user->ID,
        'order' => 'DESC'
    )
)[0];   
$views_user = get_field('views_user', $user_post_view->ID);
if(!empty($views_user))
    $views_user_count = count($views_user);

if(!empty($courses))
    $count_courses = count($courses);
?>

<div class="contentActivity">
    <h1 class="activityTitle">Activiteiten</h1>
    <?php
        if(isset($_GET['message']))
            if($_GET['message'])
                echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>";
    ?>
    <div class="row">
        <div class="col-lg-3 col-md-2 col-sm-6">
            <div class="cardHeadActivity">
                <div class="blockImgCardActivity bleu">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/dashicons_welcome-learn-more.png" alt="">
                </div>
                <div class="detailCardActivity">
                    <p class="numberActivity"><?= $count_courses ?></p>
                    <p class="nameCardActivity">course sessions</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-2 col-sm-6">
            <div class="cardHeadActivity red">
                <div class="blockImgCardActivity">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/notification 1.png" alt="">
                </div>
                <div class="detailCardActivity">
                    <p class="numberActivity"><?php echo count($todos) ?></p>
                    <p class="nameCardActivity">Alerts</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-2 col-sm-6">
            <div class="cardHeadActivity yellow">
                <div class="blockImgCardActivity">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/chat 1.png" alt="">
                </div>
                <div class="detailCardActivity">
                    <p class="numberActivity">0</p>
                    <p class="nameCardActivity">Messages</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-2 col-sm-6">
            <div class="cardHeadActivity green">
                <div class="blockImgCardActivity bleu">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/glif.png" alt="">
                </div>
                <div class="detailCardActivity">
                    <p class="numberActivity"><?= $views_user_count; ?></p>
                    <p class="nameCardActivity">Profil View</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7">
            <div class="cardRecentlyEnrolled">
                <h2>Laatst opgedane kennis</h2>
                <?php 
                if(!empty($enrolled_courses)){
                    foreach($enrolled_courses as $key=>$course) {
                        if($key == 2)
                            break;

                        /*
                        * Location
                        */
                        $location = 'Virtual';
                        $data = get_field('data_locaties', $course->ID);
                        if($data){
                            if($data[0]['data'][0]['location'])
                                $location = $data[0]['data'][0]['location'];
                        }
                        else{         
                            $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                            if($data[2])
                                $location = $data[2];
                        }

                        /*
                        * Categories
                        */
                    
                        $category = ' ';
                                    
                        $category_id = 0;
                        $category_string = " ";

                        $tree = get_the_terms($course->ID, 'course_category'); 
                            if($tree)
                                if(isset($tree[2]))
                                    $category = $tree[2]->name;
                        
                        if($category == ' '){
                            $category_str = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]);
                            $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                            if($category_str != 0)
                                $category = (String)get_the_category_by_ID($category_str);
                            else if($category_id != 0)
                                $category = (String)get_the_category_by_ID($category_id);                                    
                        }

                        /*
                        * Price
                        */
                        $p = get_field('price', $course->ID);
                        if($p != "0")
                            $price =  number_format($p, 2, '.', ',');
                        else
                            $price = 'Gratis';

                        /*
                        * Thumbnails
                        */
                        $thumbnail = get_field('preview', $course->ID)['url'];
                        if(!$thumbnail){
                            $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                            if(!$thumbnail)
                                $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                        }

                    ?>
                    <a href="<?php echo get_permalink($course->ID); ?>" class="coursElement">
                        <div class="imgBlockCoursElement">
                            <img src="<?php echo $thumbnail; ?>" alt="">
                        </div>
                        <div class="detailTwoCoursElement">
                            <div class="d-block">
                                <div class="subDetailTwoCoursElement">
                                    <p class="nameCours"><?php echo $course->post_title; ?></p>
                                    <div class="d-flex">
                                        <div class="d-flex mr-3">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/iconsMap.png" alt="">
                                            <p class="mapLocalisation"><?php echo $location; ?></p>
                                        </div>
                                        <div class="d-flex">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/moneyElement.png" alt="">
                                            <p class="mapLocalisation"><?php echo $price; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tagElementBlock">
                                    <p><?php echo $category; ?></p>
                                </div>
                            </div>
                            <!-- <div class="d-flex">
                                <button class="btn btnViewCours">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/viewC.png" alt="">
                                </button>
                                <button class="btn btnViewCours">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/trashC.png" alt="">
                                </button>
                            </div> -->
                        </div>
                    </a>
                    <?php
                    } 
                }
                else
                    echo "empty until now";
                ?>
                <br>
                <?php
                    if($save_enrolls)
                        foreach (range(1, $save_enrolls) as $number){
                            if(isset($_GET['page2']))
                                if($_GET['page2'] == $number)
                                    echo '<a href="?opgedane&page2=' .$number. '" style="color: #DB372C" class="textLiDashboard">'. $number .'&nbsp;</a>';
                                else
                                    echo '<a href="?opgedane&page2=' .$number. '" class="textLiDashboard">'. $number .'&nbsp;</a>';
                            else
                                echo '<a href="?opgedane&page2=' .$number. '" class="textLiDashboard">'. $number .'&nbsp;</a>';
                        }
                ?>
                
            </div>
        </div>
        <div class="col-lg-5">
            <div class="cardNotification"> 
                <div class="headCardNotification">
                    <h2>Notificaties</h2>
                    <a href="/dashboard/user/notification" class="btn btnOnderwerp2">See all</a>
                </div>
                <?php 
                if(!empty($todos)){
                foreach($todos as $key=>$todo) {
                    if($key == 6)
                        break;

                    $type = get_field('type_feedback', $todo->ID);
                    $manager = get_userdata( get_field('manager_feedback', $todo->ID) );

                    $manager_name_display = "";
                    if(isset($manager->first_name) && isset($manager->last_name)) 
                        $manager_name_display = $manager->first_name . ' ' . $manager->last_name; 
                    else 
                        $manager_name_display = $manager->display_name;

                    if(!$manager_name_display)
                        $manager_name_display = "A manager";

                    $image = get_field('profile_img',  'user_' . $manager->ID);
                    if(!$image)
                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                
                ?>
                    <a href="/dashboard/user/detail-notification?todo=<?php echo $todo->ID; ?>" class="SousBlockNotification">
                        <div class="d-flex align-items-center">
                            <div class="circleNotification">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/notification 1.png" alt="">
                            </div>
                            <p class="feddBackNotification"><?= $manager_name_display; ?> sent you a  <span><?=$type;?></span></p>
                        </div>
                        <br>
                    <!-- div><p class="hoursText"></p></div> -->                    
                    </a>
                <?php
                    }
                ?>

                 <?php
                    }
                    else 
                        echo "empty until now";
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="cardNotification card-badge-notifications">
                <h2>The badges you have unlocked</h2>
                <div class="content-badges content-badge-notifications">
                    <a href="#" class="card">
                        <div class="block-icons">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/validate-badge.png" alt="">
                        </div>
                    <?php 
                        $strotime_date = strtotime($user->user_registered);
                        $date_registered = date("d M Y", $strotime_date);
                    ?>
                    <p class="title">You created a account sucessfully !</p>
                    <p class="awarded">Awarded for : <span> <?php echo $user->display_name ?> </span></p>
                    <p class="date-awarded"><span>Date Awarded : </span><?= $date_registered ?></p>
                    </a>
                    <!-- <a href="" class="card">
                        <div class="block-icons">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/dashicons_awards.png" alt="">
                        </div>
                        <p class="title">Complete and verified profile </p>
                        <p class="awarded">Awarded for : <span> Profil Livelearn </span></p>
                        <p class="date-awarded"><span>Date Awarded :</span> 06 Jul 2022</p>
                    </a>
                    <a href="" class="card">
                        <div class="block-icons">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/gg_awards.png" alt="">
                        </div>
                        <p class="title">Complete and verified profile </p>
                        <p class="awarded">Awarded for : <span> Profil Livelearn </span></p>
                        <p class="date-awarded"><span>Date Awarded :</span> 06 Jul 2022</p>
                    </a>
                    <a href="" class="card ">
                        <div class="card-lock">
                            <img class="img-card-lock" src="<?php echo get_stylesheet_directory_uri();?>/img/lock-2.png" alt="">
                        </div>
                        <div class="block-icons">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/validate-badge.png" alt="">
                        </div>
                        <p class="title">Complete and verified profile </p>
                        <p class="awarded">Awarded for : <span> Profil Livelearn </span></p>
                        <p class="date-awarded"><span>Date Awarded :</span> 06 Jul 2022</p>
                    </a> -->
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?php 
                if(!empty($courses)){
                    $company = get_field('company',  'user_' . $user->ID);
                    $company_id = $company[0]->ID;
                    $company_logo = (get_field('company_logo', $company_id)) ? get_field('company_logo', $company_id) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
                    ?>
                <div class="cardNotification card-badge-notifications">
                    <h2 class="text-title-certifications">Click on the button to see your certifications</h2>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-see" data-toggle="modal" data-target="#ModalCertificate">
                        See
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="ModalCertificate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <!-- <button class="btn btn-primary" class="html2PdfConverter" onclick="createPDF()">html to PDF </button> -->
                                <div class="modal-body" id="element-to-print">
                                    <div >
                                        <div class="Certificate">
                                            <div class="logo">
                                                <img src="<?= $company_logo ?>" alt="">
                                            </div>
                                            <p class="name-certifica">LIVELEARN AGENCY CORP</p>
                                            <p class="certificate-of-completion">Certificate of Expertise author
                                            <p class="trainees-name"><?= $user->display_name ?></p>
                                            <p class="description-certificate"> Congratulations !
                                            <br><span class="date-certificate">Your first published course is worthy of an expert level.</span>
                                            </p>
                                            <p class="topic-description">The subject is to create a course publicly accessible to all students with all the requirements of the platform</p>
                                            <p class="topic-details">Expert - Course</p>
                                            <div class="footer-certificate">
                                                <div>
                                                    <p class="title">Accredited by</p>
                                                    <img class="logo-company-certificate" src="<?php echo get_stylesheet_directory_uri();?>/img/Image49.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="title">Signed by</p>
                                                    <p class="sub-title">Daniel Van Der Kolk</p>
                                                </div>
                                                <!-- <div>
                                                    <p class="title">Date</p>
                                                    <p class="sub-title">04 / 05 / 2022</p>
                                                </div> -->
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            <?php 
                }
            ?>
        </div>
    </div>
    <div class="cardFavoriteCourses">
        <div class="d-flex aligncenter justify-content-between">
            <h2>Favoriete kennisproducten</h2>
            <input type="search" id="search_txt_course" placeholder="zoeken" class="inputSearchCourse">
        </div>
        <div class="globalCoursElement" id="autocomplete_company_course" >
            <?php 
            foreach($courses_favorite as $key => $course) {
                if($key == 6)
                    break;

                /*
                * Location
                */
                $location = 'Virtual';
                $data = get_field('data_locaties', $course->ID);
                if($data){
                    if($data[0]['data'][0]['location'])
                        $location = $data[0]['data'][0]['location'];
                }
                else{         
                    $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                    if($data[2])
                        $location = $data[2];
                }

                /*
                * Categories
                */
               
                $category = ' ';
                            
                $category_id = 0;
                $category_string = " ";

                $tree = get_the_terms($course->ID, 'course_category'); 
                    if($tree)
                        if(isset($tree[2]))
                            $category = $tree[2]->name;
                
                if($category == ' '){
                    $category_str = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]);
                    $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                    if($category_str != 0)
                        $category = (String)get_the_category_by_ID($category_str);
                    else if($category_id != 0)
                        $category = (String)get_the_category_by_ID($category_id);                                    
                }

                /*
                * Price
                */
                $p = get_field('price', $course->ID);
                if($p != "0")
                    $price =  number_format($p, 2, '.', ',');
                else
                    $price = 'Gratis';

                /*
                * Thumbnails
                */
                $thumbnail = get_field('preview', $course->ID)['url'];
                if(!$thumbnail){
                    $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                    if(!$thumbnail)
                        $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                }

            ?>
            <a href="<?php echo get_permalink($course->ID); ?>" class="coursElement">
                <div class="imgBlockCoursElement">
                    <img src="<?php echo $thumbnail; ?>" alt="">
                </div>
                <div class="detailTwoCoursElement">
                    <div class="d-block">
                        <div class="subDetailTwoCoursElement">
                            <p class="nameCours"><?php echo $course->post_title; ?></p>
                            <div class="d-flex">
                                <div class="d-flex mr-3">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/iconsMap.png" alt="">
                                    <p class="mapLocalisation"><?php echo $location; ?></p>
                                </div>
                                <div class="d-flex">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/moneyElement.png" alt="">
                                    <p class="mapLocalisation"><?php echo $price; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="tagElementBlock">
                            <p><?php echo $category; ?></p>
                        </div>
                    </div>
                    <div class="d-flex">
                       <!--  
                        <button class="btn btnViewCours">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/viewC.png" alt="">
                        </button> 
                        -->
                        <form action="" method="POST">
                            <input type="hidden" name="meta_value" value="<?=$course->ID;?>">
                            <button type="submit" name="delete_favorite" class="btn btnViewCours">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/trashC.png" alt="">
                            </button>
                        </form>
                    </div>
                </div>
            </a>
            <?php
                } 
            ?>
            
        </div>
            <center>
            <br> <br>
            <?php
                if($save_pages)
                    foreach (range(1, $save_pages) as $number){
                        if(isset($_GET['page1']))
                            if($_GET['page1'] == $number)
                                echo '<a href="?saved&page1=' .$number. '" style="color: #DB372C" class="textLiDashboard">'. $number .'&nbsp;</a>';
                            else
                                echo '<a href="?saved&page1=' .$number. '" class="textLiDashboard">'. $number .'&nbsp;</a>';
                        else
                            echo '<a href="?saved&page1=' .$number. '" class="textLiDashboard">'. $number .'&nbsp;</a>';
                    }
            ?>
            </center>
    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/html2pdf.js/0.9.1/html2pdf.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script>

<script>

    $('#search_txt_course').keyup(function(){
        var txt = $(this).val();

        $.ajax({

            url:"/fetch-company-course",
            method:"post",
            data:{
                search_user_course : txt,
            },
            dataType:"text",
            success: function(data){
                console.log(data);
                $('#autocomplete_company_course').html(data);
            }
        });

    });
</script>

<script>
         function createPDF() {
            var element = document.getElementById('element-to-print');
            html2pdf(element, {
                margin:1,
                padding:0,
                filename: 'certificat.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 1 },
                jsPDF: { unit: 'in', format: 'A4', orientation: 'P' ,'UTF-8', array(0, 0, 0, 0)},
                class: createPDF
            });
        };
    </script>


