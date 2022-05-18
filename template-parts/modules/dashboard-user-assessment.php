<?php
$args = array(  
        'post_type' => 'assessment',
        'post_status' => 'publish',
        'order' => 'ASC', 
    );
    $loop = new WP_Query( $args ); 
    $count_question=0;
    while ( $loop->have_posts() ) : $loop->the_post(); 
        $count_question++;
        $post_id = get_the_ID();
        $question=get_field( "question", $post_id );
        //var_dump($question);
        // print the_title(); 
        // the_excerpt(); 
    endwhile;
        ?>

<div class="content-assessment">
    <div class="contentAsessment">
        <center>
            <h1 class="titleAssessment">Assessments</h1>
            <p class="descriptionAssessment">Stand out from other job seekers by completing an assessment ! Livelearn will feature top performers to employers</p>
        </center>
        <div class="contentCardAssessment">
            <div class="cardAssessement" >
                <div class="bodyCardAssessment">
                    <div class="contentImgAssessment">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/backend1.png">
                    </div>
                    <div>
                        <p class="textMutliSelect">Multiple Choice Quiz</p>
                        <p class="categoryCours">Back-End Web</p>
                        <p class="elementCategory">Algorithms, data structures, databases, HTTP, web frameworks</p>
                        <div class="d-flex align-items-center">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_timer-sand.png">
                            <p class="timeAssessement">25 Minutes</p>
                        </div>
                    </div>
                </div>
                <div class="footerCardSkillsssessment">
                    <a href="/detail-assessment" class="btn btnDetailsAssessment">Details</a>
                    <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal">Get Started</button>
                </div>
            </div>
          <!-- <div class="cardAssessement">
              <div class="bodyCardAssessment">
                  <div class="contentImgAssessment">
                      <img src="<?php echo get_stylesheet_directory_uri();?>/img/front1.png">
                  </div>
                  <div>
                      <p class="textMutliSelect">Multiple Choice Quiz</p>
                      <p class="categoryCours">Front-end</p>
                      <p class="elementCategory">React, HTML, CSS, JavaScript & DOM, HTTP</p>
                      <div class="d-flex align-items-center">
                          <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_timer-sand.png">
                          <p class="timeAssessement">25 Minutes</p>
                      </div>
                  </div>
              </div>
              <div class="footerCardSkillsssessment">
                  <a href="/detail-assessment" class="btn btnDetailsAssessment">Details</a>
                  <button class="btn btnGetStartAssessment"  data-target="#ModalFrontEnd" data-toggle="modal">Get Started</button>
              </div>
            </div>
            <div class="cardAssessement" >
                <div class="bodyCardAssessment">
                    <div class="contentImgAssessment">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/fullstack1.png">
                    </div>
                    <div>
                        <p class="textMutliSelect">Multiple Choice Quiz</p>
                        <p class="categoryCours">Full-stack</p>
                        <p class="elementCategory">Front-end and back-end web development</p>
                        <div class="d-flex align-items-center">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_timer-sand.png">
                            <p class="timeAssessement">25 Minutes</p>
                        </div>
                    </div>
                </div>
                <div class="footerCardSkillsssessment">
                    <a href="/detail-assessment" class="btn btnDetailsAssessment">Details</a>
                    <button class="btn btnGetStartAssessment" data-target="#ModalFull" data-toggle="modal">Get Started</button>
                </div>
            </div>
            <div class="cardAssessement">
                <div class="bodyCardAssessment">
                    <div class="contentImgAssessment">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/android1.png">
                    </div>
                    <div>
                        <p class="textMutliSelect">Multiple Choice Quiz</p>
                        <p class="categoryCours">Android</p>
                        <p class="elementCategory">Android SDK, Kotlin, and Java</p>
                        <div class="d-flex align-items-center">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_timer-sand.png">
                            <p class="timeAssessement">25 Minutes</p>
                        </div>
                    </div>
                </div>
                <div class="footerCardSkillsssessment">
                    <a href="/detail-assessment" class="btn btnDetailsAssessment">Details</a>
                    <button class="btn btnGetStartAssessment" data-target="#ModalAndroid" data-toggle="modal">Get Started</button>
                </div>
            </div>
            <div class="cardAssessement" >
                <div class="bodyCardAssessment">
                    <div class="contentImgAssessment">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/apple1.png">
                    </div>
                    <div>
                        <p class="textMutliSelect">Multiple Choice Quiz</p>
                        <p class="categoryCours">IOS</p>
                        <p class="elementCategory">iOS SDK, Swift, and Objective-C</p>
                        <div class="d-flex align-items-center">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_timer-sand.png">
                            <p class="timeAssessement">25 Minutes</p>
                        </div>
                    </div>
                </div>
                <div class="footerCardSkillsssessment">
                    <a href="/detail-assessment" class="btn btnDetailsAssessment">Details</a>
                    <button class="btn btnGetStartAssessment" data-target="#ModalIOS" data-toggle="modal">Get Started</button>
                </div>
            </div>
        </div> -->
    </div>

</div>


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
                        <p class="titleCategorieAssessment">Back-End Web Development</p>
                        <p class="descriptionAssessmentModal">The Back-End Web Quiz assesses basic technical competency in back-end web development.  Topics include programmatic problem solving, APIs, databases, and systems design.  Candidates who do well have demonstrated applicable knowledge in algorithms & data structures, integrating and building APIs, querying relational databases, and understanding of web architecture.</p>
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
                                <p class="secondElement">25 minutes</p>
                            </div>
                            <div class="elementOtherInformation">
                                <p class="firstElement">Format</p>
                                <p class="secondElement">Multiple Choice Quiz</p>
                            </div>
                            <div class="elementOtherInformation">
                                <p class="firstElement">Difficulty</p>
                                <p class="secondElement">Medium</p>
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
            <p class="titleCategorieAssessment">Back-End Web Development</p>
        </div>
        <div class="card cardOverviewAssessment">
            <div id="step1OverviewAssessmentBackend">
                <p class="overviewAssementTitle">Overview</p>
                <div class="listDescription">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/VectorPoly.png">
                    <p class="descriptionlistElement">Make sure you choose at least 3 technologies to start with </p>
                </div>
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
                        <option value="Laravel">Laravel</option>
                        <option value="SQL">SQL</option>
                    </select>
                    <button class="btn btnStratModal" id="btnStart3">Continue</button>
                </div>
            </div>


            <div id="step3OverviewAssessmentBackend">
                <div id="child">
    
            <div class="head3OverviewAssessment">
                    <p class="assessmentNUmber" id="current-index">Question 1 / <?php echo count($question); ?></p>
                    <p class="assessmentTime" id="backendTime"><?php echo $question[0]['timer'] ?></p>
                </div>
                <p class="chooseTechnoTitle" id="wording"><?php echo $question[0]['wording'] ?><span> (Multiple choose posible)</span></p>
                <div class="listAnswer">
                    <form id="getAnswer">
                      <?php
                        $alphabet = range('A', 'Z');
                        foreach ($question[0]['responses'] as $key => $value) { ?>
                            <label class="container-checkbox">
                                <span class="numberAssassment"><?= $alphabet[$key]?> </span>
                                <span class="assassment  <?php echo 'answer_'.($key+1);?>"> <?php echo $value ?></span>
                                <input name="<?php echo "answer_".($key+1); ?>" id=<?php echo "answer_".($key+1); ?> type="checkbox" value="<?php echo $key; ?>" >
                                <span class="checkmark"></span>
                            </label>
                        <?php
                            } 
                        ?>
                    </form>
                </div>
            </div>
            <button type="button" class="btn btnStratModal" id="btnBackend">Continue</button>
        </div>
        
    </div>
</div>
</div>

                <!--for backend-->
<!-- <div id="frontend">
    <div class="modal fade modalAssessment" id="ModalFrontEnd" tabindex="-1" role="dialog" aria-labelledby="ModalFrontEndLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="firstblockAssessments">
                        <p class="titleCategorieAssessment">Front-End Web Development</p>
                        <p class="descriptionAssessmentModal">The Front-End Web Quiz assesses basic technical competency in front-end web development. Topics covered include HTML & CSS, JavaScript, and React. High-scoring candidates have proficiency in vanilla HTML markup and CSS rules and how they relates to web page presentation, a good understanding of modern JavaScript (ES2015 and later), and familiarity with the React.js framework.</p>
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
                            </ul>
                        </div>
                        <div class="otherInformation">
                            <div class="elementOtherInformation">
                                <p class="firstElement">Time</p>
                                <p class="secondElement">25 minutes</p>
                            </div>
                            <div class="elementOtherInformation">
                                <p class="firstElement">Format</p>
                                <p class="secondElement">Multiple Choice Quiz</p>
                            </div>
                            <div class="elementOtherInformation">
                                <p class="firstElement">Difficulty</p>
                                <p class="secondElement">Medium</p>
                            </div>
                        </div>
                        <button class="btn btnStratModal medium" id="btnStratModalfront"  data-dismiss="modal">Start</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="secondBlockAssessmentsfront" class="frontElementstep">
        <div class="headSecondBlockAssessment">
            <button class="btn btnBackAssessments mr-2" id="back1front"><img src="<?php echo get_stylesheet_directory_uri();?>/img/bi_arrow-left.png"></button>
            <p class="titleCategorieAssessment">Front-End Web Development</p>
        </div>
        <div class="card cardOverviewAssessment">
            <div id="step1OverviewAssessmentfront">
                <p class="overviewAssementTitle">Overview</p>
                <div class="listDescription">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/VectorPoly.png">
                    <p class="descriptionlistElement">Make sure you choose at least 3 technologies to start with </p>
                </div>
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
                <button class="btn btnStratModal medium" id="btnStart2front">Start</button>
            </div>

            <div class="frontElementstep stepchooseTech" id="step2OverviewAssessmentfront">
                <p class="chooseTechnoTitle">Choose at least 3 technologies to start with </p>
                <div class="form-group formModifeChoose">

                    <select id="foo_select" class="dropdown multipleSelect3" form="foo_form" multiple data-placeholder="Click to select an Techno">
                        <option value="null">HTML</option>
                        <option value="null">CSS</option>
                        <option value="null">JS</option>
                    </select>
                    <button class="btn btnStratModal" id="btnStart3front">Continue</button>
                </div>
            </div>


            <div id="step3OverviewAssessmentfront" class="frontElementstep">
                <div class="head3OverviewAssessment">
                    <p class="assessmentNUmber">Question 1 / 30</p>
                    <p class="assessmentTime">4 : 05</p>
                </div>
                <p class="chooseTechnoTitle">Select the correct sql query <span>(Multiple choose posible)</span></p>
                <div class="listAnswer">
                    <label class="container-checkbox">
                        <span class="numberAssassment">A.</span>
                        <span class="assassment">SELECT * FROM table_name_0;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">B.</span>
                        <span class="assassment">SELECT DISTINCT column1, column2, ... FROM table_name;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">C.</span>
                        <span class="assassment">SELECT * FROM table_name_0;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">D.</span>
                        <span class="assassment">SELECT * FROM table_name_0;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <button class="btn btnStratModal" >Continue</button>
            </div>
        </div>
    </div>
</div> -->

                <!--full stack -->
<!-- <div id="fullstack">
    <div class="modal fade modalAssessment" id="ModalFull" tabindex="-1" role="dialog" aria-labelledby="ModalFullLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="firstblockAssessments">
                        <p class="titleCategorieAssessment">Full-Stack Web Development</p>
                        <p class="descriptionAssessmentModal">The Full-Stack Web Quiz assesses basic technical competency in full-stack web development. It covers five areas: programmatic problem solving, core front-end technologies (HTML, CSS, JavaScript, React), APIs, databases, and devops. Strong candidates are likely to have the ability to create and maintain web-based applications.</p>
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
                            </ul>
                        </div>
                        <div class="otherInformation">
                            <div class="elementOtherInformation">
                                <p class="firstElement">Time</p>
                                <p class="secondElement">25 minutes</p>
                            </div>
                            <div class="elementOtherInformation">
                                <p class="firstElement">Format</p>
                                <p class="secondElement">Multiple Choice Quiz</p>
                            </div>
                            <div class="elementOtherInformation">
                                <p class="firstElement">Difficulty</p>
                                <p class="secondElement">Medium</p>
                            </div>
                        </div>
                        <button class="btn btnStratModal medium" id="btnStratModalfull"  data-dismiss="modal">Start</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="secondBlockAssessmentsfull" class="frontElementstep">
        <div class="headSecondBlockAssessment">
            <button class="btn btnBackAssessments mr-2" id="back1full"><img src="<?php echo get_stylesheet_directory_uri();?>/img/bi_arrow-left.png"></button>
            <p class="titleCategorieAssessment">Full-Stack Web Development</p>
        </div>
        <div class="card cardOverviewAssessment">
            <div id="step1OverviewAssessmentfull">
                <p class="overviewAssementTitle">Overview</p>
                <div class="listDescription">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/VectorPoly.png">
                    <p class="descriptionlistElement">Make sure you choose at least 3 technologies to start with </p>
                </div>
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
                <button class="btn btnStratModal medium" id="btnStart2full">Start</button>
            </div>

            <div class="frontElementstep stepchooseTech" id="step2OverviewAssessmentfull">
                <p class="chooseTechnoTitle">Choose at least 3 technologies to start with </p>
                <div class="form-group formModifeChoose">

                    <select id="foo_select" class="dropdown multipleSelect3" form="foo_form" multiple data-placeholder="Click to select an Techno">
                        <option value="null">HTML</option>
                        <option value="null">CSS</option>
                        <option value="null">JS</option>
                    </select>
                    <button class="btn btnStratModal" id="btnStart3full">Continue</button>
                </div>
            </div>


            <div id="step3OverviewAssessmentfull" class="frontElementstep">
                <div class="head3OverviewAssessment">
                    <p class="assessmentNUmber">Question 1 / 30</p>
                    <p class="assessmentTime">4 : 05</p>
                </div>
                <p class="chooseTechnoTitle">Select the correct sql query <span>(Multiple choose posible)</span></p>
                <div class="listAnswer">
                    <label class="container-checkbox">
                        <span class="numberAssassment">A.</span>
                        <span class="assassment">SELECT * FROM table_name_0;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">B.</span>
                        <span class="assassment">SELECT DISTINCT column1, column2, ... FROM table_name;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">C.</span>
                        <span class="assassment">SELECT * FROM table_name_0;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">D.</span>
                        <span class="assassment">SELECT * FROM table_name_0;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <button class="btn btnStratModal" >Continue</button>
            </div>
        </div>
    </div>
</div> -->

                <!--Android-->
<!-- <div id="Android">
    <div class="modal fade modalAssessment" id="ModalAndroid" tabindex="-1" role="dialog" aria-labelledby="ModalAndroidLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="firstblockAssessments">
                        <p class="titleCategorieAssessment">Android App Development</p>
                        <p class="descriptionAssessmentModal">The Android Quiz assesses the ability to create Android apps using Android Studio. Strong candidates have demonstrated knowledge of Kotlin and Java programming languages, familiarity with the Android SDK, and experience with its development environment.</p>
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
                            </ul>
                        </div>
                        <div class="otherInformation">
                            <div class="elementOtherInformation">
                                <p class="firstElement">Time</p>
                                <p class="secondElement">25 minutes</p>
                            </div>
                            <div class="elementOtherInformation">
                                <p class="firstElement">Format</p>
                                <p class="secondElement">Multiple Choice Quiz</p>
                            </div>
                            <div class="elementOtherInformation">
                                <p class="firstElement">Difficulty</p>
                                <p class="secondElement">Medium</p>
                            </div>
                        </div>
                        <button class="btn btnStratModal medium" id="btnStratModalAndroid"  data-dismiss="modal">Start</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="secondBlockAssessmentsAndroid" class="frontElementstep">
        <div class="headSecondBlockAssessment">
            <button class="btn btnBackAssessments mr-2" id="back1Android"><img src="<?php echo get_stylesheet_directory_uri();?>/img/bi_arrow-left.png"></button>
            <p class="titleCategorieAssessment">Android App Development</p>
        </div>
        <div class="card cardOverviewAssessment">
            <div id="step1OverviewAssessmentAndroid">
                <p class="overviewAssementTitle">Overview</p>
                <div class="listDescription">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/VectorPoly.png">
                    <p class="descriptionlistElement">Make sure you choose at least 3 technologies to start with </p>
                </div>
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
                <button class="btn btnStratModal medium" id="btnStart2Android">Start</button>
            </div>

            <div class="frontElementstep stepchooseTech" id="step2OverviewAssessmentAndroid">
                <p class="chooseTechnoTitle">Choose at least 3 technologies to start with </p>
                <div class="form-group formModifeChoose">

                    <select id="foo_select" class="dropdown multipleSelect3" form="foo_form" multiple data-placeholder="Click to select an Techno">
                        <option value="null">HTML</option>
                        <option value="null">CSS</option>
                        <option value="null">JS</option>
                    </select>
                    <button class="btn btnStratModal" id="btnStart3Android">Continue</button>
                </div>
            </div>


            <div id="step3OverviewAssessmentAndroid" class="frontElementstep">
                <div class="head3OverviewAssessment">
                    <p class="assessmentNUmber">Question 1 / 30</p>
                    <p class="assessmentTime">4 : 05</p>
                </div>
                <p class="chooseTechnoTitle">Select the correct sql query <span>(Multiple choose posible)</span></p>
                <div class="listAnswer">
                    <label class="container-checkbox">
                        <span class="numberAssassment">A.</span>
                        <span class="assassment">SELECT * FROM table_name_0;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">B.</span>
                        <span class="assassment">SELECT DISTINCT column1, column2, ... FROM table_name;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">C.</span>
                        <span class="assassment">SELECT * FROM table_name_0;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">D.</span>
                        <span class="assassment">SELECT * FROM table_name_0;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <button class="btn btnStratModal" >Continue</button>
            </div>
        </div>
    </div>
</div> -->

                <!--IOS-->
<!-- <div id="IOS">
    <div class="modal fade modalAssessment" id="ModalIOS" tabindex="-1" role="dialog" aria-labelledby="ModalIOSLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="firstblockAssessments">
                        <p class="titleCategorieAssessment">IOS App Development</p>
                        <p class="descriptionAssessmentModal">The IOS Quiz assesses the ability to create iOS apps using Apple's SDK. Strong candidates have demonstrated knowledge of Swift and Objective-C programming languages, familiarity with the iOS SDK, and experience with the Xcode development environment.</p>
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
                            </ul>
                        </div>
                        <div class="otherInformation">
                            <div class="elementOtherInformation">
                                <p class="firstElement">Time</p>
                                <p class="secondElement">25 minutes</p>
                            </div>
                            <div class="elementOtherInformation">
                                <p class="firstElement">Format</p>
                                <p class="secondElement">Multiple Choice Quiz</p>
                            </div>
                            <div class="elementOtherInformation">
                                <p class="firstElement">Difficulty</p>
                                <p class="secondElement">Medium</p>
                            </div>
                        </div>
                        <button class="btn btnStratModal medium" id="btnStratModalIOS"  data-dismiss="modal">Start</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="secondBlockAssessmentsIOS" class="frontElementstep">
        <div class="headSecondBlockAssessment">
            <button class="btn btnBackAssessments mr-2" id="back1IOS"><img src="<?php echo get_stylesheet_directory_uri();?>/img/bi_arrow-left.png"></button>
            <p class="titleCategorieAssessment">IOS App Development</p>
        </div>
        <div class="card cardOverviewAssessment">
            <div id="step1OverviewAssessmentIOS">
                <p class="overviewAssementTitle">Overview</p>
                <div class="listDescription">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/VectorPoly.png">
                    <p class="descriptionlistElement">Make sure you choose at least 3 technologies to start with </p>
                </div>
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
                <button class="btn btnStratModal medium" id="btnStart2IOS">Start</button>
            </div>

            <div class="frontElementstep stepchooseTech" id="step2OverviewAssessmentIOS">
                <p class="chooseTechnoTitle">Choose at least 3 technologies to start with </p>
                <div class="form-group formModifeChoose">

                    <select id="foo_select" class="dropdown multipleSelect3" form="foo_form" multiple data-placeholder="Click to select an Techno">
                        <option value="HTML">HTML</option>
                        <option value="CSS">CSS</option>
                        <option value="JS">JS</option>
                    </select>
                    <button class="btn btnStratModal" id="btnStart3IOS">Continue</button>
                </div>
            </div>


            <div id="step3OverviewAssessmentIOS" class="frontElementstep">
                <div class="head3OverviewAssessment">
                    <p class="assessmentNUmber">Question 1 / 30</p>
                    <p class="assessmentTime">4 : 05</p>
                </div>
                <p class="chooseTechnoTitle">Select the correct sql query <span>(Multiple choose posible)</span></p>
                <div class="listAnswer" id="list-answer">
                    <label class="container-checkbox">
                        <span class="numberAssassment">A.</span>
                        <span class="assassment">SELECT * FROM table_name_0;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">B.</span>
                        <span class="assassment">SELECT DISTINCT column1, column2, ... FROM table_name;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">C.</span>
                        <span class="assassment">SELECT * FROM table_name_0;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">D.</span>
                        <span class="assassment">SELECT * FROM table_name_0;</span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <button class="btn btnStratModal" >Continue</button>
            </div>
        </div>
    </div>
</div> -->


</div>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script>
    var current_index;
    var responses = [];
    var cancelled=false;
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