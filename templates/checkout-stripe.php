<?php /** Template Name: Checkout Stripe */ ?>

<?php get_header(); ?>

<?php
require_once 'new-module-subscribe.php';

//Price ID
$price_id = '';
$mode = 'setup';
$postID = '';
// get user
$userID = get_current_user_id();
$prijs = 0;


extract($_POST);
if($_POST['stripe_register']):
endif;

//After Login/Register
if(isset($_GET['single'])):
    $post = get_post($_GET['single']);
    $message = (isset($_GET['message'])) ? $_GET['message'] . $register_instruction : $register_instruction;
    if($post):
        $postID = $_GET['single'];
        $productPrice = 1;
        if($_GET['after'])
            $userID = 'null';
    endif;
endif;

//create product/price
if(isset($productPrice)):
    // get course
    $post = get_post($postID);
    $course_type = get_field('course_type', $postID);

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
        $price_id = (search_price($data_price['ID'])) ?: create_price($data_price);

        $mode = ($prijs) ? 'payment' : 'setup';
    endif;

    // $free_form = null;
endif;
//create ...

//Form login
$success = "Login successful !";
$redirect_success = "/checkout-stripe?message=" . $success . "&single=" . $postID;
$login_form = (!$userID) ? wp_login_form([
    'redirect' => $redirect_success,
    'remember' => false,
    'label_username' => 'What is your email address ?',
    'placeholder_email' => 'E-mail address',
    'label_password' => 'What is your password ?'
]) : "";

//Form register
$redirect_register = "?single=" . $postID ."&after=1";
$login_form .= "<span>I don't have a account, <a href='" . $redirect_register . "'>create one !</a> </span>";
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

<body>
<div class="contentProfil">
    <div class="container-fluid">
        <!-- <h1 class="titleSubscription">Sample</h1> -->
        <center><?php if(isset($_GET['message'])) echo "<span class='alert alert-info'>" . $_GET['message'] . "</span><br><br>"?></center>
        <!-- <br><br> -->
        <div class="contentFormSubscription">
            <?php
            //User connected or not
            if($userID):
                //Prijs or free
                if($prijs):
                    echo "
                        <div id='stripe-checkout'>
                            <div id='checkout'>
                            </div>
                        </div>";
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
            else:
                echo $login_form;
            endif;
            ?>
        </div>
    </div>
</div>

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
