<?php /** Template Name: cards payment */ ?>

<?php
extract($_POST);

$form = '
    <form action="/credit-card-details" method="POST">
        <input type="hidden" value="' . $first_name . '" name="first_name" >
        <input type="hidden" value="' . $last_name . '" name="last_name" >
        <input type="hidden" value="' . $bedrjifsnaam . '" name="bedrjifsnaam" >
        <input type="hidden" value="' . $city . '" name="city" >
        <input type="hidden" value="' . $email . '" name="email" >
        <input type="hidden" value="' . $phone . '" name="phone" >
        <input type="hidden" value="' . $factuur_address . '" name="factuur_address" >
        <input type="hidden" value="' . $is_trial . '" name="is_trial" >
        <center><br><button type="submit" class="btn btn-sendSubscrip" >Voer de creditcardgegevens in </button></center>
    </form>
';

echo $form;