<?php get_header();?>

<?php
global $post;

$posttags = get_the_tags();


//Image
$image = get_the_post_thumbnail_url($post->ID);
if(!$image)
    $image = get_field('preview', $post->ID)['url'];
else if(!$image)
    $image = get_stylesheet_directory_uri() . '/img/libay.png';

$author = get_field('profile_img',  'user_' . $post->post_author);
if(!$author)
    $author = get_stylesheet_directory_uri() . 'img/blog/blog-author.jpg';

$biographical = get_field('biographical_info',  'user_' . $post->post_author);

$functie = get_field('role',  'user_' . $post->post_author);

if($tag = ''){
    $tagS = intval(explode(',', get_field('categories',  $blog->ID)[0]['value'])[0]);
    $tagI = intval(get_field('category_xml',  $blog->ID)[0]['value']);
    if($tagS != 0)
        $tag = (String)get_the_category_by_ID($tagS);
    else if($tagI != 0)
        $tag = (String)get_the_category_by_ID($tagI);                                    
}

$content = get_field('article_itself',  $blog->ID);

?>

<div class="main-wrapper ">

    <section class="section blog-wrap bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <div class="single-blog-item">
                                <div class="block-single-blog-item">
                                    <img src="<?php echo$image; ?>" alt="" class="img-fluid rounded">
                                </div>
                                <!-- -------------------------------------- Start Icons row ------------------------------------->
                                <div class="d-flex justify-content-md-between justify-content-around sousblockArticles1 text-center">
                                    <div class="d-flex flex-row">
                                        <div class="d-flex flex-column mx-md-3 mx-2">
                                            <input type="hidden" id="user_id" value="<?php echo $user_id; ?>">
                                            <input type="hidden" id="course_id" value="<?php echo $post->ID; ?>">
                                            <!-- <img class="iconeCours" src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt=""> -->
                                            <button id="btn_favorite" style="background:unset; border:none"><i class="far fa-heart" style="font-size: 25px;"></i></button>
                                            <span class="textIconeLearning mt-1" id="autocomplete_favoured">0</span>
                                        </div>
                                        <div class="d-flex flex-column mx-md-3 mx-2">
                                            <i class="fas fa-calendar-alt" style="font-size: 25px;"></i>
                                            <span class="textIconeLearning mt-1"> <?php echo get_the_date('d F'); ?></span>
                                        </div>
                                        <div class="d-flex flex-column mx-md-3 mx-2">
                                            <i class="fas fa-graduation-cap" style="font-size: 25px;"></i>
                                            <span class="textIconeLearning mt-1">Training</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row">
                                        <div class="d-flex flex-column mx-md-3 mx-2">
                                            <button type="button" class="btn btnModalBlog" data-toggle="modal" data-target="#modalShare">
                                                <i class='fa fa-share' style='font-size: 25px;'></i><br>
                                                <span class='textIconeLearning mt-1'>Share</span>
                                            </button>
                                        </div>

                                    </div>
                                </div>

                                <!-- début Modal deel -->
                                <div class="modal fade" id="modalShare" tabindex="-1" role="dialog" aria-labelledby="modalShareModalLabel" aria-hidden="true">
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

                                        </div>
                                    </div>
                                </div>
                                <!-- fin Modal deel -->
                                <div class="blog-item-content bg-white blogPadding">
                                    <div class="blog-item-meta-Comment">
                                        <span class="text-muted text-capitalize mr-3"><i class="ti-pencil-alt mr-2"></i><?php echo $posttags[0]->name; ?></span>
                                        <span class="text-muted text-capitalize mr-3"><i class="ti-comment mr-2"></i>0 Comments</span>
                                    </div> 

                                    <h4 class="mt-3 mb-4"><?php echo the_title();?></h4>
                                    <?php 
                                        if(!the_content())
                                            echo $content;
                                    ?>

                                    <div class="tag-option mt-5 clearfix">
                                        <ul class="float-left list-inline"> 
                                            <li>Tags:</li> 
                                            <?php
                                                if(!empty($posttags))
                                                    foreach($posttags as $posttag) 
                                                        echo '<li class="list-inline-item"><a href="#" rel="tag">' . $posttag->name . '</a></li>';
                                                else
                                                    echo '<li class="list-inline-item"><a href="#" rel="tag">' . $tag . '</a></li>';
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12 mb-5">
                            <div class="posts-nav bg-white p-4 d-lg-flex d-md-flex justify-content-between ">

                                <?php
                                $prev = get_previous_post();

                                $prev_link = get_permalink($prev);

                                ?>
                                <a class="post-prev align-items-center" href="<?php echo $prev_link;?>">
                                    <div class="posts-prev-item mb-4 mb-lg-0">
                                        <span class="nav-posts-desc text-color">- Previous Post</span>

                                        <p class="nav-posts-element">
                                            <?php echo get_the_title($prev);?>
                                        </p>
                                    </div>
                                </a>
                                <div class="border"></div>

                                <?php
                                $next = get_next_post();

                                $next_link = get_permalink($next);

                                ?>
                                <a class="posts-next" href="<?php echo $next_link;?>">
                                    <div class="posts-next-item pt-4 pt-lg-0">
                                        <span class="nav-posts-desc text-lg-right text-md-right text-color d-block">- Next Post</span>
                                        <p class="nav-posts-element">
                                            <?php echo get_the_title($next);?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>

                                                <!--
                        <div class="col-lg-12 mb-5">
                        <div class="comment-area card border-0 p-5">
                        <h4 class="mb-4">2 Comments</h4>
                        <ul class="comment-tree list-unstyled">
                        <li class="mb-5">
                        <div class="comment-area-box">
                        <img alt="" src="img/blog/test1.jpg" class="img-fluid float-left mr-3 mt-2">

                        <h5 class="mb-1">Philip W</h5>
                        <span>United Kingdom</span>

                        <div class="comment-meta mt-4 mt-lg-0 mt-md-0 float-lg-right float-md-right">
                        <a href="#"><i class="icofont-reply mr-2 text-muted"></i>Reply |</a>
                        <span class="date-comm">Posted October 7, 2018 </span>
                        </div>

                        <div class="comment-content mt-3">
                        <p>Some consultants are employed indirectly by the client via a consultancy staffing company, a company that provides consultants on an agency basis. </p>
                        </div>
                        </div>
                        </li>

                        <li>
                        <div class="comment-area-box">
                        <img alt="" src="img/blog/test2.jpg" class="mt-2 img-fluid float-left mr-3">

                        <h5 class="mb-1">Philip W</h5>
                        <span>United Kingdom</span>

                        <div class="comment-meta mt-4 mt-lg-0 mt-md-0 float-lg-right float-md-right">
                        <a href="#"><i class="icofont-reply mr-2 text-muted"></i>Reply |</a>
                        <span class="date-comm">Posted October 7, 2018</span>
                        </div>

                        <div class="comment-content mt-3">
                        <p>Some consultants are employed indirectly by the client via a consultancy staffing company, a company that provides consultants on an agency basis. </p>
                        </div>
                        </div>
                        </li>
                        </ul>
                        </div>
                        </div>

                        <div class="col-lg-12">
                        <form class="contact-form bg-white rounded p-5" id="comment-form">
                        <h4 class="mb-4">Write a comment</h4>
                        <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                        <input class="form-control" type="text" name="name" id="name" placeholder="Name:">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                        <input class="form-control" type="text" name="mail" id="mail" placeholder="Email:">
                        </div>
                        </div>
                        </div>

                        <textarea class="form-control mb-3" name="comment" id="comment" cols="30" rows="5" placeholder="Comment"></textarea>

                        <input class="btn btn-main btn-round-full" type="submit" name="submit-contact" id="submit_contact" value="Submit Message">
                        </form>
                        </div>
                        -->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-wrap">
                        <div class="sidebar-widget sidebar-widget-autor  card border-0 mb-3">
                            <img src="<?php echo $author; ?>" alt="" class="img-fluid">
                            <div class="card-body p-4 text-center">
                                <h5 class="mb-0 mt-4"><?php echo(get_userdata($post->post_author)->data->display_name); ?></h5>
                                <p><?php echo $functie; ?></p>
                                <p><?php echo $biographical; ?></p>

                                <ul class="list-inline author-socials">
                                    <li class="list-inline-item mr-3">
                                        <a href="#"><i class="fab fa-facebook-f text-muted"></i></a>
                                    </li>
                                    <li class="list-inline-item mr-3">
                                        <a href="#"><i class="fab fa-twitter text-muted"></i></a>
                                    </li>
                                    <li class="list-inline-item mr-3">
                                        <a href="#"><i class="fab fa-linkedin-in text-muted"></i></a>
                                    </li>
                                    <li class="list-inline-item mr-3">
                                        <a href="#"><i class="fab fa-pinterest text-muted"></i></a>
                                    </li>
                                    <li class="list-inline-item mr-3">
                                        <a href="#"><i class="fab fa-behance text-muted"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="sidebar-widget latest-post sidebar-widget-autor card border-0 p-4 mb-3">
                            <h5>Latest Posts</h5>
                            
                            <?php
                            $latests = wp_get_recent_posts(array('numberposts' => 3));
                            
                            foreach($latests as $latest){
                            ?>
                            
                            <div class="media border-bottom py-3">
                                <a href="<?php echo get_the_permalink($latest['ID']);?>"><img class="mr-4" src="img/blog/bt-3.jpg" alt=""></a>
                                <div class="media-body">
                                    <p class="nav-posts-element"><a href="#"><?php echo get_the_title($latest['ID']);?></a></p>
                                    <span class="text-sm text-muted"><?php echo get_the_date('d-m-Y',$latest['ID']);?></span>
                                </div>
                            </div>
                            <?php }?>
                        </div>

                        <div class="sidebar-widget bg-white rounded tags p-4 mb-3">
                            <h5 class="mb-4">Tags</h5>

                            <?php
                            if ($posttags) {
                                foreach($posttags as $tag) {
                                    echo '<a href=#">'.$tag->name . '</a>'; 
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


    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<?php get_footer(); ?>
<?php wp_footer(); ?>