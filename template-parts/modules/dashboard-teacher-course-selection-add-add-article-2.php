
<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>2.Article Itself</h2>
                </div>
                <?php
                    //update_field('course_type', 'article', $_GET['id']);
                    acf_form(
                    array(
                    'post_id'       => $_GET['id'],
                    'fields' => array('article_itself'),
                    'submit_value'  => __('Opslaan & verder'),
                    'return' => '?func=add-add-article&id=%post_id%&step=3'
                    )); 
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-4 col-sm-12">
        <div class="blockCourseToevoegen">
            <p class="courseToevoegenText">Course toevoegen</p>
            <div class="contentBlockRight">
                <a href="/dashboard/teacher/course-selection/?func=add-add-article&id=<?php echo $_GET['id'];?>&step=1" class="contentBlockCourse">
                    <div class="circleIndicator  passEtape"></div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-add-article&id=<?php echo $_GET['id'];?>&step=2" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2"></div>
                    <p class="textOpleidRight">Article Itself</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-add-article&id=<?php echo $_GET['id'];?>&step=3" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2"></div>
                    <p class="textOpleidRight">Tags</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-add-article&id=<?php echo $_GET['id'];?>&step=4" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2"></div>
                    <p class="textOpleidRight">Experts</p>
                </a>
            </div>
        </div>
    </div>
</div>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>


