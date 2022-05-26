
<?php

$user_id = get_current_user_id();
$company = get_field('company',  'user_' . $user_id );
$company_connected = $company[0]->post_title;
$users=get_users();
$members=array();
$numbers=array();
foreach ($users as $user ) {
    $company = get_field('company',  'user_' . $user->ID);
    if ($company[0]->post_title == $company_connected)
    {
        array_push($numbers,$user->ID);
        array_push($members,$user);                            
    }
}

//FADEL CODE 
$most_active_members= '';
foreach ($members as $key => $value) {
    if ($key==3)
        break;
    $image_author = get_field('profile_img',  'user_' . $value->ID);
    $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
    $most_active_members.='
    <div class="contentStats">
    <div class="contentImgName">
        <div class="statsImgCours">
            <img id="money" src="' . $image_author . '" alt="">
        </div>
    <div>
        <p class="nameCoursSales">'.$value->first_name.'</p>
        <p class="categoriesNameCours">'.get_field('role',  'user_' . $value->ID).'</p>
    </div>
    </div>
    <a href="/user-overview?id='. $value->ID .'" class="btn btnViewProfilActiveM">View Profil</a>
    </div>';
}

/*
* * Get courses
*/
$args = array(
    'post_type' => 'course', 
    'posts_per_page' => -1,
    'author__in' => $numbers,  
);

$courses = get_posts($args);

$outros = array();
$outroes = array();
$intros = array();
$sells = 0;

$popular_courses = array();
$sale_courses = array();

foreach($courses as $course){
    global $wpdb;
    $outro = array();
    $courseid = intval($course->ID) + 1;
    $results = $wpdb->get_results("SELECT meta_value,entry_id FROM wpe7_gf_entry_meta WHERE form_id = 1 AND meta_value =" . $courseid);
    $entries = count($results);

    if(!empty($results)){
        foreach($results as $value){
            $value = intval($value->meta_value) - 1;
            if(array_search($value, array_column($outros, 'entry')) === false) {
                $outro['values'] = $entries;
                $outro['entry'] = $value;
                array_push($outros, $outro);
            }
            if(!in_array($value, $intros))
                array_push($intros,$value);
        }
    }
}
asort($outros);
$outros = array_reverse($outros);

foreach($outros as $key=>$outroe){
    print_r($outroe);
    if($key <= 2)
        array_push($outroes, $outroe['entry']);
    $sells += intval($outroe['values']);
}

// The most popular courses 
if(!empty($outroes)){
    $args = array(
        'post_type' => 'course', 
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'include' => $outroes,  
    );

    $popular_courses = get_posts($args);
}

// Sales stats
if(!empty($intros)){
    $args = array(
        'post_type' => 'course', 
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'include' => $intros,  
    );

    $sale_courses = get_posts($args);
}

    
?>




<div class="contentActivity">
    <h1 class="activityTitle">Statistics</h1>
    <div class="row">
        <div class="col-lg-3 col-md-2 col-sm-6">
            <div class="cardHeadActivity">
                <div class="blockImgCardActivity bleu">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/vaadin_line-bar-chart.png" alt="">
                </div>
                <div class="detailCardActivity">
                    <p class="numberActivity">0</p>
                    <p class="nameCardActivity">Total Audiance</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-2 col-sm-6">
            <div class="cardHeadActivity red">
                <div class="blockImgCardActivity">
                    <img id="student" src="<?php echo get_stylesheet_directory_uri();?>/img/ph_student.png" alt="">
                </div>
                <div class="detailCardActivity">
                    <p class="numberActivity"><?php echo $sells; ?></p>
                    <p class="nameCardActivity">Total Student</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-2 col-sm-6">
            <div class="cardHeadActivity yellow">
                <div class="blockImgCardActivity">
                    <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/cil_money.png" alt="">
                </div>
                <div class="detailCardActivity">
                    <p class="numberActivity"><?php echo $sells; ?></p>
                    <p class="nameCardActivity">Total Sells</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-2 col-sm-6">
            <div class="cardHeadActivity green">
                <div class="blockImgCardActivity bleu">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/glif.png" alt="">
                </div>
                <div class="detailCardActivity">
                
                    <p class="numberActivity"><?php echo count($members);?></p>
                    <p class="nameCardActivity">Active Members</p>
                    
                    


                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7">
            <div class="cardEngagedAudiance">
                <h2>Engaged Audiance</h2>
                <div class="wrapper w-100">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="cardNotification">
                <h2>The most popular courses</h2>
                <?php 
                    foreach($popular_courses as $key=>$course) {
                        if($key == 2)
                            break;

                        $rand = intval(rand(5, 100));

                        /*
                        * Company
                        */
                        $company = get_field('company',  'user_' . $course->post_author);
                        $company_title = $company[0]->post_title;

                ?>   
                    <a href="<?php echo get_permalink($course->ID); ?>" class="cartPopularCourse">
                        <div class="circle_percent" data-percent="<?php echo $rand; ?>">
                            <div class="circle_inner">
                                <div class="round_per">
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="elementCardPopularCourse"> <b><?php echo $course->post_title; ?></b> </p>
                            <p class="elementCardPopularCourse">By : <?php echo $company_title; ?></p>
                            <button class="btn btnViewListRe">View list registered</button>
                        </div>
                    </a>
                <?php
                    }
                ?>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-lg-4 colModifeStats">
            <div class="cardStats">
                <h2>Sales stats</h2>
                <?php 
                foreach($sale_courses as $key=>$course) {
                    if($key == 2)
                        break;
                        
                    /*
                    * Categories
                    */
                
                    $category = ' ';
                                
                    $category_id = 0;
                    $category_string = " ";

                    $tree = get_the_terms($course->ID, 'course_category'); 
                        if($tree)
                            if(isset($tree[2]))
                                $category = $tree[2]->name;
                    
                    if($category == ' '){
                        $category_str = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]);
                        $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                        if($category_str != 0)
                            $category = (String)get_the_category_by_ID($category_str);
                        else if($category_id != 0)
                            $category = (String)get_the_category_by_ID($category_id);                                    
                    }

                    /*
                    * Price
                    */
                    $p = get_field('price', $course->ID);
                    if($p != "0")
                        $price =  number_format($p, 2, '.', ',');
                    else
                        $price = 'Gratis';

                    /*
                    * Thumbnails
                    */
                    $thumbnail = get_field('preview', $course->ID)['url'];
                    if(!$thumbnail){
                        $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                        if(!$thumbnail)
                            $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                    }

                ?>
                <div class="contentStats">
                    <div class="contentImgName">
                        <div class="statsImgCours">
                            <img id="money" src="<?php echo $thumbnail;?>" alt="">
                        </div>
                       <div>
                           <p class="nameCoursSales"><?php echo $course->post_title; ?></p>
                           <p class="categoriesNameCours"><?php echo $category; ?></p>
                       </div>
                    </div>
                    <p class="price"><?php echo $price ?></p>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="col-lg-4 colModifeStats">
            <div class="cardStats">
                <h2>Earnings history</h2>
                
                <!-- <div class="contentStats">
                    <div class="contentImgName">
                        <div class="statsImgCours">
                            <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                        </div>
                       <div>
                           <p class="nameCoursSales">Adobe xd Part 01</p>
                           <p class="categoriesNameCours">UX-UI Design</p>
                       </div>
                    </div>
                    <p class="priceHistory">20 $</p>
                </div>
                <div class="contentStats">
                    <div class="contentImgName">
                        <div class="statsImgCours">
                            <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                        </div>
                       <div>
                           <p class="nameCoursSales">Adobe xd Part 01</p>
                           <p class="categoriesNameCours">UX-UI Design</p>
                       </div>
                    </div>
                    <p class="priceHistory">20 $</p>
                </div>
                <div class="contentStats">
                    <div class="contentImgName">
                        <div class="statsImgCours">
                            <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                        </div>
                       <div>
                           <p class="nameCoursSales">Adobe xd Part 01</p>
                           <p class="categoriesNameCours">UX-UI Design</p>
                       </div>
                    </div>
                    <p class="priceHistory">20 $</p>
                </div> -->
            </div>
        </div>
        <div class="col-lg-4 colModifeStats">
            <div class="cardStats">
                <h2>Most active members</h2>
                    <?php echo $most_active_members ?>
            </div>
        </div>
    </div>
    </div>



</div>


<script src="<?php echo get_stylesheet_directory_uri();?>/chart.min.js"></script>

<script >

    $(".circle_percent").each(function() {
        var $this = $(this),
            $dataV = $this.data("percent"),
            $dataDeg = $dataV * 3.6,
            $round = $this.find(".round_per");
        $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)");
        $this.append('<div class="circle_inbox"><span class="percent_text"></span></div>');
        $this.prop('Counter', 0).animate({Counter: $dataV},
            {
                duration: 2000,
                easing: 'swing',
                step: function (now) {
                    $this.find(".percent_text").text(Math.ceil(now)+"%");
                }
            });
        if($dataV >= 51){
            $round.css("transform", "rotate(" + 360 + "deg)");
            setTimeout(function(){
                $this.addClass("percent_more");
            },1000);
            setTimeout(function(){
                $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)");
            },1000);
        }
    });

</script>

<script>
    var ctx = document.getElementById('myChart').getContext("2d");

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SPT", "OTB", "NVB", "DEC"],
            datasets: [{
                label: "Data",
                fill: false,
                borderWidth: 1,
                tension: 0.1,
                borderColor: 'rgb(75, 192, 192)',
                data: [100, 120, 150, 170, 180, 170, 160, 170, 170, 170, 170, 150]
            }]
        },
        options: {
            legend: {
                position: "bottom"
            },

        }
    });

</script>
<script>
    var cont = 0
    var initialTime = $('.chart').data('percent');
    $(function() {
        //create instance
        $('.chart').easyPieChart({
            size: 230,
            barColor: "#EE4224",
            scaleLength: 0,
            lineWidth: 10,
            trackColor: "",
            lineCap: "circle",
            animate: 1000,
        });

        var interval = setInterval(function() {

            cont = cont + 0.3
            $('.chart').data('easyPieChart').update(initialTime + cont);

            console.log(initialTime + cont)

            if(initialTime + cont >= 100){
                clearInterval(interval)
            }
        }, 1000);

    });

</script>