<?php /** Template Name: detail assessment template */ ?>
<?php wp_head(); ?>
<?php get_header(); ?>

<?php  
/* Get  seconds by given string time  */
function timeToSeconds(string $time): int
{
    $time_array = explode(':', $time);
    if (count($time_array) === 2 && $time_array[0]!='00') {
        return  $time_array[0] * 60 + $time_array[1];
    }
    return $time_array[1];
}

/* Get the assessment's ID by the url */
    $assessment_id=$_GET['assessment_id'];
    $assessment=get_post ($assessment_id);
    $assessment_array=array(
        'id'=> $assessment_id,
        'title'=> $assessment->post_title,
        'description_assessment'=> get_field('description_assessment',$assessment_id),
        'how_it_works' => get_field('how_it_works', $assessment_id),
        'difficulty_assessment' => get_field('difficulty_assessment', $assessment_id),
        'image_assessment' => get_field('image_assessement', $assessment_id)['url'],
        'language_assessment' => get_field('language_assessment', $assessment_id),
    );
    $timer=0;
    foreach (get_field('question',$assessment_id) as $question)
    {
        $question_time=$question['timer'];
        $timer+= timeToSeconds($question_time);
    }
    /* Get minutes by given string seconds  */
    $timer=ceil($timer/60);

/* Reviews */
$reviews = get_field('reviews', $assessment_id);

$my_review_bool = false;

foreach ($reviews as $review)
    if($review['user']->ID == $user_id){
        $my_review_bool = true;
        break;
    }

?>

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


    <div class="content-detail-assessment">
        <div class="container-fluid">
            <div class="overElement">
                <div class="blockOneOver">
                    <div class="titleBlock">
                        <div class="roundBlack" >
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoMobil.png" alt="company logo">
                        </div>
                        <p class="livelearnText2 text-uppercase">Livelean</p>
                    </div>


                    <p class="e-learningTitle"> <?= $assessment_array['title'] ?> </p>
                    <!-- Image -->
                    <div class="img-fluid-course">
                        <img src=<?= $assessment_array['image_assessment'] ?> alt="">
                    </div>

                    <!--------------------------------------- start Text description -------------------------------------- -->
                    <p class="title-assessment-test">Why do employers use skills assessment tests?</p>
                    <!-- <p class="description-assessment-test">It has already been mentioned that employers use these tests to be able to further shortlist candidates for a role based on their talent and skill set.

                        There are a few other reasons why companies may use these tests, though:</p>
                    <ul class="ulAssessment">
                        <li>To help develop the current employee’s skill sets that will benefit the business in the long term</li>
                        <li>To see if there is a need for any more training within the company, for example, testing current employees’ skills to gain information on any areas where there seems to be an overall struggle. The company can then invest in further training and development</li>
                        <li>To recruit for an in-house promotion. Current employees may need to do an assessment as part of an application to progress their career within the company</li>
                    </ul> -->
                    <?= $assessment_array['description_assessment'] ?>

                    <div class="customTabs">
                        <div class="tabs">
                            <ul id="tabs-nav">
                                <li><a href="#tab1">how it works</a></li>
                                <li><a href="#tab2">Reviews</a></li>
                                <?php if(!$my_review_bool) echo '<li><a href="#tab3">Add Reviews</a></li>'; ?>
                            </ul> <!-- END tabs-nav -->
                            <div id="tabs-content">
                                <div id="tab1" class="tab-content">
                                    <div>
                                        <ul class="ulAssessment">
                                        <?= $assessment_array['how_it_works'].'<br>'; ?>
                                            <!-- <li>
                                                Each question is timed
                                            </li>
                                            <li>
                                                Using search engines is acceptable
                                            </li>
                                            <li>
                                                Once you answer and proceed, you can't go back to edit answer choices
                                            </li>
                                            <li>
                                                You may exit the quiz and resume later, but you'll forgo points for the question you’re on when you exit
                                            </li>
                                            <li>
                                                Each question is timed
                                            </li>
                                           
                                        </ul>
                                         -->

                                    <?php 
                                      if (get_current_user_id()!=0) 
                                      {
                                    ?>
                                            <a href="/dashboard/user/assessment"  class="btn btnGetStartAssessment">Start</a>
                                    <?php
                                      }
                                        else
                                        {
                                    ?>
                                        <a href="#" data-toggle="modal" data-target="#exampleModalCenter"  class="btn btnGetStartAssessment">Start</a>
                                    <?php
                                      }
                                    ?>
                                        </div>
                                </div>
                                <div id="tab2" class="tab-content">
                                    <?php
                                    if(!empty($reviews)){
                                        foreach($reviews as $review){
                                            $user = $review['user'];
                                            $image_author = get_field('profile_img',  'user_' . $user->ID);
                                            $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';
                                            $rating = $review['rating'];
                                        ?>
                                        <div class="review-info-card">
                                            <div class="review-user-mini-profile">
                                                <div class="user-photo">
                                                    <img src="<?= $image_author; ?>" alt="">
                                                </div>
                                                <div class="user-name">
                                                    <p><?= $user->display_name; ?></p>
                                                    <div class="rating-element">
                                                        <div class="rating">
                                                        <?php
                                                            for($i = $rating; $i >= 1; $i--){
                                                                if($i == $rating)
                                                                    echo '<input type="radio" name="rating" value="' . $i . ' " checked disabled/>
                                                                    <label class="star" title="" aria-hidden="true"></label>';
                                                                else
                                                                    echo '<input type="radio" name="rating" value="' . $i . ' " disabled/>
                                                                        <label class="star" title="" aria-hidden="true"></label>';
                                                            }
                                                        ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="reviewsText"><?= $review['feedback']; ?></p>

                                        </div>
                                    <?php
                                        }
                                    }
                                    else
                                        echo "<h6>No reviews for this course ...</h6>";
                                    ?>
                                </div>
                                <div id="tab3" class="tab-content">
                                    <?php
                                    if($user_id != 0 && !$my_review_bool){
                                    ?>
                                    <div class="formSingleCoourseReview">
                                        <label>Rating</label>
                                        <div class="rating-element2">
                                            <div class="rating">
                                                <input type="radio" id="star5" class="stars" name="rating" value="5" />
                                                <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4" class="stars" name="rating" value="4" />
                                                <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3" class="stars" name="rating" value="3" />
                                                <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2" class="stars" name="rating" value="2" />
                                                <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label class="star" for="star1" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Feedback</label>
                                            <textarea name="feedback_content" id="feedback" rows="10"></textarea>
                                        </div>
                                        <input type="button" class='btn btn-sendRating' id='btn_review' name='review_post' value='Send'>
                                    </div>
                                    <?php
                                    }
                                    else
                                        echo "<button data-toggle='modal' data-target='#SignInWithEmail'  data-dismiss='modal'class='btnLeerom' style='border:none'> You must sign-in for review </button>";
                                    ?>
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
                    <div class="blockElementCardDetailLive">
                        <hr class="horizontalHr">
                        <hr class="verticalHr">
                        <div class="CarddetailLive">
                            <div class="tg-card">
                                <img class="card-icon" src="<?php echo get_stylesheet_directory_uri();?>/img/developpement.png" alt="">
                                <p class="tg-title">Format</p>
                                <p class="tg-element">Multiple Choice Quiz</p>
                            </div>
                        </div>
                        <div class="CarddetailLive">
                            <div class="tg-card">
                                <img class="card-icon" src="<?php echo get_stylesheet_directory_uri();?>/img/level.png" alt="">
                                <p class="tg-title">Difficulty</p>
                                <p class="tg-element"><?= $assessment_array['difficulty_assessment'] ?></p>
                            </div>
                        </div>
                        <div class="CarddetailLive">
                            <div class="tg-card">
                                <img class="card-icon" src="<?php echo get_stylesheet_directory_uri();?>/img/lhorloge.png" alt="">
                                <p class="tg-title">Times</p>
                                <p class="tg-element"> <?= $timer; ?> minutes</p>
                            </div>
                        </div>
                        <div class="CarddetailLive">
                            <div class="tg-card">
                                <img class="card-icon" src="<?php echo get_stylesheet_directory_uri();?>/img/speak.png" alt="">
                                <p class="tg-title">Languages</p>
                                <p class="tg-element"><?= $assessment_array['language_assessment'] ?></p>
                            </div>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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