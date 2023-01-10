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

    <h1 class="titleSubscription">Abonnement</h1>
    <center><?php if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>"?></center>
    <div class="contentFormSubscription">
        <div id="required">
        
        </div>
        <form action="" method="POST">
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
                <!-- <div class="checkSubs">
                    <div class="form-check">
                        <input class="form-check-input credit-card" type="radio" name="payement" id="creditcard" onclick="show2();">
                        <label class="form-check-label" for="creditcard">
                            Credit card
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payement" id="invoice" onclick="show1();" checked>
                        <label class="form-check-label" for="invoice">
                            Invoice
                        </label>
                    </div>
                </div> -->
                <div class="creditCardBlock" id="payementCard">
                    <div class="payment_box">
                        <div class="form-group">
                            <label for="Card-number ">Card number <span>*</span></label>
                            <input type="text" class="form-control" id="Card-number" placeholder="1234 1234 1234 1234" name="Card-number">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="expiration-date">Expiration date <span>*</span></label>
                                <input type="date" class="form-control" id="email" placeholder="MM / AA" name="expiration-date">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Visual-cryptogram">Visual cryptogram <span>*</span></label>
                                <input type="number" class="form-control" id="Visual-cryptogram" placeholder="CVC" name="Visual-cryptogram">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" value="Essayer" type="checkbox" id="is_trial">
                    <label class="form-check-label" for="is_trial">
                        Trial (14 days)
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="starter" id="starter" class="btn btn-sendSubscrip">Start</button>
            </div>
        </form>
        <div id="output">
    
        </div>
    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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

    $("#starter").click((e)=>{
        $(e.preventDefault());

        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var bedrjifsnaam = $('#bedrjifsnaam').val();
        var city = $('#city').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var factuur_address = $('#factuur_address').val();

        var pass = 0;

        if(first_name && last_name && bedrjifsnaam && email && phone )
            pass = 1;

        if(pass == 1){
            $('#required').html("");

            $('#starter').hide();

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
                    factuur_address : factuur_address
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


