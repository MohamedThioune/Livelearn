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
      <div class="d-flex justify-content-between align-items-center mb-4">.'
        // <ul>
        //     <li class="selectAll">
        //         <input class="styled-checkbox" id="all" type="checkbox" value="all">
        //         <label for="all">Select All</label>
        //     </li>
        // </ul>
        .'
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

    foreach($tags as $tag){
      if(in_array($tag->cat_ID, $topics_internal))
        $topic_content = '<input type="hidden" name="meta_key" value="topic_affiliate" id="">
                          <a href="#" type="button" class="btn btnFollowSubTopic">Internal</a>';
      else if (in_array($tag->cat_ID, $topics_external))
        $topic_content = '<input type="hidden" name="meta_key" value="topic" id="">
                          <button type="submit" name="delete" style="background:red;" class="btn btnFollowSubTopic">Unfollow</button>';
      else
        $topic_content = '<input type="hidden" name="meta_key" value="topic" id="">
                          <button type="submit" name="interest_push" class="btn btnFollowSubTopic">Follow</button>';   
     
      $image_category = get_field('image', 'category_'. $tag->cat_ID);
      $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/placeholder.png';
      
      if(in_array($tag->cat_ID, $topics_selected )){
        $row .= ' <div class="subtTopics-element">
                      <div class="d-flex align-items-center">
                          <div class="checkbox rows">.'
                              // <input class="styled-checkbox" id="'. $tag->cat_name .'" type="checkbox" value="'. $tag->cat_ID .'" checked>
                              .'<label for="'. $tag->cat_name .'"></label>
                          </div>
                          <div class="img">
                              <img src="' . $image_category . '" alt="">
                          </div>
                          <p class="subTitleText">'. $tag->cat_name .'</p>
                      </div>
                      <div class="d-flex align-items-center">
                          <a href="/category-overview?category=' . $tag->cat_ID . '" target="_blank">See</a>
                          <form action="/dashboard/user/" method="POST">
                            <input type="hidden" name="meta_value" value="' . $tag->cat_ID . '" id="">
                            <input type="hidden" name="user_id" value="' . $id . '" id="">
                              ' . $topic_content . '
                          </form>
                      </div>
                  </div>';
        continue;
      }
      $row .= ' <div class="subtTopics-element">
                    <div class="d-flex align-items-center">
                        <div class="checkbox rows">.'
                            // <input class="styled-checkbox" id="'. $tag->cat_name .'" type="checkbox" value="'. $tag->cat_ID .'">
                            .'<label for="'. $tag->cat_name .'"></label>
                        </div>
                        <div class="img">
                            <img src="' . $image_category . '" alt="">
                        </div>
                        <p class="subTitleText">'. $tag->cat_name .'</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="/category-overview?category=' . $tag->cat_ID . '" target="_blank">See</a>
                        <form action="/dashboard/user/" method="POST">
                          <input type="hidden" name="meta_value" value="' . $tag->cat_ID . '" id="">
                          <input type="hidden" name="user_id" value="' . $id . '" id="">
                            ' . $topic_content . '
                        </form>
                    </div>
                </div>';
      $bool_tag = true;
    }
    $topic .= $row;
  }

  if(!$bool_tag)
    $topic .= '<center><span class="kraaText" style="color:red">No child categories belongs to your selection !</span></center><br>';

  $output =  $topic . '
            <div class="mt-3 mb-0">
              <button type="button" id="backTopics" class="btn bg-dark btnNext mr-3 mb-0">Back</button>
            </div>';

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
