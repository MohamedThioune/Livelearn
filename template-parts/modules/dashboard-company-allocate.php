<?php
$user_id = get_current_user_id();
$user = wp_get_current_user();
$company = get_field('company',  'user_' . $user_id );
$company_connected = $company[0]->post_title;

if ( !in_array('administrator', $user->roles) && !in_array('manager', $user->roles) && !in_array('hr', $user->roles))
    header('Location: /dashboard/company/');

$allocate_basic = get_field('managed', 'user_'.$user_id);
if(!$allocate_basic)
    $allocate_basic = array();

extract($_POST);

if(isset($manager_employee))
    if($allocate){
        //Employee precision
        foreach($allocate as $locate){
            if(!in_array($locate, $allocate_basic))
                array_push($allocate_basic, $locate);
            update_field('ismanaged', $user_id, 'user_' . $locate);
        }
        //Manager precision
        update_field('managed', $allocate_basic, 'user_' . $user_id);

        $success = true;
        $message = "Successfully assigning employees as their manager";
        header('Location: /dashboard/company/people/?message=' . $message);
    }

$users = get_users();
?>
<div class="blockManageTeam">
    <?php
        if(isset($_GET['message']))
            if($_GET['message'])
                echo "<span alert='alert alert-success'>" . $_GET['message'] . "</span> <br><br>"; 
    ?>
    <form action="/dashboard/company/allocate" method="post">
        <div class="acf-field">
            <label for="locate">Selecteer de mensen die u wilt managen :</label><br>
            <div class="form-group">
                    <?php
                    //Get users from company
                    foreach($users as $used){

                        if(in_array('administrator', $used->roles) || in_array('hr', $used->roles) || in_array('manager', $used->roles))
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
                                        <input class='form-check-input' name='allocate[]' type='checkbox' value='" . $used->ID . "' id='flexCheckDefault'>
                                        <label class='form-check-label' for='flexCheckDefault'>"
                                        . $display . "
                                        </label>
                                    </div>";
                            } 
                        }
                    }
                ?>
            </div>
            <button type="submit" name="manager_employee" class="btn btn-info">Activeer</button>
        </div>
    </form>
    <div class="table-allocate w-100">
        <div class="cardPeople">
            <div class="headListeCourse">
                <p class="JouwOpleid">Selecteer de mensen die u wilt managen :</p>
                <input id="search_txt_company" class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek medewerker" aria-label="Search" >
            </div>
            <div class="contentCardAlloccate contentCardGrant">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Afbeelding</th>
                        <th scope="col">Naam</th>
                        <th scope="col"><input class='form-check-input checkAllElement' type='checkbox' value="" id=''></th>
                    </tr>
                    </thead>
                    <tbody id="autocomplete_company_people">
                        <tr id="" >
                            <td scope="row">1</td>
                            <td class="textTh thModife">
                                <div class="ImgUser">
                                    <a href="" >
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/placeholder_user.png" class="" alt="">
                                    </a>
                                </div>
                            </td>
                            <td class="textTh text-center">Mohamed Thioune</td>
                            <td class="textTh text-center"><input class='form-check-input' type='checkbox' value="" id=""></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Modal -->
                <div class="modal fade modal-Budget" id="modalGrant" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center">Give your team a personal learning budget</h5>
                            </div>
                            <h6 class="manager-name">To: Daniel </h6>
                            <div class="modal-body">
                                <form action="">

                                    <div class="form-group block-check-grant">
                                        <label>
                                            <input type="checkbox" name="Manager" value="Manager"><span class="checbox-element-label">Manager</span>
                                        </label>
                                        <label>
                                            <input type="checkbox" name="Teacher" value="Teacher"><span class="checbox-element-label">Teacher</span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Leerbudget</label>
                                        <input type="number" class="form-control" placeholder="Amount €">
                                    </div>
                                    <button type="button" class="btn btn-add-budget">Add</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

