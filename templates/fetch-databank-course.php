<?php /** Template Name: Fetch databank course */ ?>

<?php

extract($_POST);

//$page = 'check_visibility.php';
//require($page);

$args = array(
        'post_type' => array('course','post','leerpad','assessment'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',                          
        );

$courses = get_posts($args);

$row_company_course = "";
$artikel_single = "Artikel"; 
$white_type_array =  ['Lezing', 'Event'];
$course_type_array = ['Opleidingen', 'Workshop', 'Training', 'Masterclass', 'Cursus'];
$video_single = "Video";
$leerpad_single  = 'Leerpad';
$podcast_single = 'Podcast';
if(isset($search_txt_course)){
    foreach($courses as $key => $course){
        $filter = $course->post_title;
        // if(!visibility($course, $visibility_company))
        //     continue;
        $category = ' ';
        /*
        * Categories
        */
        $category = ' ';
        $category_id = 0;
        $category_str = 0;
        if($category == ' '){
            $one_category = get_field('categories',  $course->ID);
            if(isset($one_category[0]['value']))
                $category_str = intval(explode(',', $one_category[0]['value'])[0]);
            else{
                $one_category = get_field('category_xml',  $course->ID);
                if(isset($one_category[0]['value']))
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

        $tags = get_field('categories', $course->ID);

        $keywords = array();

        $words = "";

        if(empty($tags)){
            $tags = array();
            $title = $course->post_title;
            if($title)
                $words .= $title;
            $description = get_field('short_description', $course->ID);
            if($description)
                $words .= $description;
            $descriptionHtml = get_field('long_description', $course->ID);
            if($descriptionHtml)
                $words .= $descriptionHtml;

            $keywords = explode(' ', $words);

            $occurrence = array_count_values(array_map('strtolower', $keywords));
            arsort($occurrence);

            foreach($categorys as $value)
                if($occurrence[strtolower($value->cat_name)] >= 1){
                    echo strtolower($value->cat_name);
                    array_push($tags, $value->cat_ID);
                }
            update_field('categories', $tags, $course->ID);
        }

        // Course type
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
        else if($course_type == 'Assessment')
            $path_edit = "/dashboard/teacher/course-selection/?func=add-assessment&id=" . $course->ID ."&edit";
        else if($course_type == 'Podcast')
            $path_edit = "/dashboard/teacher/course-selection/?func=add-podcast&id=" . $course->ID ."&edit";

        $link = "";    
        if($course_type == "Leerpad")
            $link = '/detail-product-road?id=' . $course->ID ;
        else if($course_type == "Assessment")
            $link = '/detail-assessment?assessment_id=' . $course->ID;
        else
            $link = get_permalink($course->ID);


        if( stristr($filter, $search_txt_course) || $search_txt_course == ''){

            $course_subtopics = get_field('categories', $course->ID);
            $field = '';
            if($course_subtopics != NULL){
                if (!empty($course_subtopics)){
                    foreach($course_subtopics as $key => $course_subtopic) 
                        if ($course_subtopic != "")
                            $field .= (String)get_the_category_by_ID($course_subtopic['value']).',';
                }
                $field = substr($field,0,-1);
            }

            $row_company_course .= ' <tr>
                <td scope="row"><?= $key; ?></td>
                <td class="textTh "><a style="color:#212529;font-weight:bold" href="' . get_permalink($course->ID) . '">' . $course->post_title . '</a></td>
                <td class="textTh">' . $price . '</td>
                <td class="textTh ">'
                . $field .
               '</td>
                <td class="textTh">' . $day . '</td>
                <td class="textTh">Live</td>
                <td class="textTh">
                    <div class="dropdown text-white">
                        <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                            <img style="width:20px"
                                src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                        </p>
                        <ul class="dropdown-menu">
                            <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="' . $link .'" target="_blank">Bekijk</a></li>
                            <li class="my-2"><i class="fa fa-gear px-2"></i><a href="' . $path_edit. '" target="_blank">Pas aan</a></li>
                            <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2 "></i><input type="button" id="" value="Verwijderen"/></li>
                        </ul>
                    </div>
                </td>
            </tr>';
        }
    }

    echo $row_company_course;
}
