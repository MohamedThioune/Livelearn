<?php /** Template Name: Checkout Stripe */ ?>

<?php get_header(); ?>

<?php
//Price ID
$price_id = '';
if(isset($_GET['priceID'])):
    $key_password = "C@##me1995.";
    $price_id = openssl_decrypt($_GET['priceID'], "AES-128-ECB", $key_password);
    $mode = openssl_decrypt($_GET['mode'], "AES-128-ECB", $key_password);
    var_dump($mode);
endif;
?>
<head>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<script src="https://js.stripe.com/v3/"></script>
<script defer>
    // This is your test secret API key.
    const stripe = Stripe("pk_test_51JyijWEuOtOzwPYXpQ5PQzJGMroshnARkLBNWWJK2ZOsGaaJvF0tmh96eVkAgklzjB8L3usvqvP3229HTXx796nt00qw0X8k7y");

    initialize();

    // Create a Checkout Session
    async function initialize() {
    const fetchClientSecret = async () => {
        const priceID = "<?php echo $price_id ?>";
        const mode = "<?php echo $mode ?>";
        alert(mode)
        const response = await fetch("/checkout-module/?priceID=" + priceID + "&mode=" + mode + " ", {
            method: "POST",
        });
        const { clientSecret } = await response.json();
        return clientSecret;
    };

    const checkout = await stripe.initEmbeddedCheckout({
        fetchClientSecret,
    });

    // Mount Checkout
    checkout.mount('#checkout');
    }
</script>
</head>

<!--<style>
    .HeightObserverProvider-container .App-Container {
        display: flex !important;
        justify-content: space-between;
        flex-wrap: wrap;
        width: 100%;
    }
    .HeightObserverProvider-container .TestModeNotch {
        width: 100%;
        text-align: center;
    }
    .HeightObserverProvider-container .Tag{
        display: block;
    }
    #modalPayment .HeightObserverProvider-container .App-Overview {
        width: 41%;
        padding-top: 30px;
    }
    .HeightObserverProvider-container .App-Payment {
        width: 55%;
        margin-top: 48px;
    }
    @media all and (min-width: 300px) and (max-width: 767px){
        .HeightObserverProvider-container .App-Overview {
            width: 100%;
            padding-top: 30px;
        }
        .HeightObserverProvider-container .App-Payment {
            width: 100%;
            margin-top: 20px;
        }
    }
</style>-->
<body>

<div class="contentProfil">
   <div class="container-fluid">
       <h1 class="titleSubscription">Checkout - sample</h1>
       <!-- <center><?php if(isset($_GET['message'])) echo "<span class='alert alert-info'>" . $_GET['message'] . "</span><br><br>"?></center> -->

       <div class="contentFormSubscription">

           <!-- <form action="" method="POST"> -->

           <div class="form-row">
               <div class="form-group col-md-6">
                   <label for="first_name">First name</label>
                   <i class="fas fa-user" aria-hidden="true"></i>
                   <input type="text" class="form-control" id="first_name" value="<?= $current_user->first_name ?>" placeholder="First name" name="first_name" required>
               </div>
               <div class="form-group col-md-6">
                   <label for="last_name">Last name</label>
                   <i class="fas fa-users" aria-hidden="true"></i>
                   <input type="text" class="form-control" id="last_name" value="<?= $current_user->last_name ?>" placeholder="Last name" name="last_name" required>
               </div>
           </div>
           <div class="form-group">
               <label for="bedrjifsnaam">Email</label>
               <i class="fas fa-building" aria-hidden="true"></i>
               <input type="email" class="form-control" id="" value="" placeholder="Email" name="email" required>
           </div>
           <div class="form-group">
               <label for="city">Company name</label>
               <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
               <input type="text" class="form-control" id="" value="" placeholder="Company name" name="name_company">
           </div>
           <div class="form-row">
               <div class="form-group col-md-12">
                   <label for="phone">Phone number</label>
                   <i class="fas fa-phone" aria-hidden="true"></i>
                   <input type="number" class="form-control" id="phone" value="<?= $telnr ?>" placeholder="Phone number" name="phone" required>
               </div>
           </div>
           <div class="form-group">
               <label for="factuur_address">Factuur Adress</label>
               <i class="fas fa-thumbtack"></i>
               <input type="text" class="form-control" id="factuur_address" value="" placeholder="Factuur Adress" name="factuur_address">
           </div>
           <div class="form-group">
               <label for="">Additional information</label>
               <i class="fas fa-text"></i>
               <textarea class="form-control" id="" value="" placeholder="Notes about your order ..." name="additional_info">
                </textarea>
           </div>

           <!-- <div class="form-group">
               <div class="checkSubs">
                   <div class="form-check">
                       <input class="form-check-input credit-card" type="radio" name="payement" id="method_payment" value="credit_card" >
                       <label class="form-check-label" for="creditcard">
                           Credit card
                       </label>
                   </div>
                   <div class="form-check">
                       <input class="form-check-input" type="radio" name="payement" id="method_payment" value="invoice" checked>
                       <label class="form-check-label" for="invoice">
                           Invoice
                       </label>
                   </div>
               </div>
           </div> -->

           <div class="modal-footer">
               <button type="button" id="starter" class="btn btn-sendSubscrip" data-toggle="modal" data-target="#modalPayment">Start</button>
               <div hidden="true" id="loader" class="spinner-border spinner-border-sm text-primary" role="status"></div>
           </div>
           <!-- </form> -->
        </div>

        <br><br>
        <div class="contentFormSubscription">
            <div id='stripe-checkout-first'>
                <h2> Hit on save once you ready !</h2>
                <center><small>Checkout will insert the payment form here ... </small></center>
            </div>
            <div id='stripe-checkout-second'>
                <div id='checkout'>
                </div>
            </div>
        </div>

   </div>
</div>

<div class="modal fade" id="modalPayment" tabindex="-1" role="dialog" aria-labelledby="modalPaymentLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPaymentLabel">Payement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="contentFormSubscription">
                    <div id='stripe-checkout-first'>
                        <h2> Hit on save once you ready !</h2>
                        <center><small>Checkout will insert the payment form here ... </small></center>
                    </div>
                    <div id='stripe-checkout-second'>
                        <h2> Pay here !</h2>
                        <div id='checkout'>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!--<script>
    var button = document.getElementById('starter');
    document.getElementById('stripe-checkout-second').style.display ='none';

    button.addEventListener('click', function(e) {
        $(e.preventDefault());
        document.getElementById('stripe-checkout-first').style.display ='none';
        document.getElementById('stripe-checkout-second').style.display ='block';
        // $('#stripe-checkout').html("<div id='checkout'><h2> Pay here !</h2></div>");
    });
</script>-->


<?php get_footer(); ?>
