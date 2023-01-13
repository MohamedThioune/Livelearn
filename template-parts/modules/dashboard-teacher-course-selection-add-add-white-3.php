
<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>4.Details en onderwerpen </h2>
                </div>
                <?php 
                    acf_form(array(
                        'post_id'       => $_GET['id'],
                        'fields' => array('incompany_mogelijk', 'geacrediteerd', 'btw-klasse'),
                        'submit_value'  => __('Opslaan & naar overzicht'),
                        'return' => '?func=add-add-white&id=%post_id%&step=4'
                    )); 
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-4 col-sm-12">  
        <div class="blockCourseToevoegen">
            <p class="courseToevoegenText">Course toevoegen</p>
            <div class="contentBlockRight">
                <a href="/dashboard/teacher/course-selection/?func=add-white&id=<?php if(isset($_GET['id'])) echo '&id=' .$_GET['id'] . '&type=' . $_GET['type']. '&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape">
                        <i class="fa fa-info"></i>
                    </div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-add-white&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=2&edit'; else echo "?func=add-white&message=Please finish this step before"; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape">
                        <i class="fa fa-globe"></i>
                    </div>
                    <p class="textOpleidRight">Online or location</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-add-white&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=3&edit'; else echo "?func=add-white&message=Please finish this step before"; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2">
                        <i class="fa fa-paste" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Settings</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-add-white&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=4&edit'; else echo "?func=add-white&message=Please finish this step before"; ?>"class="contentBlockCourse">
                    <div class="circleIndicator ">
                        <i class="fa fa-tag" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Onderwerpen</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-add-white&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=5&edit'; else echo "?func=add-white&message=Please finish this step before"; ?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Expert</p>
                </a>
            </div>
        </div>
    </div>
</div>





