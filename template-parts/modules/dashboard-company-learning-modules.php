<?php


$user_connected = get_current_user_id();
$company_connected = get_field('company',  'user_' . $user_connected);
$users_companie = array();
$course = get_field('categories', $_POST['id_course']);
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
    'customer_id' => get_current_user_id(),
    'post_status' => array_keys(wc_get_order_statuses()), 
    'post_status' => array('wc-processing'),
);
$orders = wc_get_orders($order_args);

/*
    ** Categories - all  * 
    */

    $categories = array();

    $cats = get_categories( 
        array(
        'taxonomy'   => 'course_category',  //Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => 'Uncategorized',
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
            //var_dump($subtopics);    
        }
    }


?>

<!--Link apply -->

<!-- modal-style -->
<style>
    body {
        padding-top: 0px !important;
    }

    /* modal on dashboard-learning-modules */
    @media (max-width: 991.98px) {
        .select2-container {
        min-width: 100%; } }

    .select2-results__option {
    padding-right: 20px;
    vertical-align: middle; }
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #fff; 
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #fd5f00;
    border-width: 2px; }

    .select2-container--default .select2-selection--multiple {
    border: none !important;
    background: #E7F8FF !important;
    border-radius: 10px !important;
    padding: 5px 10px;
    line-height: 1.6;
    -webkit-transition: 0.3s;
    -o-transition: 0.3s;
    transition: 0.3s;
    margin-bottom: 10px;
    }
    @media (prefers-reduced-motion: reduce) {
    .select2-container--default .select2-selection--multiple {
    -webkit-transition: none;
    -o-transition: none;
    transition: none; 
    } }

    .select2-container--open .select2-dropdown--below {
    padding: 10px 0;
    border-radius: 4px;
    margin-top: 25px;
    border: none;
    -webkit-box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.63);
    -moz-box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.63);
    box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.63); }

    .select2-selection .select2-selection--multiple:after {
    content: 'hhghgh'; }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
    border: none;
    background: rgba(0, 0, 0, 0.1);
    font-size: 15px;
    padding: 2px 10px;
    color: black; }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    margin-right: 5px; }

    .select2-container--default .select2-selection--multiple .select2-selection__clear {
    color: #fd5f00; }

     /* modal design width */
    .modal-content-width {
        width: 43% !important;
    }
    @media all and (max-width: 400px) {
    .modal-content-width {
        width: 90% !important;
        }
    }

</style>
         
<!-- script-modal -->
      
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">



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
                    <?php 
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

       <!-- The Modal -->
       <div id="myModal" class="modal">

           <!-- Modal content -->
       
            <!-- <div id="modal-content"> -->
           
            <div class="modal-content modal-content-width m-auto " style="margin-top: 100px !important">
                <div class="modal-header mx-4">
                    <h5 class="modal-title" id="exampleModalLabel">Subtopics </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('myModal').style.display='none'" >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="row d-flex text-center justify-content-center align-items-center h-50">
                    <div class="col-md-11  p-4">
                        <div class="form-group display-subtopics">
                        
                        </div> 
                        <div id="modal-content">

                        </div>
                        <div class="d-flex justify-content-end">
                            <button id="save_subtopics" type="button" class="btn text-white" style="background: #023356;">
                             <strong>Save</strong> </button>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
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
            <table class="table table-responsive" id="table">
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
                    foreach($courses as $key=> $course){
                        
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
                            $day = "~";
                            $data = explode('-', get_field('data_locaties_xml', $course->ID)[0]['value']);
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
                        <td id= <?php echo $course->ID; ?> class="textTh td_subtopics">
                                <?php
                                    $course_subtopics = get_field('categories', $course->ID);
                                    $field='';
                                    if($course_subtopics!=null){
                                    if (is_array($course_subtopics) || is_object($course_subtopics)){
                                        foreach ($course_subtopics as $key =>  $course_subtopic) {
                                               if ($course_subtopic!="" && $course_subtopic!="Array")
                                                   $field.=(String)get_the_category_by_ID($course_subtopic['value']).',';
                                      }
                                         $field=substr($field,0,-1);
                                         echo $field;
                                    
                                }
                            }
                                    
                                ?>
                            </p>             
                        </td>
                        <td class="textTh"><?php echo $day; ?></td>
                        <td class="textTh" id="live">Live</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>



<script>
    var id_course;
    $('.td_subtopics').click((e)=>{
        id_course = e.target.id;
     $.ajax({
            url:"/fetch-subtopics-course",
            method:"post",
            data:
            {
                id_course:id_course,
                action:'get_course_subtopics'
            },
        dataType:"text",
        success: function(data){
            // Get the modal
            //console.log(data)
    var modal = document.getElementById("myModal");
    $('.display-subtopics').html(data)
    // Get the button that opens the modal
    
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    
    // When the user clicks on the button, open the modal
    
        modal.style.display = "block";
    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
        modal.style.display = "none";
        }
    }
            
            
        }
    });
});
    
  $('#save_subtopics').click(()=>{
      var subtopics = $('#selected_subtopics').val()
      $.ajax({
  url:"/fetch-subtopics-course",
  method:"post",
  data:
    {
      add_subtopics:subtopics,
      id_course:id_course,
      action:'add_subtopics'
    },
  dataType:"text",
  success: function(data){
      
      let modal=$('#myModal');
      modal.attr('style', { display: "none" });
      //modal.style.display = "none";
      $('#'+id_course).html(data)
      //console.log(data)
  }
  })
});
</script>
