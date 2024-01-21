<?php /** Template Name: select course type */ ?>

<?php

extract($_POST);

//$page = 'check_visibility.php';
//require($page);

$users = get_users();
$data_user = wp_get_current_user();
$user_connected = $data_user->data->ID;
$company = get_field('company',  'user_' . $user_connected);

if(!empty($company))
    $company_connected = $company[0]->post_title;

$member_id = array();
foreach($users as $user)
    if($user_connected != $user->ID ){
        $company = get_field('company',  'user_' . $user->ID);
        if(!empty($company)){
            $company = $company[0]->post_title;
            if($company == $company_connected)
                array_push($member_id, $user->ID);
        }
    }

$args = array(
    'post_type' => array('course','post','leerpad','assessment'),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',                          
);
$global_course = get_posts($args);

$args = array(
    'post_type' => array('course','post','leerpad','assessment'),
    'post_status' => 'publish',
    'order' => 'DESC',
    'posts_per_page' => -1,
    'author__in' => $member_id                          
);
$internal_course = get_posts($args);

$row = '<label class="sub-label">Select Your Courses</label>
        <div class="search-multi-select-group">
            <select class="selectpicker" aria-label="Select the course" data-live-search="true" form="mandatory-form" name="course_must" required>
                <option value=""></option>';

//Legend image
// $thumbnail = get_field('preview', $course->ID)['url'];
// if(!$thumbnail){
//     $thumbnail = get_the_post_thumbnail_url($course->ID);
//     if(!$thumbnail)
//         $thumbnail = get_field('url_image_xml', $course->ID);
//     if(!$thumbnail)
//         $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
// }

$type_course = (isset($search_type_course) ? $search_type_course : 0);

if($type_course && $type_course != "0")
    if($type_course == "internal")
        foreach($internal_course as $key => $course)
            $row .= '<option value="' . $course->ID . '">'. $course->post_title .'</option>';
    else
        foreach($internal_course as $key => $course){
            //Control visibility
            $bool = true;
            $bool = visibility($course, $visibility_company);
            if(!$bool)
                continue;
            $row .= '<option value="' . $course->ID . '">'. $course->post_title .'</option>';
        }
    
    $row .= "</select>
            </div>";

    echo $row;
?>


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