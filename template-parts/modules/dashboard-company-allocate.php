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
                    if ( !in_array('manager', $user->roles) && !in_array('hr', $user->roles) && !in_array('administrator', $user->roles) ){
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
                                            if(in_array('administrator', $element->roles) || in_array('hr', $element->roles) || in_array('manager', $element->roles))
                                                continue;
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
                                <button type="submit" name="allocate_push" class="btn btn-info">Apply</button>
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
    <div class="contentCardAlloccate">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Afbeelding</th>
                <th scope="col">Naam</th>
                <th scope="col">Email</th>
                <th scope="col">Telefoonnummer</th>
                <th scope="col">Afdeling</th>
                <th scope="col">Manager</th>
                <th scope="col">Optie</th>
            </tr>
            </thead>
            <tbody id="autocomplete_company_people">
                <tr id="" >
                    <td scope="row">1</td>
                    <td class="textTh thModife">
                     <div class="ImgUser">
                         <a href="" >
                             <img src="<?php echo get_stylesheet_directory_uri();?>/img/placeholder_user.png" alt="">
                         </a>
                     </div>
                    </td>
                    <td class="textTh"> <a href="" style="text-decoration:none;">Mamadou</a> </td>
                    <td class="textTh">modoudiouf535@gmail.com</td>
                    <td class="textTh">	+221779349340</td>
                    <td class="textTh"></td>
                    <td class="textTh img-block-mananger" data-toggle="modal" data-target="#modalViewManager">
                        <div class="img-mananger">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/placeholder_user.png" alt="">
                        </div>
                        <div class="img-mananger">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/placeholder_user.png" alt="">
                        </div>
                        <div class="img-mananger">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/placeholder_user.png" alt="">
                        </div>
                        <div class="img-mananger">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/placeholder_user.png" alt="">
                        </div>
                    </td>
                    <td class="textTh">
                        <div class="dropdown text-white">
                            <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                            </p>
                            <ul class="dropdown-menu">
                                <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="" target="_blank">View</a></li>
                                <li class="my-1"><i class="fa fa-pencil px-2" ></i><a data-toggle="modal" data-target="#modalAllocate" href="#">Edit</a></li>
                                <li class="my-2"><i class="fa fa-trash px-2"></i><a href="" target="_blank">Remove</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>

        <!-- Modal optie edit missign information  -->
        <div class="modal fade modal-Budget" id="modalAllocate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center">Add missing information</h5>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <div class="form-group">
                                <label for="telefoonnummer">Telefoonnummer</label>
                                <input type="number" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="functie">Functie</label>
                                <input type="text" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="afdeling">Afdeling</label>
                                <input type="text" class="form-control" placeholder="">
                            </div>

                            <button type="button" class="btn btn-add-budget">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal optie edit missign information  -->
        <div class="modal fade modal-Manager" id="modalViewManager" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center">All managers who manage <span>Mamadou</span></h5>
                    </div>
                    <div class="modal-body">
                        <div class="one-element-list-manager">
                            <div class="d-flex align-items-center">
                                <div class="block-img">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                                </div>
                                <div class="m-lg-2">
                                    <p class="name-manager">Mouhamed</p>
                                    <p class="email-manager">mouamed@livelearn.nl</p>
                                </div>
                            </div>
                            <a href="" target="_blank">
                                <i class="fa fa-eye viewIcone"></i>
                            </a>
                        </div>

                        <div class="one-element-list-manager">
                            <div class="d-flex align-items-center">
                                <div class="block-img">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                                </div>
                                <div class="m-lg-2">
                                    <p class="name-manager">Mouhamed</p>
                                    <p class="email-manager">mouamed@livelearn.nl</p>
                                </div>
                            </div>
                            <a href="" target="_blank">
                                <i class="fa fa-eye viewIcone"></i>
                            </a>
                        </div>

                        <div class="one-element-list-manager">
                            <div class="d-flex align-items-center">
                                <div class="block-img">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                                </div>
                                <div class="m-lg-2">
                                    <p class="name-manager">Mouhamed</p>
                                    <p class="email-manager">mouamed@livelearn.nl</p>
                                </div>
                            </div>
                            <a href="" target="_blank">
                                <i class="fa fa-eye viewIcone"></i>
                            </a>
                        </div>

                        <div class="one-element-list-manager">
                            <div class="d-flex align-items-center">
                                <div class="block-img">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                                </div>
                                <div class="m-lg-2">
                                    <p class="name-manager">Mouhamed</p>
                                    <p class="email-manager">mouamed@livelearn.nl</p>
                                </div>
                            </div>
                            <a href="" target="_blank">
                                <i class="fa fa-eye viewIcone"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

