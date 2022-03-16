<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>3.Data en locaties</h2>
                </div>
                <?php acf_form(array(
    'post_id'       => $_GET['id'],
    'fields' => array('data_locaties'),
    'submit_value'  => __('Opslaan & verder'),
    'return' => '?func=add-offline&id=%post_id%&step=4'
)); ?>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-4 col-sm-12">
        <div class="blockCourseToevoegen">
            <p class="courseToevoegenText">Course toevoegen</p>
            <div class="contentBlockRight">
                <a href="/dashboard/teacher/course-selection/" class="contentBlockCourse">
                    <div class="circleIndicator passEtape"></div>
                    <p class="textOpleidRight">Opleidingstype</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-course&id=385&step=2" class="contentBlockCourse">
                    <div class="circleIndicator  passEtape"></div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=2" class="contentBlockCourse">
                    <div class="circleIndicator passEtape"></div>
                    <p class="textOpleidRight">Uitgebreide beschrijving</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=3" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2"></div>
                    <p class="textOpleidRight ">Data en locaties</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=4" class="contentBlockCourse">
                    <div class="circleIndicator"></div>
                    <p class="textOpleidRight">Details en onderwepren</p>
                </a>
            </div>
        </div>
    </div>
</div>





