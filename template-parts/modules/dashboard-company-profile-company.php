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
$team = count($members)
?>

<div class="contentProfil ">

    <h1 class="titleSubscription">Abonnement</h1>
    <center><?php if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>"?></center>
    <div class="contentFormSubscription">
       <h4> Team : <?= $team . ' X ' . '5' ?> = <?= $team * 5 ?>.00 € </h4><br>
        <div id="required">
        
        </div>
        <!-- <form action="" method="POST"> -->
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
                        <input class="form-check-input credit-card" type="radio" name="payement" id="method_payment" value="credit_card" onclick="show2();" checked>
                        <label class="form-check-label" for="creditcard">
                            Credit card
                        </label>
                    </div>
                    <!-- <div class="form-check">
                        <input class="form-check-input" type="radio" name="payement" id="method_payment" value="invoice" onclick="show1();" >
                        <label class="form-check-label" for="invoice">
                            Invoice
                        </label>
                    </div> -->
                </div>
                <div id="payementCard">
                    <form id="payment_card">
                        <div id="card"></div>
                    <form>
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
                <button type="button" name="starter" id="starter" class="btn btn-sendSubscrip">Start</button>
            </div>
        <!-- </form> -->
        <div id="output">
    
        </div>
    </div>

</div>
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
    
    var profile_id = "pfl_8SUjU2jSrq";

    var mollie = Mollie( profile_id, { locale: 'nl_NL', testmode: false });
    var options = {
        styles : {
            base: {
                backgroundColor: '#eee',
                color: 'black',
                fontSize: '10px',
                '::placeholder' : {
                    color: 'rgba(68, 68, 68, 0.2)',
                }
            },
            valid: {
                color: '#033256',
            },
            invalid: {
                color: '#E11654',
            }
        }
    };
    var cardComponent = mollie.createComponent('card', options);
    cardComponent.mount('#card');
    var form = document.getElementById('payment_card');
    var button = document.getElementById('starter');
    button.addEventListener('click', async e => {
        $(e.preventDefault());
        var pass = 0;

        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var bedrjifsnaam = $('#bedrjifsnaam').val();
        var city = $('#city').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var factuur_address = $('#factuur_address').val();
        var method_payment = $('#method_payment').val();
        var is_trial_state = document.getElementById('is_trial').checked;
        var is_trial = 0;

        if(is_trial_state)
            is_trial = 1;
        
        if(Boolean(first_name) && Boolean(last_name) && Boolean(bedrjifsnaam) && Boolean(email) && Boolean(phone) )
            pass = 1;

        if(pass == 1){
            $('#required').html("");

            $('#starter').hide();

            var { token, error } = await mollie.createToken();

            if (error) {
                token = 0;
                console.log(error);
                // Something wrong happened while creating the token. Handle this situation gracefully.
                return error;
                $('#required').html("<b><small style='color: #E10F51'>Something went wrong !</small><b><br>");
            }
            else
                var token = 0;
        
            $.ajax({

                url:"/starter-abonnement",
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
                    card_token : token
                },
                dataType:"text",
                success: function(data){
                    console.log(data);
                    $('#output').html(data);
                }
            });
        }
        else
            $('#required').html("<b><small style='color: #E10F51'>*Please fill all fields correctly</small><b><br>");
    });

</script>


