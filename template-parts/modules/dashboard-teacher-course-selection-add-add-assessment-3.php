
<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>3. Beschrijving Assessment</h2>
                </div>
                <?php 
                    acf_form(array(
                    'post_id' => $_GET['id'],
                    'fields' => array('how_it_works', 'language_assessment', 'difficulty_assessment'),
                    'submit_value'  => __('Opslaan & verder'),
                    'return' => '?func=add-add-assessment&id=%post_id%&step=4'
                    )); 
                ?>
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
                    <div class="circleIndicator passEtape">
                        <i class="fa fa-question"></i>
                    </div>
                    <p class="textOpleidRight">Vragen</p>
                </a>
                <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-add-assessment&id=' . $_GET['id'] . '&step=3&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2">
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

    $("#addQuestion").click(function() {
        alert('Bonjour')
    })
})

</script>




