<?php

$id = get_current_user_id();

if($id != 0){

    $args = array(
        'post_type' => array('course','post','leerpad','assessment'),
        'posts_per_page' => -1,
        'author' => $id,  
    );

    $courses = get_posts($args);
    $artikel_single = "Artikel";
    $white_type_array =  ['Lezing', 'Event'];
    $course_type_array = ['Opleidingen', 'Workshop', 'Training', 'Masterclass', 'Cursus'];
    $video_single = "Video";
    $leerpad_single  = "Leerpad";
    $assessment_single = "Assessment";
    $podcast_single = "Podcast";

}
?>
<div class="contentListeCourse">
    <div class="cardOverviewCours">
        <div class="headListeCourse">
            <p class="JouwOpleid">Mijn leermodules</p>
            <a href="/dashboard/teacher/course-selection/" class="btnNewCourse">Nieuwe</a>
        </div>
        <div class="contentCardListeCourse">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sign-Ups</th>
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
                        if(!visibility($course, $visibility_company))
                            continue;

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
                                $day = explode(' ', $dates[0]['date']);
                            else{
                                $data = get_field('data_locaties_xml', $course->ID);
                                if(isset($data[0]['value'])){
                                    $data = explode('-', $data[0]['value']);
                                    $date = $data[0];
                                    $day = explode(' ', $date)[0];
                                }
                            }
                        }

                        if($day == "<i class='fas fa-calendar-week'></i>")
                            continue;

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

                        $link = "";    
                        if($course_type == "Leerpad")
                            $link = '/detail-product-road?id=' . $course->ID ;
                        else if($course_type == "Assessment")
                            $link = '/detail-assessment?assessment_id=' . $course->ID;
                        else
                            $link = get_permalink($course->ID);
                                            
                    ?>
                    <tr id="<?php echo $course->ID; ?>" data-attr="<?php echo $course->ID;?>">
                        <td scope="row"><?= $i; ?></td>
                        <td class="textTh">
                            <a href="/dashboard/teacher/signups/?parse=<?php echo $course->ID;?>"><i class="fas fa-globe-africa"></i></a>
                        </td>
                        <td class="textTh elementOnder"><a style="color:#212529;font-weight:bold" href="<?php echo $link ?>"><?php echo $course->post_title; ?></a></td>
                        <td class="textTh"><?php echo $price; ?></td>
                        <td class="textTh "><?php echo $category; ?></td>
                        <td class="textTh"><?php echo $day; ?></td>
                        <td class="textTh">
                            <div class="dropdown text-white">
                                <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                    <img  style="width:20px"
                                          src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                </p>
                                <ul class="dropdown-menu">
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="<?php echo $link; ?>" target="_blank">Bekijk</a></li>
                                    <li class="my-2"><a href="<?php echo $path_edit; ?>"><i class="fa fa-gear px-2"></i> Pas aan</a></li>
                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button" id="" value="Verwijderen"/></li>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

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
