<?php /* Template Name: dashboard individual */ ?>
<?php wp_head(); ?>
<?php get_header();?>
<?php 

    $args = array(
        'post_type' => 'course', 
        'post_status' => 'publish',
        'posts_per_page' => '50',
    );

    $courses = get_posts($args);

    $categories = array();

    $cats = get_categories( array(
        'taxonomy'   => 'category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );
    

    foreach($cats as $category){
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($categories, $category);
    }

?>
<div class="theme-content">
    <div class="theme-side-menu">
        <div class="row">
            <div class="col">
                <div class="theme-side-menu__list">
                    <ul>
                        <li>Dashboard</li>
                        <li class="theme-side-menu__item active">Opleiding toevoegen</li>
                        <li>overzicht opleidingen</li>
                        <li>inschrijven</li>
                        <li>berichten</li>
                        <li>financien</li>
                        <li>statestieken</li>
                        <li>instellingen</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="theme-learning">
        <div class="theme-content__title">
            Trending E-learnings - Heroes
        </div>
        <div class="row slick-slider-large">
            <?php
                $i = 0;
                foreach($courses as $course){
                    if(!get_field('visibility', $course->ID)) {
                        if(get_field('course_type', $course->ID) == "E-learning"){
                            /*
                                * Categories and Date
                                */    
                                $tree = get_the_category($course->ID);
                                if($tree){
                                    if(isset($tree[2]))
                                        $category = $tree[2]->cat_name;
                                    else 
                                        if(isset($tree[1]))
                                            $category = $tree[1]->cat_name;
                                }else 
                                    $category = ' ~ ';

                                $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];    

                                $dates = get_field('dates', $course->ID);
                                if($dates){
                                    
                                    $day = explode('-', explode(' ', $dates[0]['date'])[0])[2];
                                    $month = explode('-', explode(' ', $dates[0]['date'])[0])[1];
        
                                    $month = $calendar[$month]; 
                                   
                                }else{
                                    $day = '~';
                                    $month = '';
                                }
                               
                                /*
                                * Price 
                                */
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                                else 
                                    $price = 'Gratis';

                                /*
                                * Thumbnails
                                */ 
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_stylesheet_directory_uri() . '/img/placeholder.png';

                                //Image author of this post 
                                $image_author = get_field('profile_img',  'user_' . $course->post_author);
            ?>
            <a href="<?php echo get_permalink($course->ID) ?>" class="col-4">
                <div class="theme-card__small-course">
                    <div class="theme-card__header-area">
                        <div class="theme-card__header-image">
                        </div>
                        <div class="theme-card__header-info">
                            <div class="theme-card__course-category">
                                <?php echo $category ?>
                            </div>
                            <div class="theme-card__course-level">
                                <?php echo get_field('degree', $course->ID);?>
                            </div>
                            <div class="theme-card__course-duration">
                                <?php echo $day . " " . $month ?>
                            </div>
                            <div class="theme-card__course-price">
                                <?php echo $price ?>
                            </div>
                        </div>
                    </div>
                    <div class="theme-card__course-info">
                        <div class="theme-card__course-info-top">
                            <div class="row">
                                <div class="col-xl-5 col-md-12 col-sm-6">
                                    <div class="theme-card__author">
                                        <img width="17" src="<?php echo $image_author ?>" alt="" >
                                      <?php echo(get_userdata($course->post_author)->data->display_name); ?>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-3">
                                    <div class="theme-card__type">
                                        <?php echo get_field('course_type', $course->ID) ?>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-3">
                                    <div class="theme-card__location">
                                        Amsterdam
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="theme-card__title">
                                    <?php echo $course->post_title;?>
                                </div>
                                <div class="theme-card__content">
                                    <?php echo $course->post_excerpt;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <?php
                        if ($i == 4)
                        break;
                    }
                }
            $i++;
            }
            ?>
        </div>

        <div class="theme-content__title">
            Online Events
        </div>
        <div class="row slick-slider-small">
            <?php
                $i = 0;
                foreach($courses as $course){
                    if(!get_field('visibility', $course->ID)) {
                        if(get_field('course_type', $course->ID) == "Event"){
                            /*
                                * Categories and Date
                                */    
                                $tree = get_the_category($course->ID);
                                if($tree){
                                    if(isset($tree[2]))
                                        $category = $tree[2]->cat_name;
                                    else 
                                        if(isset($tree[1]))
                                            $category = $tree[1]->cat_name;
                                }else 
                                    $category = ' ~ ';

                                $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];    

                                $dates = get_field('dates', $course->ID);
                                if($dates){
                                    
                                    $day = explode('-', explode(' ', $dates[0]['date'])[0])[2];
                                    $month = explode('-', explode(' ', $dates[0]['date'])[0])[1];
        
                                    $month = $calendar[$month]; 

                                    $hour = explode(':', explode(' ', $dates[0]['date'])[1])[0];
                                    $minute = explode(':', explode(' ', $dates[0]['date'])[1])[1];
                                   
                                }else{
                                    $day = '~';
                                    $month = '';
                                    $hour = '~';
                                    $minute = '';
                                }

                                /*
                                * Price 
                                */
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                                else 
                                    $price = 'Gratis';

                                /*
                                * Thumbnails
                                */ 
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_stylesheet_directory_uri() . '/img/placeholder.png';

                                //Image author of this post 
                                $image_author = get_field('profile_img',  'user_' . $course->post_author);
            ?>
            <a href="<?php echo get_permalink($course->ID) ?>" class="col-3">
                <div class="theme-card__small-course">
                    <div class="theme-card__header-area">
                        <div class="theme-card__header-image">
                        </div>
                        <div class="theme-card__header-info">
                            <div class="theme-card__course-time">
                                <?php echo $hour .":". $minute ?>
                            </div>
                            <div class="theme-card__course-date">
                                <?php echo $day . " " . $month ?>
                            </div>
                            <div class="theme-card__course-price">
                                <?php echo $price ?>
                            </div>
                        </div>
                    </div>
                    <div class="theme-card__course-info">
                        <div class="theme-card__title">
                            <?php echo $course->post_title;?>
                        </div>
                        <div class="theme-card__content">
                            <?php echo $course->post_excerpt;?>
                        </div>
                    </div>
                </div>
            </a>
            <?php
                        if ($i == 6)
                        break;
                    }
                }
            $i++;
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer();?>
<?php wp_footer(); ?>