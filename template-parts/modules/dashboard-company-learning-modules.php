<?php

$user_connected = get_current_user_id();
$company_connected = get_field('company',  'user_' . $user_connected);
$users_companie = array();

$users = get_users();

foreach($users as $user) {
    $company_user = get_field('company',  'user_' . $user->ID);
    if(!empty($company_connected) && !empty($company_user))
        if($company_user[0]->post_title == $company_connected[0]->post_title)
            array_push($users_companie,$user->ID);
}

$args = array(
    'post_type' => 'course', 
    'posts_per_page' => -1,
    'author__in' => $users_companie,  
);

$courses = get_posts($args);

$user_in = wp_get_current_user();




//bought courses
$order_args = array(
    'post_status' => array_keys(wc_get_order_statuses()), 
    'post_status' => array('wc-processing'),

);
$orders = wc_get_orders($order_args);

var_dump($orders);

?>
<div class="contentListeCourse">
    <div class="cardOverviewCours">
        <div class="headListeCourse">
            <p class="JouwOpleid">Gekochte opleidingen</p>
<!--            <a href="/dashboard/teacher/course-selection/" class="btnNewCourse">Nieuwe course</a>-->
        </div>

        <div class="contentCardListeCourse">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th scope="col">Aangekocht</th>
                        <th scope="col">Ordernummer</th>
                        <th scope="col">Datum van aanschaf</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

    foreach($orders as $order){        

                    ?>
                    <tr>
                        <td class="textTh"><a href="/dashboard/company/assign/?payment_id=<?php echo $order->get_id();?>">Openen</a></td>
                        <td class="textTh">Order <?php echo $order->get_id();?></td>
                        <td class="textTh"><?php echo $order->get_date_paid();?></td>
                        <td class="textTh"><?php echo $order->get_status();?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>





    <div class="cardOverviewCours">
        <div class="headListeCourse">
            <p class="JouwOpleid">Jouw opleidingen</p>
            <?php 
                if ( in_array( 'manager', $user_in->roles ) || in_array('administrator', $user_in->roles)) 
                    echo '<a href="/dashboard/teacher/course-selection/" class="btnNewCourse">Nieuwe course</a>';
            ?>
        </div>

        <div class="contentCardListeCourse">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th scope="col">Titel</th>
                        <th scope="col">Leervorm</th>
                        <th scope="col">Prijs</th>
                        <th scope="col">Onderwerp(en)</th>
                        <th scope="col">Startdatum</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($courses as $course){
                        /*
                            * Categories
                            */
                        $day = "<p><i class='fas fa-calendar-week'></i></p>";
                        $month = ' ';

                        $category = ' ';

                        $tree = get_the_terms($course->ID, 'course_category'); 

                        if($tree)
                            if(isset($tree[2]))
                                $category = $tree[2]->name;

                        $category_id = 0;

                        if($category == ' '){
                            $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                            if($category_id != 0)
                                $category = (String)get_the_category_by_ID($category_id);
                        }

                        $location = ' ';

                        $data = get_field('data_locaties', $course->ID);
                        if($data){
                            $date = $data[0]['data'][0]['start_date'];
                            if($date != ""){
                                $day = explode(' ', $date)[0];
                            }
                        }else{
                            $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                            $date = $data[0];
                            $day = explode(' ', $date)[0];
                        }

                        /*
                            * Price
                            */
                        $p = get_field('price', $course->ID);
                        if($p != "0")
                            $price =  number_format($p, 2, '.', ',');
                        else
                            $price = 'Gratis';

                        // Course type
                        $course_type = get_field('course_type', $course->ID) 

                    ?>
                    <tr>
                        <td class="textTh"><a style="color:#212529;" href="<?php echo get_permalink($course->ID) ?>"><?php echo $course->post_title; ?></a></td>
                        <td class="textTh"><?php echo $course_type; ?></td>
                        <td class="textTh"><?php echo $price; ?></td>
                        <td class="textTh"><?php echo $category; ?></td>
                        <td class="textTh"><?php echo $day; ?></td>
                        <td class="textTh">Live</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


