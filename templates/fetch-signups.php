<?php /** Template Name: Fetch signups */ ?>

<?php

extract($_POST);

if(isset($id_course)){
    $courseid = intval($id_course);
    if(gettype($courseid) == 'integer'){
        $args = array(
            'post_type' => 'course', 
            'post_status' => 'publish',
            'include' => [$courseid],  
        );

        $post = get_posts($args)[0];
        
        $date = get_field('data_locaties', $post->ID);
        $calendar = ['01' => 'Januari',  '02' => 'Februari',  '03' => 'Maart', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Augustus', '09' => 'September', '10' => 'Oktober',  '11' => 'November', '12' => 'December'];    
    }
    else
        $post = array(); 
}

$data = get_field('data_locaties', $post->ID);
if(!$data){
    $data = get_field('data_locaties_xml', $post->ID);
    $xml_parse = true;
}   

$price = get_field('price', $post->ID);

$subscriber_bool = false;

//get woo roders from user
$args = array(
    'limit' => -1,
);
$bunch_orders = wc_get_orders($args);
$orders = array();
$item_order = array();
$row_people_signups = "";

foreach($bunch_orders as $order){
    $item_order['id'] = $order->data['customer_id'];
    $item_order['first_name'] = $order->data['billing']['first_name'];
    $item_order['last_name'] = $order->data['billing']['last_name'];
    foreach ($order->get_items() as $item_id => $item ) {
        $course_id = intval($item->get_product_id()) - 1;
        if($course_id == $id_course){
            $item_order['name']= $item->get_name();
            $item_order['datenr'] = $item->get_meta_data('Option')[0]->value;
            $item_order['companie_title'] = get_field('company',  'user_' . $customer_id)[0]->post_title;
            $item_order['function']  = get_field('role',  'user_' . $customer_id);
            array_push($orders, $item_order);  
        }
    }
}

foreach($orders as $order){
    $customer_name = $order['first_name'] . ' ' . $order['last_name'];
    if( stristr($customer_name, $search_signup) || $search_signup == '')
        $row_people_signups .= '
        <tr>
            <td class="textTh pl-3 thModife">
                <input type="checkbox">
            </td>
            <td class="textTh">' . $order['first_name'] . '</td>
            <td class="textTh">' . $order['last_name'] . '</td>
            <td class="textTh">' . $order['companie_title'] . '</td>
            <td class="textTh">' . $order['function'] . '</td>
            <td class="textTh">' . $price . '</td>
            <td class="textTh">Prive</td>
        </tr>
        ';
}

echo $row_people_signups;

