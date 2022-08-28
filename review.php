<?php /** Template Name: Review */ ?>

<?php 

    extract($_POST);

    $reviews = get_field('reviews', $id);
    $review = array();
    $review['user'] = get_user_by('ID', $user_id);
    $review['rating'] = $stars;
    $review['feedback'] = $feedback_content;
    var_dump($review['feedback']);
    if($review['user']){ 
        if(!$reviews)
            $reviews = array();
        array_push($reviews,$review);
        update_field('reviews',$reviews, $id);
        $message = "Your review added successfully"; 
    }
    else 
        $message = "User not find...";         

    $reviews = get_field('reviews', $id);
    if(!empty($reviews)){
        foreach($reviews as $review){
            $user = $review['user'];
            $image_author = get_field('profile_img',  'user_' . $user->ID);
            $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';
            $rating = $review['rating']; 
            $stars = "";                  

            $row_review = '<div class="review-info-card">
                                <div class="review-user-mini-profile">
                                    <div class="user-photo">
                                        <img src="' . $image_author . '" alt="">
                                    </div>
                                    <div class="user-name">
                                        <p>' . $user->display_name . '</p>
                                        <div class="rating">';

            for($i = $rating; $i >= 1; $i--){
                if($i == $rating)
                    $stars .= '<input type="radio" name="rating" value="' . $i . ' " checked disabled/>
                                <label class="star" title="" aria-hidden="true"></label>';
                else 
                    $stars .= '<input type="radio" name="rating" value="' . $i . ' " disabled/>
                                <label class="star" title="" aria-hidden="true"></label>';
            }

            $row_review .= $stars . '
                                        </div>
                                    </div>
                                </div>

                                <p class="reviewsText">' . $review['feedback'] .'</p>
                                
                           </div>';
        }
        echo $row_review;
    }
    else 
        //echo "<h6>No reviews found for this course ...<h6>";
   
?>
