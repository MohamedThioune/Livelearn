<?php

    $args = array(  
            'post_type' => 'assessment',
            'post_status' => 'publish',
            'order' => 'ASC', 
        );
        $assessments=get_posts($args);
    
?>

<div class="content-assessment">
    <div class="contentAsessment">
        <center>
            <h1 class="titleAssessment">Assessments</h1>
            <p class="descriptionAssessment">Stand out from other job seekers by completing an assessment ! Livelearn will feature top performers to employers</p>
        </center>
        <div class="contentCardAssessment">
            <?php
                foreach($assessments as $key => $assessment) {
            ?>
            <div class="cardAssessement" >
                <div class="bodyCardAssessment">
                    <div class="contentImgAssessment">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/backend1.png">
                    </div>
                    <div>
                        <p class="textMutliSelect">Multiple Choice Quiz</p>
                        <p class="categoryCours"><?= $assessment->post_title  ?> </p>
                        <p class="elementCategory">Algorithms, data structures, databases, HTTP, web frameworks</p>
                        <div class="d-flex align-items-center">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_timer-sand.png">
                            <p class="timeAssessement">25 Minutes</p>
                        </div>
                    </div>
                </div>
                <div class="footerCardSkillsssessment">
                    <a href= <?= "/detail-assessment?assessment_id=$assessment->ID"; ?> class="btn btnDetailsAssessment">Details</a>
                    <button class="btn btnGetStartAssessment" data-target="#ModalBackEnd" data-toggle="modal" id= <?= $assessment->ID; ?> >Get Started</button>
                </div>
            </div>
            <?php
                }
            ?>
            
          
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
                        <!-- <option value="Laravel">Laravel</option>
                        <option value="SQL">SQL</option> -->
                    </select>
                    <button class="btn btnStratModal" id="btnStart3">Continue</button>
                </div>
            </div>


            <div id="step3OverviewAssessmentBackend">
                <div id="child">
    
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
            </div>
            <button type="button" class="btn btnStratModal" id="btnBackend">Continue</button>
        </div>
        
    </div>
</div>
</div>

                <!--for backend-->



</div>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
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