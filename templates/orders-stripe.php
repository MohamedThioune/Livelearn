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

    $sql_orders_stripe = $wpdb->prepare("SELECT course_id FROM $table WHERE owner_id = $userID");
    $orders_stripe = $wpdb->get_results($sql_orders_stripe);
    $enrolledPost = array();
    $enrolledID = array();
    if(isset($orders_stripe[0]))
        foreach ($orders_stripe as $order)
            if($order->course_id):
                $post = get_post($order->course_id);
                if($post):
                array_push($enrolledPost, $post);
                array_push($enrolledID, $post->ID);
                endif;
            endif;
    
    //Reverse array of orders
    $enrolledPost = (empty($enrolledPost)) ?: array_reverse($enrolledPost);
    return ['ids' => $enrolledID, 'posts' => $enrolledPost];
}

?>
