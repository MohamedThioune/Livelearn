<?php

if(isset($_GET['parse'])){
    $courseid = intval($_GET['parse']);
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

foreach($bunch_orders as $order){
    $item_order['id'] = $order->data['customer_id'];
    $item_order['first_name'] = $order->data['billing']['first_name'];
    $item_order['last_name'] = $order->data['billing']['last_name'];
    foreach ($order->get_items() as $item_id => $item ) {
        $course_id = intval($item->get_product_id()) - 1;
        if($course_id == $_GET['parse']){
            $item_order['name']= $item->get_name();
            $item_order['datenr'] = $item->get_meta_data('Option')[0]->value;
            $item_order['companie_title'] = get_field('company',  'user_' . $customer_id)[0]->post_title;
            $item_order['function']  = get_field('role',  'user_' . $customer_id);
            array_push($orders, $item_order);  
        }
    }
}

$inkomsten = count($orders) * $price;
?>

<div class="contentPageManager">
    <div class="blockSidbarMobile blockSidbarMobile2">
        <div class="zijbalk">
            <p class="zijbalkMenu">zijbalk menu</p>
            <button class="btn btnSidbarMob">
                <img src="img/filter.png" alt="">
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-8">
            <div class="cardCoursGlocal">
                <div class="w-100">
                    <div class="titleOpleidingstype">
                        <?php
                             $calendar = ['01' => 'Januari',  '02' => 'Februari',  '03' => 'Maart', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Augustus', '09' => 'September', '10' => 'Oktober',  '11' => 'November', '12' => 'December'];    
                             $date_start = ''; 
                             $agenda_start = '';
                             foreach($date as $datum) {                     
                                 if(!empty($datum['data'])){
                                     $date_start = $datum['data'][0]['start_date'];
                                     $location = $datum['data'][0]['location'];
                                     if($date_start)
                                         if(count($datum['data']) >= 1)
                                             $agenda_start = explode('/', explode(' ', $date_start)[0])[0] . ' ' . $calendar[explode('/', explode(' ', $date_start)[0])[1]];
                                             break;
                                }
                            }
                            if(isset($xml_parse)){
                                $x = 0;
                                $number = count($data)-1;
                                $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];    
                                $date_start = explode(' ', $data[0]['value']);
                                $date_end = explode(' ', $data[$number]['value']);
                                $d_start = explode('/',$date_start[0]);
                                $d_end = explode('/',$date_end[0]);
                                $h_start = explode('-', $date[1])[0];
                                $h_end = explode('-', $date_end[1])[0];
                        
                                $agenda_start = $d_start[0] . ' ' . $calendar[$d_start[1]];
                                $agenda_end = $d_end[0] . ' ' . $calendar[$d_end[1]];
                                $location = explode('-', $date_start[2])[1];
                            }
                        ?>
                    <h2><?php echo $post->post_title ?></h2>
                    </div>
                    <div class="blockCardAcqureren">
                        <div class="cardAcqureren">
                            <p class="titleCardAcqureren">Aantal inschrijvingen</p>
                            <p class="numberCardAcqureren"><?php echo count($orders) ?></p>
                        </div>
                        <div class="cardAcqureren">
                            <p class="titleCardAcqureren">Inkomsten</p>
                            <p class="numberCardAcqureren"><?php echo $inkomsten ?></p>
                        </div>
                        <div class="cardAcqureren">
                            <p class="titleCardAcqureren">Startdatum</p>
                            <p class="numberCardAcqureren"><?php echo $agenda_start?></p>
                        </div>
                        <div class="cardAcqureren">
                            <p class="titleCardAcqureren">Locatie</p>
                            <p class="numberCardAcqureren"><?php if(isset($location)) echo $location; ?></p>
                        </div>
                    </div>
                    <div class="tableListeView">
                        <div class="headListeCourse">
                            <p class="JouwOpleid">Inschrijvingen</p>
                            <div class="d-flex">
                                <a href="" class="btnZoek">Zoek personen</a>
                                <a href="" class="btnActiviteit">Actie</a>
                            </div>
                        </div>
                        <div class="contentCardListeCourse">
                            <?php
                            if(!empty($orders)){
                            ?>
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Naam</th>
                                    <th scope="col">Achternaam</th>
                                    <th scope="col">Bedrijf</th>
                                    <th scope="col">Functie</th>
                                    <th scope="col">Prijs</th>
                                    <th scope="col">Betaaid</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $subscriber_bool = false;
                                    foreach($orders as $order){
                                   
                                    ?>
                                        <tr>
                                            <td class="textTh pl-3 thModife">
                                                <input type="checkbox">
                                            </td>
                                            <td class="textTh"><?= $order['first_name']; ?></td>
                                            <td class="textTh"><?= $order['last_name']; ?></td>
                                            <td class="textTh"><?= $order['companie_title'];?></td>
                                            <td class="textTh"><?= $order['function'];; ?></td>
                                            <td class="textTh">€ <?php echo $price ?></td>
                                            <td class="textTh">Prive</td>
                                        </tr>
                                    <?php 
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            }
                            else
                                echo"<center style = 'color:#00A89D; font-weight:bold;'>No subscribers for this course yet.<center>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-lg-4">
            <div class="blockRight2">
                <a href="" class="btn btnActiviteit btnBewerken">Bewerken</a>
                    <div class="w-100">
                        <div class="textGroup2">
                            <p>Geplande data</p>
                            <p>Aanmeidingen</p>
                        </div>
                        <?php 
                        if(!isset($xml_parse)){
                            if(!empty($date)){
                                $calendar = ['01' => 'Januari',  '02' => 'Februari',  '03' => 'Maart', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Augustus', '09' => 'September', '10' => 'Oktober',  '11' => 'November', '12' => 'December'];    
                                foreach($date as $datum) {
                                    if(!empty($datum['data'])){
                                        for($i = 0; $i < count($datum['data']); $i++) { 
                                            $date_start = $datum['data'][$i]['start_date'];
                        
                                            $location = $datum['data'][$i]['location'];
                                            if($date_start != null){
                                                $day = explode('/', explode(' ', $date_start)[0])[0] . ' ' . $calendar[explode('/', explode(' ', $date_start)[0])[1]];
                                    
                            ?>
                            <a href="" class="btn btnDate"><?php echo $day . ', '. $location; ?> <span>15</span></a>
                            <?php               }
                                        } 
                                    }     
                                }
                            }
                        }else{
                            foreach($data as $datum) {
                                $date = explode(' ', $datum['value']);
        
                                $d = explode('/',$date[0]);
                                $day = $d[0] . ' ' . $calendar[$d[1]];
                                $hour = explode(':', explode('-', $date[1])[0])[0] .':'. explode(':', explode('-', $date[1])[0])[1];
                                $location = explode('-',$date[2])[1];
                        
                        ?>
                                <a href="" class="btn btnDate"><?php echo $day . ', '. $location; ?> <span>15</span></a>
                        <?php
                            } 
                        }  
                        ?>
                        <a href="" class="btn btnSubmit w-100">Toevoegen</a>
                    </div>  
            </div>
        </div>
    </div>
</div>









