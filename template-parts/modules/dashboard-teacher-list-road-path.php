<?php
$user_id = get_current_user_id();

/*
** Leerpaden  owned *
*/

$args = array(
    'post_type' => 'learnpath',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'author' => $user_id,
);

$road_paths = get_posts($args);

/*
** Courses  owned *
*/

$courses = array();

$args = array(
    'post_type' => 'course',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',
);

$global_courses = get_posts($args);

foreach($global_courses as $course)
{
    $experts = get_field('experts', $course->ID);
    if($course->post_author == $user_id || in_array($user_id, $experts) ){
        array_push($courses, $course);
    }

}

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


//


?>
<div class="contentRoadMap">
   <div class="d-flex justify-content-between headContentRoad">
       <h1 class="roadCourTitle">Road Cours Path</h1>
       <button class="btn btnAddRoadMap" type="button" data-toggle="modal" data-target="#modalRoadMap">Add new road path</button>
   </div>
   <?php
        if(isset($_GET['message']))
            if($_GET['message'])
                echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>";
    ?>
    <!-- Modal Road map -->
    <div class="modal fade" id="modalRoadMap" tabindex="-1" role="dialog" aria-labelledby="modalRoadMapLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST">
                    <div id="step1RoadPath">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">1<sup>er</sup> Etape</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <div class="">
                                <div class="row">
                                    <table class="table row-select">
                                        <thead>
                                            <tr class="head">
                                                <th class="">
                                                    <div class="checkbox table-checkbox ">
                                                        <label class="block-label d-flex align-items-center selection-button-checkbox">
                                                            <input type="checkbox" name="all" class="mr-2" value="all" id="toggleAll" tabindex="0"></label>
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="searchCoursMap ">
                                                        <input id="search_path" type="search" autocomplete="off">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/searchM.png" alt="">
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="autocomplete">
                                            <?php
                                            foreach($courses as $key=>$course){
                                                if($key == 5){
                                                    echo '<tr> <td> <center> <div class="checkbox table-checkbox"><label class="block-label selection-button-checkbox">- - PLUS - -</label></div> </center></td> </tr>';
                                                    break;
                                                }

                                                $type_course = get_field('course_type', $course->ID);
                                                $short_description = get_field('short_description', $course->ID);

                                                /*
                                                * Experts
                                                */
                                                $expert = get_field('experts', $course->ID);
                                                $author = array($course->post_author);
                                                $experts = array_merge($expert, $author);

                                                /*
                                                * Thumbnails
                                                */
                                                $image = get_field('preview', $course->ID)['url'];
                                                if(!$image){
                                                    $image = get_field('url_image_xml', $course->ID);
                                                    if(!$image)
                                                        $image = "https://cdn.pixabay.com/photo/2021/09/18/12/40/pier-6635035_960_720.jpg";
                                                }
                                                ?>
                                                <tr id="<?php echo $course->ID;?>" >
                                                    <td>
                                                        <div class="checkbox table-checkbox">
                                                            <label class="block-label selection-button-checkbox">
                                                                <input type="checkbox" name="road_path[]" value="<?= $course->ID; ?>"> </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="blockCardCoursRoad">
                                                            <div class="imgCoursRoad">
                                                                <img class="" src="<?= $image; ?>" alt="">
                                                            </div>
                                                            <div class="">
                                                                <p class="titleCoursRoad"><?= $course->post_title; ?></p>
                                                                <div class="sousBlockCategorieRoad ">
                                                                    <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/grad-search.png" alt="">
                                                                    <p class="categoryText"><?= $type_course; ?></p>
                                                                </div>
                                                                <p class="descriptionTextRoad"><?= $short_description; ?></p>
                                                                <div class="contentImgCardCour">
                                                                    <?php
                                                                    foreach($experts as $expert){
                                                                        $image_author = get_field('profile_img',  'user_' . $expert);
                                                                        if(!$image_author)
                                                                            $image_author = get_stylesheet_directory_uri() ."/img/placeholder_user.png";
                                                                        echo '<img class="euroImg" src="' . $image_author . '" alt="">';
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="bntContinueRoad" class="btn row-select-submit">Continue</button>
                            </div>
                    </div>
                    <div id="step2RoadPath">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">2<sup>nd</sup> Etape</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="acf-field">

                            <label for="locate">Baangerichte :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-bangers" class="multipleSelect2 dropdown" name="topics[]" >
                                    <option value=""> Maak en keuze</option>
                                    <?php
                                    //Baangerichts
                                    foreach($bangerichts as $value){
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <label for="locate">Functiegerichte :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-functs" class="multipleSelect2" name="topics[]">
                                    <option value=""> Maak en keuze</option>

                                    <?php
                                    //Functies
                                    foreach($functies as $value){
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <label for="locate">Skill :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-skills" class="multipleSelect2" name="topics[]">
                                    <option value=""> Maak en keuze</option>

                                    <?php
                                    //Skills
                                    foreach($skills as $value){
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <label for="locate">Persoonlijke :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-interess" class="multipleSelect2" name="topics[]">
                                    <option value=""> Maak en keuze</option>

                                    <?php
                                    //Persoonlikje interesses
                                    foreach($interesses as $value){
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <div class="form-group">
                                <label> Title learning path : </label>
                                <input class="form-control" type="text" name="title_road_path" id="" value="" placeholder="Fill the correct title" required>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" name="road_path_created" class="btn row-select-submit">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <?php
    if(empty($road_paths))
        echo '<li class="ui-state-default" id="1"><div class="blockCardCoursRoad"><h6>Geen selectie, maak er een 😉</h6></div></li>';

    else{
    ?>
    <div class="row">
        <?php 
        foreach($road_paths as $road){ 
        $topic_road_path = get_field('topic_road_path', $road->ID);
        $name_topic =  ($topic_road_path != 0) ? (String)get_the_category_by_ID($topic_road_path) : '';

        ?>
        <section class="col-lg-4" id="<?=  $road->ID; ?>">
            <div class="cardRoadPath">
                <div class="headRoadPath">
                    <p class="titleRoadPath "><?= $road->post_title; ?></p>
                </div>
                <div class="categoriesRoadPath">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/op-seach.png" alt="">
                    <p class=""><?= $name_topic; ?></p>
                </div>
                <div class="footer-road-path">
                    <button type="" class="btn btnRemoveRoadPath remove">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/dashRemove.png" alt="">
                        <span>Remove</span>
                    </button>
                    <a href="/dashboard/teacher/road-path/?id=<?= $road->ID ?>" class="seeRoadPath">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/oeil.png" alt="">
                        <span>see</span>
                    </a>
                </div>
            </div>
        </section>
        <?php } ?>
    </div>
    <?php
    }
    ?>


</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" ></script>
<script>
     $('#search_path').keyup(function(){
        var txt = $(this).val();
        event.stopPropagation();

        if(txt){
            $.ajax({

                url:"/fetch-ajax",
                method:"post",
                data:{
                    search_path:txt,
                },
                dataType:"text",
                success: function(data){
                    console.log(data);
                    $('#autocomplete').html(data);
                }
            });
        }
        else
            $('#autocomplete').html("<center> <small>Typing ... </small> <center>");
    });
</script>
<script>
    $(".remove").click(function(){
        var id = $(this).parents("section").attr("id");

        if(confirm('Are you sure to remove this record ?'))
        {
            $.ajax({
               url: '/delete-course',
               type: 'GET',
               data: {id: id},
               error: function() {
                  alert('Something is wrong');
               },
               success: function(data) {
                    $("#"+id).remove();
                    alert("Record removed successfully");
               }
            });
        }
    });

</script>

<script>
    $(document).ready(function (e) {
        $("#sortable").sortable();
        $("#sortable").disableSelection();

        $("#btn").on("click", function () {
            var x = "";
            $("#sortable li").each(function (index, element) {
                x = x + $(this).text() + " , ";
            });
            $(".show").text(x);
        });
    });

</script>

<script>
    $(function () {
        $("body").addClass("js-enabled");
        $("thead input[type=checkbox]").focus(function () {
            $(this).closest(".block-label").addClass("focused");
        })
        $("thead input[type=checkbox]").focusout(function () {
            $(this).closest(".block-label").removeClass("focused");
        })
        $("input[type=checkbox]").focus(function () {
            $(this).closest("tr").addClass("focused");
        })
        $("input[type=checkbox]").blur(function () {
            $(this).closest("tr").removeClass("focused");
        })
        /* Checkbox, set classes to apply styles */
        $("input[type=checkbox]").click(function () {
            if ($(this).closest("tr").hasClass("head")) return;
            if ($(this).is(":checked")) {
                $(this).closest("tr").addClass("row-selected");
                $(this).closest(".selection-button-checkbox").addClass('selected');
            }
            else {
                $(this).closest("tr").removeClass("row-selected");
                $(this).closest(".selection-button-checkbox").removeClass('selected');
            }
        });
        $("#toggleAll").click(function () {
            if ($(this).hasClass("all-selected")) {
                $(this).removeClass("all-selected");
                $("input[type=checkbox]").each(function () {
                    $(this).closest(".selection-button-checkbox").removeClass('selected');
                    $(this).closest("tr").removeClass("row-selected");
                    $(this).attr("checked", false);
                })
            }
            else {
                $(this).addClass("all-selected");
                $("input[type=checkbox]").each(function () {
                    $(this).closest(".selection-button-checkbox").addClass('selected');
                    if ($(this).attr("id") != "toggleAll") $(this).closest("tr").addClass("row-selected");
                    $(this).attr("checked", true);
                })
            }
        })
        $(".row-select tbody tr").click(function (e) {
            selectRowChange($(this));
        })
        $("input[type=checkbox]").keyup(function (e) {
            if (e.which == 13) boxPressed($(this));
        })

        function selectRowChange(row) {
            if (row.find("select").is(":focus")) return;
            if (row.hasClass("row-selected")) {
                row.removeClass("row-selected");
                row.find("input[type=checkbox]").first().attr("checked", false);
                row.find(".selection-button-checkbox").first().removeClass("selected");
            }
            else {
                row.addClass("row-selected");
                row.find("input[type=checkbox]").first().attr("checked", true);
                row.find(".selection-button-checkbox").first().addClass("selected");
            }
        }

        function boxPressed(cbox) {
            if (cbox.closest("select").is(":focus")) return;
            if (cbox.closest("tr").hasClass("row-selected")) {
                cbox.closest("tr").removeClass("row-selected");
                cbox.attr("checked", false);
                cbox.closest("label").removeClass("selected");
            }
            else {
                cbox.closest("tr").addClass("row-selected");
                cbox.attr("checked", true);
                cbox.closest("label").addClass("selected");
            }
        }
    })
</script>