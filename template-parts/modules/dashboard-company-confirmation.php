<?php

$current_user = wp_get_current_user();

if(!in_array('administrator', $current_user->roles) && !in_array('hr', $current_user->roles)) 
    header('Location: /dashboard/company/');

$company = get_field('company', 'user_' . $current_user->ID);
if(!empty($company) ){
    $company = $company[0];
    $company_connected = $company->post_title;
}

$telnr = get_field('telnr', 'user_' . $current_user->ID);
?>

<div class="contentProfil ">

    <h1 class="titleSubscription">Subscription</h1>
    <div class="contentFormSubscription">
        <div class="w-100 text-center">
            <img class="gif-subscription" src="<?php echo get_stylesheet_directory_uri();?>/img/success.gif" alt="gif-subscription">
        </div>
        <h2>Your order is complete ans had been confirmed</h2>
        <div class="head-content-subscription">
            <div class="detail">
                <div class="element-detail">
                    <p class="subtitel-detail">Order Date</p>
                    <p class="product-detail">18 March 2023</p>
                </div>
                <div class="element-detail">
                    <p class="subtitel-detail">Payment</p>
                    <p class="product-detail">18 March 2023</p>
                </div>
                <div class="element-detail">
                    <p class="subtitel-detail">Adress</p>
                    <p class="product-detail">18 March 2023</p>
                </div>
            </div>
            <div class="detail-cart">
                <div class="element-detail-cart">
                    <p class="item">Subtotal</p>
                    <p class="price-subscription">$400</p>
                </div>
                <div class="element-detail-cart">
                    <p class="item">Tva</p>
                    <p class="price-subscription">$20</p>
                </div>
                <div class="element-detail-cart">
                    <p class="item-total"><b>Total</b></p>
                    <p class="item-total"><b>$420</b></p>
                </div>
            </div>
            <div class="footer-subscription">
                <a href="" class="btn btn-continue">Continue</a>
            </div>
        </div>
    </div>




</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>