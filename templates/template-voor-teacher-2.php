<?php /** Template Name: Voor teacher2 */ ?>
<?php
global $wp;

$url = home_url( $wp->request );
if (isset($_POST) && !empty($_POST)){
    $userdata = array(
        'user_pass' => $_POST['password'],
        'user_login' => $_POST['username'],
        'user_email' => $_POST['email'],
        'user_url' => 'http://livelearn.nl/',
        'display_name' => $_POST['firstName'] . ' ' . $_POST['lastName'],
        'first_name' => $_POST['firstName'],
        'last_name' => $_POST['lastName'],
        'role' => 'Manager',
    );
    $user_id = wp_insert_user($userdata);
    if (is_wp_error($user_id)) {
        header("Location: $url?message=<div class='alert alert-danger'>$user_id->get_error_message() </div>");
    } else {
        //update phone number
        if ($_POST['phone'])
            update_field('telnr', $_POST['phone'], 'user_' . $user_id);

        //create a new company the new user
        $company_id = wp_insert_post(
            array(
                'post_title' => $_POST['company'],
                'post_type' => 'company',
                'post_status' => 'pending',
            ));
        $company = get_post($company_id);
        update_field('company', $company, 'user_' . $user_id);
        header("Location: ".$url."?message=<div class='alert alert-success text-center'>user saved success</div>");

        /*
        //connect the new user with the new company
        $creds = array();
        $creds['user_login'] = $_POST['username'];
        $creds['user_password'] = $_POST['password'];
        $creds['remember'] = true;
        $user = wp_signon( $creds, false );
        if ( is_wp_error($user) )
            header("Location: $url?message=<div class='alert alert-danger'>$user->get_error_message()</div>");
        else
            header('Location'.$url);
        */
    }
}
?>
<?php wp_head(); ?>
<meta name="description" content="Fluidify">
<meta name='keywords' content="fluidify">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta property="og:image" content="<?php echo get_stylesheet_directory_uri() . '/img/logo_livelearn.png' ?>">

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/custom.css" />
<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>


<div class="content-voor-2 content-voor-teacher-2">
    <div class="block-logo">
        <a href="/">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/livelearn-logo-blanc.png" class="" alt="">
        </a>
    </div>
    <section class="firstSection">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="content-detail-voor-organisation">
                        <h1>Word onderdeel van het grootste expert & opleidersnetwerk</h1>
                        <p>Via LiveLearn deel je eenvoudig je kennis met de rest van de wereld. Zo bereik je nieuwe klanten en positioneer je je als de absolute expert in het vakgebied.</p>
                        <a href="/overview-organisations-5/" class="btn btnMeerInformation">Meer informatie ?</a>
                    </div>
                    <div class="img-block">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Informatiesessie-LiveLearn.png" class="" alt="">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="blockForm2">
                        <p><b>Aanmelden expert of opleider</b></p>
                        <?php
                        if (isset($_GET['message']))
                            echo $_GET['message'];
                           //echo do_shortcode("[gravityform id='17' title='false' description='false' ajax='true']");
                        ?>
                        <div class="form-input new-form-input">
                            <form action="/" method="POST" id="new-form-register-workflow">

                                <div class="first-step-modal">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter your email address" required autofocus>
                                    </div>
                                    <button type="button" class="btn btn-connection" id="create-account-step">Create Account</button>
                                </div>

                                <div class="second-step-modal">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="First-name">First name</label>
                                        <input type="text" class="form-control" id="First-name" name="firstName" placeholder="Enter your First name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="last-name">Last name</label>
                                        <input type="text" class="form-control" id="last-name" name="lastName" placeholder="Enter your last name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="company">Company</label>
                                        <input type="text" class="form-control" id="company" name="company" placeholder="Enter your Company name">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone-number">phone number</label>
                                        <input type="text" class="form-control" id="phone-number" name="phone" placeholder="Enter your phone-number">
                                    </div>
                                    <div class="form-group">
                                        <label for="Password-workflow">Password</label>
                                        <input type="password" class="form-control" id="Password-workflow" name="password" placeholder="Enter your Password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Password2-workflow">Password</label>
                                        <input type="password" class="form-control" id="Password2-workflow" name="password2" placeholder="Confirm your Password" required>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button class="btn btn-switch-email d-none mb-2" type="button">Return on Email</button>
                                        <button type="submit" class="btn btn-connection" id="">Create Acccount</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center block-hr-strat">
                <hr>
                <div class="block-start d-flex align-items-center justify-content-center">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Group_301.png" class="" alt="">
                    <p class="mb-0">(8,1)</p>
                </div>
                <hr>
            </div>
            <h2 class="title-zij">Zij gebruiken al LiveLearn</h2>
            <div class="block-logo-parteners2">
                <div class="logo-element">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/voor-partenar-1.png" alt="">
                </div>
                <div class="logo-element">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/voor-partenar-2.png" alt="">
                </div>
                <div class="logo-element">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/voor-partenar-3.png" alt="">
                </div>
                <div class="logo-element">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/voor-partenar-4.png" alt="">
                </div>
                <div class="logo-element img2">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/voor-partenar-5.png" alt="">
                </div>
                <div class="logo-element img2">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/voor-partenar-6.png" alt="">
                </div>
                <div class="logo-element img2">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/voor-partenar-7.png" alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="block-contact-teams">
        <div class="container-fluid">
            <h3>Direct iemand spreken van ons team?</h3>
            <button onclick="Calendly.initPopupWidget({url: 'https://calendly.com/livelearn/overleg-pilot'});return false;" class="btn btn-plan">Plan een afspraak</button>
        </div>
    </section>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        $("#create-account-step").click(function() {
            $(".btn-switch-email").removeClass('d-none');
            $(".first-step-modal").hide();
            $(".second-step-modal").show();
        });
        $(".btn-switch-login").click(function() {
            $(".register-block").hide();
            $(".create-account-block").show();
        });
        $(".btn-switch-email").click(function() {
            $(".btn-switch-email").addClass('d-none');
            $(".second-step-modal").hide();
            $(".first-step-modal").show();
        });
        $(".btn-Sign-Up").click(function() {
            $(".register-block").show();
            $(".create-account-block").hide();
        });
    </script>
    <script>
        $("#new-form-register-workflow").submit((e)=>{
            //e.preventDefault();
            const formData = new FormData(e.currentTarget);
            password = formData.get('password')
            password2 = formData.get('password2')
            if (password !== password2){
                e.preventDefault();
                alert('passwords not matched')
                //$('#alert-danger-register').removeClass('d-none')
                //$('#Password-workflow').addClass('btn-danger')
                //$('#Password2-workflow').addClass('btn-danger')
            }
        })
    </script>
<?php get_footer(); ?>
<?php wp_footer(); ?>