<?php
//Create orders stripe
function create_order($data){
    global $wpdb;
    $table = $wpdb->prefix . 'stripe_order';

    $sql_orders_stripe = $wpdb->prepare(
        "SELECT * FROM $table WHERE course_id = %s AND owner_id = %s", $data['course_id'], $data['owner_id']
    );
    $orders_stripe = $wpdb->get_results($sql_orders_stripe);

    if (isset($orders_stripe[0])) 
        return 1;
    else 
        return $wpdb->insert($table, $data);
}

//Listing orders stripe
function list_orders($userID){
    global $wpdb;
    $table = $wpdb->prefix . 'stripe_order';

    $sql_orders_stripe = $wpdb->prepare("SELECT course_id, metadata FROM $table WHERE owner_id = $userID");
    $orders_stripe = $wpdb->get_results($sql_orders_stripe);
    $enrolledPost = array();
    $enrolledID = array();
    if(isset($orders_stripe[0]))
        foreach ($orders_stripe as $order)
            if($order->course_id):
                $post = get_post($order->course_id);
                if($post):
                //Get metadata
                $post->metadata = ($order->metadata) ?: null;
                //Get extra informations on the post 
                //+short description
                $post->short_description = get_field('short_description', $post->ID) ?: 'No description available !';
                //+long description
                $post->long_description = get_field('long_description', $post->ID) ?: 'No long description available !';
                //+Image
                $course_type = get_field('course_type', $post->ID);
                $thumbnail = "";
                if(!$thumbnail):
                    $thumbnail = get_the_post_thumbnail_url($post->ID);
                    if(!$thumbnail)
                        $thumbnail = get_field('url_image_xml', $post->ID);
                        if(!$thumbnail)
                            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                endif;
                $post->image = $thumbnail;
                //+author
                $author = get_user_by('id', $post->post_author);
                $author_name = ($author->last_name) ? $author->first_name . ' ' . $author->last_name : $author->display_name;
                $author_image = get_field('profile_img',  'user_' . $post->post_author);
                $author->image= $author_image ? $author_image : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                $post->author = $author;
                array_push($enrolledPost, $post);
                array_push($enrolledID, $post->ID);
                endif;
            endif;
    
    //Reverse array of orders
    $enrolledPost = (empty($enrolledPost)) ?: array_reverse($enrolledPost);
    return ['ids' => $enrolledID, 'posts' => $enrolledPost];
}

?>
