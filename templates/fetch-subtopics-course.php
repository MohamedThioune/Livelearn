
<?php /** Template Name: Fetch subtopics course */ ?>

<?php
// Already exists  
$course = get_field('categories', $_POST['id_course']);

//  New subtopics
 $subtopics=$_POST['subtopics'];
 //Adding new subtopics on course
 
 //var_dump($course);
  update_field('categories', $subtopics, $_POST['id_course']);
 //var_dump(get_field('categories', $_POST['id_course']));
 foreach ($subtopics as $key => $value) {
     if ($value!='')
     $field.=(String)get_the_category_by_ID($value).',';
 }
 $field=substr($field,0,-1);
 echo $field;
 ?>