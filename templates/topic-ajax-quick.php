<?php
/** Template Name: topic ajax quick */ 
extract($_POST);
$output = "";
$topic = "";
$bool_tag = false;
$read_tag = array();

// Get interests courses
$topics_external = get_user_meta($id, 'topic');
$topics_internal = get_user_meta($id, 'topic_affiliate');

$topics_selected = array();
if(!empty($topics_external))
    $topics_selected = $topics_external;

if(!empty($topics_internal))
    foreach($topics_internal as $value)
      array_push($topics_selected, $value);


  $row = "";
  foreach($topics as $key => $value){

    if($key==0)
      $topic = ' 
      <div class="d-flex justify-content-between align-items-center mb-4">
        
        <div class="position-relative">'
            // <input type="search" placeholder="Search for your favorite Subtopics" class="searchSubTopics">
            // <img class="searchImg" src="' . get_stylesheet_directory_uri() . '/img/searchM.png" alt=""> 
            .'
        </div>
      </div>';

    $row = "";

    //Topics
    $tags = get_categories( array(
      'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
      'parent' => $value,
      'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ));

    foreach($tags as $key => $tag){
      if(in_array($tag->cat_ID, $topics_internal))
        $topic_content = '<a href="#" type="button" class="btn btnFollowExpert">Internal</a>';
      else if (in_array($tag->cat_ID, $topics_external))
        $topic_content = '<input type="hidden" id="meta_key_tag' . $key . '" value="topic">
                          <button type="button" style="background:red;" class="btn btnPushTag btnFollowExpert"><span id="autocomplete-push-tag' . $key . '">Unfollow</span></button>';
      else
        $topic_content = '<input type="hidden" id="meta_key_tag' . $key . '" value="topic">
                          <button type="button" class="btn btnPushTag btnFollowExpert" value="' . $key . '"><span id="autocomplete-push-tag' . $key . '">Follow</span></button>';   
     
      $image_category = get_field('image', 'category_'. $tag->cat_ID);
      $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/placeholder.png';
      
      $row .= ' <div class="subtTopics-element">
                    <div class="d-flex align-items-center">
                        <div class="img">
                            <img src="' . $image_category . '" alt="">
                        </div>
                        <p class="subTitleText">'. $tag->cat_name .'</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="/category-overview?category=' . $tag->cat_ID . '" target="_blank">See</a> 
                          <input type="hidden" id="meta_value_tag' . $key . '" value="' . $tag->cat_ID . '">
                          <input type="hidden" id="user_id_tag' . $key . '" value="' . $id . '">
                            ' . $topic_content . '
                        
                    </div>
                </div>';
      $bool_tag = true;
    }
    $topic .= $row;
  }

  if(!$bool_tag)
    $topic .= '<center><span class="kraaText" style="color:red">No child categories belongs to your selection !</span></center><br>';

  $output = $topic;
  
  // $output =  $topic . 
  //           '<div class="mt-3 mb-0">
  //             <button type="submit" form="multiple_form_tags" class="btn btnNext mb-0" name="interest_multiple_push">Follow / Unfollow</button>
  //           </div>';

  echo $output;

?>

<script id="rendered-js" >
    $(document).ready(function () {
        //Select2
        $(".multipleSelect2").select2({
            placeholder: "Maak uw keuze" //placeholder
        });
    });
    //# sourceURL=pen.js
</script>

<script>
    $('.btnPushTag').click((e)=>{
        var key = e.currentTarget.value;
        var user_id = $("#user_id_tag" + key).val();
        var meta_key = $("#meta_key_tag" + key).val();
        var meta_value = $("#meta_value_tag" + key).val();
        $.ajax({
                url:"/interest-push",
                method:"POST",
                data:{
                    'user_id': user_id,
                    'meta_key': meta_key,
                    'meta_value': meta_value
                },
                dataType:"text",
                success: function(data){
                    console.log(data);
                    $('#autocomplete-push-tag' + key).html(data);

                }
        });
    });
</script>