<?php 


  $user = get_users(array('include'=> get_current_user_id()))[0]->data;
  $image = get_field('profile_img',  'user_' . $user->ID);
  $company = get_field('company',  'user_' . $user->ID);

  function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $rand = $characters[rand(0, strlen($characters))];
            $randstring .= $rand;  
        }
        return $randstring;
    }

  if(!empty($company))
    $company_manager = $company[0]->post_title;

    extract($_POST);

    if(isset($email)){
       
        if($email != null)
        {
            $args = array(
                'post_type' => 'company', 
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'DESC',                        
            );
        
            $companies = get_posts($args);

            foreach($companies as $company){
                if($company->post_title == $company_manager){
                    $companie = $company;
                    break;
                }
            }

            if($first_name == null)
                $first_name = "ANONYM";
            
            if($last_name == null)
                $last_name = "ANONYM";

            
            $random = RandomString();

            $login = $random;

            $userdata = array(
                'user_pass' => 'p@ssword1234.',
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
                    $subject = 'Je LiveLearn inschrijving is binnen! ✨';
                    $body = "
                    Bedankt voor je inschrijving<br>
                    <h1>Hello " . $first_name  . "</h1>,<br> 
                    Je hebt je succesvol geregistreerd. Welcome onboard! Je LOGIN-ID is <b style='color:blue'>" . $login . "</b>  en je wachtwoord <b>p@ssword1234.</b><br><br>
                    <h4>Inloggen:</h4><br>
                    <h6><a href='https://livelearn.nl/inloggen/'> Connexion </a></h6>
                    ";
                
                    $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
                    wp_mail($email, $subject, $body, $headers, array( '' )) ; 
        
                    update_field('company', $companie, 'user_'.$user_id);
                ?>
                 <script>
                    window.location.replace("/dashboard/company/people/?message=U heeft met succes een nieuwe werknemer aangemaakt ✔️ ");
                </script>

            <?php
               
            }
        }
        else{
            echo "Vul de e-mail in, alsjeblieft";
            ?>
            <script>
                window.location.replace("/dashboard/company/people-mensen/?message=Your personal information has been sucessfully updated ✔️ ");
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
                            <li> <input type="text" name="first_name" placeholder="Voornaam">       </li>
                            <li> <input type="text" name="last_name" placeholder="Achternaam">      </li>
                            <li> <input type="email" name="email" placeholder="ZaKelijk mailadres"> </li>
                        </ul>
                        <br><br>
                        <button type="submit" class="btn btnMensenToevoegen">Werknemer toevoegen</button>
                    </div>
            </form>
        </div>
        <div class="blockOverviewMensen">
            <h2 class="titleBlockOverviewMensen">Groep Toevoegen </h2>
            <form action="../people-mensen/" method="POST">
                <div class="bodyBlockOverviewMensen">
                    <ul>
                        <li><input type="email" name="email" placeholder="ZaKelijk mailadres"></li>
                        <li><input type="email" name="email" placeholder="ZaKelijk mailadres"></li>
                        <li><input type="email" name="email" placeholder="ZaKelijk mailadres"></li>
                        <li><a href=""><b>+meer</b></a></li>
                    </ul>
                    <br><br>
                    <button type="submit" class="btn btnMensenToevoegen" disabled>Werknemer toevoegen</button>
                </div>
            </form>
        </div>
        <div class="importBlock2 blockOverviewMensen">
            <h2 class="titleBlockOverviewMensen">Import Lijst</h2>
            <div class="file-upload">
                <div class="file-select">
                    <button type="submit" class="file-select-button btnMensenToevoegen" id="fileName" disabled>Lijst importeren</button>
                    <div class="file-select-name" id="noFileLijs">IMPORT (Excel, CSV)</div>
                    <input type="file" name="chooseFileLijs" id="chooseFileLijs">
                </div>
            </div>
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




