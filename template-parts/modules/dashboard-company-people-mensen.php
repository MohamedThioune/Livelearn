<?php 


  $user = get_users(array('include'=> get_current_user_id()))[0]->data;
  $image = get_field('profile_img',  'user_' . $user->ID);
  $company = get_field('company',  'user_' . $user->ID);

    extract($_POST);

    if(isset($single_add_people)){
       
        if($email != null)
        {
            if($first_name == null)
                $first_name = "ANONYM";
            
            if($last_name == null)
                $last_name = "ANONYM";
     

            $login = RandomString();
            $password = RandomString();

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
                ?>
                 <script>
                    window.location.replace("/dashboard/company/people-mensen/?message=Er is een fout opgetreden, probeer het opnieuw.");
                </script>
                <?php
                echo ("<span class='alert alert-info'>" .  $danger . "</span>");   
            }else
                {
                    update_field('degree_user', $choiceDegrees, 'user_' . $user_id);
                    $subject = 'Je LiveLearn inschrijving is binnen! ✨';
                    $body = "
                    Bedankt voor je inschrijving<br>
                    <h1>Hello " . $first_name  . "</h1>,<br> 
                    Je hebt je succesvol geregistreerd. Welcome onboard! Je LOGIN-ID is <b style='color:blue'>" . $login . "</b>  en je wachtwoord <b>".$password."</b><br><br>
                    <h4>Inloggen:</h4><br>
                    <h6><a href='https://livelearn.nl/inloggen/'> Connexion </a></h6>
                    ";
                
                    $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
                    wp_mail($email, $subject, $body, $headers, array( '' )) ; 
        
                    update_field('company', $company[0], 'user_'.$user_id);
                ?>
                 <script>
                    window.location.replace("/dashboard/company/people/?message=U heeft met succes een nieuwe werknemer aangemaakt ✔️ ");
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
    else if(isset($multiple_add_people)){ 
        if(!empty($emails)){
            foreach($emails as $email){
                if($email != null)
                {
                    $login = RandomString();
                    $password = RandomString();
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
                        continue;
                    }else{

                        update_field('degree_user', $choiceDegrees, 'user_' . $user_id);
                        update_field('company', $company[0], 'user_'.$user_id);

                        $subject = 'Je LiveLearn inschrijving is binnen! ✨';
                        $body = "
                            Bedankt voor je inschrijving<br>
                            <h1>Hello and welcome to livelearn</h1>,<br> 
                            Je hebt je succesvol geregistreerd. Welcome onboard! Je LOGIN-ID is <b style='color:blue'>" . $login . "</b>  en je wachtwoord <b>".$password."</b><br><br>
                            <h4>Inloggen:</h4><br>
                            <h6><a href='https://livelearn.nl/inloggen/'> Connexion </a></h6>
                        ";
                    
                        $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
                        wp_mail($email, $subject, $body, $headers, array( '' )) ;
                    }
                }
            }
            ?>
            <script>
                window.location.replace("/dashboard/company/people/?message=U heeft met succes een nieuwe werknemer aangemaakt ✔️ ");
            </script>
        <?php
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
    <br><br>
    <div class="contentOverviewMensen">
        <div class="blockOverviewMensen">
            <h2 class="titleBlockOverviewMensen">Toevoegen</h2>
            <form action="/dashboard/company/people-mensen/" method="POST">
                    <div class="bodyBlockOverviewMensen">
                        <ul>
                            <li> <input type="text" name="first_name" placeholder="Voornaam" required>       </li>
                            <li> <input type="text" name="last_name" placeholder="Achternaam" required>      </li>
                            <li> <input type="email" name="email" placeholder="ZaKelijk mailadres" required> </li>
                        </ul>
                        <br><br>
                        <button type="submit" name="single_add_people" class="btn btnMensenToevoegen">Werknemer toevoegen</button>
                    </div>
            </form>
        </div>
        <div class="blockOverviewMensen">
            <h2 class="titleBlockOverviewMensen">Groep Toevoegen </h2>
            <form action="/dashboard/company/people-mensen/" method="POST">
                <div class="bodyBlockOverviewMensen">
                    <ul>
                        <li><input type="email" name="emails[]" placeholder="ZaKelijk mailadres"></li>
                        <li><input type="email" name="emails[]" placeholder="ZaKelijk mailadres"></li>
                        <li><input type="email" name="emails[]" placeholder="ZaKelijk mailadres"></li>
                        <li><a href="#"><b>+meer</b></a></li>
                    </ul>
                    <br><br>
                    <button type="submit" name="multiple_add_people" class="btn btnMensenToevoegen">Werknemer toevoegen</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $('#chooseFileLijs').bind('change', function () {
        var filename = $("#chooseFileLijs").val();
        if (/^\s*$/.test(filename)) {
            $(".file-upload").removeClass('active');
            $("#noFileLijs").text("No file chosen...");
        }
        else {
            $(".file-upload").addClass('active');
            $("#noFileLijs").text(filename.replace("C:\\fakepath\\", ""));
        }
    });

</script>




