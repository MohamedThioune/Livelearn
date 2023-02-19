
<?php 

if (isset ($_POST) && !empty ($_POST))
{
    
    extract ($_POST);

    echo $titles[0];
}
var_dump($_POST);
?>
<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>2.Vragen</h2>
                </div>
                <?php 
                    update_field('course_type', 'assessment', $_GET['id']);
                    acf_form(array(
                    'post_id' => $_GET['id'],
                    'fields' => array('question'),
                    'submit_value'  => __('Opslaan & verder'),
                    'return' => '?func=add-add-assessment&id=%post_id%&step=3'
                    )); 
                ?>
            </div>
            <div class="new-assessment-form w-100 assessment-container">
                <div class = "container-question-field" >
                
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" id="title" class="form-control" placeholder="Title of your queestion">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Timer</label>
                        <input value="00:45" id="timer" type="time" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Fill in the responses and check who 's true </label>
                        <div class="group-input-assement">
                            <input type="text" class="form-control" placeholder="answer 1" id="responseField">
                            <input type="checkbox" value=false id="responseState" name="answerQuestion1">
                        </div>
                        <div class="group-input-assement">
                            <input type="text" class="form-control" placeholder="answer 2" id="responseField">
                            <input type="checkbox" id="responseState" name="answerQuestion1">
                        </div>
                        <div class="group-input-assement">
                            <input type="text" class="form-control" placeholder="answer 3" id="responseField">
                            <input type="checkbox" id="responseState" name="answerQuestion1">
                        </div>
                        <div class="group-input-assement">
                            <input type="text" class="form-control" placeholder="answer 4" id="responseField">
                            <input type="checkbox" id="responseState" name="answerQuestion1">
                        </div>

                        
                    </div>
                
                </div>
                <div class="append"></div>
                <div class="mt-5">
                    <button type="button" id="addQuestion" class="add btn-newDate"> + Add question</button>
                </div>
                <div class="mt-5">
                    <button type="button" id="save" class="add btn-newDate"> Save</button>
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
    var questionary = $(".container-question-field").html()
    $("#addQuestion").click(() => {
        
        $(".append").append(questionary)
        questionsCount++
    })

    $("#save").click(() => {
    var  titles =[] ,responsesFields = [] ,responseStates = [] ,timers = []  ;
    document.querySelectorAll("#title").forEach((element) => {titles.push(element.value)})
    document.querySelectorAll("#responseField").forEach((element) => {responsesFields.push(element.value)}),
    document.querySelectorAll("#responseState").forEach((element) => {responseStates.push(element.value)})
    document.querySelectorAll("#timer").forEach((element) => {timers.push(element.value)})
    $.ajax(
        {
            
            type: 'post',
            dataType: 'text',
            data:{
                titles : titles,
                responsesFields: responsesFields,
                responseStates : responseStates,
                timers : timers
            },
            success: (result) => {
                console.log(result)
            }

        }
    )
        })

})

</script>






