<?php /** Template Name: product lezing template */ ?>
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


    <div class="liveOverBlock">
        <div class="container-fluid">
            <div class="overElement">
                <div class="blockOneOver">
                    <div class="titleBlock">
                        <div class="roundBlack" >
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoMobil.png" alt="company logo">
                        </div>
                        <p class="livelearnText2 text-uppercase">Livelean</p>
                    </div>


                    <p class="e-learningTitle">Workshop Course Test</p>
                    <!-- Image -->
                    <div class="img-fluid-course">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/lezing.jpg" alt="">
                    </div>

                    <!--------------------------------------- start Text description -------------------------------------- -->
                    <p class="description-assessment-test">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                        type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
                        typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
                        Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                    <div class="customTabs">
                        <div class="tabs">
                            <ul id="tabs-nav">
                                <li><a href="#tab1">Events</a></li>
                                <li><a href="#tab2">Skills</a></li>
                                <li><a href="#tab3">Reviews</a></li>
                                <li><a href="#tab4">Add Reviews</a></li>
                            </ul> <!-- END tabs-nav -->
                            <div id="tabs-content">
                                <div id="tab1" class="tab-content">
                                    <h2>Evens</h2>
                                    <div>
                                        <div class="block2evens">
                                            <div class="CardBlockEvenement">

                                                <div class="dateBlock">
                                                    <p class="dateText1">04/12/2022
                                                    </p>
                                                    <p class="inclusiefText">Dakar</p>
                                                </div>
                                                <div class="BlocknumberEvenement">

                                                    <div class="d-flex">
                                                        <p class="numberEvens">3</p>
                                                        <p class="dateEvens">04/12/2022</p>
                                                    </div>
                                                    <p class="inclusiefText">Beschrijving van de verschillende data voor deze cursus en de bijbehorende plaats</p>

                                                </div>

                                                <div class="blockPriceEvens">
                                                    <p class="prixEvens">450 €</p>
                                                    <p class="exText">Ex BTW</p>

                                                    <div class="contentBtnCardProduct">
                                                        <form class="cart" action="" method="post" enctype=''>
                                                            <button type="submit" name="add-to-cart" class="single_add_to_cart_button button alt">Reserveren</button>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="tab2" class="tab-content">
                                    <h2>Skills</h2>
                                    <div class="blockSkillsTabs">
                                        <p class="skillsElement">Management</p>
                                        <p class="skillsElement">Organisatie</p>
                                        <p class="skillsElement">Digital</p>
                                    </div>
                                </div>

                                <div id="tab3" class="tab-content">
                                    <h2>Reviews</h2>
                                    <div class="review-info-card">
                                        <div class="review-user-mini-profile">
                                            <div class="user-photo">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/dan.jpg" alt="">
                                            </div>
                                            <div class="user-name">
                                                <p>Daniel</p>
                                                <div class="rating-element">
                                                    <div class="rating-stats">
                                                        <div id="rating-container-custom">
                                                            <ul class="list-show">
                                                                <li class="selected"></li>
                                                                <li class="selected"></li>
                                                                <li class="selected"></li>
                                                                <li class="disabled"></li>
                                                                <li class="disabled"></li>
                                                            </ul>
                                                        </div>
                                                        <p class="hours-element">18 hours ago</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="reviewsText">Half the lanes don't work! But it's decent for the price. Waited over 30 minutes for our drinks!!!! But yes I recommend it. It's not great but it's OK I guess</p>

                                    </div>
                                    <div class="review-info-card">
                                        <div class="review-user-mini-profile">
                                            <div class="user-photo">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/dan.jpg" alt="">
                                            </div>
                                            <div class="user-name">
                                                <p>Daniel</p>
                                                <div class="rating-element">
                                                    <div class="rating-stats">
                                                        <div id="rating-container">
                                                            <ul class="list-show">
                                                                <li class="selected"></li>
                                                                <li class="selected"></li>
                                                                <li class="selected"></li>
                                                                <li class="disabled"></li>
                                                                <li class="disabled"></li>
                                                            </ul>
                                                        </div>
                                                        <p class="hours-element">18 hours ago</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="reviewsText">Half the lanes don't work! But it's decent for the price. Waited over 30 minutes for our drinks!!!! But yes I recommend it. It's not great but it's OK I guess</p>

                                    </div>
                                    <div class="review-info-card">
                                        <div class="review-user-mini-profile">
                                            <div class="user-photo">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/dan.jpg" alt="">
                                            </div>
                                            <div class="user-name">
                                                <p>Daniel</p>
                                                <div class="rating-element">
                                                    <div class="rating-stats">
                                                        <div id="rating-container">
                                                            <ul class="list-show">
                                                                <li class="selected"></li>
                                                                <li class="selected"></li>
                                                                <li class="selected"></li>
                                                                <li class="disabled"></li>
                                                                <li class="disabled"></li>
                                                            </ul>
                                                        </div>
                                                        <p class="hours-element">18 hours ago</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="reviewsText">Half the lanes don't work! But it's decent for the price. Waited over 30 minutes for our drinks!!!! But yes I recommend it. It's not great but it's OK I guess</p>

                                    </div>
                                </div>

                                <div id="tab4" class="tab-content">
                                    <h2>Add review</h2>
                                    <form>
                                        <div class="form-group">
                                            <label for="rating-container-custom">Rating</label>
                                            <div class="rating">
                                                <input type="radio" id="star5" name="rating" value="5" />
                                                <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4" name="rating" value="4" />
                                                <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3" name="rating" value="3" />
                                                <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2" name="rating" value="2" />
                                                <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label class="star" for="star1" title="Bad" aria-hidden="true"></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Feedback</label>
                                            <textarea name="" id=""  rows="10"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-sendRating">Send</button>
                                    </form>
                                </div>
                            </div> <!-- END tabs-content -->
                        </div> <!-- END tabs -->
                    </div>
                    <!--------------------------------------- end Text description -------------------------------------- -->
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