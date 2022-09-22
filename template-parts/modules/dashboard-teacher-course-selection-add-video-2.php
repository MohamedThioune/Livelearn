
<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>2.Uitgebreide beschrijving</h2>
                </div>
                <?php
                
                update_field('course_type', 'video', $_GET['id']);
 
                acf_form(array(
                    'post_id'       => $_GET['id'],
                    'field_groups' => array('group_6155d485977f6'),
                    'submit_value'  => __('Opslaan & verder'),
                    'return' => '?func=add-video&id=%post_id%&step=3'
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
                    <div class="circleIndicator passEtape"></div>
                    <p class="textOpleidRight">Opleidingstype</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-video<?php if(isset($_GET['id'])) echo '&id=' .$_GET['id'] . '&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator  passEtape"></div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-video&id=' . $_GET['id'] . '&step=2&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2"></div>
                    <p class="textOpleidRight">Uitgebreide beschrijving</p>
                </a>
                <a  href="<?php echo '/dashboard/teacher/course-selection/?func=add-video&id=' . $_GET['id'] . '&step=3&edit'; ?>"  class="contentBlockCourse">
                    <div class="circleIndicator"></div>
                    <p class="textOpleidRight ">voeg video’s toe</p>
                </a>
                <a  href="<?php echo '/dashboard/teacher/course-selection/?func=add-video&id=' . $_GET['id'] . '&step=4&edit'; ?>"  class="contentBlockCourse">
                    <div class="circleIndicator"></div>
                    <p class="textOpleidRight">Details en onderwepren</p>
                </a>
                <a  href="<?php echo '/dashboard/teacher/course-selection/?func=add-video&id=' . $_GET['id'] . '&step=5&edit'; ?>"  class="contentBlockCourse">
                    <div class="circleIndicator"></div>
                    <p class="textOpleidRight">Tags</p>
                </a>
                <a  href="<?php echo '/dashboard/teacher/course-selection/?func=add-video&id=' . $_GET['id'] . '&step=6&edit'; ?>"  class="contentBlockCourse">
                    <div class="circleIndicator"></div>
                    <p class="textOpleidRight">Experts</p>
                </a>
            </div>
        </div>
    </div>
</div>





