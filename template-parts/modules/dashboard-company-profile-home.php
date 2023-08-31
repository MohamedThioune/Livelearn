
<?php
     
    /*
    ** Categories - all  * 
    */

    $categories = array();

    $cats = get_categories( 
        array(
        'taxonomy'   => 'course_category',  //Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude'    => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) 
    );

    foreach($cats as $category){
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($categories, $category);
    }

    $subtopics = array();
     
    foreach($categories as $categ){
        //Topics
        $topicss = get_categories(
            array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categ,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ) 
        );

        foreach ($topicss as  $value) {
            $subtopic = get_categories( 
                 array(
                 'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                 'parent'  => $value->cat_ID,
                 'hide_empty' => 0,
                  //  change to 1 to hide categores not having a single post
                ) 
            );
            $subtopics = array_merge($subtopics, $subtopic);      
        }
    }

    $user = get_users(array('include'=> $_GET['id']))[0]->data;

    //Skills 
    $topics_external = get_user_meta($user->ID, 'topic');
    $topics_internal = get_user_meta($user->ID, 'topic_affiliate');

    $topics = array();
    if(!empty($topics_external))
        $topics = $topics_external;

    if(!empty($topics_internal))
        foreach($topics_internal as $value)
            array_push($topics, $value);

    //Note
    $skills_note = get_field('skills', 'user_' . $user->ID);

?>
<!-- Latest BS-Select compiled and minified CSS/JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
<div class="contentProilView">
    <div class="head-profil-company"></div>
    <div class="content-general-info d-flex">
        <div class="content-img-profil">
            <img src="<?php echo $image;?>" alt="">
        </div>
        <div class="other-general-info">
            <p class="name">Mobina Mirbagheri</p>
            <p class="professionCandidat">Manager</p>
            <p class="company">Company : <span>Livelearn Team</span></p>
        </div>
    </div>

    <div id="tab-url1">

        <ul class="nav">
            <li class="nav-one"><a href="#Over" class="current">Over</a></li>
            <li class="nav-two"><a href="#Skills">Skills</a></li>
            <li class="nav-three"><a href="#Verplichte-training">To Do’s</a></li>
            <li class="nav-four "><a href="#Certificaten">Certificaten</a></li>
            <li class="nav-five "><a href="#Statistieken">Statistieken</a></li>
            <li class="nav-seven "><a href="#Interne-groei">Interne groei</a></li>
            <li class="nav-eight last"><a href="#Externe-groei">Externe groei</a></li>
            <li class="nav-eight last"><a href="#Feedback">Feedback</a></li>
        </ul>

        <div class="list-wrap">

            <ul id="Over">
                <div class="element-over">
                    <div class="sub-head-over d-flex align-items-center">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_about.svg" alt="">
                        <h2>ABOUT</h2>
                    </div>
                    <p class="text-about-profil">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo con.
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatu.
                        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id es nisi ut
                        aliquip ex ea commodo con. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                        nulla pariatu.
                        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id es</p>
                    <div class="d-flex group-other-info flex-wrap">
                        <div class="d-flex element-content-other-info">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/ic_baseline-phone.svg" alt="">
                            <p>(123)33 123 234</p>
                        </div>
                        <div class="d-flex element-content-other-info">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/ic_baseline-email.svg" alt="">
                            <p>user@email.domain</p>
                        </div>
                        <div class="d-flex element-content-other-info">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/bxs_map.svg" alt="">
                            <p>50 rue Rambuteau à Paris 3e – 6 salles</p>
                        </div>
                    </div>
                </div>

                <div class="element-over">
                    <div class="sub-head-over d-flex align-items-center">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/ic_outline-work.svg" alt="">
                        <h2>EXPERIENCE</h2>
                    </div>
                    <div class="one-experience d-flex align-items-center">
                        <div class="">
                            <p class="name-company">Apple</p>
                            <p class="profession">Software developer engineer</p>
                        </div>
                        <p class="date">2020-2021</p>
                    </div>
                    <div class="one-experience d-flex align-items-center">
                        <div class="">
                            <p class="name-company">Apple</p>
                            <p class="profession">Software developer engineer</p>
                        </div>
                        <p class="date">2020-2021</p>
                    </div>
                    <div class="one-experience d-flex align-items-center">
                        <div class="">
                            <p class="name-company">Apple</p>
                            <p class="profession">Software developer engineer</p>
                        </div>
                        <p class="date">2020-2021</p>
                    </div>
                </div>

                <div class="element-over element-over-education">
                    <div class="sub-head-over d-flex align-items-center">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/zondicons_education.svg" alt="">
                        <h2>EDUCATION</h2>
                    </div>
                    <div class="one-experience d-flex align-items-center">
                        <div class="">
                            <p class="name-company">Apple</p>
                            <p class="profession">Software developer engineer</p>
                        </div>
                        <p class="date">2020-2021</p>
                    </div>
                    <div class="one-experience d-flex align-items-center">
                        <div class="">
                            <p class="name-company">Apple</p>
                            <p class="profession">Software developer engineer</p>
                        </div>
                        <p class="date">2020-2021</p>
                    </div>
                    <div class="one-experience d-flex align-items-center">
                        <div class="">
                            <p class="name-company">Apple</p>
                            <p class="profession">Software developer engineer</p>
                        </div>
                        <p class="date">2020-2021</p>
                    </div>
                </div>

                <div class="element-over">
                    <div class="sub-head-over d-flex align-items-center">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/dashicons_portfolio.svg" alt="">
                        <h2>PORTFOLIO</h2>
                    </div>
                    <div class="one-portfolio">
                        <p class="name-portfolio">Projet Alakham</p>
                        <p class="description-portfolio">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.
                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo con.
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatu.
                            Excepteur sint occaecat cupidatat non proident, sunt in</p>
                        <p class="link-portfolio">Link : <span>www.alkham.com</span></p>
                    </div>
                    <div class="one-portfolio">
                        <p class="name-portfolio">Projet Alakham</p>
                        <p class="description-portfolio">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.
                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo con.
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatu.
                            Excepteur sint occaecat cupidatat non proident, sunt in</p>
                        <p class="link-portfolio">Link : <span>www.alkham.com</span></p>
                    </div>
                    <div class="one-portfolio">
                        <p class="name-portfolio">Projet Alakham</p>
                        <p class="description-portfolio">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.
                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo con.
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatu.
                            Excepteur sint occaecat cupidatat non proident, sunt in</p>
                        <p class="link-portfolio">Link : <span>www.alkham.com</span></p>
                    </div>
                </div>
            </ul>

            <ul id="Skills" class="hide">
                <div class="content-card-skills content-card-skills-profil">
                    <div class="card-skills">
                        <div class="group position-relative">
                            <span class="donut-chart has-big-cente">40</span>
                        </div>
                        <p class="name-course">Accountancy</p>
                    </div>
                    <div class="card-skills">
                        <div class="group position-relative">
                            <span class="donut-chart has-big-cente">30</span>
                        </div>
                        <p class="name-course">Accountancy</p>
                    </div>
                    <div class="card-skills">
                        <div class="group position-relative">
                            <span class="donut-chart has-big-cente">10</span>
                        </div>
                        <p class="name-course">Accountancy</p>
                    </div>
                    <div class="card-skills">
                        <div class="group position-relative">
                            <span class="donut-chart has-big-cente">90</span>
                        </div>
                        <p class="name-course">Accountancy</p>
                    </div>
                    <div class="card-skills">
                        <div class="group position-relative">
                            <span class="donut-chart has-big-cente">50</span>
                        </div>
                        <p class="name-course">Accountancy</p>
                    </div>
                    <div class="card-skills">
                        <div class="group position-relative">
                            <span class="donut-chart has-big-cente">10</span>
                        </div>
                        <p class="name-course">Accountancy</p>
                    </div>

                </div>
            </ul>

            <ul id="Verplichte-training" class="hide">
                <div class="sub-to-do d-flex justify-content-between align-items-center">
                    <p class="text-to-do-for">To do’s for Mamadou</p>
                    <button class="btn btn-add-to-do" type="button" data-toggle="modal" data-target="#to-do-Modal">Add to do</button>

                    <!-- Modal Add to do -->

                    <div class="modal fade" id="to-do-Modal" tabindex="-1" role="dialog" aria-labelledby="to-do-ModalModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="MandatoryModalLabel">To do</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-Submit" form="mandatory-form" name="mandatory_course">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="body-content-to-do">

                    <div class="content-tab">
                        <div class="content-button-tabs">
                            <button  data-tab="All" class="b-nav-tab btn active">
                                All <span class="number-content">14</span>
                            </button>
                            <button  data-tab="Activiteiten" class="b-nav-tab btn">
                                Activiteiten <span class="number-content">2</span>
                            </button>
                            <button  data-tab="Plannen" class="b-nav-tab btn">
                                Plannen <span class="number-content">5</span>
                            </button>
                            <button  data-tab="Onderwerpen" class="b-nav-tab btn">
                                Onderwerpen <span class="number-content">2</span>
                            </button>
                            <button  data-tab="Courses" class="b-nav-tab btn">
                                Courses <span class="number-content">4</span>
                            </button>
                            <button  data-tab="empty" class="b-nav-tab btn">
                                Empty <span class="number-content">O</span>
                            </button>
                        </div>

                        <div id="All" class="b-tab active contentBlockSetting">
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">To do</th>
                                    <th scope="col">What</th>
                                    <th scope="col">Progress</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Due-date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">PoP</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        50 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="50"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        20 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="20"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert3.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        80 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="80"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">PoP</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        50 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="50"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        20 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="20"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert3.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        80 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="80"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">PoP</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        50 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="50"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        20 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="20"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert3.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        80 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="80"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div id="Activiteiten" class="b-tab contentBlockSetting">
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">To do</th>
                                    <th scope="col">What</th>
                                    <th scope="col">Progress</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Due-date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">PoP</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        50 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="50"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        20 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="20"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <div id="Plannen" class="b-tab contentBlockSetting">
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">To do</th>
                                    <th scope="col">What</th>
                                    <th scope="col">Progress</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Due-date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">PoP</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        50 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="50"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        20 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="20"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert3.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        80 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="80"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        20 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="20"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert3.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        80 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="80"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div id="Onderwerpen" class="b-tab contentBlockSetting">
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">To do</th>
                                    <th scope="col">What</th>
                                    <th scope="col">Progress</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Due-date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">PoP</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        50 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="50"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        20 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="20"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <div id="Courses" class="b-tab contentBlockSetting">
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">To do</th>
                                    <th scope="col">What</th>
                                    <th scope="col">Progress</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Due-date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">PoP</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        50 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="50"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        20 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="20"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert3.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        80 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="80"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert3.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b>You</b>  25 AUG 2023 | 09:23  </p>
                                                    <p class="text-date mb-0">Schrijf je eigen Persoonlijk ontwikkelplan.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element">Podcast</p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        80 <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="80"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td>
                                        <td class="textTh">
                                            <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div id="empty" class="b-tab aa contentBlockSetting">
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                    <tr>
                                    <th scope="col courseTitle">To do</th>
                                    <th scope="col">What</th>
                                    <th scope="col">Progress</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Due-date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">

                                </tbody>
                            </table>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <a href="" class="btn btn-creer-eeen">Creëer een eerste to do</a>
                            </div>
                        </div>

                    </div>

                </div>
            </ul>

            <ul id="Certificaten" class="hide">d</ul>

            <ul id="Statistieken" class="hide">e</ul>

            <ul id="Interne-groei" class="hide">f</ul>

            <ul id="Externe-groei" class="hide">g</ul>

            <ul id="Feedback" class="hide">h</ul>


        </div> <!-- END List Wrap -->

    </div>



   <!-- <div class="row">
        <div class="col-md-12">
            <div id="profilVIewDetail" class="detailContentCandidat">
                <div>
                    <?php
/*
                    if(isset($_GET['message'])) if($_GET['message']) echo "<span class='alert alert-success alert-dismissible fade show' role='alert'>" . $_GET['message'] . "</span>"; */?>
                    <div class="overviewFirstBlock">
                        <div class="blockImageCandidat">
                            <img src="<?php /*echo $image; */?>" alt="">
                        </div>
                        <div class="overviewSecondBlock">
                            <p class="professionCandidat"><?php /*if(isset($user->first_name) && isset($user->last_name)) echo $user->first_name . '' . $user->last_name; else echo $user->display_name*/?>
                            <p class="professionCandidat"><?php /*if(isset($user->email)) echo $user->email; */?></p>
                            <?php /*if($country) { */?>
                                <p class="professionCandidat"><?php /*echo $country; */?></p>
                            <?php /*} */?>
                        </div>
                        <div class="overviewTreeBlock">
                            <p class="titleOvervien">Manager : <span><?php /*if(isset($superior->first_name) && isset($superior->last_name)) echo $superior->first_name . '' . $superior->last_name; else echo $superior->display_name; */?></span></p>
                            <p class="titleOvervien">Company : <span><?php /*echo $company_name; */?></span></p>
                        </div>
                        <br>
                        <div class="overviewFourBlock">
                            <?php /*if($experience){ */?>

                                <div class="d-flex">
                                    <p class="nameOtherSkill">Experience : <span><?php /*echo $experience; */?></span></p>
                                </div>
                            <?php /*} if($languages){ */?>

                                <div class="d-flex">
                                    <p class="nameOtherSkill">Language :
                                        <span>
                                                        <?php
/*                                                        foreach($languages as $key => $language){
                                                            echo $language;
                                                            if(isset($languages[$key+1]))
                                                                echo ", ";
                                                        }
                                                        */?>
                                                    </span>
                                    </p>
                                </div>
                                <br>
                            <?php /*} */?>
                        </div>
                    </div>

                </div>


                <div class="content-tab">
                    <div class="content-button-tabs">
                        <button  data-tab="Over" class="b-nav-tab btn active">
                           Over
                        </button>
                        <button  data-tab="Skills" class="b-nav-tab btn">
                            Skills
                        </button>
                        <button  data-tab="Mandatory" class="b-nav-tab btn">
                            Verplichte training
                        </button>
                        <button  data-tab="Certificaten" class="b-nav-tab btn">
                            Certificaten
                        </button>
                        <button  data-tab="Statistieken" class="b-nav-tab btn">
                            Statistieken
                        </button>
                        <button  data-tab="Interne-groei" class="b-nav-tab btn">
                            Interne groei
                        </button>
                        <button  data-tab="Externe-groei" class="b-nav-tab btn">
                            Externe groei
                        </button>
                        <button  data-tab="Feedback" class="b-nav-tab btn">
                            Feedback
                        </button>
                    </div>

                    <div id="Over" class="b-tab active contentBlockSetting">
                        <div class="content">
                            <p class="textDetailCategorie"><?php /*echo $biographical_info;  */?></p>
                            <?php
/*                            if($educations){
                                */?>
                                <div class="categorieDetailCandidat">
                                    <h2 class="titleCategorieDetailCandidat">Education</h2>
                                    <?php
/*                                    foreach($educations as $value) {
                                        $value = explode(";", $value);
                                        if(isset($value[2]))
                                            $year = explode("-", $value[2])[0];
                                        if(isset($value[3]))
                                            if(intval($value[2]) != intval($value[3]))
                                                $year = $year . "-" .  explode("-", $value[3])[0];
                                        */?>
                                        <div class="contentEducationCandidat">
                                            <div class="titleDateEducation">
                                                <p class="titleCoursCandiddat"><?php /*echo $value[1]; */?></p>
                                                <?php /*if($year) { */?>
                                                    <p class="dateCourCandidat"><?php /*echo $year; */?></p>
                                                <?php /*} */?>
                                            </div>
                                            <p class="schoolCandidat"><?php /*echo $value[0]; */?></p>
                                            <p class="textDetailCategorie"><?php /*echo $value[4]?: ''; */?></p>
                                        </div>
                                    <?php /*} */?>
                                </div>
                                <?php
/*                            }
                            */?>

                            <?php
/*                            if($experiences){
                                */?>
                                <div class="categorieDetailCandidat workExperiece">
                                    <h2 class="titleCategorieDetailCandidat ex">Work & Experience</h2>
                                    <?php
/*                                    if($experiences)
                                        if(!empty($experiences))
                                            foreach($experiences as $value) {
                                                $value = explode(";", $value);
                                                if(isset($value[2]))
                                                    $year = explode("-", $value[2])[0];
                                                if(isset($value[3]))
                                                    if(intval($value[2]) != intval($value[3]))
                                                        $year = $year . "-" .  explode("-", $value[3])[0];
                                                */?>
                                                <div class="contentEducationCandidat">
                                                    <div class="titleDateEducation">
                                                        <p class="titleCoursCandiddat"><?php /*echo $value[1]; */?></p>
                                                        <?php /*if($year) { */?>
                                                            <p class="dateCourCandidat"><?php /*echo $year; */?></p>
                                                        <?php /*} */?>
                                                    </div>
                                                    <p class="schoolCandidat"><?php /*echo $value[0]; */?></p>
                                                    <p class="textDetailCategorie"><?php /*echo $value[4]?: '' */?> </p>
                                                </div>

                                            <?php /*} */?>
                                </div>
                                <?php
/*                            }
                            */?>
                        </div>
                    </div>

                    <div id="Skills" class="b-tab contentBlockSetting">
                        <div class="content">
                            <?php
/*                            if(!empty($topics_user)){
                                foreach($topics_user as $value){
                                    $topic = get_the_category_by_ID($value);
                                    $note = 0;
                                    if(!$topic)
                                        continue;
                                    if(!empty($skills_note))
                                        foreach($skills_note as $skill)
                                            if($skill['id'] == $value)
                                                $note = $skill['note'];
                                    $name_topic = (String)$topic;
                                    */?>
                                    <div class="skillbars">
                                        <label class="skillName"><?php /*echo $name_topic;  */?></label>
                                        <div class="progress" data-fill="<?php /*= $note */?>" >
                                        </div>
                                    </div>
                                <?php /*}
                            }else {
                                echo "<p class='textDetailCategorie'>we do not have statistics at this time </p>";
                            }
                            */?>
                        </div>
                    </div>

                    <div id="Mandatory" class="b-tab contentBlockSetting">
                        <div class="content">

                            <button type="button" class="btn btnAddToDo" data-toggle="modal" data-target="#MandatoryModal">
                                Een verplichte cursus toevoegen
                            </button>


                            <div class="modal fade" id="MandatoryModal" tabindex="-1" role="dialog" aria-labelledby="MandatoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="MandatoryModalLabel">Verplichte training Sharing</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" id="mandatory-form" action="">
                                                <div class="form-group">
                                                    <label for="maneMandatory">Name</label>
                                                    <input type="text" class="form-control" id="maneMandatory" aria-describedby="maneMandatoryHelp" placeholder="Enter name of the mandatory" form="mandatory-form" name="name_mandatory" required>
                                                </div>
                                                <div class="form-group" id="">
                                                    <label class="sub-label">Select internal course or external course</label>
                                                    <select class="form-select select-internal-external mb-0" aria-label="Default" id="starter-select-course" >
                                                        <option value="0" selected>Select</option>
                                                        <option value="internal">Internal course</option>
                                                        <option value="external">External course</option>
                                                    </select>
                                                </div>
                                                <div class="form-group" id="autocomplete_select_course">
                                                
                                                </div>
                                                <div class="form-group">
                                                    <label for="dateDone">Has to be done Before</label>
                                                    <input type="date" class="form-control" id="dateDone" placeholder="choose date" form="mandatory-form" name="done_must">
                                                </div>

                                                <div class="form-group">
                                                    <label for="dateValid">Valid for (days)</label>
                                                    <input type="number" class="form-control" id="amount" placeholder="7 days" form="mandatory-form" name="valid_must">
                                                </div>

                                                <div class="form-group">
                                                    <label for="amount">Amount of points </label>
                                                    <input type="number" class="form-control" id="amount" placeholder="456" form="mandatory-form" name="point_must">
                                                </div>

                                                <div class="form-group">
                                                    <textarea class="message-area" form="mandatory-form" name="message_must" id="" cols="30" rows="10"></textarea>
                                                </div>

                                                <input type="hidden" name="user_must" form="mandatory-form"  value="<?php /*= $user->ID */?>">

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-Submit" form="mandatory-form" name="mandatory_course">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="Certificaten" class="b-tab contentBlockSetting">
                        <div class="content">
                            <div class="categorieDetailCandidat workExperiece">
                                <?php
/*                                if($awards){
                                    if(!empty($awards))
                                        foreach($awards as $value) {
                                            $value = explode(";", $value);
                                            $year_start = explode("-", $value[2])[0];
                                            $year_end = explode("-", $value[3])[0];
                                            if($year_start && !$year_end)
                                                $year = $year_start;
                                            else if($year_end && !$year_start)
                                                $year = $year_end;
                                            else if($year_end != $year_start)
                                                $year = $year_start .'-'. $year_end;
                                            */?>
                                            <div class="contentEducationCandidat">
                                                <div class="titleDateEducation">
                                                    <p class="titleCoursCandiddat"><?php /*echo $value[0]; */?> </p>
                                                    <?php /*if($year) { */?>
                                                        <p class="dateCourCandidat"><?php /*echo $year; */?></p>
                                                    <?php /*} */?>
                                                </div>
                                                <p class="textDetailCategorie"><?php /*echo $value[1]; */?></p>
                                            </div>
                                            <?php
/*                                        }
                                }
                                else
                                    echo "<p class='textDetailCategorie'>we do not have statistics at this time </p>";
                                */?>

                            </div>
                        </div>
                    </div>

                    <div id="Statistieken" class="b-tab contentBlockSetting">
                        <div class="content">
                            <h2 class="titleCategorieDetailCandidat ex">Statistic</h2>
                            <p class="textDetailCategorie">we do not have statistics at this time </p>
                        </div>
                    </div>

                    <div id="Interne-groei" class="b-tab contentBlockSetting">
                        <div class="content">
                            <form action="" method="POST">

                                <div class="form-group formModifeChoose">

                                    <select class="multipleSelect2" name="selected_subtopics[]" multiple="true" required>
                                        <?php
/*                                        //Subtopics
                                        foreach($subtopics as $value){
                                            echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                        }
                                        */?>
                                    </select>
                                    <input type="hidden" name="manager" value=<?php /*=$manager->ID*/?> >
                                    <input type="hidden" name="id_user" value=<?php /*=$user->ID*/?> >
                                    <button name="add_internal_growth" class="btn btnVoegTab " type="submit">Voeg toe</button>
                                </div>

                                <?php
/*                                if (!empty (get_user_meta($user->ID,'topic_affiliate')))
                                {
                                    $internal_growth_subtopics= get_user_meta($user->ID,'topic_affiliate');
                                    */?>

                                    <div class="inputGroein">
                                        <?php
/*                                        foreach($internal_growth_subtopics as $value){
                                            echo "
                                                <form action='/dashboard/user/' method='POST'>
                                                <input type='hidden' name='meta_value' value='". $value . "' id=''>
                                                <input type='hidden' name='user_id' value='". $user->ID . "' id=''>
                                                <input type='hidden' name='meta_key' value='topic_affiliate' id=''>";
                                            echo "<p> <button type='submit' name='delete' style='border:none;background:#C7D8F5'><i style='font-size 0.5em; color:white'class='fa fa-trash'></i>&nbsp;".(String)get_the_category_by_ID($value)."</button></p>";
                                            echo "</form>";

                                            */?>


                                            <?php
/*                                        }
                                        */?>
                                    </div>

                                    <?php
/*                                }else {
                                    echo "<p>No topics yet</p>" ;
                                }
                                */?>
                            </form>
                        </div>
                    </div>

                    <div id="Externe-groei" class="b-tab contentBlockSetting">
                        <div class="content">
                            <div class="inputGroein">

                                <?php
/*                                if (!empty (get_user_meta($user->ID,'topic')))
                                {
                                    $external_growth_subtopics = get_user_meta($user->ID,'topic');
                                    */?>

                                    <div class="inputGroein">
                                        <?php
/*                                        foreach($external_growth_subtopics as $value){
                                            echo "<p>".(String)get_the_category_by_ID($value)."</p>";
                                        }

                                        */?>
                                    </div>

                                    <?php
/*                                }else {
                                    echo "<p>No topics yet</p>" ;
                                }
                                */?>

                            </div>
                        </div>
                    </div>

                    <div id="Feedback" class="b-tab contentBlockSetting">
                        <div class="content">
                            <div class="addBlockComment">
                                <div class="otherSkills">
                                    <button class="btn btnAddToDo"  data-toggle="modal" data-target="#exampleModalWork">Toevoegen om te doen</button>
                                    <?php
/*                                    if(!empty($todos))
                                        foreach($todos as $key=>$todo) {
                                            if($key == 8)
                                                break;

                                            $type = get_field('type_feedback', $todo->ID);
                                            $manager = get_field('manager_feedback', $todo->ID);

                                            $image = get_field('profile_img',  'user_' . $manager->ID);
                                            if(!$image)
                                                $image = get_stylesheet_directory_uri() . '/img/Group216.png';

                                            if($type == "Feedback" || $type == "Compliment")
                                                $beschrijving_feedback = get_field('beschrijving_feedback', $todo->ID);
                                            else if($type == "Persoonlijk ontwikkelplan")
                                                $beschrijving_feedback = get_field('opmerkingen', $todo->ID);
                                            else if($type == "Beoordeling Gesprek")
                                                $beschrijving_feedback = get_field('algemene_beoordeling', $todo->ID);

                                            */?>
                                            <div class="activiteRecent">
                                                <img width="25" src="<?php /*echo $image */?>" alt="">
                                                <div class="contentRecentActivite">
                                                    <div class="titleActivite"><?php /*=$todo->post_title;*/?> by <span style="font-weight:bold">
                                                    <?php
/*                                                    if(isset($manager->first_name)) echo $manager->first_name ; else echo $manager->display_name;
                                                    */?>
                                                    </span>
                                                    </div>
                                                    <p class="activiteRecentText"><?php /*if($beschrijving_feedback) echo $beschrijving_feedback; else echo ""; */?></p>
                                                </div>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <form action="" method="POST">
                                                    <input type="hidden" name="id" value="<?php /*echo $todo->ID; */?>">
                                                    <input type="hidden" name="user_id" value="<?php /*echo $user->ID; */?>">
                                                    <button class="btn btn-removeAdd"  name="delete_todos" type="submit">
                                                        <img src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/trash.png" alt="remove-Image">
                                                    </button>
                                                </form>
                                            </div>
                                        <?php /*}

                                    */?>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>-->
    <!-- Modal  -->
    <div class="modal modalEdu fade show" id="exampleModalWork" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 93% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nieuw toevoegen </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="firstBlockVoeg">
                        <h2 class="voegToeText">Voeg toe</h2>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="boxVoeg" id="boxVoeg1">
                                    <div class="imgoxVoeg">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/feedback.png" alt="">
                                    </div>
                                    <p class="titleBoxVoeg">Feedback</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="boxVoeg" id="boxVoeg2">
                                    <div class="imgoxVoeg">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/personal-development.png" alt="">
                                    </div>
                                    <p class="titleBoxVoeg">Persoonlijk Ontwikkelplan</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="boxVoeg" id="boxVoeg3">
                                    <div class="imgoxVoeg">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/personal-development2.png" alt="">
                                    </div>
                                    <p class="titleBoxVoeg">Beoordeling Gesprek</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="boxVoeg" id="boxVoeg4">
                                    <div class="imgoxVoeg">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/conversation.png" alt="">
                                    </div>
                                    <p class="titleBoxVoeg">Compliment</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="secondBlockVoeg">
                        <form action="/dashboard/company/profile" method="POST">
                            <h2 class="voegToeText">Voeg toe</h2>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Title feedback</label>
                                    <input name="title_feedback" type="text" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Onderwerp feedback</label>
                                    <div class="form-group formModifeChoose">
                                        <select id="form-control-skills" name="onderwerp_feedback[]"  class="multipleSelect2" multiple="true" required>

                                            <?php
                                            //Subtopics
                                            foreach($subtopics as $value){
                                                echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Beschrijving</label>
                                    <textarea name="beschrijving_feedback" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div>

                                <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                <input type="hidden" name="id_user" value=<?=$user->ID?> >
                                <input type="hidden" name="type" value="Feedback">
                            </div>
                            <div class="">
                                <button class="btn btnSaveSetting" name="add_todo_feedback" >Save</button>
                            </div>
                    </div>
                    </form>
                    <div class="treeBlockVoeg">
                        <form action="/dashboard/company/profile" method="POST">
                            <h2 class="voegToeText">Persoonlijk ontwikkelplan</h2>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Title persoonlijk ontwikkelplan</label>
                                    <input name="title_persoonlijk" type="text" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Onderwerp PoP</label>
                                    <div class="form-group formModifeChoose">
                                        <select id="form-control-skills" class="multipleSelect2" name="onderwerp_pop[]" multiple="true" required>

                                            <?php
                                            //Subtopics
                                            foreach($subtopics as $value){
                                                echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Wat wil je bereiken ?</label>
                                    <textarea name="wat_bereiken" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Hoe ga je dit bereiken ?</label>
                                    <textarea name="hoe_bereiken" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Heb je hierbij hulp nodig ?</label>
                                    <div class="d-flex">
                                        <div class="mr-3">
                                            <input type="radio" id="JA" name="hulp_radio_JA" value="JA">
                                            <label for="JA">JA</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="NEE" name="hulp_radio_JA" value="NEE">
                                            <label for="NEE">NEE</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Opmerkingen ?</label>
                                    <textarea name="opmerkingen" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="">
                                <button class="btn btnSaveSetting" name="add_todo_persoonlijk" >Save</button>
                                <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                <input type="hidden" name="id_user" value=<?=$user->ID?> >
                                <input type="hidden" name="type" value="Persoonlijk ontwikkelplan">
                            </div>
                        </form>
                    </div>
                    <form action="/dashboard/company/profile" method="POST">
                        <div class="fourBlockVoeg">
                            <div class="sousBlockFourBlockVoeg1">
                                <h2 class="voegToeText">Beoordelingsgesprek</h2>
                                <div class="col-lg-12 col-md-12">
                                    <div class="group-input-settings">
                                        <label for="">Title Beoordelingsgesprek</label>
                                        <input name="title_beoordelingsgesprek" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="group-input-settings">
                                        <label for="">Cijfers interne groei</label>


                                        <?php
                                        if (!empty (get_user_meta($user->ID,'topic_affiliate')))
                                        {
                                            $internal_growth_subtopics= get_user_meta($user->ID,'topic_affiliate');
                                            foreach($internal_growth_subtopics as $key =>  $value){

                                                echo '<div class="bloclCijfers" style="height: 52px">';
                                                echo '<p class="mb-0" style="width: 20%;">'.lcfirst((String)get_the_category_by_ID($value)).'</p>';
                                                echo '<div class="rating" id="selected_stars_'.($key+1).'">
                                                        <input type="radio" id="star5_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="5" />
                                                        <label class="star mt-4" for="star5_'.$key.'" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="star4_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="4" />
                                                        <label class="star mt-4" for="star4_'.$key.'" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="star3_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="3" />
                                                        <label class="star mt-4" for="star3_'.$key.'" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="star2_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="2" />
                                                        <label class="star mt-4" for="star2_'.$key.'" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="star1_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="1" />
                                                        <label class="star mt-4" for="star1_'.$key.'" title="Bad" aria-hidden="true"></label>
                                                    </div>';

                                                echo '<div class="">
                                                            <div hidden class="group-input-settings" id="commentaire_hidden_'.($key+1).'">
                                                                <label for="">'.lcfirst((String)get_the_category_by_ID($value)).' toelichting</label>
                                                                <textarea name="'.lcfirst((String)get_the_category_by_ID($value)).'_toelichting" id="" rows="5" cols="85"></textarea>
                                                            </div>
                                                        </div>';
                                                echo '</div>';

                                            }
                                        }

                                        ?>
                                        
                                        <!-- old rate -->
                                        <!-- <div class="rate feedback" id="selected_stars_'.($key+1).'">
                                             <input type="radio" id="star1_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="1" />
                                             <label class="ma_link" for="star1_'.$key.'" title="text">1 star</label>
                                             <input type="radio" id="star2_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="2" />
                                             <label class="ma_link" for="star2_'.$key.'" title="text">2 stars</label>
                                             <input type="radio" id="star3_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="3" />
                                             <label class="ma_link" for="star3_'.$key.'" title="text">3 stars</label>
                                             <input type="radio" id="star4_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="4" />
                                             <label class="ma_link" for="star4_'.$key.'" title="text">4 stars</label>
                                             <input type="radio" id="star5_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="5" />
                                             <label class="ma_link" for="star5_'.$key.'" title="text">5 stars</label>
                                         </div> -->


                                        <!--  the news rate get from course page -->
                                        <!-- <div class="rating">
                                            <input type="radio" id="star5" name="rating" value="5" />
                                            <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                            <input type="radio" id="star4" name="rating" value="4" />
                                            <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                            <input type="radio" id="star3" name="rating" value="3" />
                                            <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                            <input type="radio" id="star2" name="rating" value="2" />
                                            <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                            <input type="radio" id="star1" name="rating" value="1" />
                                            <label class="star" for="star1" title="Bad" aria-hidden="true"></label>
                                        </div> -->


                                    </div>

                                </div>
                                <div class="">
                                    <input type="button" value="Volgende"  class="btn btnSaveSetting" id="volgende2">
                                </div>
                            </div>

                        </div>

                        <div class="sousBlockFourBlockVoeg3">
                            <h2 class="voegToeText">Beoordelingsgesprek</h2>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Algemene beoordeling</label>
                                    <textarea name="algemene_beoordeling" id="" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="">
                                <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                <input type="hidden" name="id_user" value=<?=$user->ID?> >
                                <input type="hidden" name="type" value="Beoordeling Gesprek">
                                <input type="submit" name="add_todo_beoordelingsgesprek" value="Save"  class="btn btnSaveSetting" >
                            </div>
                        </div>
                </div>
                </form>
                <form action="/dashboard/company/profile" method="post">
                    <div class="fiveBlockVoeg">
                        <h2 class="voegToeText">Compliment</h2>
                        <div class="col-lg-12 col-md-12">
                            <div class="group-input-settings">
                                <label for="">Title compliment</label>
                                <input name="title_feedback" type="text" required>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="group-input-settings">
                                <label for="">Onderwerp compliment</label>
                                <div class="form-group formModifeChoose">
                                    <select id="form-control-skills" name="onderwerp_feedback[]" class="multipleSelect2" multiple="true" required>

                                        <?php
                                        //Subtopics
                                        foreach($subtopics as $value){
                                            echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="group-input-settings">
                                <label for="">Beschrijving compliment</label>
                                <textarea name="beschrijving_feedback" id="" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="">
                            <input type="hidden" name="manager" value=<?=$superior->ID?> >
                            <input type="hidden" name="id_user" value=<?=$user->ID?> >
                            <input type="hidden" name="type" value="Compliment">
                            <button class="btn btnSaveSetting" name="add_todo_compliment" >Save</button>
                        </div>



                    </div>
                </form>
            </div>
            <!--   <div class="modal-body">
                   <div class="row">
                       <div class="col-lg-12 col-md-12">
                           <div class="group-input-settings">
                               <label for="">Title</label>
                               <input name="job" type="text" placeholder="Engineer">
                           </div>
                       </div>
                       <div class="col-lg-12 col-md-12">
                           <div class="group-input-settings">
                               <label for="">Commentary</label>
                               <textarea name="commentary" id="" rows="4"></textarea>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="modal-footer">
                   <button class="btn btnSaveSetting" name="add_work" >Save</button>
               </div>-->

        </div>
    </div>

</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/donu-chart.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/nouislider.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/donu-chart.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/nouislider.min.js"></script>
<script src="https://rawgit.com/andreruffert/rangeslider.js/develop/dist/rangeslider.min.js"></script>

<script src="<?php echo get_stylesheet_directory_uri();?>/organictabs.jquery.js"></script>
<script>
    $(function() {

        // Calling the plugin
        $("#tab-url1").organicTabs();

    });
</script>

<script>
    document.querySelectorAll(".filters .item").forEach(function (tab, index) {
        tab.addEventListener("click", function () {
            const filters = document.querySelectorAll(".filters .item");
            const tabs = document.querySelectorAll(".tabs__list .tab");

            filters.forEach(function (tab) {
                tab.classList.remove("active");
            });
            this.classList.add("active");

            tabs.forEach(function (tabContent) {
                tabContent.classList.remove("active");
            });
            tabs[index].classList.add("active");
        });
    });

</script>

<script>
    $(document).ready(function() {
        $(".selectpicker").selectpicker();

    })
</script>

<script>
    'use strict';

    function Tabs() {
        var bindAll = function() {
            var menuElements = document.querySelectorAll('[data-tab]');
            for(var i = 0; i < menuElements.length ; i++) {
                menuElements[i].addEventListener('click', change, false);
            }
        };

        var clear = function() {
            var menuElements = document.querySelectorAll('[data-tab]');
            for(var i = 0; i < menuElements.length ; i++) {
                menuElements[i].classList.remove('active');
                var id = menuElements[i].getAttribute('data-tab');
                document.getElementById(id).classList.remove('active');
            }
        };

        var change = function(e) {
            clear();
            e.target.classList.add('active');
            var id = e.currentTarget.getAttribute('data-tab');
            document.getElementById(id).classList.add('active');
        };

        bindAll();

        //window.location.hash = target_panel_selector ;
        if(history.pushState) {
            history.pushState(null, null, target_panel_selector);
        } else {
            window.location.hash = target_panel_selector;
        }
        return false;
    }

    var connectTabs = new Tabs();

</script>

<script>
    $(document).ready(function() {
        $(".js-select2").select2();
        $(".js-select2-multi").select2();

        $(".large").select2({
            dropdownCssClass: "big-drop",
        });
    });
</script>

<script>
    
    // Afficher un champ de commentaire spécifique aprés avoir noté un topics sur le modal des feedbacks
    $(".rate.feedback").click(function() {
        var id = $(this).attr('id');
        console.log("#commentaire_hidden_"+id.substr(-1));
        $("#commentaire_hidden_"+id.substr(-1)).attr("hidden",function(n, v){
      return false;
    });
    });


    /**
     * Defines the bootstrap tabs handler.
     *
     * @param {string} element
     *  Element.
     */
    var tabsActions = function (element) {
        this.element = $(element);

        this.setup = function () {
            if (this.element.length <= 0) {
                return;
            }
            this.init();
            // Update after resize window.
            var resizeId = null;
            $(window).resize(function () {
                clearTimeout(resizeId);
                resizeId = setTimeout(() => {this.init()}, 50);
            }.bind(this));
        };

        this.init = function () {

            // Add class to overflow items.
            this.actionOverflowItems();
            var tabs_overflow = this.element.find('.overflow-tab');

            // Build overflow action tab element.
            if (tabs_overflow.length > 0) {
                if (!this.element.find('.overflow-tab-action').length) {
                    var tab_link = $('<a>')
                        .addClass('nav-link')
                        .attr('href', '#')
                        .attr('data-toggle', 'dropdown')
                        .text('...')
                        .on('click', function (e) {
                            e.preventDefault();
                            $(this).parents('.nav.nav-tabs').children('.nav-item.overflow-tab').toggle();
                        });

                    var overflow_tab_action = $('<li>')
                        .addClass('nav-item')
                        .addClass('overflow-tab-action')
                        .append(tab_link);

                    // Add hide to overflow tabs when click on any tab.
                    this.element.find('.nav-link').on('click', function (e) {
                        $(this).parents('.nav.nav-tabs').children('.nav-item.overflow-tab').hide();
                    });
                    this.element.append(overflow_tab_action);
                }

                this.openOverflowDropdown();
            }
            else {
                this.element.find('.overflow-tab-action').remove();
            }
        };

        this.openOverflowDropdown = function () {
            var overflow_sum_height = 0;
            var overflow_first_top = 41;

            this.element.find('.overflow-tab').hide();
            // Calc top position of overflow tabs.
            this.element.find('.overflow-tab').each(function () {
                var overflow_item_height = $(this).height() - 1;
                if (overflow_sum_height === 0) {
                    $(this).css('top', overflow_first_top + 'px');
                    overflow_sum_height += overflow_first_top + overflow_item_height;
                }
                else {
                    $(this).css('top', overflow_sum_height + 'px');
                    overflow_sum_height += overflow_item_height;
                }

            });
        };

        this.actionOverflowItems = function () {
            var tabs_limit = this.element.width() - 100;
            var count = 0;

            // Calc tans width and add class to any tab that is overflow.
            for (var i = 0; i < this.element.children().length; i += 1) {
                var item = $(this.element.children()[i]);
                if (item.hasClass('overflow-tab-action')) {
                    continue;
                }

                count += item.width();
                if (count > tabs_limit) {
                    item.addClass('overflow-tab');
                }
                else if (count < tabs_limit) {
                    item.removeClass('overflow-tab');
                    item.show();
                }
            }
        };
    };

    var tabsAction = new tabsActions('.layout--tabs .nav-tabs-wrapper .nav-tabs');
    tabsAction.setup();

</script>

<script>
    var course = document.getElementById('starter-select-course');
    course.addEventListener('change', function(e) {
        var type = $(this).val();

        $.ajax({
            url:"/select-course-type",
            method:"post",
            data:{
                search_type_course : type,
            },
            dataType:"text",
            success: function(data) {
                console.log(data);
                $('#autocomplete_select_course').html(data);
            }
        });
    });
</script>