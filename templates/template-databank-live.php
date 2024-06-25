<?php /** Template Name: databank live */ ?>
<?php
require_once 'add-author.php';
global $wpdb;

/*
 * * Pagination
 */
$pagination = 50;

if (isset($_GET['id'])) 
    $page = intval($_GET['id']);

if ($page) 
    $offset = ($page - 1) * $pagination;


$courses = array();

// Check if the form is submitted
if (isset($_POST['filter_databank'])) {
    // Sanitize and validate form values
    $leervom = isset($_POST['leervom']) ? array_map('sanitize_text_field', $_POST['leervom']) : array();
    $min = isset($_POST['min']) ? intval($_POST['min']) : null;
    $max = isset($_POST['max']) ? intval($_POST['max']) : null;
   // $gratis = isset($_POST['gratis']) ? boolval($_POST['gratis']) : false;
      $gratis = isset($_POST['gratis']) ? 1 : 0;
    $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : null;

    $args = array(
        'post_type' => array('course', 'post'),
        'post_status' => 'publish',
        'posts_per_page' => 100,
        'order' => 'DESC',
        'meta_query' => array(),
    );

    // Filter by course type
    if (!empty($leervom)) {
        $args['meta_query'][] = array(
            'key' => 'course_type',
            'value' => $leervom,
            'compare' => 'IN',
        );
    }

    // Filter by price
    if ($gratis) {
            $args = array(
        

        'post_type' => array('course', 'post'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'ordevalue'       => 0,
        'order' => 'DESC' ,
      'meta_key'   => 'price',
      'meta_value' => 0
    );
    } else if ($min !== null || $max !== null) {
        $price_range = array('relation' => 'AND');
        if ($min !== null) {
            $price_range[] = array(
                'key' => 'price',
                'value' => $min,
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }
        if ($max !== null) {
            $price_range[] = array(
                'key' => 'price',
                'value' => $max,
                'compare' => '<=',
                'type' => 'NUMERIC',
            );
        }
        $args['meta_query'][] = $price_range;
    }

    // Filter by status
    if ($status) {
        $args['meta_query'][] = array(
            'key' => 'status',
            'value' => $status,
            'compare' => '=',
        );
    }

    // Fetch filtered courses
    $courses = get_posts($args);

} else {
    // Default behavior: Fetch all published courses if no filter is applied
    $args = array(
        'post_type' => array('course', 'post'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC'
    );
    $courses = get_posts($args);
}


 function countTypeCourse($course_type){
    
$args = array(
      'post_type' => array('course','post'),
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'ordevalue'       => $course_type,
      'order' => 'DESC' ,
      'meta_key'         => 'course_type',
      'meta_value' => $course_type
);
return count(get_posts($args));
 }
 $countVideos = countTypeCourse('video');
 $countArtikles = countTypeCourse('article');
 $countPodcasts=countTypeCourse('podcast');
 $countOpleidingens=countTypeCourse('course');



// // Retrieve courses using get_posts()
$args = array(
    'post_type' => array('course', 'post'),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC'
);
 $courses_on_current_page = get_posts($args);
  $count = count($courses_on_current_page);

  // get compagnies:
   $args = array(
        'post_type' => 'company',
        'post_status' => 'publish',
        'posts_per_page' => -1 // Get all posts
    );

    $companies = get_posts($args);
 //get users Authors
   

   $author_users = get_users(array('role_in' => ['author','administrator']));


if ($count % $pagination == 0) 
    $pagination_number = $count / $pagination;
else 
    $pagination_number = intval($count / $pagination) + 1;

$user = wp_get_current_user();

   
     


?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">


<div class="new-content-databank">
    <div class="container-fluid">
        <div class="head d-flex justify-content-between align-items-center">
            <p class="title-page">Databank LIVE</p>
            <div class="d-flex">
                <button class="btn btn-add-element" data-toggle="modal" data-target="#ModalCompany" type="button">Add a
                    company</button>
                <button class="btn btn-add-element" data-toggle="modal" data-target="#ModalTeacher" type="button">Add a
                    teacher</button>
            </div>
        </div>
        <div class="content-tab">
            <div class="d-flex justify-content-between content-head-tab">
                <div class="content-button-tabs">
                    <button data-tab="all" class="b-nav-tab buttonInsideModal btn active">
                        View all<span class="number-content"><?php echo $count;?></span>
                    </button>
                    <button data-tab="Opleidingen" class="b-nav-tab buttonInsideModal btn">
                        Opleidingen <span class="number-content"><?php echo $countOpleidingens;?></span>
                    </button>
                    <button data-tab="Article" class="b-nav-tab buttonInsideModal btn">
                        Article <span class="number-content"><?php echo $countArtikles;?></span>
                    </button>
                    <button data-tab="Podcast" class="b-nav-tab buttonInsideModal btn">
                        Podcast <span class="number-content"><?php echo $countPodcasts;?></span>
                    </button>
                    <button data-tab="Videos" class="b-nav-tab buttonInsideModal btn">
                        Videos <span class="number-content"><?php echo $countVideos;?></span>
                    </button>
                </div>
                <div class="d-flex align-items-center">
                    <input id="search_txt_course" type="search" class="search-databank" placeholder="Search">
                </div>
            </div>
            <div class="headFilterCourse">
                <div class="mob filterBlock m-2 mr-4">
                    <p class="fliterElementText">Filter</p>
                    <button class="btn btnIcone8" id="show"><img
                            src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/filter.png" alt=""></button>
                </div>
                <div class="formFilterDatabank">
                    <form action="" method="POST">
                        <p class="textFilter">Filter :</p>
                        <button class="btn hideBarFilterBlock"><i class="fa fa-close"></i></button>
                        <select name="leervom[]">
                            <option value="" disabled>Leervoom</option>
                            <option value="Opleidingen"
                                <?php if(isset($leervom) && in_array('Opleidingen', $leervom)) echo "selected"; ?>>
                                Opleidingen</option>
                            <option value="Training"
                                <?php if(isset($leervom) && in_array('Training', $leervom)) echo "selected"; ?>>Training
                            </option>
                            <option value="Workshop"
                                <?php if(isset($leervom) && in_array('Workshop', $leervom)) echo "selected"; ?>>Workshop
                            </option>
                            <option value="E-learning"
                                <?php if(isset($leervom) && in_array('E-learning', $leervom)) echo "selected"; ?>>
                                E-learning</option>
                            <option value="Masterclass"
                                <?php if(isset($leervom) && in_array('Masterclass', $leervom)) echo "selected"; ?>>
                                Masterclass</option>
                            <option value="Video"
                                <?php if(isset($leervom) && in_array('Video', $leervom)) echo "selected"; ?>>Video
                            </option>
                            <option value="Assessment"
                                <?php if(isset($leervom) && in_array('Assessment', $leervom)) echo "selected"; ?>>
                                Assessment</option>
                            <option value="Lezing"
                                <?php if(isset($leervom) && in_array('Lezing', $leervom)) echo "selected"; ?>>Lezing
                            </option>
                            <option value="Event"
                                <?php if(isset($leervom) && in_array('Event', $leervom)) echo "selected"; ?>>Event
                            </option>
                            <option value="Leerpad"
                                <?php if(isset($leervom) && in_array('Leerpad', $leervom)) echo "selected"; ?>>Leerpad
                            </option>
                            <option value="Artikel"
                                <?php if(isset($leervom) && in_array('Artikel', $leervom)) echo "selected"; ?>>Artikel
                            </option>
                            <option value="Podcast"
                                <?php if(isset($leervom) && in_array('Podcast', $leervom)) echo "selected"; ?>>Podcast
                            </option>
                            <option value="Cursus"
                                <?php if(isset($leervom) && in_array('Cursus', $leervom)) echo "selected"; ?>>Cursus
                            </option>
                            <option value="Class"
                                <?php if(isset($leervom) && in_array('Class', $leervom)) echo "selected"; ?>>Class
                            </option>
                            <option value="Webinar"
                                <?php if(isset($leervom) && in_array('Webinar', $leervom)) echo "selected"; ?>>Webinar
                            </option>
                        </select>
                        <div class="priceInput">
                            <div class="priceFilter">
                                <input type="number" name="min" value="<?php if(isset($min)) echo $min ?>"
                                    placeholder="min Prijs">
                                <input type="number" name="max" value="<?php if(isset($max)) echo $max ?>"
                                    placeholder="tot Prijs">
                                    
                            </div>
                             <div class="input-group">
                                <label for="">Gratis</label>
                                <input name="gratis" type="checkbox" <?php if(isset($gratis)) echo 'checked'; else  echo  '' ?> >
                            </div>
                          
                        </div>
                        <select name="status">
                            <option value="" disabled selected>Status</option>
                            <option value="Live">Live</option>
                            <option value="Not Live">Not Live</option>
                        </select>

                        <button class="btn btnApplyFilter" name="filter_databank" type="submit">Apply</button>
                    </form>
                   
                </div>

            </div>

            <div id="all" class="b-tab active contentBlockSetting">
                <div class="contentCardListeCourse">
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
                                $thumbnail = "";
$course_type = get_field('course_type', $course->ID); 
if(!$thumbnail){
    $thumbnail = get_the_post_thumbnail_url($course->ID);
    if(!$thumbnail)
         $thumbnail = get_field('url_image_xml', $course->ID);
    if(!$thumbnail)
         $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
}

//   //Author Image
//         $image_author = get_field('profile_img', 'user_' . $course->author_id);
//         $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';

//         //Company
//         $company = get_field('company', 'user_' . $course->post_author);

//         $company_logo = get_stylesheet_directory_uri() . '/img/placeholder.png';
//         if (!empty($company)) {
//             $company_logo = (get_field('company_logo', $company[0]->ID)) ? get_field('company_logo', $company[0]->ID) : get_stylesheet_directory_uri() . '/img/placeholder.png';
//         }
     //Author Image
                                           $image_author = get_field('profile_img', 'user_' . $course->post_author);
                                           $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';

                                           //Company
                                            $company = get_field('company', 'user_' . $course->post_author);

                                            $company_logo = get_stylesheet_directory_uri() . '/img/placeholder.png';
                                            if (!empty($company)) {
                                                   $company_logo = (get_field('company_logo', $company[0]->ID)) ? get_field('company_logo', $company[0]->ID) : get_stylesheet_directory_uri() . '/img/placeholder.png';
                                            }
       
                           /*
                            * Price 
                            */
                            $p = get_field('price', $course->ID);
                            if($p != "0")
                                $price = number_format($p, 2, '.', ',');
                            else 
                                $price = 'Gratis';
                                     
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
                            
                                          

                                             $link = get_permalink($course->ID);
                                           
                                              
        
                                              
                                      

                    

                                           
                      ?>
                            <tr class="pagination-element-block">
                                <td>
                                    <div class="for-img">
                                        <img src="<?=$thumbnail;?>" alt="" srcset="">
                                    </div>
                                </td>
                                <td class="textTh text-left first-td-databank"><a style="color:#212529;font-weight:bold"
                                        href=""><?php echo $course->post_title; ?></a></td>
                                <td class="textTh"><?= get_field('course_type', $course->ID);?></td>
                                <td id="" class="textTh td_subtopics">
                                    <?php echo empty(get_field('price', $course->ID)) ? 'Gratis':  get_field('price', $course->ID); ?>
                                </td>
                              

                                 
                                <td id= <?php echo $course->ID; ?> class="textTh td_subtopics">
                                    <?php
                                     $course_subtopics = get_field('categories', $course->ID);
                                     if($course_subtopics != null){
                                     ?>
                                    <div id= <?php echo $course->ID; ?> class="d-flex content-subtopics bg-element td_subtopics" >
                                <?= $category ?>
                                <?php
                               
                                $field='';
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

                    
                                    </div> 
                                    <?php }?>      
                            </td>
                                <td class="textTh ">
                                    <div class="bg-element">
                                        <p> <?php 
                                    $date = new DateTime($course->post_date);
                                    $formattedDate = $date->format('d/m/Y');
                                    echo  $day ; 
                                    ?></p>
                                    </div>
                                </td>
                                <td  class="textTh block-pointer td_authors">
                                    <div id="id_authors" class="d-flex content-teacher" data-toggle="modal" data-target="#showTeacher"
                                        type="button" data-value="<?php echo $course->ID; ?>">
                                        <?php if ($course->post_author) {
                                            ?>
                                            
            <img src="<?php echo $image_author?>" alt="image course" width="25" height="25">;
            <?php
        } else {
            ?>


            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/course-img.png" alt="" srcset="">;
                             <?php

                                        }
                                        ?>
                                        <!-- <img src="<?php echo get_stylesheet_directory_uri() ?>/img/course-img.png" alt="" srcset="">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/img/course-img.png" alt="" srcset="">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/img/course-img.png" alt="" srcset="">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/img/course-img.png" alt="" srcset=""> -->
                                    </div>
                                </td>
                                <td class="textTh block-pointer td_compagnies">
                                    <div class="d-flex content-company"  data-toggle="modal" data-target="#showCompany" data-value="<?php echo $course->ID ?>"
                                        type="button">
                                       <?php if (!empty($company)) {
                                        ?>
                                           <img src="<?php echo $company_logo?>" alt="image course" width="25" height="25">;
                                           <?php
                                        } else {
                                            ?>
                                           
                                             <img src="<?php echo get_stylesheet_directory_uri() ?>/img/course-img.png" alt="image course" >;
                                    <?php
                                        }
                                      ?>

                                    </div>
                                </td>
                                <td class="textTh">
                                    
                                        <div class="bg-element">
                                        <p>Live</p>
                                    </div>
                                    
                                </td>
                                <td class="textTh">
                                    <div class="bg-element">
                                        <p>503</p>
                                    </div>
                                </td>
                                <td class="textTh">
                                    <div class="dropdown text-white">
                                        <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                            <img style="width:20px"
                                                src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt=""
                                                srcset="">
                                        </p>
                                        <ul class="dropdown-menu">
                                            <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i
                                                    class="fa fa-eye px-2"></i><a href="<?php echo $link; ?>" target="_blank">Bekijk</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>



                            <?php
                        //  die();
                          }
                     } else {
                             echo ("There is nothing to see here");
                           }
                        ?>
                        </tbody>
                    </table>
                    
                <div class="pagination-container">
                    <!-- Les boutons de pagination seront ajoutés ici -->
                </div>


                </div>
            </div>

            <div id="Opleidingen" class="b-tab contentBlockSetting">
                b
            </div>

            <div id="Article" class="b-tab contentBlockSetting">
                d
            </div>

            <div id="Podcast" class="b-tab contentBlockSetting">
                e
            </div>

            <div id="Videos" class="b-tab contentBlockSetting">
                f
            </div>

        </div>
    </div>

    
     <!-- Modal add company -->
    <div class="modal fade" id="ModalCompany" tabindex="-1" role="dialog" aria-labelledby="ModalCompanyLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
               
                    <h5 class="modal-title" id="exampleModalLabel">Create a company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               
                  <div class="text-center" id="content-back-topics"></div>
                <div class="modal-body">
    <form id="companyForm" >
        <div class="form-group">
            <label for="First-name">Click to choose your logo</label>
            <div class="image-container" id="imageContainerCompany" onclick="document.getElementById('fileInputCompany').click()">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/placeholder_user.png" alt="Placeholder" id="uploadedImageCompany">
            </div>
            <input type="file" id="fileInputCompany" name="company_logo" accept="image/*" style="display: none;">
        </div>
        <div class="form-group">
            <label for="Company-name">Company Name</label>
            <input type="text" class="form-control" id="Company-name" name="company_name" placeholder="Enter your Company Name" required>
        </div>
        <div class="form-group">
            <label for="Country">Company Country</label>
            <input type="text" class="form-control" id="Country" name="company_country" placeholder="Enter your Company Country" required>
        </div>
        <div class="form-group">
            <label for="City">Company City</label>
            <input type="text" class="form-control" id="City" name="company_city" placeholder="Enter your Company City" required>
        </div>
        <div class="form-group">
            <label for="Address">Company Address</label>
            <input type="text" class="form-control" id="Address" name="company_address" placeholder="Enter your Company Address" required>
        </div>
        <div class="form-group">
            <label for="Industry">Industry</label>
            <input type="text" class="form-control" id="Industry" name="company_industry" placeholder="Enter your Industry" required>
        </div>
        <div class="form-group">
            <label for="People">Amount of people</label>
            <input type="number" class="form-control" id="People" name="company_size" placeholder="Enter the number of people">
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="submitCompanyForm()">Save</button>
</div>
            </div>
        </div>
    </div>

    <!-- Modal add teacher -->
    <div class="modal fade" id="ModalTeacher" tabindex="-1" role="dialog" aria-labelledby="ModalTeacherLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h5 class="modal-title" id="exampleModalLabel">Add a Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="text-center" id="content-back-topicsauthor"></div>
     <div class="modal-body">
    <form id="userForm" enctype="multipart/form-data">
        <div class="form-group">
            <label for="Profile-photo">Profile photo</label>
            <div class="image-container" id="imageContainer" onclick="document.getElementById('fileInput').click()">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/placeholder_user.png" alt="Placeholder" id="uploadedImage">
            </div>
            <input type="file" id="fileInput" name="profile_photo" accept="image/*" style="display: none;">
        </div>
        <div class="form-group">
            <label for="First-name">First name</label>
            <input type="text" class="form-control" id="First-name" name="first_name" placeholder="Enter her First name" required>
        </div>
        <div class="form-group">
            <label for="Last-name">Last name</label>
            <input type="text" class="form-control" id="Last-name" name="last_name" placeholder="Enter her Last name" required>
        </div>
        <div class="form-group">
            <label for="Email">Email</label>
            <input type="email" class="form-control" id="Email" name="email" placeholder="Enter her Email" required>
        </div>
        <div class="form-group">
            <label for="Phonenumber">Phone number</label>
            <input type="text" class="form-control" id="Phonenumber" name="phone_number" placeholder="Enter her Phone number" required>
        </div>
         <div class="form-group">
                        <label class="label-sub-topics">Select Company</label>
                        <select name="companyId" id="selected_company"  class="multipleSelect2" >
                            <?php
                                foreach($companies as $value) {
                                   
                                    echo "<option value='" . $value->ID . "'>" . $value->post_name . "</option>";
                                }
                            ?>
                        </select>
                    </div> 
        
        <!-- <div class="form-group">
            <label for="Role">Role</label>
            <select name="role" id="Role" class="form-control" required>
                <option value="subscriber">User</option>
                <option value="editor">Teacher</option>
                <option value="administrator">Admin</option>
            </select>
        </div> -->
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="submitUserForm()">Save</button>
</div>

            </div>
        </div>
    </div>
    <!-- Modal add teacher -->
    <div class="modal fade" id="ModalTeacher" tabindex="-1" role="dialog" aria-labelledby="ModalTeacherLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sub-topics</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label for="First-name">Profile photo</label>
                            <div class="image-container" id="imageContainer" onclick="openImageUploader()">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/img/placeholder_user.png"
                                    alt="Placeholder" id="uploadedImage"">
                            </div>
                            <input type=" file" id="fileInput" name="profile_photo" accept="image/*" style="display: none;">
                            </div>
                            <div class="form-group">
                                <label for="First-name">First name</label>
                                <input type="text" class="form-control" id="First-name*"
                                    placeholder="Enter her First name" required>
                            </div>
                            <div class="form-group">
                                <label for="Country">Last name</label>
                                <input type="text" class="form-control" id="Last-name" placeholder="Enter her Last name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" class="form-control" id="Email" name="City"
                                    placeholder="Enter her Email" required>
                            </div>
                            <div class="form-group">
                                <label for="Phonenumber">Phone number</label>
                                <input type="text" class="form-control" id="Phonenumber"
                                    placeholder="Enter her Phone number" required>
                            </div>
                            <div class="form-group">
                                <label for="Industry">Role</label>
                                <select name="" id="">
                                    <option value="">User</option>
                                    <option value="">Teacher</option>
                                    <option value="">Admin</option>
                                </select>
                            </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

   


    <!-- Modal show teacher -->
    <div class="modal fade" id="showTeacher" tabindex="-1" role="dialog" aria-labelledby="showTeacherLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                 <div class="text-center" id="seclect-author"></div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center head-for-body">
                        <p class="btn-sub-title-topics" id="removeTeacher" type="button">Remove</p>
                        <p class="text-or">Or</p>
                        <button class="btn btn-add-sub-topics" id="addTeacher" type="button">Add teacher</button>
                    </div>
                    <div class="block-to-show-teacher">
                       
                    </div>

                    <div class="block-to-add-teacher">
                         <form action="">
                        <div class="form-group mb-4">
                            <div class="companyAutho" id="companyAuthor"></div>
                            <label class="label-sub-topics">Select Author(s) </label>
                            <div class="formModifeChoose">
                                <select name="userId" id="selected_user" class="multipleSelect2" multiple="true">
                                    <?php
 
                                        foreach($author_users as $value)
                                      echo "<option    value='" . $value->ID . "'>" . $value->display_name . "</option>";
 
                                       ?>


                                     
            
                                </select>
                            </div>
                        </div>
                        
                         
                    </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="save_author" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

  
     <!-- The Modal -->
    <div id="myModal" class="modal">
          
           
        <div class="modal-dialog" role="document">
            <div class="modal-content">
               
                
                    
                
            <!-- </div> -->
            </div>
        </div>    
    </div>

    


</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#autocomplete').on('change', function() {
        if ($(this).val()) {
            $(".block-sub-topics").show();
        } else {
            $(".block-sub-topics").hide();
        }
    });
});
</script>
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
const selectButtons = document.querySelectorAll('.select-button');
selectButtons.forEach(button => {
    button.addEventListener('click', () => {
        button.classList.toggle('active');
    });
});
</script>
<script>
$(".btn-add-sub-topics").click(function() {
    $(".content-sub-topics").hide();
    $(".content-add-sub-topics").show();
});
$(".btn-sub-title-topics").click(function() {
    $(".content-sub-topics").show();
    $(".content-add-sub-topics").hide();
});
$("#addTeacher").click(function() {
    $(".block-to-add-teacher").show();
    $(".block-to-show-teacher").hide();
});
$("#removeTeacher").click(function() {
    $(".block-to-add-teacher").hide();
    $(".block-to-show-teacher").show();
});
</script>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// $(document).ready(function() {
//     $('.topic-item').on('click', function() {
//         var topic = $(this).data('topic');
//         console.log(topic);
//         var topics = $(this).data('topic');
//         var topicHtml = '';
//         topics.forEach(function(topic) {
//             topicHtml += '<div class="btn-sub-topics">' +
//                 '<p>' + topic + '</p>' +
//                 '<button class="btn"><i class="fa fa-remove"></i></button>' +
//                 '</div>';
//         });

//         $('.content-sub-topics').html(topicHtml);
//     });
// });
</script>
<script>
function submitUserForm() {
   // var formData = new FormData(document.getElementById('userForm'));
    var form = document.getElementById('userForm');
 var companyId = $('#selected_company').val()

        
      
document.getElementById('content-back-topicsauthor').innerHTML ="<span>Wait for saving datas <i class='fas fa-spinner fa-pulse'></i></span>";
    // Create a FormData object to send the file
    var formData = new FormData(form);
 
//     console.log("avant")
   
//     var formData = new FormData();

    
//     for (var i = 0; i < form.elements.length; i++) {
//         var element = form.elements[i];
//         if (element.name) {
//             formData.append(element.name, element.value);
//         }
//     }
   
    
//   const fileInput = document.getElementById('fileInput');
//      if (fileInput.files.length > 0) {
         
//          formData.append('profile_photo', fileInput.files[0]);
//      }
    
      formData.append('action', 'add_users');
      formData.append('companyId', companyId);

 
    

    $.ajax({
        url: "/save-author-and-compagny",
        method:"post",
        data: formData,
        processData: false,
        contentType: false, 
        
         // dataType:"text",
        success: function(response) {
            console.log(response)
           // alert('User created successfully!');
              document.getElementById('content-back-topicsauthor').innerHTML =response;
            // Optionally, you can refresh the page or update the UI accordingly
           //  $('#ModalTeacher').modal('hide');
        },
        error: function(response) {
            alert('Failed to create user!');
              document.getElementById('content-back-topicsauthor').innerHTML =response;
             //  $('#ModalTeacher').modal('hide');
        },
        
   complete:function(response){
                    
                  location.reload();
                }
    });
}
</script>
<script>
function submitCompanyForm() {
    document.getElementById('content-back-topics').innerHTML ="<span>Wait for saving datas <i class='fas fa-spinner fa-pulse'></i></span>"
    var form = document.getElementById('companyForm');
    var formData = new FormData();

    for (var i = 0; i < form.elements.length; i++) {
        var element = form.elements[i];
        if (element.name) {
            formData.append(element.name, element.value);
        }
    }

    const fileInput = document.getElementById('fileInputCompany');
    if (fileInput.files.length > 0) {
       formData.append('company_logo', fileInput.files[0]);
    }
     
    formData.append('action', 'add_compagnies');
 

    $.ajax({
        url: "/save-author-and-compagny",
        method: "post",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);
            document.getElementById('content-back-topics').innerHTML = response;
           // $('#ModalCompany').modal('hide');

            
            // Optionally, you can refresh the page or update the UI accordingly
        },
        error: function(response) {
            alert('Failed to create company!');
            document.getElementById('content-back-topics').innerHTML = response;
            // $('#ModalCompany').modal('hide');
        },
        
   complete:function(response){
                    
                  location.reload();
                }

    });
}
</script>

<!-- script-modal -->
<script>
    var id_course;
    $('.td_subtopics').click((e)=>{
        id_course = e.target.id;
        
     $.ajax({
            url:"/fetch-subtopics-course-databanklive",
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
    $('.modal-content').html(data)
    
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
      
      var subtopics = $('#selected_subtopics').val()
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


      
  }
  })
});
// connect company to course
  $('#save_author').click(()=>{
    id_course = document.getElementById('id_authors').getAttribute('data-value');
  
   
        document.getElementById('companyAuthor').innerHTML="<span>Wait for saving datas <i class='fas fa-spinner fa-pulse'></i></span>";
      var author = $('#selected_user').val()
      
    
      $.ajax({
  url:"/save-author-and-compagny",
  method:"post",
  data:
    {
      connect_authortoCourse:author,
      id_course:id_course,
      action:'connect_authortoCourse'
    },
  dataType:"text",
  success: function(data){
    console.log(data);
      
      document.getElementById('companyAuthor').innerHTML = data;
      
  },
  error:function(data){
    document.getElementById('companyAuthor').innerHTML = data;
  },
   complete:function(response){
                    
                  location.reload();
                }

  })
  }
);
// display author 
 $('.td_authors').click((e)=>{
      id_course = document.getElementById('id_authors').getAttribute('data-value');
       
    $('.block-to-show-teacher').html("<span>Wait for getting datas <i class='fas fa-spinner fa-pulse'></i></span>")
     $.ajax({
            url:"/fetch-subtopics-course-databanklive",
            method:"post",
            data:
            {
                id_course:id_course,
                action:'get_course_authors'
            },
        dataType:"text",
        success: function(data){
      
               $('.block-to-show-teacher').html(data)
         } 

})});

</script>

<script>
function openImageUploader() {
    document.getElementById('fileInput').click();
}

document.getElementById('fileInput').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();

        reader.addEventListener('load', function() {
            const imageContainer = document.getElementById('imageContainer');
            const uploadedImage = document.getElementById('uploadedImage');

            imageContainer.style.backgroundImage = `url('${reader.result}')`;
            uploadedImage.src = reader.result;
            uploadedImage.style.display = 'block';
            imageContainer.querySelector('span').style.display = 'none';
        });

        reader.readAsDataURL(file);
    }  

});

</script>
<script>    
function openImageUploaderCompany() {
    document.getElementById('fileInputCompany').click();
}

document.getElementById('fileInputCompany').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();

        reader.addEventListener('load', function() {
            const imageContainer = document.getElementById('imageContainerCompany');
            const uploadedImage = document.getElementById('uploadedImageCompany');

            imageContainer.style.backgroundImage = `url('${reader.result}')`;
            uploadedImage.src = reader.result;
            uploadedImage.style.display = 'block';
            imageContainer.querySelector('span').style.display = 'none';
        });

        reader.readAsDataURL(file);
    }
});
</script>
<script>
     $('#search_txt_course').keyup(function(){
        var txt = $(this).val();
        console.log(txt);

        $.ajax({

            url:"/fetch-databank-live-course",
            method:"post",
            data:{
                search_txt_course : txt,
            },
            dataType:"text",
            success: function(data){
                
                $('#autocomplete_company_databank').html(data);
            }
        });

    });
</script>




<?php get_footer(); ?>
<?php wp_footer(); ?>