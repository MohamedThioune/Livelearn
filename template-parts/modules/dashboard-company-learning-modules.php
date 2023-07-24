<?php
$user_connected = get_current_user_id();
$company_connected = get_field('company',  'user_' . $user_connected);
$users_companie = array();
if(isset($_POST['id_course']))
    $course = get_field('categories', $_POST['id_course']);

$users = get_users();

foreach($users as $user) {
    $company_user = get_field('company',  'user_' . $user->ID);
    if(!empty($company_connected) && !empty($company_user))
        if($company_user[0]->post_title == $company_connected[0]->post_title)
            array_push($users_companie,$user->ID);
}

$args = array(
    'post_type' => array('course','post','leerpad','assessment'),
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

    $artikel_single = "Artikel"; 
    $white_type_array =  ['Lezing', 'Event'];
    $course_type_array = ['Opleidingen', 'Workshop', 'Training', 'Masterclass', 'Cursus'];
    $video_single = "Video";
    $leerpad_single  = 'Leerpad';
    $podcast_single = 'Podcast';

?>

<!--Link apply -->

<!-- modal-style -->
<style>


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



<div class="contentListeCourse contentLeaning">
    <!-- 
    <div class="cardOverviewCours">
        <div class="headListeCourse">
            <p class="JouwOpleid">Gekochte opleidingen</p>
            <input id="search_txt_company" class="form-control inputSearch2" type="search" placeholder="Zoek medewerker" aria-label="Search" >
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
    -->

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
    
        <!-- <div id="modal-content"> -->
        
        <div class="modal-content modal-content-width m-auto " style="margin-top: 100px !important">
            <div class="modal-header mx-4">
                <h5 class="modal-title" id="exampleModalLabel">Subtopics </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('myModal').style.display='none'" >
                    <span aria-hidden="true">x</span>
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
                            <strong>Save</strong> 
                        </button>
                    </div>
                </div>
            </div>
        <!-- </div> -->
        </div>
        

    </div> 

    <div id="myModalRent" class="modal">

        <!-- Modal content -->
    
        <!-- <div id="modal-content"> -->
        
        <div class="modal-content modal-content-width m-auto " style="margin-top: 100px !important">
            <div class="modal-header mx-4">
                <h5 class="modal-title" id="exampleModalLabel">Experts  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('myModal').style.display='none'" >
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="row d-flex text-center justify-content-center align-items-center h-50">
                <div class="col-md-11  p-4">
                    <form action='/dashboard/user/' method='POST'>
                        <label for='member_id'><b>Deel met de volgende medewerkers :</b></label><br>
                        <div class="form-group display-experts">
                        </div> 
                        <div id="modal-content">
                                
                        </div>
                        <center><input type='submit' class='btn text-white' name='referee_employee' value='Save' style='background: #023356; border: none;'/></center>
                        <div class="d-flex justify-content-end">
                        </div>
                    </form>

                </div>
            </div>
        <!-- </div> -->
        </div>
        

    </div>  
		
    <div class="cardOverviewCours">
        <div class="headListeCourse">
            <p class="JouwOpleid">Jouw opleidingen</p>
            <input id="search_txt_company" class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek" aria-label="Zoek" >
            <?php 
                if ( in_array( 'hr', $user_in->roles ) || in_array( 'manager', $user_in->roles ) || in_array('administrator', $user_in->roles)) 
                    echo '<a href="/dashboard/teacher/course-selection/" class="btnNewCourse">Nieuwe course</a>';
            ?>
        </div>

        <div class="contentCardListeCourse">
            <table class="table table-responsive" id="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Verkoop</th>
                        <th scope="col">Titel</th>
                        <th scope="col">Leervorm</th>
                        <th scope="col">Prijs</th>
                        <th scope="col">Onderwerp(en)</th>
                        <th scope="col">Startdatum</th>
                        <th scope="col">Optie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($courses as $key => $course){
                        if(!visibility($course, $visibility_company))
                            continue;                
                            
                        /*
                        * Categories
                        */
                        $category = ' ';
                        $category_id = 0;
                        $category_str = 0;
                        if($category == ' '){
                            $one_category = get_field('categories',  $course->ID);
                            if(isset($one_category[0]['value']))
                                $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                            else{
                                $one_category = get_field('category_xml',  $course->ID);
                                if(isset($one_category[0]['value']))
                                    $category_id = intval($one_category[0]['value']);
                            }

                            if($category_str != 0)
                                $category = (String)get_the_category_by_ID($category_str);
                            else if($category_id != 0)
                                $category = (String)get_the_category_by_ID($category_id);
                        }

                        /*
                        *  Date and Location
                        */ 
                        $day = "<p class='text-no-date'>no date given</p>";
                        $month = ' ';
                        $location = ' ';
                    
                        $data = get_field('data_locaties', $course->ID);
                        if($data){
                            $date = $data[0]['data'][0]['start_date'];
                            $day = explode(' ', $date)[0];
                        }
                        else{
                            $dates = get_field('dates', $course->ID);
                            if($dates)
                                $day = explode(' ', $dates[0]['date'])[0];
                            else{
                                $data = get_field('data_locaties_xml', $course->ID);
                                if(isset($data[0]['value'])){
                                    $data = explode('-', $data[0]['value']);
                                    $date = $data[0];
                                    $day = explode(' ', $date)[0];
                                }
                            }
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
                        $course_type = get_field('course_type', $course->ID);

                        $path_edit  = "";
                        if($course_type == $artikel_single)
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-article&id=" . $course->ID ."&edit";
                        else if($course_type == $video_single)
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-video&id=" . $course->ID ."&edit";
                        else if(in_array($course_type,$white_type_array))
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-add-white&id=" . $course->ID ."&edit";
                        else if(in_array($course_type,$course_type_array))
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-course&id=" . $course->ID ."&edit";
                        else if($course_type == $leerpad_single)
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-road&id=" . $course->ID ."&edit";
                        else if($course_type == 'Assessment')
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-assessment&id=" . $course->ID ."&edit";
                        else if($course_type == 'Podcast')
                            $path_edit = "/dashboard/teacher/course-selection/?func=add-podcast&id=" . $course->ID ."&edit";

                        $link = get_permalink($course->ID);

                        if(!$course_type)
                            $course_type = 'Artikel';
                    ?>
                    <tr id="<?php echo $course->ID; ?>">
                        <td scope="row"><?= $key; ?></td>                        
                        <td class="textTh"><?php if(!empty(get_field('visibility',$course->ID))) echo 'nee'; else echo 'ja'; ?></td>
                        <td class="textTh text-left"><a style="color:#212529;" href="<?php echo $link; ?>"><?php echo $course->post_title; ?></a></td>
                        <td class="textTh"><?php echo $course_type; ?></td>
                        <td class="textTh"><?php echo $price; ?></td>
                        <td id= "<?php echo $course->ID; ?>" class="textTh td_subtopics" >
                            <?php
                                $course_subtopics = get_field('categories', $course->ID);
                                $field = '';
                                $read_topis = array();
                                if($course_subtopics != null){
                                    if (is_array($course_subtopics) || is_object($course_subtopics)){
                                        foreach ($course_subtopics as $key => $course_subtopic) {
                                            if ($course_subtopic != "" && $course_subtopic != "Array" && !in_array(intval($course_subtopic['value']), $read_topis)){
                                                $field.=(String)get_the_category_by_ID($course_subtopic['value']).',';
                                                array_push($read_topis, intval($course_subtopic['value']));
                                            }
                                        }
                                        $field = substr($field,0,-1);
                                        echo $field;
                                    }
                                }
                            ?>
                            </p>             
                        </td>
                        <td class="textTh"><?php echo($day); ?></td>
                        <td class="textTh">
                            <div class="dropdown text-white">
                                <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                    <img style="width:20px"
                                          src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                </p>
                                <ul class="dropdown-menu">
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="<?php echo $link; ?>" target="_blank">Bekijk</a></li>
                                    <?php
                                    if($course->post_author == $user_in->ID || in_array('hr', $user_in->roles) || in_array('administrator', $user_in->roles) ){
                                        echo '<li class="my-2"><i class="fa fa-gear px-2"></i><a href="' . $path_edit . '">Pas aan</a></li>';
                                        echo '<li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2 "></i><input type="button" id="" value="Verwijderen"/></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script>
    var id_course;
    $('.rent').click((e)=>{
        id_course = e.target.id;
        $.ajax({
            url:"/fetch-rent",
            method:"post",
            data:
            {
                id_course:id_course
            },
            dataType:"text",
            success: function(data){
                // Get the modal
                //console.log(data)
                var modal = document.getElementById("myModalRent");
                $('.display-experts').html(data);
                console.log(data);
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
</script>

<!-- <script>
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
</script> -->

<script type="text/javascript">
    $(".remove_opleidingen").click(function(){
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