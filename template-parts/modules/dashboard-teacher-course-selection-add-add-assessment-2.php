
<?php

if (isset ($_POST) && !empty ($_POST))
{
    extract ($_POST);
    $questions = array();
    for ($i = 0; $i < $questionsCount ; $i++)
    {
        if (isset($titles[$i]) && !empty($titles[$i]))
        {
            $questions[$i]['wording'] = $titles[$i];
            if (isset($timers[$i]) && !empty($timers[$i]))
            {
                $questions[$i]['timer'] = $timers[$i];
                if (isset($responsesFields) && !empty($responsesFields))
                {
                    $questions[$i]['responses'] = array();
                    for ($j = 0; $j < 4; $j++)
                    {
                        array_push($questions[$i]['responses'],$responsesFields[$j]);
                    }
                    array_splice($responsesFields , 0 , 4);
                    if (isset($responseStates) && !empty($responseStates))
                    {
                        $questions[$i]['correct_response'] = array();
                        for ($k = 0; $k < 4; $k++){
                            if ($responseStates[$k] == "true") 
                                array_push($questions[$i]['correct_response'],$k);
                        }
                        array_splice($responseStates , 0 , 4);
                    }
                }
            }
        }
    }
    update_field('course_type', 'assessment', $_GET['id']);
    update_field('question',$questions, $_GET['id']);
}

?>
<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>2.Vragen</h2>
                </div>
                <?php 

                    // acf_form(array(
                    // 'post_id' => $_GET['id'],
                    // 'fields' => array('question'),
                    // 'submit_value'  => __('Opslaan & verder'),
                    // 'return' => '?func=add-add-assessment&id=%post_id%&step=3'
                    // ));
                ?>
            </div>
            <div class="new-assessment-form w-100 assessment-container position-relative">
            <div id = "question_1">
                    <button type="button" class="btn btn-remove-assessments">
                        Remove
                    </button>
                    <div class = "container-question-field" >
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input required type="text" id="title" class="form-control" placeholder="Title of your queestion">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Timer ( m : s )</label>
                        <input required value="00:01:00" id="timer" type="time" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Fill in the responses and check who 's true </label>
                        <?php
                            /** Display possible answers fields for each question  */

                            for($i = 1; $i <= 4; $i++)
                            {
                        ?>
                                <div class="group-input-assement">
                                    <input required type="text" class="form-control" placeholder= "<?php echo 'Answer ' .$i; ?>" id="responseField">
                                    <input required type="checkbox"  id="responseState">
                                </div>
                        <?php
                            }
                        ?>


                    </div>

                </div>
            </div>
                <div id="append">

                </div>
                <div class="mt-5">
                    <button type="button" id="addQuestion" class="add btn-newDate"> + Add question</button>
                </div>
                <div class="mt-5">
                    <button type="button" id="createAssessment" class="add btn-newDate"> Next </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-lg-4 col-sm-12">
        <div class="blockCourseToevoegen">
            <p class="courseToevoegenText">Course toevoegen</p>
            <div class="contentBlockRight">
                <a href="/dashboard/teacher/course-selection/" class="contentBlockCourse">
                    <div class="circleIndicator passEtape">
                        <i class="fa fa-book"></i>
                    </div>
                    <p class="textOpleidRight">Opleidingstype</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-assessment<?php if(isset($_GET['id'])) echo '&id=' .$_GET['id'] . '&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape">
                        <i class="fa fa-info"></i>
                    </div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-add-assessment&id=' . $_GET['id'] . '&step=2&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2">
                        <i class="fa fa-question"></i>
                    </div>
                    <p class="textOpleidRight">Vragen</p>
                </a>
                <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-add-assessment&id=' . $_GET['id'] . '&step=3&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-file-text"></i>
                    </div>
                    <p class="textOpleidRight">Beschrijving Assessment</p>
                </a>
                <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-add-assessment&id=' . $_GET['id'] . '&step=4&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-paste" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Onderwerpen</p>
                </a>
                <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-add-assessment&id=' . $_GET['id'] . '&step=5&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Experts</p>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>

     

     



    $(document).ready(function() {
    var questionsCount=1;
    var questionary = $("#question_1").html()


$("#addQuestion").click(() => {
    questionsCount++
    $('#append').append(jQuery('<div>', {
      id: "question_"+questionsCount,
  }).append(questionary))
})

$("body").on("click", ".btn-remove-assessments", function () {
            if( questionsCount > 1)
            {
                questionsCount--;
                console.log($(this).attr('class'))
                $(this).parent().remove();
                //$(this).parents("#question_1").remove();
            }
            else
                alert('You must have at least one question !')
        })


       

    $("#createAssessment").click(() => {
    var  titles =[] ,responsesFields = [] ,responseStates = [] ,timers = []  ;
    document.querySelectorAll("#title").forEach((element) => {titles.push(element.value)})
    document.querySelectorAll("#responseField").forEach((element) => {responsesFields.push(element.value)}),
    document.querySelectorAll("#responseState").forEach((element) => {responseStates.push(element.checked)})
    document.querySelectorAll("#timer").forEach((element) => {timers.push(element.value)})
    $.ajax(
        {
            type: 'post',
            dataType: 'text',
            data:
            {
                titles : titles,
                responsesFields: responsesFields,
                responseStates : responseStates,
                timers : timers,
                questionsCount: questionsCount
            },
            success: (result) => {

                let id_post = <?php echo $_GET['id'] ?>;
                window.location.href = "?func=add-add-assessment&id="+id_post+"&step=3"
            }

        }
    )
        })

})

</script>






