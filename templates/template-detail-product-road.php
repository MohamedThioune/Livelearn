<?php /** Template Name: detail product road path template */ ?>
<?php wp_head(); ?>
<?php get_header(); ?>

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


    <div class="">
        <div class="container-fluid">
            <div class="overElement">
                <div class="blockOneOver">
                    <div class="titleBlock">
                        <div class="roundBlack" >
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image54.png" alt="company logo">
                        </div>
                        <p class="livelearnText2 text-uppercase">Daniel</p>
                    </div>


                    <p class="e-learningTitle">Doorbreek gedachtepatronen</p>
                    <!-- Image -->
                    <div class="img-fluid-course">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/sport.jpg" alt="">
                    </div>
                    <p class="beschiBlockText">Webshop training (virtueel)</p>

                    <!-- -------------------------------------- Start Icons row ------------------------------------->
                    <div class="d-flex elementcourseIcone sousBlock mx-md-2 mx-sm-2 text-center">
                        <div class="d-flex flex-row block1">
                            <div class="d-flex flex-column mx-md-3 mx-2">
                                <input type="hidden" id="user_id" value="0">
                                <input type="hidden" id="course_id" value="0">
                                <!-- <img class="iconeCours" src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt=""> -->
                                <button id="btn_favorite" style="background:white; border:none"><i class="far fa-heart" style="font-size: 25px;"></i></button>
                                <span class="textIconeLearning mt-1" id="autocomplete_favoured">5</span>
                            </div>
                            <div class="d-flex flex-column mx-md-3 mx-2">
                                <i class="fas fa-calendar-alt" style="font-size: 25px;"></i>
                                <span class="textIconeLearning mt-1">1 dagdeel</span>
                            </div>
                            <div class="d-flex flex-column mx-md-3 mx-2">
                                <i class="fas fa-graduation-cap" style="font-size: 25px;"></i>
                                <span class="textIconeLearning mt-1">Training</span>
                            </div>
                        </div>
                        <div class="d-flex flex-row block2">
                            <div class="d-flex flex-column mx-md-3 mx-2">
                                <form action="../../dashboard/user/" method="POST">
                                    <button type='submit' class='' name='interest_save' style='border:none; background:white'>
                                        <i class='fas fa-bell' style='font-size: 25px;'></i><br>
                                        <span class='textIconeLearning mt-1'>Bewaar</span>
                                    </button>
                                </form>
                            </div>
                            <div class="d-flex flex-column mx-md-3 mx-2">
                                <button class="btn iconeText open-modal">
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

                    <div class="blockTextGlovale mt-3">
                        <div class="text-limit">
                           <p>Je wilt dolgraag een professionele webshop en niet afhankelijk zijn van een webdesigner of programmeur. Met WordPress – het meest gebruikte en gewaardeerde CMS ter wereld – kan iedereen eenvoudig een eigen webshop bouwen en onderhouden. Maar hoe bouw je een WordPress webshop?</p>
                            <p>In de WordPress webshop training verkrijg je diepgaand inzicht in hoe je een WordPress webshop kunt creëren. Van het installeren en implementeren van de WooCommerce plug-in en e-commerce thema’s tot het gebruik van voorbeeldbestanden; alle belangrijke elementen voor het bouwen en beheren van een WordPress webshop passeren de revue.</p>
                        </div>
                    </div>
                </div>


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
                        <a href="" class="btnContact" data-bs-toggle="modal" data-bs-target="#voor-wie">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/question.png" alt="">
                            Voor wie
                        </a>
                    </div>

                    <div class="play-road-element">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <p class="title">Doorbreek gedachtepatronen</p>
                            <p class="number">7 Courses</p>
                        </div>
                        <div class="content-play-road-element">
                            <div class="image-play-road">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/sport.jpg" alt="">
                            </div>
                            <div class="secondBlock ">
                                <p class="name-course-road">webshop training (WooCommerce) (virtueel)</p>
                                <div class="categoriesRoadPath">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/op-seach.png" alt="">
                                    <p class="">E-learnning</p>
                                </div>
                            </div>
                        </div>
                        <div class="content-play-road-element">
                            <div class="image-play-road">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/sport.jpg" alt="">
                            </div>
                            <div class="secondBlock ">
                                <p class="name-course-road">webshop training (WooCommerce) (virtueel)</p>
                                <div class="categoriesRoadPath">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/op-seach.png" alt="">
                                    <p class="">E-learnning</p>
                                </div>
                            </div>
                        </div>
                        <div class="content-play-road-element">
                            <div class="image-play-road">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/sport.jpg" alt="">
                            </div>
                            <div class="secondBlock ">
                                <p class="name-course-road">webshop training (WooCommerce) (virtueel)</p>
                                <div class="categoriesRoadPath">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/op-seach.png" alt="">
                                    <p class="">E-learnning</p>
                                </div>
                            </div>
                        </div>
                        <div class="content-play-road-element">
                            <div class="image-play-road">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/sport.jpg" alt="">
                            </div>
                            <div class="secondBlock ">
                                <p class="name-course-road">webshop training (WooCommerce) (virtueel)</p>
                                <div class="categoriesRoadPath">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/op-seach.png" alt="">
                                    <p class="">E-learnning</p>
                                </div>
                            </div>
                        </div>
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