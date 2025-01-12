<?php
    $users = get_users();
  
    $members = array();
    
    $post = get_post($_GET['id']);
    $author = array($post->post_author);
    $experts = $author;
    if(!empty($expert))
        $experts = array_merge($expert);

    foreach($users as $user)
        if(in_array('author', $user->roles) || in_array('teacher', $user->roles))
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

                                                if($teacher != $user_id)
                                                    $name = ($member->last_name) ? $member->first_name : $member->display_name;
                                                else
                                                    $name = "Ikzelf";
                
                                                if($member->first_name == "")
                                                    continue;

                                                if(in_array($member->ID,$experts)){
                                                    echo "<option selected value='" . $member->ID ."'>" . $name . "</option>";
                                                    continue;
                                                } 
                                                echo "<option value='" . $member->ID ."'>" . $name . "</option>";
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
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-book"></i>
                        </div>
                        <p class="textOpleidRight">Opleidingstype</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-assessment<?php if(isset($_GET['id'])) echo '&id=' .$_GET['id'] . '&edit'; ?>" class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-info"></i>
                        </div>
                        <p class="textOpleidRight">Basis informatie</p>
                    </a>
                    <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-add-assessment&id=' . $_GET['id'] . '&step=2&edit'; ?>" class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-question"></i>
                        </div>
                        <p class="textOpleidRight">Vragen</p>
                    </a>
                    <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-add-assessment&id=' . $_GET['id'] . '&step=3&edit'; ?>" class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <p class="textOpleidRight">Beschrijving Assessment</p>
                    </a>
                    <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-add-assessment&id=' . $_GET['id'] . '&step=4&edit'; ?>" class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-paste" aria-hidden="true"></i>
                        </div>
                        <p class="textOpleidRight">Onderwerpen</p>
                    </a>
                    <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-add-assessment&id=' . $_GET['id'] . '&step=5&edit'; ?>" class="contentBlockCourse">
                        <div class="circleIndicator passEtape2">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        <p class="textOpleidRight">Experts</p>
                    </a>
                </div>
            </div>
        </div>

    </div>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>