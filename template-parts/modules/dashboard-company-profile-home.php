
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

                    <div class="modal fade new-modal-to-do" id="to-do-Modal" tabindex="-1" role="dialog" aria-labelledby="to-do-ModalModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="MandatoryModalLabel">To do</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="content-block-bg">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="element-Doe-een" data-target="Persoonlijk" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">Doe een</p>
                                                        <p class="description">Een opleiding, cursus,
                                                            podcast, event o.i.d.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-Schrijf-een" data-target="Schrijf-een" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">Schrijf een</p>
                                                        <p class="description">Een persoonlijk
                                                            ontwikkel plan</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-Leer-een-onderwerp" data-target="Leer-een-onderwerp" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">Leer een onderwerp</p>
                                                        <p class="description">Zet de uren vast!</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-Geef-feedback" data-target="Geef-feedback" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">Geef feedback</p>
                                                        <p class="description">Aan je collega’s</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="detail-content-modal content-Persoonlijk">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Do a course</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van to do</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group" id="">
                                                <label class="sub-label">Selecteer bestaande intern of extern kennisproduct óf creëer een nieuwe</label>
                                                <select class="form-select select-internal-external mb-0" aria-label="Default" id="" >
                                                    <option value="0" selected>Select</option>
                                                    <option value="internal">Internal course</option>
                                                    <option value="external">External course</option>
                                                    <option value="external">Create a new one</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="">
                                                <label class="sub-label">Selecteer product (for</label>
                                                <select class="form-select select-internal-external mb-0" aria-label="Default" id="" >
                                                    <option value="0" selected>Select</option>
                                                    <option value="">A</option>
                                                    <option value="">B</option>
                                                    <option value="">C</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="dateDone">Te doen voor welke datum?</label>
                                                <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Geldig tot?</label>
                                                <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                    </div>
                                    <div class="detail-content-modal content-Schrijf-een">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Persoonlijk ontwikkelplan</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van ontwikkelplan</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Waarover een ontwikkelplan maken?</label>
                                                <textarea class="message-area" name="" id="" rows="3"></textarea>
                                            </div>
                                            <div class="form-group" id="">
                                                <label class="sub-label">Voor welke datum?</label>
                                                <select class="form-select select-internal-external mb-0" aria-label="Default" id="" >
                                                    <option value="0" selected>Select</option>
                                                    <option value="internal">Internal course</option>
                                                    <option value="external">External course</option>
                                                    <option value="external">Create a new one</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Over welke competenties?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                    </div>
                                    <div class="detail-content-modal content-Leer-een-onderwerp">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span> Leer een onderwerp</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van de to do</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group" id="">
                                                <label class="sub-label">Selecteer het onderwerp (sub-topic)</label>
                                                <select class="form-select select-internal-external mb-0" aria-label="Default" id="" >
                                                    <option value="0" selected>Type topic …</option>
                                                    <option value="">A</option>
                                                    <option value="">B</option>
                                                    <option value="">C</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="">
                                                <label class="sub-label">Select hours to learn</label>
                                                <select class="form-select select-internal-external mb-0" aria-label="Default" id="" >
                                                    <option value="0" selected>Type topic …</option>
                                                    <option value="">A</option>
                                                    <option value="">B</option>
                                                    <option value="">C</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                    </div>
                                    <div class="detail-content-modal content-Geef-feedback">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Geef Feedback</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van te geven feedback</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group formModifeChoose">
                                                <label class="sub-label">Selecteer de collega(s)</label>
                                                <select id="" name=""  class="multipleSelect2" multiple="true" required>
                                                    <option value="">A</option>
                                                    <option value="">C</option>
                                                    <option value="">D</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="dateDone">Voor welke datum?</label>
                                                <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Over welke competenties?</label>
                                                <textarea class="message-area" placeholder="Type topics …" name="" id="" rows="5"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" placeholder="" name="" id="" rows="5"></textarea>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                    </div>
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

            <ul id="Certificaten" class="hide">
                <div class="sub-to-do d-flex justify-content-between align-items-center">
                    <p class="text-to-do-for">Achievements by Mamadou</p>
                    <button class="btn btn-add-to-do" type="button" data-toggle="modal" data-target="#Add-achievement-Modal">Add achievement</button>

                    <!-- Modal Add Add achievement -->

                    <div class="modal fade new-modal-to-do" id="Add-achievement-Modal" tabindex="-1" role="dialog" aria-labelledby="to-do-ModalModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="MandatoryModalLabel">To do</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="content-block-bg">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="element-BADGE" data-target="BADGE" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">BADGE</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-CERTFICATE" data-target="CERTFICATE" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">CERTFICATE</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-PRESTATIE" data-target="PRESTATIE" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">PRESTATIE</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-DIPLOMA" data-target="DIPLOMA" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">DIPLOMA</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="detail-content-modal content-BADGE">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Badge</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="">Titel van de badge</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Hoe is deze badge behaald?</label>
                                                <textarea class="message-area" name="" id="" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Upload de batch</label>
                                                <div>
                                                    <div x-data="imageData()" class="file-input flex items-center">
                                                        <!-- Preview Image -->
                                                        <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                                            <!-- Placeholder image -->
                                                            <div x-show="!previewPhoto" class="preview-badge">
                                                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                                            </div>
                                                            <!-- Show a preview of the photo -->
                                                            <div x-show="previewPhoto" class="preview-badge">
                                                                <img :src="previewPhoto"
                                                                     alt=""
                                                                     class="h-12 w-12 object-cover">
                                                            </div>
                                                        </div>

                                                        <div class="flex items-center">
                                                            <!-- File Input -->
                                                            <div class="ml-5 rounded-md shadow-sm">
                                                                <!-- Replace the file input styles with our own via the label -->
                                                                <input @change="updatePreview($refs)" x-ref="input"
                                                                       type="file"
                                                                       accept="image/*,capture=camera"
                                                                       name="photo" id="photo"
                                                                       class="custom">
                                                                <label for="photo"
                                                                       class="py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-indigo-500 hover:border-indigo-300 focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-gray-50 active:text-indigo-800 transition duration-150 ease-in-out">
                                                                    Upload Photo
                                                                </label>
                                                            </div>
                                                            <div class="flex items-center text-sm text-gray-500 mx-2">
                                                                <!-- Display the file name when available -->
                                                                <span x-text="fileName || emptyText"></span>
                                                                <!-- Removes the selected file -->
                                                                <button x-show="fileName"
                                                                        @click="clearPreview($refs)"
                                                                        type="button"
                                                                        aria-label="Remove image"
                                                                        class="mx-1 mt-1">
                                                                    <svg viewBox="0 0 20 20" fill="currentColor" class="x-circle w-4 h-4"
                                                                         aria-hidden="true" focusable="false"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                                                </button>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group" id="">
                                                <label class="sub-label">Selecteer bestaande intern of extern kennisproduct óf creëer een nieuwe</label>
                                                <select class="form-select select-internal-external mb-0" aria-label="Default" id="" >
                                                    <option value="0" selected>Select</option>
                                                    <option value="internal">Internal course</option>
                                                    <option value="external">External course</option>
                                                    <option value="external">Create a new one</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="">
                                                <label class="sub-label">Selecteer product (for</label>
                                                <select class="form-select select-internal-external mb-0" aria-label="Default" id="" >
                                                    <option value="0" selected>Select</option>
                                                    <option value="">A</option>
                                                    <option value="">B</option>
                                                    <option value="">C</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="dateDone">Te doen voor welke datum?</label>
                                                <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Geldig tot?</label>
                                                <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                    </div>
                                    <div class="detail-content-modal content-CERTFICATE">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Persoonlijk ontwikkelplan</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van ontwikkelplan</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Waarover een ontwikkelplan maken?</label>
                                                <textarea class="message-area" name="" id="" rows="3"></textarea>
                                            </div>
                                            <div class="form-group" id="">
                                                <label class="sub-label">Voor welke datum?</label>
                                                <select class="form-select select-internal-external mb-0" aria-label="Default" id="" >
                                                    <option value="0" selected>Select</option>
                                                    <option value="internal">Internal course</option>
                                                    <option value="external">External course</option>
                                                    <option value="external">Create a new one</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Over welke competenties?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                    </div>
                                    <div class="detail-content-modal content-PRESTATIE">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span> Leer een onderwerp</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van de to do</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group" id="">
                                                <label class="sub-label">Selecteer het onderwerp (sub-topic)</label>
                                                <select class="form-select select-internal-external mb-0" aria-label="Default" id="" >
                                                    <option value="0" selected>Type topic …</option>
                                                    <option value="">A</option>
                                                    <option value="">B</option>
                                                    <option value="">C</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="">
                                                <label class="sub-label">Select hours to learn</label>
                                                <select class="form-select select-internal-external mb-0" aria-label="Default" id="" >
                                                    <option value="0" selected>Type topic …</option>
                                                    <option value="">A</option>
                                                    <option value="">B</option>
                                                    <option value="">C</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                    </div>
                                    <div class="detail-content-modal content-DIPLOMA">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Geef Feedback</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van te geven feedback</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group formModifeChoose">
                                                <label class="sub-label">Selecteer de collega(s)</label>
                                                <select id="" name=""  class="multipleSelect2" multiple="true" required>
                                                    <option value="">A</option>
                                                    <option value="">C</option>
                                                    <option value="">D</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="dateDone">Voor welke datum?</label>
                                                <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Over welke competenties?</label>
                                                <textarea class="message-area" placeholder="Type topics …" name="" id="" rows="5"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" placeholder="" name="" id="" rows="5"></textarea>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="body-content-to-do">

                    <div class="content-tab">
                        <div class="content-button-tabs">
                            <button  data-tab="Badges" class="b-nav-tab btn active">
                                Badges<span class="number-content">0</span>
                            </button>
                            <button  data-tab="Certificates" class="b-nav-tab btn">
                                Certificates <span class="number-content">0</span>
                            </button>
                            <button  data-tab="Prestaties" class="b-nav-tab btn">
                                Prestaties <span class="number-content">O</span>
                            </button>
                            <button  data-tab="Diploma" class="b-nav-tab btn">
                                Diploma <span class="number-content">0</span>
                            </button>
                        </div>

                        <div id="Badges" class="b-tab active contentBlockSetting">
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-certifican.png" alt="">
                                <a href="" class="btn btn-creer-eeen">Geef <span>Mamadou</span> waardering</a>
                            </div>
                        </div>

                        <div id="Certificates" class="b-tab contentBlockSetting">
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-certifican.png" alt="">
                                <a href="" class="btn btn-creer-eeen">Geef <span>Mamadou</span> waardering</a>
                            </div>
                        </div>

                        <div id="Prestaties" class="b-tab contentBlockSetting">
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-certifican.png" alt="">
                                <a href="" class="btn btn-creer-eeen">Geef <span>Mamadou</span> waardering</a>
                            </div>
                        </div>

                        <div id="Diploma" class="b-tab contentBlockSetting">
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-certifican.png" alt="">
                                <a href="" class="btn btn-creer-eeen">Geef <span>Mamadou</span> waardering</a>
                            </div>
                        </div>


                    </div>

                </div>
            </ul>

            <ul id="Statistieken" class="hide">
                <div class="group-statistieken">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Courses done</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <p class="text-stat">12</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Training Costs:</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <p class="text-stat">€1.415,-</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Average Training Hours</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <p class="text-stat">3,5 hours <span>/ 1,5 hours</span> </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Courses in progress</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <p class="text-stat">2</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Assessments done</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <p class="text-stat">2</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Mandatory courses done</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <p class="text-stat">0/2</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Self-Assessment of Skills:</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <p class="text-stat">12</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">External Learning Opportunities:</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <p class="text-stat">56</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Feedback given on average</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <p class="text-stat">3,6 <span>/ 4,3</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="theme-card-statistiken-1 mb-4 position-relative height-fit-content">
                        <div class="head-card d-flex justify-content-between align-items-center">
                            <p class="title">Key Skill Development Progress: (See all)</p>
                            <div class="select">
                                <select>
                                    <option value="Year">OOH</option>
                                    <option value="Month">Month</option>
                                    <option value="Day">Day</option>
                                </select>
                                <div>
                                    <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="w-100">
                            <canvas id="Key-Skill"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Learning Delivery Methods:</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <div class="d-block w-100 subTopics-usage-block">
                                    <a href="" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics">Articles</p>
                                        </div>
                                        <p class="number">76%</p>
                                    </a>
                                    <a href="" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics">Articles</p>
                                        </div>
                                        <p class="number">76%</p>
                                    </a>
                                    <a href="" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics">Articles</p>
                                        </div>
                                        <p class="number">76%</p>
                                    </a>
                                    <a href="" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics">Articles</p>
                                        </div>
                                        <p class="number">76%</p>
                                    </a>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                           <div>
                               <div class="theme-card-statistiken-1 height-fit-content mb-3">
                                   <div class="head-card d-flex justify-content-between align-items-center">
                                       <p class="title">Feedback received</p>
                                       <div class="select">
                                           <select>
                                               <option value="Year">Year</option>
                                               <option value="Month">Month</option>
                                               <option value="Day">Day</option>
                                           </select>
                                           <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                       </div>
                                   </div>
                                   <p class="text-stat">2</p>
                               </div>
                               <div class="theme-card-statistiken-1 height-fit-content">
                                   <div class="head-card d-flex justify-content-between align-items-center">
                                       <p class="title">Feedback given</p>
                                       <div class="select">
                                           <select>
                                               <option value="Year">Year</option>
                                               <option value="Month">Month</option>
                                               <option value="Day">Day</option>
                                           </select>
                                           <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                       </div>
                                   </div>
                                   <p class="text-stat">2</p>
                               </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Most Viewed Topics</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <p class="text-stat"></p>
                                <div class="empty-topic-block">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-topic.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Followed topics</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <div class="d-block w-100 subTopics-usage-block">
                                    <a href="" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics">Agile / Scrum</p>
                                        </div>
                                        <p class="number">122k</p>
                                    </a>
                                    <a href="" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics">Articles</p>
                                        </div>
                                        <p class="number">76%</p>
                                    </a>
                                    <a href="" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics">Cocktail maken</p>
                                        </div>
                                        <p class="number">23k</p>
                                    </a>
                                    <a href="" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics">Transport</p>
                                        </div>
                                        <p class="number">5k</p>
                                    </a>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Followed teachers</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <p class="text-stat"></p>
                                <div class="empty-topic-block">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-topic.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Most Viewed Expert</p>
                                    <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div>
                                </div>
                                <div class="d-block w-100 subTopics-usage-block">
                                    <a href="" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics">Seydou Diallo</p>
                                        </div>
                                        <p class="number">232</p>
                                    </a>
                                    <a href="" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics">Articles</p>
                                        </div>
                                        <p class="number">76%</p>
                                    </a>
                                    <a href="" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics">Mohamed Thioune</p>
                                        </div>
                                        <p class="number">134</p>
                                    </a>
                                    <a href="" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics">Daniel van der Kolk</p>
                                        </div>
                                        <p class="number">45</p>
                                    </a>

                                </div>

                            </div>
                        </div>
                    </div>
                  <div class="row">
                      <div class="col-md-8">
                          <div class="theme-card-statistiken-1 mb-4 position-relative height-fit-content">
                              <div class="head-card d-flex justify-content-between align-items-center">
                                  <p class="title">Usage desktop vs Mobile app</p>
                                  <div class="select">
                                      <select>
                                          <option value="Year">OOH</option>
                                          <option value="Month">Month</option>
                                          <option value="Day">Day</option>
                                      </select>
                                      <div>
                                          <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                      </div>
                                  </div>
                              </div>
                              <div class="w-100">
                                  <canvas id="Usage-desktop"></canvas>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="theme-card-statistiken-1">
                              <div class="head-card d-flex justify-content-between align-items-center">
                                  <p class="title">Followed topics</p>
                                  <div class="select">
                                      <select>
                                          <option value="Year">Year</option>
                                          <option value="Month">Month</option>
                                          <option value="Day">Day</option>
                                      </select>
                                      <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                  </div>
                              </div>
                              <div class="d-block w-100 subTopics-usage-block">
                                  <div class="element-SubTopics d-flex justify-content-between">
                                      <div class="d-flex">
                                          <div class="imgTopics">
                                              <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                          </div>
                                          <p class="text-subTopics">ux/ui Designerf</p>
                                      </div>
                                      <a href="" class="number">Apply</a>
                                  </div>
                                  <div class="element-SubTopics d-flex justify-content-between">
                                      <div class="d-flex">
                                          <div class="imgTopics">
                                              <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                          </div>
                                          <p class="text-subTopics">ux/ui Designerf</p>
                                      </div>
                                      <a href="" class="number">Apply</a>
                                  </div>
                                  <div class="element-SubTopics d-flex justify-content-between">
                                      <div class="d-flex">
                                          <div class="imgTopics">
                                              <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                          </div>
                                          <p class="text-subTopics">ux/ui Designerf</p>
                                      </div>
                                      <a href="" class="number">Apply</a>
                                  </div>
                                  <div class="element-SubTopics d-flex justify-content-between">
                                      <div class="d-flex">
                                          <div class="imgTopics">
                                              <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                          </div>
                                          <p class="text-subTopics">ux/ui Designerf</p>
                                      </div>
                                      <a href="" class="number">Apply</a>
                                  </div>

                              </div>

                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="theme-card-statistiken-1 mb-4 position-relative height-fit-content">
                              <div class="head-card d-flex justify-content-between align-items-center">
                                  <p class="title">Latest badges</p>
                                  <div class="select">
                                      <select>
                                          <option value="See-all">See all</option>
                                          <option value="">...</option>
                                          <option value="">...</option>
                                      </select>
                                      <div>
                                          <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                      </div>
                                  </div>
                              </div>
                              <div class="block-empty-badge">
                                  <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-badge.png" alt="">
                              </div>
                          </div>
                      </div>
                  </div>

                </div>
            </ul>

            <ul id="Interne-groei" class="hide">

                <div class="contentBlockSetting">
                    <div class="content">
                        <form action="" method="POST">

                            <div class="form-group formModifeChoose">

                                <select class="multipleSelect2" name="selected_subtopics[]" multiple="true" required>
                                    <?php

                                    foreach($subtopics as $value){
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="manager" value=<?php $manager->ID?> >
                                <input type="hidden" name="id_user" value=<?php $user->ID?> >
                                <button name="add_internal_growth" class="btn btnVoegTab " type="submit">Voeg toe</button>
                            </div>

                            <?php
                            if (!empty (get_user_meta($user->ID,'topic_affiliate')))
                            {
                                $internal_growth_subtopics= get_user_meta($user->ID,'topic_affiliate'); ?>


                                <div class="inputGroein">
                                    <?php
                                    foreach($internal_growth_subtopics as $value){
                                        echo "
                                            <form action='/dashboard/user/' method='POST'>
                                            <input type='hidden' name='meta_value' value='". $value . "' id=''>
                                            <input type='hidden' name='user_id' value='". $user->ID . "' id=''>
                                            <input type='hidden' name='meta_key' value='topic_affiliate' id=''>";
                                        echo "<p> <button type='submit' name='delete' style='border:none;background:#C7D8F5'><i style='font-size 0.5em; color:white'class='fa fa-trash'></i>&nbsp;".(String)get_the_category_by_ID($value)."</button></p>";
                                        echo "</form>";
                                        ?>


                                        <?php
                                    }
                                    ?>
                                </div>

                                <?php
                            }else {
                                echo "<p>No topics yet</p>" ;
                            }
                            ?>
                        </form>
                    </div>
                </div>

            </ul>

            <ul id="Externe-groei" class="hide">
                <div id="Externe-groei" class="contentBlockSetting">
                    <div class="content">
                        <div class="inputGroein">

                            <?php
                             if (!empty (get_user_meta($user->ID,'topic')))
                                {
                                    $external_growth_subtopics = get_user_meta($user->ID,'topic');
                                    ?>

                            <div class="inputGroein">
                                <?php
                                   foreach($external_growth_subtopics as $value){
                                        echo "<p>".(String)get_the_category_by_ID($value)."</p>";
                                    }

                                    ?>
                            </div>

                            <?php
                             }else {
                                    echo "<p>No topics yet</p>" ;
                                }
                                ?>

                        </div>
                    </div>
                </div>
            </ul>

            <ul id="Feedback" class="hide">
                <div class="sub-to-do d-flex justify-content-between align-items-center">
                    <p class="text-to-do-for">Feedback for Mamadou</p>
                    <button class="btn btn-add-to-do" type="button" data-toggle="modal" data-target="#Add-Feedback-Modal">Add Feedback</button>

                    <!-- Modal Add to do -->

                    <div class="modal fade new-modal-to-do" id="Add-Feedback-Modal" tabindex="-1" role="dialog" aria-labelledby="to-do-ModalModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="MandatoryModalLabel">Feedback</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="content-block-bg">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="element-FEEDBACK" data-target="FEEDBACK" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">FEEDBACK</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-ONTWIKKELPLAN" data-target="ONTWIKKELPLAN" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">ONTWIKKELPLAN</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-BEOORDELING" data-target="BEOORDELING" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">BEOORDELING</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-COMPLIMENT" data-target="COMPLIMENT" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">COMPLIMENT</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="detail-content-modal content-FEEDBACK">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Feedback</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van feedback</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Beschrijf de feedback</label>
                                                <textarea class="message-area" name="" id="" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Competenties waar de feedback over gaat</label>
                                                <textarea class="message-area" name="" id="" rows="3"></textarea>
                                            </div>
                                            <div class="form-group position-relative">
                                                <label for="">Geef een rating </label>
                                                <div class="rating-element">
                                                    <div class="rating">
                                                        <input type="radio" id="star5-Geef" class="stars" name="rating-Geef" value="5" />
                                                        <label class="star" for="star5-Geef" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="star4-Geef" class="stars" name="rating-Geef" value="4" />
                                                        <label class="star" for="star4-Geef" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="star3-Geef" class="stars" name="rating-Geef" value="3" />
                                                        <label class="star" for="star3-Geef" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="star2-Geef" class="stars" name="rating-Geef" value="2" />
                                                        <label class="star" for="star2-Geef" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="star1-Geef" name="rating-Geef" value="1" />
                                                        <label class="star" for="star1-Geef" class="stars" title="Bad" aria-hidden="true"></label>
                                                    </div>
                                                    <span class="rating-counter"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Hoe te verbeteren / overige opmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>
                                            <div class="form-group d-flex checkbokElement">
                                                <input type="checkbox" id="Anoniem" name="Anoniem-versturen?" value="Anoniem versturen?">
                                                <label class="sub-label-check" for="Anoniem-versturen?">Anoniem versturen?</label>
                                            </div>


                                            <button class="btn btn-submi-form-to-do">Stuur feedback</button>

                                        </form>
                                    </div>
                                    <div class="detail-content-modal content-ONTWIKKELPLAN">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Ontwikkelplan</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van ontwikkelplan</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Competenties waar het ontwikkelen over gaat</label>
                                                <textarea class="message-area" name="" id="" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Wat wil je dat er bereikt wordt?</label>
                                                <textarea class="message-area" name="" id="" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Hoe denk je dat dit het best bereikt kan worden? </label>
                                                <textarea class="message-area" name="" id="" rows="3"></textarea>
                                            </div>
                                            <div class="form-group d-flex">
                                                <label for="">Denk je dat er hulp bij nodig is?</label>
                                                <div class="d-flex">
                                                    <div class="d-flex checkbokElement mr-3">
                                                        <input type="checkbox" id="Ja" name="Denk" value="Ja">
                                                        <label class="sub-label-check" for="Anoniem-versturen?">Ja</label>
                                                    </div>
                                                    <div class="d-flex checkbokElement ">
                                                        <input type="checkbox" id="Nee" name="Denk" value="Nee">
                                                        <label class="sub-label-check" for="Nee">Nee</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Huidige waardering (voor ontwikkelplan)</label>
                                                <div class="rating-element">
                                                    <div class="rating">
                                                        <input type="radio" id="star5-Huidige" class="stars" name="rating-Geef" value="5" />
                                                        <label class="star" for="star5-Huidige" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="star4-Huidige" class="stars" name="rating-Geef" value="4" />
                                                        <label class="star" for="star4-Huidige" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="star3-Huidige" class="stars" name="rating-Geef" value="3" />
                                                        <label class="star" for="star3-Huidige" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="star2-Huidige" class="stars" name="rating-Geef" value="2" />
                                                        <label class="star" for="star2-Huidige" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="star1-Huidige" name="rating-Geef" value="1" />
                                                        <label class="star" for="star1-Huidige" class="stars" title="Bad" aria-hidden="true"></label>
                                                    </div>
                                                    <span class="rating-counter"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Overige opmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>
                                            <div class="form-group d-flex checkbokElement">
                                                <input type="checkbox" id="Anoniem" name="Anoniem-versturen?" value="Anoniem versturen?">
                                                <label class="sub-label-check" for="Anoniem-versturen?">Anoniem versturen?</label>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                    </div>
                                    <div class="detail-content-modal content-BEOORDELING">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Beoordeling</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van beoordeling</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Competenties waar de beoordeling over gaat</label>
                                                <textarea class="message-area" name="" id="" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Algemene beoordeling bovenstaande competenties</label>
                                                <textarea class="message-area" name="" id="" rows="3"></textarea>
                                            </div>
                                            <div class="form-group position-relative">
                                                <label for="">Beoordeling competentie “Skill A”</label>
                                                <div class="rating-element">
                                                    <div class="rating">
                                                        <input type="radio" id="star5-Beoordeling" class="stars" name="rating-Beoordeling" value="5" />
                                                        <label class="star" for="star5-Beoordeling" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="star4-Beoordeling" class="stars" name="rating-Beoordeling" value="4" />
                                                        <label class="star" for="star4-Beoordeling" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="star3-Beoordeling" class="stars" name="rating-Beoordeling" value="3" />
                                                        <label class="star" for="star3-Beoordeling" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="star2-Beoordeling" class="stars" name="rating-Beoordeling" value="2" />
                                                        <label class="star" for="star2-Beoordeling" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="star1-Beoordeling" name="rating-Geef" value="1" />
                                                        <label class="star" for="star1-Beoordeling" class="stars" title="Bad" aria-hidden="true"></label>
                                                    </div>
                                                    <span class="rating-counter"></span>
                                                </div>
                                            </div>
                                            <div class="form-group position-relative">
                                                <label for="">Beoordeling competentie “Skill B”</label>
                                                <div class="rating-element">
                                                    <div class="rating">
                                                        <input type="radio" id="star5-Beoordeling-2" class="stars" name="rating-Beoordeling-2" value="5" />
                                                        <label class="star" for="star5-Beoordeling-2" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="star4-Beoordeling-2" class="stars" name="rating-Beoordeling-2" value="4" />
                                                        <label class="star" for="star4-Beoordeling-2" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="star3-Beoordeling-2" class="stars" name="rating-Beoordeling-2" value="3" />
                                                        <label class="star" for="star3-Beoordeling-2" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="star2-Beoordeling-2" class="stars" name="rating-Beoordeling-2" value="2" />
                                                        <label class="star" for="star2-Beoordeling-2" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="star1-Beoordeling-2" name="rating-Geef" value="1" />
                                                        <label class="star" for="star1-Beoordeling-2" class="stars" title="Bad" aria-hidden="true"></label>
                                                    </div>
                                                    <span class="rating-counter"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="dateDone">Voor welke datum?</label>
                                               <div class="d-flex">
                                                   <input type="date" class="form-control mr-3" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                                   <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                               </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Overige opmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>
                                            <div class="form-group d-flex checkbokElement">
                                                <input type="checkbox" id="Anoniem" name="Anoniem-versturen?" value="Anoniem versturen?">
                                                <label class="sub-label-check" for="Anoniem-versturen?">Anoniem versturen?</label>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur feedback</button>

                                        </form>

                                    </div>
                                    <div class="detail-content-modal content-COMPLIMENT">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Compliment</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van Compliment</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Competenties waar het compliment over gaat</label>
                                                <textarea class="message-area" name="" id="" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Waarom een compliment?</label>
                                                <textarea class="message-area" name="" id="" rows="3"></textarea>
                                            </div>
                                            <div class="form-group position-relative">
                                                <label for="">Compliment competentie “Skill A”</label>
                                                <div class="rating-element">
                                                    <div class="rating">
                                                        <input type="radio" id="star5-Beoordeling" class="stars" name="rating-Beoordeling" value="5" />
                                                        <label class="star" for="star5-Beoordeling" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="star4-Beoordeling" class="stars" name="rating-Beoordeling" value="4" />
                                                        <label class="star" for="star4-Beoordeling" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="star3-Beoordeling" class="stars" name="rating-Beoordeling" value="3" />
                                                        <label class="star" for="star3-Beoordeling" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="star2-Beoordeling" class="stars" name="rating-Beoordeling" value="2" />
                                                        <label class="star" for="star2-Beoordeling" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="star1-Beoordeling" name="rating-Geef" value="1" />
                                                        <label class="star" for="star1-Beoordeling" class="stars" title="Bad" aria-hidden="true"></label>
                                                    </div>
                                                    <span class="rating-counter"></span>
                                                </div>
                                            </div>
                                            <div class="form-group position-relative">
                                                <label for="">Compliment competentie “Skill B”</label>
                                                <div class="rating-element">
                                                    <div class="rating">
                                                        <input type="radio" id="star5-Beoordeling-2" class="stars" name="rating-Beoordeling-2" value="5" />
                                                        <label class="star" for="star5-Beoordeling-2" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="star4-Beoordeling-2" class="stars" name="rating-Beoordeling-2" value="4" />
                                                        <label class="star" for="star4-Beoordeling-2" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="star3-Beoordeling-2" class="stars" name="rating-Beoordeling-2" value="3" />
                                                        <label class="star" for="star3-Beoordeling-2" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="star2-Beoordeling-2" class="stars" name="rating-Beoordeling-2" value="2" />
                                                        <label class="star" for="star2-Beoordeling-2" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="star1-Beoordeling-2" name="rating-Geef" value="1" />
                                                        <label class="star" for="star1-Beoordeling-2" class="stars" title="Bad" aria-hidden="true"></label>
                                                    </div>
                                                    <span class="rating-counter"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="dateDone">Compliment voor de periode van .. tot</label>
                                                <div class="d-flex">
                                                    <input type="date" class="form-control mr-3" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                                    <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Overige opmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>
                                            <div class="form-group d-flex checkbokElement">
                                                <input type="checkbox" id="Anoniem" name="Anoniem-versturen?" value="Anoniem versturen?">
                                                <label class="sub-label-check" for="Anoniem-versturen?">Anoniem versturen?</label>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur feedback</button>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="body-content-to-do">
                    <div class="content-tab">
                        <div class="content-button-tabs">
                            <button  data-tab="AllFeddback" class="b-nav-tab btn active">
                                All <span class="number-content">14</span>
                            </button>
                            <button  data-tab="Feedback" class="b-nav-tab btn">
                                Feedback <span class="number-content">2</span>
                            </button>
                            <button  data-tab="Ontwikkelplan" class="b-nav-tab btn">
                                Ontwikkelplan <span class="number-content">5</span>
                            </button>
                            <button  data-tab="Beoordeling" class="b-nav-tab btn">
                                Beoordeling <span class="number-content">2</span>
                            </button>
                            <button  data-tab="Compliment" class="b-nav-tab btn">
                                Compliment <span class="number-content">4</span>
                            </button>
                            <button  data-tab="empty-" class="b-nav-tab btn">
                                Empty <span class="number-content">O</span>
                            </button>
                        </div>

                        <div id="AllFeddback" class="b-tab active contentBlockSetting">
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Feedback</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Rating</th>
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
                                                <p class="text-date mb-0">Fantastisch om met jou samen te werken!</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-other-element" id="mr-element">Feedback</p>
                                    </td>
                                    <td class="position-relative">
                                        <div class="rating-element">
                                            <div class="rating">
                                                <input type="radio" id="star5-Great" class="stars" checked  name="rating-Great" value="5" />
                                                <label class="star" for="star5-Great" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4-Great" class="stars" name="rating-Great" value="4" />
                                                <label class="star" for="star4-Great" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3-Great" class="stars" name="rating-Great" value="3" />
                                                <label class="star" for="star3-Great" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2-Great" class="stars" name="rating-Great" value="2" />
                                                <label class="star" for="star2-Great" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1-Great" name="rating-Great" value="1" />
                                                <label class="star" for="star1-Great" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
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
                                                <p class="text-date mb-0">Fantastisch om met jou samen te werken!</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-other-element" id="mr-element">Feedback</p>
                                    </td>
                                    <td class="position-relative">
                                        <div class="rating-element">
                                            <div class="rating">
                                                <input type="radio" id="star5" class="stars" checked  name="rating" value="5" />
                                                <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4" class="stars" name="rating" value="4" />
                                                <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3" class="stars" name="rating" value="3" />
                                                <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2" class="stars" name="rating" value="2" />
                                                <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label class="star" for="star1" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
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

                        <div id="Feedback" class="b-tab contentBlockSetting">
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Feedback</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Rating</th>
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
                                                <p class="text-date mb-0">Fantastisch om met jou samen te werken!</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-other-element" id="mr-element">Feedback</p>
                                    </td>
                                    <td class="position-relative">
                                        <div class="rating-element">
                                            <div class="rating">
                                                <input type="radio" id="star5-Great" class="stars" checked  name="rating-Great" value="5" />
                                                <label class="star" for="star5-Great" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4-Great" class="stars" name="rating-Great" value="4" />
                                                <label class="star" for="star4-Great" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3-Great" class="stars" name="rating-Great" value="3" />
                                                <label class="star" for="star3-Great" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2-Great" class="stars" name="rating-Great" value="2" />
                                                <label class="star" for="star2-Great" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1-Great" name="rating-Great" value="1" />
                                                <label class="star" for="star1-Great" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
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
                                                <p class="text-date mb-0">Fantastisch om met jou samen te werken!</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-other-element" id="mr-element">Feedback</p>
                                    </td>
                                    <td class="position-relative">
                                        <div class="rating-element">
                                            <div class="rating">
                                                <input type="radio" id="star5" class="stars" checked  name="rating" value="5" />
                                                <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4" class="stars" name="rating" value="4" />
                                                <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3" class="stars" name="rating" value="3" />
                                                <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2" class="stars" name="rating" value="2" />
                                                <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label class="star" for="star1" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
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

                        <div id="Ontwikkelplan" class="b-tab contentBlockSetting">
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Feedback</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Rating</th>
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
                                                <p class="text-date mb-0">Fantastisch om met jou samen te werken!</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-other-element" id="mr-element">Feedback</p>
                                    </td>
                                    <td class="position-relative">
                                        <div class="rating-element">
                                            <div class="rating">
                                                <input type="radio" id="star5-Great" class="stars" checked  name="rating-Great" value="5" />
                                                <label class="star" for="star5-Great" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4-Great" class="stars" name="rating-Great" value="4" />
                                                <label class="star" for="star4-Great" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3-Great" class="stars" name="rating-Great" value="3" />
                                                <label class="star" for="star3-Great" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2-Great" class="stars" name="rating-Great" value="2" />
                                                <label class="star" for="star2-Great" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1-Great" name="rating-Great" value="1" />
                                                <label class="star" for="star1-Great" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
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
                                                <p class="text-date mb-0">Fantastisch om met jou samen te werken!</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-other-element" id="mr-element">Feedback</p>
                                    </td>
                                    <td class="position-relative">
                                        <div class="rating-element">
                                            <div class="rating">
                                                <input type="radio" id="star5" class="stars" checked  name="rating" value="5" />
                                                <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4" class="stars" name="rating" value="4" />
                                                <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3" class="stars" name="rating" value="3" />
                                                <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2" class="stars" name="rating" value="2" />
                                                <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label class="star" for="star1" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
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

                        <div id="Beoordeling" class="b-tab contentBlockSetting">
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Feedback</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Rating</th>
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
                                                <p class="text-date mb-0">Fantastisch om met jou samen te werken!</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-other-element" id="mr-element">Feedback</p>
                                    </td>
                                    <td class="position-relative">
                                        <div class="rating-element">
                                            <div class="rating">
                                                <input type="radio" id="star5-Great" class="stars" checked  name="rating-Great" value="5" />
                                                <label class="star" for="star5-Great" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4-Great" class="stars" name="rating-Great" value="4" />
                                                <label class="star" for="star4-Great" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3-Great" class="stars" name="rating-Great" value="3" />
                                                <label class="star" for="star3-Great" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2-Great" class="stars" name="rating-Great" value="2" />
                                                <label class="star" for="star2-Great" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1-Great" name="rating-Great" value="1" />
                                                <label class="star" for="star1-Great" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
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
                                                <p class="text-date mb-0">Fantastisch om met jou samen te werken!</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-other-element" id="mr-element">Feedback</p>
                                    </td>
                                    <td class="position-relative">
                                        <div class="rating-element">
                                            <div class="rating">
                                                <input type="radio" id="star5" class="stars" checked  name="rating" value="5" />
                                                <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4" class="stars" name="rating" value="4" />
                                                <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3" class="stars" name="rating" value="3" />
                                                <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2" class="stars" name="rating" value="2" />
                                                <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label class="star" for="star1" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
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

                        <div id="Compliment" class="b-tab contentBlockSetting">
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Feedback</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Rating</th>
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
                                                <p class="text-date mb-0">Fantastisch om met jou samen te werken!</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-other-element" id="mr-element">Feedback</p>
                                    </td>
                                    <td class="position-relative">
                                        <div class="rating-element">
                                            <div class="rating">
                                                <input type="radio" id="star5-Great" class="stars" checked  name="rating-Great" value="5" />
                                                <label class="star" for="star5-Great" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4-Great" class="stars" name="rating-Great" value="4" />
                                                <label class="star" for="star4-Great" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3-Great" class="stars" name="rating-Great" value="3" />
                                                <label class="star" for="star3-Great" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2-Great" class="stars" name="rating-Great" value="2" />
                                                <label class="star" for="star2-Great" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1-Great" name="rating-Great" value="1" />
                                                <label class="star" for="star1-Great" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
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
                                                <p class="text-date mb-0">Fantastisch om met jou samen te werken!</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-other-element" id="mr-element">Feedback</p>
                                    </td>
                                    <td class="position-relative">
                                        <div class="rating-element">
                                            <div class="rating">
                                                <input type="radio" id="star5" class="stars" checked  name="rating" value="5" />
                                                <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4" class="stars" name="rating" value="4" />
                                                <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3" class="stars" name="rating" value="3" />
                                                <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2" class="stars" name="rating" value="2" />
                                                <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label class="star" for="star1" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
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

                        <div id="empty-" class="b-tab  contentBlockSetting">
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <a href="" class="btn btn-creer-eeen">Creëer een eerste to do</a>
                            </div>
                        </div>

                    </div>
                </div>
            </ul>


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

<script>
    var data = {
        labels: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
        datasets: [
            {
                label: 'You',
                backgroundColor: '#14A89D',
                borderColor: '#14A89D',
                borderWidth: 1,
                data: [100, 120, 140, 130, 150, 170, 160, 180, 190, 200, 210, 220] 
            },
            {
                label: 'Average learner following this topic',
                backgroundColor: '#023356',
                borderColor: '#023356',
                borderWidth: 1,
                data: [200, 180, 160, 170, 150, 130, 140, 120, 110, 100, 90, 80] 
            }
        ]
    };


    var ctx = document.getElementById('Key-Skill').getContext('2d');


    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>

    var data = {
        labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        datasets: [
            {
                label: 'Mobile',
                borderColor: '#14A89D',
                backgroundColor: '#14A89D',
                borderWidth: 2,
                data: [100, 120, 140, 130, 150, 170, 160, 180, 190, 200, 210, 220]
            },
            {
                label: 'Desktop',
                borderColor: '#023356',
                backgroundColor: '#023356',
                borderWidth: 2,
                data: [200, 180, 160, 170, 150, 130, 140, 120, 110, 100, 90, 80]
            }
        ]
    };


    var ctx = document.getElementById('Usage-desktop').getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.6.0/alpine.js"></script>
<script>
    function imageData(url) {
        const originalUrl = url || '';
        return {
            previewPhoto: originalUrl,
            fileName: null,
            emptyText: originalUrl ? 'No new file chosen' : 'No file chosen',
            updatePreview($refs) {
                var reader,
                    files = $refs.input.files;
                reader = new FileReader();
                reader.onload = (e) => {
                    this.previewPhoto = e.target.result;
                    this.fileName = files[0].name;
                };
                reader.readAsDataURL(files[0]);
            },
            clearPreview($refs) {
                $refs.input.value = null;
                this.previewPhoto = originalUrl;
                this.fileName = false;
            }
        };
    }
</script>