<?php /** Template Name: template course e-learning  */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<?php extract($_GET); ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />


    <body>
    <div class="liveOverBlock">
        <div class="container-fluid">
            <div class="overElement">
                <div class="blockOneOver">

                    <!-- ------------------------------ Start Title livelearn ---------------------------------- -->
                    <div class="titleBlock">

                        <a href="/" class="roundBlack">
                            <img width="28" src="" alt="company logo">
                        </a>
                        <a href="/" class="livelearnText2 text-uppercase">Title E-learning</a>

                    </div>
                    <!-- ------------------------------ End Title livelearn ---------------------------------- -->

                    <p class="e-learningTitle"><b><?php echo $post->post_title;?></b></p>
                    <div class="blockImgCour">
                        <video class='blockImgCour' poster='' controls>
                            <source src='' type='video/mp4;charset=UTF-8' />
                            <source src='' />
                            <source src='' />
                        </video>
                    </div>

                    <p class="startTextBtn modalStratQuizz" >Quizz for Module 1 HTML</p>

                    <!-- -------------------------------------- Start Icons row ------------------------------------->
                    <div class="d-flex elementcourseIcone justify-content-md-between justify-content-around text-center">
                        <div class="d-flex flex-row block1">
                            <div class="d-flex flex-column mrIcone">
                                <input type="hidden" id="user_id" value="">
                                <input type="hidden" id="course_id" value="">
                                <button id="btn_favorite" style="background:white; border:none">
                                    <img class="like1" src="<?php echo get_stylesheet_directory_uri();?>/img/like1.png" alt="">
                                    <img class="like2" src="<?php echo get_stylesheet_directory_uri();?>/img/like2.png" alt="">
                                </button>
                                <span class="textIconeLearning mt-1" id="autocomplete_favoured"><?php echo $favoured; ?></span>
                            </div>
                            <div class="d-flex flex-column mx-md-3 mx-2">
                                <i class="fas fa-calendar-alt" style="font-size: 25px;"></i>
                                <span class="textIconeLearning mt-1"><?= $duration_day; ?> dagdeel</span>
                            </div>
                            <div class="d-flex flex-column mx-md-3 mx-2">
                                <i class="fas fa-graduation-cap" style="font-size: 25px;"></i>
                                <span class="textIconeLearning mt-1"><?php if($course_type) echo $course_type; else echo "Undefined"; ?></span>
                            </div>
                        </div>
                        <div class="d-flex flex-row block2">
                            <div class="d-flex flex-column mx-md-3 mx-2">
                                <form action="../../dashboard/user/" method="POST">
                                    <input type="hidden" name="meta_value" value="" id="">
                                    <input type="hidden" name="user_id" value="" id="">
                                    <input type="hidden" name="meta_key" value="course" id="">
                                    <button type='submit' class='' name='interest_save' style='border:none; background:white'>
                                        <i class='fas fa-bell' style='font-size: 25px;'></i><br>
                                        <span class='textIconeLearning mt-1'>Bewaar</span>
                                    </button>
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
                            <div class="d-flex flex-column mlIcone">
                                <button class="btn open-modal" data-open="modal1">
                                    <i class="fa fa-share" style="font-size: 25px;"></i><br>
                                    <span class="textIconeLearning mt-1">Deel</span>
                                </button>
                            </div>

                            <!-- Debut Modal deel -->
                            <div class="modal" id="modal1" data-animation="fadeIn">
                                <div class="modal-dialog modal-dialog-course modal-dialog modal-dialog-course-deel" role="document">
                                    <div class="modal-content">
                                        <div class="tab">
                                            <button class="tablinks btn active" onclick="openCity(event, 'Extern')">Extern</button>
                                            <hr class="hrModifeDeel">
                                            <button class="tablinks btn" onclick="openCity(event, 'Intern')">Intern</button>
                                        </div>
                                        <div id="Extern" class="tabcontent">
                                            <div class="contentElementPartage">
                                                <a href="https://wa.me/?text=<?= $share_txt ?>" target="_blank" id="whatsapp"  class="btn contentIcone">
                                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/whatsapp.png" alt="">
                                                </a>
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
                                                <a href="sms:?&body=<?= $share_txt ?>" target="_blank" id="sms" class="btn contentIcone">
                                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sms.png" alt="">
                                                </a>
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
                                            echo "<div id='Intern' class='tabcontent px-md-5 p-3'>";
                                            wp_login_form([
                                                'redirect' => $url,
                                                'remember' => false,
                                                'label_username' => 'Wat is je e-mailadres?',
                                                'placeholder_email' => 'E-mailadress',
                                                'label_password' => 'Wat is je wachtwoord?'
                                            ]);
                                            echo "</div>";
                                        }else{
                                            echo "<div id='Intern' class='tabcontent px-md-5 p-3'>";
                                            echo "<form action='/dashboard/user/' class='formConetentIntern' method='POST'>";
                                            echo "<label for='member_id'><b>Deel deze cursus met uw team :</b></label>";
                                            echo "<select class='multipleSelect2' id='member_id' name='selected_members[]' multiple='true'>";
                                            if(!empty($users_company))
                                                foreach($users_company as $user){
                                                    $name = get_users(array('include'=> $user))[0]->data->display_name;
                                                    if(!empty($allocution))
                                                        if(in_array($user, $allocution))
                                                            echo "<option class='redE' selected  value='" . $user . "'>" . $name . "</option>";
                                                        else
                                                            echo "<option class='redE' value='" . $user . "'>" . $name . "</option>";
                                                    else
                                                        echo "<option class='redE' value='" . $user . "'>" . $name . "</option>";
                                                }
                                            echo "</select>";
                                            echo "<input type='hidden' name='course_id' value='" . $post->ID . "' >";
                                            echo "<input type='hidden' name='path' value='course' />";
                                            echo "<input type='submit' class='btn btn-info' name='referee_employee' value='Apply' >";
                                            echo "</form>";
                                            echo "</div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- fin Modal deel -->
                        </div>
                    </div>
                    <div class="detail-product-assesment">
                        <p class="title-description">Description:</p>
                        <p class="description">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book.

                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularsed in the 1960 with release containing Lorem Ipsum passages desktop publishing software.</p>
                        <p class="title-description">Requirements: </p>
                        <p class="description">No pre-necessities, in spite of the fact that commonality with fundamental business ideas is useful.</p>

                    </div>
                    <!----------------------------------- End Text description ----------------------------------- -->

                    <div class="customTabs">
                        <div class="tabs">
                            <ul id="tabs-nav">
                                <li><a href="#tab2">Reviews</a></li>
                                <?php if(!$my_review_bool) echo '<li><a href="#tab3">Add Reviews</a></li>'; ?>

                            </ul> <!-- END tabs-nav -->
                            <div id="tabs-content">
                                <div id="tab2" class="tab-content">
                                    <?php
                                    if(!empty($reviews)){
                                        foreach($reviews as $review){
                                            $user = $review['user'];
                                            $image_author = get_field('profile_img',  'user_' . $user->ID);
                                            $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';
                                            $rating = $review['rating'];
                                            ?>
                                            <div class="review-info-card">
                                                <div class="review-user-mini-profile">
                                                    <div class="user-photo">
                                                        <img src="<?= $image_author; ?>" alt="">
                                                    </div>
                                                    <div class="user-name">
                                                        <p><?= $user->display_name; ?></p>
                                                        <div class="rating-element">
                                                            <div class="rating">
                                                                <?php
                                                                for($i = $rating; $i >= 1; $i--){
                                                                    if($i == $rating)
                                                                        echo '<input type="radio" name="rating" value="' . $i . ' " checked disabled/>
                                                                <label class="star" title="" aria-hidden="true"></label>';
                                                                    else
                                                                        echo '<input type="radio" name="rating" value="' . $i . ' " disabled/>
                                                                    <label class="star" title="" aria-hidden="true"></label>';
                                                                }
                                                                ?>
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
                                        echo "<h6>No reviews for this e-learning course ...</h6>";
                                    ?>
                                </div>
                                <div id="tab3" class="tab-content">
                                    <?php
                                    if($user_id != 0 && !$my_review_bool){
                                        ?>
                                        <div class="formSingleCoourseReview">
                                            <label>Rating</label>
                                            <div class="rating-element2">
                                                <div class="rating">
                                                    <input type="radio" id="star5" class="stars" name="rating" value="5" />
                                                    <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                                    <input type="radio" id="star4" class="stars" name="rating" value="4" />
                                                    <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                                    <input type="radio" id="star3" class="stars" name="rating" value="3" />
                                                    <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                                    <input type="radio" id="star2" class="stars" name="rating" value="2" />
                                                    <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                                    <input type="radio" id="star1" name="rating" value="1" />
                                                    <label class="star" for="star1" class="stars" title="Bad" aria-hidden="true"></label>
                                                </div>
                                                <span class="rating-counter"></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Feedback</label>
                                                <textarea name="feedback_content" id="feedback" rows="10"></textarea>
                                            </div>
                                            <input type="button" class='btn btn-sendRating' id='btn_review' name='review_post' value='Send'>
                                        </div>
                                        <?php
                                    }
                                    else
                                        echo "<button data-toggle='modal' data-target='#SignInWithEmail'  data-dismiss='modal'class='btnLeerom' style='border:none'> You must sign-in for review </button>";
                                    ?>
                                </div>
                            </div> <!-- END tabs-content -->
                        </div> <!-- END tabs -->
                    </div>
                </div>

                <!-- -----------------------------------Start Modal Direct contact & Voor wie ----------------------------------------------- -->
                <div class="modal fade" id="direct-contact" tabindex="-1" role="dialog" aria-labelledby="direct-contactModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-course">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="direct-contactModalLongTitle">Direct contact</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex justify-content-center">

                                    <div>
                                        <a href="https://wa.me/<?= $phone_user ?>" target="_blank" class="mx-3 d-flex flex-column ">
                                            <i style="font-size: 50px; height: 49px; margin-top: -4px;"
                                               class="fab fa-whatsapp text-success shadow rounded-circle border border-3 border-white "></i>
                                        </a>
                                        <div class="mt-3 text-center">
                                            <span class="bd-highlight fw-bold text-success mt-2">whatsapp</span>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="mailto:<?= $email_user ?>" target="_blank" class="mx-3 d-flex flex-column ">
                                            <i style="font-size: 25px"
                                               class="fa fa-envelope bg-danger border border-3 border-danger rounded-circle p-2 text-white shadow"></i>
                                            <!-- <span class="bd-highlight fw-bold text-primary mt-2">email</span> -->
                                        </a>
                                        <div class="mt-3 text-center">
                                            <span class="bd-highlight fw-bold text-danger mt-5">email</span>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="sms:<?= $phone_user ?>" target="_blank" class="mx-3 d-flex flex-column ">
                                            <i style="font-size: 25px" class="fa fa-comment text-secondary shadow p-2 rounded-circle border border-3 border-secondary"></i>
                                        </a>
                                        <div class="mt-3 text-center">
                                            <span class="bd-highlight fw-bold text-secondary mt-5">message</span>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="tel:<?= $phone_user ?>" target="_blank" class="mx-3 d-flex flex-column ">
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
                <!-- -------------------------------------------------- End Modal Direct contact & Voor wie -------------------------------------- -->

                <div class="modal fade" id="voor-wie" tabindex="-1" role="dialog" aria-labelledby="voor-wieModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-course">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="voor-wieModalLongTitle"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
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
                                        <p class="m-0">
                                            <?= $for_who ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- -------------------------------------------------- End Modal Direct contact & Voor wie -------------------------------------- -->


                <!-- ------------------------------------------Start Modal Sign In ----------------------------------------------- -->
                <div class="modal modalEcosyteme fade" id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                     style="position: absolute;height: 150% !important; overflow-y:hidden !important;">
                    <div class="modal-dialog" role="document" style="width: 96% !important; max-width: 500px !important;
                    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">

                        <div class="modal-content">

                            <div class="modal-header border-bottom-0">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body  px-md-4 px-0">
                                <div class="mb-4">
                                    <div class="text-center">
                                        <img style="width: 53px" src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="">
                                    </div>
                                    <h3 class="text-center my-2">Sign Up</h3>
                                    <div class="text-center">
                                        <p>Already a member? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                                data-toggle="modal" data-target="#exampleModalCenter">&nbsp; Sign in</a></p>
                                    </div>
                                </div>


                                <?php
                                echo (do_shortcode('[user_registration_form id="59"]'));
                                ?>

                                <div class="text-center">
                                    <p>Al een account? <a href="" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                          data-toggle="modal" data-target="#exampleModalCenter">Log-in</a></p>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <!-- -------------------------------------------------- End Modal Sign In-------------------------------------- -->

                <!-- -------------------------------------- Start Modal Sign Up ----------------------------------------------- -->
                <div class="modal modalEcosyteme fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                     style="position: absolute;overflow-y:hidden !important;height: 110%; ">
                    <div class="modal-dialog" role="document" style="width: 96% !important; max-width: 500px !important;
                box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">

                        <div class="modal-content">
                            <div class="modal-header border-bottom-0">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body  px-md-5 px-4">
                                <div class="mb-4">
                                    <div class="text-center">
                                        <img style="width: 53px" src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="">
                                    </div>
                                    <h3 class="text-center my-2">Sign In</h3>
                                    <div class="text-center">
                                        <p>Not an account? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                              data-toggle="modal" data-target="#SignInWithEmail">&nbsp; Sign Up</a></p>
                                    </div>
                                </div>

                                <?php
                                wp_login_form([
                                    'redirect' => $url,
                                    'remember' => false,
                                    'label_username' => 'Wat is je e-mailadres?',
                                    'placeholder_email' => 'E-mailadress',
                                    'label_password' => 'Wat is je wachtwoord?'
                                ]);
                                ?>
                                <div class="text-center">
                                    <p>Nog geen account?  <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                             data-toggle="modal" data-target="#SignInWithEmail">Meld je aan</a></p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- -------------------------------------------------- End Modal Sign Up-------------------------------------- -->


                <!-- ---------------------------------- Start Right Side Dashboard -------------------------------- -->
                <div class="blockTwoOver">
                    <div class="btnGrou10">
                        <button type="button" class="btnContact" data-toggle="modal" data-target="#direct-contact">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/phone.png" alt="">
                            Direct contact
                        </button>
                        <button type="button" class="btnContact" data-toggle="modal" data-target="#voor-wie">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/question.png" alt="">
                            Voor wie
                        </button>
                    </div>
                    <p class="afspeeText">Afspeellijst</p>

                    <div class="sousBlockCours d-block playlist-video">
                        <div class="element-afspeellijst">
                            <a href=""  class="d-flex contentListVidoeCourse">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png"  src="" alt="">
                                <span class="textChapitreCours">Module 1 HTML</span>
                            </a>
                            <button data-toggle="modal" data-target="#modalAssessment" type="button" class="btn quizz-afspeellijst">
                                <i class="fas fa-tasks"></i>
                                <p>Quizes</p>
                            </button>
                        </div>
                        <div class="element-afspeellijst">
                            <a href=""  class="d-flex contentListVidoeCourse">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png"  src="" alt="">
                                <span class="textChapitreCours">Building power where you seemingly don’t belong | Zulfat Suara | TEDxNashvilleSalon</span>
                            </a>
                            <button data-toggle="modal" data-target="#modalAssessment" type="button" class="btn quizz-afspeellijst">
                                <i class="fas fa-tasks"></i>
                                <p>Quizes</p>
                            </button>
                        </div>
                        <div class="element-afspeellijst">
                            <a href=""  class="d-flex contentListVidoeCourse">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png"  src="" alt="">
                                <span class="textChapitreCours">Building power where you seemingly don’t belong | Zulfat Suara | TEDxNashvilleSalon</span>
                            </a>
                            <button data-toggle="modal" data-target="#modalAssessment" type="button" class="btn quizz-afspeellijst">
                                <i class="fas fa-tasks"></i>
                                <p>Quizes</p>
                            </button>
                        </div>
                        <div class="element-afspeellijst">
                            <a href=""  class="d-flex contentListVidoeCourse">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png"  src="" alt="">
                                <span class="textChapitreCours">Building power where you seemingly don’t belong | Zulfat Suara | TEDxNashvilleSalon</span>
                            </a>
                            <button data-toggle="modal" data-target="#modalAssessment" type="button" class="btn quizz-afspeellijst">
                                <i class="fas fa-tasks"></i>
                                <p>Quizes</p>
                            </button>
                        </div>
                        <div class="element-afspeellijst">
                            <a href=""  class="d-flex contentListVidoeCourse">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png"  src="" alt="">
                                <span class="textChapitreCours">Building power where you seemingly don’t belong | Zulfat Suara | TEDxNashvilleSalon</span>
                            </a>
                            <button data-toggle="modal" data-target="#modalAssessment" type="button" class="btn quizz-afspeellijst">
                                <i class="fas fa-tasks"></i>
                                <p>Quizes</p>
                            </button>
                        </div>
                    </div>
                    <div class="widget-information widget-information-elarning">
                        <div class="info-list">
                            <div class="d-flex align-items-center">
                                <i class='fas fa-chalkboard-teacher'></i>
                                <strong>Create by :</strong>
                            </div>
                            <p class="name">Livelearn</p>
                        </div>
                        <div class="info-list">
                            <div class="d-flex align-items-center">
                                <i class='fas fa-map-marker'></i>
                                <strong>Locaties</strong>
                            </div>
                            <p class="name">Online</p>
                        </div>
                        <div class="info-list">
                            <div class="d-flex align-items-center">
                                <i class='fas fa-chalkboard-teacher'></i>
                                <strong>Assessment Fee</strong>
                            </div>
                            <p class="name">Free</p>
                        </div>
                        <div class="info-list">
                            <div class="d-flex align-items-center">
                                <i class='fas fa-Clock'></i>
                                <strong>Duration</strong>
                            </div>
                            <p class="name">10h 50m</p>
                        </div>
                        <div class="info-list">
                            <div class="d-flex align-items-center">
                                <i class='fas fa-level-up-alt'></i>
                                <strong>Difficulty Level</strong>
                            </div>
                            <p class="name">Secondary</p>
                        </div>
                        <div class="info-list">
                            <div class="d-flex align-items-center">
                                <i class='fas fa-language'></i>
                                <strong>Language</strong>
                            </div>
                            <p class="name">English</p>
                        </div>
                    </div>
                    <div class="col-12 my-5" style="background-color: #E0EFF4">
                        <div class="btn-icon rounded-2 p-3 text-center d-flex justify-content-md-around
                        justify-content-center">

                            <!-- --------------------------------------- Swiper ------------------------------------ -->
                            <!-- Slider main container -->
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    <?php
                                    $saves_expert = get_user_meta($user_id, 'expert');
                                    foreach($experts as $value){
                                        if(!$value)
                                            continue;

                                        $expert = get_users(array('include'=> $value))[0]->data;
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
                                                <form action="/dashboard/user/" method="POST">
                                                    <input type="hidden" name="artikel" value="<?= $post->ID; ?>" id="">
                                                    <input type="hidden" name="meta_value" value="<?= $expert->ID; ?>" id="">
                                                    <input type="hidden" name="user_id" value="<?= $user_id ?>" id="">
                                                    <input type="hidden" name="meta_key" value="expert" id="">
                                                    <div>
                                                        <?php
                                                        if(empty($saves_expert))
                                                            echo "<button type='submit' class='btn btnFollowExpert' name='interest_push'>Follow</button>";
                                                        else if($user_id != 0 && $user_id != $expert->ID)
                                                        {
                                                            if (in_array($expert->ID, $saves_expert))
                                                                echo "<button type='submit' class='btn btnFollowExpert' name='delete'>Unfollow</button>";
                                                            else
                                                                echo "<button type='submit' class='btn btnFollowExpert' name='interest_push'>Follow</button>";
                                                        }
                                                        ?>
                                                    </div>
                                                </form>
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

    </div>


    <!-- <div class="CardpriceLive">
                    <div class="imgCardPrice">
                        <img src="<?php if($image_author) echo $image_author; else echo get_stylesheet_directory_uri() . "/img/placeholder_user.png"; ?>" alt="image author">
                    </div>
                    <p class="liveTextCadPrice"><?php echo get_userdata($post->post_author)->data->display_name; ?></p>
                </div> -->
    </div>
    <!-- ---------------------------------- End Right Side Dashboard -------------------------------- -->

    </div>


      <div class="container-fluid">
          <div class="bloxkWorldMembre formDirect ">
              <!-- <p class="wordnuText">Word nu <b>LIFT Member</b> en ontvang persoonlijke korting</p>
              <a href="" class="btn btnPlan">Planeen 15min afspraak in</a> -->
              <div class="row d-flex justify-content-center">
                  <div class="col-md-2">
                      <img class="imgDanForm" src="<?php echo $photo_daniel; ?>" alt="photo daniel" srcset="">
                  </div>
                  <div class="col-md-9 mt-3">
                      <p class="h4">Direct <span class="font-weight-bolder h3">vrijblijvend</span> een 15 minuten scholingsconsult</p>
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

    <!-- Modal -->

    <!-- Start Modal  -->
    <?php
    if($price !== 'Gratis'){
        ?>
        <div class="modal fade modalpaywallVideo" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <h5 class="title-paywall" >Get Acces Now </h5>
                    <div class="modal-body">
                        <p class="sub-title-paywall">Please purchase this course to continue</p>
                        <p class="price-course"><?= $price ?></p>
                        <?php
                        echo '<a href="/cart/?add-to-cart=' . get_field('connected_product', $post->ID) . '" class="btn btn-paywall">Buying Now <img src="<?php echo get_stylesheet_directory_uri();?>/img/arrowhead.png" alt=""></a>';
                        ?>
                        <a href="" class="btn btn-paywall">Buying Now <img src="<?php echo get_stylesheet_directory_uri();?>/img/arrowhead.png" alt=""></a>
                        <p class="text-not-sure-which">Not Sure which is right now for you ? <a href="">Discover the benefits of taking this course now </a></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <!-- -->


    <!-- Modal assessment-->
    <div class="modal fade" id="modalAssessment" tabindex="-1" role="dialog" aria-labelledby="modalAssessmentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Quizz for Module 1 HTML </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="quizcontainer">
                            <p class="instructionTitle">What does HTML stand for?</p>
                            <div class="input-group">
                                <input type="radio" id="html1" name="group1" value="HTML1">
                                <label for="html1"> Hyperlinks and Text Markup Language</label>
                            </div>
                            <div class="input-group">
                                <input type="radio" id="html2" name="group1" value="HTML2">
                                <label for="html2"> Hyper Text Markup Language</label>
                            </div>
                            <div class="input-group">
                                <input type="radio" id="html3" name="group1" value="HTML3">
                                <label for="html3"> Home Tool Markup Language</label>
                            </div>
                        </div>
                        <div class="quizcontainer">
                            <p class="instructionTitle">Who is making the Web standards?</p>
                            <div class="input-group">
                                <input type="radio" id="html1" name="group1" value="HTML1">
                                <label for="html1"> Hyperlinks and Text Markup Language</label>
                            </div>
                            <div class="input-group">
                                <input type="radio" id="html2" name="group1" value="HTML2">
                                <label for="html2"> Hyper Text Markup Language</label>
                            </div>
                            <div class="input-group">
                                <input type="radio" id="html3" name="group1" value="HTML3">
                                <label for="html3"> Home Tool Markup Language</label>
                            </div>
                        </div>
                        <div class="quizcontainer">
                            <p class="instructionTitle">Choose the correct HTML element for the largest heading:</p>
                            <div class="input-group">
                                <input type="radio" id="html1" name="group1" value="HTML1">
                                <label for="html1"> Hyperlinks and Text Markup Language</label>
                            </div>
                            <div class="input-group">
                                <input type="radio" id="html2" name="group1" value="HTML2">
                                <label for="html2"> Hyper Text Markup Language</label>
                            </div>
                            <div class="input-group">
                                <input type="radio" id="html3" name="group1" value="HTML3">
                                <label for="html3"> Home Tool Markup Language</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-save-quizz">Save</button>
                </div>
            </div>
        </div>
    </div>



    </div>




    <!-- ------------------------------------------ End modals ---------------------------------------------- -->




    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

    <script>
        // scroll down on click button
        $( '.btnScroolEvent' ).on( 'click', function(e){
            $( 'html, body' ).animate({
                scrollTop: $(".customTabs").offset().top
            }, '500' );
            e.preventDefault();

        });
    </script>

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
        $("#btn_review").click((e)=>
        {
            $(e.preventDefault());
            var user_id = $("#user_id").val();
            var id = $("#course_id").val();
            var feedback = $("#feedback").val();
            var stars = $('input[name=rating]:checked').val()
            $.ajax({

                url:"/review",
                method:"post",
                data:{
                    id:id,
                    user_id:user_id,
                    feedback_content:feedback,
                    stars:stars,
                },
                dataType:"text",
                success: function(data){
                    console.log(data);
                    $('#tab3').html(data);
                    $("#feedback").val(' ');
                    if(data)
                        $('#info_review').html("<span class='alert alert-success'>Your comments sent successfully</span>");
                    else
                        $('#info_review').html("<span class='alert alert-error'>You already sent a comments for this course</span>");
                }
            });
        })
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
    <script src="<?php echo get_stylesheet_directory_uri();?>/donu-chart.js"></script>

    </body>

<?php get_footer(); ?>
<?php wp_footer(); ?>