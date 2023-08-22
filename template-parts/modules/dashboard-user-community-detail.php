<?php
    global $wp;


    $args = array(
        'post_type' => 'community',
        'post_status' => 'publish',
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    
    $communities = get_posts($args);
    $other_communities = array();
    foreach($communities as $key => $value){
        if ($community->ID == $value->ID)
            continue;
        array_push($other_communities, $community);
    }

    //current user
    $user_id = get_current_user_id();

    //current user image
    $user_image = get_field('profile_img',  'user_' . $user_id);
    $user_image = $user_image ?: get_stylesheet_directory_uri() . '/img/user.png';

    $no_content = "
    <p class='dePaterneText theme-card-description'> 
        <span style='color:#033256'> Stay connected, Something big is coming 😊 </span> 
    </p>
    ";

    $no_content_event =  '
    <center>
        <img src="' . get_stylesheet_directory_uri() . '/img/skill-placeholder-content.png" width="140" height="150" alt="Skill no-content" >
        <br><span class="text-dark h5 p-1 mt-2" style="color:#033256"> No content found !</span>
    <center>
    ';
    $users = get_users();
    $authors = array();

    $community = "";
    if(isset($_GET['mu']))
        $community = get_post($_GET['mu']);

    //Calendar don't mind about it
    $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];
    

if($community){

    $company = get_field('company_author', $community->ID);
    $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/group-friends-gathering-together.jpg';
    $community_image = get_field('image_community', $community->ID) ?: $company_image;

    foreach ($users as $value) {
        $company_user = get_field('company',  'user_' . $value->ID )[0];
        if($company_user->post_title == $company->post_title)
            array_push($authors, $value->ID);
    }

    // courses comin through custom field 
    $courses = get_field('course_community', $community->ID);

    $max_user = 0;
    if(!empty($authors))
        $max_user = count($authors);

    $max_course = 0;
    if(!empty($courses))
        $max_course = count($courses);

    $max_follower = 0;
    $followers = get_field('follower_community', $community->ID);
    if(!empty($followers))
        $max_follower = count($followers);
    
    $level = get_field('range', $community->ID);

    //Since year
    $date = $community->post_date;
    $days = explode(' ', $date)[0];
    $month = $calendar[explode('-', $date)[1]];
    $year = explode('-', $days)[0];
    
    $user_id = get_current_user_id();
    $bool = false;
    //Communities granted
    foreach($followers as $follower)
        if($follower->ID == $user_id){
            $bool = true;
            break;
        }
    
    //Questions 
    $max_question = 0;
    $questions = get_field('question_community', $community->ID);
    if(!empty($questions)){
        $max_question = count($questions);
        $questions = array_reverse($questions);
    }
    if(!$bool)
        header('Location: /dashboard/user/communities/?message=Je moet lid zijn van deze gemeenschap voordat je toegang krijgt');
?>

<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>

<div class="content-detail-community content-new-user">
    <div class="head-detail-community">
        <div class="imgCommunities">
            <img class="" src="<?= $community_image ?>" alt="">
        </div>
        <div class="block-detail-community">
            <p class="name-community"><?= $community->post_title; ?></p>
            <div class="d-flex justify-content-between">
                <p class="number-members"><?= $max_follower ?> members</p>
                <p class="statut">Private Group</p>
                <p class="statut">Since <?= $month . ' ' . $year ?></p>
            </div>
            <p class="description-community"><?= $community->post_excerpt; ?></p>
        </div>
    </div>
    <div class="body--detail-community">
        <div class="tabs-courses">
            <div class="tabs">
                <div class="head">
                    <ul class="filters">
                        <li class="item active">Activity</li>
                        <li class="item position-relative">Members <span><?= $max_follower ?></span></li>
                        <li class="item item-question position-relative">Questions <span><?= $max_question ?></span></li>
                        <!-- <li class="item position-relative">Courses <span><?= $max_course ?></span></li> -->
                    </ul>
                </div>
                <div class="">
                    <div class="tabs__list">
                        <div class="tab tab-one active">
                            <div class="d-flex flex-wrap">
                                <div class="group-course-activity first-section-dashboard">
                                    <div class="question-block" data-toggle="modal" data-target="#modalQuestion" type="button">
                                        <a href="" class="imgUser">
                                            <img class="" src="<?= $user_image; ?>" alt="">
                                        </a>
                                        <p class="text-question">Do you have a question ?</p>
                                    </div>
                                    
                                    <div class="w-100">
                                        <?php
                                        foreach($questions as $key => $question):
                                        if($key == 2)
                                            break;
                                        $user_question = $question['user_question'];
                                        $user_question_name = $user_question->first_name ?: $user_question->display_name;
                                        $user_question_image = get_field('profile_img', 'user_' . $user_question->ID);
                                        $user_question_image = $user_question_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                        $text_question = $question['text_question'];
                                        $reply_question = $question['reply_question'];
                                        $reply_question_count = 0;
                                        if(!empty($reply_question))
                                            $reply_question_count = count($reply_question);
                                        ?>
                                        <div class="interviewer-block d-flex">
                                            <a href="" class="imgUser">
                                                <img src="<?= $user_question_image ?>" alt="">
                                            </a>
                                            <div class="block-detail-interviewer">
                                                <div class="d-flex align-items-center">
                                                    <p class="name-user-answer"><?= $user_question_name; ?></p>
                                                    <!-- <p class="date-answer">March, 16 2023</p> -->
                                                </div>
                                                <p class="text-question"> <?= $text_question ?> </p>
                                                <div class="d-flex">
                                                    <button class="btn footer-answer-items" data-target="block<?= $key; ?>" id="answer-item-1">
                                                        <i class="fa fa-comment"></i>
                                                        <p><?= $reply_question_count; ?> answers</p>
                                                    </button>
                                                    <button class="btn footer-answer-items" data-target="block-input-answer-<?= $key; ?>" id="reply-btn-1">
                                                        <i class="fa fa-reply" aria-hidden="true"></i>
                                                        <p>Reply</p>
                                                    </button>
                                                </div>
                                                <!-- <div class="block-all-answer" id="">  -->
                                                <div class="block-all-answer" id="block<?= $key; ?>">
                                                    <?php
                                                        foreach($reply_question as $reply):
                                                        $user_reply = $reply['user_reply'];
                                                        $user_reply_name = $user_reply->first_name ?: $user_reply->display_name;
                                                        $user_reply_image = get_field('profile_img', 'user_' . $user_reply->ID);
                                                        $user_reply_image = $user_reply_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                                        $text_reply = $reply['text_reply'];
                                                    ?>
                                                        <div class="interviewer-block d-flex">
                                                            <a href="" class="imgUser">
                                                                <img src="<?= $user_reply_image ?>" alt="">
                                                            </a>
                                                            <div class="block-detail-interviewer">
                                                                <div class="d-flex align-items-center">
                                                                    <p class="name-user-answer"><?= $user_reply_name ?></p>
                                                                    <!-- <p class="date-answer">March, 16 2023</p> -->
                                                                </div>
                                                                <p class="text-question"><?= $text_reply ?></p>
                                                            </div>
                                                        </div>
                                                    <?php
                                                        endforeach;
                                                        if(empty($reply_question))
                                                            echo '<p>No responses !</p>';
                                                    ?>
                                                </div>
                                                <div id="block-input-answer-<?= $key; ?>" class="block-input-answer position-relative">
                                                    <form action=""  method="POST">
                                                        <input type='hidden'  name='id' value='<?= $key ?>' >
                                                        <input type='hidden' name='community_id' value='<?= $community->ID ?>' >
                                                        <input type="text" name="txtreply" placeholder="Share your opinion on this question" required>
                                                        <button type="submit"  name="reply_question_community" class="btn btn-send">Send</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        endforeach;
                                        if(empty($questions))
                                            echo '<p>No questions !</p>';
                                        ?>
                                        <!-- <button class="btn btn-see-all">Seee All</button> -->
                                    </div> 
                                   
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalQuestion" tabindex="-1" role="dialog" aria-labelledby="modalQuestionLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"></h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>

                                                </div>
                                                <div class="modal-body text-left">
                                                    <form action="" method="POST" id="question_community">
                                                        <input type='hidden' form="question_community" name='community_id' value='<?= $community->ID ?>' >
                                                        <textarea form="question_community" name="text_question" id="editor" placeholder="Write your question..." required></textarea>
                                                    </form>
                                                </div>
                                                <button type="submit" form="question_community" name="question_community" class="btn btn-send">Send</button>

                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $events = array();
                                    $i = 0;
                                    if(!empty($courses))
                                        foreach($courses as $key => $course){
                                            // course-type
                                            $course_type = get_field('course_type', $course->ID);
                                            if($course_type == 'Event'){
                                                array_push($events, $course);
                                                continue;
                                            }
                                            $i++;

                                            if($i == 9)
                                                continue;

                                            //image
                                            $thumbnail = get_field('preview', $course->ID)['url'];
                                            if(!$thumbnail){
                                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                                if(!$thumbnail)
                                                    $thumbnail = get_field('url_image_xml', $course->ID);
                                                if(!$thumbnail)
                                                    $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                            }
                                                                                                
                                            //short-description
                                            $short_description = get_field('short_description',  $course->ID);

                                            //author
                                            $author_object = get_user_by('ID', $course->post_author);      
                                            $author_name = $author_object->display_name ?: $author_object->first_name;
                                            $author_image = get_field('profile_img',  'user_' . $author_object->ID);
                                            $author_image = $author_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

                                            //Likes
                                            $favour = get_field('favorited', $course->ID);
                                            if(empty($favour))
                                                $favoured = 0;
                                            else 
                                                $favoured = count($favour);

                                            //Comments
                                            $comments = get_field('reviews', $course->ID);
                                            $number_comments = !empty($comments) ? count($comments) : '0';
                                        ?>
                                    <div class="new-card-course">
                                        <div class="head">
                                            <img src="<?= $thumbnail ?>" class="" alt="">
                                        </div>
                                        <div class="title-favorite d-flex justify-content-between align-items-center">
                                            <p class="title-course"><?= $course->post_title; ?></p>
                                            <!-- <button>
                                                <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                                <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                            </button> -->
                                        </div>
                                        <div class="autor-price-block d-flex justify-content-between align-items-center">
                                            <p class="autor"><b>By</b>: <?= $author_object->display_name; ?></p>
                                        </div>
                                        <div class="footer-card-course d-flex justify-content-between align-items-center">
                                            <!-- 
                                            <div class="d-flex align-items-center">
                                                <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                                <p class="hours-course">4h</p>
                                            </div> 
                                            -->
                                            <a href="<?= get_permalink($course->ID); ?>">View Details</a>
                                        </div>
                                        <div class="like-and-comment">
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <div class="element-like-and-comment">
                                                    <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-outline.png" alt="">
                                                    <p class="sub-text"><?= $favoured ?></p>
                                                </div>
                                                <div class="d-flex">
                                                    <button type="button" data-target="comment<?= $key ?>" class="btn element-like-and-comment mr-2">
                                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/comment-alt-lines.png" alt="">
                                                        <p class="sub-text"><?= $number_comments ?></p>
                                                    </button>

                                                    <!-- 
                                                    <button type="button" data-target="comment1" class="btn element-like-and-comment mr-2">
                                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/comment-alt-lines.png" alt="">
                                                        <p class="sub-text">0</p>
                                                    </button> 
                                                    -->
                                                    <!-- 
                                                    <button type="button" class="btn element-like-and-comment">
                                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/fluent_share.png" alt="">
                                                        <p class="sub-text">16</p>
                                                    </button> 
                                                    -->
                                                </div>
                                            </div>
                                            <div class="first-element" id="comment<?= $key ?>" >
                                            <?php
                                            if(!empty($comments)){
                                                foreach($comments as $key=>$review){
                                                    if($key == 3)
                                                        break;
                                                    $user = $review['user'];
                                                    $image_author = get_field('profile_img',  'user_' . $user->ID);
                                                    $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';
                                                    $rating = $review['rating'];
                                                    ?>
                                                <div class="comment-element-block">
                                                    <a class="imgUserComment">
                                                        <img class="" src="<?= $image_author; ?>" alt="">
                                                    </a>
                                                    <div style="width: 93%;">
                                                        <p class="name-user-comment"><?= $user->display_name; ?></p>
                                                        <p class="date-time-comment"></p>
                                                        <p class="text-comment"><?= $review['feedback']; ?></p>
                                                    </div>
                                                </div>
                                            <?php
                                                    }
                                                }
                                            else
                                                echo "<h6>No reviews for this course ...</h6>";
                                            ?>
                                                
                                                <!-- 
                                                <button class="btn btnmoreComment">
                                                    More Comments+
                                                </button> -->
                                                <div class="comment-element-block">
                                                <?php
                                                if($user_id != 0){
                                                    $image_author = get_field('profile_img',  'user_' . $user_id);
                                                    $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';

                                                    ?>
                                                    <form id="comment_community" action="" method="POST">
                                                        <input type="hidden" form="comment_community" name="user_id" value="<?= $user_id; ?>">
                                                        <input type="hidden" form="comment_community" name="course_id" value="<?= $community->ID; ?>">
                                                        <input type="hidden" form="comment_community" name="post_type" value="community">
                                                    </form>
                                                    <?php
                                                }
                                                ?>
                                                    <!-- 
                                                    <div class="imgUserComment">
                                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                                                    </div>
                                                    <div style="width: 93%;">
                                                        <input form="comment_community" name="feedback_content" type="text" placeholder="Your comment">
                                                    </div>
                                                    <br><br> 
                                                    <div class="">
                                                        <button type="submit" form="comment_community" name="review_post" class="btn btnSendComment">Send</button>
                                                    </div> 
                                                    -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    else
                                        echo "";
                                    ?>
                                </div>
                                <div class="second-section-dashboard">
                                    <div class="Upcoming-block">
                                        <h2>Upcoming Schedule</h2>
                                        <?php
                                        if(!empty($events)){
                                            foreach($events as $key => $course){
                                            if($key == 3)
                                                break;

                                            $price = get_field('price', $course->ID) ?: 'Free';
                                            $day = "00";
                                            $month = "00";
                                            $hours = "";
                                            $dates = get_field('dates', $course->ID);
                                            if($dates){
                                                $date = $dates[0]['date'];
                                                $days = explode(' ', $date)[0];
                                                $day = explode('-', $days)[2];
                                                $month = $calendar[explode('-', $date)[1]];
                                                $year = explode('-', $days)[0];
                                                $time = explode(' ', $date)[1];
                                                $hours = explode(':', $time)[0] . 'h' . explode(':', $time)[1];
                                            }
                                            $author_course = $course->post_author;

                                            $author_object = get_user_by('ID', $course->post_author);      
                                            $author_name = $author_object->display_name ?: $author_object->first_name;
                                            $author_image = get_field('profile_img',  'user_' . $author_object->ID);
                                            $author_image = $author_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                    
                                            $experts = array();
                                            $expert = get_field('experts', $course->ID);
                                            $authors = array($author_course);
                                            if(isset($expert[0]))
                                                $experts = array_merge($expert, $authors);
                                            else
                                                $experts = $authors;
                                        ?>
                                            <div class="card-Upcoming">
                                                <p class="title"><?= $course->post_title; ?></p>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/bi_calendar-event-fill.png" alt="">
                                                    <p class="date"><?php echo($month . ' ' . $day . ', ' . $year) ?></p>
                                                    <hr>
                                                    <p class="time"><?= $hours ?> - Online</p>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between footer-card-upcoming">
                                                    <div class="d-flex align-items-center">
                                                        <img class="imgAutor" src="<?= $author_image; ?>" alt="">
                                                        <p class="nameAutor"><?= $author_name; ?></p>
                                                    </div>
                                                    <p class="price">Free</p>
                                                </div>
                                            </div>
                                        <?php
                                            }
                                        }
                                        else
                                            echo $no_content;
                                        ?> 
                                        <!-- <a href="#" class="btn btn-more-events">More Events</a> -->
                                    </div>
                                    <div class="advertissement-block">
                                        <p class="name-ad">Learning Platform</p>
                                        <p class="description-ad">Whether you are a beginner or an experienced student, we have courses tailored to your level and interests !</p>
                                        <a href="/dashboard/user/" class="btn btn-discover">Discover</a>
                                    </div>
                                    <div class="user-community-block">
                                        <?php
                                        $i = 0;
                                        if($other_communities[0] != NULL)
                                            echo '<h2>Other Communities</h2>';

                                        foreach($other_communities as $key => $value){

                                            if(!$value)
                                                continue;

                                            if($i == 3)
                                                break;
                                            $i++;

                                            $company = get_field('company_author', $value->ID);
                                            $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/logo_livelearn_white.png';
                                            $community_image = get_field('image_community', $value->ID) ?: $company_image;

                                            //Courses through custom field 
                                            $courses = get_field('course_community', $value->ID);
                                            $max_course = 0;
                                            if(!empty($courses))
                                                $max_course = count($courses);

                                            //Followers
                                            $max_follower = 0;
                                            $followers = get_field('follower_community', $value->ID);
                                            if(!empty($followers))
                                                $max_follower = count($followers);
                                        ?>
                                        <div class="card-Community d-flex align-items-center">
                                            <div class="imgCommunity">
                                                <img class="calendarImg" src="<?= $community_image ?>" alt="">
                                            </div>
                                            <div>
                                                <p class="title"><?= $value->post_title ?>, Netherlands</p>
                                                <p class="number-members"><?= $max_follower ?> Members</p>
                                            </div>
                                        </div>
                                        <?php
                                        }

                                        if($other_communities[0] != NULL)
                                            echo '<a href="/dashboard/user/comunities" class="btn btn-more-events">More</a>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="group-members-community">
                                <?php
                                foreach ($followers as $user){
                                    $name = $user->display_name ?: $user->first_name;
                                    $country = get_field('country',  'user_' . $user->ID);
                                    $biographical_info = get_field('biographical_info',  'user_' . $user->ID);
                                    $image_author = get_field('profile_img',  'user_' . $user->ID);
                                    $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';                            

                                    $date = $user->user_registered;
                                    $days = explode(' ', $date)[0];
                                    $month = $calendar[explode('-', $date)[1]];
                                    $year = explode('-', $days)[0];
                                ?>
                                <div class="card-members">
                                    <div class="head-card-members">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/bgcomminity.png" alt="">                                    
                                    </div>
                                    <div class="img-user-block">
                                        <img class="" src="<?= $image_author ?>" alt="">
                                    </div>
                                    <p class="name-members"><?= $name ?></p>
                                    <p class="city"><?= $country ?></p>
                                    <p class="description"><?= $biographical_info ?></p>
                                    <p class="friend-members">Learn Since :</p>
                                    <p class="date-since"><?= $month . ' ' . $year ?></p>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="tab tab-active">
                            <?php
                            foreach($questions as $key => $question):
                            $user_question = $question['user_question'];
                            $user_question_name = $user_question->first_name ?: $user_question->display_name;
                            $user_question_image = get_field('profile_img', 'user_' . $user_question->ID);
                            $user_question_image = $user_question_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                            $text_question = $question['text_question'];
                            $reply_question = $question['reply_question'];
                            $reply_question_count = 0;
                            if(!empty($reply_question))
                                $reply_question_count = count($reply_question);
                            ?>
                            <div class="interviewer-block d-flex">
                                <a href="" class="imgUser">
                                    <img src="<?= $user_question_image ?>" alt="">
                                </a>
                                <div class="block-detail-interviewer">
                                   
                                    <div class="d-flex align-items-center">
                                        <p class="name-user-answer"><?= $user_question_name; ?></p>
                                        <!-- <p class="date-answer">March, 16 2023</p> -->
                                    </div>
                                    <p class="text-question"><?= $text_question ?> </p>
                                    <div class="d-flex">
                                        
                                        <button class="btn footer-answer-items" data-target="block-all-answer-<?= $key; ?>" id="answer-item-1">
                                            <i class="fa fa-comment"></i>
                                            <p><?= $reply_question_count; ?> answers</p>
                                        </button>
                                        <button class="btn footer-answer-items" data-target="block-input-answer-1-<?= $key; ?>" id="reply-btn-1">
                                            <i class="fa fa-reply" aria-hidden="true"></i>
                                            <p>Reply</p>
                                        </button>
                                       
                                    </div>
                                    <div class="block-all-answer" id="block-all-answer-<?= $key; ?>">
                                    <?php
                                        foreach($reply_question as $reply):
                                        $user_reply = $reply['user_reply'];
                                        $user_reply_name = $user_reply->first_name ?: $user_reply->display_name;
                                        $user_reply_image = get_field('profile_img', 'user_' . $user_reply->ID);
                                        $user_reply_image = $user_reply_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                        $text_reply = $reply['text_reply'];
                                    ?>
                                        <div class="interviewer-block d-flex">
                                            <a href="" class="imgUser">
                                                <img src="<?= $user_reply_image ?>" alt="">
                                            </a>
                                            <div class="block-detail-interviewer">
                                                <div class="d-flex align-items-center">
                                                    <p class="name-user-answer"><?= $user_reply_name ?></p>
                                                    <!-- <p class="date-answer">March, 16 2023</p> -->
                                                </div>
                                                <p class="text-question"><?= $text_reply ?></p>
                                            </div>
                                        </div>
                                    <?php
                                        endforeach;
                                        if(empty($reply_question))
                                            echo '<p>No responses !</p>';
                                    ?>
                                    </div>
                                    <div id="block-input-answer-1-<?= $key; ?>" class="block-input-answer position-relative">
                                        <form action="" id="reply_form<?= $key; ?>" method="POST">
                                            <input type='hidden' form="reply_form<?= $key; ?>" name='id' value='<?= $key ?>' >
                                            <input type='hidden' form="reply_form<?= $key; ?>" name='community_id' value='<?= $community->ID ?>' >
                                            <input type="text" form="reply_form<?= $key; ?>" name="txtreply" placeholder="Share your opinion on this question" required>
                                            <button type="submit" form="reply_form<?= $key; ?>" name="reply_question_community" class="btn btn-send">Send</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                            endforeach;
                            if(empty($questions))
                                echo '<p>No questions !</p>';
                            ?>
                        </div>
                        <div class="tab">
                            <div class="group-files-members">
                               <div class="d-flex group-card-head">
                                   <div class="card-files active" id="all">
                                       <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/dossier-fichier-une.png" alt="">
                                       <p class="name">All</p>
                                       <p class="number">33</p>
                                   </div>
                                   <div class="card-files Images" id="Images">
                                       <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-images-community.png" alt="">
                                       <p class="name">Images</p>
                                       <p class="number">33</p>
                                   </div>
                                   <div class="card-files" id="Document-pdf">
                                       <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-pdf-community.png" alt="">
                                       <p class="name">document.pdf</p>
                                       <p class="number">33</p>
                                   </div>
                                   <div class="card-files" id="Document-world">
                                       <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-world-community.png" alt="">
                                       <p class="name">document.world</p>
                                       <p class="number">33</p>
                                   </div>
                               </div>
                                <div id="parent">
                                    <div class="box all">
                                        <div class="group-files">

                                        </div>
                                    </div>
                                    <div class="box Images">
                                        <div class="group-files">
                                            <div class="card-files" >
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-images-community.png" alt="">
                                                <p class="name">Sea.png</p>
                                                <p class="number">20.mb</p>
                                            </div>
                                            <div class="card-files" >
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-images-community.png" alt="">
                                                <p class="name">Sea.png</p>
                                                <p class="number">20.mb</p>
                                            </div>
                                            <div class="card-files" >
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-images-community.png" alt="">
                                                <p class="name">Sea.png</p>
                                                <p class="number">20.mb</p>
                                            </div>
                                            <div class="card-files" >
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-images-community.png" alt="">
                                                <p class="name">Sea.png</p>
                                                <p class="number">20.mb</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box Document-pdf">
                                        <div class="group-files">
                                            <div class="card-files" >
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-pdf-community.png" alt="">
                                                <p class="name">document.pdf</p>
                                                <p class="number">230.mb</p>
                                            </div>
                                            <div class="card-files" >
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-pdf-community.png" alt="">
                                                <p class="name">document.pdf</p>
                                                <p class="number">230.mb</p>
                                            </div>-
                                            <div class="card-files" >
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-pdf-community.png" alt="">
                                                <p class="name">document.pdf</p>
                                                <p class="number">230.mb</p>
                                            </div>
                                            <div class="card-files" >
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-pdf-community.png" alt="">
                                                <p class="name">document.pdf</p>
                                                <p class="number">230.mb</p>
                                            </div>-
                                        </div>
                                    </div>
                                    <div class="box Document-world">
                                        <div class="group-files">
                                            <div class="card-files">
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-world-community.png" alt="">
                                                <p class="name">document</p>
                                                <p class="number">230.mb</p>
                                            </div>
                                            <div class="card-files">
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-world-community.png" alt="">
                                                <p class="name">document</p>
                                                <p class="number">230.mb</p>
                                            </div>
                                            <div class="card-files">
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-world-community.png" alt="">
                                                <p class="name">document</p>
                                                <p class="number">230.mb</p>
                                            </div>
                                            <div class="card-files">
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-world-community.png" alt="">
                                                <p class="name">document</p>
                                                <p class="number">230.mb</p>
                                            </div>
                                            <div class="card-files">
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/files-world-community.png" alt="">
                                                <p class="name">document</p>
                                                <p class="number">230.mb</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}
else
    header("Location: /dashboard/user/communities/");
?>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $(".footer-answer-items").click(function() {
            var targetId = $(this).data("target"); // Récupération de l'ID cible depuis l'attribut data-target
            $("#" + targetId).toggle(); // Afficher/Masquer le bloc en fonction de l'ID correspondant
        });
    });

</script>
<script>
    document.querySelectorAll(".filters .item").forEach(function (tab, index) {
        tab.addEventListener("click", function () {
            const filters = document.querySelectorAll(".filters .item");
            const tabs = document.querySelectorAll(".tabs__list .tab");

            filters.forEach(function (tab) {
                tab.classList.remove("active");
            });
            this.classList.add("active");

            tabs.forEach(function (tabContent) {
                tabContent.classList.remove("active");
            });
            tabs[index].classList.add("active");
        });
    });

</script>
<script>
    var $btns = $('.card-files').click(function() {
        if (this.id == 'all') {
            $('#parent > div').fadeIn(450);
        } else {
            var $el = $('.' + this.id).fadeIn(450);
            $('#parent > div').not($el).hide();
        }
        $btns.removeClass('active');
        $(this).addClass('active');
    })
</script>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>