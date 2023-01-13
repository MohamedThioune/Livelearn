
<div class="row">
    <?php if($_GET['message']) echo "<span class='alert alert-error'>" . $_GET['message'] . "</span><br><br>"; ?>
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>2.Online or location</h2>
                </div>
            <?php 
                $offline = ['reading', 'event'];
                if(in_array($_GET['type'], $offline))
                    update_field('course_type', $_GET['type'], $_GET['id']);

                // If user choose online (radio button value)
                if (get_field('online_location', $_GET['id']) == "online"){
                    acf_form(array(
                        'post_id'=> $_GET['id'],
                        // url field created from custom fields
                        'fields' => array('link_to', 'long_description'), 
                        'submit_value'  => __('Opslaan & verder'),
                        'return' => '?func=add-add-white&id=%post_id%&step=3'
                    )); 
                }
                // If user choose location (radio button value)
                else if(get_field('online_location', $_GET['id']) == "location"){
                    acf_form(array(
                        'post_id'=> $_GET['id'],
                        // date field already exist on custom fields
                        'fields' => array('dates', 'long_description'), 
                        'submit_value'  => __('Opslaan & verder'),
                        'return' => '?func=add-add-white&id=%post_id%&step=3'
                    ));
                }
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
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-add-white&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=2&edit'; else echo "?message=Please finish this step before"; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2">
                        <i class="fa fa-globe"></i>
                    </div>
                    <p class="textOpleidRight">Online or location</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-add-white&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=3&edit'; else echo "?func=add-white&message=Please finish this step before"; ?>" class="contentBlockCourse">
                    <div class="circleIndicator ">
                        <i class="fa fa-paste" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Settings</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-add-white&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=4&edit'; else echo "?message=Please finish this step before"; ?>"class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-tag" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight ">Onderwerpen</p>
                </a>
                <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-add-white&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=5&edit';?>" class="contentBlockCourse">
                    <div class="circleIndicator"></div>
                    <p class="textOpleidRight">Experts</p>
                </a>
            </div>
        </div>
    </div>
</div>





