<?php
$user_id = get_current_user_id();
$user = wp_get_current_user();
$company = get_field('company',  'user_' . $user_id );
$company_connected = $company[0]->post_title;

$ismanaged = get_field('managed',  'user_' . $user_id); 

if ( !in_array('administrator', $user->roles) && !in_array('manager', $user->roles) && !in_array('hr', $user->roles))
    header('Location: /dashboard/company/');

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

$users = get_users();

?>
<div class="blockManageTeam">
    <form action="/dashboard/company/grant" method="post">
        <div class="acf-field">
            <label for="locate">Selecteer de mensen die u wilt beheren :</label><br>
            <div class="form-group">
                    <?php
                    //Get users from company
                    foreach($users as $used){

                        if(in_array('administrator', $used->roles) || in_array('hr', $used->roles) || in_array('manager', $used->roles))
                            continue;
                        if(!empty($ismanaged))
                            if(in_array($used->ID, $ismanaged))
                                continue;
                        
                        if(!empty($allocate_basic))    
                            if(in_array($used->ID, $allocate_basic))
                                continue;

                        $companies = get_field('company',  'user_' . $used->ID);
                        if(!empty($company) && $user_id != $used->ID ){
                            $companie = $companies[0]->post_title;
                            if($companie == $company_connected){
                                $display = ($used->first_name) ?  $used->first_name . ' ' . $used->last_name : $used->user_email ;
                                echo "<div class='form-check'>
                                        <input class='form-check-input' name='allocate_normal[]' type='checkbox' value='" . $used->ID . "' id='flexCheckDefault'>
                                        <label class='form-check-label' for='flexCheckDefault'>"
                                        . $display . "
                                        </label>
                                    </div>";
                            } 
                        }
                    }
                ?>
            </div>
            <button type="submit" name="allocate_push" class="btn btn-info">Activeer</button>
        </div>
    </form>
</div>

