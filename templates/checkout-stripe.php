<?php /** Template Name: Checkout Stripe */ ?>

<?php get_header(); ?>

<?php
require_once 'new-module-subscribe.php';

//Price ID
$price_id = '';
$mode = 'setup';
$postID = '';
$userID = '';
$prijs = 0;

extract($_POST);

//create product/price 
if(isset($productPrice)):
    // get course
    $post = get_post($postID);
    $course_type = get_field('course_type', $postID);

    // get user 
    $userID = get_current_user_id();

    // create product
    $short_description = get_field('short_description', $post->ID) ?: 'Your adventure begins with Livelearn !';
    $prijs = get_field('price', $post->ID) ?: 0; 
    $permalink = get_permalink($postID); 
    $thumbnail = "";
    if(!$thumbnail):
        $thumbnail = get_field('url_image_xml', $post->ID);
        if(!$thumbnail)
            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
    endif;

    if($prijs):
        // create price 
        $currency = 'eur';
        $data_price = [
            'currency' => $currency,
            'amount' => $prijs,
            'product_name' => $post->post_title,
            'product_description' => $short_description,
            'statement_descriptor' => 'LIVELEARN PAY !',
            'product_image' => $thumbnail,
            'product_url' => $permalink,
            'ID' => $post->ID,
        ];
        $price_id = create_price($data_price);
        $mode = ($prijs) ? 'payment' : 'setup';
    endif;

endif;
//create ...

?>
<head>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<script src="https://js.stripe.com/v3/"></script>
<script defer>
    // This is your test secret API key.
    const stripePublicKey = "<?php echo $stripePublicKey ?>"
    const stripe = Stripe(stripePublicKey);

    initialize();

    // Create a Checkout Session
    async function initialize() {
    const fetchClientSecret = async () => {
        const priceID = "<?php echo $price_id ?>";
        const mode = "<?php echo $mode ?>";
        const postID = "<?php echo $postID ?>";
        const userID = "<?php echo $userID ?>";
        const response = await fetch("/checkout-module/?priceID=" + priceID + "&mode=" + mode + "&postID=" + postID +  "&userID=" + userID, {
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
       <!-- <h1 class="titleSubscription">Sample</h1> -->
       <!-- <center><?php if(isset($_GET['message'])) echo "<span class='alert alert-info'>" . $_GET['message'] . "</span><br><br>"?></center> -->

        <!--
        <div class="contentFormSubscription"> -->

           <!-- <div class="form-row">
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
           </div> -->

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

           <!-- <div class="modal-footer">
               <button type="button" id="starter" class="btn btn-sendSubscrip" data-toggle="modal" data-target="#modalPayment">Start</button>
               <div hidden="true" id="loader" class="spinner-border spinner-border-sm text-primary" role="status"></div>
           </div> -->
           <!-- </form> 
        </div> 
        -->

        <!-- <br><br> -->
        <div class="contentFormSubscription">
            <!-- <div id='stripe-checkout-first'>
                <h2> Hit on save once you ready !</h2>
                <center><small>Checkout will insert the payment form here ... </small></center>
            </div> -->
            <?php
            if($prijs):
            ?>
            <div id='stripe-checkout'>
                <div id='checkout'>
                </div>
            </div>
            <?php
            else:
                // Form free course 
                /** Instructions here */
            ?>
                <h3>Register information :</h3>
                <form method="POST" action="/checkout-module">
                    <input type="hidden" name="postID" value="<?= $postID ?>" class="" id="" placeholder="">
                    <input type="hidden" name="authID" value="<?= $userID ?>" class="" id="" placeholder="">

                    <div class="form-group">
                        <label for="additional_name">Full name</label>
                        <input type="text" name="additional_name" class="form-control" id="additional_name" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="additional_email">Email address</label>
                        <input type="email" name="additional_email" class="form-control" id="additional_email" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="additional_company">Company</label>
                        <input type="text" name="additional_company" class="form-control" id="additional_company" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="additional_phone">Phone</label>
                        <input type="number" name="additional_phone" class="form-control" id="additional_phone" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="additional_adress">Adress</label>
                        <input type="text" name="additional_adress" class="form-control" id="additional_adress" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="additional_information">Additionnal Information</label>
                        <textarea name="additional_information" rows="8" id="additional_information"></textarea>
                    </div>
                    <button type="submit" name="order_free" class="btn btn-primary">Save</button>
                </form>
            <?php
            endif;
            ?>
        </div>
   </div>
</div>

<!-- <div class="modal fade" id="modalPayment" tabindex="-1" role="dialog" aria-labelledby="modalPaymentLabel" aria-hidden="true">
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
</div> -->

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
    var button = document.getElementById('starter');
    // document.getElementById('stripe-checkout-second').style.display ='none';

    button.addEventListener('click', function(e) {
        $(e.preventDefault());
        document.getElementById('stripe-checkout-first').style.display ='none';
        document.getElementById('stripe-checkout-second').style.display ='block';
    });
</script>


<?php get_footer(); ?>
