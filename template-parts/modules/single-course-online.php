<?php

extract($_GET);

$long_description = get_field('long_description', $post->ID);

$course_type = get_field('course_type', $post->ID);

$price = get_field('price', $post->ID);
$prijsvat = get_field('prijsvat', $post->ID);
    
$category = "<i class='fa fa-exclamation'></i>";

/*
* Thumbnails
*/
$thumbnail = get_field('preview', $post->ID)['url']; 
if(!$thumbnail){
    $thumbnail = get_field('url_image_xml', $post->ID);
    if(!$thumbnail)
        $thumbnail = "https://cdn.pixabay.com/photo/2021/09/18/12/40/pier-6635035_960_720.jpg";
}
$category = " ";

$tree = get_the_terms($post->ID, 'course_category'); 

if($tree)
    if(isset($tree[2]))
        $category = $tree[2]->name;

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


/*
* Companies
*/ 
$company = get_field('company',  'user_' . $post->post_author);

$photo_daniel = get_stylesheet_directory_uri() . '/img/daniel.png';

/*
* Experts
*/
$expert = get_field('experts', $post->ID);
$author = array($post->post_author);
$experts = array_merge($expert, $author);

$favoured = count(get_field('favorited', $post->ID));

$duration_day = get_field('duration_day', $post->ID);

$attachments_xml = get_field('attachment_xml', $post->ID);

$reviews = get_field('reviews', $post->ID);

?>

<style>
    .swiper {
        width: 600px;
    }
    .swiper-moved{
        color: #023356 !important;
        font-size: 12px;
    }
     /* ------------------- Show more Text -------------- */
    .text-limit p,.text-limit .moreText{
        display:none;
    }
    .text-limit p:first-child, .text-limit{
        display:block;
         overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 5; /** number of line to display! */
        -webkit-box-orient: vertical;   
    }
    .text-limit.show-more .moreText, .text-limit.show-more p, .text-limit.show-more {
        display: block;
    }
    .lees_alles:hover {
        color: #fff;
        background-color: #023356;
    }
    .bi-search {
        font-size: 22px;
        top: -5px;
        position: relative;
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<div class="liveOverBlock">
    <div class="container-fluid">
        <div class="overElement">
            <div class="blockOneOver">
                  <?php 
                  if(isset($_GET["message"]))
                    echo "<span class='alert alert-infos'>" . $_GET['message'] . "</span>";
                  ?>
                  <!-- ------------------------------ Start Title livelearn ---------------------------------- -->
                  <div class="titleBlock">
                  <?php
                        if(!empty($company)){
                            $company_id = $company[0]->ID;
                            $company_title = $company[0]->post_title;
                            $company_logo = get_field('company_logo', $company_id);
                    ?>
                    <a href="/opleider-courses?companie=<?php echo $company_id ; ?>" class="roundBlack">
                        <img width="28" src="<?php echo $company_logo ?>" alt="company logo">
                    </a>
                    <a href="/opleider-courses?companie=<?php echo $company_id ; ?>" class="livelearnText2 text-uppercase"><?php echo $company_title; ?></a>
                    <?php
                        }
                    ?>
                    <a href="category-overview?category=<?php echo $id_category ?>"class="bd-highlight ">
                            <button class="btn py-0 btnPhilo"> <span class="text-white"><?php echo $category; ?></span></button>
                    </a>
                 </div>
                 <!-- ------------------------------ End Title livelearn ---------------------------------- -->

                <p class="e-learningTitle"><?php echo $post->post_title;?></p>
                <div class="blockImgCour">
                    <?php 
                     
                    if(!empty($courses) && !empty($youtube_videos) ){
                        if(!empty(get_field('preview', $post->ID)))
                            echo "<img src='" . get_field('preview', $post->ID)['url'] . "' alt='preview img'>";
                        else
                            echo "<img src='" . $thumbnail . "' alt='thumbnail placeholder'>";
                    }else{
                        if(!empty($courses)){
                            if(isset($topic) && isset($lesson))
                                echo " <video class='blockImgCour' poster='' controls>
                                            <source src='" . $courses[$topic]['course_topic']['course_topic_lessons'][$lesson]['course_lesson']['course_lesson_data'] . "' type='video/mp4;charset=UTF-8' />
                                            <source src='" . $courses[$topic]['course_topic']['course_topic_lessons'][$lesson]['course_lesson']['course_lesson_data'] . "' type='video/webm; codecs='vp8, vorbis'' />
                                            <source src='" . $courses[$topic]['course_topic']['course_topic_lessons'][$lesson]['course_lesson']['course_lesson_data'] . "' type='video/ogg; codecs='theora, vorbis'' />
                                        </video>";
                            else
                                if(!empty(get_field('preview', $post->ID)))
                                    echo "<img src='" . get_field('preview', $post->ID)['url'] . "' alt='preview img'>";
                                else
                                    echo "<img src='" . $thumbnail . "' alt='thumbnail placeholder'>"; 
                        }
                        else{
                            if(isset($lesson))
                                echo '<iframe width="730" height="433" src="https://www.youtube.com/embed/' . $youtube_videos[$lesson]['id'] .'" title="' . $youtube_videos[$lesson]['title'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                            else 
                                if(!empty(get_field('preview', $post->ID)))
                                    echo "<img src='" . get_field('preview', $post->ID)['url'] . "' alt='preview img'>";
                                else
                                    echo "<img src='" . $thumbnail . "' alt='thumbnail placeholder'>"; 
                        }
                    }
                        
                    ?>

                </div>

                <!-- -------------------------------------- Start Icons row ------------------------------------->
                <div class="d-flex elementcourseIcone justify-content-md-between justify-content-around mx-md-2 my-3 mx-sm-2 text-center">
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
                            <span class="textIconeLearning mt-1"><?= $duration_day; ?> dagdee</span>
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
                                        <span class='textIconeLearning mt-1'>Bewaar</span>
                                    </button>
                                    ";
                            ?>
                        </div>
                        <div class="d-flex flex-column mx-md-3 mx-2">
                            <?php
                            if($user_id != 0){
                            ?>
                            <button class="btn iconeText open-modal" data-open="modal1">
                                <i class="fa fa-share" style="font-size: 25px;"></i><br>
                                <span class="textIconeLearning mt-1">Deel</span>
                            </button>
                            <?php }else{ ?>
                            <button class="btn iconeText open-modal" data-toggle='modal' data-target='#SignInWithEmail'  aria-label='Close' data-dismiss='modal' style='border:none; background:white'>
                                <i class="fa fa-share" style="font-size: 25px;"></i><br>
                                <span class="textIconeLearning mt-1">Deel</span>
                            </button>
                            <?php } ?>

                        </div>
                        <!-- début Modal deel -->
                        <div class="modal" id="modal1" data-animation="fadeIn">
                            <div class="modal-dialog modal-dialog-deel" role="document">
                                <div class="modal-content">
                                    <div class="tab">
                                        <button class="tablinks btn active" onclick="openCity(event, 'Extern')">Extern</button>
                                        <hr class="hrModifeDeel">
                                        <button class="tablinks btn" onclick="openCity(event, 'Intern')">Intern</button>
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
                                    <div id="Intern" class="tabcontent">
                                        <form action="" class="formShare">
                                            <input type="text" placeholder="Gebruikersnaam">
                                            <input type="text" placeholder="Wachtwoord">
                                            <button class="btn btnLoginModife">Log-in</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- fin Modal deel -->
                    </div>
                </div>
                <!-- -------------------------------------- End Icons row ------------------------------------->

                <!--------------------------------------- Text description -------------------------------------- -->
                <div class="blockTextGlovale mt-3 text">
                    <div class="text-limit">
                        <?php echo $long_description; ?>
                        <div class=" moreText"> 
                        <?php
                                if($agenda){
                            ?>
                                    <h6 class="textDirect p-0 mt-3" style="text-align: left"><b>Agenda :</b></h6>
                                    <?php echo $agenda; ?> <br><br>
                                    <?php
                                }

                                if($who){
                                    ?>  
                                    <h6 class="textDirect" style="text-align: left"><b>For who :</b></h6>
                                    <?php echo $who; ?> <br><br>
                                    <?php
                                }

                                if($results){
                                    ?>  
                                    <h6 class="textDirect p-0" style="text-align: left"><b>Results :</b></h6>
                                    <p > <?php echo $results; ?> </p> 

                            <?php
                                }
                            ?>
                        </div>    
                        <br>
                       
                   </div>

                    <button type="button" class="btn btn-lg lees_alles mb-5 mt-3 w-md-25 px-4 border border-3 border-dark
                     read-more-btn " >Lees alles</button>
                    
                </div>
                <!----------------------------------- End Text description ----------------------------------- -->
                <?php
                    foreach ($attachments_xml as $key => $attachment) {
                        $i = $key+1;
                        if($key == 3)
                            break;

                        $text = "<a href='". $attachment . "' target='_blank' class='beschiBlockText'>Bijlage " . $i . "  </a>";
                            
                        echo $text;
                    }
                ?>
                <div class="customTabs">
                    <div class="tabs">
                        <ul id="tabs-nav">
                            <li><a href="#tab2">Reviews</a></li>
                            <li><a href="#tab3">Add Reviews</a></li>
                        </ul> <!-- END tabs-nav -->
                        <div id="tabs-content">
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
                                                <p><?= $review->name; ?></p>
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
                                        <p class="reviewsText"><?= $review->feedback; ?></p>

                                    </div>
                                <?php
                                    }
                                }
                                else 
                                    echo "<h4>No reviews for this course ...</h4>";
                                ?>
                            </div>
                            <div id="tab3" class="tab-content">
                                <form action="../../dashboard/user/" method="POST">
                                    <input type="hidden" name="course_id" value="<?= $post->ID; ?>">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="name">Name</label>
                                            <input type="text" name="first_name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Name" required>
                                        </div>
                                        <div class="form- col-6">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" name="email_adress" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
                                            <small id="exampleInputEmail1" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                        </div>
                                    </div>
                                    <div class="form-group">
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
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Feedback</label>
                                        <textarea name="feedback" id=""  rows="10" required></textarea>
                                    </div>
                                    <button type="submit" name="review_post" class="btn btn-sendRating">Send</button>
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
                <div class="modal-dialog" role="document">
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
                <div class="modal-dialog" role="document">
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

            <!-- ---------------------------------- Start Right Side Dashboard -------------------------------- -->
            <div class="blockTwoOver">
                <div class="btnGrou10">
                    <a href="" class="btnContact">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/phone.png" alt="">
                        Direct contact
                    </a>
                    <a href="" class="btnContact">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/question.png" alt="">
                        Voor wie
                    </a>
                </div>
                <p class="afspeeText">Afspeellijst</p>

                <div class="blockChapitreCours">

                    <?php 
                    if(!empty($courses) && !empty($youtube_videos))
                        echo "<div class='sousBlockCours'>
                                <span> No lesson as far, soon available </span>
                            </div>";
                    else
                        if(!empty($courses)){
                            foreach($courses as $key => $course){
                        ?>
                            <div class="sousBlockCours">
                                <?php if(isset($topic)) if($topic == $key) { ?><img class="playElement" src="<?php echo get_stylesheet_directory_uri() ?>/img/play.png" alt=""> <?php } ?>
                                <a style="color:#F79403" href="?topic=<?php echo (int)$key; ?>" class="textChapitreCours"><?php echo ($course['course_topic']['course_topic_title']);?></a>
                                    <?php 
                                        if(!empty($course['course_topic']['course_topic_lessons']))
                                            foreach($course['course_topic']['course_topic_lessons'] as $sand => $value){
                                                if(isset($lesson)) if($lesson == $sand) { ?>
                                                    <div class="d-flex contentListVidoeCourse">
                                                         <img class="playElement mr-3" src="<?php echo get_stylesheet_directory_uri() ?>/img/play.png" alt=""> <?php } ?>
                                                          <a href="?topic=<?php echo (int)$key; ?>&lesson=<?php echo (int)$sand; ?>" class="textChapitreCours"><?php echo ($value['course_lesson']['course_lesson_title']);?></a>
                                                    </div>


                                    <?php
                                            }
                                    ?>
                            </div>
                        <?php }
                            }
                        else{
                        ?>
                            <div class="sousBlockCours">
                                <?php 
                                if(isset($topic)) 
                                    if($topic == $key) { 
                                        echo '<img class="playElement" src="'.  get_stylesheet_directory_uri() . '/img/play.png" alt="">';
                                    } 
                                ?>
                                <a style="color:#F79403" href="?topic=<?php echo (int)$key; ?>" class="textChapitreCours"><?php echo $post->post_title; ?></a>
                                <?php 
                                foreach($youtube_videos as $key => $video){
                                    $style = "";
                                    if(isset($lesson)) 
                                        if($lesson == $key)
                                            $style = "color:#F79403";
                                    echo '  
                                        <a href="?topic=0&lesson=' . $key . '"  class="d-flex contentListVidoeCourse">
                                            <img class="" width="35px" height="20px" src="'. $video['thumbnail_url'] . '" alt="">
                                            <span style="' .$style . '" class="textChapitreCours">' . $video['title'] . '</span>
                                        </a>';
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>

                    <a href="/cart/?add-to-cart=<?php echo get_field('connected_product', $post->ID);?>" class="startTextBtn btn">Start nu voor <?php echo $course_price;?></a>
                </div>

                <!-- d -->
                <div class="CardpriceLive">
                    <?php
                        if(!empty($company)){
                            $company_id = $company[0]->ID;
                            $company_title = $company[0]->post_title;
                            $company_logo = get_field('company_logo', $company_id);
                    ?>
                    <div class="imgCardPrice">
                        <img src="<?php echo $company_logo; ?>" alt="company logo">
                    </div>
                    <a href="/opleider-courses?companie=<?php echo $company_id ; ?>" class="liveTextCadPrice h5"><?php echo $company_title; ?></a>
                    
                    <?php
                        }
                    ?>
                    <form action="../../dashboard/user/" method="POST">
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

                    <p class="PrisText">Locaties</p>
                    <p class="opeleidingText">Online</p>

                    <p class="PrisText">Prijs vanaf</p>
                    <p class="opeleidingText">Opleiding: € <?php echo $price ?></p>
                    <p class="btwText">BTW: € <?php echo $prijsvat ?></p>
                    <p class="btwText">LIFT member korting: 28%</p>
                    
                    
                    <a href="#bookdates" class="btn btnKoop">Koop deze <?php echo $course_type; ?></a>
                </div>

                <!-- ------------------------------------ Start Swiper ------------------------------------ -->
                <div class="col-12 my-5" style="background-color: #E0EFF4">
                    <div class="btn-icon rounded-2 p-3 text-center d-flex justify-content-md-around 
                    justify-content-center">

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
                <!-- -------------------------------------------- End Swiper ----------------------------------- -->


                <!--  -->

                <!-- <div class="CardpriceLive">
                    <div class="imgCardPrice">
                        <img src="<?php if($image_author) echo $image_author; else echo get_stylesheet_directory_uri() . "/img/placeholder_user.png"; ?>" alt="image author">
                    </div>
                    <p class="liveTextCadPrice"><?php echo get_userdata($post->post_author)->data->display_name; ?></p>
                </div> -->
            </div>
            <!-- ---------------------------------- End Right Side Dashboard -------------------------------- -->

        </div>

        <div class="bloxkWorldMembre rounded-3">
            <!-- <p class="wordnuText">Word nu <b>LIFT Member</b> en ontvang persoonlijke korting</p>
            <a href="" class="btn btnPlan">Planeen 15min afspraak in</a> -->
            <div class="row d-flex justify-content-center">
                <div class="col-md-2">
                    <img width="200px" src="<?php echo $photo_daniel; ?>" alt="photo daniel" srcset="">
                </div>
                <div class="col-md-9 mt-3">
                    <p class="h4">Direct <span class="font-weight-bolder h3">vrijblivend</span> een 15 minuten scholingsconsult</p>
                    <div class="d-flex flex-md-row flex-column ">
                        <div class="p-2 w-md-50 w-sm-50 w-100">
                            <div class="input-group">
                                <input type="text" class="form-control text-center border-0"
                                 placeholder="E-mailadres" aria-label="E-mailadress" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="p-2 w-md-50 w-100">
                            <div class="input-group">
                                <input type="text" class="form-control text-center border-0" 
                                placeholder="Telefoonnummer" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="p-2" >
                            <button type="button" class="btn" style="background-color: #00A89D !important; 
                            width: 160px">
                                <span class="text-white" style="font-size: 17px">Neem contact op</span>
                            </button> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
    </div>


    <!-- début Modal deel -->
    <div class="modal" id="modal1" data-animation="fadeIn">
        <div class="modal-dialog modal-dialog-deel" role="document">
            <div class="modal-content">
                <div class="tab">
                    <button class="tablinks btn active" onclick="openCity(event, 'Extern')">Extern</button>
                    <hr class="hrModifeDeel">
                    <button class="tablinks btn" onclick="openCity(event, 'Intern')">Intern</button>
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
                            <input id="test1" type="text" class="linkTextCopy form-control" value="https://g.co/kgs/K1k9oA" readonly>
                            <span class="input-group-btn">
                            <button class="btn btn-default btnCopy">Copy</button>
                            </span>
                            <span class="linkCopied">link copied</span>
                        </div>
                    </div>
                </div>
                <div id="Intern" class="tabcontent">
                    <form action="" class="formShare">
                        <input type="text" placeholder="Gebruikersnaam">
                        <input type="text" placeholder="Wachtwoord">
                        <button class="btn btnLoginModife">Log-in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- fin Modal deel -->

</div>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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

<!-- scritpt for modal -->
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
    // Swiper
    const swiper = new Swiper('.swiper', {

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