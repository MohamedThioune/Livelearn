<?php

$id = get_current_user_id();

if($id != 0){

    $args = array(
        'post_type' => 'course', 
        'posts_per_page' => -1,
        'author' => $id,  
    );

    $courses = get_posts($args);
    
}

?>
<div class="contentListeCourse">
    <div class="cardOverviewCours">
        <div class="headListeCourse">
            <?php if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span>"?>
            <p class="JouwOpleid">Overzicht leermodules</p>
            <a href="/dashboard/teacher/course-selection/" class="btnNewCourse">Nieuwe</a>
        </div>
        <div class="contentCardListeCourse">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th scope="col">Actie</th>
                        <th scope="col">Verkoop</th>
                        <th scope="col">Titel</th>
                        <!-- th scope="col">Leervorm</th> -->                    
                        <th scope="col">Prijs</th>
                        <th scope="col">Onderwerp(en)</th>
                        <th scope="col">Startdatum</th>
                        <th scope="col">Optie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($courses as $course){

                        /*
                        * Categories
                        */
                        $category = ' ';
                        $day = "<p><i class='fas fa-calendar-week'></i></p>";

                        $tree = get_the_terms($course->ID, 'course_category'); 

                        $category = ' ';

                            $tree = get_the_terms($course->ID, 'course_category'); 

                            if($tree)
                                if(isset($tree[2]))
                                    $category = $tree[2]->name;
                                
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
                            $price = number_format($p, 2, '.', ',');
                        else 
                            $price = 'Gratis';

                        /*
                        *  Date and Location
                        */ 
                        $location = ' ';

                        $data = get_field('data_locaties', $course->ID);
                        if($data){
                            $date = $data[0]['data'][0]['start_date'];
                            $day = explode(' ', $date)[0];
                        }
                        else{
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
                    <tr id="<?php echo $course->ID;?>" >
                        <td class="textTh">
                            <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $course->ID;?>&edit"><i class="fas fa-edit"></i></a>
                        </td>
                        <td class="textTh"><?php if(!empty(get_field('connected_product',$course->ID))){echo 'ja';}else{echo 'nee';}?></td>
                        <td class="textTh "><a style="color:#212529;font-weight:bold" href="<?php echo get_permalink($course->ID) ?>"><?php echo $course->post_title; ?></a></td>
                        <td class="textTh"><?php echo $price; ?></td>
                        <td class="textTh "><?php echo $category ?></td>
                        <td class="textTh"><?php echo $day; ?></td>
                        <td class="textTh remove"><i class='delete-course fas fa-trash-alt'></i></td>
                    </tr>
                    <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(".remove").click(function(){
        var id = $(this).parents("tr").attr("id");

        if(confirm('Are you sure to remove this record ?'))
        {
            $.ajax({
               url: '/delete-course',
               type: 'GET',
               data: {id: id},
               error: function() {
                  alert('Something is wrong');
               },
               success: function(data) {
                    $("#"+id).remove();
                    alert("Record removed successfully");  
               }
            });
        }
    });

</script>