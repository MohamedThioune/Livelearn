
<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>2.Selecteer cursussen</h2>
                    <?php if($_GET['message']) echo "<span class='alert alert-error courseToevoegenText' style='color:red'>* " . $_GET['message'] . "</span><br><br>"; ?>
                </div>
                <?php 
                    update_field('course_type', 'leerpad', $_GET['id']);

                    acf_form(array(
                        'post_id' => $_GET['id'],
                        'fields' => array('road_path'),
                        'submit_value'  => __('Opslaan & naar overzicht'),
                        'return' => '?func=add-road&id=%post_id%&step=3'
                    )); 
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-4 col-sm-12">  
        <div class="blockCourseToevoegen">
            <p class="courseToevoegenText">Course toevoegen</p>
            <div class="contentBlockRight">
                <a href="/dashboard/teacher/course-selection/?func=add-road&id=<?php if(isset($_GET['id'])) echo '&id=' .$_GET['id'] . '&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape">
                        <i class="fa fa-info"></i>
                    </div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-road&id=' . $_GET['id'] . '&step=2&edit'; else echo "?func=add-road&message=Please finish this step before"; ?>"class="contentBlockCourse">
                    <div class="circleIndicator passEtape2">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Selecteer cursussen</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-road&id=' . $_GET['id'] . '&step=3&edit'; else echo "?func=add-road&message=Please finish this step before"; ?>"class="contentBlockCourse">
                    <div class="circleIndicator ">
                        <i class="fa fa-tag" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Onderwerpen</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-road&id=' . $_GET['id'] . '&step=4&edit'; else echo "?func=add-white&message=Please finish this step before"; ?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Experts</p>
                </a>
            </div>
        </div>
    </div>
</div>





