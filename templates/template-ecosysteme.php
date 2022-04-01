<?php /** Template Name: Ecosystem template */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>

<?php 

$topic = ($_GET['topic']) ? $_GET['topic'] : ' ';
$name_topic = (String)get_the_category_by_ID($topic);

if($topic != ' '){    
    $categories = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'parent'     => $topic,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );
}

$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',
);

$global_blogs = get_posts($args);
$blogs = array();
$others = array();
$teachers = array();

$categoriees = array(); 

if(isset($categories))
    foreach($categories as $category)
        array_push($categoriees, $category->cat_ID);

foreach($global_blogs as $blog)
{
    /*
    * Categories
    */ 

    $category_id = 0;
    $experts = get_field('experts', $blog->ID);
    
    $trees = array();
    $tree = get_the_terms($blog->ID, 'course_category');
    foreach($tree as $tre)
        array_push($trees, $tre->term_id);
    
    $categories_id = get_field('categories',  $blog->ID);
    $categories_xml = get_field('category_xml',  $blog->ID);
    $categories = array();

    /*
    * Merge categories from customize and xml
    */ 


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

    foreach($categoriees as $category){
        if(in_array($category, $trees) || $categories)
            if(in_array($category, $trees) || in_array($category, $categories))
                array_push($blogs, $blog);
        else
            array_push($others, $blog);
    }
    /*
     *
    */ 
    
    /*
    * Push experts 
    */ 
    if(!in_array($course->post_author, $teachers))
        array_push($teachers, $blog->post_author);

    foreach($experts as $expertie)
    if(!in_array($expertie, $teachers))
        array_push($teachers, $expertie);
    /*
     *
    */ 
        
}




?>

<div>
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
</div>

<div class="content-ecosysteme ">
    <div class="head-content-ecosysteme">
    
        <div class="row">
            <div class="col-lg-6">
                <div class="container">
                    <div class="content-head-ecosystem">
                        <h1>Bijven leren en ontwikkelen, dat is ons streven | Join de community</h1>
                        <p class="description-head">Het ecosysteem waar HR- en L&D-professionals op strategisch niveau samenkomen om invulling te geven aan vraagstukken omtrent workforce career management en het creëren van een high performing organisatie.</p>
                        
                        <div class="groupBtnEcosysteme">
                            <div class="p-2 my-3">
                                <a href="" class="btnContact rounded-pill rounded" style="background-color: #00A89D"
                                 data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoMobil.png" alt="" class="text-danger">
                                    Join community
                                </a>
                            </div>
                            <div class="p-2 my-3">
                                <a href="" class="btnContact rounded-pill rounded border-dark border-3 border ">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/phone.png" alt="">
                                    HR Discord
                                </a>
                            </div>
                        </div>
                        
                        <p class="title-een">Een initiatief van:</p>

                        <div class="block-consultant">
                            <div class="block-initiative">
                               <div class="imgLivelearnLogo">
                                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/logo_right.png" alt="" >
                               </div><!--
                                <div class="auteur-initiative">
                                    <div class="imgAuteur">
                                        <img src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/Image53.png" alt="">
                                    </div>
                                    <p>Lieselotte van der <br> Meer <br> Principal <br> consultant</p>
                                </div>-->
                            </div>
                            <div class="block-initiative block-initiative2">
                               <div class="imgLivelearnLogo">
                                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image49.png" alt="" >
                               </div><!--
                                <div class="auteur-initiative">
                                    <div class="imgAuteur">
                                        <img src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/Image54.png" alt="">
                                    </div>
                                    <p>Daniel van der Kolk <br> Oprichter</p>
                                </div>-->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="img-head-ecosysteme">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/ecosystemHeadImg.png" alt="">
                </div>
            </div>

        </div>
    </div>
    <div class="topCollection">
        <div class="container">
            <div class="headCollections">
                <div class="dropdown show">
                    <a class="btn btn-collection dropdown-toggle" href="#" role="button" id="dropdownHuman" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Top experts binnen <b><?= $name_topic; ?></b><br>
                    </a>
                    <div class="dropdown-menu dropdownModifeEcosysteme" aria-labelledby="dropdownHuman">
                        <?php 
                        foreach($categories as $category){
                            echo '<a class="dropdown-item" href="category-overview?category=' . $category->cat_ID . '">' . $category->cat_name .'</a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="dropdown show">
                    <a class="btn btn-collection dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Over de <b>laatste 7 dagen</b>
                    </a>
                    <div class="dropdown-menu dropdownModifeEcosysteme" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#">Last 7 days</a>
                        <a class="dropdown-item" href="#"> last moth</a>
                        <a class="dropdown-item" href="#"> last 7 year</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php 
                $num = 1;

                foreach($teachers as $user) {
                    $image_user = get_field('profile_img',  'user_' . $user->ID);
                    $image_user = $image_user ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                ?>
                    <a href="/dashboard/user-overview/?id=<?php echo $user->ID; ?>" class="col-md-4">
                        <div class="boxCollections">
                            <p class="numberList"><?php echo $num++ ; ?></p>
                            <div class="circleImgCollection">
                                <img src="<?php echo $image_user ?>" alt="">
                            </div>
                            <div class="secondBlockElementCollection ">
                                <p class="nameListeCollection"><?php if(isset($user->first_name) && isset($user->last_name)) echo $user->first_name . '' . $user->last_name; else echo $user->display_name; ?></p>
                                <div class="iconeTextListCollection">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/ethereum.png" alt="">
                                    <p>16.300,44</p>
                                </div>
                            </div>
                            <p class="pourcentageCollection">-35.21%</p>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="hulpBox">
        <div class="container-fluid">
            <div class="alJoum">
                <div class="blockImGDaniel">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/daniel.png" alt="">
                </div>
                <?php
                echo do_shortcode("[gravityform id='10' title='false' description='false' ajax='true']");
                ?>
            </div>
            <!--  <div class="groeipadenBlock">
                <p class="sousBlockTitleProduct">Groeipaden</p>
                <div class="blockSousblockTitle">
                    <div class="swiper-container swipeContaineEvens">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-45.png" alt="">
                                    </div>
                                    <p class="verkop">Verkoop en sales</p>
                                    <a href="" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-45.png" alt="">
                                    </div>
                                    <p class="verkop">Verkoop en sales</p>
                                    <a href="" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-45.png" alt="">
                                    </div>
                                    <p class="verkop">Leiderschap</p>
                                    <a href="" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-45.png" alt="">
                                    </div>
                                    <p class="verkop">Excel</p>
                                    <a href="" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-45.png" alt="">
                                    </div>
                                    <p class="verkop">HRM</p>
                                    <a href="" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-45.png" alt="">
                                    </div>
                                    <p class="verkop">Marktkoopman</p>
                                    <a href="" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <?php 
            if(!empty($others)){
            ?>
            <div class="UitgelichteBlock">
                <p class="sousBlockTitleProduct">Andere artikelen</p>
                <div class="blockCardOpleidingen ">

                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
                            <?php
                            foreach($others as $blog) {

                            $tag = '';
                            $image = null;

                            //Image
                            $image = get_the_post_thumbnail_url($blog->ID);
                            if(!$image)
                                $image = get_field('preview', $blog->ID)['url'];
                                    if(!$image){
                                        $image = get_field('url_image_xml', $course->ID);
                                        if(!$image)
                                            $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                                    }

                            $author = get_field('profile_img',  'user_' . $blog->post_author);

                            //Summary
                            $summary = get_the_excerpt($blog->ID);

                            if(!$summary)
                                $summary = get_field('short_description', $blog->ID);

                            //Tags
                            $tree = get_the_tags($blog->ID);

                            if($tree)
                                if(isset($tree[2]))
                                    $tag = $tree[2]->name;

                            if($tag = ''){
                                $tagS = intval(explode(',', get_field('categories',  $blog->ID)[0]['value'])[0]);
                                $tagI = intval(get_field('category_xml',  $blog->ID)[0]['value']);
                                if($tagS != 0)
                                    $tag = (String)get_the_category_by_ID($tagS);
                                else if($tagI != 0)
                                    $tag = (String)get_the_category_by_ID($tagI);                                    
                            }
                            ?>
                            <a href="<?php echo get_permalink($blog->ID) ?>" class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <img src="<?php echo $image; ?>" alt="">
                                    </div>
                                    <button class="btn btnImgCoeurEcosysteme">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/coeur1.png" alt="">
                                    </button>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img src="<?php echo $author; ?>" alt="">
                                                </div>
                                                <p class="nameCoursProd"><?php echo(get_userdata($blog->post_author)->data->display_name); ?></p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                    <p class="lieuAm">Artikel</p>
                                                </div>
                                                <?php if($tag != '') { ?>
                                                <div class="blockOpein">
                                                    &#x0023;&#xFE0F;&#x20E3;
                                                    <p class="lieuAm"><?php echo $tag; ?></p>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <p class="werkText"><?php echo $blog->post_title; ?></p>
                                        <p class="descriptionPlatform">
                                            <?php echo $summary; ?>
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

            <div class="groeipadenBlock">
                <p class="sousBlockTitleProduct">Onderwerpen</p>
                <div class="blockSousblockTitle">
                    <div class="swiper-container swipeContaineEvens">
                        <div class="swiper-wrapper">
                            <?php 
                            foreach($categories as $category){
                                $image_category = get_field('image', 'category_'. $category->cat_ID);
                                $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/Image-45.png';
                            ?>
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?= $image_category; ?>" alt="">
                                    </div>
                                    <p class="verkop"><?= $category->cat_name; ?></p>
                                    <a href="<?php echo 'category-overview?category=' . $category->cat_ID; ?>" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                            <?php 
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            if(!empty($blogs)){
            ?>
            <div class="UitgelichteBlock">
                <p class="sousBlockTitleProduct">Uitgelichte artikelen</p>
                <div class="blockCardOpleidingen ">

                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
                            <?php
                            foreach($blogs as $blog) {

                            $tag = '';
                            $image = null;

                            //Image
                            $image = get_the_post_thumbnail_url($blog->ID);
                            if(!$image)
                                $image = get_field('preview', $blog->ID)['url'];
                            else if(!$image)
                                $image = get_stylesheet_directory_uri() . '/img/libay.png';
                                    

                            $author = get_field('profile_img',  'user_' . $blog->post_author);

                            //Summary
                            $summary = get_the_excerpt($blog->ID);

                            if(!$summary)
                                $summary = get_field('short_description', $blog->ID);

                            //Tags
                            $tree = get_the_tags($blog->ID);

                            if($tree)
                                if(isset($tree[2]))
                                    $tag = $tree[2]->name;

                            if($tag = ''){
                                $tagS = intval(explode(',', get_field('categories',  $blog->ID)[0]['value'])[0]);
                                $tagI = intval(get_field('category_xml',  $blog->ID)[0]['value']);
                                if($tagS != 0)
                                    $tag = (String)get_the_category_by_ID($tagS);
                                else if($tagI != 0)
                                    $tag = (String)get_the_category_by_ID($tagI);                                    
                            }
                            ?>
                            <a href="<?php echo get_permalink($blog->ID) ?>" class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <img src="<?php echo $image; ?>" alt="">
                                    </div>
                                    <button class="btn btnImgCoeurEcosysteme">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/coeur1.png" alt="">
                                    </button>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img src="<?php echo $author; ?>" alt="">
                                                </div>
                                                <p class="nameCoursProd"><?php echo(get_userdata($blog->post_author)->data->display_name); ?></p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                    <p class="lieuAm">Artikel</p>
                                                </div>
                                                <?php if($tag != '') { ?>
                                                <div class="blockOpein">
                                                    &#x0023;&#xFE0F;&#x20E3;
                                                    <p class="lieuAm"><?php echo $tag; ?></p>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <p class="werkText"><?php echo $blog->post_title; ?></p>
                                        <p class="descriptionPlatform">
                                            <?php echo $summary; ?>
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
        </div>
    </div>
</div>


<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input').val(recipient)
    })
   
    // Hidden password
    $(document).ready(function() {
        $(".show_hide_password a").on('click', function(event) {
            if($('.show_hide_password input').attr("type") == "text"){
                $('.show_hide_password input').attr('type', 'password');
                $('.show_hide_password i').addClass( "fa-eye-slash" );
                $('.show_hide_password i').removeClass( "fa-eye" );
            }else if($('.show_hide_password input').attr("type") == "password"){
                // alert("cool1111");
                $('.show_hide_password input').attr('type', 'text');
                $('.show_hide_password i').removeClass( "fa-eye-slash" );
                $('.show_hide_password i').addClass( "fa-eye" );
            }
        });
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
    $("#btn-signIn").click(()=>{
        datas={
            name:$('#name').val(),
            email:$('#email').val(),
            password:$('#password').val(),
            position:$('#position').val(),
            age:$('#form2Example34').val(),
        }
        console.log(datas)
        $.ajax({

        url:"fetch-ajax",
        method:"post",
        data:datas,
        dataType:"text",
        success: function(data){
            console.log(data);
            $('#autocomplete').html(data);
        }
});
    })
</script>

<?php get_footer(); ?>
<?php wp_footer(); ?>

<script>
    jQuery(document).ready(function(){
        jQuery('#user_login').attr('placeholder', 'E-mailadres of Gebruikersnaam');
        jQuery('#user_pass').attr('placeholder', 'Wachtwoord');
    });
</script>