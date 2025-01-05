<?php

$current_user = wp_get_current_user();

if(!in_array('administrator', $current_user->roles) && !in_array('hr', $current_user->roles)) 
    header('Location: /dashboard/company/');

/** Mollie API client for php **/
// $mollie = new \Mollie\Api\MollieApiClient();
// $mollie->setApiKey($global_mollie_key);

$company = get_field('company', 'user_' . $current_user->ID);
if(!empty($company) ){
    $company = $company[0];
    $company_connected = $company->post_title;
}

$telnr = get_field('telnr', 'user_' . $current_user->ID);

//Team members
$users = get_users();
$members = array();
foreach($users as $user){
    $company_value = get_field('company',  'user_' . $user->ID);
    if(!empty($company_value)){
        $company_value_title = $company_value[0]->post_title;
        if($company_value_title == $company_connected)
            array_push($members, $user);
    }
}
$team = count($members);

if ( !in_array( 'administrator', $current_user->roles ) && !in_array( 'hr', $current_user->roles ) ) 
    header('Location: /dashboard/user');              
?>

<?php
if (!$access_granted || empty($abonnement)){
?>
<div class="contentProfil ">

    <h1 class="titleSubscription">Abonnement</h1>
    <center><?php if(isset($_GET['message'])) echo "<span class='alert alert-info'>" . $_GET['message'] . "</span><br><br>"?></center>
    <div class="contentFormSubscription">
       <h4> Team : <?= $team . ' X ' . '5' ?> = <?= $team * 5 ?>.00 € </h4><br>
        <div id="required">
        
        </div>
        <!-- <form action="" method="POST"> -->
            <input type="hidden" id="user_id" value="<?= $current_user->ID ?>" >

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="first_name">First name</label>
                    <i class="fas fa-user" aria-hidden="true"></i>
                    <input type="text" class="form-control" id="first_name" value="<?= $current_user->first_name ?>" aplaceholder="First name" name="first_name" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="last_name">Last name</label>
                    <i class="fas fa-users" aria-hidden="true"></i>
                    <input type="text" class="form-control" id="last_name" value="<?= $current_user->last_name ?>" placeholder="Last name" name="last_name" required>
                </div>
            </div>
            <div class="form-group">
                <label for="bedrjifsnaam">Company Name</label>
                <i class="fas fa-building" aria-hidden="true"></i>
                <input type="text" class="form-control" id="bedrjifsnaam" value="<?= $company_connected ?>" placeholder="Bedrjifsnaam" name="bedrjifsnaam" required>
            </div>
            <div class="form-group">
                <label for="city">Company place</label>
                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                <input type="text" class="form-control" id="city" value="" placeholder="City" name="city">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                    <input type="email" class="form-control" id="email" value="<?= $current_user->user_email ?>" placeholder="Email" name="email" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="phone">Phone number</label>
                    <i class="fas fa-phone" aria-hidden="true"></i>
                    <input type="number" class="form-control" id="phone" value="<?= $telnr ?>" placeholder="Phone number" name="phone" required>
                </div>
            </div>
            <div class="form-group">
                <label for="actuur_address">Factuur Adress</label>
                <i class="fas fa-thumbtack"></i>
                <input type="text" class="form-control" id="factuur_address" value="" placeholder="Factuur Adress" name="factuur_address">
            </div>

            <div class="form-group">
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
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="is_trial" >
                    <label class="form-check-label" for="is_trial">
                        Trial (14 days)
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="starter" class="btn btn-sendSubscrip">Start</button>
                <div hidden="true" id="loader" class="spinner-border spinner-border-sm text-primary" role="status"></div>
            </div>
        <!-- </form> -->
        <div id="output">
    
        </div>
    </div>

</div>
<?php
}
else
    include_once('dashboard-company-confirmation.php');
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://js.mollie.com/v1/mollie.js"></script>

<script>

    function show1(){
        document.getElementById('payementCard').style.display ='none';
    }
    function show2(){
        document.getElementById('payementCard').style.display = 'block';
    }

    $(document).ready(function(){
        $("#is_trial").change(function() {
            if(this.checked) {
                $("#starter").text("Start Trial");
            } else {
                $("#starter").text("Start")
            }
        });
    });

</script>

<script>
    
    var button = document.getElementById('starter');
    button.addEventListener('click', function(e) {
        // alert("Intro");
        $(e.preventDefault());
        var pass = 0;

        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var bedrjifsnaam = $('#bedrjifsnaam').val();
        var city = $('#city').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var factuur_address = $('#factuur_address').val();
        var method_payment_state = document.getElementById('method_payment').checked;
        var is_trial_state = document.getElementById('is_trial').checked;
        var is_trial = 0;
        var method_payment = "invoice";

        if(method_payment_state)
            method_payment = "credit_card";

        if(is_trial_state)
            is_trial = 1;
        
        if( Boolean(first_name) && Boolean(last_name) && Boolean(bedrjifsnaam) && Boolean(email) && Boolean(phone) )
            pass = 1;

        if(pass == 1){
            $('#required').html("");

            $('#starter').hide();

            if(method_payment == 'credit_card'){
                $.ajax({
                    url:"/starter-card",
                    method:"post",
                    data:{
                        first_name : first_name,
                        last_name : last_name,
                        bedrjifsnaam : bedrjifsnaam,
                        city : city,
                        email : email,
                        phone : phone,
                        factuur_address : factuur_address,
                        is_trial : is_trial,
                        method_payment : method_payment,
                    },
                    dataType:"text",
                    beforeSend:function(){
                        $('#loader').attr('hidden',false)
                    },
                    success: function(data){
                        window.location.href = data;
                        //$('#output').html(data);
                    },
                    error: function (jqXHR, exception) {
                        if (jqXHR.status == 500) {
                            $('#output').html("<center><br><a class='btn btn-success' style='background : #E10F51; color : white' href='#'>Internal error, please try later !</a></center>");
                        } else {
                            $('#output').html("<center><br><a class='btn btn-success' style='background : #E10F51; color : white' href='#'>Something went wrong, please try later !</a></center>");
                        }                    
                    }
                });
            }
            else{
                $.ajax({
                    url:"/starter-sample",
                    method:"post",
                    data:{
                        first_name : first_name,
                        last_name : last_name,
                        bedrjifsnaam : bedrjifsnaam,
                        city : city,
                        email : email,
                        phone : phone,
                        factuur_address : factuur_address,
                        is_trial : is_trial,
                        method_payment : method_payment,
                    },
                    dataType:"text",
                    beforeSend:function(){
                        $('#loader').attr('hidden',false)
                    },
                    success: function(data){
                        // console.log(data);
                        location.reload();
                    },
                    error: function (jqXHR, exception) {
                        if (jqXHR.status == 500) {
                            $('#output').html("<center><br><a class='btn btn-success' style='background : #E10F51; color : white' href='#'>Internal error, please try later !</a></center>");
                        } else {
                            $('#output').html("<center><br><a class='btn btn-success' style='background : #E10F51; color : white' href='#'>Something went wrong, please try later !</a></center>");
                        }
                    }
                });
            }
        }
        else
            $('#required').html("<b><small style='color: #E10F51'>*Please fill all fields correctly</small><b><br>");
    });

</script>
