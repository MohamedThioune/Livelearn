<?php
    global $wp;


    $args = array(
        'post_type' => 'community',
        'post_status' => 'publish',
        'posts_per_page' => -1);
    
    $communities = get_posts($args);

    $via_url = get_site_url() . "/community-overview";

    //current user
    $user_id = get_current_user_id();

    $no_content =  '
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

if($community){

    $company = get_field('company_author', $community->ID)[0];
    $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
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
                <p class="statut">0 days ago</p>
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
                        <li class="item position-relative">Courses <span><?= $max_course ?></span></li>
                    </ul>
                </div>
                <div class="">
                    <div class="tabs__list">
                        <div class="tab active">
                            <div class="d-flex flex-wrap">
                                <div class="group-course-activity first-section-dashboard">
                                    <div class="question-block" data-toggle="modal" data-target="#modalQuestion" type="button">
                                        <div class="imgUser">
                                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/autor1.png" alt="">
                                        </div>
                                        <p class="text-question">Do you have a question ?</p>
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
                                                    <form id="">
                                                        <textarea name="content" id="editor">Write your question......</textarea>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-send">Send</button>
                                                </div>
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
                                            $thumbnail = get_the_post_thumbnail_url($course->ID);
                                            if(!$thumbnail)
                                                $thumbnail = get_field('url_image_xml', $course->ID);
                                            if(!$thumbnail)
                                                $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                            
                                            //short-description
                                            $short_description = get_field('short_description',  $course->ID);

                                            //author
                                            $author_object = get_user_by('ID', $course->post_author);        
                                            $author_image = get_field('profile_img',  'user_' . $author_object->ID);
                                            $author_image = $author_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                        ?>
                                    <div class="new-card-course">
                                        <div class="head">
                                            <img src="<?= $thumbnail ?>" class="" alt="">
                                        </div>
                                        <div class="title-favorite d-flex justify-content-between align-items-center">
                                            <p class="title-course"><?= $course->post_title; ?></p>
                                            <button>
                                                <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                                <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                            </button>
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
                                                    <p class="sub-text">0</p>
                                                </div>
                                                <div class="d-flex">
                                                    <button type="button" data-target="comment1" class="btn element-like-and-comment mr-2">
                                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/comment-alt-lines.png" alt="">
                                                        <p class="sub-text">0</p>
                                                    </button>
                                                    <!-- 
                                                    <button type="button" class="btn element-like-and-comment">
                                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/fluent_share.png" alt="">
                                                        <p class="sub-text">16</p>
                                                    </button> 
                                                    -->
                                                </div>
                                            </div>
                                            <div class="first-element" id="comment1" >
                                                <div class="comment-element-block">
                                                    <div class="imgUserComment">
                                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                                                    </div>
                                                    <div style="width: 93%;">
                                                        <p class="name-user-comment">David Moore</p>
                                                        <p class="date-time-comment">5 Mins Ago</p>
                                                        <p class="text-comment">Donec rutrum congue leo eget malesuada nulla quis lorem ut libero malesuada feugiat donec rutrum congue leo eget malesuada donec rutrum congue leo eget malesuada.</p>
                                                    </div>
                                                </div>
                                                <div class="comment-element-block">
                                                    <div class="imgUserComment">
                                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                                                    </div>
                                                    <div style="width: 93%;">
                                                        <p class="name-user-comment">David Moore</p>
                                                        <p class="date-time-comment">5 Mins Ago</p>
                                                        <p class="text-comment">Donec rutrum congue leo eget malesuada nulla quis lorem ut libero malesuada feugiat donec rutrum congue leo eget malesuada donec rutrum congue leo eget malesuada.</p>
                                                    </div>
                                                </div>
                                                <button class="btn btnmoreComment">
                                                    More Comments+
                                                </button>
                                                <div class="comment-element-block">
                                                    <div class="imgUserComment">
                                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                                                    </div>
                                                    <div style="width: 93%;">
                                                        <input type="text" placeholder="Your comment">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    else
                                        echo $no_content;
                                    ?>
                                </div>
                                <div class="second-section-dashboard">
                                    <div class="Upcoming-block">
                                        <h2>Upcoming Schedule</h2>
                                        <?php
                                            $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];
                                            if(!empty($events)){
                                            foreach($events as $key => $course){
                                                if($key == 8)
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
                                                    $year = explode('-', $days)[3];
                                                    $time = explode(' ', $date)[1];
                                                    $hours = explode(':', $time)[0] . 'h' . explode(':', $time)[1];
                                                }
                                                $author_course = $course->post_author;

                                                $author_object = get_user_by('ID', $course->post_author);        
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
                                                    <img class="imgAutor" src="<?php echo get_stylesheet_directory_uri();?>/img/autor1.png" alt="">
                                                    <p class="nameAutor">x</p>
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
                                        <p class="name-ad">Learning Plateform</p>
                                        <p class="description-ad">Whether you are a beginner or an experienced student, we have courses tailored to your level and interests !</p>
                                        <a href="" class="btn btn-discover">Discover</a>
                                    </div>
                                    <div class="user-community-block">
                                        <h2>Other Communities</h2>
                                        <div class="card-Community d-flex align-items-center">
                                            <div class="imgCommunity">
                                                <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/Community-1.png" alt="">
                                            </div>
                                            <div>
                                                <p class="title">Designer community, Dakar</p>
                                                <p class="number-members">112K Members</p>
                                            </div>
                                        </div>
                                        <div class="card-Community d-flex align-items-center">
                                            <div class="imgCommunity">
                                                <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/Community-1.png" alt="">
                                            </div>
                                            <div>
                                                <p class="title">Designer community, Dakar</p>
                                                <p class="number-members">112K Members</p>
                                            </div>
                                        </div>
                                        <div class="card-Community d-flex align-items-center">
                                            <div class="imgCommunity">
                                                <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/Community-1.png" alt="">
                                            </div>
                                            <div>
                                                <p class="title">Designer community, Dakar</p>
                                                <p class="number-members">112K Members</p>
                                            </div>
                                        </div>
                                        <a href="/dashboard/user/comunities" class="btn btn-more-events">More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="group-members-community">
                                <div class="card-members">
                                    <div class="head-card-members">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/bgcomminity.png" alt="">
                                    </div>
                                    <div class="img-user-block">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/Fadel.png" alt="">
                                    </div>
                                    <p class="name-members">Nicholas Grissom</p>
                                    <p class="city">Los Angeles, CA</p>
                                    <p class="description">Hi!,I’m a Community Manager for “Gametube”. Gamer and full-time mother.</p>
                                    <p class="friend-members">Friends Since:</p>
                                    <p class="date-since">December 2014</p>
                                </div>
                                <div class="card-members">
                                    <div class="head-card-members">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/bgcomminity.png" alt="">
                                    </div>
                                    <div class="img-user-block">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/Fadel.png" alt="">
                                    </div>
                                    <p class="name-members">Nicholas Grissom</p>
                                    <p class="city">Los Angeles, CA</p>
                                    <p class="description">Hi!,I’m a Community Manager for “Gametube”. Gamer and full-time mother.</p>
                                    <p class="friend-members">Friends Since:</p>
                                    <p class="date-since">December 2014</p>
                                </div>
                                <div class="card-members">
                                    <div class="head-card-members">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/bgcomminity.png" alt="">
                                    </div>
                                    <div class="img-user-block">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/Fadel.png" alt="">
                                    </div>
                                    <p class="name-members">Nicholas Grissom</p>
                                    <p class="city">Los Angeles, CA</p>
                                    <p class="description">Hi!,I’m a Community Manager for “Gametube”. Gamer and full-time mother.</p>
                                    <p class="friend-members">Friends Since:</p>
                                    <p class="date-since">December 2014</p>
                                </div>
                                <div class="card-members">
                                    <div class="head-card-members">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/bgcomminity.png" alt="">
                                    </div>
                                    <div class="img-user-block">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/Fadel.png" alt="">
                                    </div>
                                    <p class="name-members">Nicholas Grissom</p>
                                    <p class="city">Los Angeles, CA</p>
                                    <p class="description">Hi!,I’m a Community Manager for “Gametube”. Gamer and full-time mother.</p>
                                    <p class="friend-members">Friends Since:</p>
                                    <p class="date-since">December 2014</p>
                                </div>
                                <div class="card-members">
                                    <div class="head-card-members">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/bgcomminity.png" alt="">
                                    </div>
                                    <div class="img-user-block">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/Fadel.png" alt="">
                                    </div>
                                    <p class="name-members">Nicholas Grissom</p>
                                    <p class="city">Los Angeles, CA</p>
                                    <p class="description">Hi!,I’m a Community Manager for “Gametube”. Gamer and full-time mother.</p>
                                    <p class="friend-members">Friends Since:</p>
                                    <p class="date-since">December 2014</p>
                                </div>
                                <div class="card-members">
                                    <div class="head-card-members">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/bgcomminity.png" alt="">
                                    </div>
                                    <div class="img-user-block">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/Fadel.png" alt="">
                                    </div>
                                    <p class="name-members">Nicholas Grissom</p>
                                    <p class="city">Los Angeles, CA</p>
                                    <p class="description">Hi!,I’m a Community Manager for “Gametube”. Gamer and full-time mother.</p>
                                    <p class="friend-members">Friends Since:</p>
                                    <p class="date-since">December 2014</p>
                                </div>
                                <div class="card-members">
                                    <div class="head-card-members">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/bgcomminity.png" alt="">
                                    </div>
                                    <div class="img-user-block">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/Fadel.png" alt="">
                                    </div>
                                    <p class="name-members">Nicholas Grissom</p>
                                    <p class="city">Los Angeles, CA</p>
                                    <p class="description">Hi!,I’m a Community Manager for “Gametube”. Gamer and full-time mother.</p>
                                    <p class="friend-members">Friends Since:</p>
                                    <p class="date-since">December 2014</p>
                                </div>
                                <div class="card-members">
                                    <div class="head-card-members">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/bgcomminity.png" alt="">
                                    </div>
                                    <div class="img-user-block">
                                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/Fadel.png" alt="">
                                    </div>
                                    <p class="name-members">Nicholas Grissom</p>
                                    <p class="city">Los Angeles, CA</p>
                                    <p class="description">Hi!,I’m a Community Manager for “Gametube”. Gamer and full-time mother.</p>
                                    <p class="friend-members">Friends Since:</p>
                                    <p class="date-since">December 2014</p>
                                </div>
                            </div>
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