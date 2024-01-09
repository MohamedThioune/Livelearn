<?php
    if(isset($abonnement->invoices))
        if($abonnement->invoices):
            $last_order = array_reverse($abonnement->invoices)[0];
            $last_order = (Object)$last_order;
            //var_dump($last_order);
            $last_order_date_created = explode('T', $last_order->date_created)[0];
        endif;

    if(isset($abonnement->date_created)){
        $abonnement_date_created = $abonnement->date_created;
        $abonnement_date_created = explode('T',$abonnement_date_created);
        $abonnement_date_next_payment = $abonnement->next_payment_date_gmt;
        $abonnement_date_next_payment = explode('T',$abonnement_date_next_payment)[0];
        $abonnement->total = $global_price * $abonnement->line_items[0]['quantity'];
    }else if(isset($abonnement->createdAt)){
        $abonnement_date_created = $abonnement->createdAt;
        $abonnement_date_created = explode('T',$abonnement_date_created);
        $abonnement_date_next_payment = $abonnement->nextPaymentDate;
        $abonnement->total = $global_price * $abonnement->metadata->quantity;
    }
    $global_price = 5;
?>
<div class="contentProfil ">

    <h1 class="titleSubscription">Subscription</h1>
    <div class="contentFormSubscription">
        <div class="w-100 text-center">
            <img class="gif-subscription" src="<?php echo get_stylesheet_directory_uri();?>/img/success.gif" alt="gif-subscription">
        </div>
        <h2>Your subscription is currently active</h2>
        <div class="head-content-subscription">
            <div class="detail">
                <div class="element-detail"> 
                    <p class="subtitel-detail">Team <b>x <?= $team ?></b></p>
                    <p class="product-detail"> <?= $abonnement->total ?> euros</p>
                </div>
                <div class="element-detail">
                    <p class="subtitel-detail">Last order payment</p>
                    <!-- <p class="product-detail">March 18, 2023</p> -->
                    <p class="product-detail"><?= $last_order_date_created ?></p>
                </div>
                <div class="element-detail">
                    <p class="subtitel-detail">Next payment</p>
                    <p class="product-detail"><?= $abonnement_date_next_payment ?></p>
                </div>
            </div>
            <?php
                $sub_total = $abonnement->total;
                $tva = $sub_total * (20/100);
                $total = $sub_total + $tva;
            ?>
            <div class="detail-cart">
                <div class="element-detail-cart">
                    <p class="item">Subtotal</p>
                    <p class="price-subscription"><?= $sub_total ?> euros</p>
                </div>
                <div class="element-detail-cart">
                    <p class="item">Tva</p>
                    <p class="price-subscription"><?= $tva ?> euros</p>
                </div>
                <div class="element-detail-cart">
                    <p class="item-total"><b>Total</b></p>
                    <p class="item-total"><b><?= $total ?> euros</b></p>
                </div>


            </div>
            <!--
            <div class="footer-subscription">
                <a href="" class="btn btn-continue">Continue</a>
            </div>
            -->
        </div>
    </div>

    <?php
    $situation = "";
    if(isset($abonnement->invoices))
    if($abonnement->invoices):
    ?>
    <div class="content-list-amount">
        <div class="d-flex justify-content-between align-items-center head-block">
            <h2></h2>
            <!-- <input class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek" aria-label="Zoek" > -->
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Instrument</th>
                <th scope="col">Amount</th>
                <th scope="col">Situation</th>
                <!-- <th scope="col">Action</th> -->
            </tr>
            </thead>

            <tbody>
                <?php 
                var_dump($abonnement->invoices);
                die();
                foreach($abonnement->invoices as $order):
                $order_date_created = $order['date_created'];
                $order_date_created = explode('T', $order_date_created);

                // $payment_method_title = ($order->payment_method_title || $order->payment_method_title != "" ) ? $order->payment_method_title  : "N/D";

                $situation = ($order['needs_payment']) ? '<span class="hold">On hold</span>' : '<span class="done">Done</span>';
                ?> 
                <tr>
                    <td><?= $order_date_created[0] ?></td>
                    <td><?= "Invoice" ?></td>
                    <td><?= $order['total'] ?> €</td>
                    <td><?= $situation ?></td>
                    <!-- 
                    <td>
                        <div class="dropdown text-white">
                            <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                            </p>
                            <ul class="dropdown-menu">
                                <li class="my-1"><i class="fa fa-money px-2"></i><a href="" target="_blank">Pay</a></li>
                            </ul>
                        </div>
                    </td> 
                    -->
                </tr>
                <?php endforeach; ?>
                <?php 
                foreach($abonnement->cards as $order):
                // $order_date_created = $order->date_created;
                // $order_date_created = explode('T', $order_date_created);

                // // $payment_method_title = ($order->payment_method_title || $order->payment_method_title != "" ) ? $order->payment_method_title  : "N/D";

                // $situation = ($order->needs_payment) ? '<span class="hold">On hold</span>' : '<span class="done">Done</span>';
                ?> 
                <tr>
                    <td><?= $order_date_created[0] ?></td>
                    <td><?= "Invoice" ?></td>
                    <td><?= $order->total ?> €</td>
                    <td><?= $situation ?></td>
                    <!-- 
                    <td>
                        <div class="dropdown text-white">
                            <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                            </p>
                            <ul class="dropdown-menu">
                                <li class="my-1"><i class="fa fa-money px-2"></i><a href="" target="_blank">Pay</a></li>
                            </ul>
                        </div>
                    </td> 
                    -->
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
    endif;
    ?>
</div>