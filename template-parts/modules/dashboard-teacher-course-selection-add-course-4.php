<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>4.Details en onderwerpen </h2>
                </div>
                <?php acf_form(array(
                    'post_id'       => $_GET['id'],
                    'fields' => array('incompany_mogelijk', 'geacrediteerd', 'btw-klasse'),
                    'submit_value'  => __('Opslaan & naar overzicht'),
                    'return' => '?func=add-course&id=%post_id%&step=5'
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
                <a href="/dashboard/teacher/course-selection/?func=add-course" class="contentBlockCourse">
                <div class="circleIndicator  passEtape"></div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <?php if(isset($_GET['id'])){ ?>
                <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=2" class="contentBlockCourse">
                    <div class="circleIndicator passEtape"></div>
                    <p class="textOpleidRight">Uitgebreide beschrijving</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=3" class="contentBlockCourse">
                    <div class="circleIndicator passEtape"></div>
                    <p class="textOpleidRight ">Data en locaties</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=4" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2"></div>
                    <p class="textOpleidRight">Details en onderwepren</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=5" class="contentBlockCourse">
                    <div class="circleIndicator"></div>
                    <p class="textOpleidRight">Tags</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=6" class="contentBlockCourse">
                    <div class="circleIndicator"></div>
                    <p class="textOpleidRight">Experts</p>
                </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>





