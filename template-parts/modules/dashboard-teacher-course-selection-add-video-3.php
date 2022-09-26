<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>3.Voeg video’s toe</h2>
                </div>
                <?php 
                acf_form(array(
                    'post_id'       => $_GET['id'],
                    'fields' => array('data_virtual'),
                    'uploader' => 'basic',
                    'submit_value'  => __('Opslaan & verder'),
                    'return' => '?func=add-video&id=%post_id%&step=4'
                )); 
                ?>

                <!-- 
                    <form action="">
                        <div class="lessonBlock">
                            <div class="input-group-course">
                                <label for="">Lesson title</label>
                                <input type="text">
                            </div>
                            <div class="input-group-course">
                                <label for="">Lesson description</label>
                                <input type="text">
                            </div>
                            <div class="input-group-course">
                                <label for="">Lesson data</label>
                                <input type="file">
                            </div>
                        </div>
                        <button type="button" class="btn btn-newDate " data-toggle="modal" data-target="#exampleModalDataLesson">
                            Add another Data en Lesson
                        </button>


                        <!-- Modal  Add another Data en Lesson -->
                        <!--                     
                        <div class="modal fade" id="exampleModalDataLesson" tabindex="-1" role="dialog" aria-labelledby="exampleModalDataLesson" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add another Data en Lesson</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group-course">
                                            <label for="">Lesson title</label>
                                            <input type="text">
                                        </div>
                                        <div class="input-group-course">
                                            <label for="">Lesson description</label>
                                            <input type="text">
                                        </div>
                                        <div class="input-group-course">
                                            <label for="">Lesson data</label>
                                            <input type="file">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-SaveDate">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form> 
                --> 

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
                <a href="/dashboard/teacher/course-selection/?func=add-video<?php if(isset($_GET['id'])) echo '&id=' .$_GET['id'] . '&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape"></div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-video&id=<?php echo $_GET['id'];?>&step=2" class="contentBlockCourse">
                    <div class="circleIndicator passEtape"></div>
                    <p class="textOpleidRight">Uitgebreide beschrijving</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-video&id=<?php echo $_GET['id'];?>&step=3" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2"></div>
                    <p class="textOpleidRight ">voeg video’s toe</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-video&id=<?php echo $_GET['id'];?>&step=4" class="contentBlockCourse">
                    <div class="circleIndicator"></div>
                    <p class="textOpleidRight">Details en onderwepren</p>
                </a>
                <a  href="<?php echo '/dashboard/teacher/course-selection/?func=add-video&id=' . $_GET['id'] . '&step=5&edit'; ?>"  class="contentBlockCourse">
                    <div class="circleIndicator"></div>
                    <p class="textOpleidRight">Tags</p>
                </a>
                <a  href="<?php echo '/dashboard/teacher/course-selection/?func=add-video&id=' . $_GET['id'] . '&step=6&edit'; ?>"  class="contentBlockCourse">
                    <div class="circleIndicator"></div>
                    <p class="textOpleidRight">Experts</p>
                </a>
            </div>
        </div>
    </div>
</div>





