<?php /** Template Name: Voor teachers template */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />


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
    <div class="audioBar">
    <div class="container-fluid">
       <div class="d-flex align-items-center text-center">
           <button class="codeless-player-toggle">
               <img id="down-chevron" src="<?php echo get_stylesheet_directory_uri();?>/img/down-chevron.svg" alt="">
               <img id="up-chevron" src="<?php echo get_stylesheet_directory_uri();?>/img/up-chevron.png" alt="">
           </button>
           <div class="codeless-player-info codeless-element">
               <div class="codeless-player-nav">
                   <button class="previous round livecast-play">&#8249;</button>
                   <button class="next round livecast-play">&#8250;</button>
               </div>
               <div class="codeless-player-content">
                   <h4>What is the ecosystem?</h4>
                   <p class="categorie">World</p>
               </div>
           </div>
           <div class="codeless-player-audio  codeless-element">
               <audio controls id="myAudioID">
                   <source src="horse.ogg" type="audio/ogg">
                   <source src="<?php echo get_stylesheet_directory_uri();?>/sounds/firstSounds.mp3" type="audio/mpeg">
                   Your browser does not support the audio element.
               </audio>
           </div>
       </div>
    </div>
</div>
    <div class="container-fluid">
        <div class="overElement product-podcat1">
            <div class="blockOneOver">
                <div class="titleBlock">
                    <div class="roundBlack" >
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoMobil.png" alt="company logo">
                    </div>
                    <p class="livelearnText2 text-uppercase">Livelean</p>
                </div>


                <p class="e-learningTitle">What is the ecosystem?</p>
                <!-- Image -->
                <div class="img-fluid-course img-podacast">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/ecosystem.jpeg" alt="">
                </div>
                <div class="sound-wave">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" preserveAspectRatio="none" viewBox="0 0 1440 560">
                        <g mask='url("#SvgjsMask1099")' fill="none">
                        <rect fill="#0e2a47"></rect>
                        <g transform="translate(0, 0)" stroke-linecap="round" stroke="url(#SvgjsLinearGradient1100)">
                            <path d="M375 202.15 L375 357.85" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M398 155.33 L398 404.67" stroke-width="17.25" class="bar-scale3"></path>
                            <path d="M421 196.44 L421 363.56" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M444 259.91 L444 300.09" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M467 208.25 L467 351.75" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M490 184.8 L490 375.2" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M513 249.28 L513 310.72" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M536 220.75 L536 339.25" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M559 254.8 L559 305.2" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M582 186.77 L582 373.23" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M605 210.13 L605 349.87" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M628 234.45 L628 325.55" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M651 241.1 L651 318.89" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M674 202.95 L674 357.05" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M697 165.81 L697 394.19" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M720 224.51 L720 335.49" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M743 157.59 L743 402.4" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M766 164.98 L766 395.02" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M789 158.93 L789 401.07" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M812 224.24 L812 335.76" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M835 171.73 L835 388.27" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M858 264.89 L858 295.11" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M881 175.14 L881 384.86" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M904 248.17 L904 311.83" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M927 185.4 L927 374.6" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M950 234.82 L950 325.18" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M973 229.9 L973 330.1" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M996 194.25 L996 365.75" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M1019 162.47 L1019 397.53" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M1042 205.06 L1042 354.94" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M1065 240.52 L1065 319.48" stroke-width="17.25" class="bar-scale1 "></path>
                        </g>
                        </g>
                        <defs>
                        <mask id="SvgjsMask1099">
                            <rect width="1440" height="560" fill="#ffffff"></rect>
                        </mask>
                        <linearGradient x1="360" y1="280" x2="1080" y2="280" gradientUnits="userSpaceOnUse" id="SvgjsLinearGradient1100">
                            <stop stop-color="#3a7cc3" offset="0"></stop>
                            <stop stop-color="#dd1133" offset="1"></stop>
                        </linearGradient>
                        </defs>
                    </svg>
                </div>

                <!--------------------------------------- start Text description -------------------------------------- -->
                <div class="block-description-block">
                    <p class="description-assessment-test">Ecosystem, the complex of living organisms, their physical environment, and all their interrelationships in a particular unit of space.
                    A brief treatment of ecosystems follows. For full treatment, see biosphere.</p>
                </div>
                

                <div class="customTabs">
                    <div class="tabs">
                        <ul id="tabs-nav">
                            <li><a href="#tab2">Reviews</a></li>
                            <li><a href="#tab3">Add Reviews</a></li>
                        </ul> <!-- END tabs-nav -->
                        <div id="tabs-content">
                            <div id="tab2" class="tab-content">
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
                            <div id="tab3" class="tab-content">
                                <h2>Add review</h2>
                                <form>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="exampleInputEmail1">Name</label>
                                            <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Name">
                                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                        </div>
                                        <div class="form- col-6">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
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

                <p class="title-assessment-test">Episode Timeline</p>
                <ul class="ulpodcast">
                    <li><a href="" class=""><span class="time">00:35</span>Introduction</a></li>
                    <li><a href="" class=""><span class="time">00:35</span>Exploring the topic</a></li>
                    <li><a href="" class=""><span class="time">00:35</span>A word from our guest</a></li>
                    <li><a href="" class=""><span class="time">00:35</span>Closing remarks</a></li>
                    <li><a href="" class=""><span class="time">00:35</span>Ecofarm</a></li>
                </ul>

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
<script>
          $(document).ready(function() {
            var audio = document.querySelector('audio');

            audio.onplay = function() { 
                audio.play(0);
                $(".img-podacast").addClass("hide");
                $(".sound-wave").show();
            };

            audio.addEventListener('pause', (event) => {
                $(".img-podacast").removeClass("hide");
                $(".sound-wave").hide();
            });
                

        } )
</script>


<?php get_footer(); ?>
<?php wp_footer(); ?>