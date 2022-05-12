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
        $question=get_field( "question", $post_id );
        //var_dump($question);
        // print the_title(); 
        // the_excerpt(); 
    endwhile;
?>

<div class="head3OverviewAssessment">
                    <p class="assessmentNUmber" id="current-index">Question <?php echo $current_index+1; ?> / <?php echo $count_question; ?></p>
                    <p class="assessmentTime" id="backendTime"><?php echo $question[0]['timer'] ?></p>
                </div>
                <p class="chooseTechnoTitle"><?php echo $question[$current_index]['wording'] ?><span> (Multiple choose posible)</span></p>
                <div class="listAnswer">
                    <label class="container-checkbox">
                        <span class="numberAssassment">A.</span>
                        <span class="assassment"><?php echo $question[$current_index]['responses'][$current_index] ?></span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>

                    <label class="container-checkbox">
                        <span class="numberAssassment">B.</span>
                        <span class="assassment"><?php echo $question[$current_index]['responses'][1] ?></span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">C.</span>
                        <span class="assassment"> <?php echo $question[$current_index]['responses'][2] ?></span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container-checkbox">
                        <span class="numberAssassment">D.</span>
                        <span class="assassment"><?php echo $question[$current_index]['responses'][3] ?></span>
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <button class="btn btnStratModal" id="btnBackend">Continue</button>