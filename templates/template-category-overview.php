<?php /** Template Name: category overview */ ?>
<?php 
global $wp;

$url = home_url( $wp->request );

$page = dirname(__FILE__) . '/check_visibility.php';

$url = home_url( $wp->request );

require($page); 
?>
<style>
     .checkmarkUpdated{
        background-color: white !important;
        border: 2px solid #043356 !important;
    }
    .LeerBlock {
        border-bottom: 2px solid #043356 !important;
    }
    .border-right-adapt {
        border-top-left-radius: 25px; border-bottom-left-radius: 25px;
    }
    .border-left-adapt {
        border-top-right-radius: 25px; border-bottom-right-radius: 25px;
    }
    .modal-dialog{
         width: 40% !important;
    }
    @media all and (max-width: 753px) {
        .modal-dialog{
             width: 90% !important;
        }  
        .swipeContaineEvens .swiper-wrapper .swiper-slide {
            width: 170px !important;
        }
        .custom_slide{
            width: 170px !important; 
        }
    }
    @media all and (min-width: 753px) and (max-width: 900px) {
        .modal-dialog{
             width: 70% !important;
        } 
    }

    @media all and (max-width: 764px) {
        .border-right-adapt {
            border-radius: 0px;
        }
        .border-left-adapt {
            border-radius: 0px;
        }
    }
    .modal-backdrop.show { /* to remove gray side on the bottom */
        opacity: .5;
        display: none;
    }
    
</style>
<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<?php 

    $category = ($_GET['category']) ?: ' ';

    $user_id = get_current_user_id();
    
    $courses = array();

    if($category != ' '){

        $args = array(
            'post_type' => 'course', 
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );

        $global_courses = get_posts($args);

        $opleidingen = array();
        $workshops = array();
        $masterclasses = array();
        $events = array();
        $e_learnings = array();
        $trainings = array();
        $videos = array();

        $teachers = array();

        foreach($global_courses as $course)
        {
            if(!visibility($course, $visibility_company))
                continue;
    
            /*
            * Categories
            */ 

            $category_id = 0;
            $experts = get_field('experts', $course->ID);
                        
            $tree = get_the_terms($course->ID, 'course_category');
            $tree = $tree[2]->ID;
            $categories_id = get_field('categories',  $course->ID);
            $categories_xml = get_field('category_xml',  $course->ID);
            $categories = array();

            if($categories_xml)
                foreach($categories_xml as $categorie){
                    $categorie = $categorie['value'];
                    if(!in_array($categorie, $categories))
                        array_push($categories, $categorie);
                }

            if($categories_id)
                if(!empty($categories_id)){
                    $categories = array();  
                    foreach($categories_id as $categorie)                    
                        $categories = explode(',', $categorie['value']);
                }


            if(in_array($category, $trees) || $categories)
                if(in_array($category, $trees) || in_array($category, $categories)){
                    array_push($courses, $course);
                    if(get_field('course_type', $course->ID) == "Opleidingen")
                        array_push($opleidingen, $course);
                    else if(get_field('course_type', $course->ID) == "Workshop")
                        array_push($workshops, $course);
                    else if(get_field('course_type', $course->ID) == "Masterclass")
                        array_push($masterclasses, $course);
                    else if(get_field('course_type', $course->ID) == "Event")
                        array_push($events, $course);
                    else if(get_field('course_type', $course->ID) == "E-learning")
                        array_push($e_learnings, $course);
                    else if(get_field('course_type', $course->ID) == "Training")
                        array_push($trainings, $course);
                    else if(get_field('course_type', $course->ID) == "Video")
                        array_push($videos, $course);
                    
                    if(!in_array($course->post_author, $teachers))
                        array_push($teachers, $course->post_author);

                    foreach($experts as $expertie)
                        if(!in_array($expertie, $teachers))
                            array_push($teachers, $expertie);
            }
            //Activitien
            $activitiens  = count($courses);
        }

        $name = (String)get_the_category_by_ID($category);

        $image_category = get_field('image', 'category_'. $category);
        $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/placeholder.png';

        //$logo_livelearn = get_stylesheet_directory_uri() . '/img/logoMobil.png';
        $logo_livelearn = get_stylesheet_directory_uri() . '/img/logo_livelearn.png';


        /*
        ** Categories information
        */
        //Volgend
        $users=get_users();
        foreach($users as $user)
        {
            $topics_volgers = get_user_meta($user->ID, 'topic');
            if(in_array($_GET['category'], $topics_volgers))
                $volgers++;
        }
        
        
    }

?>

<body>
<div class="contentOne">
</div>

<!-- -----------------------------------Start Modal Sign In ----------------------------------------------- -->

    <!-- Modal Sign End -->
    <div class="modal modalEcosyteme fade" id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
         style="position: absolute; ">
        <div class="modal-dialog" role="document" style="width: 96% !important; max-width: 500px !important;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">

            <div class="modal-content">
                <!-- <div class="modal-header">
                    <h2>Registreren</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> -->
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
                        <h3 class="text-center my-2">Sign In</h3>
                        <div class="text-center">
                            <p>Already a member? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                            data-toggle="modal" data-target="#exampleModalCenter">&nbsp; Sign up</a></p>
                        </div>
                    </div>  


                    <?php
                        echo (do_shortcode('[user_registration_form id="59"]'));
                    ?>

                    <div class="text-center">
                        <p>Al een account? <a href="" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                data-toggle="modal" data-target="#exampleModalCenter">Log-in</a></p>
                    </div>


                    <!-- <div class="col-md-12 mt-5">
                        <button class="btn btn-block d-flex justify-content-sm-between border border-2 p-2 justify-content-center btn-icon my-3">
                            <i class="fab fa-facebook-f text-primary ml-2" style="font-size: 19px;"></i>
                            <span class="d-sm-block d-none">Connect with Facebook</span> <span></span>
                        </button>

                        <button class="btn btn-block d-flex justify-content-sm-between border border-2 p-2 justify-content-center p-2 btn-icon my-2">
                            <i class="fab fa-google text-danger ml-2" style="font-size: 19px;"></i>
                            <span class="d-sm-block d-none">Connect with Google</span> <span></span>
                        </button>

                        <button class="btn btn-block d-flex justify-content-sm-between border border-2 p-2 justify-content-center p-2 btn-icon my-3">
                            <i class="fab fa-apple text-dark ml-2" style="font-size: 22px;"></i>
                            <span class="d-sm-block d-none">Connect with Apple</span> <span></span>
                        </button>

                        <div class="text-center py-3">
                            <a href="" class="font-weight-normal">Any problem of connection ?</a>
                        </div>
                    </div> -->

                    <!-- <div id="nsl-custom-login-form-1"><div class="nsl-container nsl-container-block nsl-container-embedded-login-layout-below" data-align="left" style="display: block;"><div class="nsl-container-buttons"><a href="http://localhost/livelearn/login/?loginSocial=google&amp;redirect=http%3A%2F%2Flocalhost%2Flivelearn%2Fcategory-overview%2F" rel="nofollow" aria-label="Continue with <b>Google</b>" data-plugin="nsl" data-action="connect" data-provider="google" data-popupwidth="600" data-popupheight="600"><div class="nsl-button nsl-button-default nsl-button-google customSocialMedia" data-skin="light" style="background-color:#fff;"><div class="nsl-button-svg-container"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#4285F4" d="M20.64 12.2045c0-.6381-.0573-1.2518-.1636-1.8409H12v3.4814h4.8436c-.2086 1.125-.8427 2.0782-1.7959 2.7164v2.2581h2.9087c1.7018-1.5668 2.6836-3.874 2.6836-6.615z"></path><path fill="#34A853" d="M12 21c2.43 0 4.4673-.806 5.9564-2.1805l-2.9087-2.2581c-.8059.54-1.8368.859-3.0477.859-2.344 0-4.3282-1.5831-5.036-3.7104H3.9574v2.3318C5.4382 18.9832 8.4818 21 12 21z"></path><path fill="#FBBC05" d="M6.964 13.71c-.18-.54-.2822-1.1168-.2822-1.71s.1023-1.17.2823-1.71V7.9582H3.9573A8.9965 8.9965 0 0 0 3 12c0 1.4523.3477 2.8268.9573 4.0418L6.964 13.71z"></path><path fill="#EA4335" d="M12 6.5795c1.3214 0 2.5077.4541 3.4405 1.346l2.5813-2.5814C16.4632 3.8918 14.426 3 12 3 8.4818 3 5.4382 5.0168 3.9573 7.9582L6.964 10.29C7.6718 8.1627 9.6559 6.5795 12 6.5795z"></path></svg></div><div class="nsl-button-label-container">Continue with <b>Google</b></div></div></a><a href="http://localhost/livelearn/login/?loginSocial=twitter&amp;redirect=http%3A%2F%2Flocalhost%2Flivelearn%2Fcategory-overview%2F" rel="nofollow" aria-label="Continue with <b>Twitter</b>" data-plugin="nsl" data-action="connect" data-provider="twitter" data-popupwidth="600" data-popupheight="600"><div class="nsl-button nsl-button-default nsl-button-twitter customSocialMedia" style="background-color:#4ab3f4;"><div class="nsl-button-svg-container"><svg xmlns="http://www.w3.org/2000/svg"><path fill="#fff" d="M16.327 3.007A5.07 5.07 0 0 1 20.22 4.53a8.207 8.207 0 0 0 2.52-.84l.612-.324a4.78 4.78 0 0 1-1.597 2.268 2.356 2.356 0 0 1-.54.384v.012A9.545 9.545 0 0 0 24 5.287v.012a7.766 7.766 0 0 1-1.67 1.884l-.768.612a13.896 13.896 0 0 1-9.874 13.848c-2.269.635-4.655.73-6.967.276a16.56 16.56 0 0 1-2.895-.936 10.25 10.25 0 0 1-1.394-.708L0 20.023a8.44 8.44 0 0 0 1.573.06c.48-.084.96-.06 1.405-.156a10.127 10.127 0 0 0 2.956-1.056 5.41 5.41 0 0 0 1.333-.852 4.44 4.44 0 0 1-1.465-.264 4.9 4.9 0 0 1-3.12-3.108c.73.134 1.482.1 2.198-.096a3.457 3.457 0 0 1-1.609-.636A4.651 4.651 0 0 1 .953 9.763c.168.072.336.156.504.24.334.127.68.22 1.033.276.216.074.447.095.673.06H3.14c-.248-.288-.653-.468-.901-.78a4.91 4.91 0 0 1-1.105-4.404 5.62 5.62 0 0 1 .528-1.26c.008 0 .017.012.024.012.13.182.28.351.445.504a8.88 8.88 0 0 0 1.465 1.38 14.43 14.43 0 0 0 6.018 2.868 9.065 9.065 0 0 0 2.21.288 4.448 4.448 0 0 1 .025-2.28 4.771 4.771 0 0 1 2.786-3.252 5.9 5.9 0 0 1 1.093-.336l.6-.072z"></path></svg></div><div class="nsl-button-label-container">Continue with <b>Twitter</b></div></div></a></div></div></div> -->

                </div>
            </div>


            <!-- new modal form meetup -->
            <!-- <div class="modal-content px-5">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form>

                        <div class="mb-4">
                            <div class="text-center">
                                <img style="width: 53px" src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="">     
                            </div>  
                            <h3 class="text-center my-2">Sign In</h3>
                            <div class="text-center">
                                <p>Already a member? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                                data-toggle="modal" data-target="#exampleModalCenter">Sign up</a></p>
                            </div>
                        </div>  
                    
                    
                      
                        <button class="btn btn-block d-flex justify-content-sm-between border border-2 p-2 justify-content-center p-2 btn-icon my-3">
                            <i class="fab fa-facebook-f text-primary ml-2" style="font-size: 19px;"></i>
                            <span class="d-sm-block d-none">Connect with Facebook</span> <span></span>
                        </button>

                        <button class="btn btn-block d-flex justify-content-sm-between border border-2 p-2 justify-content-center p-2 btn-icon my-2">
                            <i class="fab fa-google text-danger ml-2" style="font-size: 19px;"></i>
                            <span class="d-sm-block d-none">Connect with Google</span> <span></span>
                        </button>

                        <button class="btn btn-block d-flex justify-content-sm-between border border-2 p-2 justify-content-center p-2 btn-icon my-3">
                            <i class="fab fa-apple text-dark ml-2" style="font-size: 22px;"></i>
                            <span  class="d-sm-block d-none">Connect with Apple</span> <span></span>
                        </button>

                        <button class="btn btn-block d-flex justify-content-sm-between border border-2 p-2 justify-content-center p-2 btn-icon my-3"
                        data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal">
                            <i class="far fa-envelope text-dark ml-2" style="font-size: 22px;"></i>
                            <span class="d-sm-block d-none">Sign in with email address</span> <span></span>
                        </button>

                    </form>
                </div>
            
            </div> -->
           

        </div>
    </div>

    <!-- -------------------------------------------------- End Modal Sign In-------------------------------------- -->

    <!-- -------------------------------------- Start Modal Sign Up ----------------------------------------------- -->

    <div class="modal modalEcosyteme fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
         style="position: absolute; ">
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
                        <h3 class="text-center my-2">Sign Up</h3>
                        <div class="text-center">
                            <p>Not an account? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                            data-toggle="modal" data-target="#SignInWithEmail">&nbsp; Sign in</a></p>
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

            <!-- modals from meetup -->
            <!-- <div class="modal-content px-5">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body">
                    <form id="form" class="form">

                        <div class="mb-4">
                            <div class="text-center">
                                <img style="width: 53px" src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="">     
                            </div>
                            <h3 class="text-center my-2">Sign Up</h3>
                            <div class="text-center">
                                <p>Not an account? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                                data-toggle="modal" data-target="#SignInWithEmail">Sign in</a></p>
                            </div>
                        </div>
                       
                        <div class="mb-4 form-outline">
                            <label class="form-label" for="email">Adresse e-mail</label>
                            <input type="email" class="form-control" placeholder="a@florin-pop.com" id="email" />
                        </div>
                        
                        
                        <div class="form-outline mb-4">
                            <div class="row mb-2 d-flex justify-content-between">
                                <div class="col-md-5">
                                    <label class="form-check-label" for="password"> Password </label>
                                </div>                               
                                <div class="col d-flex justify-content-end">
                                    <a href="" class="px-0">Mot de passe oublié?</a>
                                </div>
                            </div>
                        
                            <div class="input-group" id="show_hide_password">
                                <input type="password" id="password" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background-color: white; height: 38px;"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                                </div>
                            </div>
                        </div>
                            
                        <div class="row mb-4">
                            <div class="col-12 d-flex justify-content-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="form2Example34" checked />
                                    <label class="form-check-label" for="form2Example34">Stay connected </label>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-block mb-5 p-2" style="background-color: #F77070;"> 
                            <span class="text-white font-weight-bold " style="font-size: 20px;"> Sign up</span>
                        </button>


                        <p><hr/></p>
                    
                        <div class="col-md-12 mt-5">
                            <button class="btn btn-block d-flex justify-content-sm-between border border-2 p-2 justify-content-center btn-icon my-3">
                                <i class="fab fa-facebook-f text-primary ml-2" style="font-size: 19px;"></i>
                                <span class="d-sm-block d-none">Connect with Facebook</span> <span></span>
                            </button>

                            <button class="btn btn-block d-flex justify-content-sm-between border border-2 p-2 justify-content-center p-2 btn-icon my-2">
                                <i class="fab fa-google text-danger ml-2" style="font-size: 19px;"></i>
                                <span class="d-sm-block d-none">Connect with Google</span> <span></span>
                            </button>

                            <button class="btn btn-block d-flex justify-content-sm-between border border-2 p-2 justify-content-center p-2 btn-icon my-3">
                                <i class="fab fa-apple text-dark ml-2" style="font-size: 22px;"></i>
                                <span class="d-sm-block d-none">Connect with Apple</span> <span></span>
                            </button>

                            <div class="text-center py-3">
                                <a href="" class="font-weight-normal">Any problem of connection ?</a>
                            </div>
                        </div>

                    </form>
                </div>
                
            </div> -->

        </div>
    </div>

    <!-- -------------------------------------------------- End Modal Sign Up-------------------------------------- -->


<!-- ------------------------------------------ start Header -------------------------------------- -->
<div class="head2" style="margin-top: -10px !important;">
    <div class="comp1">
        <img src="<?php echo $image_category; ?>" alt="">
    </div>
    <div class="elementText3">
        <p class="liverTilteHead2"><?php echo $name ?></p>
        <div>
            <form action="../dashboard/user/" method="POST">
                <input type="hidden" name="meta_value" value="<?php echo $category ?>" id="">
                <input type="hidden" name="user_id" value="<?=$user_id;?>" id="">
                <div>
                    <?php
                        if($user_id != 0)
                        {
                            $topics_internal = get_user_meta($user_id,'topic_affiliate');
                            $topics_external = get_user_meta($user_id,'topic');
                            if (in_array($category, $topics_internal)){
                                echo '<input type="hidden" name="meta_key" value="topic_affiliate" id="">';
                                echo "<a href='#' class='btn btn-info rounded-pill text-white font-weight-bold p-1 px-2'>verwijder uit leeromgeving</a>";
                            }
                            else if(in_array($category, $topics_external)){
                                echo '<input type="hidden" name="meta_key" value="topic" id="">';
                                echo "<button type='submit' class='btn btn-danger rounded-pill text-white font-weight-bold p-1 px-2' name='delete' >verwijder uit leeromgeving</button>";
                            }else{
                                echo '<input type="hidden" name="meta_key" value="topic" id="">';
                                echo "<button type='submit' style='background: #00A89D'
                                class='btn btn-success rounded-pill text-white font-weight-bold p-1 px-2' name='interest_push' >Toevoegen aan Leeromgeving</button>";   
                            }    

                            echo "<img style='height: 30px;' class='rounded-pill' src='" . $logo_livelearn . "' alt=''>";
                        }
                        
                    ?>
                </div>
            </form> 

                <?php
                
                if($user_id == 0){
                ?> 
                <div>
                    <button data-toggle='modal' data-target='#SignInWithEmail' aria-label='Close' data-dismiss='modal' class='btn rounded-pill text-white font-weight-bold p-1 px-2'
                        style='background: #00A89D'>Toevoegen aan Leeromgeving</button>
                    <img style="height: 30px;" class="rounded-pill" src="<?php echo $logo_livelearn; ?>" alt="">
                </div>

                <?php
                }
                ?>
        </div>

        <div class="row  mt-4 d-flex justify-content-center">
            <div class="col-md-2 col-lg-1 col-sm-5 col-5 bg-light border border-dark py-md-3 py-1 border-right-adapt">
                <span class="text-dark font-weight-bold h5 pt-2">

                <?php 
                    if ($volgers!=null && $volgers!=0)
                        echo $volgers;
                    else
                        echo '0';

                ?> 

                </span>
                <p class="text-secondary font-weight-bold m-0">Volgers</p>
            </div>

            <!-- <div class="col-md-1 col-3 bg-light border border-dark py-md-3 py-1">
                <span class="text-dark font-weight-bold h5 pt-2">0</span>
                <p class="text-secondary font-weight-bold m-0">Impact</p>
            </div> -->
            <!-- <div class="col-md-1 col-3 bg-light border border-dark py-md-3 py-1">
                <span class="text-dark font-weight-bold h5 pt-2">
                </span>
                <p class="text-secondary font-weight-bold m-0">Activiteiten</p>
            </div> -->

             <div class="col-md-2 col-lg-1 col-sm-5 col-5 bg-light border border-dark py-md-3 py-1 border-left-adapt">
                <span class="text-dark font-weight-bold h5 pt-2">

                <?php 
                    if ($activitiens!=null && $activitiens!=0)
                        echo $activitiens;
                    else
                        echo '0';

                ?>

                </span>
                <p class="text-secondary font-weight-bold m-0">Activiteiten</p>
            </div>           
        </div>

    </div>
    <div>
       
    </div>
   
</div>
<!-- ------------------------------------------ end Header -------------------------------------- -->


<div class="firstBlock">
    <div class="row">

        <!-- ------------------------------------ Start Slide bar ---------------------------------------- -->
        <div class="col-md-3 ">
            <div class="sousProductTest Mobelement pr-4" style="background: #F4F7F6;color: #043356;">
                <form action="/product-search/" method="POST">
                    <div class="LeerBlock pl-4" style="">
                        <div class="leerv">
                            <p class="sousProduct1Title" style="color: #043356;">LEERVORM</p>
                            <button class="btn btnClose" id="hide">
                                <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/X.png" alt=""> -->
                                <i class="bi bi-x text-dark" style="font-size: 35px"></i>
                            </button>
                        </div>
                        <input type="hidden" name="category" value="<?php echo $_GET['category'] ?>">
                        <div class="checkFilter">
                            <label class="contModifeCheck">Opleiding
                                <input style="color:red;" type="checkbox" id="opleiding" name="leervom[]" value="Opleidingen">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Masterclass
                                <input type="checkbox" id="masterclass" name="leervom[]" value="Masterclass">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Workshop
                                <input type="checkbox" id="workshop" name="leervom[]" value="Workshop">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">E-Learning
                                <input type="checkbox" id="learning" name="leervom[]" value="E-learning">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Event
                                <input type="checkbox" id="event" name="leervom[]" value="Event">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div> 
                        <div class="checkFilter">
                            <label class="contModifeCheck">Video
                                <input type="checkbox" id="event" name="leervom[]" value="Video">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div> 
                        <div class="checkFilter">
                            <label class="contModifeCheck">Training
                                <input type="checkbox" id="event" name="leervom[]" value="Training">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div> 
                        <br>
                    </div>
                    <div class="LeerBlock pl-4" >
                        <p class="sousProduct1Title" style="color: #043356;">PRIJS</p>
                        <div class="prijsSousBlock" style="color: #043356;">
                            <span class="vanafText" style="color: #043356">Vanaf</span>
                            <input name="min" style="width:100px;" class="btn btnmin text-left" placeholder="€min">              
                        </div>
                        <div class="prijsSousBlock" style="color: #043356;">
                            <span class="vanafText" style="color: #043356">tot</span>
                            &nbsp; &nbsp;&nbsp;&nbsp;
                            <input name="max" style="width:100px" class="btn btnmin text-left" placeholder="€max">                
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Alleen gratis
                                <input type="checkbox" id="Allen" name="gratis">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                    </div>
                    <div class="LeerBlock pl-4">
                        <p class="sousProduct1Title" style="color: #043356;">LOCATIE</p>
                        <div class="inputSearchFilter">
                            <input type="hidden" name="choice" value="3">
                            <input type="search" name="locate" style="width:150px"  class="searchLocFilter" placeholder="&nbsp;Postcode">
                        </div>    
                        <div class="inputSearchFilter">
                            <input type="hidden" name="choice" value="3">
                            <input type="search" name="range" style="width:150px"  class="searchLocFilter" placeholder="&nbsp;Afstand(m)">
                            <!-- <input type="search" name="range" class="btb btnSubmitFilter" placeholder="">  -->
                        </div>               
                        <div class="checkFilter">
                            <label class="contModifeCheck">Alleen online
                                <input type="checkbox" id="Alleen-online" name="online" value="0">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                    </div>

                    <div class="LeerBlock pl-4">
                        <p class="sousProduct1Title" style="color: #043356;">EXPERTS</p>
                        <?php
                       if (is_object( $arg ) || is_array( $arg ))
                            foreach($teachers as $teacher){
                                if($teacher != $user_id)
                                    $name = get_userdata($teacher)->data->display_name;
                                else
                                    $name = "Ikzelf";                                
                        ?>
                        <div class="checkFilter">
                            <label class="contModifeCheck"><?php echo $name ?>
                                <input type="checkbox" id="sales" name="experties[]" value="<?php echo $teacher; ?>">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <?php
                            }
                        ?>

                        <br><button type="submit" class="btn btn-default" style="background:#C0E9F4; padding:5px 20px;">Apply</button> 
                    </div>


                </form>

            </div>
            <div class="mob filterBlock">
                <p class="fliterElementText">Filter</p>
                <button class="btn btnIcone8" id="show"><img src="<?php echo get_stylesheet_directory_uri();?>/img/filter.png" alt=""></button>
            </div>
        </div>
        <!-- ------------------------------------ End  Slide bar ---------------------------------------- -->                    

        <br><br>
       <!-- ------------------------------------------ Start Content ------------------------------------ -->
        <?php 
            if(isset($courses) && !empty($courses)){
            ?>
        <div class="col-md-9">
            <?php
                if(!empty($opleidingen)){                    
            ?>
            <div class="sousProductTest2 opleiBlock">
                <div class="sousBlockProduct2">
                    <p class="sousBlockTitleProduct">Opleidingen</p>
                    <div class="blockCardOpleidingen ">

                        <div class="swiper-container swipeContaine4">
                            <div class="swiper-wrapper">
                            <?php
                            foreach($opleidingen as $course){
                                if(!visibility($course, $visibility_company))
                                    continue;
                
                                $day = ' ';
                                $month = '';
                                if($category == ' '){
                                $category_str = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]); 
                                $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                                if($category_str != 0)
                                    $category = (String)get_the_category_by_ID($category_str);
                                else if($category_id != 0)
                                    $category = (String)get_the_category_by_ID($category_id);                                    
                                }

                                $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];    

                                $dates = get_field('dates', $course->ID);
                                if($dates){
                                    
                                    $day = explode('-', explode(' ', $dates[0]['date'])[0])[2];
                                    $month = explode('-', explode(' ', $dates[0]['date'])[0])[1];
        
                                    $month = $calendar[$month]; 
                                   
                                }else{
                                    $data = get_field('data_locaties', $course->ID);
                                    if($data){
                                        $date = $data[0]['data'][0]['start_date'];

                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        
                                        $location = $data[0]['data'][0]['location'];
                                    }
                                    else{
                                        $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                                        $date = $data[0];
                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        $location = $data[2];
                                    }
                                }
                               
                                /*
                                * Price 
                                */
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                                else 
                                    $price = 'Gratis';

                                /*
                                * Thumbnails
                                */ 
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail){
                                    $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                                }

                                //Image author of this post 
                                $image_author = get_field('profile_img',  'user_' . $course->post_author);
                            ?>
                                <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4">
                                    <div class="cardKraam2">
                                        <div class="headCardKraam">
                                            <div class="blockImgCardCour">
                                                <img src="<?php echo $thumbnail ?>" alt="">
                                            </div>
                                            <div class="blockgroup7">
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $category ?></p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo get_field('degree', $course->ID);?> </p>
                                                    </div>
                                                </div>
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $day . " " . $month ?> </p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $price ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contentCardProd">
                                            <div class="group8">
                                                <div class="imgTitleCours">
                                                    <div class="imgCoursProd">
                                                        <img src="<?php echo $image_author ?>" alt="">
                                                    </div>
                                                    <p class="nameCoursProd"> <?php echo(get_userdata($course->post_author)->data->display_name); ?> </p>
                                                </div>
                                                <div class="group9">
                                                    <div class="blockOpein">
                                                        <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                        <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                                    </div>
                                                    <div class="blockOpein">
                                                        <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                        <p class="lieuAm">Amsterdam</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="werkText"><?php echo $course->post_title ?></p>
                                            <p class="descriptionPlatform">
                                                <?php echo get_field('short_description', $course->ID);?>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            <?php
                                }
                            ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php
                 }
            ?>

           

            <?php
                if(!empty($workshops)){
            ?>
            <div class="sousBlockProduct2">
                <p class="sousBlockTitleProduct">Workshops</p>
                <div class="blockCardOpleidingen ">

                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
                            <?php
                            foreach($workshops as $course){
                                if(!visibility($course, $visibility_company))
                                    continue;
                
                                $day = '~';
                                $month = '';
                                /*
                                * Categories and Date
                                */  
                                $tree = get_the_category($course->ID);
                                if($tree){
                                    if(isset($tree[2]))
                                        $category = $tree[2]->cat_name;
                                    else 
                                        if(isset($tree[1]))
                                            $category = $tree[1]->cat_name;
                                }else 
                                    $category = ' ~ ';

                                $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];    

                                $dates = get_field('dates', $course->ID);
                                if($dates){
                                    
                                    $day = explode('-', explode(' ', $dates[0]['date'])[0])[2];
                                    $month = explode('-', explode(' ', $dates[0]['date'])[0])[1];
        
                                    $month = $calendar[$month]; 
                                   
                                }else{
                                    $data = get_field('data_locaties', $course->ID);
                                    if($data){
                                        $date = $data[0]['data'][0]['start_date'];

                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        
                                        $location = $data[0]['data'][0]['location'];
                                    }
                                    else{
                                        $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                                        $date = $data[0];
                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        $location = $data[2];
                                    }
                                }
                               
                                /*
                                * Price 
                                */
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                                else 
                                    $price = 'Gratis';

                                /*
                                * Thumbnails
                                */ 
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail){
                                    $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                                }

                                //Image author of this post 
                                $image_author = get_field('profile_img',  'user_' . $course->post_author);
                            ?>
                            <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="<?php echo $thumbnail ?>" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $category ?> </p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo get_field('degree', $course->ID);?> </p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $day . " " . $month ?> </p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $price ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img width="17" src="<?php echo $image_author ?> " alt="" >
                                                </div>
                                                <p class="nameCoursProd">
                                                    <?php echo(get_userdata($course->post_author)->data->display_name); ?>
                                                </p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                    <p class="lieuAm"> <?php echo get_field('course_type', $course->ID) ?> </p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText"><?php echo $course->post_title; ?></p>
                                        <p class="descriptionPlatform">
                                            <?php echo get_field('short_description', $course->ID);?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <?php
                                }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
            <?php
                }
            ?>

            <?php
                if(!empty($masterclasses)){
            ?>
            <div class="sousBlockProduct2">
                <p class="sousBlockTitleProduct">Masterclasses</p>
                <div class="blockCardOpleidingen ">

                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
                            <?php
                            foreach($masterclasses as $course){
                                if(!visibility($course, $visibility_company))
                                    continue;
                
                                $day = ' ';
                                $month = '';
                                $hour = ' ';
                                $minute = '';
                                /*
                                * Categories and Date
                                */    
                                $tree = get_the_category($course->ID);
                                if($tree){
                                    if(isset($tree[2]))
                                        $category = $tree[2]->cat_name;
                                    else 
                                        if(isset($tree[1]))
                                            $category = $tree[1]->cat_name;
                                }else 
                                    $category = ' ';

                                $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];    

                                $dates = get_field('dates', $course->ID);
                                if($dates){
                                    
                                    $day = explode('-', explode(' ', $dates[0]['date'])[0])[2];
                                    $month = explode('-', explode(' ', $dates[0]['date'])[0])[1];
        
                                    $month = $calendar[$month]; 

                                    $hour = explode(':', explode(' ', $dates[0]['date'])[1])[0];
                                    $minute = explode(':', explode(' ', $dates[0]['date'])[1])[1];
                                   
                                }else{
                                    $data = get_field('data_locaties', $course->ID);
                                    if($data){
                                        $date = $data[0]['data'][0]['start_date'];

                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        
                                        $location = $data[0]['data'][0]['location'];
                                    }
                                    else{
                                        $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                                        $date = $data[0];
                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        $location = $data[2];
                                    }
                                    
                                }

                                /*
                                * Price 
                                */
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price =  number_format($p, 2, '.', ',') . ",-";
                                else 
                                    $price = 'Gratis';

                                /*
                                * Thumbnails
                                */ 
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail){
                                    $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                                }

                                //Image author of this post 
                                $image_author = get_field('profile_img',  'user_' . $course->post_author);
                            ?>
                            <a href="<?php echo get_permalink($course->ID) ?>"  class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="<?php echo $thumbnail ?>" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $category ?> </p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo get_field('degree', $course->ID);?> </p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $day . " " . $month ?> </p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $price ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img width="17" src="<?php echo $image_author ?> " alt="" >
                                                </div>
                                                <p class="nameCoursProd"> <?php echo(get_userdata($course->post_author)->data->display_name); ?> </p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                    <p class="lieuAm"> <?php echo get_field('course_type', $course->ID) ?> </p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText"><?php echo $course->post_title; ?></p>
                                        <p class="descriptionPlatform">
                                            <?php echo get_field('short_description', $course->ID);?> 
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <?php
                                }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
            <?php
                }
            ?>

            <?php
                if(!empty($events)){
            ?>
            <div class="sousBlockProduct6">
                <p class="sousBlockTitleProduct">Events</p>
                <div class="blockCardOpleidingen">

                    <div class="swiper-container swipeContaineEvens">
                        <div class="swiper-wrapper">

                            <?php
                            foreach($events as $course){
                                if(!visibility($course, $visibility_company))
                                    continue;

                                $day = ' ';
                                $month = '';
                                $hour = ' ';
                                $minute = '';
                                if($category == ' '){
                                $category_str = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]); 
                                $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                                if($category_str != 0)
                                    $category = (String)get_the_category_by_ID($category_str);
                                else if($category_id != 0)
                                    $category = (String)get_the_category_by_ID($category_id);                                    
                            }

                                $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];    

                                $dates = get_field('dates', $course->ID);
                                if($dates){
                                    
                                    $day = explode('-', explode(' ', $dates[0]['date'])[0])[2];
                                    $month = explode('-', explode(' ', $dates[0]['date'])[0])[1];
        
                                    $month = $calendar[$month]; 

                                    $hour = explode(':', explode(' ', $dates[0]['date'])[1])[0];
                                    $minute = explode(':', explode(' ', $dates[0]['date'])[1])[1];
                                   
                                }else{
                                    $data = get_field('data_locaties', $course->ID);
                                    if($data){
                                        $date = $data[0]['data'][0]['start_date'];

                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        
                                        $location = $data[0]['data'][0]['location'];
                                    }
                                    else{
                                        $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                                        $date = $data[0];
                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        $location = $data[2];
                                    }
                                    
                                }

                                /*
                                * Price 
                                */
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                                else 
                                    $price = 'Gratis';

                                /*
                                * Thumbnails
                                */ 
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail){
                                    $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                                }

                                //Image author of this post 
                                $image_author = get_field('profile_img',  'user_' . $course->post_author);
                            ?>
                            <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide">
                                <div class="cardKraam1 cardKraamTest">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour2">
                                            <img src="<?php echo $thumbnail ?>" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/hours.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $hour ."h". $minute ?> </p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $day . " " . $month ?> </p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $price ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <p class="werkText"><?php echo $course->post_title; ?></p>
                                        <p class="descriptionPlatform">
                                            <?php echo get_field('short_description', $course->ID);?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <?php
                                   
                                }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <?php
                }
            ?>

            <?php 
                if(!empty($e_learnings)){
            ?>
            <div class="sousBlockProduct2">
                <p class="sousBlockTitleProduct">E-Learnings</p>
                <div class="blockCardOpleidingen ">
                                
                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
                            <?php
                            foreach($e_learnings as $course){
                                if(!visibility($course, $visibility_company))
                                    continue;
                    
                                $day = '~';
                                $month = '';
                                if($category == ' '){
                                $category_str = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]); 
                                $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                                if($category_str != 0)
                                    $category = (String)get_the_category_by_ID($category_str);
                                else if($category_id != 0)
                                    $category = (String)get_the_category_by_ID($category_id);                                    
                            }

                                $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];    

                                $dates = get_field('dates', $course->ID);
                                if($dates){
                                    
                                    $day = explode('-', explode(' ', $dates[0]['date'])[0])[2];
                                    $month = explode('-', explode(' ', $dates[0]['date'])[0])[1];
        
                                    $month = $calendar[$month]; 
                                   
                                }else{
                                    $data = get_field('data_locaties', $course->ID);
                                    if($data){
                                        $date = $data[0]['data'][0]['start_date'];

                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        
                                        $location = $data[0]['data'][0]['location'];
                                    }
                                    else{
                                        $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                                        $date = $data[0];
                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        $location = $data[2];
                                    }
                                    
                                }

                                /*
                                * Price 
                                */
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                                else 
                                    $price = 'Gratis';

                                /*
                                * Thumbnails
                                */ 
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail){
                                    $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                                }

                                //Image author of this post 
                                $image_author = get_field('profile_img',  'user_' . $course->post_author);
                            ?>
                            <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="<?php echo $thumbnail ?>" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText"><?php echo $category ?></p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText"><?php echo get_field('degree', $course->ID);?></p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText"><?php echo $day . " " . $month ?></p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText"><?php echo $price ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img width="17" src="<?php echo $image_author ?> " alt="" >
                                                </div>
                                                <p class="nameCoursProd"><?php echo(get_userdata($course->post_author)->data->display_name); ?></p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                    <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText"><?php echo $course->post_title; ?></p>
                                        <p class="descriptionPlatform">
                                            <?php echo get_field('short_description', $course->ID);?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <?php
                                }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
            <?php 
                }
            ?>

            <?php
                if(!empty($trainings)){
            ?>

            <div class="sousBlockProduct2">
                <p class="sousBlockTitleProduct">Trainings</p>
                <div class="blockCardOpleidingen ">

                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
                            <?php
                            foreach($trainings as $course){
                                if(!visibility($course, $visibility_company))
                                    continue;
                                    
                                /*
                                * Categories
                                */
                                $category = ' '; 

                                $tree = get_the_terms($course->ID, 'course_category'); 

                                if($tree)
                                    if(isset($tree[2]))
                                        $category = $tree[2]->name;

                                $category_id = 0;
                            
                                if($category == ' '){
                                $category_str = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]); 
                                $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                                if($category_str != 0)
                                    $category = (String)get_the_category_by_ID($category_str);
                                else if($category_id != 0)
                                    $category = (String)get_the_category_by_ID($category_id);                                    
                            }

                                $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];    

                                $dates = get_field('dates', $course->ID);
                                if($dates){
                                    
                                    $day = explode('-', explode(' ', $dates[0]['date'])[0])[2];
                                    $month = explode('-', explode(' ', $dates[0]['date'])[0])[1];
        
                                    $month = $calendar[$month]; 
                                   
                                }else{
                                    $data = get_field('data_locaties', $course->ID);
                                    if($data){
                                        $date = $data[0]['data'][0]['start_date'];

                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        
                                        $location = $data[0]['data'][0]['location'];
                                    }
                                    else{
                                        $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                                        $date = $data[0];
                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        $location = $data[2];
                                    }
                                }
                               
                                /*
                                * Price 
                                */
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                                else 
                                    $price = 'Gratis';

                               /*
                                * Thumbnails
                                */ 
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail){
                                    $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                                }

                                //Image author of this post 
                                $image_author = get_field('profile_img',  'user_' . $course->post_author);
                                $image_author = $image_author ? $image_author : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                            ?>
                            <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="<?php echo $thumbnail ?>" alt="">
                                            
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $category ?> </p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo get_field('degree', $course->ID);?> </p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $day . " " . $month ?> </p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $price ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img width="17" src="<?php echo $image_author ?> " alt="" >
                                                </div>
                                                <p class="nameCoursProd">
                                                    <?php echo(get_userdata($course->post_author)->data->display_name); ?>
                                                </p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                    <p class="lieuAm"> <?php echo get_field('course_type', $course->ID) ?> </p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText"><?php echo $course->post_title; ?></p>
                                        <p class="descriptionPlatform">
                                            <?php echo get_field('short_description', $course->ID);?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <?php
                                }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
            <?php
                }
            ?>

            <?php
                if(!empty($videos)){
            ?>

            <div class="sousBlockProduct2">
                <p class="sousBlockTitleProduct">Videos</p>
                <div class="blockCardOpleidingen ">

                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
                            <?php
                            foreach($videos as $course){
                                if(!visibility($course, $visibility_company))
                                    continue;
                
                                    
                                /*
                                * Categories
                                */
                                $category = ' '; 

                                $tree = get_the_terms($course->ID, 'course_category'); 

                                if($tree)
                                    if(isset($tree[2]))
                                        $category = $tree[2]->name;

                                $category_id = 0;
                            
                                if($category == ' '){
                                $category_str = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]); 
                                $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                                if($category_str != 0)
                                    $category = (String)get_the_category_by_ID($category_str);
                                else if($category_id != 0)
                                    $category = (String)get_the_category_by_ID($category_id);                                    
                            }

                                $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];    

                                $dates = get_field('dates', $course->ID);
                                if($dates){
                                    
                                    $day = explode('-', explode(' ', $dates[0]['date'])[0])[2];
                                    $month = explode('-', explode(' ', $dates[0]['date'])[0])[1];
        
                                    $month = $calendar[$month]; 
                                   
                                }else{
                                    $data = get_field('data_locaties', $course->ID);
                                    if($data){
                                        $date = $data[0]['data'][0]['start_date'];

                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        
                                        $location = $data[0]['data'][0]['location'];
                                    }
                                    else{
                                        $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                                        $date = $data[0];
                                        $day = explode('/', explode(' ', $date)[0])[0];
                                        $month = explode('/', explode(' ', $date)[0])[1];
                                        $month = $calendar[$month];
                                        $location = $data[2];
                                    }
                                }
                               
                                /*
                                * Price 
                                */
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                                else 
                                    $price = 'Gratis';

                               /*
                                * Thumbnails
                                */ 
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail){
                                    $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                                }

                                //Image author of this post 
                                $image_author = get_field('profile_img',  'user_' . $course->post_author);
                                $image_author = $image_author ? $image_author : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                            ?>
                            <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="<?php echo $thumbnail ?>" alt="">
                                            
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $category ?> </p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo get_field('degree', $course->ID);?> </p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $day . " " . $month ?> </p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $price ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img width="17" src="<?php echo $image_author ?> " alt="" >
                                                </div>
                                                <p class="nameCoursProd">
                                                    <?php echo(get_userdata($course->post_author)->data->display_name); ?>
                                                </p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                    <p class="lieuAm"> <?php echo get_field('course_type', $course->ID) ?> </p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText"><?php echo $course->post_title; ?></p>
                                        <p class="descriptionPlatform">
                                            <?php echo get_field('short_description', $course->ID);?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <?php
                                }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
            <?php
                }
            ?>
         <div class="sousBlockProduct3 mx-3 mx-md-0">
            <p class="sousBlockTitleProduct">Expert</p>
            <div class="blockSousblockTitle">
                <div class="swiper-container swipeContaineEvens">
                    <div class="swiper-wrapper">
                        <?php
                        foreach($teachers as $teacher){
                            $image = get_field('profile_img',  'user_' . $teacher);
                            $path = "../user-overview?id=" . $teacher;
                            if(!$image)
                                $image = get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                            if($teacher != $user_id)
                                $name = get_userdata($teacher)->data->display_name;
                            else
                                $name = "Ikzelf";
                            ?>
                            <div class="swiper-slide swipeExpert custom_slide" style="width: 170px !important;">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo $image ?>" alt="">
                                    </div>
                                    <p class="verkop"><?php echo $name ?></p>
                                    <a href="<?php echo $path ?>" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="sousBlockProduct4">
            <div class="headsousBlockProduct4">
                <p class="sousBlockTitleProduct2">Agenda</p>
                <div class="elementIconeRight">
                    <img class="imgIconeShowMore" src="<?php echo get_stylesheet_directory_uri();?>/img/IconShowMore.png" alt="">
                </div>
                <a href="/newFilesHtml/agenda.html" class="showAllLink">Show all</a>
            </div>

            <div class="row mr-md-2 mr-1">
                <?php
                    foreach($courses as $key=>$course){
                        if($key == 6)
                            break;
                        $location = '~';
                        /*
                        * Categories and Date
                        */ 
                        $day = "~";
                        $month = "~"; 

                        $tree = get_the_category($course->ID);
                        if($tree){
                            if(isset($tree[2]))
                                $category = $tree[2]->cat_name;
                            else 
                                if(isset($tree[1]))
                                    $category = $tree[1]->cat_name;
                        }else 
                            $category = ' ~ ';

                        $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];    

                        $dates = get_field('dates', $course->ID);
                        if($dates){
                            
                            $day = explode('-', explode(' ', $dates[0]['date'])[0])[2];
                            $month = explode('-', explode(' ', $dates[0]['date'])[0])[1];

                            $month = $calendar[$month]; 
                            
                        }else{
                            $data = get_field('data_locaties', $course->ID);
                            if($data){
                                $date = $data[0]['data'][0]['start_date'];

                                $day = explode('/', explode(' ', $date)[0])[0];
                                $month = explode('/', explode(' ', $date)[0])[1];
                                $month = $calendar[$month];
                                
                                $location = $data[0]['data'][0]['location'];
                            }
                            else{
                                $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                                $date = $data[0];
                                $day = explode('/', explode(' ', $date)[0])[0];
                                $month = explode('/', explode(' ', $date)[0])[1];
                                $month = $calendar[$month];
                                $location = $data[2];
                            }
                        }
                        
                        /*
                        * Price 
                        */
                        $p = get_field('price', $course->ID);
                        if($p != "0")
                            $price =  number_format($p, 2, '.', ',') . ",-";
                        else 
                            $price = 'Gratis';

                        /*
                        * Thumbnails
                        */ 
                        $thumbnail = get_the_post_thumbnail_url($course->ID);
                        if(!$thumbnail){
                            $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                            if(!$thumbnail)
                                $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                        }

                        //Image author of this post 
                        $image_author = get_field('profile_img',  'user_' . $course->post_author);
                ?>
                <a href="<?php echo get_permalink($course->ID) ?>" class="col-md-12">
                    <div class="blockCardFront">
                        <div class="workshopBlock">
                            <p class="workshopText"> <?php echo get_field('course_type', $course->ID) ?> </p>
                            <div class="blockDateFront">
                                <p class="moiText"><?php echo $month ?></p>
                                <p class="dateText"><?php echo $day ?></p>
                            </div>
                        </div>
                        <div class="deToekomstBlock">
                            <p class="deToekomstText"> <?php echo $course->post_title ?> </p>
                            <p class="platformText"> <?php echo get_field('short_description', $course->ID) ?></p>
                            <div class="detaiElementAgenda detaiElementAgendaModife">
                                <div class="janBlock">
                                    <div class="colorFront"> 
                                        <img width="17" src="<?php echo $image_author ?> " alt="" >
                                    </div>
                                    <p class="textJan"> <?php echo(get_userdata($course->post_author)->data->display_name) ?> </p>
                                </div>
                                <div class="euroBlock">
                                    <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/euro.png" alt="">
                                    <p class="textJan"> <?php echo $price ?> </p>
                                </div>
                                <div class="zwoleBlock">
                                    <img class="ss" src="<?php echo get_stylesheet_directory_uri();?>/img/ss.png" alt="">
                                    <p class="textJan"><?php echo $location; ?></p>
                                </div>
                                <div class="facilityBlock">
                                    <img class="faciltyImg" src="<?php echo get_stylesheet_directory_uri();?>/img/map-search.png" alt="">
                                    <p class="textJan facilityText"> <?php echo $category ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
                }            
                ?>
            </div>
        </div>

        </div>
        <?php

            }
        ?>
    </div>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>

<script>
    jQuery(document).ready(function(){
        jQuery('#user_login').attr('placeholder', 'E-mailadres of Gebruikersnaam');
        jQuery('#user_pass').attr('placeholder', 'Wachtwoord');
    });
</script>

<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: '3',
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>
<script>
    var swiper = new Swiper('.swipeContaineVerkoop', {
        slidesPerView: '5',
        spaceBetween: 20,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>
<script>
    var swiper = new Swiper('.swipeContaineEvens', {
        slidesPerView: '5',
        spaceBetween: 20,
        breakpoints: {
            780: {
                slidesPerView: 1,
                spaceBetween: 40,
            },
            1230: {
                slidesPerView: 3.9,
                spaceBetween: 20,
            }
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

    });

</script>
<script>
    $(document).ready(function(){
        $("#hide").click(function(){
            event.preventDefault();
            $(".sousProductTest").hide();
        });
        $("#show").click(function(){
            event.preventDefault();
            $(".sousProductTest").show();
        });
    });

// make a border bottom after clicking button 
    $(document).ready(function(){
        $("#btn_click1").click(function(){
        $(".add_here1").addClass("buttonSelected");
        $(".add_here2").removeClass("buttonSelected");
        });
    });
    $(document).ready(function(){
        $("#btn_click2").click(function(){
        $(".add_here2").addClass("buttonSelected");
        $(".add_here1").removeClass("buttonSelected");
         });
    });

</script>

</body>
</html>
