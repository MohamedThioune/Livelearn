<?php
//Create orders stripe
function create_order($data){
    global $wpdb;
    $table = $wpdb->prefix . 'stripe_order';

    $sql_order_stripe = $wpdb->prepare(
        "SELECT * FROM $table WHERE course_id = %s AND owner_id = %s",
        $data['course_id'], $data['owner_id']
    );
    $result_order_stripe = $wpdb->get_results($sql_order_stripe);

    if (isset($result_order_stripe[0])) 
        return 1;
    else 
        return $wpdb->insert($table, $data);
}

?>
