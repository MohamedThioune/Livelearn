<?php /** Template Name: recruitement */ ?>


<?php 
    extract($_POST);

    extract($_GET);

    if(isset($start_adventure))
        if(isset($email)){
        
            if($email != null)
            {

                if($first_name == null)
                    $first_name = "ANONYM";
                
                if($last_name == null)
                    $last_name = "ANONYM";

                $userdata = array(
                    'user_pass' => $password,
                    'user_login' => $user_login,
                    'user_email' => $email,
                    'user_url' => 'http://livelearn.nl/',
                    'display_name' => $first_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'role' => 'Klant'
                );

                $user_id = wp_insert_user(wp_slash($userdata));

                if(is_wp_error($user_id)){
                    $danger = $user_id->get_error_message();
                    header("location:registreren?message=".$danger."&danger");

                }else{
                    $success = "U bent succesvol geregistreerd<br>";
                    update_field('telnr', $phone, 'user_'.$user_id);
                    update_field('subscription_company', $bedrij, 'user_'.$user_id);
                    
                    $subject = 'Welcome onboard ✨';
                    $body = "
                    <h1>Hello " . $first_name  . "</h1><br> 
                    Your are successfully registered , welcome onboard<br><br>
                    <h4><a href='http://livelearn.nl/inloggen'> Connexion </a></h4>
                    ";
                
                    $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );

                    wp_mail($email, $subject, $body, $headers, array( '' )) ; 
                    header("location:candidat?message=".$success."&success");
         
                }

              
            }
            else{
                $danger = "Vul de e-mail in, alsjeblieft";
                header("location:candidat?message=".$danger."&danger");
            }
        }
?>


<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />


<body class="bodyContentCandidat">
<div class="contentOne">
    <div class="headCandidat">
        <div class="container">
            <div class="blockHeadContent">
                <div class="firstBlockHeadContent">
                    <h1 class="titleBecomeMember">Hire IT specialists from Senegal and build your remote IT workforce</h1>
                    <div class="listDescription">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/VectorPoly.png" alt="">
                        <p>Attract talent from Senegal </p>
                    </div>
                    <div class="listDescription">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/VectorPoly.png" alt="">
                        <p>A dedicated team of IT professionals </p>
                    </div>
                    <div class="listDescription">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/VectorPoly.png" alt="">
                        <p>Fair price and transparent contracts</p>
                    </div>
                    <div class="listDescription">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/VectorPoly.png" alt="">
                        <p>Lifelong learning included from LiveLearn</p>
                    </div>
                    <a href="" class="btn bntStarted">Get started</a>
                </div>
                <div class="secondBlockHeadContent">
                    <div class="elemntImgRecrutement">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Developers_Senegal001.png" alt="">
                    </div>
                    <div class="cardHeadCompany">
                        <p>+1000 Developers</p>
                        <div class="logoCardCompanyBlock">
                            <div class="circleLogoCompanies lv">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoMobil.png" alt="">
                            </div>
                            <div class="circleLogoCompanies ">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Ellipse5.png" alt="">
                            </div>
                            <div class="circleLogoCompanies ">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Ellipse6.png" alt="">
                            </div>
                            <div class="circleLogoCompanies ">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Ellipse5.png" alt="">
                            </div>
                            <div class="circleLogoCompanies plus">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Ellipse6.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="contentCandidatHome">
            <h2 class="howDoesText">How does it work?</h2>
            <div class="contentCardWork">
                <div class="cardworkCandidat">
                    <div class="imgCardWork">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/group-svgrepo.png" alt="">
                    </div>
                    <p class="titleCardWork">Sign-up</p>
                    <p class="descriptionCardWork">Show interest by filling in the form below.</p>
                </div>
                <div class="cardworkCandidat">
                    <div class="imgCardWork">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/profile-svgrepo2.png" alt="">
                    </div>
                    <p class="titleCardWork">Chat</p>
                    <p class="descriptionCardWork">Have a chat with one of our experts about your goals. </p>
                </div>
                <div class="cardworkCandidat">
                    <div class="imgCardWork">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/interview-svgrep1.png" alt="">
                    </div>
                    <p class="titleCardWork">Match</p>
                    <p class="descriptionCardWork">We match you with the best talent and guide you on the job.</p>
                </div>
            </div>
        </div>
        <div class="contentSponsortBlock">
            <div class="sponsortBlock">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners1.jpeg" class="sponsortImg" alt="">
            </div>
            <div class="sponsortBlock">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners2.jpeg" class="sponsortImg" alt="">
            </div>
            <div class="sponsortBlock">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners3.jpeg" class="sponsortImg" alt="">
            </div>
            <div class="sponsortBlock">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners4.jpeg" class="sponsortImg" alt="">
            </div>
            <div class="sponsortBlock">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners5.jpeg" class="sponsortImg" alt="">
            </div>
            <div class="sponsortBlock">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners6.jpeg" class="sponsortImg" alt="">
            </div>
            <div class="sponsortBlock">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners7.jpeg" class="sponsortImg" alt="">
            </div>
            <div class="sponsortBlock">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners8.jpeg" class="sponsortImg" alt="">
            </div>
        </div>
        <div class="supportBlock">
            <h2 class="howDoesText">LiveLearn supports you and your (remote) workforce</h2>
            <div class="contentCardWork">
                <div class="cardSupportYou">
                    <div class="imgSupportYou">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/BlackVideoChat.png" alt="">
                    </div>
                    <hr class="hrWork">
                    <p class="titleCardSupportYou">Access to the brightest IT specialists </p>
                    <p class="descriptionCardSpportYou">Over the years we built a pool of 1000+ IT specialists in Senegal. We identify their skills and help you optimize your IT workforce. This is your chance to succeed in your digitalization. </p>
                </div>
                <div class="cardSupportYou">
                    <div class="imgSupportYou">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/GroupSetting.png" alt="">
                    </div>
                    <hr class="hrWork">
                    <p class="titleCardSupportYou">Onboarding, trainings and career advice</p>
                    <p class="descriptionCardSpportYou">In order to make you succeed, we take care of the whole onboarding and provide you with all tools available. The developers receive training and career advice to keep them informed of the latest developments.</p>
                </div>
                <div class="cardSupportYou">
                    <div class="imgSupportYou">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Black-Coffee.png" alt="">
                    </div>
                    <hr class="hrWork">
                    <p class="titleCardSupportYou">Dedicated team</p>
                    <p class="descriptionCardSpportYou">By working with us and our IT specialists, you can build a complete IT team instead of individual developers. We set up an online environment to have all communication at one place, so you won’t experience the distance.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="testimonialBlock">
        <div class="container">
            <h2 class="TitleTestimonial">Testimonials From Our Customers</h2>
            <p class="descriptionTestimonial">We aim for a life long learning experience for our customers, employees and ourselves.</p>
            <div>
                <div class="carousel-container">
                    <ul class="myCarouselTestimonial">
                        <li>
                            <div class="card">
                                <p class="titleCardTestimonial">They are good! </p>
                                <p class="testimonialText">At LiveLearn we use a dedicated team of developers from Senegal as well. All developers are part of the team and work on projects together. We make use of Discord and Trello to keep all communication at one place and to keep the remote workforce integrated to the whole team.</p>
                                <div class="blockImgNameCard">
                                    <div class="imgCardTestimonial">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image54.png" alt="">
                                    </div>
                                    <div>
                                        <p class="nameCardTestimonial">Daniel</p>
                                        <p class="professionTestimoniale">Manager LiveLearn</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card">
                                <p class="titleCardTestimonial">Motivated and hard working</p>
                                <p class="testimonialText">I've been working with developers from Senegal now for the last 10 months. Working with a dedicated team instead of individual developers really makes a difference and a great add-ons to our in-house developers</p>
                                <div class="blockImgNameCard">
                                    <div class="imgCardTestimonial">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Maurice_Veraa_.jpeg" alt="">
                                    </div>
                                    <div>
                                        <p class="nameCardTestimonial">Maurice</p>
                                        <p class="professionTestimoniale">Tech Lead livelearn</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card">
                                <p class="titleCardTestimonial">High quality and thinking along</p>
                                <p class="testimonialText">It’s not only giving tasks, but the team in Senegal is really thinking along with our challenges. During the project we work in sprints and every two weeks we are having a brainstorm.</p>
                                <div class="blockImgNameCard">
                                    <div class="imgCardTestimonial">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image54.png" alt="">
                                    </div>
                                    <div>
                                        <p class="nameCardTestimonial">Daniel</p>
                                        <p class="professionTestimoniale">Manager LiveLearn</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="blockFormDeveloper">
            <p class="titleForm">We are looking for a wide spectrum of developers</p>
            <div class="blockImgSkills">
                <div class="elementSkills">
                    <p>Python</p>
                    <div class="imgSkillElement">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/python.jpg" alt="">
                    </div>
                </div>
                <div class="elementSkills">
                    <p>Front-end</p>
                    <div class="imgSkillElement">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/front-end-stack.png" alt="">
                    </div>
                </div>
                <div class="elementSkills">
                    <p>FullStack</p>
                    <div class="imgSkillElement">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/full.png" alt="">
                    </div>
                </div>
                <div class="elementSkills">
                    <p>AngularJS</p>
                    <div class="imgSkillElement">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/angularjs.png" alt="">
                    </div>
                </div>
                <div class="elementSkills">
                    <p>NodeJS</p>
                    <div class="imgSkillElement">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/node.png" alt="">
                    </div>
                </div>
                <div class="elementSkills">
                    <p>Javascript</p>
                    <div class="imgSkillElement">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/javascript.png" alt="">
                    </div>
                </div>
                <div class="elementSkills">
                    <p>React</p>
                    <div class="imgSkillElement">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/react.png" alt="">
                    </div>
                </div>
                <div class="elementSkills">
                    <p>.Net</p>
                    <div class="imgSkillElement">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/net.png" alt="">
                    </div>
                </div>
                <div class="elementSkills">
                    <p>Magento</p>
                    <div class="imgSkillElement">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/magento.png" alt="">
                    </div>
                </div>
                <div class="elementSkills">
                    <p>Android</p>
                    <div class="imgSkillElement">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/android.png" alt="">
                    </div>
                </div>
                <div class="elementSkills">
                    <p>IOS</p>
                    <div class="imgSkillElement">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/ios.png" alt="">
                    </div>
                </div>
                <div class="elementSkills">
                    <p>PHP</p>
                    <div class="imgSkillElement">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/php.png" alt="">
                    </div>
                </div>
            </div>
            <center>
                <?php if(isset($_GET['success'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>" ?>
                <?php if(isset($_GET['danger'])) echo "<span class='alert alert-danger'>" . $_GET['message'] . "</span><br><br>" ?>
            </center>
            <form  action="/candidat" method="POST" class="row">
            
                <div class="col-md-6"> 
                    <div class="form-group">
                        <input type="text" name="user_login" id="name" placeholder="Usernam" class="block-input-form" required>
                    </div>
                </div>
                <div class="col-md-6"> 
                    <div class="form-group">
                        <input type="text" name="first_name" id="name" placeholder="First name" class="block-input-form" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="last_name" id="ache"  placeholder="Last name" class="block-input-form" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="email" name="email" id="emailadres" placeholder="E-mail address" class="block-input-form"  required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="tel" name="phone" id="telefo" placeholder="Phone number" class="block-input-form" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="bedrij" id="bedrij" placeholder="Current Company (leave blank if not applicable)" class="block-input-form" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="password" name="password" id="text" placeholder="Password" class="block-input-form" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="hidden" name="" >
                    </div>
                </div>
                <button type="submit" class="btn btnStart" name="start_adventure">Start the adventure</button>
            </form>
        </div>
    </div>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>

<script>
    $(document).ready(function () {
        (function ($) {
            $('.myCarouselTestimonial').owlCarousel({
                autoplay: true,
                center: true,
                items: 2,
                autoplayTimeout:2000,
            });

        })(jQuery);
    });
</script>





<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


</body>
