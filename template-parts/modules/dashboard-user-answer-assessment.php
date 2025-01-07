<?php

if (get_current_user_id() === 0)
        header('Location: /');

function timeToSeconds(string $time): int
{
    $time_array = explode(':', $time);
    if (count($time_array) === 2 && $time_array[0]!='00') {
        return  $time_array[0] * 60 + $time_array[1];
    }
    return (int)$time_array[1];
}
    if (isset($_POST) && !empty ($_POST))
    {
        extract($_POST);
        $assessment = get_post($assessment_id);
        $questions = get_field('question',$assessment->ID);
        $question_count = count($questions);
        
    }
?>
<div class="main-container-assessment">

    <div class="d-block w-100">
        <div class="content-assessment">
        <div class="head3OverviewAssessment">
        <p class="count_question" id= <?php echo count($questions); ?> hidden=hidden ></p>
            <p class="assessmentNUmber" id="current-index">Question 1 / <?php echo count($questions); ?></p>
            <p class="assessmentTime" id="backendTime"><?php echo $questions[0]['timer'] ?></p>
        </div>

        <p class="chooseTechnoTitle" id="wording"><?php echo $questions[0]['wording'] ?><span> (Multiple choose posible)</span></p>

        <div class="listAnswer">
            <form id="getAnswer">
                <?php
                $alphabet = range('A', 'Z');
                for ($i=0;$i<4;$i++)
                {

                    ?>
                    <label class="container-checkbox">
                        <span class="numberAssassment"><?= $alphabet[$i]?> </span>
                        <span class="assassment  <?php echo 'answer_'.($i+1);?>"> <?= $questions[0]["responses"][$i] ?> </span>
                        <input name="<?php echo "answer_".($i+1); ?>" id=<?php echo "answer_".($i+1); ?> type="checkbox" value="<?php echo $i; ?>" >
                        <span class="checkmark"></span>
                    </label>

                    <?php
                }

                ?>
                <button type="button" class="btn btnStratModal" id="btnBackend">Continue</button>

        </div>
        </div>
                                            <!-- Success Component -->

     <div class="content-assessment mt-5 success-component" hidden=true>
        <div class="block-img-response">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/badge-assessment-sucess.png" alt="">
        </div>
        <p class="congrat-text">Congratulations</p>
        <p class="congrat-description">Congratulations! You have successfully completed your assessment. Well done! Your hard work and dedication have paid off. You should be proud of your accomplishment. Keep up the excellent work and continue to strive for success in all your endeavors.</p>
        <p class="title-scrore">YOUR SCORE</p>
        <p class="score"></p>
        <div class="d-flex justify-content-center">
            <a href="assessment/" class="btn btn-other-assessment">Other Assessment</a>
        </div>
    </div> 

                                            <!-- Fail Component -->

     <div class="content-assessment mt-5 fail-component" hidden=true>
        <div class="block-img-response">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/badge-assessment-failed.png" alt="">
        </div>
        <p class="congrat-text">Fail</p>
        <p class="congrat-description">sorry to inform you that your assessment quiz did not meet the required criteria. While you put in effort, there were some areas that fell short of the expected standards. Don't be discouraged, as assessments are meant to help identify areas for improvement</p>
        <p class="title-scrore">YOUR SCORE</p>
        <p class="score"></p>
        <div class="d-flex justify-content-center group-btn-assessment">
            <a href="assessment/" class="btn btn-other-assessment">Other Assessment</a>
            <!-- <a  href="" class="btn btn-retry">Retry</a> -->
        </div>
    </div>

    </div>

</div>




<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

<script>

    // Durée par défaut pour chaque question en secondes
const questionDuration = 90;
let timeRemaining = questionDuration;
let timerInterval;


var id_current_assessment = "<?php echo $assessment_id; ?>" ;
var current_index = 1;
var responses = [];
var cancelled=false;



function startTimer() {
  // Mettre à jour l'affichage initial
  updateTimerDisplay();

  // Démarrer le minuteur
  timerInterval = setInterval(function() {
    // Décrémenter le temps restant
    timeRemaining--;

    // Mettre à jour l'affichage
    updateTimerDisplay();

    // Vérifier si le temps est écoulé
    if (timeRemaining <= 0) {
      // Réinitialiser le minuteur
      resetTimer();

      // Passer à la question suivante (à implémenter)
      nextQuestion();
    }
  }, 1000);
}

function resetTimer() {
  // Réinitialiser le temps restant
  timeRemaining = questionDuration;

  // Arrêter le minuteur
  clearInterval(timerInterval);
}

function onClickContinue(){
    
}

function updateTimerDisplay() {
  // Afficher le temps restant dans le format mm:ss
  const minutes = Math.floor(timeRemaining / 60);
  const seconds = timeRemaining % 60;
  const timerDisplay = document.getElementById('backendTime');
  timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
}


function nextQuestion() 
{
    let response=[];
    for (let index = 1; index <=4; index++) 
        if ($('#answer_'+index).is(":checked"))
            response.push($('#answer_'+index).val());
        responses.push(response);

    var question_count = "<?php echo $question_count; ?>"
    if (current_index<question_count)
    {
        console.log(responses);
        $.ajax({
            url:"/answer-assessment",
            method:"post",
            data:{
                id_current_assessment:id_current_assessment,
                current_index:current_index
            },
        dataType:"text",
        success: function(data)
        { 
            data=JSON.parse(data);
            current_index++;
            $('#wording').html(data.wording+"<span> (Multiple choose posible)</span>");
            $('#current-index').text("Question "+current_index+" / "+data.count);
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
            
            // cancelled=true;
            // console.log($('#backendTime').html());
            // chrono($('#backendTime').html());
            // $('#test').html(data);
            }
        });
    }

    else if ($('#btnBackend').text()=="Finish") 
    {
        $.ajax({
            url:"/answer-assessment",
            method:"post",
            data:{
                id_current_assessment:id_current_assessment,
                user_responses:responses
            },
            dataType:"text",
            success: function(data)
            { 
                var score = parseInt(data);
                $('.content-assessment').attr("hidden",true)
                $('.score').text( score+" %" );
                if (score >= 50)
                        $('.success-component').attr( "hidden", false );
                else
                        $('.fail-component').attr( "hidden", false );
            }
            });
    }


  // Implémentez votre logique pour passer à la question suivante ici
  // ...

  // Pour l'exemple, réinitialisez le minuteur et démarrez-le pour la prochaine question
  resetTimer();
  startTimer();
}

$('#btnBackend').click(()=>{
             nextQuestion();            
});

// Démarrez le minuteur au chargement de la page
startTimer();
    



    

//     chrono($('#backendTime').html());

//     $("#back1").click(function() {
//         $("#secondBlockAssessmentsBackend").hide();
//         current_index=0;
//         responses=[];
//     });

    
    
//     
//     function chrono(time)
//     {
//          if (cancelled) {
//              cancelled=false;
//              clearInterval()
//      return;
//    } 
//         time = time.split(':');
//        var minutes = time[0], seconds = time[1];
//          var interval = setInterval(function() {
//              if (seconds > 0 )
//                 seconds = --seconds;
//               if (minutes >0) {
//                 if (seconds <= 0) {
//                     minutes = --minutes;
//                     seconds = 59;
//                 }
//               }
//               if (seconds < 10 && seconds > 0) {
//                     seconds = "0" + seconds;
//                 }
//               else
//               if ((minutes <= 0 && seconds <= 0)  || cancelled==true) {
//                 $('#backendTime').html("00 : 00");
//                 clearInterval(interval); 
//                 paginate();
//               }
//               $('#backendTime').html(minutes + ":" + seconds);
//             }, 1000);    
//     }

    // $(document).ready(function(){
    //     $('#btnStart3').click(()=>{
    //         var time=$('#backendTime').html();
    //         chrono(time);
    //     });
       
    //     $('#btnBackend').click(()=>{
    //         paginate();
            
    //     });
    //     });





</script>
            