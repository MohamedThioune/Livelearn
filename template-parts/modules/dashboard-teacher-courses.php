<?php

$id = get_current_user_id();

if($id != 0){

    $args = array(
        'post_type' => 'course', 
        'posts_per_page' => -1,
        'author' => $id,  
    );

    $courses = get_posts($args);
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
                        <th scope="col">Actie</th>
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
                    foreach($courses as $key => $course){
                        if(!visibility($course, $visibility_company))
                            continue;

                        /*
                        * Categories
                        */
                        $category = ' ';
                        $location = ' ';
                        $day = "<p><i class='fas fa-calendar-week'></i></p>";
                        $month = ' ';

                        $tree = get_the_terms($course->ID, 'course_category'); 

                        if($tree)
                            if(isset($tree[2]))
                                $category = $tree[2]->name;
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
                    ?>
                    <tr data-attr="<?php echo $course->ID;?>">
                        <td scope="row"><?= $key; ?></td>
                        <td class="textTh">
                            <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $course->ID;?>&edit"><i class="fas fa-edit"></i></a>
                        </td>
                        <td class="textTh">
                            <a href="/dashboard/teacher/signups/?parse=<?php echo $course->ID;?>"><i class="fas fa-globe-africa"></i></a>
                        </td>
                        <td class="textTh elementOnder"><a style="color:#212529;font-weight:bold" href="<?php echo get_permalink($course->ID) ?>"><?php echo $course->post_title; ?></a></td>
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
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="#">Bekijk</a></li>
                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="#">Pas aan</a></li>
                                    <li class="my-1" id="live"><i class="fa fa-trash px-2"></i><input type="button" id="<?= $course->ID; ?>" value="Verwijderen"/></li>
                                </ul>
                            </div>
                        </td>
<!--                         <td><a class="del-course" data-attr="<?php echo $course->ID;?>" href="#"><i class="fas fa-trash-alt" style="color:red;"></i></a></td>
 -->                    </tr>

                    <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>


