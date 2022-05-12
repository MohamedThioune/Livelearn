<?php


    /*
    ** Categories - all  * 
    */

    $categories = array();

    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    foreach($cats as $category){
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($categories, $category);
    }

    //Categories
    $bangerichts = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[1],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $functies = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[0],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $skills = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[3],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $interesses = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[2],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

?>


    <div class="row">
        <div class="col-md-5 col-lg-8">
            <div class="cardCoursGlocal">
                <div id="basis" class="w-100">
                <?php 
                    if(!isset($step2)){     
                ?>
                    <div class="titleOpleidingstype">
                        <h2>TAGS</h2>
                    </div>
                    <?php
                }
                    ?>
                    <form id="step1">
                        <div class="acf-field">
                            <label for="locate">Specifieke baan :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-bangers"  form="foo_form" class="multipleSelect2 dropdown" multiple="true">
                                    <?php
                                    //Baangerichts
                                    foreach($bangerichts as $value){
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <label for="locate">Functies :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-functs" class="multipleSelect2" multiple="true">
                                    <?php
                                    //Functies
                                    foreach($functies as $value){
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <label for="locate">Skills :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-skills" class="multipleSelect2" multiple="true">
                                    <?php
                                    //Skills
                                    foreach($skills as $value){
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <label for="locate">Persoonlikje interesses :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-interess" class="multipleSelect2" multiple="true">
                                    <?php
                                    //Persoonlikje interesses
                                    foreach($interesses as $value){
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <button type="button" name="step1" id="btn-ajax" class="btn btn-info">Apply</button>
                        </div>
                    </form>

                    <form action='/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'] ?>&step=6' method='post'>
                        <div class='acf-field' id="autocomplete_ajax">
                        </div>
                    </form>
                   
                </div>
            </div>
        </div>

        <?php 
            if(!isset($step2)){     
        ?>
            <div class="col-md-3 col-lg-4 col-sm-12">
                <div class="blockCourseToevoegen">
                    <p class="courseToevoegenText">Course toevoegen</p>
                    <div class="contentBlockRight">
                        <a href="/dashboard/teacher/course-selection/" class="contentBlockCourse">
                            <div class="circleIndicator passEtape"></div>
                            <p class="textOpleidRight">Opleidingstype</p>
                        </a>
                        <a href="/dashboard/teacher/course-selection/?func=add-course" class="contentBlockCourse">
                            <div class="circleIndicator  passEtape"></div>
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
        <?php 
            }     
        ?>
    </div>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

<script>
    $("#btn-ajax").click((e)=>
    {
        $(e.preventDefault())
        var bangers =$("#form-control-bangers").val();
        var functs =$("#form-control-functs").val();
        var skills =$("#form-control-skills").val();
        var interess =$("#form-control-interess").val();

        $.ajax({

            url:"/topic-ajax",
            method:"post",
            data:{
                bangers:bangers,
                functs:functs,
                skills:skills,
                interess:interess
            },
            dataType:"text",
            success: function(data){
                console.log(data);
                $('#autocomplete_ajax').html(data);
            }
        });
    })
</script>
