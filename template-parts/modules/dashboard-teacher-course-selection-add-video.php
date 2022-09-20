
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
                        'fields' => array('preview', 'price', 'short_description', 'visibility'),
                        'uploader' => 'basic',
                        'submit_value'  => __('Opslaan & verder'),
                        'return' => '?func=add-video&id='.$_GET['id'].'&step=2'
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
                        'fields' => array('preview', 'price', 'short_description', 'visibility'),
                        'uploader' => 'basic',
                        'submit_value'  => __('Opslaan & verder'),
                        'return' => '?func=add-video&id=%post_id%&step=2'
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
                    <div class="circleIndicator passEtape">
                        <i class="fa fa-book"></i>
                    </div>
                    <p class="textOpleidRight">Opleidingstype</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-video<?php if(isset($_GET['id'])) echo '&id=' .$_GET['id'] . '&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2">
                        <i class="fa fa-info"></i>
                    </div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-video&id=<?php echo $_GET['id'];?>&step=2" class="contentBlockCourse">
                    <div class="circleIndicator ">
                        <i class="fa fa-file-text"></i>
                    </div>
                    <p class="textOpleidRight">Uitgebreide beschrijving</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-video&id=<?php echo $_GET['id'];?>&step=3" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-play"></i>
                    </div>
                    <p class="textOpleidRight ">voeg video’s toe</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-video&id=<?php echo $_GET['id'];?>&step=4" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-paste" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Details en onderwepren</p>
                </a>
            </div>
        </div>
    </div>
</div>





