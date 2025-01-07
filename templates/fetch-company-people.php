<?php /** Template Name: Fetch company people */ ?>

<?php

extract($_POST);
require_once 'check_visibility.php';

$users = get_users();
$data_user = wp_get_current_user();
$user_connected = $data_user->data->ID;
$company = get_field('company',  'user_' . $user_connected);

//Departments 
$departments = get_field('departments', $company[0]->ID);

if(!empty($company))
    $company_connected = $company[0]->post_title;

$grant = get_field('manager',  'user_' . $user_connected);
$ismanaged = get_field('managed',  'user_' . $user_connected); 

$members = array();
foreach($users as $user)
    if($user_connected != $user->ID ){
        $company = get_field('company',  'user_' . $user->ID);
        if(!empty($company)){
            $company = $company[0]->post_title;
            if($company == $company_connected)
                array_push($members, $user);
        }
    }

$count = count($members);


$row_company_people = " ";

if(isset($search_user_company)){
    foreach($members as $key => $user){
        $filter = $user->first_name . ' ' . $user->last_name . ' ' . $user->display_name;
        $managed = in_array($user->ID, $ismanaged) ? 'You' : '';
        $image_user = get_field('profile_img',  'user_' . $user->ID); 
        if(!$image_user)  
            $image_user = get_stylesheet_directory_uri(). "/img/placeholder_user.png";

        $you = NULL;
        if(!in_array('administrator', $user->roles))
            $you = (in_array($user->ID, $ismanaged) || in_array('administrator', $data_user->roles) || in_array('hr', $data_user->roles) ) ?  'You' : NULL;

        $display_name = (isset($user->first_name)) ? $user->first_name : $user->display_name;

        $manager = get_field('ismanaged', 'user_' . $user->ID);
        $manager_image = get_field('profile_img',  'user_' . $manager); 

        $manager_image_pattern = "";
        if($manager_image)
            $manager_image_pattern = '<div class="ImgUser">
                                        <img src="' . $manager_image . '" alt="">
                                    </div>';
        
        $edit_pattern = "";
        if($you)
            $edit_pattern = '<li class="my-1"> <i class="fa fa-pencil px-2"></i> <a data-toggle="modal" data-target="#modalEdit' . $key . '" href="#">Edit</a> </li>';
        
        $delete_pattern = ""; 
        if(in_array('administrator', $data_user->roles))
            if(!in_array('administrator', $user->roles) && !in_array('hr', $user->roles))
                $delete_pattern = '<li class="my-1">
                                        <div class="remove">
                                            <img class="removeImg" src="' . get_stylesheet_directory_uri() . '/img/deleteIcone.png" alt="">
                                            <span>Verwijderen</span>
                                        </div>
                                    </li>';
                            
        if( stristr($filter, $search_user_company) || $search_user_company == '')
            $row_company_people .= '
            <tr id="' . $user->ID .'" >
                <td scope="row">' . $key . '</td>
                <td class="textTh thModife">
                    <div class="ImgUser">
                    <a href="' . $link . '" > <img src="' . $image_user  . '" alt=""> </a>
                    </div>
                </td>
                <td class="textTh"> <a href="' . $link . '" style="text-decoration:none;">' . $display_name . '</a> </td>
                <td class="textTh">' . $user->user_email . '</td>
                <td class="textTh">' . get_field('telnr', 'user_'.$user->ID) . '</td>
                <td class="textTh elementOnder">' . get_field('role', 'user_'.$user->ID) . '</td>
                <td class="textTh">' . get_field('department', 'user_'.$user->ID) . '</td>
                <td class="textTh thModife">
                ' . $manager_image_pattern . '
                </td>
                <td class="textTh">
                    <div class="dropdown text-white">
                        <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                            <img  style="width:20px"
                                src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                        </p>
                        <ul class="dropdown-menu">
                            <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="<?= $link; ?>" target="_blank">Bekijk</a></li>
                            ' . $edit_pattern . '
                            ' . $delete_pattern . '
                        </ul>
                    </div>
                </td>
            </tr>
            ';
    }
    echo $row_company_people;
}elseif (isset($search_company_learn_module)){
    $user_connected = get_current_user_id();
    $company_connected = get_field('company',  'user_' . $user_connected);
    $users_companie = array();
    if(isset($_POST['id_course']))
        $course = get_field('categories', $_POST['id_course']);

    $users = get_users();

    foreach($users as $user) {
        $company_user = get_field('company',  'user_' . $user->ID);
        if(!empty($company_connected) && !empty($company_user))
            if($company_user[0]->post_title == $company_connected[0]->post_title)
                array_push($users_companie,$user->ID);
    }
    $args = array(
        'post_type' => array('course','post','leerpad','assessment'),
        'posts_per_page' => 1000,
        's'=> $search_company_learn_module,
        'author__in' => $users_companie,
    );
    $courses = get_posts($args);
    $row_company_people = "";
    foreach($courses as $key => $course){
        if(!visibility($course, $visibility_company))
            continue;

        //Categories
        $category = " ";
        $id_category = 0;
        $category_id = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]);
        $category_xml = intval(get_field('category_xml', $course->ID)[0]['value']);
        if($category_xml)
            if($category_xml != 0)
                $category = (String)get_the_category_by_ID($category_xml);

        if($category_id)
            if($category_id != 0)
                $category = (String)get_the_category_by_ID($category_id);



        /*
        *  Date and Location
        */
        $day = "<p class='text-no-date'>no date given</p>";
        $month = ' ';
        $location = ' ';

        $data = get_field('data_locaties', $course->ID);
        if($data){
            $date = $data[0]['data'][0]['start_date'];
            $day = explode(' ', $date)[0];
        }
        else{
            $dates = get_field('dates', $course->ID);
            if($dates){
                $post_date = explode(' ', $dates[0]['date'])[0];
                $date_immu = new DateTimeImmutable($post_date);
                $day = $date_immu->format('d/m/Y');
            }
            else{
                $data = get_field('data_locaties_xml', $course->ID);
                if(isset($data[0]['value'])){
                    $data = explode('-', $data[0]['value']);
                    $date = $data[0];
                    $day = explode(' ', $date)[0];
                }
            }
        }

        /*
        * Price
        */
        $p = get_field('price', $course->ID);
        if($p != "0")
            $price =  number_format($p, 2, '.', ',');
        else
            $price = 'Gratis';

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

        $link = get_permalink($course->ID);

        if(!$course_type)
            $course_type = 'Artikel';
        ?>
        <tr class="pagination-element-block" id="<?php echo $course->ID; ?>">
            <td scope="row"><?= $key; ?></td>
            <td class="textTh"><?php if(!empty(get_field('visibility',$course->ID))) echo 'nee'; else echo 'ja'; ?></td>
            <td class="textTh text-left"><a style="color:#212529;" href="<?php echo $link; ?>"><?php echo $course->post_title; ?></a></td>
            <td class="textTh"><?php echo $course_type; ?></td>
            <td class="textTh"><?php echo $price; ?></td>
            <td id= "<?php echo $course->ID; ?>" class="textTh td_subtopics row<?php echo $course->ID; ?>">
                <?= $category ?>
                <?php
                $course_subtopics = get_field('categories', $course->ID);
                $field = '';
                $read_topis = array();
                if($course_subtopics != null){
                    if (is_array($course_subtopics) || is_object($course_subtopics)){
                        foreach ($course_subtopics as $key => $course_subtopic) {
                            if(!$course_subtopic)
                                continue;
                            if(!is_int($course_subtopic['value']))
                                continue;

                            $topic_category = get_the_category_by_ID($course_subtopic['value']);
                            if(is_wp_error($topic_category))
                                continue;

                            if ($course_subtopic != "" && $course_subtopic != "Array" && !in_array(intval($course_subtopic['value']), $read_topis)){
                                $field .= (String)$topic_category . ',';
                                array_push($read_topis, intval($course_subtopic['value']));
                            }
                        }
                        $field = substr($field,0,-1);
                        echo $field;
                    }
                }
                ?>
                </p>
            </td>
            <td class="textTh"><?php echo($day); ?></td>
            <td class="textTh">
                <div class="dropdown text-white">
                    <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                        <img style="width:20px"
                             src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                    </p>
                    <ul class="dropdown-menu">
                        <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="<?php echo $link; ?>" target="_blank">Bekijk</a></li>
                        <?php
                        if($course->post_author == $user_in->ID || in_array('hr', $user_in->roles) || in_array('administrator', $user_in->roles) ){
                            echo '<li class="my-2"><i class="fa fa-gear px-2"></i><a href="' . $path_edit . '">Pas aan</a></li>';
                            echo '<li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2 "></i><input type="button" id="" value="Verwijderen"/></li>';
                        }
                        ?>
                    </ul>
                </div>
            </td>
        </tr>
        <?php
    }
}