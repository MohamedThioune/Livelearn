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

    $args = array(  
        'post_type' => 'assessment',
        'post_status' => 'publish',
        'order' => 'ASC', 
    );
    $assessments = get_posts($args);
?>


<div class="content-assessment-2">
    <div class="head-element-assessment">
        <h1 class="titleAssessment">Assessments</h1>
        <p class="descriptionAssessment">Stand out from other job seekers by completing an assessment ! Livelearn will feature top performers to employers</p>
    </div>

    <div class="tabs-courses">
        <div class="tabs">
            <div class="head">
                <ul class="filters">
                    <li class="item active">All</li>
                    <li class="item">In Progress</li>
                    <li class="item">Done</li>
                    <li class="item">Other assessment</li>
                </ul>
                <!-- <input type="search" class="form-control search" placeholder="search"> -->
            </div>
            <div class="tabs__list">
                <div class="tab active">
                   <div class="contentCardAssessment">
                       <div class="cardAssessement">
                           <div class="heead-img-block">
                               <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                           </div>
                           <div class="body-card-assessment">
                               <p class="title-assessment">Backend assessments</p>
                               <p class="level">Medium</p>
                               <div class="d-flex justify-content-between flex-wrap">
                                   <div class="d-flex element-detail-assessment">
                                       <i class="far fa-clock"></i>
                                       <p class="text-element-detail">7 Minutes</p>
                                   </div>
                                   <div class="d-flex element-detail-assessment">
                                       <i class="far fa-clone"></i>
                                       <p class="text-element-detail">Multiple Choice Quiz</p>
                                   </div>
                               </div>
                           </div>
                           <div class="footerCardSkillsssessment">
                               <a href="" class="btn btnDetailsAssessment">Details</a>
                               <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                           </div>
                       </div>
                       <div class="cardAssessement">
                           <div class="heead-img-block">
                               <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                           </div>
                           <div class="body-card-assessment">
                               <p class="title-assessment">Backend assessments</p>
                               <p class="level">Medium</p>
                               <div class="d-flex justify-content-between flex-wrap">
                                   <div class="d-flex element-detail-assessment">
                                       <i class="far fa-clock"></i>
                                       <p class="text-element-detail">7 Minutes</p>
                                   </div>
                                   <div class="d-flex element-detail-assessment">
                                       <i class="far fa-clone"></i>
                                       <p class="text-element-detail">Multiple Choice Quiz</p>
                                   </div>
                               </div>
                           </div>
                           <div class="footerCardSkillsssessment">
                               <a href="" class="btn btnDetailsAssessment">Details</a>
                               <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                           </div>
                       </div>
                       <div class="cardAssessement">
                           <div class="heead-img-block">
                               <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                           </div>
                           <div class="body-card-assessment">
                               <p class="title-assessment">Backend assessments</p>
                               <p class="level">Medium</p>
                               <div class="d-flex justify-content-between flex-wrap">
                                   <div class="d-flex element-detail-assessment">
                                       <i class="far fa-clock"></i>
                                       <p class="text-element-detail">7 Minutes</p>
                                   </div>
                                   <div class="d-flex element-detail-assessment">
                                       <i class="far fa-clone"></i>
                                       <p class="text-element-detail">Multiple Choice Quiz</p>
                                   </div>
                               </div>
                           </div>
                           <div class="footerCardSkillsssessment">
                               <a href="" class="btn btnDetailsAssessment">Details</a>
                               <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                           </div>
                       </div>
                       <div class="cardAssessement">
                           <div class="heead-img-block">
                               <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                           </div>
                           <div class="body-card-assessment">
                               <p class="title-assessment">Backend assessments</p>
                               <p class="level">Medium</p>
                               <div class="d-flex justify-content-between flex-wrap">
                                   <div class="d-flex element-detail-assessment">
                                       <i class="far fa-clock"></i>
                                       <p class="text-element-detail">7 Minutes</p>
                                   </div>
                                   <div class="d-flex element-detail-assessment">
                                       <i class="far fa-clone"></i>
                                       <p class="text-element-detail">Multiple Choice Quiz</p>
                                   </div>
                               </div>
                           </div>
                           <div class="footerCardSkillsssessment">
                               <a href="" class="btn btnDetailsAssessment">Details</a>
                               <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                           </div>
                       </div>
                       <div class="cardAssessement">
                           <div class="heead-img-block">
                               <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                           </div>
                           <div class="body-card-assessment">
                               <p class="title-assessment">Backend assessments</p>
                               <p class="level">Medium</p>
                               <div class="d-flex justify-content-between flex-wrap">
                                   <div class="d-flex element-detail-assessment">
                                       <i class="far fa-clock"></i>
                                       <p class="text-element-detail">7 Minutes</p>
                                   </div>
                                   <div class="d-flex element-detail-assessment">
                                       <i class="far fa-clone"></i>
                                       <p class="text-element-detail">Multiple Choice Quiz</p>
                                   </div>
                               </div>
                           </div>
                           <div class="footerCardSkillsssessment">
                               <a href="" class="btn btnDetailsAssessment">Details</a>
                               <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                           </div>
                       </div>
                   </div>
                </div>
                <div class="tab">
                    <div class="contentCardAssessment">
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab">
                    <div class="contentCardAssessment">
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab">
                    <div class="contentCardAssessment">
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail">7 Minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                                <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id="">Get Started</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


<!--    <div class="contentAsessment">
        <div class="contentCardAssessment">
            <?php
/*                foreach($assessments as $key => $assessment) {
                   
                    $description = get_field('description_assessment',$assessment->ID);
                    $how_it_works = get_field('how_it_works', $assessment->ID);
                    $level = get_field('difficulty_assessment', $assessment->ID);
                    $language = get_field('language_assessment', $assessment->ID);

                    $timer = 0;
                    $questions = get_field('question',$assessment->ID);
                    $number_question = 0;
                    if(!empty($questions))
                        $number_question = count($questions);
                    foreach ($questions as $question)
                    {
                        $question_time = $question['timer'];
                        $timer += timeToSeconds($question_time);
                    }
                    // Get minutes by given string seconds
                    $timer = ceil($timer/60);

                    //Image
                    $image = get_field('image_assessement', $assessment->ID)['url'];
                    if(!$image){
                        $image = get_the_post_thumbnail_url($assessment->ID);
                        if(!$image)
                            $image = get_field('url_image_xml', $assessment->ID);
                                if(!$image)
                                    $image = get_stylesheet_directory_uri() . '/img' . '/backend1.png';
                    }

                    //Tags !mportant 
                    $posttags = get_the_tags();

                    if(!$posttags){
                        $category_default = get_field('categories', $assessment->ID);
                        $category_xml = get_field('category_xml', $assessment->ID);
                    }

            ?>
                    <div class="cardAssessement" >
                        <div class="bodyCardAssessment">
                            <div class="contentImgAssessment">
                                <img src="<?php /*= $image; */?>">
                            </div>
                            <div>
                                <p class="textMutliSelect"><?php /*= $level */?></p>
                                <p class="categoryCours"><?php /*= $assessment->post_title */?> </p>
                                <p class="elementCategory">
                                    <?php
/*                                    if(!empty($posttags))
                                        foreach($posttags as $posttag)
                                            echo $posttag->name . ',';
                                    else{
                                        $read_category = array();
                                        if(!empty($category_default))
                                            foreach($category_default as $item)
                                                if($item)
                                                    if(!in_array($item['value'],$read_category)){
                                                        array_push($read_category,$item['value']);
                                                        echo (String)get_the_category_by_ID($item['value']) . ',';
                                                    }
                                        else if(!empty($category_xml))
                                            foreach($category_xml as $item)
                                                if($item)
                                                    if(!in_array($item['value'],$read_category)){
                                                        array_push($read_category,$item['value']);
                                                        echo (String)get_the_category_by_ID($item['value']) . ',';
                                                    }
                                    }
                                    */?>
                                </p>
                                <div class="d-flex align-items-center">
                                    <img src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/mdi_timer-sand.png">
                                    <p class="timeAssessement"><?php /*= $timer */?> Minutes</p>
                                </div>
                            </div>
                        </div>
                        <div class="footerCardSkillsssessment">
                            <a href= <?php /*echo "/detail-assessment/?assessment_id=" . $assessment->ID; */?> class="btn btnDetailsAssessment">Details</a>
                            <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id= <?php /*= $assessment->ID; */?> >Get Started</button>
                        </div>
                    </div>
            <?php
/*                }
            */?>
            
          
    </div>
    </div>-->


<!--for backend-->
<div id="backend">
    <div class="modal fade modalAssessment" id="ModalBackEnd" tabindex="-1" role="dialog" aria-labelledby="ModalBackEndLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="firstblockAssessments">
                        <p class="titleCategorieAssessment">Start your test</p>
                        <p class="descriptionAssessmentModal"><?= $description ?></p>
                        <p class="instructionTitle">Instructions</p>
                        <div class="listInstruction">
                            <ul>
                                <li>
                                    <div class="circleInsctruction"></div>
                                    <p>Each question is timed</p>
                                </li>
                                <li>
                                    <div class="circleInsctruction"></div>
                                    <p>Using search engines is acceptable</p>
                                </li>
                                <li>
                                    <div class="circleInsctruction"></div>
                                    <p>Once you answer and proceed, you can't go back to edit answer choices</p>
                                </li>
                                <li>
                                    <div class="circleInsctruction"></div>
                                    <p>You may exit the quiz and resume later, but you'll forgo points for the question you’re on when you exit</p>
                                </li>
                                <li>
                                    <div class="circleInsctruction"></div>
                                    <p>Each question is timed</p>
                                </li>
                                <li>
                                    <div class="circleInsctruction"></div>
                                    <p>Each question is timed</p>
                                </li>
                            </ul>
                        </div>
                        <div class="otherInformation">
                            <div class="elementOtherInformation">
                                <p class="firstElement">Time</p>
                                <p class="secondElement"><?= $timer ?> minutes</p>
                            </div>
                            <div class="elementOtherInformation">
                                <p class="firstElement">Language</p>
                                <p class="secondElement"><?= $language ?></p>
                            </div>
                            <div class="elementOtherInformation">
                                <p class="firstElement">Difficulty</p>
                                <p class="secondElement"><?= $level ?></p>
                            </div>
                        </div>
                        <button class="btn btnStratModal medium" id="btnStratModal1"  data-dismiss="modal">Start</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="secondBlockAssessmentsBackend">
        <div class="headSecondBlockAssessment">
            <button class="btn btnBackAssessments mr-2" id="back1"><img src="<?php echo get_stylesheet_directory_uri();?>/img/bi_arrow-left.png"></button>
            <p class="titleCategorieAssessment">Start your test</p>
        </div>
        <div class="card cardOverviewAssessment">
            <div id="step1OverviewAssessmentBackend">
                <p class="overviewAssementTitle">Overview</p>
                <div class="listDescription">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/VectorPoly.png">
                    <p class="descriptionlistElement">Each question is timed</p>
                </div>
                <div class="listDescription">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/VectorPoly.png">
                    <p class="descriptionlistElement">Once you answer and proceed, you can't go back to edit answer choices</p>
                </div>
                <div class="listDescription">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/VectorPoly.png">
                    <p class="descriptionlistElement">You may exit the quiz and resume later, but you'll forgo points for the question you’re on when you exit</p>
                </div>
                <button class="btn btnStratModal medium" id="btnStart2">Start</button>
            </div>

            <div id="step2OverviewAssessmentBackend" class="stepchooseTech">
                <p class="chooseTechnoTitle">Choose at least 3 technologies to start with </p>
                <div class="form-group formModifeChoose">

                    <select id="foo_select" class="dropdown multipleSelect3" form="foo_form" multiple data-placeholder="Click to select an Techno">
                        <option value="PHP">PHP</option>
                        <!-- <option value="Laravel">Laravel</option>
                        <option value="SQL">SQL</option> -->
                    </select>
                    <button class="btn btnStratModal" id="btnStart3">Continue</button>
                </div>
            </div>


            <div id="step3OverviewAssessmentBackend">
                <div id="child">
                    <?php
                    if(!empty($number_question)){
                    ?>
                    <div class="head3OverviewAssessment">
                        <p class="assessmentNUmber" id="current-index">Question 1 / <?php echo count($question); ?></p>
                        <p class="assessmentTime" id="backendTime"> </p>
                    </div>
                    <p class="chooseTechnoTitle" id="wording"><span> (Multiple choose posible)</span></p>
                    <div class="listAnswer">
                        <form id="getAnswer">
                        <?php
                            $alphabet = range('A', 'Z');
                            for ($i=1;$i<=4;$i++) { ?>
                                <label class="container-checkbox">
                                    <span class="numberAssassment"><?= $alphabet[$i]?> </span>
                                    <span class="assassment  <?php echo 'answer_'.($i);?>"></span>
                                    <input name="<?php echo "answer_".($i); ?>" id=<?php echo "answer_".($i); ?> type="checkbox" value="<?php echo $i; ?>" >
                                    <span class="checkmark"></span>
                                </label>
                            <?php
                                } 
                            ?>
                        </form>
                    </div>
                    <?php
                    }
                    else
                        echo "<p class='chooseTechnoTitle'>No question found !</p>"
                    ?>
                </div>
                <button type="button" class="btn btnStratModal" id="btnBackend">Continue</button>
            </div>
        
    </div>
</div>
</div>

                <!--for backend-->



</div>

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

    var id_current_assessment;
    var current_index=0;
    var responses = [];
    var cancelled=false;
    $('.btnGetStartAssessment').click((e)=>{
        id_current_assessment = e.target.id;
        $.ajax({
            url:"/answer-assessment",
            method:"post",
            data:{
                id_current_assessment:id_current_assessment,
                current_index:current_index
            },
        dataType:"text",
        success: function(data){ 
            console.log(data);
            data=JSON.parse(data);
            current_index++;
            $('#wording').html(data.wording+"<span> (Multiple choose posible)</span>");
            $('#current-index').text("Question "+current_index+" / "+data.count);
            //console.log(data,current_index);
            //$('#current-index').text("Question "+current_index+" / "+data.length);
              let length = data.responses.length;
              for (let i = 0; i < length; i++) {
                $('.answer_'+(i+1)).text(data.responses[i]);
                $('#answer_'+(i+1)).val(i);
                $('#answer_'+(i+1)).prop('checked',false); 
              }
              $('#backendTime').text(data.timer);

              if (current_index==question_count) {
                $('#btnBackend').text("Finish");
              }
              
            cancelled=true;
            //console.log($('#backendTime').html());
            chrono($('#backendTime').html());
            //$('#test').html(data);
            }
        });
    });

    $("#back1").click(function() {
        $("#secondBlockAssessmentsBackend").hide();
        current_index=0;
        responses=[];
    });

    
    
    function paginate()
    {
        let response=[];
            //$('#getAnswer').preventDefault();
            for (let index = 1; index <=4; index++) 
        if ($('#answer_'+index).is(":checked"))
            response.push($('#answer_'+index).val());
            responses.push(response);
            //console.log(responses);
         var txt=$('#current-index').text()
            txt=txt.split(" ")
            //console.log(txt)
         var current_index=txt[1]
         var question_count=txt[3]
         if (current_index<question_count) 
         $.ajax({
            url:"/answer-assessment",
            method:"post",
            data:{
                id_current_assessment:id_current_assessment,
                current_index:current_index
            },
        dataType:"text",
        success: function(data){ 
            console.log(data);
            data=JSON.parse(data);
            current_index++;
            $('#wording').html(data.wording+"<span> (Multiple choose posible)</span>");
            $('#current-index').text("Question "+current_index+" / "+data.count);
            //console.log(data,current_index);
            //$('#current-index').text("Question "+current_index+" / "+data.length);
              let length = data.responses.length;
              for (let i = 0; i < length; i++) {
                $('.answer_'+(i+1)).text(data.responses[i]);
                $('#answer_'+(i+1)).val(i);
                $('#answer_'+(i+1)).prop('checked',false); 
              }
              $('#backendTime').text(data.timer);

              if (current_index==question_count) {
                $('#btnBackend').text("Finish");
              }
              
            cancelled=true;
            //console.log($('#backendTime').html());
            chrono($('#backendTime').html());
            //$('#test').html(data);
            }
        });
        else if ($('#btnBackend').text()=="Finish") {
            $.ajax({
                url:"/answer-assessment",
                method:"post",
                data:{
                    id_current_assessment:id_current_assessment,
                    user_responses:responses
                },
                dataType:"text",
                success: function(data){ 
                    $('#step3OverviewAssessmentBackend').html("<p class='titleCategorieAssessment'>" +data+ "</p>");    
                    }
                });
        }
    }
    function chrono(time)
    {
         if (cancelled) {
             cancelled=false;
             clearInterval()
     return;
   } 
        time = time.split(':');
       var minutes = time[0], seconds = time[1];
         var interval = setInterval(function() {
             if (seconds > 0 )
                seconds = --seconds;
              if (minutes >0) {
                if (seconds <= 0) {
                    minutes = --minutes;
                    seconds = 59;
                }
              }
              if (seconds < 10 && seconds > 0) {
                    seconds = "0" + seconds;
                }
              else
              if ((minutes <= 0 && seconds <= 0)  || cancelled==true) {
                $('#backendTime').html("00 : 00");
                clearInterval(interval); 
                paginate();
              }
              $('#backendTime').html(minutes + ":" + seconds);
            }, 1000);    
    }

    $(document).ready(function(){
        $('#btnStart3').click(()=>{
            var time=$('#backendTime').html();
            chrono(time);
        });
       
        $('#btnBackend').click(()=>{
            paginate();
        });
        });
</script>
<script id="rendered-js" >
    $(document).ready(function () {
        //Select2
        $(".multipleSelect3").select2({
            placeholder: "Choose technologies" //placeholder
        });
    });
    //# sourceURL=pen.js
</script>