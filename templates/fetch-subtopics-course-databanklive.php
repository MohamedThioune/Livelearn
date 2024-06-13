



<?php /** Template Name: Fetch subtopics course DatabankLive */ ?>

<?php

    
   if ( $_POST['action'] == 'get_course_authors') 

{
        $course = get_post(intval($_POST['id_course']));
        // $courses = get_field('author',intval($_POST['id_course']) );

    //      $args = array(
    //     'post_type' => array('post', 'course', 'learnpath'),
    //     'posts_per_page' => -1,
    //     'author' => $id,  
    // );

    // $courses = get_posts($args);
          //Author Image
        $user_info = get_userdata($user_id); 
        $image_author = get_field('profile_img', 'user_' . $course->post_author);
        $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';
        $company=get_field('company', 'user_' . $post->post_author);
        $functie = get_field('role', 'user_' . $course->post_author);

         $html = '';
           
                $html .= '

        <div class="element-teacher-block d-flex justify-content-between align-items-center">
                            <div class="element-teacher d-flex align-items-center">
                                <div class="block-img">
                                    <img src="'. $image_author .'" alt=""
                                        srcset="">
                                </div>
                                <p class="name">  '. $user_info->display_name .'</p>
                                <hr>
                                <p class="other-element">'. $company[0]->post_title .'</p>
                                <hr>
                                <p class="other-element">'. json_encode($functie) .'</p>
                            </div>
                            <button class="btn btn-remove-teacher">
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>';
            
           
            echo $html;




} 








if (isset ($_POST['add_subtopics']) && !empty($_POST['add_subtopics']) && $_POST['action'] == 'add_subtopics') {
{
    // getting subtopics for a specific course  
    $course = get_field('categories', $_POST['id_course']);
    $subtopics = array();
    // new subtopics selected by user
    $subtopics = $_POST['add_subtopics'];
    $field = '';
    //Adding new subtopics on this course
    update_field('categories', $subtopics, $_POST['id_course']);
    foreach ($subtopics as $key => $value) {
        if($key == 2)
            break;

        if ($value != '')
            $field .= (String)get_the_category_by_ID($value) . ',';
    }
        // this string will contains all the subtopics of this course
    $field = substr($field,0,-1);

  }

}
else if (empty($_POST['add_subtopics']) && $_POST['action'] == 'add_subtopics') 
    update_field('categories', [], $_POST['id_course']);

// display the subtopics of this course 
echo $field;
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


<!-- modal-style -->
         
<!-- script-modal -->
<?php
if (isset ($_POST['id_course'])  && $_POST['action'] == 'get_course_subtopics') {

     
    $categories = array();

    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    foreach($cats as $category){
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($categories, $category);
    }

    //Topics
    $topics = array();
    foreach ($categories as $value){
        $merged = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $value,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ) );

        if(!empty($merged))
            $topics = array_merge($topics, $merged);
    }
    

?>
  
            
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sub-topics</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('myModal').style.display='none'" >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center head-for-body">
                        <button class="btn btn-sub-title-topics" type="button">Remove</button>
                        <p class="text-or">Or</p>
                        <button class="btn btn-add-sub-topics" type="button">Add Subtopics</button>
                    </div>
                    <div class="content-sub-topics">
                                             <?php
    
    $course_subtopics = get_field('categories',$_POST['id_course']);
    $selected_subtopics=array();
    if (is_array($course_subtopics) || is_object($course_subtopics)){
        foreach ($course_subtopics as $key =>  $course_subtopic) {
            if ($course_subtopic!="" && $course_subtopic!="Array")
                array_push($selected_subtopics,$course_subtopic['value']);
        }
        // check subtopics already added on this course 
        foreach($subtopics as $value){
            if (in_array($value->cat_ID,$selected_subtopics))

                echo "<div class='btn-sub-topics' id='btn-sub-topics' value='".json_encode($selected_subtopics) ."'><p   value='" . $value->cat_ID . "'>" . $value->cat_name . "</p> <button class='btn'><i class='fa fa-remove'></i></button></div>";
           
        }
    }

           ?>   
                        
                        
                    </div>
                    <div class="content-add-sub-topics" >
                        
                            <div class="form-group mb-4">
                                <label class="label-sub-topics">First Choose Your topics </label>
                                <div class="formModifeChoose" id="formModifeChoose" value=<?php echo $_POST['id_course'];?>>
                                    <select name="topic" id="selectTopic" class="multipleSelect2" >

                                        <?php
                                foreach($topics as $value)
                                    echo '<option  value= '.$value->cat_ID .'  >'. $value->cat_name .'</option>';
                                ?>
                                        
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="block-sub-topics">
                                
                              
                                
                            </div>
                        
                    
                </div>
            </div>
      
  <?php }?>             
<!----> 
 <script>
        $(document).ready(function() {
            $('#autocomplete').on('change', function() {
                if ($(this).val()) {
                    $(".block-sub-topics").show();
                } else {
                    $(".block-sub-topics").hide();
                }
            });
        });
    </script>
<script id="rendered-js" >
    $(document).ready(function () {
        //Select2
        $(".multipleSelect2").select2({
            placeholder: "Maak uw keuze",
             //placeholder
        });
    });
    //# sourceURL=pen.js
</script>  

 <script>
        $(".btn-add-sub-topics").click(function() {
            $(".content-sub-topics").hide();
            $(".content-add-sub-topics").show();
            $(".block-sub-topics").show();
        });
        $(".btn-sub-title-topics").click(function() {
            $(".content-sub-topics").show();
            $(".content-add-sub-topics").hide();
        });
        $("#addTeacher").click(function() {
            $(".block-to-add-teacher").show();
            $(".block-to-show-teacher").hide();
        });
        $("#removeTeacher").click(function() {
            $(".block-to-add-teacher").hide();
            $(".block-to-show-teacher").show();
        });
    </script>  
    <script>
$(document).ready(function() {
    
    const topicSelect = $('.multipleSelect2');

    topicSelect.on('change', function() {
        const selectedTopic = $(this).val();

        if (selectedTopic) {
            $.ajax({
                url: "/save-author-and-compagny",
                method: "post",
                data: {
                    topic_id: selectedTopic,
                     action:'get_subtopics'
                },
                dataType: "text",
                success: function(response) {
                    console.log(response);
                    $('.block-sub-topics').html(response);

                    const selectedValues = new Set();
                    const buttons = document.querySelectorAll('.select-button');

                    buttons.forEach(button => {
                        button.addEventListener('click', (event) => {
                            const value = button.getAttribute('data-value');
                            if (selectedValues.has(value)) {
                                selectedValues.delete(value);
                                button.style.backgroundColor = ""
                            } else {
                                selectedValues.add(value);
                                button.classList.add('selected');
                                button.style.backgroundColor = "#7FFF00"
                            }
                        });
                    });

                    // Move the event listener binding inside the success callback
                    const saveButton = document.getElementById('save_subtopics');
                    
                    
                        
                       $(document).on('click', '#save_subtopics', function() {
                            

                            var subtopics  = Array.from(selectedValues);;
                            var selectedsubtopics=JSON.parse(document.getElementById('btn-sub-topics').getAttribute('value'));
                            const id_course = document.getElementById('formModifeChoose').getAttribute('value');
                           
                             var concatenatedselectedsubtopics = subtopics.concat(selectedsubtopics)
                            
                           
      $.ajax({
  url:"/fetch-subtopics-course",
  method:"post",
  data:
    {
      add_subtopics:concatenatedselectedsubtopics,
      id_course:id_course,
      action:'add_subtopics'
    },
  dataType:"text",
  success: function(data){
      console.log(data)
      let modal=$('#myModal');
      modal.attr('style', { display: "none" });
      //modal.style.display = "none";
      $('#'+id_course).html(data)
      //console.log(data)
  },
  error:function(data){
    
      console.log(data)
  }
  })

                            
                        });
                    
                },
                error: function(response) {
                    alert('Failed to create user!');
                    document.getElementById('content-back-topics').innerHTML = response;
                }
            });
        } else {
            $('.block-sub-topics').html(''); // Clear subtopics if no topic is selected
        }
    });
});
</script>

                     
                    