
<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>1.Basis informatie</h2>
                </div>
                <?php 
                if(isset($_GET['edit']) && isset($_GET['id'])){
                    acf_form(array(
                        'post_id'       => $_GET['id'],
                        'post_title'   => true,
                        'post_excerpt'   => true,
                        'fields' => array('preview','price','short_description','internal_external','online_location'),
                        'submit_value'  => __('Opslaan & verder'),
                        'return' => '?func=add-add-white&id='.$_GET['id'].'&step=2&type='.$_GET['type']
                    ));
                }else
                {
                    acf_form(array(
                        'post_id'       => 'new_post',
                        'new_post' => array(
                            'post_type'     => 'course',
                            'post_status'     => 'publish',
                        ),
                        'post_title'   => true,
                        'post_excerpt'   => true,
                        'fields' => array('preview','price','short_description','internal_external','online_location'),
                        'submit_value'  => __('Opslaan & verder'),
                        'return' => '?func=add-add-white&id=%post_id%&step=2&type='.$_GET['type']
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
                            <div class="circleIndicator  passEtape2"></div>
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





