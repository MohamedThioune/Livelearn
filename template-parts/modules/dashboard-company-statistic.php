
<?php

$user_id = get_current_user_id();
$company = get_field('company',  'user_' . $user_id );
$company_connected = $company[0]->post_title;
$users = get_users();
$members = array();
$numbers = array();
foreach ($users as $user ) {
    $company = get_field('company',  'user_' . $user->ID);
    if($company[0]->post_title == $company_connected)
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
$students = array();
$sells = 0;

$popular_courses = array();
$sale_courses = array();

//Popular courses
$args = array(
    'limit' => -1,
);

$bunch_orders = wc_get_orders($args);
$cids = array();

foreach( $bunch_orders as $order ){
    foreach( $order->get_items() as $item_id => $item ) {
        $course_id = intval($item->get_product_id()) - 1;
        $course = get_post($course_id);
        if(isset($course->post_author))
            if(in_array($course->post_author, $numbers)){
                array_push($cids, $course->ID);
                array_push($students, $course->post_author);
                $sells+=1;
            }
    }
}
$cids = array_count_values($cids);
$students = array_count_values($students);
$students = count($students);
arsort($cids);
    
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
                    <p class="numberActivity"><?php echo $students; ?></p>
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
        <div class="col-md-7">
            <div class="cardEngagedAudiance">
                <h2>Engaged Audiance</h2>
                <div class="wrapper w-100">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="cardNotification mt-3 mt-md-0">
                <h2>The most popular courses</h2>
                    <?php
                    $i = 0;
                    foreach($cids as $key => $cid){
                        $i++;
                        if($i > 3)
                            break;

                        $course = get_post($key);
                        
                        /*
                        * Categories
                        */
                        $category = ' ';
                                        
                        $category_id = 0;
                        $category_string = " ";
                        
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
                            $price =  number_format($p, 2, '.', ',') ;
                        else
                            $price = 'Gratis';

                        /*
                        * Thumbnails
                        */ 
                        $thumbnail = get_field('preview', $course->ID)['url'];
                        if(!$thumbnail){
                            $thumbnail = get_field('url_image_xml', $course->ID);
                            if(!$thumbnail)
                                $thumbnail = get_field('image', 'category_'. $category_id);
                                if(!$thumbnail)
                                    $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                        }    
                    ?>
                    <a href="">
                        <div class="contentStats mb-3 mb-">
                            <div class="contentImgName w-25">
                                    <img src="<?= $thumbnail ?>"
                                     class="img-fluid w-100 h-100" alt="">  
                                <div class="ml-3">
                                    <p class="nameCoursSales mb-0 mb-md-2"><?= $course->post_title ?></p>
                                    <p class="categoriesNameCours"><?= $category ?></p>
                                </div>
                            </div>
                            <p class="priceHistory"><?= $price ?> $</p>
                        </div>
                    </a>  
                    <?php
                    }
                    ?>  
                    <div class="d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- ----------------------------------- end new table -------------------------------------- -->
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-md-4 mt-3 mt-md-2">
            <div class="cardStats mt-3 pb-0">
                <h2>Most viewed topics</h2>

                <!-- ---------------------------------- start new table ------------------------------------- -->
                <a href="">
                    <div class="contentStats mb-3">
                        <div class="contentImgName">
                            <div class="statsImgCours">
                                <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                            </div>
                        <div>
                            <p class="nameCoursSales mb-0">Adobe xd Part 01</p>
                            <p class="categoriesNameCours">Seydou</p>
                        </div>
                        </div>
                        <p class="priceHistory">220 $</p>
                    </div>
                </a>
                <a href="">
                    <div class="contentStats mb-3">
                        <div class="contentImgName">
                            <div class="statsImgCours">
                                <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                            </div>
                        <div>
                            <p class="nameCoursSales mb-0">Mathmatics</p>
                            <p class="categoriesNameCours">Mass</p>
                        </div>
                        </div>
                        <p class="priceHistory">80 $</p>
                    </div>
                </a>    

                <a href="">
                    <div class="contentStats mb-3">
                        <div class="contentImgName">
                            <div class="statsImgCours">
                                <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                            </div>
                        <div>
                            <p class="nameCoursSales mb-0">Angular</p>
                            <p class="categoriesNameCours">Mamadou</p>
                        </div>
                        </div>
                        <p class="priceHistory">30 $</p>
                    </div>
                </a>    

                <a href="">
                    <div class="contentStats mb-3">
                        <div class="contentImgName">
                            <div class="statsImgCours">
                                <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                            </div>
                        <div>
                            <p class="nameCoursSales mb-0">Symfony</p>
                            <p class="categoriesNameCours">Fadel</p>
                        </div>
                        </div>
                        <p class="priceHistory">120 $</p>
                    </div>
                </a>     

                <a href="">
                    <div class="contentStats mb-3">
                        <div class="contentImgName">
                            <div class="statsImgCours">
                                <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                            </div>
                        <div>
                            <p class="nameCoursSales mb-0">Adobe xd Part 01</p>
                            <p class="categoriesNameCours">Alioune</p>
                        </div>
                        </div>
                        <p class="priceHistory">90 $</p>
                    </div> 
                </a>

                <div class="d-flex justify-content-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- ----------------------------------- end new table -------------------------------------- -->
            </div>
        </div>
        <div class="col-md-4 mt-3 mt-md-2">
            <div class="cardStats mt-3 pb-0">
                <h2>Most followed topics</h2>
                
                <!-- ---------------------------------- start new table ------------------------------------- -->
                <a href="">
                    <div class="contentStats mb-3">
                        <div class="contentImgName">
                            <div class="statsImgCours">
                                <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                            </div>
                        <div>
                            <p class="nameCoursSales mb-0">Adobe xd Part 01</p>
                            <p class="categoriesNameCours">Seydou</p>
                        </div>
                        </div>
                        <p class="priceHistory">220 $</p>
                    </div>
                </a>
                <a href="">
                    <div class="contentStats mb-3">
                        <div class="contentImgName">
                            <div class="statsImgCours">
                                <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                            </div>
                        <div>
                            <p class="nameCoursSales mb-0">Mathmatics</p>
                            <p class="categoriesNameCours">Mass</p>
                        </div>
                        </div>
                        <p class="priceHistory">80 $</p>
                    </div>
                </a>    

                <a href="">
                    <div class="contentStats mb-3">
                        <div class="contentImgName">
                            <div class="statsImgCours">
                                <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                            </div>
                        <div>
                            <p class="nameCoursSales mb-0">Angular</p>
                            <p class="categoriesNameCours">Mamadou</p>
                        </div>
                        </div>
                        <p class="priceHistory">30 $</p>
                    </div>
                </a>    

                <a href="">
                    <div class="contentStats mb-3">
                        <div class="contentImgName">
                            <div class="statsImgCours">
                                <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                            </div>
                        <div>
                            <p class="nameCoursSales mb-0">Symfony</p>
                            <p class="categoriesNameCours">Fadel</p>
                        </div>
                        </div>
                        <p class="priceHistory">120 $</p>
                    </div>
                </a>     

                <a href="">
                    <div class="contentStats mb-3">
                        <div class="contentImgName">
                            <div class="statsImgCours">
                                <img id="money" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                            </div>
                        <div>
                            <p class="nameCoursSales mb-0">Adobe xd Part 01</p>
                            <p class="categoriesNameCours">Alioune</p>
                        </div>
                        </div>
                        <p class="priceHistory">90 $</p>
                    </div> 
                </a>

                <div class="d-flex justify-content-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- ----------------------------------- end new table -------------------------------------- -->

               
            </div>
        </div>
        <div class="col-md-4 mt-3 mt-md-2 mb-5 mb-md-0">
            <div class="cardStats mt-3">
                <h2>Most active users</h2>

                <?php echo $most_active_members ?>

                <div class="d-flex justify-content-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>

        </div>
    </div>
    </div>



</div>


<script src="<?php echo get_stylesheet_directory_uri();?>/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
    ];

    const data = {
        labels: labels,
        datasets: [{
        label: 'Monthly / Yearly users',
        backgroundColor: '#023356',
        borderColor: '#023356',
        data: [0, 10, 5, 2, 20, 30, 45],
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {}
    };
</script>
<script>
  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>
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