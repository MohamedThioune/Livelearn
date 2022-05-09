
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
                        'fields' => array('field_610f19a34af16','field_610f0d9b21fb8','short_description'),
                        'submit_value'  => __('Opslaan & verder'),
                        'return' => '?func=add-course&id='.$_GET['id'].'&step=2'
                    ));
                }else{

                    acf_form(array(
                        'post_id'       => 'new_post',
                        'new_post' => array(
                            'post_type'     => 'course',
                            'post_status'     => 'publish',
                        ),
                        'post_title'   => true,
                        'post_excerpt'   => true,
                        'fields' => array('field_610f19a34af16','field_610f0d9b21fb8', 'short_description'),
                        'submit_value'  => __('Opslaan & verder'),
                        'return' => '?func=add-course&id=%post_id%&step=2'
                    )); 
                }?>
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
                    <div class="circleIndicator  passEtape2"></div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <?php if(isset($_GET['id'])){ ?>
                <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=2" class="contentBlockCourse">
                    <div class="circleIndicator"></div>
                    <p class="textOpleidRight">Uitgebreide beschrijving</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=3" class="contentBlockCourse">
                    <div class="circleIndicator"></div>
                    <p class="textOpleidRight ">Data en locaties</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=4" class="contentBlockCourse">
                    <div class="circleIndicator"></div>
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





