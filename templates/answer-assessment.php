<?php /** Template Name: Answer assessment */ ?>

<?php

if (isset($_POST['id_current_assessment']))
{
    $assessment = get_post($_POST['id_current_assessment']);
    $current_index=(int)($_POST['current_index']); 
    $question=get_field('question',$assessment->ID);
    $question[$current_index]['count']=count($question);
    if (!isset($_POST['user_responses']))
            echo json_encode($question[$current_index]);
    else
    {
        $args=array(
            'post_type' => 'response_assessment',
            'post_author' => get_current_user_id(),
            'post_status' => 'publish',
            'post_title' => $assessment->post_title .' '.get_user_by('ID',get_current_user_id())->display_name,
        );
        $id_new_response=wp_insert_post($args);
        $score=0;
        $responses=array();
        $user_responses=$_POST['user_responses'];
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
            update_field('assessment_id',$assessment->ID,$id_new_response);
            update_field('score',$score,$id_new_response);
    }    
        $score = (int)(($score/count($question)) * 100);
        $assessments_validated = get_user_meta( get_current_user_id(), 'assessment_validated');

        if ($score >= 50)
        {
            array_push($assessments_validated , $assessment);
            add_user_meta( get_current_user_id(), 'assessment_validated',$assessment); 
            
        }
        // $status = $score >= 50 ? "Congratulations " : "Unfortunately ";
        // echo $status.'your score is '. $score . '%' ;
        echo $score;
    }

}
?>