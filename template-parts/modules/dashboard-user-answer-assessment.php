<?php


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

<div class="content-assessment">
    <div class="head3OverviewAssessment">
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

</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

<script>

    var id_current_assessment = "<?php echo $assessment_id; ?>" ;
    var current_index = 1;
    var responses = [];
    var cancelled=false;

    chrono($('#backendTime').html());

    $("#back1").click(function() {
        $("#secondBlockAssessmentsBackend").hide();
        current_index=0;
        responses=[];
    });

    
    
    function paginate()
    {
        let response=[];
            
            for (let index = 1; index <=4; index++) 
        if ($('#answer_'+index).is(":checked"))
            response.push($('#answer_'+index).val());
            responses.push(response);
         
         var question_count = "<?php echo $question_count; ?>"
         if (current_index<question_count)
         {
            
            //console.log(responses);
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
              
            cancelled=true;
            //console.log($('#backendTime').html());
            chrono($('#backendTime').html());
            //$('#test').html(data);
            }
        });
    }
    
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
                    $('.main-container').html("<p class='titleCategorieAssessment'>" +data+ "</p>");    
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
            