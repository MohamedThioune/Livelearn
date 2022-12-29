<?php /** Template Name: template course assessement  */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<?php extract($_GET); ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />


<body>


<div class="liveOverBlock">
    <div class="container-fluid">
        <div class="overElement">
            <div class="blockOneOver">

                <p class="e-learningTitle">Assessament Title</p>
                <!-- Image -->
                <div class="img-fluid-course">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png"  alt="">
                </div>


                <p class="beschiBlockText btnScroolEvent">Strat Assessmant</p>

                <!-- -------------------------------------- Start Icons row ------------------------------------->
                <div class="d-flex elementcourseIcone sousBlock text-center">
                    <div class="d-flex flex-row block1">
                        <div class="d-flex flex-column mrIcone">
                            <input type="hidden" id="user_id" value="<?php echo $user_id; ?>">
                            <input type="hidden" id="course_id" value="<?php echo $post->ID; ?>">
                            <!-- <img class="iconeCours" src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt=""> -->
                            <button id="btn_favorite" style="background:white; border:none">
                                <img class="like1" src="<?php echo get_stylesheet_directory_uri();?>/img/like1.png" alt="">
                                <img class="like2" src="<?php echo get_stylesheet_directory_uri();?>/img/like2.png" alt="">
                            </button>
                            <span class="textIconeLearning mt-1" id="autocomplete_favoured"><?php echo $favoured; ?></span>
                        </div>
                        <div class="d-flex flex-column mx-md-3 mx-2">
                            <i class="fas fa-calendar-alt" style="font-size: 25px;"></i>
                            <span class="textIconeLearning mt-1"><?= $dagdeel." dagdeel" ?></span>
                        </div>
                        <div class="d-flex flex-column mx-md-3 mx-2">
                            <i class="fas fa-graduation-cap" style="font-size: 25px;"></i>
                            <span class="textIconeLearning mt-1"><?php if($course_type) echo $course_type; else echo "Undefined"; ?></span>
                        </div>
                    </div>
                    <div class="d-flex flex-row block2">
                        <div class="d-flex flex-column mx-md-3 mx-2">
                            <form action="/dashboard/user/" method="POST">
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
                        <div class="d-flex flex-column mlIcone">
                            <button class="btn open-modal" data-open="modal1">
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
                                            <div class="input-group input-group-copy formCopyLink w-75">
                                                <input id="test1" type="text" class="linkTextCopy form-control" value="<?php echo get_permalink($post->ID) ?>" readonly>
                                                <span class="input-group-btn">
                                                <button class="btn btn-default btnCopy">Copy</button>
                                                </span>
                                                <span class="linkCopied">link copied</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php

                                    if ($user_id == 0)
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
                                    }
                                    else{
                                        echo "<div id='Intern' class='tabcontent px-md-5 p-3'>";
                                        echo "<form action='/dashboard/user/' class='formConetentIntern' method='POST'>";
                                        echo "<label for='member_id'><b>Deel deze cursus met uw team :</b></label>";
                                        echo "<select class='multipleSelect2' id='member_id' name='selected_members[]' multiple='true'>";
                                        if(!empty($users_company))
                                            foreach($users_company as $user){
                                                $name = get_users(array('include'=> $user))[0]->data->display_name;
                                                if(!empty($allocution))
                                                    if(in_array($user, $allocution))
                                                        echo "<option selected  value='" . $user . "'>" . $name . "</option>";
                                                    else
                                                        echo "<option value='" . $user . "'>" . $name . "</option>";
                                                else
                                                    echo "<option class='redE' value='" . $user . "'>" . $name . "</option>";
                                            }
                                        echo "</select></br></br>";
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

                <div class="customTabs">






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



                            <!-- ----------------------------------- Right side: small dashboard ------------------------------------- -->



                        </div>

                    </div>
                <!-- start Modal deel -->
                <div class="modal" id="modal1" data-animation="fadeIn">
                    <div class="modal-dialog modal-dialog-course modal-dialog modal-dialog-course-deel" role="document">
                        <div class="modal-content">
                            <div class="tab">
                                <button class="tablinks btn active" onclick="openCity(event, 'Extern')">Extern</button>
                                <hr class="hrModifeDeel">
                                <?php
                                if ($user_id != 0)
                                {
                                    ?>
                                    <button class="tablinks btn" onclick="openCity(event, 'Intern')">Intern</button>
                                    <?php
                                }
                                ?>
                            </div>
                            <div id="Extern" class="tabcontent">
                                <div class="contentElementPartage">
                                    <a href="https://wa.me/?text=<?= $share_txt ?>" target="_blank" id="whatsapp"  class="btn contentIcone">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/whatsapp.png" alt="">
                                        <p class="titleIcone">WhatsAppp</p>
                                    </a>
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
                                    <a href="sms:?&body=<?= $share_txt ?>" target="_blank" id="" class="btn contentIcone">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sms.png" alt="">
                                    </a>
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
                <div class="blockTwoOver">
                <div class="widget-information">
                    <div class="info-list">
                        <div class="d-flex align-items-center">
                            <i class='fas fa-chalkboard-teacher'></i>
                            <strong>Create by :</strong>
                        </div>
                        <p class="name">Livelearn</p>
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
                        <p class="name">Duration</p>
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
                    <div class="btn-icon rounded-2 p-3 text-center d-flex justify-content-md-around justify-content-center">

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