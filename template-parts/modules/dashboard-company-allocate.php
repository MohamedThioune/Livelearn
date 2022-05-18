<?php
    $user_id = get_current_user_id();
    $allocate_basic = get_field('managed', 'user_'.$user_id);
    if(!$allocate_basic)
        $allocate_basic = array();

    extract($_POST);
    
    if(isset($allocate_push))
        if($allocate){
            //Employee precision
            foreach($allocate as $locate){
                if(!in_array($locate, $allocate_normal))
                    array_push($allocate_basic, $locate);
                update_field('ismanaged', $user_id, 'user_'.$locate);
            }
            //Manager precision
            update_field('managed', $allocate_basic, 'user_'.$user_id);

            $success = true;
            $message = "Successfully assigning employees as their manager";
        }

?>

<div class="row">
    <div class="col-md-5 col-lg-12">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <?php
                if(isset($message))
                    if($success)
                        echo "<span class='alert alert-success'>" . $message . "</span><br><br>";

                $user = get_users(array('include'=> $user_id))[0];
                if (!empty($user->roles)){
                    if ( !in_array('manager', $user->roles) && !in_array('administrator', $user->roles) ){
                        echo '<div class="titleOpleidingstype"><h2>You are not able to grant privileges</h2></div>';
                    }
                    else{                        
                        echo '<div class="titleOpleidingstype"><h2>Manage je team</h2></div>';
                        $company = get_field('company',  'user_' . $user_id );
                        $company_connected = $company[0]->post_title;

                        $users = get_users();
                ?>
                        <form action="/dashboard/company/allocate" method="post">
                            <div class="acf-field">
                                <label for="locate">Word de manager van de volgende medewerkers:</label><br>
                                <div class="form-group">
                                    <select name="allocate[]" class="multipleSelect2" multiple="true">
                                        <?php
                                        //Get users from company
                                        foreach($users as $element){
                                            $companies = get_field('company',  'user_' . $element->ID);
                                            if( !empty($company) && $user_id != $element->ID && !in_array($element->ID, $allocate_basic) ){
                                                $companie = $companies[0]->post_title;
                                                if($companie == $company_connected){
                                                    if($element->first_name)
                                                        echo "<option value='" . $element->ID ."'>" . $element->first_name . ' ' . $element->last_name . "</option>";
                                                    else 
                                                        echo "<option value='" . $element->ID ."'>" . $element->user_email ."</option>";
                                                } 
                                            }
                                        }
                                    ?>
                                    </select>
                                </div>
                                <button type="submit" name="allocate_push" class="btn btn-info">Activeer</button>
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

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
