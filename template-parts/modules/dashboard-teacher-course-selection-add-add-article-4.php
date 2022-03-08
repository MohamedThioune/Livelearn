<?php
     $users = get_users();
     $data_user = wp_get_current_user();
     $user_connected = $data_user->data->ID;
     $company = get_field('company',  'user_' . $user_connected);
     if(!empty($company))
         $company_connected = $company[0]->post_title;
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
                    <a href="/dashboard/teacher/course-selection/?func=add-add-article&id=<?php echo $_GET['id'];?>&step=1" class="contentBlockCourse">
                        <div class="circleIndicator passEtape"></div>
                        <p class="textOpleidRight">Basis informatie</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-add-article&id=<?php echo $_GET['id'];?>&step=2" class="contentBlockCourse">
                        <div class="circleIndicator passEtape"></div>
                        <p class="textOpleidRight">Article Itself</p>
                    </a>
                        
                    <a href="/dashboard/teacher/course-selection/?func=add-add-article&id=<?php echo $_GET['id'];?>&step=3" class="contentBlockCourse">
                        <div class="circleIndicator passEtape"></div>
                        <p class="textOpleidRight">Tags</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-add-article&id=<?php echo $_GET['id'];?>&step=4" class="contentBlockCourse">
                        <div class="circleIndicator passEtape2"></div>
                        <p class="textOpleidRight">Experts</p>
                    </a>
                </div>
            </div>
        </div>
        
    </div>

    <script>
    $("#search_expert").keyup(()=>
    { 
        var search=$("#search_expert").val()
        console.log(search)
        $.ajax({
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


    