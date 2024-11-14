<?php /** Template Name: Fetch subtopics course DatabankLive */ ?>

<?php

    
   if ( $_POST['action'] == 'get_course_authors') {
        $course = get_post(intval($_POST['id_course']));
        // $courses = get_field('author',intval($_POST['id_course']) );

    //      $args = array(
    //     'post_type' => array('post', 'course', 'learnpath'),
    //     'posts_per_page' => -1,
    //     'author' => $id,  
    // );

    // $courses = get_posts($args);
          //Author Image
        $user_info = get_userdata($course->post_author); 
        $image_author = get_field('profile_img', 'user_' . $course->post_author);
        $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';
        $company=get_field('company', 'user_' . $course->post_author);
        $functie = get_field('role', 'user_' . $course->post_author);
         $html = '';
           
                $html .= '
                            <div id="id_course_'. $course->ID .'" class="element-teacher-block d-flex justify-content-between align-items-center">
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
    ) );
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
                'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent' => $categ,
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ));

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
        }
    }
 ?>


<!-- modal-style -->

<!-- script-modal -->
<?php
if (isset ($_POST['id_course'])  && $_POST['action'] == 'get_course_subtopics') {
    $course = get_post(intval($_POST['id_course']));

    $categories = array();
    $course_subtopics = [];
    $course_subtopics = get_field('categories',$_POST['id_course']);
    $id_subtopics = $course_subtopics ? array_column($course_subtopics, 'value'):[];
    if(!$course_subtopics)
        $course_subtopics = get_field('category_xml', $_POST['id_course']);

    foreach($course_subtopics as $choosen){
        if(empty($course_subtopicss))
            $course_subtopics = explode(',', $choosen['value']);
        else
            array_merge($course_subtopics, explode(',', $choosen['value']));
    }

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
    $row_bangrichts = '';
    $topics = array();
    foreach ($categories as $key1=>$value){
        $merged = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $value,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ) );
        if(!empty($merged)) {
            $topics = array_merge($topics, $merged);
            $row_bangrichts.='<div hidden=true class="cb_topics_bangricht_'.($key1+1).'" '.($key1+1).'">';
            foreach ($merged as $key => $value) {
                $selected = '';
                if(!empty($already_linked_tags))
                    $selected = in_array($value->cat_ID,$already_linked_tags) ? 'checked' : '' ;

                $row_bangrichts .= '
            <input '.$selected.' class="selected" type="checkbox" name="choice_bangrichts_'.$value->cat_ID.'" value= '.$value->cat_ID .' id=subtopics_bangricht_'.$value->cat_ID.' />
            <label class="labelChoose" for=subtopics_bangricht_'.$value->cat_ID.'>'. $value->cat_name .'</label>';
            }
            $row_bangrichts.= '</div>';
        }
    }

    ?>
    <div class="modal-header">
        <h5 class="modal-title" >Sub-topics</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('myModal').style.display='none'" >
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center head-for-body">
            <!-- <button class="btn btn-sub-title-topics" type="button">Remove</button>
                <p class="text-or">Or</p>
                <button class="btn btn-add-sub-topics" type="button">Add Subtopics</button> -->
        </div>
        <div class="content-sub-topics">
            <div class="hiddenCB">
                <div>
                    <?php
                    foreach($cats as $key => $value)
                    {
                        $state = false;
                        $childrens = get_term_children($value->cat_ID, 'course_category');
                        foreach($course_subtopicss as $element)
                            if(in_array($element, $childrens) && !in_array($element, $displayed)){
                                echo '<input checked type="checkbox" value= '.$value->cat_ID .' id="cb_topics_bangricht'.($key+1).'" /><label class="labelChoose btnBaangerichte subtopics_bangricht_'.($key+1).' '.($key+1).'" for="cb_topics_bangricht'.($key+1).'">'. $value->cat_name .'</label>';
                                array_push($displayed, $element);
                                $state = true;
                            }
                        if($state)
                            continue;
                        echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_bangricht'.($key+1).'" /><label class="labelChoose btnBaangerichte subtopics_bangricht_'.($key+1).' '.($key+1).'" for="cb_topics_bangricht'.($key+1).'">'. $value->cat_name .'</label>';
                    }
                    ?>
                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnBaangerichte" for="cb1">Choice A</label> -->
                </div>
            </div>
            <div class="subtopicBaangerichte">
                <div class="hiddenCB">
                    <p class="pickText">Pick the sub-topics matching with the course : <span class="h6"><?=$course->post_title?></span> </p>
                    <?php
                    echo $row_bangrichts;
                    ?>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btnSkipCourse" id="btnSkipTopics1">Skip</button>
                    <button type="button" class="btn btnNext" id="nextblockBaangerichte">Next</button>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('myModal').style.display='none'">Close</button>
            <button type="button" class="btn btn-primary" id="save_subtopic_course" onclick="saveSubTopics()">Save subtopics</button>
        </div>
    </div>
      <?php }?>
<!---->
<script>
    $("#nextblockBaangerichte, #btnSkipTopics1").click(function() {
        $(".blockfunctiegericht").show();
        $(".blockBaangerichte").hide();
    });
   function saveSubTopics(){
       const selectElement = document.getElementById('selected_subtopics');
       /*
       Array.from(selectElement.options).forEach(option=>{
           if(option)
                option.setAttribute("selected", "selected");
       })
       */
       var selectedTopicOption = $("#selected_subtopics").find('option:selected');
       var subtopicsId = [];

       selectedTopicOption.each(function(){
           var values = $(this).val();
           console.log($(this))
           subtopicsId.push(values);
       });
       console.log(subtopicsId)

       // const selectedOptions = selectElement.selectedOptions
       // const selectedValues = Array.from(selectedOptions).map(option => option.value);
       // console.log('Valeurs sélectionnées:', selectedValues);


       //const selectedValues = Array.from(select.selectedOptions).map(option => option.value);
       //console.log(selectedValues);
   }
</script>
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
            placeholder: "Nothing for yet",
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
    console.log('changeeeeeeeeeee')
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
                error:function (error){
                    console.log(error)
                }
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
                },
                error: function(response) {
                    alert('Failed to create user!');
                    document.getElementById('content-back-topics').innerHTML = response;
                    console.log(response)
                },
                 complete:function(response){
                  location.reload();
                }
            });
        } else {
            $('.block-sub-topics').html(''); // Clear subtopics if no topic is selected
        }
    });
});
</script>

                     
                    