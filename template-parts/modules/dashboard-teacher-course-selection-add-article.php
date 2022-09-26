
<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>1.Basis informatie</h2>
                    <?php if($_GET['message']) echo "<span class='alert alert-error courseToevoegenText' style='color:red'>* " . $_GET['message'] . "</span><br><br>"; ?>
                </div>
                <?php 

                if(isset($_GET['edit']) && isset($_GET['id'])){
                    acf_form(array(
                        'post_id'       => $_GET['id'],
                        'post_title'   => true,
                        'post_excerpt'   => true,
                        'fields' => array('preview','price','short_description','visibility'),
                        'submit_value'  => __('Opslaan & verder'),
                        'return' => '?func=add-add-article&id='.$_GET['id'].'&step=2'
                    ));
                }else{
                    
                    acf_form(
                        array(
                        'post_id'       => 'new_post',
                        'new_post' => array(
                            'post_type'     => 'post',
                            'post_status'     => 'publish',
                        ),
                        'post_title'   => true,
                        'post_excerpt'   => true,
                        'fields' => array('preview','price','short_description', 'visibility'),
                        'submit_value'  => __('Opslaan & verder'),
                        'return' => '?func=add-add-article&id=%post_id%&step=2'
                    )); 
                }?>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-4 col-sm-12">
        <div class="blockCourseToevoegen">
            <p class="courseToevoegenText">Course toevoegen</p>
            <div class="contentBlockRight">
                <a href="/dashboard/teacher/course-selection/?func=add-article<?php if(isset($_GET['id'])) echo '&id=' .$_GET['id'] . '&type=' . $_GET['type']. '&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator  passEtape">
                        <i class="fa fa-info"></i>
                    </div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-add-article&id=' . $_GET['id'] . '&step=2&edit'; echo '?func=add-add-article&message=Please finish this step before'?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2">
                        <i class="fa fa-font"></i>
                    </div>
                    <p class="textOpleidRight">Schrijf je artikel</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-add-article&id=' . $_GET['id'] . '&step=3&edit'; echo '?func=add-add-article&message=Please finish this step before'?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-tag" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Tags</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-add-article&id=' . $_GET['id'] . '&step=4&edit'; echo '?func=add-add-article&message=Please finish this step before'?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Experts</p>
                </a>
            </div>
        </div>
    </div>
</div>





