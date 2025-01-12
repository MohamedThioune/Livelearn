<?php 
extract($_POST);
if($_POST)
    if (!isset($multiple_add_people) && !isset($single_add_people)) {
        $response = "";
        foreach ($_POST as $json => $value) {
            $decoded = json_decode($json, true);
            $first_name = str_replace('_',' ',$decoded['first_name']);
            $last_name = str_replace('_',' ',$decoded['last_name']);
            $email = str_replace('_','.',$decoded['email']);

            $login = RandomString();
            $password = "Livelearn2023";
            $userdata = array(
                'user_pass' => $password,
                'user_login' => $login,
                'user_email' => $email,
                'user_url' => 'https://livelearn.nl/inloggen/',
                'display_name' => $first_name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'role' => 'subscriber'
            );
            $user_id = wp_insert_user(wp_slash($userdata));
            if(is_wp_error($user_id)){
                $response ="<span class='alert alert-danger'>". $user_id->get_error_message()."</span>";
            }
            else{
                    $guest = wp_get_current_user();
                    $company = get_field('company',  'user_' . $guest->ID);
                    update_field('degree_user', $choiceDegrees, 'user_' . $user_id);
                    update_field('company', $company[0], 'user_'.$user_id);
                    $subject = 'Je LiveLearn inschrijving is binnen! ✨';
                    $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
                    wp_mail($email, $subject, $mail_invitation_body, $headers, array( '' )) ; 
                    $response = "<span class='alert alert-success'>U heeft met succes een nieuwe werknemer aangemaakt ✔️</span>";
                }
        }
        echo $response;
        return 1;
    }

$user = get_users(array('include'=> get_current_user_id()))[0]->data;
$image = get_field('profile_img',  'user_' . $user->ID);
$company = get_field('company',  'user_' . $user->ID);

$mail_notification_invitation = '/../../templates/mail-notification-invitation.php';
require(__DIR__ . $mail_notification_invitation); 

if(isset($single_add_people))
    if($email != null){
        if($first_name == null)
            $first_name = "ANONYM";
        
        if($last_name == null)
            $last_name = "ANONYM";
    

        $login = RandomString();
        $password = "Livelearn2023";

        $userdata = array(
            'user_pass' => $password,
            'user_login' => $login,
            'user_email' => $email,
            'user_url' => 'https://livelearn.nl/inloggen/',
            'display_name' => $first_name,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role' => 'subscriber'
        );
        $user_id = wp_insert_user(wp_slash($userdata));
        if(is_wp_error($user_id)){
            $danger = $user_id->get_error_message();
            header("Location: /dashboard/company/people/?message=Er is een fout opgetreden, probeer het opnieuw.");
            echo ("<span class='alert alert-info'>" .  $danger . "</span>");   
        }
        else
            {
                $guest = wp_get_current_user();
                $company = get_field('company',  'user_' . $guest->ID);
                update_field('degree_user', $choiceDegrees, 'user_' . $user_id);
                update_field('company', $company[0], 'user_'.$user_id);

                $subject = 'Je LiveLearn inschrijving is binnen! ✨';
                $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
                wp_mail($email, $subject, $mail_invitation_body, $headers, array( '' )) ; 

                header("Location: /dashboard/company/people/?message=U heeft met succes een nieuwe werknemer aangemaakt ✔️ ");
            }
    }
    else
        header("Location: /dashboard/company/people-mensen/?message=Vul de e-mail in, alsjeblieft");
else if(isset($multiple_add_people)){
    $indicator = "Al uw gebruikers zijn succesvol toegevoegd"; 
    if(!empty($emails)){
        foreach($emails as $email){
            if($email != null)
            {
                $login = RandomString();
                $password = RandomString();
                $your_password = $password;
                $first_name = RandomString();
                $last_name = RandomString();
    
                $userdata = array(
                    'user_pass' => $password,
                    'user_login' => $login,
                    'user_email' => $email,
                    'user_url' => 'https://livelearn.nl/inloggen/',
                    'display_name' => $first_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'role' => 'subscriber'
                );
    
                $user_id = wp_insert_user(wp_slash($userdata));
                if(is_wp_error($user_id)){
                    $indicator = "Een fout bij het aanmaken van de e-mails, zorg ervoor dat alle e-mails niet al bestaan.";
                    $error = false;
                    continue;
                }
                else{
                    $guest = wp_get_current_user();
                    $company = get_field('company',  'user_' . $guest->ID);    
                    update_field('degree_user', $choiceDegrees, 'user_' . $user_id);
                    update_field('company', $company[0], 'user_'.$user_id);

                    $subject = 'Je LiveLearn inschrijving is binnen! ✨';
                    $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
                    wp_mail($email, $subject, $mail_invitation_body, $headers, array( '' )) ;
                }
            }
        }
        if(!isset($error)){
        ?>
        <script>
            window.location.replace("/dashboard/company/people/?message=<?php echo $indicator ?>");
        </script>
    <?php
        }
        else{
        ?>
        <script>
            window.location.replace("/dashboard/company/people-mensen/?message=<?php echo $indicator ?>");
        </script>
        <?php
        }
    }
    else
    {
        ?>
        <script>
            window.location.replace("/dashboard/company/people-mensen/?message=Vul de e-mail in, alsjeblieft");
        </script>
        <?php
    }
        
}
    
?>

<div class="contentPageManager managerOverviewMensen">
    <?php if($_GET['message']) echo "<span class='alert alert-info'>" . $_GET['message'] . "</span>" ?>
    <div class="contentOverviewMensen">
        <div class="blockOverviewMensen">
            <h2 class="titleBlockOverviewMensen">Toevoegen</h2>
            <form action="/dashboard/company/people-mensen/" method="POST">
                    <div class="bodyBlockOverviewMensen">
                        <ul>
                            <li> <input type="text" name="first_name" placeholder="Voornaam" required>       </li>
                            <li> <input type="text" name="last_name" placeholder="Achternaam" required>      </li>
                            <li> <input type="email" name="email" placeholder="Zakelijk mailadres" required> </li>
                        </ul>
                        <br><br>
                        <button type="submit" name="single_add_people" class="btn btnMensenToevoegen">Werknemer toevoegen</button>
                    </div>
            </form>
        </div>
        <div class="blockOverviewMensen">
            <h2 class="titleBlockOverviewMensen">Groep Toevoegen </h2>
            <form action="/dashboard/company/people-mensen/" method="POST">
                <div class="bodyBlockOverviewMensen" >
                    <ul>
                        <li><input type="email" name="emails[]" class="" placeholder="Zakelijk mailadres"></li>
                        <li><input type="email" name="emails[]" class="" placeholder="Zakelijk mailadres"></li>
                        <li id="item_details"><input name="emails[]" type="email"  id="item_name" class="input_text" placeholder="Zakelijk mailadres" /></li>
                    </ul>
                    <ul id="new_item_details" class="new_item_details"></ul>
                    <div class="groupBtnMesen">
                        <div class="contentInputRemoveItem" style="display:none;" id="removeitem">
                            <input type="button" name="remove_item" id="remove_item" value="-Verwijderen" class="cv-form-control button cv-submit">
                        </div>
                        <div >
                            <input type="button" name="add_item" id="add_item" value="+Meer" class="cv-form-control button cv-submit">
                        </div>
                    </div>

                    <button type="submit" name="multiple_add_people" class="btn btnMensenToevoegen">Werknemers toevoegen</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script>
    $('#chooseFileLijs').bind('change', function () {
        var filename = $("#chooseFileLijs").val();
        if (/^\s*$/.test(filename)) {
            $(".file-upload").removeClass('active');
            $("#noFileLijs").email-clone-mesen("No file chosen...");
        }
        else {
            $(".file-upload").addClass('active');
            $("#noFileLijs").email-clone-mesen(filename.replace("C:\\fakepath\\", ""));
        }
    });

</script>
<script>
    jQuery(function ($) {
        $('#add_item').click(function () {
            var button = $('#item_details').clone();
            button.find('input').val('');
            button.removeAttr('id');//ID of an element must be uniue
            $(".new_item_details").append(button);
            $('#removeitem').show();
        });
        $('#remove_item').click(function (e) {
            $("#new_item_details > li").last().remove();
            $('#removeitem').toggle( !$("#new_item_details").is(":empty") );
            e.preventDefault();
        });
    });

</script>



