<!-- modal-style -->

<style>
    body {
        padding-top: 35px !important;
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<?php

    $args = array(
    'post_type' => array('course','post','leerpad','assessment'),
    'post_status' => 'publish',
    'posts_per_page' => 500,
    'order' => 'DESC',                          
    );
    $courses = get_posts($args);

    extract($_POST);

    if(isset($filter_databank)){
        ## START WITH THE FILTERS
        /**
        * Leervom Group
        */
        if(!empty($leervom)){
            $i = 0;
            foreach($courses as $datum){ 
                $coursetype = get_field('course_type', $datum->ID);
                if(!in_array($coursetype, $leervom)){
                    unset($courses[$i]);
                }
                $i++;
            }
        }
        /**
        * Price interval 
        */
        if(isset($min) || isset($max) || isset($gratis)){
            if(isset($gratis)){
                if($gratis){
                    $prices = array(); 
                    foreach($courses as $datum){
                        $price = intval(get_field('price', $datum->ID));
                        if($price == 0)
                            array_push($prices,$datum);
                    }
                }
            }else if(isset($min) || isset($max)){
                if($min || $max){
                    $prices = array(); 
                    $tmp = 0;
                    if($min != null && $max!= null){
                        if($min > $max) {
                            $tmp = $min;
                            $min = $max;
                            $max = $tmp;
                        }
                        //Here we got interval
                        foreach($courses as $datum){
                            $price = intval(get_field('price', $datum->ID));
                            $min = intval($min);
                            $max = intval($max);
                            if($price >= $min)
                                if($price <= $max)
                                    array_push($prices,$datum);
                        }
                    }
                    else{
                        //Tested by one value 
                        foreach($courses as $datum){
                            $price = intval(get_field('price', $datum->ID));
                            if($min == null){
                                $max = intval($max);
                                if($price <= $max)
                                    array_push($prices,$datum);
                            }
                            else if($max == null){
                                $min = intval($min);
                                if($price >= $min)
                                    array_push($prices,$datum);
                            }
                        }
                    }
                }
            }
            if(isset($prices)){
                if(!empty($prices)){
                    $courses = $prices;
                }
                else{
                    $courses = array();
                }
            }
        }
    } 

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

    $artikel_single = "Artikel"; 
    $white_type_array =  ['Lezing', 'Event'];
    $course_type_array = ['Opleidingen', 'Workshop', 'Training', 'Masterclass', 'Cursus'];
    $video_single = "Video";
    $leerpad_single  = 'Leerpad';
    $podcast_single = 'Podcast';

?>
    <div class="contentListeCourse learningDatabankContent">
        <div class="cardOverviewCours">
            <div class="headListeCourse">
                <p class="JouwOpleid">Alle opleidingen</p>
                <!-- <input id="search_txt_course" class="InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek" aria-label="Zoek" > -->
                <?php
                if ( in_array( 'author', $user_in->roles ) || in_array( 'hr', $user_in->roles ) || in_array( 'manager', $user_in->roles ) || in_array('administrator', $user_in->roles)) 
                    echo '<a href="/dashboard/teacher/course-selection/" target="_blank" class="btnNewCourse">Nieuwe course</a>';
                ?>
            </div>
            <div class="headFilterCourse">
                <div class="mob filterBlock m-2 mr-4">
                    <p class="fliterElementText">Filter</p>
                    <button class="btn btnIcone8" id="show"><img src="<?php echo get_stylesheet_directory_uri();?>/img/filter.png" alt=""></button>
                </div>
                <div class="formFilterDatabank">
                    <form action="" method="POST" >
                        <P class="textFilter">Filter :</P>
                        <button class="btn hideBarFilterBlock"><i class="fa fa-close"></i></button>
                        <select name="leervom[]">
                            <option value="" disabled>Leervoom</option>
                            <option value="Opleidingen" <?php if(isset($leervom)) if(in_array('Opleidingen', $leervom)) echo "selected" ; else echo ""  ?>>Opleidingen</option>
                            <option value="Training"    <?php if(isset($leervom)) if(in_array('Training', $leervom)) echo "selected" ; else echo ""  ?> >Training</option>
                            <option value="Workshop"    <?php if(isset($leervom)) if(in_array('Workshop', $leervom)) echo "selected" ; else echo ""  ?> >Workshop</option>
                            <option value="E-learning"  <?php if(isset($leervom)) if(in_array('E-learning', $leervom)) echo "selected" ; else echo ""  ?> >E-learning</option>
                            <option value="Masterclass" <?php if(isset($leervom)) if(in_array('Masterclass', $leervom)) echo "selected" ; else echo ""  ?> >Masterclass</option>
                            <option value="Video"       <?php if(isset($leervom)) if(in_array('Video', $leervom)) echo "selected" ; else echo ""  ?> >Video</option>
                            <option value="Assessment"  <?php if(isset($leervom)) if(in_array('Assessment', $leervom)) echo "selected" ; else echo ""  ?> >Assessment</option>
                            <option value="Lezing"      <?php if(isset($leervom)) if(in_array('Lezing', $leervom)) echo "selected" ; else echo ""  ?> >Lezing</option>
                            <option value="Event"  <?php if(isset($leervom)) if(in_array('Event', $leervom)) echo "selected" ; else echo ""  ?> >Event</option>
                            <option value="Leerpad"<?php if(isset($leervom)) if(in_array('Leerpad', $leervom)) echo "selected" ; else echo ""  ?> >Leerpad</option>
                            <option value="Artikel"<?php if(isset($leervom)) if(in_array('Artikel', $leervom)) echo "selected" ; else echo ""  ?> >Artikel</option>
                            <option value="Podcast"<?php if(isset($leervom)) if(in_array('Podcast', $leervom)) echo "selected" ; else echo ""  ?> >Podcast</option>

                        </select>
                        <div class="priceInput">
                            <div class="priceFilter">
                                <input type="number" name="min" value="<?php if(isset($min)) echo $min ?>" placeholder="min Prijs">
                                <input type="number" name="max" value="<?php if(isset($max)) echo $max ?>" placeholder="tot Prijs">
                            </div>
                            <div class="input-group">
                                <label for="">Gratis</label>
                                <input name="gratis" type="checkbox" <?php if(isset($gratis)) echo 'checked'; else  echo  '' ?> >
                            </div>
                        </div>
                        <select name="status">
                            <option value="" disabled selected>Status</option>
                            <option value="Live">Live</option>
                            <option value="Not Live">Not live</option>
                        </select>
                        <!-- <input type='date' class="form-control date" placeholder="selecteer een datum" /> -->
                        <button class="btn btnApplyFilter" name="filter_databank" type="submit">Apply</button>
                    </form>
                </div>

            </div>
            <div class="contentCardListeCourse">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titel</th>
                   <!-- <th scope="col">Leervorm</th> -->                    
                        <th scope="col">Prijs</th>
                        <th scope="col">Onderwerp(en)</th>
                        <th scope="col">Startdatum</th>
                        <th scope="col">Status</th>
                        <th scope="col">Optie</th>
                    </tr>
                    </thead>
                    <tbody id="autocomplete_company_databank">
                        <?php 
                        foreach($courses as $key => $course){
                            $bool = true;
                            $bool = visibility($course, $visibility_company);
                            if(!$bool)
                                continue;   

                            //Categories
                            $category = " ";
                            $id_category = 0;
                            $category_id = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]);
                            $category_xml = intval(get_field('category_xml', $course->ID)[0]['value']);
                            if($category_xml)
                                if($category_xml != 0)
                                    $category = (String)get_the_category_by_ID($category_xml);
                                
                            if($category_id)
                                if($category_id != 0)
                                    $category = (String)get_the_category_by_ID($category_id);

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
                                if($dates){
                                    $post_date = explode(' ', $dates[0]['date'])[0];
                                    $date_immu = new DateTimeImmutable($post_date);
                                    $day = $date_immu->format('d/m/Y');  
                                }                              
                                else{
                                    $data = get_field('data_locaties_xml', $course->ID);
                                    if(isset($data[0]['value'])){
                                        $data = explode('-', $data[0]['value']);
                                        $date = $data[0];
                                        $day = explode(' ', $date)[0];
                                    }
                                }
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
                        // course image


                        ?>
                        <tr class="pagination-element-block">
                            <td scope="row"><?= $key; ?></td>
                            <td class="textTh text-left"><a style="color:#212529;font-weight:bold" href="<?php echo get_permalink($course->ID) ?>"><?php echo $course->post_title; ?></a></td>
                            <td class="textTh"><?php echo $price; ?></td>
                            <?php
                            if (in_array('administrator', $user_in->roles ) ) {
                            ?>
                                <td id= <?php echo $course->ID; ?> class="textTh td_subtopics">
                                <?= $category ?>
                                <?php
                                $course_subtopics = get_field('categories', $course->ID);
                                $field='';
                                $read_topis = array();
                                if($course_subtopics != null){
                                    if (is_array($course_subtopics) || is_object($course_subtopics)){
                                        foreach ($course_subtopics as $key => $course_subtopic) {
                                            if(!$course_subtopic)
                                                continue;
                                            if(!is_int($course_subtopic['value']))
                                                continue;

                                            $topic_category = get_the_category_by_ID($course_subtopic['value']);
                                            if(is_wp_error($topic_category))
                                                continue;

                                            if ($course_subtopic != "" && $course_subtopic != "Array" && !in_array(intval($course_subtopic['value']), $read_topis)){
                                                $field .= (String)$topic_category . ',';
                                                array_push($read_topis, intval($course_subtopic['value']));
                                            }
                                        }
                                        $field = substr($field,0,-1);
                                        echo $field;
                                    }
                                }
                            }
                            else
                            {
                            ?>
                            <td class="textTh ">
                                <?= $category ?>
                                <?php
                                $course_subtopics = get_field('categories', $course->ID);
                                $field='';
                                $read_topis = array();
                                if($course_subtopics != null){
                                    if (is_array($course_subtopics) || is_object($course_subtopics)){
                                        foreach ($course_subtopics as $key => $course_subtopic) {
                                            if(!$course_subtopic)
                                                continue;
                                            if(!is_int($course_subtopic['value']))
                                                continue;

                                            $topic_category = get_the_category_by_ID($course_subtopic['value']);
                                            if(is_wp_error($topic_category))
                                                continue;

                                            if ($course_subtopic != "" && $course_subtopic != "Array" && !in_array(intval($course_subtopic['value']), $read_topis)){
                                                $field .= (String)$topic_category . ',';
                                                array_push($read_topis, intval($course_subtopic['value']));
                                            }
                                        }
                                        $field = substr($field,0,-1);
                                        echo $field;
                                    }
                                }
                            }
                            ?>
                            </p>             
                            </td>
                            <td class="textTh"><?php echo $day; ?></td>
                            <td class="textTh">Live</td>
                            <td class="textTh">
                                <div class="dropdown text-white">
                                    <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                        <img style="width:20px"
                                              src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                    </p>
                                    <ul class="dropdown-menu">
                                        <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="<?php echo $link; ?>" target="_blank">Bekijk</a></li>    
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="pagination-container">
                    <!-- Les boutons de pagination seront ajoutés ici -->
                </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        const itemsPerPage = 20;
        const $rows = $('.pagination-element-block');
        const pageCount = Math.ceil($rows.length / itemsPerPage);
        let currentPage = 1;

        function showPage(page) {
            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;

            $rows.each(function(index, row) {
                if (index >= startIndex && index < endIndex) {
                    $(row).css('display', 'table-row');
                } else {
                    $(row).css('display', 'none');
                }
            });
        }

        function createPaginationButtons() {
            const $paginationContainer = $('.pagination-container');

            if (pageCount <= 1) {
                $paginationContainer.css('display', 'none');
                return;
            }

            const $prevButton = $('<button>&lt;</button>').on('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                    updatePaginationButtons();
                }
            });

            const $nextButton = $('<button>&gt;</button>').on('click', function() {
                if (currentPage < pageCount) {
                    currentPage++;
                    showPage(currentPage);
                    updatePaginationButtons();
                }
            });

            $paginationContainer.append($prevButton);

            for (let i = 1; i <= pageCount; i++) {
                const $button = $('<button></button>').text(i);
                $button.on('click', function() {
                    currentPage = i;
                    showPage(currentPage);
                    updatePaginationButtons();
                });

                if (i === 1 || i === pageCount || (i >= currentPage - 2 && i <= currentPage + 2)) {
                    $paginationContainer.append($button);
                } else if (i === currentPage - 3 || i === currentPage + 3) {
                    $paginationContainer.append($('<span>...</span>'));
                }
            }

            $paginationContainer.append($nextButton);
        }

        function updatePaginationButtons() {
            $('.pagination-container button').removeClass('active');
            $('.pagination-container button').filter(function() {
                return parseInt($(this).text()) === currentPage;
            }).addClass('active');
        }

        showPage(currentPage);
        createPaginationButtons();
    });
</script>


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

<script>
     $('#search_txt_course').keyup(function(){
        var txt = $(this).val();

        $.ajax({

            url:"/fetch-databank-course",
            method:"post",
            data:{
                search_txt_course : txt,
            },
            dataType:"text",
            success: function(data){
                console.log(data);
                $('#autocomplete_company_databank').html(data);
            }
        });

    });
</script>

