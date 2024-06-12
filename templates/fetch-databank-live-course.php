<?php
/** Template Name: Fetch databank  Live course */


$search_txt_course = isset($_POST['search_txt_course']) ? sanitize_text_field($_POST['search_txt_course']) : '';




if (empty($search_txt_course)) {
   $args = array(
    
    'post_type' => array('course', 'post'),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',
                            
);
} else {
   $args = array(
    
    'post_type' => array('course', 'post'),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',
     's' => $search_txt_course                           
);
}




$courses = get_posts($args);

?>

<table class="table table-responsive">
    <thead>
        <tr>
            <th scope="col">Image</th>
            <th scope="col">Titel</th>
            <th scope="col">Type</th>
            <th scope="col">Price</th>
            <th scope="col">Sub-topics</th>
            <th scope="col">Startdate</th>
            <th scope="col">Teachers</th>
            <th scope="col">Company</th>
            <th scope="col">Status</th>
            <th scope="col">Views</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody id="autocomplete_company_databank">
        <?php  
        if (!empty($courses)) {
            foreach ($courses as $course) {
                // Thumbnail
                $thumbnail = get_the_post_thumbnail_url($course->ID);
                if (!$thumbnail) {
                    $thumbnail = get_field('url_image_xml', $course->ID);
                }
                if (!$thumbnail) {
                    $thumbnail = get_stylesheet_directory_uri() . '/img/' . strtolower(get_field('course_type', $course->ID)) . '.jpg';
                }
                
                // Categories
                $category = " ";
                $category_id = intval(explode(',', get_field('categories', $course->ID)[0]['value'])[0]);
                $category_xml = intval(get_field('category_xml', $course->ID)[0]['value']);
                if ($category_xml && $category_xml != 0) {
                    $category = (String)get_the_category_by_ID($category_xml);
                }
                if ($category_id && $category_id != 0) {
                    $category = (String)get_the_category_by_ID($category_id);
                }

                // Author Image
                $image_author = get_field('profile_img', 'user_' . $course->post_author);
                $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';

                // Company
                $company = get_field('company', 'user_' . $course->post_author);
                $company_logo = get_stylesheet_directory_uri() . '/img/placeholder.png';
                if (!empty($company)) {
                    $company_logo = get_field('company_logo', $company[0]->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder.png';
                }

                // Subtopics
                $course_subtopics = get_field('categories', $course->ID);
                $field = '';
                if ($course_subtopics != NULL) {
                    if (is_array($course_subtopics) || is_object($course_subtopics)) {
                        foreach ($course_subtopics as $course_subtopic) {
                            if (!$course_subtopic || !is_int($course_subtopic['value'])) continue;
                            $topic_category = get_the_category_by_ID($course_subtopic['value']);
                            if (is_wp_error($topic_category)) continue;
                            $field .= (String)$topic_category . ',';
                        }
                        $field = rtrim($field, ',');
                    }
                }

                // Course type and Links
                $course_type = get_field('course_type', $course->ID);
                $path_edit = "";
                $link = "";
                if ($course_type == 'Artikel') {
                    $path_edit = "/dashboard/teacher/course-selection/?func=add-article&id=" . $course->ID . "&edit";
                    $link = get_permalink($course->ID);
                } elseif ($course_type == 'Video') {
                    $path_edit = "/dashboard/teacher/course-selection/?func=add-video&id=" . $course->ID . "&edit";
                    $link = get_permalink($course->ID);
                } elseif (in_array($course_type, ['Lezing', 'Event'])) {
                    $path_edit = "/dashboard/teacher/course-selection/?func=add-add-white&id=" . $course->ID . "&edit";
                    $link = get_permalink($course->ID);
                } elseif (in_array($course_type, ['Opleidingen', 'Workshop', 'Training', 'Masterclass', 'Cursus'])) {
                    $path_edit = "/dashboard/teacher/course-selection/?func=add-course&id=" . $course->ID . "&edit";
                    $link = get_permalink($course->ID);
                } elseif ($course_type == 'Leerpad') {
                    $path_edit = "/dashboard/teacher/course-selection/?func=add-road&id=" . $course->ID . "&edit";
                    $link = '/detail-product-road?id=' . $course->ID;
                } elseif ($course_type == 'Assessment') {
                    $path_edit = "/dashboard/teacher/course-selection/?func=add-assessment&id=" . $course->ID . "&edit";
                    $link = '/detail-assessment?assessment_id=' . $course->ID;
                } elseif ($course_type == 'Podcast') {
                    $path_edit = "/dashboard/teacher/course-selection/?func=add-podcast&id=" . $course->ID . "&edit";
                    $link = get_permalink($course->ID);
                }

                // Start date
                $date = new DateTime($course->post_date);
                $formattedDate = $date->format('d/m/Y');

                // Price
                $price = get_field('price', $course->ID);
                $price = empty($price) ? 'Gratis' : number_format($price, 2, '.', ',');

                // Status
                $status = $course->post_status;

                // Views (Placeholder value)
                $views = 503;

                // Company Name
                $company_name = !empty($company) ? '' : 'No company';

                echo '<tr class="pagination-element-block">';
                echo '    <td><div class="for-img"><img src="' . $thumbnail . '" alt="" srcset=""></div></td>';
                echo '    <td class="textTh text-left first-td-databank"><a style="color:#212529;font-weight:bold" href="' . $link . '">' . $course->post_title . '</a></td>';
                echo '    <td class="textTh">' . $course_type . '</td>';
                echo '    <td id="" class="textTh td_subtopics">' . $price . '</td>';
                echo '    <td id="' . $course->ID . '" class="textTh td_subtopics">' . $category . $field . '</td>';
                echo '    <td class="textTh "><div class="bg-element"><p>' . $formattedDate . '</p></div></td>';
                echo '    <td class="textTh block-pointer td_authors"><div id="id_authors" class="d-flex content-teacher" data-toggle="modal" data-target="#showTeacher" type="button" data-value="' . $course->ID . '">';
                echo '        <img src="' . $image_author . '" alt="image course" width="25" height="25">';
                echo '    </div></td>';
                echo '    <td class="textTh block-pointer td_compagnies"><div class="d-flex content-company" data-toggle="modal" data-target="#showCompany" data-value="' . $course->ID . '" type="button">';
                echo '        <img src="' . $company_logo . '" alt="image course" width="25" height="25">';
                echo '    </div></td>';
                echo '    <td class="textTh"><div class="bg-element"><p>' . $status . '</p></div></td>';
                echo '    <td class="textTh"><div class="bg-element"><p>' . $views . '</p></div></td>';
                echo '    <td class="textTh"><div class="dropdown text-white">';
                echo '        <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown"><img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset=""></p>';
                echo '        <ul class="dropdown-menu">';
                echo '            <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="' . $link . '" target="_blank">Bekijk</a></li>';
                echo '            <li class="my-2"><i class="fa fa-gear px-2"></i><a href="' . $path_edit . '" target="_blank">Pas aan</a></li>';
                echo '            <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button" id="" value="Verwijderen"/></li>';
                echo '        </ul>';
                echo '    </div></td>';
                echo '</tr>';
            }
        } else {
            echo "<tr><td colspan='11'>There is nothing to see here</td></tr>";
        }
