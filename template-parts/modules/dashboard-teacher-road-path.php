<?php 
$user_id = get_current_user_id();

/*
** Leerpaden * 
*/
if(isset($_GET['id']))
    if($_GET['id'])
        $id = $_GET['id'];

$leerpad = get_post($id);

$road_paths = get_field('road_path', $leerpad->ID);
$road_path_s = array(); 

foreach($road_paths as $value)
    array_push($road_path_s, $value->ID);

/*
** Courses - owned * 
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

$title_road_path = get_field('title_road_path', 'user_'.$user_id);

?>
<div class="contentRoadMap">
   <div class="d-flex justify-content-between headRoad">
       <div class="d-flex headContentRoad align-items-center">
           <a href="/dashboard/teacher/list-road-path/" class="backtolistRoadPath">
               <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/bi_arrow-left.png" alt="">
           </a>
           <h1 class="roadCourTitle"><?= $leerpad->post_title ?></h1>
       </div>
       <button class="btn btnAddRoadMap" type="button" data-toggle="modal" data-target="#modalRoadMap">Add</button>

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
                <div id="step1RoadPath">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">step 1 </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST">
                        <input type="hidden" name="leerpad_id" value="<?= $leerpad->ID; ?>">
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

                                            if(in_array($course->ID, $road_path_s))
                                                continue;

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
                            <button type="submit" id="" name="road_course_add" class="btn row-select-submit">Add new</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    if(empty($road_paths))
        echo '<li class="ui-state-default" id="1"><div class="blockCardCoursRoad"><h6>Geen selectie, maak er een 😉</h6></div></li>';

    else{
    ?>
    <div class="contentItemsRoad">
        <form action="" method="POST">
        <ul id="sortable">
            <input type="hidden" name="id" value="<?= $leerpad->ID ?>">
            <?php
                foreach($road_paths as $key=>$course){
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
                <li class="ui-state-default" id="<?= $course->ID; ?>">
                    <input type="hidden" name="road_path[]" value="<?= $course->ID?>">
                    <div class="blockCardCoursRoad">
                        <img class="roadIcone" src="<?php echo get_stylesheet_directory_uri();?>/img/roadIcone.png" alt="">
                        <div class="dropdown btnTroisPoint">
                            <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/troisPoint.png" alt="">
                            </button>
                            <div class="dropdown-menu dropdownRoadMap" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $course->ID;?>&edit">
                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/dashicons_edit.png" alt="">
                                    Edit
                                </a>
                                <button type="button" class="btn dropdown-item remove" href="#">
                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/dashRemove.png" alt="">
                                    Remove
                                </button>
                            </div>
                        </div>
                        <div class="imgCoursRoad">
                            <?php echo '<img class="" src="' . $image . '" alt="">'; ?>
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
                </li> 
                <?php
                }
            ?>
        </ul>
            <button type="submit" name="road_path_edited" id="validatePath" class="btn row-select-submit">Refresh 🔃</button>
        </form>
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
        var id = $(this).parents("li").attr("id");

        if(confirm('Are you sure to remove this record ?'))
        {
            $.ajax({
               url: '/delete-course',
               type: 'POST',
               data: {road_path: id},
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