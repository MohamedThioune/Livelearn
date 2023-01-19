<?php
    $abonnement_date_created = $abonnement['date_created'];

    $abonnement_date_created = explode('T',$abonnement_date_created);
?>
<div class="contentProfil ">

    <h1 class="titleSubscription">Subscription</h1>
    <div class="contentFormSubscription">
        <div class="w-100 text-center">
            <img class="gif-subscription" src="<?php echo get_stylesheet_directory_uri();?>/img/success.gif" alt="gif-subscription">
        </div>
        <h2>Your order is complete and had been confirmed</h2>
        <div class="head-content-subscription">
            <div class="detail">
                <div class="element-detail">
                    <p class="subtitel-detail">Team <b>x <?= $team ?></b></p>
                    <p class="product-detail"> <?= $team * 5 ?> euros</p>
                </div>
                <div class="element-detail">
                    <p class="subtitel-detail">Last order payment</p>
                    <!-- <p class="product-detail">March 18, 2023</p> -->
                    <p class="product-detail"><?= $abonnement_date_created[0] ?></p>
                </div>
                <div class="element-detail">
                    <p class="subtitel-detail">Next payment</p>
                    <p class="product-detail">xxxx</p>
                </div>
            </div>
            <?php 
                $sub_total = $team * 5;
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




</div>