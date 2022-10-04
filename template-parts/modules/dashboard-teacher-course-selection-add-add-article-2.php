<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>2.Article Itself</h2>
                </div>
                <?php
                    if(isset($_GET['id']))
                        acf_form(array(
                            'post_id'       => $_GET['id'],
                            'fields' => array('article_itself'),
                            'submit_value'  => __('Opslaan & verder'),
                            'return' => '?func=add-add-article&id=%post_id%&step=3'
                        )); 
                ?>
                <div id="summernote">Hello Summernote</div>

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
                <?php if(isset($_GET['id'])){ ?>
                    <a href="/dashboard/teacher/course-selection/?func=add-add-article&id=<?php echo $_GET['id'];?>&step=2&edit" class="contentBlockCourse">
                        <div class="circleIndicator passEtape2">
                            <i class="fa fa-font"></i>
                        </div>
                        <p class="textOpleidRight">Schrijf je artikel</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-add-article&id=<?php echo $_GET['id'];?>&step=3&edit" class="contentBlockCourse">
                        <div class="circleIndicator">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                        </div>
                        <p class="textOpleidRight">Tags</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-add-article&id=<?php echo $_GET['id'];?>&step=4&edit" class="contentBlockCourse">
                        <div class="circleIndicator">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        <p class="textOpleidRight">Experts</p>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
