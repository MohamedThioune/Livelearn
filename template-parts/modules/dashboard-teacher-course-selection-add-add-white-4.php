<?php
    $users = get_users();

    $members = array();

    $post = get_post($_GET['id']);
    $author = array($post->post_author);
    $expert = get_field('experts', $post->ID);    

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
                                <input type="search" name="search_expert" id="search_expert" class="form-control">
                                <br>

                                <div class="form-group formModifeChoose">

                                    <select name="experts[]" id="autocomplete" class="multipleSelect2" multiple="true">
                                        <?php 
                                            foreach($members as $member) {
                                                if(in_array($member->ID,$experts)){
                                                    echo "<option selected value='" . $member->ID ."'>" . $member->display_name . "</option>";
                                                    continue;
                                                }
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
                    <a href="/dashboard/teacher/course-selection/?func=add-white&id=<?php if(isset($_GET['id'])) echo '&id=' .$_GET['id'] . '&type=' . $_GET['type']. '&edit'; ?>" class="contentBlockCourse">
                        <div class="circleIndicator  passEtape"></div>
                        <p class="textOpleidRight">Basis informatie</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-add-white&id=<?php echo $_GET['id'];?>&step=2&edit" class="contentBlockCourse">
                        <div class="circleIndicator passEtape"></div>
                        <p class="textOpleidRight">Online or location</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-add-white&id=<?php echo $_GET['id'];?>&step=3&edit" class="contentBlockCourse">
                        <div class="circleIndicator passEtape"></div>
                        <p class="textOpleidRight ">Tags</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-add-white&id=<?php echo $_GET['id'];?>&step=4&edit" class="contentBlockCourse">
                        <div class="circleIndicator passEtape2"></div>
                        <p class="textOpleidRight">Expert</p>
                    </a>
                </div>
            </div>
        </div>
        
    </div>
   
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

    <script>
    $("#search_expert").keyup(()=>
    { 
        var search=$("#search_expert").val()
        console.log(search)
        $.ajax(
            {
                    url:"/fetch-expert",
                    method:"post",
                    data:{
                     search_expert:search
                    },
                    dataType:"text",
                    success: function(data){
                        console.log(data);
                        $('#autocomplete').html(data);
                    }
                });
    })
</script>


    