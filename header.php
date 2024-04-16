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
//include_once(dirname(__FILE__).'/header_base.php');
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
<div class="modal  dropdown-search" id="for-search-element" tabindex="-1" role="dialog" aria-labelledby="voorOpleidersLabel" aria-hidden="true">
    <div class="container-fluid">
        <section class="content-product-search">
            <div class="container-fluid">
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
