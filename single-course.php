<?php
get_header();

global $post;
global $wp;

//Redirection product page 
if($post->post_type == 'product')
    header('Location: ');

$url = home_url( $wp->request );

// $page = dirname(__FILE__) . '/templates/check_visibility.php'; 
// require($page);
view($post);

if (isset($_POST) && !empty($_POST)){
    extract($_POST);
    //ouvrir le modal et afficher un message à la fin du processus
    $userdata = array(
        'user_pass' => $_POST['password'],
        'user_login' => $_POST['username'], // to change on firstname or special name in field on the form
        'user_email' => $_POST['email'],
        'user_url' => 'http://livelearn.nl/',
        'display_name' => $_POST['firstName'] . ' ' . $_POST['lastName'],
        'first_name' => $_POST['firstName'],
        'last_name' => $_POST['lastName'],
        'role' => 'Klant'
    );
    $user_id = wp_insert_user(wp_slash($userdata));
    if(is_wp_error($user_id)) {
        $danger = $user_id->get_error_message();
        header("location:$url?message=" . $danger . "&danger");
    } else {
        $success = "U bent succesvol geregistreerd <br>";
        //update_field('telnr', $phone, 'user_' . $user_id);
        header("location:$url?message=" . $success . "&success");

        //logged the user
        /*
        $login = wp_signon(array(
            'user_email' => $_POST['email'],
            'user_pass' => $_POST['password'],
            'remember' => true,
        ));
        if (is_wp_error($login)){
            $danger = $login->get_error_message();
            header("location:$url?message=" . $danger . "&danger");
        } else
            header("location:$url?message=" . $success . "&success");
          */

    }

}
elseif ($_GET && isset($_GET['message'])){
    if (isset($_GET['danger'])){
        $danger = $_GET['message'];
        echo "<div class='alert alert-danger text-center' role='alert'>$danger</div>";
    } elseif (isset($_GET['success'])){
        $success = $_GET['message'];
        echo "<div class='alert alert-success text-center' role='alert'>$success</div>";
    }
}

$course_type = get_field('course_type', $post->ID);

$offline = ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop', 'Opleidingen', 'Cursus'];
$online = ['Video', 'Webinar','Podcast', 'E-learning'];

//Redirection - visibility
if (isset($visibility_company))
    if(!visibility($post, $visibility_company))
        header('location: /');

//Redirection - type
if(!in_array($course_type, $offline) && !in_array($course_type, $online) && $course_type != 'Artikel' && $course_type != 'Leerpad')
    header('location: /');

//Online
$courses = get_field('data_virtual', $post->ID);
$youtube_videos = get_field('youtube_videos', $post->ID);

$podcasts = get_field('podcasts', $post->ID);
$podcast_index = get_field('podcasts_index', $post->ID);
$product = wc_get_product( get_field('connected_product', $post->ID) );
$long_description = get_field('long_description', $post->ID);
$short_description = get_field('short_description', $post->ID);
$for_who = get_field('for_who', $post->ID) ?: "No content !";
$language = get_field('language', $post->ID);

$count_videos = 0;
if(!empty($courses))
    $count_videos = count($courses);
else if(!empty($youtube_videos))
    $count_videos = count($youtube_videos);

$count_audios = 0;
if(!empty($podcasts))
    $count_audios = count($podcasts);
else if(!empty($podcast_index))
    $count_audios = count($podcast_index);

$dagdeel = array();
$data = get_field('data_locaties', $post->ID);
if(!$data){
    $data = get_field('data_locaties_xml', $post->ID);
    $xml_parse = true;
}

if(!isset($xml_parse)){
    if(!empty($data))
        foreach($data as $datum) 
            if(!empty($datum['data']))
                for($i = 0; $i < count($datum['data']); $i++)
                    array_push($dagdeel, $datum['data'][$i]['start_date']);
}else{
    if (isset($data[0]))
        if($data[0])
            foreach($data as $datum){
                $infos = explode(';', $datum['value']);
                if(!empty($infos))
                    foreach($infos as $value) {
                        $info = explode('-', $value);
                        $date = $info[0];
                        array_push($dagdeel, $date);
                    }
            }
        else{
            $data = get_field('dates', $post->ID);
            $dagdeel = array($data);
        }
}

$dagdeel = array_count_values($dagdeel);
$dagdeel = count($dagdeel);

/*
*  Date and Location
*/
$calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

$price_noformat = get_field('price', $post->ID) ?: 'Gratis';
if($price_noformat != "Gratis")
    $price = '€' . number_format($price_noformat, 2, '.', ',');
else
    $price = 'Gratis';

$prijsvat = get_field('prijsvat', $post->ID);
$btw = get_field('btw-klasse', $post->ID); 
if(!$prijsvat && isset($prijs))
    $prijsvat = (get_field('price', $post->ID) * $btw/100) - $prijs;

$agenda = get_field('agenda', $post->ID);
$who = get_field('for_who', $post->ID);
$results = get_field('results', $post->ID);

$category = " ";
$category_id = 0;
$id_category = 0;
if($tag == ' '){
    $category_id = intval(explode(',', get_field('categories',  $post->ID)[0]['value'])[0]);
    $category_xml = intval(get_field('category_xml', $post->ID)[0]['value']);
    if($category_xml)
        if($category_xml != 0){
            $id_category = $category_xml;
            $category = (String)get_the_category_by_ID($category_xml);
        }
    if($category_id)
        if($category_id != 0){
            $id_category = $category_id;
            $category = (String)get_the_category_by_ID($category_id);
        }
}
$category_default = get_field('categories', $post->ID);
$category_xml = get_field('category_xml', $post->ID);

$user_id = get_current_user_id();
//$podcast_index_for_not_connected [] = $podcast_index[0];
//$youtube_videos_for_not_connected [] = $youtube_videos[0];
//$podcast_index = $user_id ? $podcast_index : $podcast_index_for_not_connected;
//$youtube_videos = $user_id ? $youtube_videos : $youtube_videos_for_not_connected;
/*
* User informations
*/
$email_user = get_user_by('ID', $post->post_author)->user_email;
$phone_user = get_field('telnr', 'user_' . $post->post_author);

/*
* Companies user
*/
$company_connected = get_field('company',  'user_' . $user_id);
$users_company = array();
$allocution = get_field('allocation', $post->ID);
$users = get_users();
$users_choose = array();
$user_choose = $post->post_author;

foreach($users as $user) {
    $company_user = get_field('company',  'user_' . $user->ID);
    if (!$company_user)
        continue;
    if(!empty($company_connected) && !empty($company_user))
        if($company_user[0]->post_title == $company_connected[0]->post_title) 
            array_push($users_company, $user->ID);
    if($company_user[0]->post_title == 'beeckestijn') 
        array_push($users_choose, $user->ID);
}

if(!$post->post_author){
    $user_choose = $users_choose[array_rand($users_choose, 1)];

    $arg = array(
        'ID' => $post->ID,
        'post_author' => $user_choose,
    );
    wp_update_post($arg); 
}

$image_author = get_field('profile_img',  'user_' . $post->post_author);
if(!$image_author)
    $image_author = get_stylesheet_directory_uri() ."/img/placeholder_user.png";

/*
* Companies
*/
$company = get_field('company',  'user_' . $post->post_author);

/*
* Experts
*/
$expert = get_field('experts', $post->ID);
$author = array($user_choose);

if(isset($expert[0]))
    $experts = array_merge($expert, $author);
else
    $experts = $author;

/*
* Likes
*/
$favour = get_field('favorited', $post->ID);
if(empty($favour))
    $favoured = 0;
else 
    $favoured = count($favour);

/*
* Image
*/
$thumbnail = "";
if(!$thumbnail){
    $thumbnail = get_the_post_thumbnail_url($post->ID);
    if(!$thumbnail)
        $thumbnail = get_field('url_image_xml', $post->ID);
            if(!$thumbnail)
                $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
}
/*
* Others
*/ 
$duration_day = get_field('duration_day', $post->ID);
$attachments_xml = get_field('attachment_xml', $post->ID);

//Reviews
$reviews = get_field('reviews', $post->ID);
$count_reviews = (!empty($reviews)) ? count($reviews) : 0;
// $count_reviews_all = 0;
$star_review = [ 0, 0, 0, 0, 0];
$average_star = 0;
$average_star_nor = 0;
$my_review_bool = false;
$counting_rate = 0;
if ($reviews)
    foreach ($reviews as $review):
        if($review['user']->ID == $user_id)
            $my_review_bool = true;

        //Star by number
        switch ($review['rating']) {
            case 1:
                $star_review[1] += 1;
                break;
            case 2:
                $star_review[2] += 1;
                break;
            case 3:
                $star_review[3] += 1;
                break;
            case 4:
                $star_review[4] += 1;
                break;
            case 5:
                $star_review[5] += 1;
                break;
        }

        if($review['rating']){
            $average_star += intval($review['rating']);
            $counting_rate += 1;
        }
    endforeach;
if ($counting_rate > 0 )
    $average_star_nor = $average_star / $counting_rate;
$average_star_format = number_format($average_star_nor, 1, '.', ',');
$average_star = intval($average_star_nor);


$link_to = get_field('link_to', $post->ID);
$share_txt = "Hello, i share this course with ya *" . $post->post_title . "* \n Link : " . get_permalink($post->ID) . "\nHope you'll like it.";

/* * Informations reservation * */
//Orders - enrolled courses 
$datenr = 0; 
$calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

$enrolled = array();
$enrolled_courses = array();
$statut_bool = 0;
$args = array(
    'customer_id' => $user_id,
    'post_status' => array('wc-processing', 'wc-completed'),
    'orderby' => 'date',
    'order' => 'DESC',
    'limit' => -1,
);
$bunch_orders = wc_get_orders($args);

$enrolled_member = 0;
$enrolled_all = 0;
foreach($bunch_orders as $order){
    foreach ($order->get_items() as $item_id => $item ) {
        $course_id = intval($item->get_product_id()) - 1;
        $course = get_post($course_id);
        if($course_id == $post->ID){
            $statut_bool = 1;
            $enrolled_member += 1;
        }
        if(!empty($course))
            if($course->post_author == $post->post_author)
                $enrolled_all += 1;
        
        //Get woo orders from user
        if(!in_array($course_id, $enrolled))
            array_push($enrolled, $course_id);
    }
}

$bool_link = 0;
if(($price == 'Gratis'))
    $bool_link = 1;
else
    if($statut_bool)
        $bool_link = 1;

//Similar course
$similar_course = array();
$args = array(
    'post_type' => array('course','post'),
    'post_status' => 'publish',
    'orderby' => 'date',
    'author' => $post->post_author,
    'order' => 'DESC',
    'posts_per_page' => -1
);
$author_courses = get_posts($args);
$initial = 0;
foreach ($author_courses as $key => $course) {
    if($course->ID == $post->ID)
        continue;
    $type_course = get_field('course_type', $course->ID);
    if($type_course == $course_type){
        array_push($similar_course, $course);
        $initial += 1;
    }
        
    if($initial == 6)
        break;
} 
if(in_array($course_type, $offline))
    include_once('template-parts/modules/single-new-course-multi-date.php');
else if($course_type == 'Video')
    include_once('template-parts/modules/single-new-course-video.php');
else if($course_type == 'Podcast')
    include_once('template-parts/modules/single-new-course-podcast.php');
else if($course_type == 'Leerpad')
    include_once('template-parts/modules/single-new-course-offline.php');
else if($course_type == 'Assessment')
    include_once('template-parts/modules/single-new-course-assessment.php');


?>
<?php
$current_url = get_permalink($post->ID);

?>
<!-- modal register / login -->
<div class="modal fade" id="modal-login-with-podcast" tabindex="-1" role="dialog" aria-labelledby="modal-login-with-podcastTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body create-account-block">
                <p class="title-modal">Welcome !</p>
                <p class="description-modal">Please, Connect to continue</p>
                <div class="group-btn-connection">
                    <a href="<?php echo get_site_url() ?>/fluidify/?loginSocial=google" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600" data-popupheight="600" class="btn btn-connection">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/net-icon-google.png" alt="First-slide-looggin">
                        Continue with Google
                    </a>
                </div>
                <div class="d-flex hr-block">
                    <hr>
                    <p>Or</p>
                    <hr>
                </div>
                <div class="form-input">
                    <?php
                    $current_url = home_url(add_query_arg(array(), $wp->request));
                    wp_login_form([
                        'redirect' => $current_url,
                        'remember' => false,
                        'label_username' => 'Email address',
                        'placeholder_email' => 'Enter your email address',
                        'label_password' => 'Password',
                        'label_log_in'   => 'Log in',
                        'placeholder_password' => 'Enter your password',
                    ]);
                    ?>
                    <button class="btn btn-switch-login btn-Sign-Up">You don't have an account ? Sign Up</button>
                </div>
            </div>
            <div class="modal-body register-block">
                <p class="title-modal">Welcome !</p>
                <p class="description-modal">Please, Create an account to continue</p>
                <div class="group-btn-connection">
                    <a href="<?php echo get_site_url() ?>/fluidify/?loginSocial=google" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600" data-popupheight="600" class="btn btn-connection">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/net-icon-google.png" alt="First-slide-looggin">
                        Continue with Google
                    </a>
                </div>
                <div class="d-flex hr-block">
                    <hr>
                    <p>Or</p>
                    <hr>
                </div>
                <div class="alert alert-danger d-none text-center" role="alert" id="alert-danger-register">
                    the confirm password don't match with password !!!
                </div>
                <div class="form-input">
                    <form action="<?= $url ?>" method="POST" id="new-form-register-workflow">

                        <div class="first-step-modal">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter your email address" required>
                            </div>
                            <button type="button" class="btn btn-coneection" id="create-account-step">Create Account</button>
                        </div>

                        <div class="second-step-modal">
                            <div class="form-group">
                                <label for="First-name">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                            </div>

                            <div class="form-group">
                                <label for="First-name">First name</label>
                                <input type="text" class="form-control" id="First-name" name="firstName" placeholder="Enter your First name" required>
                            </div>
                            <div class="form-group">
                                <label for="last-name">Last name</label>
                                <input type="text" class="form-control" id="last-name" name="lastName" placeholder="Enter your last name" required>
                            </div>
                            <div class="form-group">
                                <label for="Company">Company</label>
                                <input type="text" class="form-control" id="Company" name="Company" placeholder="Enter your Company name">
                            </div>
                            <div class="form-group">
                                <label for="phone-number">phone number</label>
                                <input type="text" class="form-control" id="phone-number" name="phone" placeholder="Enter your phone-number">
                            </div>
                            <div class="form-group">
                                <label for="Password-workflow">Password</label>
                                <input type="password" class="form-control" id="Password-workflow" name="password" placeholder="Enter your Password" required>
                            </div>
                            <div class="form-group">
                                <label for="Password2-workflow">Password</label>
                                <input type="password" class="form-control" id="Password2-workflow" name="password2" placeholder="Confirm your Password" required>
                            </div>
                            <button type="submit" class="btn btn-coneection" id="">Create Acccount</button>
                        </div>
                    </form>
                    <div class="form-block group-btn-modal d-flex align-items-center">
                        <button class="btn btn-switch-email d-none">Return on Email</button>
                        <button class="btn btn-switch-login">You already have a account? <b>Login</b></button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $("#create-account-step").click(function() {
        $(".btn-switch-email").removeClass('d-none');
        $(".first-step-modal").hide();
        $(".second-step-modal").show();
    });
    $(".btn-switch-login").click(function() {
        $(".register-block").hide();
        $(".create-account-block").show();
    });
    $(".btn-switch-email").click(function() {
        $(".btn-switch-email").addClass('d-none');
        $(".second-step-modal").hide();
        $(".first-step-modal").show();
    });
    $(".btn-Sign-Up").click(function() {
        $(".register-block").show();
        $(".create-account-block").hide();
    });
</script>
<script>
    $("#new-form-register-workflow").submit((e)=>{
        //e.preventDefault();
        const formData = new FormData(e.currentTarget);
        password = formData.get('password')
        password2 = formData.get('password2')

        if (password !== password2){
            e.preventDefault();
            $('#alert-danger-register').removeClass('d-none')
            $('#Password-workflow').addClass('btn-danger')
            $('#Password2-workflow').addClass('btn-danger')
        }
    })
</script>
<?php get_footer(); ?>
