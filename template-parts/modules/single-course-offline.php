<?php /** Template Name: Single offline course template */ ?>

<?php
global $post;
$product = wc_get_product( get_field('connected_product', $post->ID) );
$long_description = get_field('long_description', $post->ID);
$data = get_field('data_locaties', $post->ID);
    if(!$data){
        $data = get_field('data_locaties_xml', $post->ID);
        $xml_parse = true;
    }

    if(!isset($xml_parse)){
        if(!empty($data)){
            foreach($data as $datum) {
                $date_end = '';
                $date_start = '';
                $agenda_start = '';
                $agenda_end = '';
                if(!empty($datum['data'])) {
                    $date_start = $datum['data'][0]['start_date'];
                    if($date_start)
                        if(count($datum['data']) >= 1){
                            $date_end = $datum['data'][count($datum['data'])-1]['start_date'];
                            $agenda_start = explode('/', explode(' ', $date_start)[0])[0] . ' ' . $calendar[explode('/', explode(' ', $date_start)[0])[1]];
                            if($date_end)
                                $agenda_end = explode('/', explode(' ', $date_end)[0])[0] . ' ' . $calendar[explode('/', explode(' ', $date_end)[0])[1]];
                        }
                }

            }
        }
    }
    else
        if($data){
            $it = 0;
            foreach($data as $datum) {
                $infos = explode(';', $datum['value']);
                $number = count($infos)-1;
                $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];
                $date_start = explode(' ', $infos[0]);
                $date_end = explode(' ', $infos[$number]);
                $d_start = explode('/',$date_start[0]);
                $d_end = explode('/',$date_end[0]);
                $h_start = explode('-', $date[1])[0];
                $h_end = explode('-', $date_end[1])[0];
                $agenda_start = $d_start[0] . ' ' . $calendar[$d_start[1]];
                $agenda_end = $d_end[0] . ' ' . $calendar[$d_end[1]];
            }
        }

    if (isset($xml_parse))
    {
        $start=explode('/',$date_start[0]);
        $end=explode('/',$date_end[0]);
        //var_dump($date_start[0],$date_end[0]);
        $month_start = date('F', mktime(0, 0, 0, $start[1], 10));
        $month_end = date('F', mktime(0, 0, 0, $end[1], 10));
        $number_course_day=((strtotime($end[0].' '.$month_end.' '.$end[2]) - strtotime($start[0].' '.$month_start.' '.$start[2]))/86400);

    }
    else
    {
        $start=explode('/',$date_start);
        $end=explode('/',$date_end);
        $year_start=explode(' ',$start[2]);
        $year_end=explode(' ',$end[2]);
        //var_dump($date_start,$date_end);
        $month_start = date('F', mktime(0, 0, 0, $start[1], 10));
        $month_end = date('F', mktime(0, 0, 0, $end[1], 10));
        $number_course_day= ((strtotime($end[0].' '.$month_end.' '.$year_end[0]) - strtotime($start[0].' '.$month_start.' '.$year_start[0]))/86400);
    }

    if($number_course_day==0)
        $number_course_day=1;

/*
*  Date and Location
*/
$calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

$data = get_field('data_locaties', $post->ID);
$price = get_field('price', $post->ID) ?: 'Gratis';
$prijsvat = get_field('prijsvat', $post->ID);
$agenda = get_field('agenda', $post->ID);
$who = get_field('for_who', $post->ID);
$results = get_field('results', $post->ID);
$course_type = get_field('course_type', $post->ID);
$category = " ";
$tree = get_the_terms($post->ID, 'course_category');
if($tree)
    if(isset($tree[2])){
        $category = $tree[2]->name;
        $id_category = $tree[2]->ID;
    }

$category_id = 0;

if($category == ' '){
    $category_id = intval(explode(',', get_field('categories',  $post->ID)[0]['value'])[0]);
    $category_xml = intval(get_field('category_xml',  $post->ID)[0]['value']);
    if($category_xml)
        if($category_xml != 0){
            $id_category = $category_xml;
            $category = (String)get_the_category_by_ID($category_xml);
        }
    if($category_id)
        if($category_id != 0){
            $id_category = $category_id;
            $category = (String)get_the_category_by_ID($category_id);
        }
}

$user_id = get_current_user_id();
$image_author = get_field('profile_img',  'user_' . $post->post_author);
if(!$image_author)
    $image_author = get_stylesheet_directory_uri() ."/img/placeholder_user.png";

/*
* Companies
*/
$company = get_field('company',  'user_' . $post->post_author);

/*
* Experts
*/
$expert = get_field('experts', $post->ID);
$author = array($post->post_author);

$experts = array_merge($expert, $author);

/*
* Likes
*/
$favoured = count(get_field('favorited', $post->ID));
if(!$favoured)
    $favoured = 0;

/*
* Thumbnails
*/
$image = get_field('preview', $course->ID)['url'];
if(!$image){
    $image = get_field('url_image_xml', $course->ID);
    if(!$image)
        $image = "https://cdn.pixabay.com/photo/2021/09/18/12/40/pier-6635035_960_720.jpg";
}

$reviews = get_field('reviews', $post->ID);

?>

<style>
    a{
        text-decoration: none !important;
        color: black !important;
    }
    body{
        padding-top: 0 !important;
    }
    .bi-x-lg::before {
        top: -5px;
        position: relative;
    }
    .bi-search {
        font-size: 22px;
        top: -5px;
        position: relative;
    }
</style>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<!-- ---------------------------------------- Start modals ---------------------------------------------- -->
    <div class="modal fade" id="direct-contact" tabindex="-1" aria-labelledby="direct-contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-course">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="direct-contactModalLongTitle">Direct contact</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
        <div class="modal-body">
            <div class="d-flex justify-content-center">

                <div>
                    <a href="#" class="mx-3 d-flex flex-column ">
                        <i style="font-size: 50px; height: 49px; margin-top: -4px;"
                            class="fab fa-whatsapp text-success shadow rounded-circle border border-3 border-white "></i>
                    </a>
                    <div class="mt-3 text-center">
                        <span class="bd-highlight fw-bold text-success mt-2">whatsapp</span>
                    </div>
                </div>
                <div>
                    <a href="#" class="mx-3 d-flex flex-column ">
                        <i style="font-size: 25px"
                        class="fa fa-envelope bg-danger border border-3 border-danger rounded-circle p-2 text-white shadow"></i>
                        <!-- <span class="bd-highlight fw-bold text-primary mt-2">email</span> -->
                    </a>
                    <div class="mt-3 text-center">
                         <span class="bd-highlight fw-bold text-danger mt-5">email</span>
                    </div>
                </div>
                <div>
                    <a href="#" class="mx-3 d-flex flex-column ">
                        <i style="font-size: 25px" class="fa fa-comment text-secondary shadow p-2 rounded-circle border border-3 border-secondary"></i>
                    </a>
                    <div class="mt-3 text-center">
                         <span class="bd-highlight fw-bold text-secondary mt-5">message</span>
                    </div>
                </div>

                <div>
                    <a href="#" class="mx-3 d-flex flex-column ">
                        <i class="bd-highlight bi bi-telephone-x border border-3 border-primary rounded-circle text-primary shadow"
                        style="font-size: 20px; padding: 6px 11px;"></i>
                        <!-- <span class="bd-highlight fw-bold text-primary mt-2">call</span> -->
                    </a>
                    <div class="mt-3 text-center">
                         <span class="bd-highlight fw-bold text-primary mt-5">call</span>
                    </div>
                </div>

            </div>

        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div> -->
        </div>
    </div>
</div>

<div class="modal fade" id="incompany" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-course">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Incompany</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">

                <?php
                    echo do_shortcode("[gravityform id='5' title='false' description='false' ajax='true'] ");
                ?>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="offerte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-course">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Brochure</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
               <?php
                    echo do_shortcode("[gravityform id='6' title='false' description='false' ajax='true'] ");
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="voor-wie" tabindex="-1" aria-labelledby="voor-wieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-course">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voor-wieModalLongTitle"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="">
                    <!-- <img alt="course design_undrawn"
                     src="<?php echo get_stylesheet_directory_uri(); ?>/img/voorwie.png"> -->

                    <?php
                        $author = get_user_by('id', $post->post_author);
                    ?>
                    <div class="content-text p-4 pb-0">
                        <h4 class="text-dark">Voor wie ?</h4>
                        <p class="m-0"><strong>This course is followed up by <?php if(isset($author->first_name) && isset($author->last_name)) echo $author->first_name . '' . $author->last_name; else echo $author->display_name; ?> </strong></p>
                        <p><em>This line rendered as italicized text.</em></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ------------------------------------------ End modals ---------------------------------------------- -->


<div class="liveOverBlock">
    <div class="container-fluid">
        <div class="overElement">
            <div class="blockOneOver">
                <?php 
                if(isset($_GET["message"]))
                    echo "<span class='alert alert-info'>" . $_GET['message'] . "</span><br><br>";
                ?>

                <!-- ------------------------------ Start Title livelearn ---------------------------------- -->
                <div class="titleBlock">
                    <?php
                        if(!empty($company)){
                            $company_id = $company[0]->ID;
                            $company_title = $company[0]->post_title;
                            $company_logo = get_field('company_logo', $company_id);
                    ?>
                    <a href="/opleider-courses?companie=<?php echo $company_id ; ?>" class="roundBlack" >
                        <img width="28" src="<?php echo $company_logo ?>" alt="company logo">
                    </a>
                    <a href="/opleider-courses?companie=<?php echo $company_id ; ?>" class="livelearnText2 text-uppercase"><?php echo $company_title; ?></a>
                    <?php
                        }
                    ?>
                    <a href="category-overview?category=<?php echo $id_category ?>" class="bd-highlight ">
                            <button class="btn py-0 btnPhilo"> <span class="text-white"><?php echo $category; ?></span></button>
                    </a>
                </div>
                <!-- ------------------------------ End Title livelearn ---------------------------------- -->


                <p class="e-learningTitle"><?php echo $post->post_title;?></p>
                <!-- Image -->
                <div class="img-fluid-course">
                    <img src="<?=$image?>" alt="">
                </div>


                <p class="beschiBlockText">Beschikbaarheid en prijs</p>

                <!-- -------------------------------------- Start Icons row ------------------------------------->
                <div class="d-flex elementcourseIcone sousBlock mx-md-2 mx-sm-2 text-center">
                    <div class="d-flex flex-row block1">
                        <div class="d-flex flex-column mx-md-3 mx-2">
                            <input type="hidden" id="user_id" value="<?php echo $user_id; ?>">
                            <input type="hidden" id="course_id" value="<?php echo $post->ID; ?>">
                            <!-- <img class="iconeCours" src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt=""> -->
                            <button id="btn_favorite" style="background:white; border:none"><i class="far fa-heart" style="font-size: 25px;"></i></button>
                            <span class="textIconeLearning mt-1" id="autocomplete_favoured"><?php echo $favoured; ?></span>
                        </div>
                        <div class="d-flex flex-column mx-md-3 mx-2">
                            <i class="fas fa-calendar-alt" style="font-size: 25px;"></i>
                            <span class="textIconeLearning mt-1"><?= $number_course_day." dagdeel" ?></span>
                        </div>
                        <div class="d-flex flex-column mx-md-3 mx-2">
                            <i class="fas fa-graduation-cap" style="font-size: 25px;"></i>
                            <span class="textIconeLearning mt-1"><?php if($course_type) echo $course_type; else echo "Undefined"; ?></span>
                        </div>
                    </div>
                    <div class="d-flex flex-row block2">
                        <div class="d-flex flex-column mx-md-3 mx-2">
                            <form action="../../dashboard/user/" method="POST">
                                <input type="hidden" name="meta_value" value="<?php echo $post->ID; ?>" id="">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" id="">
                                <input type="hidden" name="meta_key" value="course" id="">
                                <?php
                                if($user_id != $post->post_author && $user_id != 0)
                                    echo "
                                        <button type='submit' class='' name='interest_save' style='border:none; background:white'> 
                                            <i class='fas fa-bell' style='font-size: 25px;'></i><br>
                                            <span class='textIconeLearning mt-1'>Bewaar</span>
                                        </button>
                                        ";
                                ?>
                            </form>
                            <?php
                            if($user_id == 0)
                                echo "
                                <button data-toggle='modal' data-target='#SignInWithEmail'  aria-label='Close' data-dismiss='modal' type='submit' class='' style='border:none; background:white'> 
                                    <i class='fas fa-bell' style='font-size: 25px;'></i><br>
                                    <span class='textIconeLearning mt-1'>Bewaar</spanz>
                                </button>
                                ";
                            ?>
                        </div>
                        <div class="d-flex flex-column mx-md-3 mx-2">
                            <button class="btn iconeText open-modal" data-open="modal1">
                                <i class="fa fa-share" style="font-size: 25px;"></i><br>
                                <span class="textIconeLearning mt-1">Deel</span>
                            </button>
                        </div>
                        <!-- début Modal deel -->
                        <div class="modal" id="modal1" data-animation="fadeIn">
                            <div class="modal-dialog modal-dialog-course modal-dialog modal-dialog-course-deel" role="document">
                                <div class="modal-content">
                                    <div class="tab">
                                        <button class="tablinks btn active" onclick="openCity(event, 'Extern')">Extern</button>
                                        <hr class="hrModifeDeel">
                                        <?php
                                       if ($user_id==0)
                                       {
                                        ?>
                                        <button class="tablinks btn" onclick="openCity(event, 'Intern')">Intern</button>
                                        <?php

                                        }
                                        ?>
                                    </div>
                                    <div id="Extern" class="tabcontent">
                                    <div class="contentElementPartage">
                                        <button id="whatsapp"  class="btn contentIcone">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/whatsapp.png" alt="">
                                        </button>
                                        <p class="titleIcone">WhatsApp</p>
                                    </div>
                                    <div class="contentElementPartage">
                                        <button class="btn contentIcone">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/facebook.png" alt="">
                                        </button>
                                        <p class="titleIcone">Facebook</p>
                                    </div>
                                    <div class="contentElementPartage">
                                        <button class="btn contentIcone">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/insta.png" alt="">
                                        </button>
                                        <p class="titleIcone">Instagram</p>
                                    </div>
                                    <div class="contentElementPartage">
                                        <button id="linkedin" class="btn contentIcone">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/linkedin.png" alt="">
                                        </button>
                                        <p class="titleIcone">Linkedin</p>
                                    </div>
                                    <div class="contentElementPartage">
                                        <button id="sms" class="btn contentIcone">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sms.png" alt="">
                                        </button>
                                        <p class="titleIcone">Sms</p>
                                    </div>
                                        <div>
                                            <p class="klikText">Klik om link te kopieren</p>
                                            <div class="input-group input-group-copy formCopyLink">
                                                <input id="test1" type="text" class="linkTextCopy form-control" value="<?php echo get_permalink($post->ID) ?>" readonly>
                                                <span class="input-group-btn">
                                                <button class="btn btn-default btnCopy">Copy</button>
                                                </span>
                                                <span class="linkCopied">link copied</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                       if ($user_id==0)
                                       {
                                        ?>
                                        <div id='Intern' class='tabcontent px-md-5 p-3'>
                                        <?php
                                        wp_login_form([
                                                'redirect' => 'http://wp12.influid.nl/dashboard/user/',
                                                'remember' => false,
                                                'label_username' => 'Wat is je e-mailadres?',
                                                'placeholder_email' => 'E-mailadress',
                                                'label_password' => 'Wat is je wachtwoord?'
                                        ]);
                                        ?>
                                            </div>
                                            <?php
                                       }
                                            ?>
                                </div>
                            </div>
                        </div>
                        <!-- fin Modal deel -->
                    </div>
                </div>
                <!-- -------------------------------------- End Icons row ------------------------------------->


                <!--------------------------------------- start Text description -------------------------------------- -->
                <div class="blockTextGlovale mt-3">
                    <div class="text-limit">
                        <?php echo $long_description; ?>

                        <div class="moreText">
                           <?php
                                if($agenda){
                                    ?>
                                    <h6 class="textDirect p-0 mt-3" style="text-align: left"><b>Agenda :</b></h6>
                                    <span> <?php echo $agenda; ?> </span>
                                    <?php
                                }

                                if($who){
                                    ?>
                                    <h6 class="textDirect mt-3" style="text-align: left"><b>For who :</b></h6>
                                    </span> <?php echo $who; ?> </span>
                                    <?php
                                }

                                if($results){
                                    ?>
                                    <h6 class="textDirect p-0 mt-3" style="text-align: left"><b>Results :</b></h6>
                                    <span > <?php echo $results; ?> </span>
                                    <?php
                                }
                            ?>
                        </div>
                       <br>

                   </div>
                    <?php 
                        if($long_description || $agenda || $who || $results ) 
                            echo '<button type="button" class="btn btn-lg lees_alles my-4 w-md-25 px-4 border border-1 border-dark read-more-btn">Lees alles</button>';
                        else 
                            echo '<h6 class="textDirect p-0 mt-3" style="text-align: left"><b>Leeg tot nu toe ...</b></h6>';
                    ?>
                </div>
                <!--------------------------------------- end Text description -------------------------------------- -->

                <div class="customTabs">
                    <div class="tabs">
                        <ul id="tabs-nav">
                            <li><a href="#tab1">Evens</a></li>
                            <li><a href="#tab2">Reviews</a></li>
                            <li><a href="#tab3">Add Reviews</a></li>
                        </ul> <!-- END tabs-nav -->
                        <div id="tabs-content">
                            <div id="tab1" class="tab-content">
                                <?php

                                $data = get_field('data_locaties', $post->ID);
                                if(!$data){
                                    $data = get_field('data_locaties_xml', $post->ID);
                                    $xml_parse = true;
                                }

                                if(!isset($xml_parse)){
                                    if(!empty($data)){
                                        foreach($data as $datum) {
                                            $date_end = '';
                                            $date_start = '';
                                            $agenda_start = '';
                                            $agenda_end = '';
                                            if(!empty($datum['data'])){
                                                $date_start = $datum['data'][0]['start_date'];
                                                if($date_start)
                                                    if(count($datum['data']) >= 1){
                                                        $date_end = $datum['data'][count($datum['data'])-1]['start_date'];
                                                        $agenda_start = explode('/', explode(' ', $date_start)[0])[0] . ' ' . $calendar[explode('/', explode(' ', $date_start)[0])[1]];
                                                        if($date_end)
                                                            $agenda_end = explode('/', explode(' ', $date_end)[0])[0] . ' ' . $calendar[explode('/', explode(' ', $date_end)[0])[1]];
                                                    }
                                            }

                                            if(!empty($datum['data'])){
                                                ?>
                                                <a id="bookdates" name="bookdates"></a>

                                                <!-------------------------------------------- Start cards on bottom --------------------------- -->
                                                <div class="block2evens">
                                                    <div class="CardBlockEvenement">

                                                        <div class="dateBlock">
                                                            <p class="dateText1"><?php
                                                                echo $agenda_start;
                                                                if($date_start != '' && $date_end != '')
                                                                {
                                                                    echo ' - ';
                                                                    echo $agenda_end;
                                                                }
                                                                ?>
                                                            </p>
                                                            <p class="inclusiefText">Beschrijving van de verschillende data voor deze cursus en de bijbehorende plaats</p>
                                                            <a href="" class="btn btnZetAjenda">Zet in je agenda <img src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-calendar-plus.png" alt=""></a>
                                                        </div>
                                                        <div class="BlocknumberEvenement">

                                                            <?php

                                                            for($i = 0; $i < count($datum['data']); $i++) {
                                                                $date_start = $datum['data'][$i]['start_date'];
                                                                $location = $datum['data'][$i]['location'];
                                                                if($date_start != null) {
                                                                    $day = explode('/', explode(' ', $date_start)[0])[0] . ' ' . $calendar[explode('/', explode(' ', $date_start)[0])[1]];
                                                                    $hour = explode(' ', $date_start)[1];

                                                                    ?>
                                                                    <?php if($i === 0){?>
                                                                        <input type="hidden" data-attr="dateNameStart" value="<?php echo $day . ', ' . $hour . ', ' . $location  ?>">
                                                                    <?php }?>
                                                                    <div class="d-flex">
                                                                        <p class="numberEvens"><?php echo $i+1 ?></p>
                                                                        <p class="dateEvens"><?php echo $day . ', ' . $hour . ', ' . $location  ?></p>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>

                                                        <div class="blockPriceEvens">
                                                            <p class="prixEvens">€ <?php echo $price; ?></p>
                                                            <p class="exText">Ex BTW</p>
                                                            <div class="product-attr">


                                                            </div>
                                                            <div class="contentBtnCardProduct">
                                                                <!-- <a href="" class="btn btnReserveer">Reserveer<br><br></a> -->
                                                                <!-- <a href="" class="btn btnSchrijf">Schrijf mij in!</a> -->
                                                                <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
                                                                <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                                                                    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
                                                                    <?php
                                                                    do_action( 'woocommerce_before_add_to_cart_quantity' );

                                                                    woocommerce_quantity_input(
                                                                        array(
                                                                            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                                                                            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                                                                            'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                                                                        )
                                                                    );

                                                                    do_action( 'woocommerce_after_add_to_cart_quantity' );

                                                                    if($user_id != 0 && $user_id != $post->post_author){
                                                                        ?>
                                                                        <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt">Reserveren</button>

                                                                    <?php }
                                                                    do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                                                                </form>

                                                                <?php
                                                                if($user_id == 0)
                                                                    echo "<button data-toggle='modal' data-target='#SignInWithEmail' aria-label='Close' data-dismiss='modal' class='single_add_to_cart_button button alt'>Reserveren</button>";
                                                                do_action( 'woocommerce_after_add_to_cart_form' ); ?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <!-------------------------------------------- End cards on bottom --------------------------- -->


                                                <?php
                                            }

                                        }
                                    }
                                }else{
                                    if($data){
                                        $it = 0;
                                        foreach($data as $datum){
                                            $infos = explode(';', $datum['value']);
                                            $number = count($infos)-1;
                                            $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];
                                            $date_start = explode(' ', $infos[0]);
                                            $date_end = explode(' ', $infos[$number]);
                                            $d_start = explode('/',$date_start[0]);
                                            $d_end = explode('/',$date_end[0]);
                                            $h_start = explode('-', $date[1])[0];
                                            $h_end = explode('-', $date_end[1])[0];
                                            $agenda_start = $d_start[0] . ' ' . $calendar[$d_start[1]];
                                            $agenda_end = $d_end[0] . ' ' . $calendar[$d_end[1]];
                                            ?>
                                            <a id="bookdates" name="bookdates"></a>
                                            <div class="block2evens">
                                                <div class="CardBlockEvenement">

                                                    <div class="dateBlock">
                                                        <p class="dateText1"><?php
                                                            echo $agenda_start;
                                                            if($date_start != $date_end)
                                                            {
                                                                echo ' - ';
                                                                echo $agenda_end;
                                                            }
                                                            ?>
                                                        </p>
                                                        <p class="inclusiefText">Beschrijving van de verschillende data voor deze cursus en de bijbehorende plaats</p>
                                                        <a href="" class="btn btnZetAjenda">Zet in je agenda <img src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-calendar-plus.png" alt=""></a>
                                                    </div>
                                                    <div class="BlocknumberEvenement">

                                                        <?php
                                                        if(!empty($infos))
                                                            $x = 0;
                                                        foreach($infos as $key=>$info) {
                                                            $date = explode(' ', $info);
                                                            $d = explode('/',$date[0]);
                                                            $day = $d[0] . ' ' . $calendar[$d[1]];
                                                            $hour = explode(':', explode('-', $date[1])[0])[0] .':'. explode(':', explode('-', $date[1])[0])[1];
                                                            $location = explode('-',$date[2])[1];
                                                            ?>
                                                            <?php if($x === 0){?>
                                                                <input type="hidden" data-attr="dateNameStart" value="<?php echo $day . ', ' . $hour . ', ' . $location  ?>">
                                                            <?php }?>
                                                            <div class="d-flex">
                                                                <p class="numberEvens"><?php echo $x+1 ?></p>
                                                                <p class="dateEvens"><?php echo $day . ', ' . $hour . ', ' . $location  ?></p>
                                                            </div>
                                                            <?php
                                                            $x+=1;
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="blockPriceEvens">
                                                        <p class="prixEvens">€ <?php echo $price; ?></p>
                                                        <p class="exText">Ex BTW</p>
                                                        <div class="product-attr">


                                                        </div>
                                                        <div class="contentBtnCardProduct">
                                                            <!-- <a href="" class="btn btnReserveer">Reserveer<br><br></a> -->
                                                            <!-- <a href="" class="btn btnSchrijf">Schrijf mij in!</a> -->
                                                            <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

                                                            <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                                                                <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
                                                                <?php
                                                                do_action( 'woocommerce_before_add_to_cart_quantity' );

                                                                woocommerce_quantity_input(
                                                                    array(
                                                                        'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                                                                        'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                                                                        'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                                                                    )
                                                                );

                                                                do_action( 'woocommerce_after_add_to_cart_quantity' );
                                                                if($user_id != 0 && $user_id != $post->post_author){
                                                                    ?>
                                                                    <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt">Reserveren</button>

                                                                <?php }

                                                                do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                                                            </form>


                                                            <?php
                                                            if($user_id == 0)
                                                                echo "<button data-toggle='modal' data-target='#SignInWithEmail' aria-label='Close' data-dismiss='modal' class='single_add_to_cart_button button alt'>Reserveren</button>";

                                                            do_action( 'woocommerce_after_add_to_cart_form' ); ?>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php
                                            $it++;
                                            if($it == 4)
                                                break;
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div id="tab2" class="tab-content">
                                <?php
                                if(!empty($reviews)){
                                    foreach($reviews as $review){
                                    ?>
                                    <div class="review-info-card">
                                        <div class="review-user-mini-profile">
                                            <div class="user-photo">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/user.png" alt="">
                                            </div>
                                            <div class="user-name">
                                                <p><?= $review['name']; ?></p>
                                                <div class="rating-element">
                                                    <div class="rating-stats">
                                                        <div id="rating-container-custom">
                                                            <ul class="list-show">
                                                                <li class="disabled"></li>
                                                                <li class="disabled"></li>
                                                                <li class="disabled"></li>
                                                                <li class="disabled"></li>
                                                                <li class="disabled"></li>
                                                            </ul>
                                                        </div>
                                                        <!-- <p class="hours-element">18 hours ago</p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="reviewsText"><?= $review['feedback']; ?></p>

                                    </div>
                                <?php
                                    }
                                }
                                else 
                                    echo "<h6>No reviews for this course ...</h6>";
                                ?>
                            </div>
                            <div id="tab3" class="tab-content">
                                <form action="../../dashboard/user/" method="POST">
                                    <input type="hidden" name="course_id" value="<?= $post->ID; ?>">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="name">Name</label>
                                            <input type="text" name="fullname" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Name" required>
                                        </div>
                                        <div class="form- col-6">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" name="email_adress" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
                                            <small id="exampleInputEmail1" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                        </div>
                                    </div>
                                    <!--<div class="form-group">
                                        <label for="rating-container-custom">Rating</label>
                                        <div id="rating-container-custom">
                                            <ul class="list">
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                            </ul>
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="">Feedback</label>
                                        <textarea name="feedback_content" rows="10"></textarea>
                                    </div>
                                    <input type='submit' class='btn btn-sendRating' name='review_post' value='Send'>
                                </form>
                            </div>
                        </div> <!-- END tabs-content -->
                    </div> <!-- END tabs -->
                </div>
            </div>

            <!-- -----------------------------------Start Modal Sign In ----------------------------------------------- -->

            <!-- Modal Sign End -->
            <div class="modal modalEcosyteme fade" id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                style="position: absolute; ">
                <div class="modal-dialog modal-dialog-course" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Sign In</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body  px-md-5 p-3">
                            <?php
                                echo (do_shortcode('[user_registration_form id="59"]'));
                            ?>

                            <div class="text-center">
                                <p>Already a member? <a href="" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                        data-toggle="modal" data-target="#exampleModalCenter">Sign up</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -------------------------------------------------- End Modal Sign In-------------------------------------- -->

            <!-- -------------------------------------- Start Modal Sign Up ----------------------------------------------- -->
            <div class="modal modalEcosyteme fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                style="position: absolute; ">
                <div class="modal-dialog modal-dialog-course" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Sign Up</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body  px-md-5 p-3">
                            <?php
                            wp_login_form([
                                'redirect' => 'http://wp12.influid.nl/dashboard/user/',
                                'remember' => false,
                                'label_username' => 'Wat is je e-mailadres?',
                                'placeholder_email' => 'E-mailadress',
                                'label_password' => 'Wat is je wachtwoord?'
                            ]);
                            ?>
                            <div class="text-center">
                                <p>Not an account? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                    data-toggle="modal" data-target="#SignInWithEmail">Sign in</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -------------------------------------------------- End Modal Sign Up-------------------------------------- -->

        <!-- ----------------------------------- Right side: small dashboard ------------------------------------- -->
        <div class="blockTwoOver">
            <div class="btnGrou10">
                <a href="" class="btnContact" data-bs-toggle="modal" data-bs-target="#direct-contact">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/phone.png" alt="">
                    Direct contact
                </a>
                <a href="" class="btnContact" data-bs-toggle="modal" data-bs-target="#incompany">
                    <i class="fas fa-house-damage px-2" style="font-size: 20px"></i>
                    Incompany
                </a>
                <a href="" class="btnContact" data-bs-toggle="modal" data-bs-target="#offerte">
                    <i class="fab fa-buffer px-2" style="font-size: 20px"></i>
                    Brochure
                </a>
                <a href="" class="btnContact" data-bs-toggle="modal" data-bs-target="#voor-wie">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/question.png" alt="">
                    Voor wie
                </a>
            </div>

            <div class="CardpriceLive">
                <?php
                    if(!empty($company))
                    {
                        $company_id = $company[0]->ID;
                        $company_title = $company[0]->post_title;
                        $company_logo = get_field('company_logo', $company_id);
                ?>
                    <div href="/opleider-courses?companie=<?php echo $company_id ; ?>"  class="imgCardPrice">
                    <a href="/opleider-courses?companie=<?php echo $company_id ; ?>" ><img src="<?php echo $company_logo; ?>" alt="company logo"></a>
                    </div>
                    <a href="/opleider-courses?companie=<?php echo $company_id ; ?>" class="liveTextCadPrice h5"><?php echo $company_title; ?></a>

                <?php
                    }
                ?>
                <form action="/dashboard/user/" method="POST">
                    <input type="hidden" name="meta_value" value="<?php echo $post->post_author ?>" id="">
                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>" id="">
                    <input type="hidden" name="meta_key" value="expert" id="">
                    <?php
                    if($user_id != 0 && $user_id != $post->post_author)
                        echo "<input type='submit' class='btnLeerom' style='border:none' name='interest_push' value='+ Leeromgeving'>";
                    ?>
                </form>
                <?php
                if($user_id == 0 )
                    echo "<button data-toggle='modal' data-target='#SignInWithEmail'  data-dismiss='modal'class='btnLeerom' style='border:none'> + Leeromgeving </button>";
                ?>


                <!-- <div class="p-1">
                     <button class="btn px-3 py-2 btnPhilo m-0" style="background-color: #00A89D !important;">
                     <i class="fas fa-plus text-white p-0" style="font-size: 15px;"></i>
                          <span class="text-white" style="font-size: 17px">Direct contact</span>
                    </button>
                </div> -->

                <?php
                    $data = get_field('data_locaties', $course->ID);
                    if($data)
                        $location = $data[0]['data'][0]['location'];
                    else{
                        $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                        $location = $data[2];
                    }
                ?>

                <p class="PrisText">Locaties</p>
                <p class="opeleidingText"><?php echo $location; ?></p>

                <p class="PrisText">Prijs vanaf</p>
                <p class="opeleidingText">Opleiding: € <?php echo $price ?></p>
                <p class="btwText">BTW: € <?php echo $prijsvat ?></p>
                <p class="btwText">LIFT member korting: 28%</p>


                <button href="#bookdates" class="btn btnKoop text-white PrisText" style="background: #043356">Koop deze <?php echo $course_type; ?></button>
            </div>

            <div class="col-12 my-5" style="background-color: #E0EFF4">
                <div class="btn-icon rounded-2 p-3 text-center d-flex justify-content-md-around
                justify-content-center">

                    <!-- --------------------------------------- Swiper ------------------------------------ -->
                    <!-- Slider main container -->
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php
                                foreach($experts as $expert){
                                    $expert = get_users(array('include'=> $expert))[0]->data;
                                    $company = get_field('company',  'user_' . $expert->ID);
                                    $title = $company[0]->post_title;
                                    $image = get_field('profile_img', $expert->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                ?>
                                <a href="user-overview?id=<?php echo $expert->ID; ?>" class="swiper-slide">
                                    <div class="my-2 d-flex flex-column mx-md-0 mx-1">
                                        <div class="imgCardPrice" style="height: 50px; width:50px">
                                            <img src="<?php echo $image; ?>" alt="teacher photo">
                                        </div>
                                        <span class="textIconeLearning"><?php if(isset($expert->first_name) && isset($expert->last_name)) echo $expert->first_name . '' . $expert->last_name; else echo $expert->display_name; ?></span>
                                        <span><?php echo $title; ?></span>
                                    </div>
                                </a>
                             <?php } ?>

                            </div>

                        </div>

                        <!-- If we need pagination -->
                        <!-- <div class="swiper-pagination"></div> -->

                        <!-- If we need navigation buttons -->
                        <div class="swiper-button-prev swiper-moved" style="font-size: 8px !important">
                        </div>
                        <div class="test">
                            <div class="swiper-button-next swiper-moved"></div>
                        </div>

                        <!-- If we need scrollbar -->
                        <!-- <div class="swiper-scrollbar"></div> -->
                    </div>

                </div>
            </div>

        </div>





    </div>


        <!-- début Modal deel -->
        <div class="modal" id="modal1" data-animation="fadeIn">
        <div class="modal-dialog modal-dialog-course modal-dialog modal-dialog-course-deel" role="document">
            <div class="modal-content">
                <div class="tab">
                    <button class="tablinks btn active" onclick="openCity(event, 'Extern')">Extern</button>
                    <hr class="hrModifeDeel">
                    <?php
                    if ($user_id==0)
                        {
                    ?>
                    <button class="tablinks btn" onclick="openCity(event, 'Intern')">Intern</button>
                    <?php
                        }
                    ?>
                </div>
                <div id="Extern" class="tabcontent">
                <div class="contentElementPartage">
                    <button id="whatsapp"  class="btn contentIcone">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/whatsapp.png" alt="">
                    </button>
                    <p class="titleIcone">WhatsAppp</p>
                </div>
                <div class="contentElementPartage">
                    <button class="btn contentIcone">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/facebook.png" alt="">
                    </button>
                    <p class="titleIcone">Facebook</p>
                </div>
                <div class="contentElementPartage">
                    <button class="btn contentIcone">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/insta.png" alt="">
                    </button>
                    <p class="titleIcone">Instagram</p>
                </div>
                <div class="contentElementPartage">
                    <button id="linkedin" class="btn contentIcone">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/linkedin.png" alt="">
                    </button>
                    <p class="titleIcone">Linkedin</p>
                </div>
                <div class="contentElementPartage">
                    <button id="sms" class="btn contentIcone">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sms.png" alt="">
                    </button>
                    <p class="titleIcone">Sms</p>
                </div>
                    <div>
                        <p class="klikText">Klik om link te kopieren</p>
                        <div class="input-group input-group-copy formCopyLink">
                            <input id="test1" type="text" class="linkTextCopy form-control" value="https://g.co/kgs/K1k9oA" readonly>
                            <span class="input-group-btn">
                            <button class="btn btn-default btnCopy">Copy</button>
                            </span>
                            <span class="linkCopied">link copied</span>
                        </div>
                    </div>
                </div>
                <?php
                    if ($user_id==0)
                    {
                ?>
                    <div id="Intern" class="tabcontent">
                        <form action="" class="formShare">
                            <input type="text" placeholder="Gebruikersnaam">
                            <input type="text" placeholder="Wachtwoord">
                            <button class="btn btnLoginModife">Log-in</button>
                        </form>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- fin Modal deel -->


</div>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
    $("#btn_favorite").click((e)=>
    {
        $(e.preventDefault());
        var user_id =$("#user_id").val();
        var id =$("#course_id").val();

        $.ajax({

            url:"/like",
            method:"post",
            data:{
                id:id,
                user_id:user_id,
            },
            dataType:"text",
            success: function(data){
                console.log(data);
                $('#autocomplete_favoured').html(data);
            }
        });
    })
</script>
    <script>
        // Rating
        const list = document.querySelector('.list')
        const lis = list.children;

        for (var i = 0; i < lis.length; i++) {
            lis[i].id = i;
            lis[i].addEventListener('mouseenter', handleEnter);
            lis[i].addEventListener('mouseleave', handleLeave);
            lis[i].addEventListener('click', handleClick);
        }

        function handleEnter(e) {
            e.target.classList.add('hover');
            for (var i = 0; i <= e.target.id; i++) {
                lis[i].classList.add('hover');
            }
        }

        function handleLeave(e) {
            [...lis].forEach(item => {
                item.classList.remove('hover');
            });
        }

        function handleClick(e){
            [...lis].forEach((item,i) => {
                item.classList.remove('selected');
                if(i <= e.target.id){
                    item.classList.add('selected');
                }
            });
        }

    </script>


<script>

    const swiper = new Swiper('.swiper', {
        // Optional parameters
        // direction: 'vertical',
        // loop: true,

        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        // And if we need scrollbar
        scrollbar: {
            el: '.swiper-scrollbar',
        },
    });


</script>
<script>
    const openEls = document.querySelectorAll("[data-open]");
    const closeEls = document.querySelectorAll("[data-close]");
    const isVisible = "is-visible";

    for (const el of openEls) {
        el.addEventListener("click", function() {
            const modalId = this.dataset.open;
            document.getElementById(modalId).classList.add(isVisible);
        });
    }

    for (const el of closeEls) {
        el.addEventListener("click", function() {
            this.parentElement.parentElement.parentElement.classList.remove(isVisible);
        });
    }

    document.addEventListener("click", e => {
        if (e.target == document.querySelector(".modal.is-visible")) {
            document.querySelector(".modal.is-visible").classList.remove(isVisible);
        }
    });

    document.addEventListener("keyup", e => {
        // if we press the ESC
        if (e.key == "Escape" && document.querySelector(".modal.is-visible")) {
            document.querySelector(".modal.is-visible").classList.remove(isVisible);
        }
    });

</script>

<!-- script for Tabs-->
<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // see more text ----course offline and online ------------------ //
    const readMoreBtn = document.querySelector('.read-more-btn');
    const text = document.querySelector('.text-limit');

    readMoreBtn.addEventListener('click', (e) => {
    //    alert('test');
        text.classList.toggle('show-more'); // add show more class
        if(readMoreBtn.innerText === 'Lees alles') {
            readMoreBtn.innerText = "Lees minder";
        } else {
            readMoreBtn.innerText = "Lees alles";
        }
    }) ;

</script>

<!-- script for Copy Link-->
<script>
    var inputCopyGroups = document.querySelectorAll('.input-group-copy');

    for (var i = 0; i < inputCopyGroups.length; i++) {
        var _this = inputCopyGroups[i];
        var btn = _this.getElementsByClassName('btn')[0];
        var input = _this.getElementsByClassName('form-control')[0];

        input.addEventListener('click', function(e) {
            this.select();
        });
        btn.addEventListener('click', function(e) {
            var input = this.parentNode.parentNode.getElementsByClassName('form-control')[0];
            input.select();
            try {
                var success = document.execCommand('copy');
                console.log('Copying ' + (success ? 'Succeeded' : 'Failed'));
            } catch (err) {
                console.log('Copying failed');
            }
        });
    }

</script>

<?php get_footer(); ?>
<?php wp_footer(); ?>