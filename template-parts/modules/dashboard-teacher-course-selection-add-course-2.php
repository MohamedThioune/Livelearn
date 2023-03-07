<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>2.Uitgebreidess beschrijving</h2>
                </div>
                <?php
                    $offline = ['course','training','workshop','masterclass','cursus'];
                    if(in_array($_GET['type'], $offline))
                        update_field('course_type', $_GET['type'], $_GET['id']);

                    acf_form(array(
                        'post_id'       => $_GET['id'],
                        'field_groups' => array('group_6155d485977f6'),
                        'submit_value'  => __('Opslaan & verder'),
                        'return' => '?func=add-course&id=%post_id%&step=3'
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
                <a href="/dashboard/teacher/course-selection/?func=add-course<?php if(isset($_GET['id'])) echo '&id=' .$_GET['id'] . '&type=' . $_GET['type']. '&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape">
                        <i class="fa fa-info"></i>
                    </div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=2&edit'; else echo "?message=Please finish this step before"; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2">
                        <i class="fa fa-file-text"></i>
                    </div>
                    <p class="textOpleidRight">Uitgebreide beschrijving</p>
                </a>
                <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=3&edit' ?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight ">Data en locaties</p>
                </a>
                <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=4&edit'?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-paste" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Settings</p>
                </a>
                <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=5&edit'?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-tag" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Onderwerpen</p>
                </a>
                <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=6&edit' ?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Experts</p>
                </a>
            </div>
        </div>
    </div>
</div>

