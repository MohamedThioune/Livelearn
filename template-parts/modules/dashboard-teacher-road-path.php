<?php 

$user_id = get_current_user_id();
$road_paths = get_field('road_path', 'user_' . $user_id);
?>
<div class="contentRoadMap">
   <div class="d-flex justify-content-between headContentRoad">
       <h1 class="roadCourTitle">Road Cours Path</h1>
       <button class="btn btnAddRoadMap" type="button" data-toggle="modal" data-target="#modalRoadMap">Add new course</button>
   </div>

    <!-- Modal Road map -->
    <div class="modal fade" id="modalRoadMap" tabindex="-1" role="dialog" aria-labelledby="modalRoadMapLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">All courses created</h5>
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
                                        <input type="search" class="">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/searchM.png" alt="">
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="checkbox table-checkbox">
                                        <label class="block-label selection-button-checkbox">
                                            <input type="checkbox" name="ck1" value="ck1"> </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="blockCardCoursRoad">
                                        <div class="dropdown btnTroisPoint">
                                            <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/troisPoint.png" alt="">
                                            </button>
                                            <div class="dropdown-menu dropdownRoadMap" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">
                                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/dashicons_edit.png" alt="">
                                                    Edit
                                                </a>
                                                <button type="button" class="btn dropdown-item" href="#">
                                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/dashRemove.png" alt="">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                        <div class="imgCoursRoad">
                                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                                        </div>
                                        <div class="">
                                            <p class="titleCoursRoad">WordPress gevorderden training (virtueel) 1</p>
                                            <div class="sousBlockCategorieRoad ">
                                                <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/grad-search.png" alt="">
                                                <p class="categoryText">Training</p>
                                            </div>
                                            <p class="descriptionTextRoad">In de WordPress specialist training verkrijg je praktisch inzicht in hoe jij zonder enige technische kennis zelf een professionele website kunt opzetten.</p>
                                            <div class="contentImgCardCour">
                                                <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox table-checkbox">
                                        <label class="block-label selection-button-checkbox row-select">
                                            <input type="checkbox" name="ck2" value="ck2"> </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="blockCardCoursRoad">
                                        <div class="dropdown btnTroisPoint">
                                            <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/troisPoint.png" alt="">
                                            </button>
                                            <div class="dropdown-menu dropdownRoadMap" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">
                                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/dashicons_edit.png" alt="">
                                                    Edit
                                                </a>
                                                <button type="button" class="btn dropdown-item" href="#">
                                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/dashRemove.png" alt="">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                        <div class="imgCoursRoad">
                                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                                        </div>
                                        <div class="">
                                            <p class="titleCoursRoad">WordPress gevorderden training (virtueel) 1</p>
                                            <div class="sousBlockCategorieRoad ">
                                                <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/grad-search.png" alt="">
                                                <p class="categoryText">Training</p>
                                            </div>
                                            <p class="descriptionTextRoad">In de WordPress specialist training verkrijg je praktisch inzicht in hoe jij zonder enige technische kennis zelf een professionele website kunt opzetten.</p>
                                            <div class="contentImgCardCour">
                                                <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox table-checkbox">
                                        <label class="block-label selection-button-checkbox row-select">
                                        <input type="checkbox" name="ck3" value="ck3"> </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="blockCardCoursRoad">
                                        <div class="dropdown btnTroisPoint">
                                            <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/troisPoint.png" alt="">
                                            </button>
                                            <div class="dropdown-menu dropdownRoadMap" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">
                                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/dashicons_edit.png" alt="">
                                                    Edit
                                                </a>
                                                <button type="button" class="btn dropdown-item" href="#">
                                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/dashRemove.png" alt="">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                        <div class="imgCoursRoad">
                                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                                        </div>
                                        <div class="">
                                            <p class="titleCoursRoad">WordPress gevorderden training (virtueel) 1</p>
                                            <div class="sousBlockCategorieRoad ">
                                                <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/grad-search.png" alt="">
                                                <p class="categoryText">Training</p>
                                            </div>
                                            <p class="descriptionTextRoad">In de WordPress specialist training verkrijg je praktisch inzicht in hoe jij zonder enige technische kennis zelf een professionele website kunt opzetten.</p>
                                            <div class="contentImgCardCour">
                                                <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox table-checkbox">
                                        <label class="block-label selection-button-checkbox row-select">
                                        <input type="checkbox" name="ck4" value="ck4"> </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="blockCardCoursRoad">
                                        <div class="dropdown btnTroisPoint">
                                            <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/troisPoint.png" alt="">
                                            </button>
                                            <div class="dropdown-menu dropdownRoadMap" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">
                                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/dashicons_edit.png" alt="">
                                                    Edit
                                                </a>
                                                <button type="button" class="btn dropdown-item" href="#">
                                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/dashRemove.png" alt="">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                        <div class="imgCoursRoad">
                                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                                        </div>
                                        <div class="">
                                            <p class="titleCoursRoad">WordPress gevorderden training (virtueel) 1</p>
                                            <div class="sousBlockCategorieRoad ">
                                                <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/grad-search.png" alt="">
                                                <p class="categoryText">Training</p>
                                            </div>
                                            <p class="descriptionTextRoad">In de WordPress specialist training verkrijg je praktisch inzicht in hoe jij zonder enige technische kennis zelf een professionele website kunt opzetten.</p>
                                            <div class="contentImgCardCour">
                                                <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn row-select-submit">Approve selected</button>
                </div>
            </div>
        </div>
    </div>


    <div class="contentItemsRoad">
        <ul id="sortable">
            <?php
            if(!empty($road_paths))
                foreach($road_paths as $course){

                ?>

                <?php
                }
            else
                echo '<li class="ui-state-default" id="1"><div class="blockCardCoursRoad"></div></li>'
            ?>
           <!--  
            <li class="ui-state-default" id="1">
                <div class="blockCardCoursRoad">
                    <img class="roadIcone" src="<?php echo get_stylesheet_directory_uri();?>/img/roadIcone.png" alt="">
                    <div class="dropdown btnTroisPoint">
                        <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/troisPoint.png" alt="">
                        </button>
                        <div class="dropdown-menu dropdownRoadMap" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">
                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/dashicons_edit.png" alt="">
                                Edit
                            </a>
                            <button type="button" class="btn dropdown-item" href="#">
                                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/dashRemove.png" alt="">
                                Remove
                            </button>
                        </div>
                    </div>
                    <div class="imgCoursRoad">
                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                    </div>
                    <div class="">
                        <p class="titleCoursRoad">WordPress gevorderden training (virtueel) 1</p>
                        <div class="sousBlockCategorieRoad ">
                            <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/grad-search.png" alt="">
                            <p class="categoryText">Training</p>
                        </div>
                        <p class="descriptionTextRoad">In de WordPress specialist training verkrijg je praktisch inzicht in hoe jij zonder enige technische kennis zelf een professionele website kunt opzetten.</p>
                        <div class="contentImgCardCour">
                            <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                        </div>
                    </div>
                </div>
            </li> 
            -->
            
        </ul>
    </div>


</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" defer></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" defer></script>
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