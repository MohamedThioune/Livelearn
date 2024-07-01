<?php /** Template Name: expert ranking */ ?>

<?php get_header(); ?>

<?php
//Price ID
if(isset($_GET['priceID'])):
    $key_password = "C@##me1995.";
    $decrypted_chaine = openssl_decrypt($encrypted_chaine, "AES-128-ECB" ,
    $key_password);    
endif;
?>
<head>
<!-- <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" /> -->
<script src="https://js.stripe.com/v3/"></script>
<script defer>
    // This is your test secret API key.
    const stripe = Stripe("pk_test_51JyijWEuOtOzwPYXpQ5PQzJGMroshnARkLBNWWJK2ZOsGaaJvF0tmh96eVkAgklzjB8L3usvqvP3229HTXx796nt00qw0X8k7y");

    initialize();

    // Create a Checkout Session
    async function initialize() {
    const fetchClientSecret = async () => {
        const response = await fetch("/ecosystem", {
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

<body>
<div class="contentProfil">
    <h1 class="titleSubscription">Checkout Page</h1>
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

            <div class="modal-footer">
                <button type="button" id="starter" class="btn btn-sendSubscrip">Start</button>
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
            <h2> Pay here !</h2>
            <div id='checkout'>
            </div>
        </div>
    </div>
</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
    var button = document.getElementById('starter');
    document.getElementById('stripe-checkout-second').style.display ='none';

    button.addEventListener('click', function(e) {
        $(e.preventDefault());
        document.getElementById('stripe-checkout-first').style.display ='none';
        document.getElementById('stripe-checkout-second').style.display ='block';
        // $('#stripe-checkout').html("<div id='checkout'><h2> Pay here !</h2></div>");
    });
</script>

<?php get_footer(); ?>
