<?php 
get_header();

$page = dirname(__FILE__) . '/templates/check_visibility.php';
 
require($page); 

?>
<head>
    <meta name=”robots” content=”noindex,nofollow”>
</head>

<?php
global $post;

global $wp;

if(!visibility($post, $visibility_company))
    header('location: /'); 

$url = home_url( $wp->request );

$posttags = get_the_tags();

if(!$posttags){
    $category_default = get_field('categories', $post->ID);
    $category_xml = get_field('category_xml', $post->ID);
}

$stackoverflow = get_field('stackoverflow',  'user_' . $post->post_author);
$github = get_field('github',  'user_' . $post->post_author);
$facebook = get_field('facebook',  'user_' . $post->post_author);
$twitter = get_field('twitter',  'user_' . $post->post_author);
$linkedin = get_field('linkedin',  'user_' . $post->post_author);
$instagram = get_field('instagram',  'user_' . $post->post_author);
$discord = get_field('discord',  'user_' . $post->post_author);
$tik_tok = get_field('tik_tok',  'user_' . $post->post_author);

$course_type = get_field('course_type', $post->ID);

//Image - article
$image = get_field('preview', $post->ID)['url'];
if(!$image){
    $image = get_the_post_thumbnail_url($post->ID);
    if(!$image)
        $image = get_field('url_image_xml', $post->ID);
            if(!$image)
                $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
}
    
//Author
$user_picture = get_field('profile_img', 'user_' . $post->post_author) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

$biographical = get_field('biographical_info',  'user_' . $post->post_author);

$functie = get_field('role',  'user_' . $post->post_author);

if($tag = ''){
    $tagS = intval(explode(',', get_field('categories',  $post->ID)[0]['value'])[0]);
    $tagI = intval(get_field('category_xml',  $post->ID)[0]['value']);
    if($tagS != 0)
        $tag = (String)get_the_category_by_ID($tagS);
    else if($tagI != 0)
        $tag = (String)get_the_category_by_ID($tagI);                                    
}

$content = get_field('article_itself',  $post->ID);

$user_id = get_current_user_id();

$reviews = get_field('reviews', $post->ID);

$number_comments = !empty($reviews) ? count($reviews) : '0';

$price = get_field('price', $post->ID) ?: 'Gratis';

?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<style>
    .selected {
        border-bottom: 4px solid rgb(4 51 86);
    }
</style>
<div class="main-wrapper ">
   

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

                    <?php echo (do_shortcode('[user_registration_form id="8477"]')); ?>

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



    <section class="section blog-wrap bg-gray">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                   <!-- 
                    <div class="head-single">
                        <div class="imgProfilAuthor">
                            <img src="<?php /*echo $author; */?>" alt="" class="img-fluid">
                        </div>
                        <div class="auhuorElement">
                            <p class="NameAuthor"><?php /*echo(get_userdata($post->post_author)->data->display_name); */?></p>

                        </div>
                    </div>
                    -->
                   <?php if($_GET['message']) echo "<div><span class='alert alert-info'>" . $_GET['message'] . "</span></div><br>" ?>
                   <h2 class="titleBlog"><?php echo the_title();?></h2>
                   <div class="dateAndShare">
                       <p class="datePublish"><?php echo get_the_date('d F'); ?></p>
                       <ul class="blockShare">
                           <li class="list-inline-item shareTitle"> Share: </li>
                           <li class="list-inline-item"><a href="#" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                           <li class="list-inline-item"><a href="#" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                           <li class="list-inline-item">
                               <a href="#"><i class="fab fa-linkedin-in text-muted"></i></a>
                           </li>
                           <li class="list-inline-item"><a href="#" target="_blank"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a></li>
                           <li class="list-inline-item"><a href="#" target="_blank"><i class="fab fa-google-plus" aria-hidden="true"></i></a></li>
                       </ul>
                   </div>

                    <div class="single-blog-item">
                        <img src="<?= $image; ?>" alt="" class="img-fluid rounded">
                    </div>
                    <div class="blockAuthorMobile">
                        <div class="d-flex align-items-center">
                            <a class="imgAuthorBlock" href="<?php echo "/user-overview/?id=" . $post->post_author; ?>" target="_blank" >
                                <img src="<?php echo $user_picture; ?>" alt="" class="img-fluid">
                            </a>
                            <p class="NameAuthor"><?php echo(get_userdata($post->post_author)->data->display_name);?></p>
                        </div>
                        <form action="/dashboard/user/" method="POST">
                            <input type="hidden" name="artikel" value="<?= $post->ID; ?>" id="">
                            <input type="hidden" name="meta_value" value="<?= $post->post_author; ?>" id="">
                            <input type="hidden" name="user_id" value="<?= $user_id ?>" id="">
                            <input type="hidden" name="meta_key" value="expert" id="">
                            <div>
                                <?php
                                if($user_id != 0 && $user_id != $post->post_author)
                                {
                                    $saves_experts = get_user_meta($user_id, 'expert');
                                    if (in_array($post->post_author, $saves_experts))
                                        echo "<button type='submit' class='btn FollowButton' name='delete'>Unfollow</button>";
                                    else
                                        echo "<button type='submit' class='btn FollowButton' name='interest_push'>Follow</button>"; 
                                }
                                
                                ?>
                            </div>
                        </form>
                        <?php
                            if($user_id == 0)
                                echo "                                
                                <button data-toggle='modal' data-target='#SignInWithEmail'  aria-label='Close' data-dismiss='modal' type='submit' class='btn FollowButton'> 
                                    Follow                                            
                                </button>";
                        ?>
                    </div>
                    <div class="blockDescriptionBlog" id="">

                        <?php
                        if(!the_content())
                            echo $content;
                        ?>
                    </div>
                    <div class="tag-option">
                        <ul class="list-inline">
                            <li class="TagsTitle">Onderwerpen: </li>
                            <?php
                            if(!empty($posttags))
                                foreach($posttags as $posttag)
                                    echo '<li class="list-inline-item"><a href="#" rel="tag">' . $posttag->name . '</a></li>';
                            else{
                                $read_category = array();
                                if(!empty($category_default))
                                    foreach($category_default as $item)
                                        if($item)
                                            if(!in_array($item['value'],$read_category)){
                                                array_push($read_category,$item['value']);
                                                echo '<li class="list-inline-item"><a href="#" rel="tag">'. (String)get_the_category_by_ID($item['value']) . '</a></li>';
                                            }
                                else if(!empty($category_xml))
                                    foreach($category_xml as $item)
                                        if($item)
                                            if(!in_array($item['value'],$read_category)){
                                                array_push($read_category,$item['value']);
                                                echo '<li class="list-inline-item"><a href="#" rel="tag">'. (String)get_the_category_by_ID($item['value']) . '</a></li>';
                                            }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="commentAndShare">
                        <p class="titleComment"><i class="fas fa-comment" aria-hidden="true"></i><?= $number_comments; ?> Comments</p>
                        <?php
                        if(!empty($reviews)){
                            foreach($reviews as $review){
                                $user = $review['user'];
                                $image_author = get_field('profile_img',  'user_' . $user->ID);
                                $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';
                                $rating = $review['rating'];
                                ?>
                                <div class="sousBlockComments">
                                    <div class="d-flex">
                                        <div class="auteurImgComment">
                                            <img src="<?= $image_author; ?>" alt="">
                                        </div>
                                        <div>
                                            <p class="NameAutorComment"><?= $user->display_name; ?></p>
                                            <p class="date"></p>
                                        </div>
                                    </div>
                                    <p class="comment"><?= $review['feedback']; ?></p>
                                </div>
                                <?php
                            }
                        }
                        else
                            echo "<h6>No reviews for this course ...</h6>";
                        ?>

                        <button class="btn AddCommentBtn" data-toggle="modal" data-target="#myModal2">Add Comments</button>
                    </div>


                    <!-- Modal -->
                    <div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>

                                <div class="modal-body">

                                    <div class="blockAddComment2">
                                        <?php
                                        if($user_id != 0){
                                            ?>
                                            <form action="/dashboard/user/" method="POST">
                                                <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                                                <input type="hidden" name="course_id" value="<?= $post->ID; ?>">

                                                <div class="form-group">
                                                    <label for="exampleFormControlTextarea1">Add new Comment</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="feedback_content" rows="3"></textarea>
                                                </div>
                                                <div class="buttonSend">
                                                    <button type="submit" name="review_post" class="btn btnSendComment">Send</button>
                                                </div>
                                            </form>
                                            <?php
                                        }
                                        else
                                            echo "<button data-toggle='modal' data-target='#SignInWithEmail'  data-dismiss='modal'class='btnLeerom' style='border:none'> You must sign-in to make a comment. </button>";
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="sidebar-wrap">
                        <div class="sidebar-widget card border-0 mb-3">
                            <center>
                                <a href="<?php echo "/user-overview/?id=" . $post->post_author; ?>" target="_blank" >
                                    <img src="<?php echo $user_picture; ?>" alt="" class="img-fluid">
                                </a>
                            </center>
                            <div class="card-body p-4 text-center">
                                <a href="<?php echo "/user-overview/?id=" . $post->post_author; ?>" target="_blank" rel="noopener noreferrer"><h5 class="mb-0 mt-4"><?php echo(get_userdata($post->post_author)->data->display_name); ?></h5></a>
                                <p><?php echo $functie; ?></p>
                                <form action="/dashboard/user/" method="POST">
                                    <input type="hidden" name="artikel" value="<?php echo $post->ID; ?>" id="">
                                    <input type="hidden" name="meta_value" value="<?php echo $post->post_author; ?>" id="">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>" id="">
                                    <input type="hidden" name="meta_key" value="expert" id="">

                                    <div>
                                        <?php
                                        if($user_id != 0 && $user_id != $post->post_author)
                                        {
                                            $experts = get_user_meta($user_id, 'expert');
                                            if (in_array($post->post_author, $experts))
                                                echo "<button type='submit' class='btn btnFollow' name='delete'>Unfollow</button>";
                                            else
                                                echo "<button type='submit' class='btn btnFollow' name='interest_push'>Follow</button>"; 
                                        }
                                       
                                        ?>
                                    </div>
                                </form>
                                <?php
                                    if($user_id == 0)
                                        echo "                                
                                        <button data-toggle='modal' data-target='#SignInWithEmail'  aria-label='Close' data-dismiss='modal' type='submit' class='btn btnFollow'> 
                                            Follow                                            
                                        </button>";
                                ?>

                                <p><?php echo $biographical; ?></p>

                                <ul class="list-inline author-socials">
                                    <?php 
                                    if($facebook){
                                    ?>
                                    <li class="list-inline-item mr-3">
                                        <a href="<?= $facebook; ?>"><i class="fab fa-facebook-f text-muted"></i></a>
                                    </li>
                                    <?php
                                    }
                                    if($twitter){
                                    ?>
                                    <li class="list-inline-item mr-3">
                                        <a href="<?= $twitter; ?>"><i class="fab fa-twitter text-muted"></i></a>
                                    </li>
                                    <?php
                                    }
                                    if($linkedin){
                                    ?>
                                    <li class="list-inline-item mr-3">
                                        <a href="<?= $linkedin; ?>"><i class="fab fa-linkedin-in text-muted"></i></a>
                                    </li>
                                    <?php
                                    }
                                    if($github){
                                    ?>
                                    <li class="list-inline-item mr-3">
                                        <a href="<?= $github; ?>"><i class="fab fa-github text-muted"></i></a>
                                    </li>
                                    <?php
                                    }
                                    if($discord){
                                    ?>
                                    <li class="list-inline-item mr-3">
                                        <a href="<?= $discord; ?>"><i class="fab fa-discord text-muted"></i></a>
                                    </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <div class="sidebar-widget latest-post card border-0 p-4 mb-3">
                            <h5>Andere artikelen</h5>
                            
                            <?php
                            $latests = wp_get_recent_posts(array('numberposts' => 3));
                            
                            foreach($latests as $latest){
                            ?>
                            
                            <div class="media border-bottom py-3">
                                <a href="<?php echo get_the_permalink($latest['ID']);?>"><img class="mr-4" src="<?= get_stylesheet_directory_uri(); ?>/img/blog/bt-3.jpg" alt="">
                                    <div class="media-body">
                                        <h6 class="my-2"><?php echo get_the_title($latest['ID']);?></h6>
                                        <span class="text-sm text-muted"><?php echo get_the_date('d-m-Y',$latest['ID']);?></span>
                                    </div>
                                </a>
                            </div>
                            <?php }?>
                        </div>

                        <div class="sidebar-widget bg-white rounded tags p-4 mb-3">
                            <h5 class="mb-4">Onderwerpen</h5>

                            <?php
                            if ($posttags)
                                foreach($posttags as $tag)
                                    echo '<a href=#">'.$tag->name . '</a>'; 
                            else{
                                $read_category = array();
                                if(!empty($category_default))
                                    foreach($category_default as $item)
                                        if($item)
                                            if(!in_array($item,$read_category)){
                                                array_push($read_category,$item);
                                                echo '  <a href=#">'. (String)get_the_category_by_ID($item['value']) .  '</a>  ';
                                            }

                                else if(!empty($category_xml))
                                    foreach($category_xml as $item)
                                        if($item)
                                            if(!in_array($item,$read_category)){
                                                array_push($read_category,$item);
                                                echo '  <a href="#" rel="tag">'. (String)get_the_category_by_ID($item['value']) . '</a>  ';
                                            }
                            }
                            ?>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </section>
</div>

<?php get_footer();?>
<?php wp_footer(); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
     var $li = $('.tabbable-line li').click(function() {
        $li.removeClass('selected');
        $(this).addClass('selected');
    });
</script>