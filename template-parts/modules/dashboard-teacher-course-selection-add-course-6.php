<?php
    $users = get_users();
  
    $members = array();
    
    $post = get_post($_GET['id']);
    $author = array($post->post_author);
    $expert = get_field('experts', $post->ID);    
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


                    <!--    //New Flow Invitation
                    <div class="acf-field">
                        <label for="locate">Benoem andere externe experts voor deze cursus:</label><br>
                        <div class="form-group formModifeChoose" >
                            <div class="form-group formModifeChoose">
                                <select name="" id="autocomplete2" class="multipleSelect2" multiple="true">
                                    <option value="">name 1</option>
                                    <option value="">name 2</option>
                                    <option value="">name 3</option>
                                    <option value="">name 4</option>
                                    <option value="">name 5</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="acf-field">
                        <label for="locate">Nodig iemand uit voor je cursus</label><br>
                        <button type="button" class="btn btnInvite"  data-toggle="modal" data-target="#modalAdding">
                            Launch static backdrop modal
                        </button>
                        <div class="GroupPeople d-flex" >
                            <div class="oneExpert">
                                <p class="name">Mouhamed Thioune</p>
                                <p class="email">Mouhamed@livelearn.nl</p>
                            </div>
                            <div class="oneExpert">
                                <p class="name">Mouhamed Thioune</p>
                                <p class="email">Mouhamed@livelearn.nl</p>
                            </div>
                            <div class="oneExpert">
                                <p class="name">Mouhamed Thioune</p>
                                <p class="email">Mouhamed@livelearn.nl</p>
                            </div>
                            <div class="oneExpert">
                                <p class="name">Mouhamed Thioune</p>
                                <p class="email">Mouhamed@livelearn.nl</p>
                            </div>
                        </div>

                    </div> -->

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
                    <a href="/dashboard/teacher/course-selection/?func=add-course<?php if(isset($_GET['id'])) echo '&id=' .$_GET['id'] . '&type=' . $_GET['type']. '&edit'; ?>" class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-info"></i>
                        </div>
                        <p class="textOpleidRight">Basis informatie</p>
                    </a>
                    <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=2&edit'; else echo "#"; ?>" class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <p class="textOpleidRight">Uitgebreide beschrijving</p>
                    </a>
                    <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=3&edit'; else echo "#" ?>" class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                        <p class="textOpleidRight ">Data en locaties</p>
                    </a>
                    <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=4&edit'; else echo "#" ?>" class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-paste" aria-hidden="true"></i>
                        </div>
                        <p class="textOpleidRight">Settings</p>
                    </a>
                    <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=5&edit'; else echo "#" ?>" class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                        </div>
                        <p class="textOpleidRight">Onderwerpen</p>
                    </a>
                    <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=6&edit'; else echo "#" ?>" class="contentBlockCourse">
                        <div class="circleIndicator passEtape2">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        <p class="textOpleidRight">Experts</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="modalAdding" tabindex="-1" aria-labelledby="modalAddingLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add an expert by invitation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Complet Name</label>
                        <input type="text" class="form-control" id="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <button type="submit" class="btn btnInvite">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

    