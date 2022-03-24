<?php
    $users = get_users();
    $data_user = wp_get_current_user();
  
    $members = array();

    foreach($users as $user)
        if(in_array( 'author', $user->roles ) )
            array_push($members, $user);   
?>
    <div class="row">
        <div class="col-md-5 col-lg-8">
            <div class="cardCoursGlocal">
                <div id="basis" class="w-100">
                    <div class="titleOpleidingstype">
                        <h2 id="exp">Experts</h2>
                    </div>
                    <form action="/dashboard/teacher/course-overview/?id=<?php echo $_GET['id'] ?>" method="post">
                        <div class="acf-field">
                            <label for="locate">Wijs andere experts uit uw team aan voor deze cursus :</label><br>
                            <div class="form-group formModifeChoose" >
                                <div class="form-group formModifeChoose">

                                    <select name="experts[]" id="autocomplete" class="multipleSelect2" multiple="true">
                                        <?php 
                                            foreach($members as $member) {
                                                echo "<option value='" . $member->ID ."'>" . $member->display_name . "</option>";
                                            }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <button type="submit" name="expert_add" class="btn btn-info">Finish</button> 
                        </div>
                    </form>

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
                    <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=1" class="contentBlockCourse">
                        <div class="circleIndicator passEtape"></div>
                        <p class="textOpleidRight">Basis informatie</p>
                    </a>
                    <?php if(isset($_GET['id'])){ ?>

                    <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=2" class="contentBlockCourse">
                        <div class="circleIndicator passEtape"></div>
                        <p class="textOpleidRight">Uitgebreide beschrijving</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=3" class="contentBlockCourse">
                        <div class="circleIndicator passEtape"></div>
                        <p class="textOpleidRight ">Data en locaties</p>
                    </a>
                        <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=4" class="contentBlockCourse">
                        <div class="circleIndicator passEtape"></div>
                        <p class="textOpleidRight">Details en onderwepren</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=5" class="contentBlockCourse">
                        <div class="circleIndicator passEtape"></div>
                        <p class="textOpleidRight">Tags</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=6" class="contentBlockCourse">
                        <div class="circleIndicator passEtape2"></div>
                        <p class="textOpleidRight">Experts</p>
                    </a>
                    <?php } ?>

                </div>
            </div>
        </div>
        
    </div>

    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

    