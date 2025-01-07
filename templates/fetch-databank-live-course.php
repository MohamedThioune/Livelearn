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

               //Categories
               $category = "";
               $id_category = 0;
               $category_id = 0;
               $categories = get_field('categories',  $course->ID);
               if ($categories)
                  if (isset($categories[0]['value'])) {
                     $category_id = intval($categories[0]['value']);
                  }
               $categories_xml = get_field('category_xml', $course->ID);
               if ($categories_xml)
                  $category_xml = intval($categories_xml[0]['value']);
               if(isset($category_xml))
                  if($category_xml != 0)
                     $category = (String)get_the_category_by_ID($category_xml);

               if($category_id)
                  if($category_id != 0)
                     $category = (String)get_the_category_by_ID($category_id);

                // Author Image
                $image_author = get_field('profile_img', 'user_' . $course->post_author);
                $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';

                // Company
                $company = get_field('company', 'user_' . $course->post_author);
                $company_logo = get_stylesheet_directory_uri() . '/img/placeholder.png';
                if (!empty($company)) {
                    $company_logo = get_field('company_logo', $company[0]->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder.png';
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
               $lang = get_field('language', $course->ID);
               $language_display = '';
               if ($lang){
                  if (is_array($lang))
                     $language_display = $lang[0];
                  else
                     $language_display = $lang;
                  // take juste 2 first letter
                  $lang_first_character = strtolower(substr($language_display,0,2));

                  switch ($lang_first_character){
                     case 'en':
                        $language_display='English';
                        break;
                     case 'fr':
                        $language_display='French';
                        break;
                     case 'de':
                        $language_display='Dutch';
                        break;
                     case 'nl':
                        $language_display='Nederlands';
                        break;
                     case 'it':
                        $language_display='Italian';
                        break;
                     case 'Ib':
                        $language_display='Luxembourgish';
                        break;
                     case 'sk':
                        $language_display='Slovak';
                        break;
                  }
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

                echo '<tr class="pagination-element-block" id="' . $course->ID . '">';
                echo '    <td><div class="for-img"><img src="' . $thumbnail . '" alt="" srcset=""></div></td>';
                echo '    <td class="textTh text-left first-td-databank"><a style="color:#212529;font-weight:bold" href="' . $link . '">' . $course->post_title . '</a></td>';
                echo '    <td class="textTh">' . $course_type . '</td>';
                echo '    <td class="textTh">' . $language_display . '</td>';
                echo '    <td id="" class="textTh td_subtopics">' . $price . '</td>';
                if ($category) {
                   echo '    <td id="' . $course->ID . '" class="textTh td_subtopics btn"> 
                       <div id= "<?php echo $course->ID; ?>" class="d-flex content-subtopics bg-element" >
                      ' . $category . '
                      </div>
                   </td>';
                } else {
                   echo '    <td id="' . $course->ID . '" class="textTh td_subtopics btn"> 
                            <button class="btn btn-success" >add subtopics</button>
                        </td>';
                }
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
                echo '            <li class="my-1 remove_opleidingen" ><i class="fa fa-trash px-2"></i><input onclick="removeCourse(this)" id="'.$course->ID.'" type="button" value="Verwijderen"/></li>';
                echo '        </ul>';
                echo '    </div></td>';
                echo '</tr>';
            }
        } else {
            echo "<tr><td colspan='11'>There is nothing to see here</td></tr>";
        }
