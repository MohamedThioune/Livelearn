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

if (isset($_POST['leervom'])) {
    var_dump($_POST['leervom']);
    switch (strtolower($_POST['leervom'][0])) {
        case 'all':
            $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
            $courses = $wpdb->get_results($sql);
            $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0");
            $count = $wpdb->get_results($sql_count);
            $count = intval($count[0]->{'COUNT(*)'});
            break;
        case 'artikel':
            $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d and type = 'Artikel' ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
            $courses = $wpdb->get_results($sql);
            $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0 and type='Artikel'");
            $count = $wpdb->get_results($sql_count);
            $count = intval($count[0]->{'COUNT(*)'});
            break;
        case 'podcast':
            $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d and type = 'Podcast' ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
            $courses = $wpdb->get_results($sql);
            $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0 and type='Podcast'");
            $count = $wpdb->get_results($sql_count);
            $count = intval($count[0]->{'COUNT(*)'});
            break;
        case 'video': 
            $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d and type = 'Videos' ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
            $courses = $wpdb->get_results($sql);
            $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0 and type='Videos'");
            $count = $wpdb->get_results($sql_count);
            $count = intval($count[0]->{'COUNT(*)'});
            break;
        case 'courses':
            $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d and type='Opleidingen' or type='Workshop' or type='Training' or type='Masterclass' or type='E-learning' or type='Lezing' or type='Event' or type='Webinar' ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
            $courses = $wpdb->get_results($sql);
            $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0 and type='Opleidingen' or type='Workshop' or type='Training' or type='Masterclass' or type='E-learning' or type='Lezing' or type='Event' or type='Webinar'");
            $count = $wpdb->get_results($sql_count);
            $count = intval($count[0]->{'COUNT(*)'});
            break;
        default:
            $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
            $courses = $wpdb->get_results($sql);
            $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0");
            $count = $wpdb->get_results($sql_count);
            $count = intval($count[0]->{'COUNT(*)'});
            break;

    }
}
else {
    $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
  //  $courses = $wpdb->get_results($sql);
    $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0");
    $count = $wpdb->get_results($sql_count);
    $count = intval($count[0]->{'COUNT(*)'});
    $args=array('post_type'=>array('course','post'),
    'post_status'=>'publish',
    'posts_per_page'=>-1,
    'order'=>'DESC'
    );
   // $courses=get_posts($args);

    

}

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
                <button class="btn btn-add-element" data-toggle="modal" data-target="#ModalCompany" type="button">Add a company</button>
                <button class="btn btn-add-element" data-toggle="modal" data-target="#ModalTeacher" type="button">Add a teacher</button>
            </div>
        </div>
        <div class="content-tab">
            <div class="d-flex justify-content-between content-head-tab">
                <div class="content-button-tabs">
                    <button data-tab="all" class="b-nav-tab buttonInsideModal btn active">
                        View all<span class="number-content">12</span>
                    </button>
                    <button data-tab="Opleidingen" class="b-nav-tab buttonInsideModal btn">
                        Opleidingen <span class="number-content">8</span>
                    </button>
                    <button data-tab="Article" class="b-nav-tab buttonInsideModal btn">
                        Article <span class="number-content">2</span>
                    </button>
                    <button data-tab="Podcast" class="b-nav-tab buttonInsideModal btn">
                        Podcast <span class="number-content">0</span>
                    </button>
                    <button data-tab="Videos" class="b-nav-tab buttonInsideModal btn">
                        Videos <span class="number-content">3</span>
                    </button>
                </div>
                <div class="d-flex align-items-center">
                    <input type="search" class="search-databank" placeholder="Search">
                </div>
            </div>
            <div class="headFilterCourse">
                <div class="mob filterBlock m-2 mr-4">
                    <p class="fliterElementText">Filter</p>
                    <button class="btn btnIcone8" id="show"><img src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/filter.png" alt=""></button>
                </div>
                <div class="formFilterDatabank">
                    <form action="" method="POST" >
                        <P class="textFilter">Filter :</P>
                        <button class="btn hideBarFilterBlock"><i class="fa fa-close"></i></button>
                        <select name="leervom[]" >
                            <option value="" disabled>Leervoom</option>
                            <option value="Opleidingen" <?php if(isset($leervom)) if(in_array('Opleidingen', $leervom)) echo "selected" ; else echo "" ?>>Opleidingen</option>
                            <option value="Training"    <?php if(isset($leervom)) if(in_array('Training', $leervom)) echo "selected" ; else echo ""  ?>>Training</option>
                            <option value="Workshop"    <?php if(isset($leervom)) if(in_array('Workshop', $leervom)) echo "selected" ; else echo ""  ?>>Workshop</option>
                            <option value="E-learning"  <?php if(isset($leervom)) if(in_array('E-learning', $leervom)) echo "selected" ; else echo "" ?>>E-learning</option>
                            <option value="Masterclass" <?php if(isset($leervom)) if(in_array('Masterclass', $leervom)) echo "selected" ; else echo "" ?>>Masterclass</option>
                            <option value="Video"       <?php if(isset($leervom)) if(in_array('Video', $leervom)) echo "selected" ; else echo ""  ?>>Video</option>
                            <option value="Assessment"  <?php if(isset($leervom)) if(in_array('Assessment', $leervom)) echo "selected" ; else echo "" ?>>Assessment</option>
                            <option value="Lezing"      <?php if(isset($leervom)) if(in_array('Lezing', $leervom)) echo "selected" ; else echo ""?>>Lezing</option>
                            <option value="Event"  <?php if(isset($leervom)) if(in_array('Event', $leervom)) echo "selected" ; else echo "" ?>>Event</option>
                            <option value="Leerpad"<?php if(isset($leervom)) if(in_array('Leerpad', $leervom)) echo "selected" ; else echo "" ?>>Leerpad</option>
                            <option value="Artikel"<?php if(isset($leervom)) if(in_array('Artikel', $leervom)) echo "selected" ; else echo "" ?>>Artikel</option>
                            <option value="Podcast"<?php if(isset($leervom)) if(in_array('Podcast', $leervom)) echo "selected" ; else echo "" ?>>Podcast</option>

                        </select>
                        <div class="priceInput">
                            <div class="priceFilter">
                                <input type="number" name="min" value="<?php if(isset($min)) echo $min ?>" placeholder="min Prijs">
                                <input type="number" name="max" value="<?php if(isset($max)) echo $max ?>" placeholder="tot Prijs">
                            </div>
                            <div class="input-group">
                                <label for="">Gratis</label>
                                <input name="gratis" type="checkbox" <?php if(isset($gratis)) echo 'checked'; else  echo  ''?> >
                            </div>
                        </div>
                        <select name="status">
                            <option value="" disabled selected>Status</option>
                            <option value="Live">Live</option>
                            <option value="Not Live">Not live</option>
                        </select>

                        <button class="btn btnApplyFilter" name="filter_databank" type="submit">Apply</button>
                    </form>
                </div>

            </div>

            <div id="all" class="b-tab active contentBlockSetting">
        
         <div class="contentCardListeCourse">
        <table class="table table-responsive" id="myTable">
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
                       $args=array('post_type'=>array('course','post'),
    'post_status'=>'publish',
    'posts_per_page'=>-1,
    'order'=>'DESC'
    );
    $courses=get_posts($args);
                       if (!empty($courses)) {
                            foreach ($courses as $course) {
                                            //Author Image
                                           $image_author = get_field('profile_img', 'user_' . $course->author_id);
                                           $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';

                                           //Company
                                            $company = get_field('company', 'user_' . $course->author_id);

                                            $company_logo = get_stylesheet_directory_uri() . '/img/placeholder.png';
                                            if (!empty($company)) {
                                                   $company_logo = (get_field('company_logo', $company[0]->ID)) ? get_field('company_logo', $company[0]->ID) : get_stylesheet_directory_uri() . '/img/placeholder.png';
                                            }

                                             //Thumbnail
                                            $image = $course->image_xml ? $course->image_xml : $company_logo;

                                             $onderwerpen = array();
                                            //Onderwerpen
                                           if ($course->onderwerpen != "") {
                                                $onderwerpen = explode(',', $course->onderwerpen);
                                            }

                                            $state = $course->course_id ? 'present' : 'missing';
                                            $key = $course->id;
                      ?>
                            <tr class="pagination-element-block">
                            <td>
                                <div class="for-img">
                                    <img src="<?=$image;?>" alt="" srcset="">
                                </div>
                            </td>
                            <td class="textTh text-left first-td-databank"><a style="color:#212529;font-weight:bold" href=""><?php echo $course->titel; ?></a></td>
                            <td class="textTh"><?=$course->type;?></td>
                            <td id="" class="textTh td_subtopics"> <?php echo empty($course->prijs) ? 'Free':  $course->prijs; ?></td>
                            <td class="textTh block-pointer">
                                
                                  <?php
// if ($course->type != 'Video') {
                                 if (!empty($onderwerpen)) {
                                    ?>
                                    <div class="d-flex content-subtopics bg-element" data-toggle="modal" data-target="#showTopics" type="button">
                                    <?php
                                           $tab = [];
                                           foreach ($onderwerpen as $value1) {
                                                     if ($value1 && !is_wp_error(get_the_category_by_ID($value1))) {
                                                            $tab[] = (String) get_the_category_by_ID($value1);
                                                     } elseif (!$value1) {
                                                     $tab[] = null;
                                                     }

                                            }
                                            $tab = array_unique($tab);
                                            foreach ($tab as $value2) {
                                                     if ($value2) {
                                                            echo '<p>'.$value2 . '</p>';
                                                     }

                                            }
                                   ?>
                                   </div>
                                   <?php
                                   }
                                   ?>
                                   
                                
                            </td>
                            <td class="textTh ">
                                <div class="bg-element">
                                    <p> <?php 
                                    $date = new DateTime($course->created_at);
                                    $formattedDate = $date->format('d/m/Y');
                                    echo $formattedDate; 
                                    ?></p>
                                </div>
                            </td>
                            <td class="textTh block-pointer">
                                <div class="d-flex content-teacher" data-toggle="modal" data-target="#showTeacher" type="button">
                                 <?php if ($course->author_id) {
            echo '<img src="' . $image_author . '" alt="image course" width="25" height="25">';
        } else {
            echo '<img src="<?php echo get_stylesheet_directory_uri() ?>/img/course-img.png" alt="" srcset="">';
        }
        ?>
                                    <!-- <img src="<?php echo get_stylesheet_directory_uri() ?>/img/course-img.png" alt="" srcset="">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/img/course-img.png" alt="" srcset="">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/img/course-img.png" alt="" srcset="">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/img/course-img.png" alt="" srcset=""> -->
                                </div>
                            </td>
                            <td class="textTh block-pointer">
                                <div class="d-flex content-company" data-toggle="modal" data-target="#showCompany" type="button">
                                    <?php if (!empty($company)) {
                                             echo '';
                                     } else {
                                                echo 'company';
                                     }
                                     ?> <?php if (!empty($company)) {
                                           echo '<img src="' . $company_logo . '" alt="image course" width="25" height="25">';
                                        } else {
                                            echo '<b>No company</b>';
                                        }
                                      ?>
                                   
                                </div>
                            </td>
                            <td class="textTh">
                                <div class="bg-element">
                                    <p><?=$course->status;?></p>
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
                                             src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                    </p>
                                    <ul class="dropdown-menu">
                                        <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="" target="_blank">Bekijk</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                      
                       
                        
                        <?php
                          }
                     } else {
                             echo ("There is nothing to see here");
                           }
                        ?>
                        </tbody>
         </table>
                   
                    <div id="pagination-container" class="pagination-container">


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
    <div class="modal fade" id="ModalCompany" tabindex="-1" role="dialog" aria-labelledby="ModalCompanyLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create a company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label for="First-name">Click to choose your logo</label>
                            <div class="image-container" id="imageContainer" onclick="openImageUploader()">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/img/placeholder_user.png" alt="Placeholder" id="uploadedImage"">
                            </div>
                            <input type="file" id="fileInput" accept="image/*" style="display: none;">
                        </div>
                        <div class="form-group">
                            <label for="First-name">Company Name</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your Company Name" required>
                        </div>
                        <div class="form-group">
                            <label for="Country">Company Country</label>
                            <input type="text" class="form-control" id="Country" name="Country" placeholder="Enter your Company Country" required>
                        </div>
                        <div class="form-group">
                            <label for="City">Company City</label>
                            <input type="text" class="form-control" id="City" name="City" placeholder="Enter your Company City" required>
                        </div>
                        <div class="form-group">
                            <label for="Adress">Company Adress</label>
                            <input type="text" class="form-control" id="Adress" placeholder="Enter your Company Adress" required>
                        </div>
                        <div class="form-group">
                            <label for="Industry">Industry</label>
                            <input type="text" class="form-control" id="Industry" placeholder="Enter your Industry" required>
                        </div>
                        <div class="form-group">
                            <label for="people">Amount of people</label>
                            <input type="number" class="form-control" id="people" name="people" placeholder="Enter your people">
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

    <!-- Modal add teacher -->
    <div class="modal fade" id="ModalTeacher" tabindex="-1" role="dialog" aria-labelledby="ModalTeacherLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add a Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label for="First-name">Profile photo</label>
                            <div class="image-container" id="imageContainer" onclick="openImageUploader()">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/img/placeholder_user.png" alt="Placeholder" id="uploadedImage"">
                            </div>
                            <input type="file" id="fileInput" accept="image/*" style="display: none;">
                        </div>
                        <div class="form-group">
                            <label for="First-name">First name</label>
                            <input type="text" class="form-control" id="First-name*"  placeholder="Enter her First name" required>
                        </div>
                        <div class="form-group">
                            <label for="Country">Last name</label>
                            <input type="text" class="form-control" id="Last-name" placeholder="Enter her Last name" required>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" id="Email" name="City" placeholder="Enter her Email" required>
                        </div>
                        <div class="form-group">
                            <label for="Phonenumber">Phone number</label>
                            <input type="text" class="form-control" id="Phonenumber" placeholder="Enter her Phone number" required>
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
    <!-- Modal add teacher -->
    <div class="modal fade" id="ModalTeacher" tabindex="-1" role="dialog" aria-labelledby="ModalTeacherLabel" aria-hidden="true">
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
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/img/placeholder_user.png" alt="Placeholder" id="uploadedImage"">
                            </div>
                            <input type="file" id="fileInput" accept="image/*" style="display: none;">
                        </div>
                        <div class="form-group">
                            <label for="First-name">First name</label>
                            <input type="text" class="form-control" id="First-name*"  placeholder="Enter her First name" required>
                        </div>
                        <div class="form-group">
                            <label for="Country">Last name</label>
                            <input type="text" class="form-control" id="Last-name" placeholder="Enter her Last name" required>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" id="Email" name="City" placeholder="Enter her Email" required>
                        </div>
                        <div class="form-group">
                            <label for="Phonenumber">Phone number</label>
                            <input type="text" class="form-control" id="Phonenumber" placeholder="Enter her Phone number" required>
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

    <!-- Modal add show topics -->
    <div class="modal fade" id="showTopics" tabindex="-1" role="dialog" aria-labelledby="showTopicsLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sub-topics</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="d-flex justify-content-between align-items-center head-for-body">
                        <button class="btn btn-sub-title-topics" type="button">Remove</button>
                        <p class="text-or">Or</p>
                        <button class="btn btn-add-sub-topics" type="button">Add Subtopics</button>
                    </div>
                    <div class="content-sub-topics">
                        <div class="btn-sub-topics">
                            <p>Sales</p>
                            <button class="btn"><i class="fa fa-remove"></i></button>
                        </div>
                        <div class="btn-sub-topics">
                            <p>Onderhandelen</p>
                            <button class="btn"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                    <div class="content-add-sub-topics" >
                        <form action="">
                            <div class="form-group mb-4">
                                <label class="label-sub-topics">First Choose Your topics </label>
                                <div class="formModifeChoose">
                                    <select name="" id="autocomplete" class="multipleSelect2" multiple="true">
                                        <option value="(Detail) Handel">(Detail) Handel</option>
                                        <option value="Agrarisch">Agrarisch / Groen</option>
                                        <option value="Bouw">Bouw</option>
                                        <option value="Cultureel">Cultureel</option>
                                        <option value="Digital">Digital</option>
                                        <option value="Financieel">Financieel / Juridisch</option>
                                        <option value="Horeca">Horeca</option>
                                        <option value="IT / Data">IT / Data</option>
                                        <option value="Media">Media</option>
                                        <option value="Onderwijs">Onderwijs / Wetenschap</option>
                                    </select>
                                </div>
                            </div>
                            <div class="block-sub-topics">
                                <label class="label-sub-topics">Choose Your sub-topics </label>
                                <div class="select-buttons-container" id="selectButtonsContainer">
                                    <button class="select-button" data-value="option1">Option 1</button>
                                    <button class="select-button" data-value="option2">Option 2</button>
                                    <button class="select-button" data-value="option3">Option 3</button>
                                    <button class="select-button" data-value="option4">Option 4</button>
                                    <button class="select-button" data-value="option5">Option 5</button>
                                </div>
                                <button class="btn btn-save" type="button">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal show teacher -->
    <div class="modal fade" id="showTeacher" tabindex="-1" role="dialog" aria-labelledby="showTeacherLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sub-topics</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center head-for-body">
                        <p class="btn-sub-title-topics" id="removeTeacher" type="button">Remove</p>
                        <p class="text-or">Or</p>
                        <button class="btn btn-add-sub-topics" id="addTeacher" type="button">Add teacher</button>
                    </div>
                    <div class="block-to-show-teacher">
                        <div class="element-teacher-block d-flex justify-content-between align-items-center">
                            <div class="element-teacher d-flex align-items-center">
                                <div class="block-img">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Seydou.png" alt="" srcset="">
                                </div>
                                <p class="name">Seydou Diallo</p>
                                <hr>
                                <p class="other-element">LiveLearn</p>
                                <hr>
                                <p class="other-element">Head of front-end</p>
                            </div>
                            <button class="btn btn-remove-teacher">
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>
                        <div class="element-teacher-block d-flex justify-content-between align-items-center">
                            <div class="element-teacher d-flex align-items-center">
                                <div class="block-img">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Seydou.png" alt="" srcset="">
                                </div>
                                <p class="name">Seydou Diallo</p>
                                <hr>
                                <p class="other-element">LiveLearn</p>
                                <hr>
                                <p class="other-element">Head of front-end</p>
                            </div>
                            <button class="btn btn-remove-teacher">
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>
                        <div class="element-teacher-block d-flex justify-content-between align-items-center">
                            <div class="element-teacher d-flex align-items-center">
                                <div class="block-img">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Seydou.png" alt="" srcset="">
                                </div>
                                <p class="name">Seydou Diallo</p>
                                <hr>
                                <p class="other-element">LiveLearn</p>
                                <hr>
                                <p class="other-element">Head of front-end</p>
                            </div>
                            <button class="btn btn-remove-teacher">
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>
                    </div>

                    <div class="block-to-add-teacher">
                        <form action="">
                            <div class="form-group mb-4">
                                <label class="label-sub-topics">First Choose Your topics </label>
                                <div class="formModifeChoose">
                                    <select name="" id="autocomplete" class="multipleSelect2" multiple="true">
                                        <option value="Seydou">Seydou</option>
                                        <option value="Mohamed">Mohamed</option>
                                        <option value="Fallou">Fallou</option>
                                    </select>
                                </div>
                            </div>
                            <div class="block-sub-topics">
                                <label class="label-sub-topics">Choose Your sub-topics </label>
                                <div class="select-buttons-container" id="selectButtonsContainer">
                                    <button class="select-button" data-value="option1">Option 1</button>
                                    <button class="select-button" data-value="option2">Option 2</button>
                                    <button class="select-button" data-value="option3">Option 3</button>
                                    <button class="select-button" data-value="option4">Option 4</button>
                                    <button class="select-button" data-value="option5">Option 5</button>
                                </div>
                                <button class="btn btn-save" type="button">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal add show ccompany-->
    <div class="modal fade" id="showCompany" tabindex="-1" role="dialog" aria-labelledby="showCompanyLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showCompanyLabel">Connect with Company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <form action="">
                        <div class="form-group mb-4">
                            <label class="label-sub-topics">Select Company(s) </label>
                            <div class="formModifeChoose">
                                <select name="" id="autocomplete" class="multipleSelect2" multiple="true">
                                    <option value="Livelearn">Livelearn</option>
                                    <option value="Sales-force">Sales force</option>
                                    <option value="Bmw">Bmw</option>
                                    <option value="Apple">Apple</option>
                                    <option value="Orange">Orange</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-save" type="button">Save</button>
                    </form>
                </div>
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
<!--script>
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
</script-->
<script>
    // PHP data passed to JavaScript as an array
    

    const rowsPerPage = 20;
    let currentPage = 1;

    function displayTable(page) {
        const table = document.getElementById("myTable");
        const tbody = document.getElementById("autocomplete_company_databank");
        const startIndex = (page - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const slicedData = courses.slice(startIndex, endIndex);

        // Clear existing table rows
        tbody.innerHTML = "";

        // Add new rows to the table
        slicedData.forEach(course => {
            const row = tbody.insertRow();
            row.classList.add("pagination-element-block");
            row.innerHTML = `
                <td>
                    <div class="for-img">
                        <img src="<?php echo $course->image; ?>" alt="" srcset="">
                    </div>
                </td>
                <td class="textTh text-left first-td-databank">
                    <a style="color:#212529;font-weight:bold" href=""><?php echo $course->titel; ?></a>
                </td>
                <td class="textTh"><?php echo $course->type; ?></td>
                <td class="textTh td_subtopics">
                    ${course.prijs ? course.prijs : 'Free'}
                </td>
                <td class="textTh block-pointer">
                    ${course.onderwerpen ? `
                        <div class="d-flex content-subtopics bg-element" data-toggle="modal" data-target="#showTopics" type="button">
                            ${course.onderwerpen.map(value => `<p>${value}</p>`).join('')}
                        </div>
                    ` : ''}
                </td>
                <td class="textTh ">
                    <div class="bg-element">
                        <p><?php echo $course->created_at; ?></p>
                    </div>
                </td>
                <td class="textTh block-pointer">
                    <div class="d-flex content-teacher" data-toggle="modal" data-target="#showTeacher" type="button">
                        ${course.author_id ? `<img src="${course.image_author}" alt="image course" width="25" height="25">` : ''}
                    </div>
                </td>
                <td class="textTh block-pointer">
                    <div class="d-flex content-company" data-toggle="modal" data-target="#showCompany" type="button">
                        ${course.company ? '' : 'company'}
                        ${course.company ? `<img src="${course.company_logo}" alt="image course" width="25" height="25">` : '<b>No company</b>'}
                    </div>
                </td>
                <td class="textTh">
                    <div class="bg-element">
                        <p>${course.status}</p>
                    </div>
                </td>
                <td class="textTh">
                    <div class="bg-element">
                        <p>${course.views}</p>
                    </div>
                </td>
                <td class="textTh">
                    <div class="dropdown text-white">
                        <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                            <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                        </p>
                        <ul class="dropdown-menu">
                            <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="" target="_blank">Bekijk</a></li>
                        </ul>
                    </div>
                </td>
            `;
        });

        // Update pagination
        updatePagination(page);
    }

    function updatePagination(currentPage) {
        const pageCount = Math.ceil(courses.length / rowsPerPage);
        const paginationContainer = document.getElementById("pagination-container");
        paginationContainer.innerHTML = "";

        for (let i = 1; i <= pageCount; i++) {
            const pageLink = document.createElement("a");
            pageLink.href = "#";
            pageLink.innerText = i;
            pageLink.onclick = function () {
                displayTable(i);
            };
            if (i === currentPage) {
                pageLink.style.fontWeight = "bold";
            }
            paginationContainer.appendChild(pageLink);
            paginationContainer.appendChild(document.createTextNode(" "));
        }
    }

    // Initial display
    displayTable(currentPage);
</script>

<!--script>
    document.addEventListener("DOMContentLoaded", function() {
        const itemsPerPage = 10; // Nombre d'éléments par page
        const $rows = document.querySelectorAll('.pagination-element-block');
        const pageCount = Math.ceil($rows.length / itemsPerPage); // Nombre total de pages
        let currentPage = 1; // Page actuelle

        function showPage(page) {
            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;

            $rows.forEach(function(row, index) {
                if (index >= startIndex && index < endIndex) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function createPaginationButtons() {
            const $paginationContainer = document.getElementById('pagination-container');

            for (let i = 1; i <= pageCount; i++) {
                const $button = document.createElement('button');
                $button.textContent = i;
                $button.addEventListener('click', function() {
                    currentPage = i;
                    showPage(currentPage);
                    updatePaginationButtons();
                });
                $paginationContainer.appendChild($button);
            }
        }

        function updatePaginationButtons() {
            const $buttons = document.querySelectorAll('#pagination-container button');
            $buttons.forEach(function(button, index) {
                if (index + 1 === currentPage) {
                    button.classList.add('active');
                } else {
                    button.classList.remove('active');
                }
            });
        }

        showPage(currentPage);
        createPaginationButtons();
    });
</script-->


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



<?php get_footer(); ?>
<?php wp_footer(); ?>