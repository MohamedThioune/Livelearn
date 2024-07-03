<?php
//chekc if user is logged in
if(is_user_logged_in()){
    //get user role
    $user = wp_get_current_user();
    $user_roles = $user->roles;

//    if(in_array('manager', $user_roles) || in_array('administrator', $user_roles)){
//        include_once(dirname(__FILE__).'/header_manager.php');
//    }else if(in_array('teacher', $user_roles)){
//        include_once(dirname(__FILE__).'/header_teacher.php');
//    }else{
        include_once(dirname(__FILE__).'/header_user.php');
//    }
}else{
    include_once(dirname(__FILE__).'/header_base.php');
}

//Categories
$bangerichts = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent'  => $categories[1],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
) );

$functies = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent'  => $categories[0],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
) );

$skills = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent'  => $categories[3],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
) );

$interesses = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent'  => $categories[2],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
) );

$subtopics = array();
$topics = array();
foreach($categories as $categ){
    //Topics
    $topicss = get_categories(
        array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categ,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        )
    );
    $topics = array_merge($topics, $topicss);

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

foreach($bangerichts as $key1=>$tag){

    //Topics
    $cats_bangerichts = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent' => $tag->cat_ID,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ));
    if (count($cats_bangerichts)!=0)
    {
        $row_bangrichts='<div hidden=true class="cb_topics_bangricht_'.($key1+1).'" '.($key1+1).'">';
        foreach($cats_bangerichts as $key => $value)
        {
            $row_bangrichts = '
                <input type="checkbox" name="choice_bangrichts_'.$value->cat_ID.'" value= '.$value->cat_ID .' id=subtopics_bangricht_'.$value->cat_ID.' /><label class="labelChoose" for=subtopics_bangricht_'.$value->cat_ID.'>'. $value->cat_name .'</label>';
        }
        $row_bangrichts= '</div>';
    }

}
$row_functies='';

foreach($functies as $key1 =>$tag)
{

    //Topics
    $cats_functies = get_categories(
        array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => $tag->cat_ID,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
    if (count($cats_functies)!=0)
    {
        $row_functies.='<div hidden=true class="cb_topics_funct_'.($key1+1).'" '.($key1+1).'">';
        foreach($cats_functies as $key => $value)
        {
            $row_functies .= '
            <input type="checkbox" name="choice_functies_'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_funct_'.($value->cat_ID).'" /><label class="labelChoose" for="cb_funct_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
        }
        $row_functies.= '</div>';
    }
}
$row_skills='';
foreach($skills as $key1=>$tag){
    //Topics
    $cats_skills = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent' => $tag->cat_ID,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ));
    if (count($cats_skills)!=0)
    {
        $row_skills.='<div hidden=true class="cb_topics_skills_'.($key1+1).'" '.($key1+1).'">';
        foreach($cats_skills as $key => $value)
        {
            $row_skills .= '
                    <input type="checkbox" name="choice_skills'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_skills_'.($value->cat_ID).'" /><label class="labelChoose"  for="cb_skills_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
        }
        $row_skills.= '</div>';
    }

}
$row_interesses='';
foreach($interesses as $key1=>$tag){
    //Topics
    $cats_interesses = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent' => $tag->cat_ID,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ));
    if (count($cats_interesses)!=0)
    {
        $row_interesses.='<div hidden=true class="cb_topics_personal_'.($key1+1).'" '.($key1+1).'">';
        foreach($cats_interesses as $key => $value)
        {
            $row_interesses .= '
            <input type="checkbox" name="choice_interesses_'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_interesses_'.($value->cat_ID).'" /><label class="labelChoose"  for="cb_interesses_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
        }
        $row_interesses.= '</div>';
    }

}

if (isset($_POST["subtopics_first_login"])){
    unset($_POST["subtopics_first_login"]);
    $subtopics_already_selected = get_user_meta(get_current_user_id(),'topic');
    foreach ($_POST as $key => $subtopics) {
        if (isset($_POST[$key]))
        {
            if (!(in_array($_POST[$key], $subtopics_already_selected)))
            {
                add_user_meta(get_current_user_id(),'topic',$_POST[$key]);
            }

        }
    }
    update_field('is_first_login', true, 'user_'.get_current_user_id());
}




?>
<style>
    #croieSearch {
        display: none;
        margin-top: 1px !important;
        width: 18px !important;
        padding: 0 !important;
        margin-right: 5px !important;
    }
    #croieProfil {
        margin: 4px 0px -3px -6px !important;
    }
    .navModife .activeModalHeader .modal{
        height: auto !important;
    }
    #voorOpleidersModal, #OpleidingenModal{
        height: auto;
    }
    .dropdown-search ul li a .blockImg {
        width: 35px;
        height: 35px;
        margin-right: 15px;
        text-align: center;
        overflow: hidden;
    }
    .dropdown-search ul li a .blockImg img {
        width: 100%;
        margin-top: 0;
        height: 100%;
        object-fit: cover;
    }
    .subtitleSousElementHeader {
        color: #043356;
        font-size: 14px;
        margin-bottom: 0;
    }
    .scrolled{
        background: #023356 !important;
    }
    .scrolled .logoModife img:first-child {
        display: block;
    }
    .scrolled .imgLogoBleu{
        display: none;
    }
    .scrolled .nav-link {
        color: #ffffff !important;
        display: flex;
    }
    .scrolled .imgArrowDropDown {
        display: block;
    }
    .scrolled .fa-angle-down-bleu {
        display: none;
    }
    .scrolled .inputSearch {
        background: #FFFFFF !important;
    }
    .scrolled .navModife4 .additionImg {
        display: block;
    }
    .scrolled .additionBlock{
        display: none;
    }
    .scrolled .bntNotification img {
        display: block;
    }
    .scrolled .bntNotification i {
        display: none;
    }
    .dropdown-search ul li a {
        display: flex;
        align-items: center;
        margin-bottom: 7px;
        border-radius: 18px;
        padding: 7px 9px 9px;
    }
    .dropdown-search .secondUlModal li {
        width: 25%;
        padding: 0 15px;
    }
    .dropdown-search .secondUlModal {
        display: flex;
        flex-wrap: wrap;
    }
    .dropdown-search .title-search {
        color: #043458;
        font-weight: 500;
        font-size: 19px;
    }
    .dropdown-search .d-grid a {
        margin-bottom: 10px;
    }
    .scrolled .dropdown-search a, .scrolled .dropdown-search p{
        color: white !important;
    }

    @media all and (min-width: 1330px) {
        #searchIconeTablet, #croieSearchTablet, .tabletsearch{
            display: none !important;
        }
    }
    @media all and (min-width: 1013px) and (max-width: 1330px) {
        .form-control{
            display: none !important;
        }
    }
    @media all and (min-width: 753px) and (max-width: 1020px) {
        .body{
            padding-top: 0px !important;
        }
        .navMobile {
            height: 58px !important;
            margin-top: -12px !important;
        }
        .btn {
            padding: 0px !important;
        }
        .searchInputHedear {
            background-color: #023356 !important;
            padding: 2px 50px !important;
            margin: -20px !important;
            /* margin-top: -6px  !important; */
        }
        /* .head2 {margin-top:45px !important;}      */
        #main {
            padding-top: 40px;
        }
        .tabletsearch{display: none !important;}
    }
    @media (min-width: 300px) and (max-width: 767px){
        .navMobile-custom {
            padding: 0px 0 8px !important;
        }
        .sousNav3 {
            width: 30%;
            display: flex;
            justify-content: flex-end;
            margin-top: -1px;
        }
    }


    .newtons-cradle {
        --uib-size: 50px;
        --uib-speed: 1.2s;
        --uib-color: #474554;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: var(--uib-size);
        height: var(--uib-size);
    }

    .newtons-cradle__dot {
        position: relative;
        display: flex;
        align-items: center;
        height: 100%;
        width: 25%;
        transform-origin: center top;
    }

    .newtons-cradle__dot::after {
        content: '';
        display: block;
        width: 100%;
        height: 25%;
        border-radius: 50%;
        background-color: var(--uib-color);
    }

    .newtons-cradle__dot:first-child {
        animation: swing var(--uib-speed) linear infinite;
    }

    .newtons-cradle__dot:last-child {
        animation: swing2 var(--uib-speed) linear infinite;
    }

    @keyframes swing {
        0% {
            transform: rotate(0deg);
            animation-timing-function: ease-out;
        }

        25% {
            transform: rotate(70deg);
            animation-timing-function: ease-in;
        }

        50% {
            transform: rotate(0deg);
            animation-timing-function: linear;
        }
    }

    @keyframes swing2 {
        0% {
            transform: rotate(0deg);
            animation-timing-function: linear;
        }

        50% {
            transform: rotate(0deg);
            animation-timing-function: ease-out;
        }

        75% {
            transform: rotate(-70deg);
            animation-timing-function: ease-in;
        }
    }


</style>
<!-- for search  -->
<div class="modal dropdown-search" id="for-search-element" tabindex="-1" role="dialog" aria-labelledby="voorOpleidersLabel" aria-hidden="true">
    <div class="container-fluid">
        <section class="content-product-search">
            <div class="container-fluid">
                <div class="search-mobile">
                    <form action="/product-search" method="GET" class="form-inline ml-auto mb-0 ">
                        <input value="<?=isset($_GET['search']) ? $_GET['search'] : '' ?>" id="header-search" class="form-control InputDropdown1 mr-sm-2 inputSearch" name="search" type="search" placeholder="Zoek opleidingen, experts en onderwerpen" aria-label="Search">
                        <div class="dropdown-menuSearch headerDrop" id="header-list">
                            <div class="list-autocomplete" id="header">
                                <center> <i class='hasNoResults'>No matching results</i> </center>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="swiper-leeveroom">
                    <p class="title-search">Populair zoeken</p>
                    <div class="swiper-container new-swiper-modal">
                        <div class="swiper-wrapper">
                            <a href="/product-search?filter=Podcast" class="btn swiper-slide">Podcasts</a>
                            <a href="/product-search?filter=Video" class="btn swiper-slide">Video's</a>
                            <a href="/product-search?filter=Opleidingen" class="btn swiper-slide">Opleiding</a>
                            <a href="/product-search?filter=Artikel" class="btn swiper-slide">Artikel</a>
                            <a href="/product-search?filter=Assessment" class="btn swiper-slide">Assessment</a>
                            <a href="/product-search?filter=E-Learning" class="btn swiper-slide">E-learning</a>
                            <a href="/product-search?filter=Masterclass" class="btn swiper-slide">Masterclass</a>
                            <a href="/product-search?filter=Workshop" class="btn swiper-slide">Workshop</a>
                            <a href="/product-search?filter=Event" class="btn swiper-slide">Event</a>
                            <a href="/product-search?filter=Training" class="btn swiper-slide">Training</a>
                            <a href="/product-search?filter=Lezing" class="btn swiper-slide">Lezing</a>
                            <a href="/product-search?filter=Webinar" class="btn swiper-slide">Webinar</a>
                        </div>
                    </div>

                </div>
                <div class="block-top-header">
                    <div class="blockGroupText">
                        <a href="/main-category-overview/?main=1" class="titleGroupText">Opleiden richting een baan </a>

                        <div class="sousBlockGroupText">
                            <?php
                            foreach($bangerichts as $bangericht){
                                ?>
                                <a href="sub-topic?subtopic=<?php echo $bangericht->cat_ID ?>" class="TextZorg"><?php echo $bangericht->cat_name ?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="blockGroupText">
                        <a href="/main-category-overview/?main=4" class="titleGroupText">Groeien binnen je functie </a>

                        <div class="sousBlockGroupText">
                            <?php
                            foreach($functies as $functie){
                                ?>
                                <a href="sub-topic?subtopic=<?php echo $functie->cat_ID ?>" class="TextZorg"><?php echo $functie->cat_name ?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="blockGroupText">
                        <a href="/main-category-overview/?main=3" class="titleGroupText">Relevante skills ontwikkelen:</a>

                        <div class="sousBlockGroupText">
                            <?php
                            foreach($skills as $skill){
                                ?>
                                <a href="sub-topic?subtopic=<?php echo $skill->cat_ID ?>" class="TextZorg"><?php echo $skill->cat_name ?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="blockGroupText">
                        <a href="/main-category-overview/?main=2" class="titleGroupText">Persoonlijke interesses & vrije tijd</a>

                        <div class="sousBlockGroupText">
                            <?php
                            foreach($interesses as $interesse){
                                ?>
                                <a href="sub-topic?subtopic=<?php echo $interesse->cat_ID ?>" class="TextZorg"><?php echo $interesse->cat_name ?></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="block-Suggesties">
                    <p class="title-search">
                        Suggesties
                    <div class="newtons-cradle d-none" id="loader-suggestion-search-bar">
                        <div class="newtons-cradle__dot"></div>
                        <div class="newtons-cradle__dot"></div>
                        <div class="newtons-cradle__dot"></div>
                    </div>
                    </p>
                    <ul class="secondUlModal" id="back-for-search-bar">
                        <!-- back for serach ba, searching course -->
                    </ul>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- for search  -->


<script src="<?php echo get_stylesheet_directory_uri();?>/organictabs.jquery.js"></script>
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
    document.addEventListener('DOMContentLoaded', function() {
        const searchInputs = document.querySelectorAll('.inputSearch');
        const blockTopHeader = document.querySelector('.block-top-header');
        const blockSuggesties = document.querySelector('.block-Suggesties');

        searchInputs.forEach(function(searchInput) {
            searchInput.addEventListener('input', function() {
                if (searchInput.value.trim() !== '') {
                    // Afficher block-Suggesties et masquer block-top-header
                    blockSuggesties.style.display = 'block';
                    blockTopHeader.style.display = 'none';
                } else {
                    // Masquer block-Suggesties et afficher block-top-header
                    blockSuggesties.style.display = 'none';
                    blockTopHeader.style.display = 'block';
                }
            });
        });
    });
</script>
