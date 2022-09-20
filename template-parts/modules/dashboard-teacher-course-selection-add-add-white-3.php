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

    $choosen_categories = array();
    $choosen_categorie = get_field('categories', $_GET['id']);
    if(!$choosen_categorie)
        $choosen_categorie = get_field('category_xml', $_GET['id']);

    foreach($choosen_categorie as $choosen){
        if(empty($choosen_categories))
            $choosen_categories = explode(',', $choosen['value']);
        else
            array_merge($choosen_categories, explode(',', $choosen['value']));
    }

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
                            <input type="hidden" id="course_id" value="<?= $_GET['id'] ?>">
                            <label for="locate">Specifieke baan :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-bangers"  form="foo_form" class="multipleSelect2 dropdown" multiple="true">
                                    <?php
                                    //Baangerichts
                                    $displayed = array();
                                    foreach($bangerichts as $value){
                                        $state = false;
                                        $childrens = get_term_children($value->cat_ID, 'course_category');
                                        foreach($choosen_categories as $element)
                                            if(in_array($element, $childrens) && !in_array($value->cat_ID, $displayed)){
                                                echo "<option selected value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                                array_push($displayed, $value->cat_ID);
                                                $state = true;
                                            }

                                            if($state)
                                                continue;
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
                                        $state = false;
                                        $childrens = get_term_children($value->cat_ID, 'course_category');
                                        foreach($choosen_categories as $element)
                                            if(in_array($element, $childrens) && !in_array($element, $displayed)){
                                                echo "<option selected value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                                array_push($displayed, $element);
                                                $state = true;
                                            }

                                            if($state)
                                                continue;
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";                                    }
                                    ?>
                                </select>

                            </div>

                            <label for="locate">Skills :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-skills" class="multipleSelect2" multiple="true">
                                    <?php
                                    //Skills
                                    foreach($skills as $value){
                                        $displayed = array(); 
                                        $state = false;
                                        $childrens = get_term_children($value->cat_ID, 'course_category');
                                        foreach($choosen_categories as $element)
                                            if(in_array($element, $childrens) && !in_array($element, $displayed)){
                                                echo "<option selected value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                                array_push($displayed, $element);
                                                $state = true;
                                            }

                                            if($state)
                                                continue;
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";                                    }
                                    ?>
                                </select>

                            </div>

                            <label for="locate">Persoonlikje interesses :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-interess" class="multipleSelect2" multiple="true">
                                    <?php
                                    //Persoonlikje interesses
                                    foreach($interesses as $value){
                                        $state = false;
                                        $childrens = get_term_children($value->cat_ID, 'course_category');
                                        foreach($choosen_categories as $element)
                                            if(in_array($element, $childrens) && !in_array($element, $displayed)){
                                                echo "<option selected value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                                array_push($displayed, $element);
                                                $state = true;
                                            }

                                            if($state)
                                                continue;
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";                                    }
                                    ?>
                                </select>

                            </div>

                            <button type="button" name="step1" id="btn-ajax" class="btn btn-info">Apply</button>
                        </div>
                    </form>

                    <form action='/dashboard/teacher/course-selection/?func=add-add-white&id=<?php echo $_GET['id'] ?>&step=4' method='post'>
                        <div class='acf-field' id="autocomplete_ajax">

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
                            <div class="circleIndicator passEtape2"></div>
                            <p class="textOpleidRight ">Tags</p>
                        </a>
                        <a href="/dashboard/teacher/course-selection/?func=add-add-white&id=<?php echo $_GET['id'];?>&step=4&edit" class="contentBlockCourse">
                            <div class="circleIndicator "></div>
                            <p class="textOpleidRight">Expert</p>
                        </a>
                    </div>
                </div>

            </div>
        
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
            },
            error: (()=>{
                alert ('bonjour')
            })
        });
    })
</script>
