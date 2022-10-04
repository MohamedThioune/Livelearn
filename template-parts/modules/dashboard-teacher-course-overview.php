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
$leerpad_single  = 'Leerpad';

?>
<div class="contentListeCourse">
    <div class="cardOverviewCours">
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

                        /*
                        * Categories
                        */
                        $category = ' ';
                        $day = "<p><i class='fas fa-calendar-week'></i></p>";

                        $tree = get_the_terms($course->ID, 'course_category'); 

                        $category = ' ';

                            $tree = get_the_terms($course->ID, 'course_category'); 

                            if($tree)
                                if(isset($tree[2]))
                                    $category = $tree[2]->name;
                                
                            $category_id = 0;
                        
                            $category_string = " ";
                            
                            if($category == ' '){
                                $category_str = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]); 
                                $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
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
                                $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                                $date = $data[0];
                                $day = explode(' ', $date)[0];
                            }
                        }

                        //Course Type
                        $course_type = get_field('course_type', $course->ID);
                    ?>

                    <tr id="<?php echo $course->ID;?>" >
                        <?php
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

                        $link = ($course_type == "Leerpad") ? '/detail-product-road?id=' . $course->ID : get_permalink($course->ID);
                        ?>
                        <td scope="row"><?= $key; ?></td>
                        <td class="textTh"><?php if(!empty(get_field('visibility',$course->ID))){echo 'nee';}else{echo 'ja';}?></td>
                        <td class="textTh "><a style="color:#212529;font-weight:bold" href="<?= $link ?>"><?php echo $course->post_title; ?></a></td>
                        <td class="textTh"><?php echo $course_type; ?></td>
                        <td class="textTh"><?php echo $price; ?></td>
                        <td class="textTh "><?php echo $category ?></td>
                        <td class="textTh"><?php echo $day; ?></td>
                        <td class="textTh">
                            <div class="dropdown text-white">
                                <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                    <img  style="width:20px"
                                          src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                </p>
                                <ul class="dropdown-menu">
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="#">Bekijk</a></li>
                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="#">Pas aan</a></li>
                                    <li class="my-2"><i class="fas fa-edit px-2"></i><a href="<?= $path_edit ?>">Actie</a></li>
                                    <li class="my-1" id="live"><i class="fa fa-trash px-2"></i><input type="button" id="<?= $course->ID; ?>" value="Verwijderen"/></li>
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="<?= $link ?>">Bekijk</a></li>
                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="<?= $path_edit ?>">Pas aan</a></li>
                                    <li class="my-1 remove" id="live"><i class="fa fa-trash px-2"></i><input type="button" id="<?= $course->ID; ?>" value="Verwijderen"/></li>
                                </ul>
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
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script type="text/javascript">
    $(".remove").click(function(){
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