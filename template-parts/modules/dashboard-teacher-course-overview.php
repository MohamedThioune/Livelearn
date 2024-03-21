<?php

$id = get_current_user_id();

if($id){
    $args = array(
        'post_type' => array('post', 'course', 'learnpath'),
        'posts_per_page' => -1,
        'author' => $id,  
    );

    $courses = get_posts($args);
}

$artikel_single = "Artikel";
$white_type_array =  ['Lezing', 'Event'];
$course_type_array = ['Opleidingen', 'Workshop', 'Training', 'Masterclass', 'Cursus'];
$video_single = "Video";
$leerpad_single  = "Leerpad";
$assessment_single = "Assessment";
$podcast_single = "Podcast";

?>
<div class="contentListeCourse">
    <div class="cardOverviewCours">
        <!-- The Modal -->
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <!-- <div id="modal-content"> -->
            <div class="modal-content modal-content-width m-auto " style="margin-top: 100px !important">
                <div class="modal-header mx-4">
                    <h5 class="modal-title" id="exampleModalLabel">Subtopics </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('myModal').style.display='none'" >
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="row d-flex text-center justify-content-center align-items-center h-50">
                    <div class="col-md-11  p-4">
                        <div class="form-group display-subtopics">
                        
                        </div> 
                        <div id="modal-content">

                        </div>
                        <div class="d-flex justify-content-end">
                            <button id="save_subtopics" type="button" class="btn text-white" style="background: #023356;">
                                <strong>Save</strong> 
                            </button>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
            </div>
        </div>
        
        <div class="headListeCourse">
            <?php if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span>"?>
            <p class="JouwOpleid">Overzicht leermodules</p>
            <input type="search" id="" placeholder="zoeken" class="inputSearchCourse">
            <a href="/dashboard/teacher/course-selection/" class="btnNewCourse">Nieuwe</a>
        </div>
        <div class="contentCardListeCourse table-responsive overflowOverviewTable">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Verkoop</th>
                        <th scope="col">Titel</th>
                        <th scope="col">Type</th>
                        <th scope="col">Prijs</th>
                        <th scope="col">Onderwerp(en)</th>
                        <th scope="col">Startdatum</th>
                        <th scope="col">Optie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($courses as $key => $course){
                        // if(!visibility($course, $visibility_company))
                        //     continue;  
                        
                        /*
                        * Categories
                        */
                        $category = ' ';
                        $category_id = 0;
                        $category_str = 0;
                        if($category == ' '){
                            $one_category = get_field('categories',  $course->ID);
                            if(isset($one_category[0]))
                                $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                            else{
                                $one_category = get_field('category_xml',  $course->ID);
                                if(isset($one_category[0]))
                                    $category_id = intval($one_category[0]['value']);
                            }

                            if($category_str != 0)
                                $category = (String)get_the_category_by_ID($category_str);
                            else if($category_id != 0)
                                $category = (String)get_the_category_by_ID($category_id);
                        }

                        /*
                        * Price 
                        */
                        $p = get_field('price', $course->ID);
                        if($p != "0")
                            $price = number_format($p, 2, '.', ',');
                        else 
                            $price = 'Gratis';

                        /*
                        *  Date and Location
                        */ 
                        $day = "No date";
                        $month = ' ';
                        $location = ' ';
                        $data = get_field('data_locaties', $course->ID);
                        if($data){
                            $date = $data[0]['data'][0]['start_date'];
                            $day = explode(' ', $date)[0];
                            $day = '<strong>' . $day . '</strong>';
                        }
                        else{
                            $dates = get_field('dates', $course->ID);
                            if($dates){
                                $day = explode(' ', $dates[0]['date'])[0];
                                $day = '<strong>' . $day . '</strong>';
                            }else{
                                if(isset($data[0]['value'])){
                                    $data = explode('-', $data[0]['value']);
                                    $date = $data[0];
                                    $day = explode(' ', $date)[0];
                                    $day = '<strong>' . $day . '</strong>';
                                } else {
                                    // get the date from database
                                    $timestamp = strtotime($course->post_date);
                                    $date_formatee = date('d/m/Y', $timestamp);
                                    $day = '<strong>' . $date_formatee . '</strong>';
                                }
                            }
                        }

                        //Course Type
                        $course_type = get_field('course_type', $course->ID);
                    ?>

                    <tr class="pagination-element-block" id="<?php echo $course->ID;?>" >
                        <?php
                        $path_edit  = "";
                        if($course_type == $artikel_single)
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-article&id=" . $course->ID ."&edit";
                        else if($course_type == $video_single)
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-video&id=" . $course->ID ."&edit";
                        else if(in_array($course_type,$white_type_array))
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-white&id=" . $course->ID ."&edit";
                        else if(in_array($course_type,$course_type_array))
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-course&id=" . $course->ID ."&edit";
                        else if($course_type == $leerpad_single)
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-road&id=" . $course->ID ."&edit";
                        else if($course_type == $assessment_single)
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-assessment&id=" . $course->ID ."&edit";
                        else if($course_type == $podcast_single)
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-podcast&id=" . $course->ID ."&edit";
                        
                        $link = get_permalink($course->ID);                        
                        ?>
                        <td scope="row"><?= $key; ?></td>
                        <td class="textTh"><?php if(!empty(get_field('visibility',$course->ID))){echo 'nee';}else{echo 'ja';}?></td>
                        <td class="textTh "><a style="color:#212529;font-weight:bold" href="<?= $link ?>"><?php echo $course->post_title; ?></a></td>
                        <td class="textTh"><?php echo $course_type; ?></td>
                        <td class="textTh"><?php echo $price; ?></td>
                        <td id= "<?php echo $course->ID; ?>" class="textTh onderwerpen row<?php echo $course->ID; ?>"><?php echo $category ?></td>
                        <td class="textTh"><?php echo $day; ?></td>
                        <td class="textTh">
                            <div class="dropdown text-white">
                                <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                    <img  style="width:20px"
                                          src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                </p>
                                <ul class="dropdown-menu">
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="<?= $link ?>">Bekijk</a></li>
                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="<?= $path_edit ?>">Pas aan</a></li>
                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button" id="<?= $course->ID; ?>" value="Verwijderen"/></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="pagination-container">
                <!-- Les boutons de pagination seront ajoutés ici -->
            </div>

        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        const itemsPerPage = 20;
        const $rows = $('.pagination-element-block');
        const pageCount = Math.ceil($rows.length / itemsPerPage);
        let currentPage = 1;

        function showPage(page) {
            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;

            $rows.each(function(index, row) {
                if (index >= startIndex && index < endIndex) {
                    $(row).css('display', 'table-row');
                } else {
                    $(row).css('display', 'none');
                }
            });
        }

        function createPaginationButtons() {
            const $paginationContainer = $('.pagination-container');

            if (pageCount <= 1) {
                $paginationContainer.css('display', 'none');
                return;
            }

            const $prevButton = $('<button>&lt;</button>').on('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                    updatePaginationButtons();
                }
            });

            const $nextButton = $('<button>&gt;</button>').on('click', function() {
                if (currentPage < pageCount) {
                    currentPage++;
                    showPage(currentPage);
                    updatePaginationButtons();
                }
            });

            $paginationContainer.append($prevButton);

            for (let i = 1; i <= pageCount; i++) {
                const $button = $('<button></button>').text(i);
                $button.on('click', function() {
                    currentPage = i;
                    showPage(currentPage);
                    updatePaginationButtons();
                });

                if (i === 1 || i === pageCount || (i >= currentPage - 2 && i <= currentPage + 2)) {
                    $paginationContainer.append($button);
                } else if (i === currentPage - 3 || i === currentPage + 3) {
                    $paginationContainer.append($('<span>...</span>'));
                }
            }

            $paginationContainer.append($nextButton);
        }

        function updatePaginationButtons() {
            $('.pagination-container button').removeClass('active');
            $('.pagination-container button').filter(function() {
                return parseInt($(this).text()) === currentPage;
            }).addClass('active');
        }

        showPage(currentPage);
        createPaginationButtons();
    });
</script>


<script>
    var id_course;
    $('.onderwerpen').click((e)=>{
        id_course = e.target.id;

        $.ajax({

            url:"/fetch-subtopics-course",
            method:"post",
            data:
            {
                id_course:id_course,
                action:'get_course_subtopics'
            },
            dataType:"text",
            success: function(data){
                // Get the modal
                //console.log(data)
                var modal = document.getElementById("myModal");
                $('.display-subtopics').html(data)
                // Get the button that opens the modal


                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks on the button, open the modal

                    modal.style.display = "block";

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                    modal.style.display = "none";
                    }
                }
            }
            });

        });
    
    $('#save_subtopics').click(()=>{
      var subtopics = $('#selected_subtopics').val();

      $.ajax({
        url:"/fetch-subtopics-course",
        method:"post",
        data:
            {
            add_subtopics:subtopics,
            id_course:id_course,
            action:'add_subtopics'
            },
        dataType:"text",
        success: function(data){
            
            let modal=$('#myModal');
            modal.attr('style', { display: "none" });
            //modal.style.display = "none";
            $('.row' + id_course).html(data)
            //console.log(data)
        }
        });

    });
</script>

<script type="text/javascript">
    $(".remove_opleidingen").click(function(){
        var id = $(this).parents("tr").attr("id");

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