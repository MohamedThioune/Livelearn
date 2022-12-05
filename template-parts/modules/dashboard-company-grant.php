<?php
    $user = wp_get_current_user();
    $user_id = $user->ID;

    extract($_POST);
    
    if(isset($granted_push_teacher))
        if(!empty($granted)){
            foreach($granted as $grant)
                {
                    $u = new WP_User($grant);
                    // Add role
                    $u->add_role( 'author' );
                }            
            $success = true;
            $message = "Werknemer(s) met succes toegekend als een teacher";
            header('Location: /dashboard/company/grant/?message=' . $message);
        }
    if(isset($granted_push_manager))
        if($rol_manager){
            foreach($granted as $grant)
                {
                    $u = new WP_User($grant);
                    // Add role
                    $u->add_role( 'manager' );
                }
                update_field('manager', 1, 'user_'.$grant);
            update_field('amount_budget', $amount_budget, 'user_'.$grant);
            $success = true;
            $message = "Werknemer(s) met succes toegekend als een manager";
            header('Location: /dashboard/company/grant/?message=' . $message);
        }
?>
<?php 
    if(!in_array('administrator', $user->roles) && !in_array('hr', $user->roles))
        header("Location: /dashboard/company/de-organisatie" );
?>
<div class="row">
    <div class="col-md-5 col-lg-12">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <?php
                if(isset($_GET['message']))
                    if($_GET['message'])
                        echo "<span alert='alert alert-success'>" . $_GET['message'] . "</span> <br><br>"; 


                $user = get_users(array('include'=> $user_id))[0];
                if (!empty($user->roles)){
                    if ( !in_array('administrator', $user->roles) && !in_array('manager', $user->roles) && !in_array('hr', $user->roles)){
                        echo '<div class="titleOpleidingstype"><h2>You are not able to manage a member</h2></div>';
                    }
                    else{                        
                        echo '<div class="titleOpleidingstype"><h2>Selecteer je managers</h2></div>';
                        $company = get_field('company',  'user_' . $user_id );
                        $company_connected = $company[0]->post_title;

                        $users = get_users();
                ?>
                        <form action="" method="POST">
                            <div class="acf-field">
                                <label for="locate">Geef een gebruiker de rol 'teacher' om een team aan te sturen :</label><br>
                                <div class="form-group">
                                        <?php
                                        //Get users from company
                                        foreach($users as $used){

                                            if(in_array('administrator', $used->roles) || in_array('hr', $used->roles) || in_array('manager', $used->roles) || in_array('author', $used->roles))
                                                continue;
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
                                <button type="submit" name="granted_push_teacher" class="btn btn-info">Activeer</button>
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


<div class="cardPeople">
    <div class="headListeCourse">
        <p class="JouwOpleid">Werknemers (4)</p>
        <input id="search_txt_company" class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek medewerker" aria-label="Search" >
        <a href="../people-mensen" class="btnNewCourse">Persoon toevoegen</a>
    </div>
    <div class="contentCardAlloccate contentCardGrant">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Afbeelding</th>
                <th scope="col">Naam</th>
                <th scope="col">Manager</th>
                <th scope="col">Teacher</th>
                <th scope="col">Learning budget</th>
                <th scope="col">Optie</th>
            </tr>
            </thead>
            <tbody id="autocomplete_company_people">
                <?php
                $i = 0;
                foreach($users as $used){

                    if(in_array('administrator', $used->roles) || in_array('hr', $used->roles))
                        continue;
                    $companies = get_field('company',  'user_' . $used->ID);
                    if(!empty($company) && $user_id != $used->ID ){
                        $companie = $companies[0]->post_title;
                        if($companie == $company_connected){
                            $i++;
                            $display = ($used->first_name) ?  $used->first_name . ' ' . $used->last_name : $used->user_email ;

                            $image_user = get_field('profile_img',  'user_' . $used->ID); 
                            if(!$image_user)  
                                $image_user = get_stylesheet_directory_uri(). "/img/placeholder_user.png";

                            $is_manager = (in_array('manager', $used->roles)) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>';
                            $is_author = (in_array('author', $used->roles)) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>';

                            $amount_budget = 0;
                            $amount_budget = get_field('amount_budget',  'user_' . $used->ID);
                ?>
                        <tr id="" >
                            <td scope="row"><?= $i ?></td>
                            <td class="textTh thModife">
                                <div class="ImgUser">
                                    <a href="" >
                                        <img src="<?= $image_user ?>" alt="">
                                    </a>
                                </div>
                            </td>
                            <td class="textTh"> <a href="" style="text-decoration:none;"><?= $display ?></a> </td>
                            <td class="textTh"><?= $is_manager ?></td>
                            <td class="textTh"><?= $is_author ?></i></td>
                            <td class="textTh ">€ <?= $amount_budget; ?></td>
                            <td class="textTh">
                                <div class="dropdown text-white">
                                    <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                        <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                    </p>
                                    <ul class="dropdown-menu">
                                        <li class="my-1"><i class="fa fa-pencil px-2" ></i><a data-toggle="modal" data-target="#modalGrant" href="#" target="_blank">Edit</a></li>
                                        <li class="my-2"><i class="fa fa-trash px-2"></i><a href="" target="_blank">Remove</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                <?php
                ?>
                   <!-- Modal -->
                    <div class="modal fade modal-Budget" id="modalGrant" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center">Give your team a personal learning budget</h5>
                                </div>
                                <h6 class="manager-name">To: <?= $display ?> </h6>
                                <div class="modal-body">
                                    <form action="" method="POST">

                                        <div class="form-group block-check-grant">
                                            <label>
                                                <input type="checkbox" name="rol_manager" value="1"><span class="checbox-element-label">Manager</span>
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Leerbudget</label>
                                            <input type="number" name="amount_budget" value="<?= $amount_budget ;?>" class="form-control" placeholder="Amount €">
                                        </div>
                                        <button type="button" class="btn btn-add-budget">Add</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    }
                }

                ?>
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

