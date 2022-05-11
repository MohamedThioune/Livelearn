<!-- modal-style -->

<style>
    body {
        padding-top: 0px !important;
    }

    .ftco-section {
		padding: 1em 0; }


		.heading-section {
		font-size: 28px;
		color: #000; }


		.select2-container {
		min-width: 90% !important;
     }
	    @media (max-width: 991.98px) {
			.select2-container {
			min-width: 100%; } }

		.select2-results__option {
		padding-right: 20px;
		vertical-align: middle; }

	    .select2-results__option:before {
            content: "";
            display: inline-block;
            position: relative;
            height: 20px;
            width: 20px;
            border: 2px solid rgba(0, 0, 0, 0.2);
            border-radius: 4px;
            background-color: transparent;
            margin-right: 15px;
            margin-left: 10px;
            vertical-align: middle; }

        .select2-results__option[aria-selected=true]:before {
            font-family: 'fontAwesome';
            content: "\f00c";
            color: #fff;
            background-color: #023356;
            border: 0;
            display: inline-block;
            padding: 0;
            line-height: 1.2;
            padding-left: 2px; 
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #fff; 
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #fff;
            color: #000; 
        }

	.select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
	border-radius: 4px;
	-webkit-box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.8);
	-moz-box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.8);
	box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.8); }

	.select2-container--default.select2-container--focus .select2-selection--multiple {
	border-color: #fd5f00;
	border-width: 2px; }

	.select2-container--default .select2-selection--multiple {
	border-width: 2px;
	border-color: transparent;
	padding: 5px 10px;
	line-height: 1.6;
	-webkit-transition: 0.3s;
	-o-transition: 0.3s;
	transition: 0.3s;
	margin-bottom: 10px;
	-webkit-box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.63);
	-moz-box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.63);
	box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.63); }
	@media (prefers-reduced-motion: reduce) {
		.select2-container--default .select2-selection--multiple {
		-webkit-transition: none;
		-o-transition: none;
		transition: none; 
        /* margin-bottom: 36px;  */
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
	color: gray; }

	.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
	margin-right: 5px; }

	.select2-container--default .select2-selection--multiple .select2-selection__clear {
	color: #fd5f00; }


    /* modal design */
    .modal-content-width {
        background-color: #023356 !important;
        width: 50% !important;
    }
    @media all and (max-width: 400px) {
        .modal-content-width {
            background-color: #023356 !important;
            width: 90% !important;
        }
    }

    .close-button {
        width: 35px;
        height: 50px;
        background: red;
        margin: 12px;
        border-radius: 10px;
        border: red;
    }
</style>
         
<!-- script-modal -->
      
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

?>
    <div class="contentListeCourse">
        <div class="cardOverviewCours">
            <div class="headListeCourse">
                <p class="JouwOpleid">Alle opleidingen</p>
                <input type="search" class="searchInputAlle" placeholder="Zoek opleidingen, experts of ondervwerpen">
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
                                    if ($course->ID[0]['value']!=null)
                                    {
                                        $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                                        $date = $data[0];
                                        $day = explode(' ', $date)[0];
                                    }
                                }
                            }
                        ?>
                        <tr>
                            <td class="textTh elementOnder"><a style="color:#212529;font-weight:bold" href="<?php echo get_permalink($course->ID) ?>"><?php echo $course->post_title; ?></a></td>
                            <td class="textTh"><?php echo $price; ?></td>
                            <?php
                            if (in_array('administrator', $user_in->roles ) ) {
                            ?>
                            <td id= <?php echo $course->ID; ?> class="textTh elementOnder td_subtopics">
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
                        }
                        else
                            {
                                ?>
                                <td class="textTh elementOnder">
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
                            }

                                ?>
                            </p>             
                        </td>
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


    <!-- The Modal -->
    <div id="myModal" class="modal">

<!-- Modal content -->
 <!-- <div id="modal-content"> -->

 <div class="modal-content modal-content-width m-auto " style="margin-top: 100px !important">
     <span type="button" class="px-2 close-button text-white bg-danger fa-2x" id="closeModal"
     onclick="document.getElementById('myModal').style.display='none'" > &times;
         <!-- <button type="button" class="btn btn-danger close">&times;</button> -->
     </span>
     <div class="row d-flex text-center justify-content-center align-items-center h-50">
         <div class="col-md-8  p-4">
             <div class="form-group display-subtopics">
             
             </div> 
             <div id="modal-content">

             </div>
             <div>
                 <button id="save_subtopics" type="button" class="btn bg-white" style="color: #003358;">
                  <strong>Save</strong> </button>
             </div>
         </div>
     </div>
 <!-- </div> -->
</div>


</div> 

<script>
    var id_course;
    $('.td_subtopics').click((e)=>{
        if (e.target.id!=null)
        {
            id_course = e.target.id;
            current_td=e.target;
            console.log(id_course);
        $.ajax({
                url:"/fetch-subtopics-course",
                method:"post",
                data:
                {
                    id_course:id_course
                },
            dataType:"text",
            success: function(data){
                // Get the modal
                console.log(data)
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
    }
});
    
  $('#save_subtopics').click(()=>{
      var subtopics = $('#selected_subtopics').val()
      $.ajax({
  url:"/fetch-subtopics-course",
  method:"post",
  data:
    {
      add_subtopics:subtopics,
      id_course:id_course
    },
  dataType:"text",
  success: function(data){
      
      let modal=$('#myModal');
      modal.attr('style', { display: "none" });
      //modal.style.display = "none";
      $('#'+id_course).html(data)
      console.log(data)
  }
  })
});

</script>