<?php
  /** Template Name: topic ajax */ 
  extract($_POST);
  $output = "";
  
  $banger = "";
  $functie = "";
  $skill = "";
  $interes = "";

  foreach($bangers as $key=>$tag){
    if($key==0)
      $banger = "<h4 class='titleSelectStep'>Banen : </h4>";

    $row_third = "";
    $row_secondary = "";

    //Topics
    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent' => $tag,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $row_secondary .= "<label for='locate'>" . (String)get_the_category_by_ID($tag) . ": </label><br> 
                       <div class='form-group formModifeChoose'>
                        <select name='hashtag_banger[]' id='form-control' class='multipleSelect2' multiple='true'>";

    foreach($cats as $value)
      $row_third .= "<option value='" . $value->cat_ID ."'>" . $value->cat_name . "</option>";

    $row_secondary .= $row_third . "</select>
                    </div>";
    $banger .= $row_secondary;
  }

  foreach($functs as $key=>$tag){
    if($key==0)
      $functie = "<h4 class='titleSelectStep'>Functies : </h4>";

    $row_third = "";
    $row_secondary = "";

    //Topics
    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent' => $tag,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $row_secondary .= "<label for='locate'>" . (String)get_the_category_by_ID($tag) . ": </label><br> 
                       <div class='form-group formModifeChoose'>
                        <select name='hashtag_funct[]' id='form-control' class='multipleSelect2' multiple='true'>";

    foreach($cats as $value)
      $row_third .= "<option value='" . $value->cat_ID ."'>" . $value->cat_name . "</option>";

    $row_secondary .= $row_third . "</select>
                    </div>";
    $functie .= $row_secondary;
  }

  foreach($skills as $key=>$tag){
    if($key==0)
      $skill = "<h4 class='titleSelectStep'>Skills : </h4>";

    $row_third = "";
    $row_secondary = "";

    //Topics
    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent' => $tag,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $row_secondary .= "<label for='locate'>" . (String)get_the_category_by_ID($tag) . ": </label><br> 
                       <div class='form-group formModifeChoose'>
                        <select name='hashtag_skill[]' id='form-control' class='multipleSelect2' multiple='true'>";

    foreach($cats as $value)
      $row_third .= "<option value='" . $value->cat_ID ."'>" . $value->cat_name . "</option>";

    $row_secondary .= $row_third . "</select>
                    </div>";
    $skill .= $row_secondary;
  }

  foreach($interess as $key=>$tag){
    if($key==0)
      $interes = "<h4 class='titleSelectStep'>Interesses : </h4>";

    $row_third = "";
    $row_secondary = "";

    //Topics
    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent' => $tag,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $row_secondary .= "<label for='locate'>" . (String)get_the_category_by_ID($tag) . ": </label><br> 
                       <div class='form-group formModifeChoose'>
                        <select name='hashtag_interes[]' id='form-control' class='multipleSelect2' multiple='true'>";

    foreach($cats as $value)
      $row_third .= "<option value='" . $value->cat_ID ."'>" . $value->cat_name . "</option>";

    $row_secondary .= $row_third . "</select>
                    </div>";
    $interes .= $row_secondary;
  }

  $output =  $banger . $functie . $skill . $interes ."<button type='submit' name='topic_add' class='btn btn-info'>Next</button>";

  echo $output;

?>

<script id="rendered-js" >
    $(document).ready(function () {
        //Select2
        $(".multipleSelect2").select2({
            placeholder: "What's your rating" //placeholder
        });
    });
    //# sourceURL=pen.js
</script>
