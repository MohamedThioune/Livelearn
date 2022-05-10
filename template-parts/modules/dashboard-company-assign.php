<?php

global $wpdb;

//get woo roders from user
$args = array(
    'customer_id' => get_current_user_id(),
    'post_status' => array_keys(wc_get_order_statuses()), 'post_status' => array('wc-processing'),

);
$orders = wc_get_orders($args);

if(isset($_GET['course_id']) && isset($_GET['payment_id']) && isset($_GET['datenr'])){
    $args_assigns = array(
        'post_type' => 'assign',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'course_id',
                'value' => $_GET['course_id'],
                'compare' => '=',
            ),
            array(
                'key' => 'payment_id',
                'value' => $_GET['payment_id'],
                'compare' => '=',
            ),
            array(
                'key' => 'datenr',
                'value' => $_GET['datenr'],
                'compare' => '=',
            ),
        ),
    );

    $data = get_posts($args_assigns);

}

?><div class="contentListeCourse">
    <div class="cardOverviewCours">

        <?php if(isset($_GET['payment_id']) && isset($_GET['course_id'])){?>
        <div class="headListeCourse">
            <p class="JouwOpleid">Reeds toegewezen</p>
        </div>

        <div class="contentCardListeCourse">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th scope="col">Naam</th>
                        <th scope="col">Email</th>
                        <th scope="col">Startdatum</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

        foreach ( $data as $subscripted) {
            $userdata = get_post_meta($subscripted->ID, 'userdata', true);
            $userdata = json_decode($userdata);
            if(!empty($userdata)){
                        ?>
                        <tr>
                            <td class="textTh"><?php echo $userdata->firstname.' '.$userdata->insertion.' '.$userdata->lastname; ?></td>
                            <td class="textTh"><?php echo $userdata->email;?></td>
                            <td class="textTh"><?php echo $_GET['datenr']; ?></td>
                        </tr>
                        <?php 
            }else{
                        ?>
                        <tr>
                            <td class="textTh">Onbekende gebruiker</td>
                            <td class="textTh">onbekende gebruikersmail</td>
                            <td class="textTh">Onbekende gebruiker</td>
                        </tr>
                        <?php 
            }
        }
                        ?>
                    </tbody>
                </table>

                <?php 
        $order = wc_get_order($_GET['payment_id']);
        foreach ( $order->get_items() as $item_id => $item ) {
            if($item->get_product_id() == $_GET['course_id'] && $item->get_meta_data('Option')[0]->value == $_GET['datenr']){
                $assigns = $item->get_quantity();
                $course_id = $item->get_product_id();
                $datenr = $item->get_meta_data('Option')[0]->value;
            }   
        }


        $args_assigns = array(
            'post_type' => 'assign',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'course_id',
                    'value' => $course_id,
                    'compare' => '=',
                ),
                array(
                    'key' => 'payment_id',
                    'value' => $_GET['payment_id'],
                    'compare' => '=',
                ),
                array(
                    'key' => 'datenr',
                    'value' => $datenr,
                    'compare' => '=',
                ),
            ),
        );

        $data = get_posts($args_assigns);
        $assigned = count($data);


        if($assigned < $assigns){
                ?>


                <div class="table">

                    <input type="hidden" class="var_course_id" value="<?php echo $_GET['course_id'];?>">
                    <input type="hidden" class="var_payment_id" value="<?php echo $_GET['payment_id'];?>">




                    <?php echo do_shortcode('[gravityform id="1"]');?>
                </div>
                <?php }?>

            </div>
    <?php }
    else{
    ?>


        <div class="headListeCourse">
            <p class="JouwOpleid">Bestellingen</p>
        </div>
        <div class="contentCardListeCourse">
            <?php 
            if(isset($_GET['payment_id']) && !isset($_GET['course_id'])){?>
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">Actie</th>
                            <th scope="col">Naam cursus</th>
                            <th scope="col">Aantal</th>
                            <th scope="col">Startdatum</th>
                            <th scope="col">Toegewezen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $order = wc_get_order($_GET['payment_id']);
                        foreach ( $order->get_items() as $item_id => $item ) {

                            $args_assigns = array(
                                'post_type' => 'assign',
                                'meta_query' => array(
                                    'relation' => 'AND',
                                    array(
                                        'key' => 'course_id',
                                        'value' => $item->get_product_id(),
                                        'compare' => '=',
                                    ),
                                    array(
                                        'key' => 'payment_id',
                                        'value' => $_GET['payment_id'],
                                        'compare' => '=',
                                    ),
                                    array(
                                        'key' => 'datenr',
                                        'value' => $item->get_meta_data('Option')[0]->value,
                                        'compare' => '=',
                                    ),
                                ),
                            );

                            $data = get_posts($args_assigns);
                            $count = count($data);

                            ?>
                            <tr>
                                <td class="textTh"><a href="?payment_id=<?php echo $_GET['payment_id'];?>&course_id=<?php echo $item->get_product_id();?>&datenr=<?php echo $item->get_meta_data('Option')[0]->value;?>">Toewijzen</a></td>
                                <td class="textTh"><?php echo $item->get_name();?></td>
                                <td class="textTh"><?php echo $item->get_quantity();?></td>
                                <td class="textTh"><?php echo $item->get_meta_data('Option')[0]->value;?></td>
                                <td class="textTh"><?php echo $count;?>/<?php echo $item->get_quantity();?></td>
                            </tr>
                        <?php 
                        }
                        ?>
                    </tbody>
                </table>
            <?php 
            }
            else{ 
                ?>
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">Aangekocht</th>
                            <th scope="col">Ordernummer</th>
                            <th scope="col">Datum van aanschaf</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($orders as $order){        
                        ?>
                            <tr>
                                <td class="textTh"><a href="?payment_id=<?php echo $order->get_id();?>">Openen</a></td>
                                <td class="textTh">Order <?php echo $order->get_id();?></td>
                                <td class="textTh"><?php echo $order->get_date_paid();?></td>
                                <td class="textTh"><?php echo $order->get_status();?></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            <?php 
            }?>
        </div>
        <?php }?>
    </div>
</div>


