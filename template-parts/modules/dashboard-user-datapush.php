<?php
global $wpdb;

$table = $wpdb->prefix . 'databank';

$format = array('%s', '%s', '%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%d', '%d', '%s');

?>
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<?php
   $args = array(
    'post_type' => 'course', 
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',  
    );

    $courses = get_posts($args);

    $user_in = wp_get_current_user();

    /*
    * * Tags *
    */ 
    $tags = array();
    $categories = array(); 
    $cats = get_categories( array(
      'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
      'orderby'    => 'name',
      'exclude' => 'Uncategorized',
      'parent'     => 0,
      'hide_empty' => 0, // change to 1 to hide categores not having a single post
      ) );

    foreach($cats as $item){
      $cat_id = strval($item->cat_ID);
      $item = intval($cat_id);
      array_push($categories, $item);
    };

    $bangerichts = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[1],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $functies = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[0],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $skills = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[3],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $interesses = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[2],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $categorys = array(); 
    foreach($categories as $categ){
        //Topics
        $topics = get_categories(
            array(
            'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categ,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ) 
        );

        foreach ($topics as $value) {
            $tag = get_categories( 
                 array(
                 'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                 'parent'  => $value->cat_ID,
                 'hide_empty' => 0,
                ) 
            );
            $categorys = array_merge($categorys, $tag);      
        }
    }
?>
<!-- Content -->
<div class="contentListeCourse">
    <div class="cardOverviewCours">
        <div class="headListeCourse">
            <p class="JouwOpleid">DATA *PUSH*</p>
            <input type="search" class="searchInputAlle" placeholder="Zoek opleidingen, experts of ondervwerpen">
        </div>
        <div class="contentCardListeCourse">
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th scope="col">Titel</th>
                    <th scope="col"></th>
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
                            $day = "~";
                            $data = explode('-', get_field('data_locaties_xml', $course->ID)[0]['value']);
                            $date = $data[0];
                            $day = explode(' ', $date)[0];
                        }

                        $tags = get_field('categories', $course->ID);

                        $keywords = array();

                        $words = "";

                        if(empty($tags)){
                            $tags = array();
                            $title = $course->post_title;
                            if($title)
                                $words .= $title;
                            $description = get_field('short_description', $course->ID);
                            if($description)
                                $words .= $description;
                            $descriptionHtml = get_field('long_description', $course->ID);
                            if($descriptionHtml)
                                $words .= $descriptionHtml;

                            $keywords = explode(' ', $words);

                            $occurrence = array_count_values(array_map('strtolower', $keywords));
                            arsort($occurrence);

                            foreach($categorys as $value)
                                if($occurrence[strtolower($value->cat_name)] >= 1){
                                    echo strtolower($value->cat_name);
                                    array_push($tags, $value->cat_ID);
                                }
                            update_field('categories', $tags, $course->ID);
                        }

                        $course_subtopics = get_field('categories', $course->ID);
                        $fields = '';
                        if($course_subtopics!=null){
                            if (is_array($course_subtopics) || is_object($course_subtopics)){
                                foreach ($course_subtopics as $key =>  $course_subtopic) {
                                    if ($course_subtopic!="" && $course_subtopic!="Array")
                                        $fields .= (String)get_the_category_by_ID($course_subtopic['value']).',';
                                }
                            }
                        }

                        /*
                        * Elements 
                        */
                        $short_description = get_field('short_description', $course->ID);

                        $long_description = get_field('long_description', $course->ID);

                        $duration = get_field('duration_day', $course->ID);

                        $level = get_field('degree', $course->ID);

                        $price = get_field('price', $course->ID);

                        $prijsvat = get_field('prijsvat', $course->ID);

                        $type_course = get_field('course_type', $course->ID);

                        $image_xml = get_field('preview', $course->ID)['url'];
                        if(!$image_xml){
                            $image_xml = get_field('url_image_xml', $course->ID);
                            if(!$image_xml)
                                $image_xml = "https://cdn.pixabay.com/photo/2021/09/18/12/40/pier-6635035_960_720.jpg";
                        }

                        $status = "intern";

                        $format = array('%s', '%s', '%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%d', '%d', '%s');

                        $data = array('titel' => $course->post_title,  'type' => $type_course, 'short_description' => $short_description, 'long_description' => $long_description, 'duration' => $duration, 'prijs' => $price, 'prijs_vat' => $prijsvat, 'image_xml' => $image_xml , 'onderwerpen' => $fields, 'date_multiple' => null, 'course_id' => $course->ID, 'author_id' => $course->post_author, 'status' => $status);

                        $wpdb->insert($table,$data,$format);
                    
                    ?>
                    <tr>
                        <td class="textTh "><a style="color:#212529;font-weight:bold" href="<?php echo get_permalink($course->ID) ?>"><?php echo $course->post_title; ?></a></td>
                        <td class="textTh">✔️</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
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

</div> 

<!-- script-modal -->
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

    
