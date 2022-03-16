
<?php
   $args = array(
    'post_type' => 'course', 
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',                          
    );

    $courses = get_posts($args);
?>
    <div class="contentListeCourse">
        <div class="cardOverviewCours">
            <div class="headListeCourse">
                <p class="JouwOpleid">Alle opleidingen</p>
                <input type="search" class="searchInputAlle" placeholder="Zoek opleidingen, experts of ondervwerpen">
                <a href="" class="btnNewCourse">Nieuwe course</a>
            </div>
            <div class="contentCardListeCourse">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th scope="col">Titel</th>
                   <!-- <th scope="col">Leervorm</th> -->                    
                        <th scope="col">Prijs</th>
                        <th scope="col">Onderwerp(en)</th>
                        <th scope="col">Startdatum</th>
                        <th scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($courses as $course){

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
                            /*
                            * Price 
                            */
                            $p = get_field('price', $course->ID);
                            if($p != "0")
                                $price = number_format($p, 2, '.', ',');
                            else 
                                $price = 'Gratis';

                            /*
                            *  Date and Location
                            */ 
                            $location = ' ';

                            $data = get_field('data_locaties', $course->ID);
                            if(!empty($data)){
                                $date = $data[0]['data'];
                                if(!empty($date)){
                                    $date = $date[0]['start_date'];
                                    $day = explode(' ', $date)[0];
                                }
                            }
                            else{
                                $day = '~';
                                $dates = get_field('dates', $course->ID);
                                if($dates)
                                    $day = explode(' ', $dates[0]['date']);
                                else{
                                    $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                                    $date = $data[0];
                                    $day = explode(' ', $date)[0];
                                }
                            }
                        ?>
                        <tr>
                            <td class="textTh elementOnder"><a style="color:#212529;font-weight:bold" href="<?php echo get_permalink($course->ID) ?>"><?php echo $course->post_title; ?></a></td>
                            <td class="textTh"><?php echo $price; ?></td>
                            <td class="textTh elementOnder"> <?php echo $category ?> </td>
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
        



</body>
</html>




