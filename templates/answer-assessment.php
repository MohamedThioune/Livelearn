<?php /** Template Name: Answer assessment */ ?>

<?php
$args = array(  
    'post_type' => 'assessment',
    'post_status' => 'publish',
    //'posts_per_page' => 8, 
    //'orderby' => 'title', 
    'order' => 'ASC', 
);

$current_index=(int)($_POST['current_index']);
//$current_index++;
$loop = new WP_Query( $args ); 
$count_question=0;
while ( $loop->have_posts() ) : $loop->the_post(); 
    $count_question++;
    $post_id = get_the_ID();
    $title = get_the_title();
    $author = get_the_author();
    $question = get_field( "question", $post_id );
    //var_dump($question);
    // print the_title(); 
    // the_excerpt(); 
endwhile;
$question[$current_index]['count']=count($question);
if (!isset($_POST['user_responses']))
        echo json_encode($question[$current_index]);
else
{
    $args=array(
        'post_type' => 'response_assessment',
        'post_author' => get_current_user_id(),
        'post_status' => 'publish',
        'post_title' => $title.' '.$author,
    );
    $id_new_response=wp_insert_post( $arg);
    $score=0;
    $responses=array();
    $user_responses=$_POST['user_responses'];
   // var_dump($user_responses);
    foreach ($question as $key => $value) {
        
        if ($value['correct_response']==$user_responses[$key])
        {
            array_push($responses, ["status"=>1,"sent_responses"=>$user_responses[$key],"response_id"=>$key]); 
            $score++;
        }
        else
        {
            array_push($responses, ["status"=>0,"sent_responses"=>$user_responses[$key],"response_id"=>$key]); 
        }
        update_field('responses_user', $responses, $id_new_response);
        update_field('assessment_id',$post_id,$id_new_response);
        update_field('score',$score,$id_new_response);
}    
    $score = ($score/count($question))*100;  
    echo 'Your score is '. $score . '%' ;
}

?>