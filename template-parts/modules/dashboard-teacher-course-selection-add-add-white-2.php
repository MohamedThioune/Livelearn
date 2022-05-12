
<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>2.Online or location</h2>
                </div>
            <?php 
              $offline = ['reading','event'];
              if(in_array($_GET['type'], $offline))
                update_field('course_type', $_GET['type'], $_GET['id']);

                // If user choose online (radio button value)
              if (get_field('online_location', $_GET['id'])=="online")
                {
                        acf_form(array(
                        'post_id'=> $_GET['id'],
                        // url field created from custom fields
                        'fields' => array('link_to'), 
                        'submit_value'  => __('Opslaan & verder'),
                        'return' => '?func=add-add-white&id=%post_id%&step=3'
                        )); 
                }
                    // If user choose location (radio button value)
                else
                    if(get_field('online_location', $_GET['id'])=="location")
                    {
                        acf_form(array(
                            'post_id'=> $_GET['id'],
                            // date field already exist on custom fields
                            'fields' => array('dates'), 
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
            <a href="/dashboard/teacher/course-selection/?func=add-white&id=<?php echo $_GET['id'];?>" class="contentBlockCourse">
                            <div class="circleIndicator  passEtape"></div>
                            <p class="textOpleidRight">Basis informatie</p>
                        </a>
                        <a href="/dashboard/teacher/course-selection/?func=add-add-white&id=<?php echo $_GET['id'];?>&step=2" class="contentBlockCourse">
                            <div class="circleIndicator passEtape2"></div>
                            <p class="textOpleidRight">Online or location</p>
                        </a>
                        <a href="/dashboard/teacher/course-selection/?func=add-add-white&id=<?php echo $_GET['id'];?>&step=3" class="contentBlockCourse">
                            <div class="circleIndicator passEtape2"></div>
                            <p class="textOpleidRight ">Tags</p>
                        </a>
                        <a href="/dashboard/teacher/course-selection/?func=add-add-white&id=<?php echo $_GET['id'];?>&step=4" class="contentBlockCourse">
                            <div class="circleIndicator passEtape2"></div>
                            <p class="textOpleidRight">Expert</p>
                        </a>
            </div>
        </div>
    </div>
</div>





