<?php /** Template Name: cards credit details payment */ ?>
<?php wp_head(); ?>
<?php get_header(); ?>
<?php extract($_POST); ?>
<div class="content-cards-credit-details">

    <center><?php if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>"?></center>
    <div class="contentFormSubscription">
        <h4 class="titleSubscription"> Credit card </h4>

        <div id="required">
        </div>

        <div>
            <input type="hidden" value="<?= $first_name ?>" name="first_name" id="first_name">
        </div>
        <div>
            <input type="hidden" value="<?= $last_name ?>" name="last_name" id="last_name">
        </div>
        <div>
            <input type="hidden" value="<?= $bedrjifsnaam ?>" name="bedrjifsnaam" id="bedrjifsnaam">
        </div>
        <div>
            <input type="hidden" value="<?= $city ?>" name="city" id="city">
        </div>
        <div>
            <input type="hidden" value="<?= $email ?>" name="email" id="email">
        </div>
        <div>
            <input type="hidden" value="<?= $phone ?>" name="phone" id="phone">
        </div>
        <div>
            <input type="hidden" value="<?= $factuur_address ?>" name="factuur_address" id="factuur_address">
        </div>
        <form id="payment_card">
            <div id="card"></div>
        <form>
        <div class="modal-footer">
            <button type="button" name="starter" id="starter" class="btn btn-sendSubscrip">Start</button>
        </div>

        <div id="output">
    
        </div>
    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://js.mollie.com/v1/mollie.js"></script>

<script> 
    var profile_id = "pfl_8SUjU2jSrq";

    var mollie = Mollie( profile_id, { locale: 'nl_NL', testmode: true });
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
                color: '#45B0A1',
            },
            invalid: {
                color: '#023356',
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
        var is_trial = $('#is_trial').val();

        if( Boolean(first_name) && Boolean(last_name) && Boolean(bedrjifsnaam) && Boolean(email) && Boolean(phone) )
            pass = 1;
        
        $('#starter').hide();

        // if(pass == 1){
        //     $('#required').html("");
        // }
        // else{
        //     $('#required').html("<b><small style='color: #E10F51'>Something went wrong !</small><b><br><br>");
        //     return 0;
        // }

        var { token, error } = await mollie.createToken();

        if (error) {
            token = 0;
            console.log(error);
            // Something wrong happened while creating the token. Handle this situation gracefully.
            $('#required').html("<b><small style='color: #E10F51'>Something went wrong !</small><b><br>");
            // return error;
        }

        $.ajax({
            
            url:"/starter",
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
                method_payment : "credit_card",
                card_token : token
            },
            dataType:"text",
            success: function(data){
                console.log(data);
                $('#output').html(data);
            }
        });
      
    });

</script>

<?php get_footer(); ?>
<?php wp_footer(); ?>
