<?php

    $user_id = get_current_user_id();

    extract($_POST);
    
    if(isset($granted_push))
        if(!empty($granted)){
            foreach($granted as $grant)
                {
                    $u = new WP_User($grant);
                    // Add role
                    $u->set_role( 'manager' );
                    $u->add_role( 'teacher' );
                }
                update_field('manager', 1, 'user_'.$grant);
            
            $success = true;
            $message = "Werknemer(s) met succes toegekend als een manager";
        }

?>

<div class="row">
    <div class="col-md-5 col-lg-12">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <?php
                if (isset($message))
                    if ($success)
                        echo "<span class='alert alert-success'>" . $message . "</span><br><br>";

                $user = get_users(array('include'=> $user_id))[0];
                if (!empty($user->roles)){
                    if ( !in_array('administrator', $user->roles) && !in_array('manager', $user->roles) ){
                        echo '<div class="titleOpleidingstype"><h2>You are not able to manage a member</h2></div>';
                    }
                    else{                        
                        echo '<div class="titleOpleidingstype"><h2>Selecteer je managers</h2></div>';
                        $company = get_field('company',  'user_' . $user_id );
                        $company_connected = $company[0]->post_title;

                        $users = get_users();
                ?>
                        <form action="/dashboard/company/grant" method="post">
                            <div class="acf-field">
                                <label for="locate">Geef een gebruiker de 'rol' manager om een team aan te sturen :</label><br>
                                <div class="form-group">
                                        <?php
                                        //Get users from company
                                        foreach($users as $used){
                                            $companies = get_field('company',  'user_' . $used->ID);
                                            if(!empty($company) && $user_id != $used->ID ){
                                                $companie = $companies[0]->post_title;
                                                if($companie == $company_connected){
                                                    $display = ($used->first_name) ?  $used->first_name . ' ' . $used->last_name : $used->user_email ;
                                                    echo "<div class='form-check'>
                                                            <input class='form-check-input' name='granted[]' type='checkbox' value='" . $used->ID . "' id='flexCheckDefault'>
                                                            <label class='form-check-label' for='flexCheckDefault'>"
                                                            . $display . "
                                                            </label>
                                                          </div>";
                                                
                                                } 
                                            }
                                        }
                                    ?>
                                </div>
                                <input type="hidden" name="manager_id" value="<?php echo $user_id; ?>">
                                <button type="submit" name="granted_push" class="btn btn-info">Activeer</button>
                            </div>
                        </form>
                <?php
                                
                    }
                }else
                    echo '<h3>Je hebt niet de rol manager binnen de organisatie, neem contact op met beheerder van jullie zakelijke omgeving</h3>';
                ?>
            </div>
        </div>
    </div>
</div>

