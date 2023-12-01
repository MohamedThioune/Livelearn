<?php

$id = get_current_user_id();

if($id != 0){
    $artikel_single = "Artikel";
    $white_type_array =  ['Lezing', 'Event'];
    $course_type_array = ['Opleidingen', 'Workshop', 'Training', 'Masterclass', 'Cursus'];
    $video_single = "Video";
    $leerpad_single  = "Leerpad";
    $assessment_single = "Assessment";
    $podcast_single = "Podcast";
}

$calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

/*
* * Courses dedicated of t
*/

$enrolled = array();
$courses = array();

//Orders - enrolled courses  
$args = array(
    'post_status' => array('wc-processing', 'wc-completed'),
    'orderby' => 'date',
    'order' => 'DESC',
    'limit' => -1,
);
$bunch_orders = wc_get_orders($args);

foreach($bunch_orders as $order){
    foreach ($order->get_items() as $item_id => $item ) {
        //Get woo orders from user
        $course_id = intval($item->get_product_id()) - 1;
        $prijs = get_field('price', $course_id);
        $expenses += $prijs; 
        if(!in_array($course_id, $enrolled))
            array_push($enrolled, $course_id);
    }
}
if(!empty($enrolled))
{
    $args = array(
        'post_type' => array('post', 'course'),
        'posts_per_page' => -1,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'include' => $enrolled,
        'author' => $id
    );
    $courses = get_posts($args);

    // if(!empty($enrolled_courses))
    //     $your_count_courses = count($enrolled_courses);
}

// var_dump($courses);

?>
<div class="contentListeCourse">
    <div class="cardOverviewCours">
        <div class="headListeCourse">
            <p class="JouwOpleid">Mijn leermodules</p>
            <input id="search_txt_company" class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek" aria-label="Zoek" >
            <a href="/dashboard/teacher/course-selection/" class="btnNewCourse">Nieuwe</a>
        </div>
        <div class="contentCardListeCourse">
            <table class="table table-responsive" id="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titel</th>
                        <th scope="col">Prijs</th>
                        <th scope="col">Onderwerp(en)</th>
                        <th scope="col">Startdatum</th>
                        <th scope="col">Optie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; 
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
                        $day = "<i class='fas fa-calendar-week'></i>";
                        $month = ' ';
                        $location = ' ';
                    
                        $data = get_field('data_locaties', $course->ID);
                        if($data){
                            $date = $data[0]['data'][0]['start_date'];
                            $day = explode(' ', $date)[0];
                        }
                        else{
                            $dates = get_field('dates', $course->ID);
                            if($dates)
                                $day = explode(' ', $dates[0]['date'])[0];
                            else{
                                $data = get_field('data_locaties_xml', $course->ID);
                                if(isset($data[0]['value'])){
                                    $data = explode('-', $data[0]['value']);
                                    $date = $data[0];
                                    $day = explode(' ', $date)[0];
                                }
                            }
                        }

                        // if($day == "<i class='fas fa-calendar-week'></i>")
                        //     continue;

                        $course_type = get_field('course_type', $course->ID);
                        $path_edit  = "";
                        if($course_type == $artikel_single)
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-article&id=" . $course->ID ."&edit";
                        else if($course_type == $video_single)
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-video&id=" . $course->ID ."&edit";
                        else if(in_array($course_type,$white_type_array))
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-add-white&id=" . $course->ID ."&edit";
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
                    <tr id="<?php echo $course->ID; ?>" data-attr="<?php echo $course->ID;?>">
                        <td scope="row"><?= $i; ?></td>
                        <td class="textTh elementOnder text-left"><a style="color:#212529;font-weight:bold" href="/dashboard/teacher/signups/?parse=<?= $course->ID; ?>"> <?php echo $course->post_title; ?> </a></td>
                        <td class="textTh"><?php echo $price; ?></td>
                        <td id= "<?php echo $course->ID; ?>" class="textTh onderwerpen"><?php echo $category; ?></td>
                        <td class="textTh"><?php echo $day; ?></td>
                        <td class="textTh">
                            <div class="dropdown text-white">
                                <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                    <img  style="width:20px"
                                          src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                </p>
                                <ul class="dropdown-menu">
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="<?php echo $link; ?>" target="_blank">Bekijk</a></li>
                                    <li class="my-1"><a href="<?php echo $path_edit; ?>"><i class="fa fa-gear px-2"></i> Pas aan</a></li>
                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button" id="" value="Verwijderen"/></li>
                                    <li class="my-1"><a href="/dashboard/teacher/signups/?parse=<?php echo $course->ID;?>"> <i class="fas fa-globe-africa px-2"></i>&nbsp;Inschrijvingen</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <?php
                    $i+=1;
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
    var id_course;
    $('.onderwerpen').click(function(e){
        alert('Please enter');
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
    
    $('#save_subtopics').click(function(){
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
            $('#'+id_course).html(data)
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
