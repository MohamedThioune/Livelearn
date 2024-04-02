<?php
    session_start();
    $users = get_users();
    $list_of_all_employees=array();
    $class_employee_is_available="d-none";
    $data_user = wp_get_current_user();
    $user_connected = $data_user->data->ID;
    $company = get_field('company',  'user_' . $user_connected);

    //Departments
    $departments = get_field('departments', $company[0]->ID);

    if(!empty($company))
        $company_connected = $company[0]->post_title;

    $grant = get_field('manager','user_' . $user_connected);
    $ismanaged = get_field('managed','user_' . $user_connected);
    $members = array();
    $member_id = [];
    foreach($users as $user){
        if($user_connected != $user->ID ){
            $company = get_field('company',  'user_' . $user->ID);
            if(!empty($company)){
                $company = $company[0]->post_title;
                if($company == $company_connected)
                    array_push($members, $user);
            }
        }
    }
    extract($_POST);

    //logique of nmbrs salary administrastion 
    if (isset($nmbrs_username) && isset($nmbrs_password)) {
        $clientId_nmbrs = $nmbrs_username;
        $clientSecret_nmbrs = $nmbrs_password;
        $baseurl  =  'https://identityservice.nmbrs.com/connect/authorize';
        //$redirect_uri = get_site_url()."/dashboard/company/people/";
        $redirect_uri = "https://livelearn.nl/dashboard/company/people/";
        $scope= "employee.employment.read";
        $state = "9e530228-7e2b3ff6dcdd";

        //$authorization_url = "https://api.nmbrs.nl/oauth2/auth?response_type=code&client_id=$clientId_nmbrs&redirect_uri=$redirect_uri&scope=$scope";
        //$response_type="code";
        //$url = "$baseurl?$clientId_nmbrs&state=$state&scope=$scope&response_type=$response_type&redirect_uri=$redirect_uri";

        //header("Location: $authorization_url");
        header("Location: https://identityservice.nmbrs.com/connect/authorize?client_id=$clientId_nmbrs&state=$state&scope=$scope&response_type=code&redirect_uri=$redirect_uri");

    }
    if(isset($missing_details_user)){
        update_field('telnr', $telnr, 'user_'.$id_user);
        update_field('role', $role_user, 'user_'.$id_user);
        update_field('department', $department, 'user_'.$id_user);
        $message = "Informations updated";
        header('Location: /dashboard/company/people/?message=' . $message);
    }
    if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>";
    if( in_array('administrator', $data_user->roles) || in_array('hr', $data_user->roles) || in_array('manager', $data_user->roles) || $grant ) {
        extract($_POST);

        if (isset($client_id)&& isset($client_secret) ){
        $baseurl  =  'https://oauth.loket-acc.nl';
        $redirect = get_site_url()."/dashboard/company/people/";
        //$redirect = "https://livelearn.nl/dashboard/company/people/";
        $status = rand(1000,9999);
        $url = "$baseurl/authorize?client_id=$client_id&redirect_uri=$redirect&response_type=code&scope=all&state=$status";
        header("Location: $url");
        $_SESSION['client_id']=$client_id;
        $_SESSION['client_secret']=$client_secret;
    }
    if (isset($_GET['code'])) {
        if($_GET['code']){
            extract($_GET);
            $token="";
            $tokenIsValide=false;
            // $id_entreprise = get_field('id_company_loket',$company_connected->ID);
            // if ($tokenIsValide){
            // var_dump('The code generate : '.$code);
            $client_id = $_SESSION['client_id'];
            $client_secret = $_SESSION['client_secret'];
            $grant_type = "authorization_code";
            // URL de l'endpoint d'obtention du token
            $token_url = "https://oauth.loket-acc.nl";
            // Corps de la demande POST
            $body = http_build_query(array(
                'code' => $code,
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'redirect_uri' => $redirect,
                'grant_type' => $grant_type
            ));
            // header of POST request
            $headers = array(
                'Content-Type: application/x-www-form-urlencoded',
                'Content-Length: ' . strlen($body)
            );
            $options = array(
                    'http' => array(
                    'method' => 'POST',
                    'header' => implode("\r\n", $headers),
                    'content' => $body
                )
            );
            $context = stream_context_create($options);
                //POST request
            $response = file_get_contents($token_url."/token", false, $context);
            $data = json_decode($response, true); // token getted
            // $_SESSION['token-loket'] = $data['access_token'];
            $token = $data['access_token'];
            // $token = "lKuDoocYhVktpHirYL76WqKmx-o1ujxXfr3kaglAhUZ_D3zuMpEWRYj9BQrQQsJURkWuZKt0Z7umWrjPSVBNGUcdCK-64ixR-f0DFJmdiJVF3OY3Q9swpJVTPoNFF_8LdG0urxmQt94Hx4UOLXIDOunGDD99Laxr1P83RfFg5Q0GL7LHWMecg2ogyzbcov5ZQesUTBWVK2uaohiHyltMN5pGE6epZ6l8jFWhYs1CqZTxwFKxzNy1Mzyy_qHIbkwT-O7l1D7FXx-vtK_eCFEVC8NQuhqIuqYtezHLq33S0WKXgdvLAU27XpQZ-ey2C5iNy6leOQ6DlLiF2PMxvu-jDZb5f2D8DrDKiRrXf68OGtkxXHRw76nFw7MEn7fTUTsrvHxkCC0hD5HXysRBj3VVmBqfRA8";
            // var_dump($token);
            // $token = $_SESSION['token-loket'];
            // }

            // id company
                $url_employees="https://api.loket-acc.nl/v2/providers/employers";
                $options = array(
                    'http' => array(
                    'method' => 'GET',
                    'header' => "Authorization: Bearer $token\r\n" .
                    "Content-Type: application/json\r\n"
                )
            );
            $context = stream_context_create($options);
            $response = file_get_contents($url_employees, false, $context);

            $json_data = json_decode($response, true);
            if ($json_data) {
                $embedded = $json_data['_embedded'];
                $id_entreprise = $embedded[0]['id'];
                update_field('id_company_loket',$id_entreprise,$company_connected->ID);
                // var_dump("id de l'entreprise : $id_entreprise");
                //get list of all employee
                $list = "https://api.loket-acc.nl/v2/providers/employers/$id_entreprise/employees";
                $options = array(
                    'http' => array(
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
                        "Authorization: Bearer $token\r\n",
                        'method' => 'GET'
                    )
                );
                $context = stream_context_create($options);
                $liste_employees = file_get_contents($list, false, $context);
                if ($liste_employees) {
                    $class_employee_is_available='';
                    $empl=json_decode($liste_employees,true);
                    foreach ($empl['_embedded'] as $key => $employee) {
                        $tab = [];
                        $tab['firstName'] = $employee['personalDetails']['firstName'];
                        $tab['lastName'] = $employee['personalDetails']['lastName'];
                        $tab['dateOfBirth'] = $employee['personalDetails']['dateOfBirth'];
                        $tab['aowDate'] = $employee['personalDetails']['aowDate'];
                        $tab['photo'] = $employee['personalDetails']['photo'];
                        $tab['phoneNumber'] = $employee['contactInformation']['phoneNumber'];
                        $tab['mobilePhoneNumber'] = $employee['contactInformation']['mobilePhoneNumber'];
                        $tab['emailAddress'] = $employee['contactInformation']['emailAddress'];
                        $tab['street'] = $employee['address']['street'];
                        $tab['city'] = $employee['address']['city'];
                        $list_of_all_employees[] = $tab;
                    }
                }
            }
             else {
                // var_dump("not id company");
            }
        }
    }

    $count = count($members);
    ?>
    <div class="cardPeople cardPeopleModife">
        <div class="headListeCourse">
            <p class="JouwOpleid">Werknemers (<?= $count; ?>)</p>
            <input id="search_txt_company" class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek medewerker" aria-label="Search" >
            <div class="">
                <?php if($list_of_all_employees): ?>
                <span class="alert alert-success ">people from loket are available</span>
                <?php endif ?>
                <div class="d-flex align-items-center group-btn-mensen">
                    <a href="../people-mensen" class="btn add-people-manualy">Add people manually</a>
                    <div class="dropdown custom-dropdown-select">
                        <button class="btn  salary-administration  btn-choose-company dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Salary administration
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <!-- <button type="button" class="dropdown-item btn btn-show-modal" data-toggle="modal" data-target="#nmbrsModal">Nmbrs</button> -->
                            <button type="button" class="dropdown-item btn btn-show-modal" data-toggle="modal" data-target="#polarisModal">Polaris</button>
                            <button type="button" class="dropdown-item btn btn-show-modal" data-toggle="modal" data-target="#loketModal">Loket</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="contentCardListeCourse">

            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Afbeelding</th>
                        <th scope="col">Naam</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefoonnummer</th>
                        <th scope="col" class="thOnder">Functie</th>
                        <th scope="col">Afdeling</th>
                        <th scope="col">Managers</th>
                        <th scope="col">Optie</th>
                    </tr>
                </thead>
                <tbody id="autocomplete_company_people">

                    <?php
                    foreach($members as $keyP => $user){
                        $image_user = get_field('profile_img',  'user_' . $user->ID);
                        if(!$image_user)
                            $image_user = get_stylesheet_directory_uri(). "/img/placeholder_user.png";

                        $you = NULL;
                        if(!in_array('administrator', $user->roles))
                            $you = (in_array($user->ID, $ismanaged) || in_array('administrator', $data_user->roles) || in_array('hr', $data_user->roles) ) ?  'You' : NULL;

                        $manager = get_field('ismanaged', 'user_' . $user->ID);
                        $manager_image = get_field('profile_img',  'user_' . $manager);

                        $link = "/dashboard/company/profile/?id=" . $user->ID . '&manager='. $user_connected;
                    ?>
                        <tr class="pagination-element-block" id="<?php echo $user->ID; ?>" >
                            <td scope="row"><?= $keyP + 1; ?></td>
                            <td class="textTh thModife az">
                                <div class="ImgUser">
                                    <a href="<?= $link; ?>" > <img src="<?php echo $image_user ?>" alt=""> </a>
                                </div>
                            </td>
                            <td class="textTh"><a href="<?= $link; ?>" style="text-decoration:none;"><?php if(!empty($user->first_name)){echo $user->first_name;}else{echo $user->display_name;}?></a> </td>
                            <td class="textTh"><?php echo $user->user_email;?></td>
                            <td class="textTh"><?php echo get_field('telnr', 'user_'.$user->ID);?></td>
                            <td class="textTh elementOnder"><?php echo get_field('role', 'user_'.$user->ID);?></td>
                            <td class="textTh"><?php echo get_field('department', 'user_'.$user->ID);?></td>
                            <td class="textTh thModife">
                                <button type="button" id ="<?= $user->ID ?>" class="btn manager-picture-block-btn" data-table="<?= htmlspecialchars(json_encode($user->my_managers), ENT_QUOTES, 'UTF-8'); ?>" data-toggle="modal" data-target="#userModal<?= $keyP; ?>">
                                    managers
                                </button>
                                <!-- Modal -->
                                <div class="modal modalAllManager fade" id="userModal<?= $keyP; ?>" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="userModalLabel">List of Manager</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <!-- <div class="text-center" id="back-list-of-user-manager"></div> -->
                                            <div class="modal-body">
                                                <table class="table table-all-manager">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Photo</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody  class="back-list-of-user-manager">

                                                    </tbody>
                                                </table>
                                                    <div class="text-center loader-manager" role="status">
                                                        <div class="spinner-border" role="status"></div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div></td>
                            <td class="textTh">
                                <div class="dropdown text-white">
                                    <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                        <img style="width:20px"
                                              src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                    </p>
                                    <ul class="dropdown-menu">
                                        <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="<?= $link; ?>" target="_blank">Bekijk</a></li>
                                        <?php
                                        if($you)
                                            echo '<li class="my-1"><i class="fa fa-pencil px-2" ></i><a data-toggle="modal" data-target="#modalEdit' . $keyP . '" href="#">Edit</a></li>';

                                        if(in_array('administrator', $data_user->roles))
                                            if(!in_array('administrator', $user->roles) && !in_array('hr', $user->roles)){
                                            ?>
                                                <li class="my-1">
                                                    <div class="remove">
                                                        <?php
                                                            echo '<img class="removeImg" src="' . get_stylesheet_directory_uri() . '/img/deleteIcone.png" alt="">';
                                                        ?>
                                                        <span>Verwijderen</span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal optie edit missign information  -->
                        <div class="modal fade modal-Budget" id="modalEdit<?= $keyP ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-center">Add missing information</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST">
                                            <input type="hidden" name="id_user" value=<?= $user->ID ?>>
                                            <div class="form-group">
                                                <label for="telefoonnummer">Telefoonnummer</label>
                                                <input type="number" name="telnr" value="<?php echo get_field('telnr', 'user_'.$user->ID);?>" class="form-control" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="functie">Functie</label>
                                                <input type="text" name="role_user" value="<?php echo get_field('role', 'user_'.$user->ID);?>" class="form-control" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="telefoonnummer">Departement</label>
                                                <div class="formModifeChoose" >
                                                    <div class="formModifeChoose">

                                                        <select placeholder="Choose skills" class="multipleSelect2 selectdepartement" name="department">
                                                            <?php
                                                             foreach($departments as $department)
                                                                if($department['name'] == get_field('department', 'user_'.$user->ID) )
                                                                    echo '<option value="' . $department['name'] .'" selected>' . $department['name'] . '</option>';
                                                                else
                                                                    echo '<option value="' . $department['name'] .'" >' . $department['name'] . '</option>';
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="missing_details_user" class="btn btn-add-budget">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
    }
    else
        echo "<h3>Access denied !<h3>";

?>
</div>

<!--begin Modal for Nmbrs -->
<div class="modal fade otherModal" id="nmbrsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NMBRS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--
            <div hidden="true" id="loader" class="text-center" role="status">
                <div class="spinner-border" role="status">
                </div>
            </div>
            -->
            <div id="back-nmbrs" class="text-center"></div>
            <div class="modal-body">
                <form class="needs-validation" action="/dashboard/company/people" novalidate id="data-sending-from-nmbrs" method="POST">
                    <div class="form-group">
                        <label for="nmbrs-username" class="col-form-label">login</label>
                        <input type="text" class="form-control" name="nmbrs_username" aria-describedby="inputGroupPrepend" autocomplete="nope" required>
                        <!-- <input type="text" value="PartnerApp_extdev-livelearn_AFEE32B2930D41FA84667196E5515D40" class="form-control" name="nmbrs_username" aria-describedby="inputGroupPrepend" autocomplete="nope" required> -->
                    </div>
                    <div class="form-group">
                        <label for="nmbrs-password" class="col-form-label">password</label>
                        <input type="password" class="form-control" name="nmbrs_password" aria-describedby="inputGroupPrepend" autocomplete="new-password" required>
                        <!-- <input type="password" value="https://quickforget.com/s/55b05bf4213e0b1bb24343918e14db5c4bfcf9a3a2bde24a" class="form-control" name="nmbrs_password" aria-describedby="inputGroupPrepend" autocomplete="new-password" required> -->
                    </div>
                </form>
            </div>
            <div hidden="true" id="" class="text-center" role="status">
                <div class="spinner-border" role="status">

                </div>
            </div>
            <div class="d-none loader-back-nmbrs">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Plaats</th>
                        <th>Email</th>
                        <th>Optie</th>
                    </tr>
                    </thead>
                    <tbody >

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" form="data-sending-from-nmbrs">Connect to nmbrs</button>
            </div>
        </div>
    </div>
</div>
<!--end Modal for Nmbrs -->

<!--begin Modal for connexion polaris -->
<div class="modal fade otherModal" id="polarisModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">POLARIS</h5>
        <h6 style="color:red;" class="d-none text-center" id="error-connexion">Invalid cridentials</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <div hidden="true" id="loader" class="text-center" role="status">
         <div class="spinner-border" role="status">
        </div>
    </div>
      <div id="back-polaris" class="text-center"></div>
      <div class="modal-body">
        <form class="needs-validation" novalidate id="data-sending-from-polaris" method="POST">
          <div class="form-group">
            <label for="polaris-username" class="col-form-label">login</label>
            <input type="text" class="form-control" id="polaris-username" name="polaris-username" aria-describedby="inputGroupPrepend" autocomplete="nope" required>
          </div>
          <div class="form-group">
            <label for="polaris-password" class="col-form-label">password</label>
            <input type="password" class="form-control" id="polaris-password" name="polaris-password" aria-describedby="inputGroupPrepend" autocomplete="new-password" required>
          </div>
        </form>
      </div>
      <div hidden="true" id="loader-back-polaris" class="text-center" role="status">
         <div class="spinner-border" role="status">

        </div>
      </div>
      <div class="d-none loader-back-polaris" id="list-polaris">
        <table class="table table-hover">
        <thead>
        <tr>
            <th>Naam</th>
            <th>Plaats</th>
            <th>Email</th>
            <th>Optie</th>
        </tr>
        </thead>
        <tbody id="data-polaris">

        </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success polaris" form="data-sending-from-polaris">Connect to Polaris</button>
      </div>
    </div>
  </div>
</div>
<!--end Modal for connexion polaris -->

<!--begin Modal for connexion Loket -->
<div class="modal fade otherModal" id="loketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">LOKET</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="back-loket" class="text-center"></div>
      <div hidden="true" id="loader-back-loket" class="text-center" role="status">
         <div class="spinner-border" role="status">
            
        </div>
      </div>
      <div class="modal-body loader-back-loket" id="list-loket">
        <?php
        $class = '';
        if ($list_of_all_employees) {
            $class = 'd-none';
            ?>
        <div>
        <table class="table table-hover">
        <thead>
        <tr>
            <th>Naam</th>
            <th>city</th>
            <th>Email</th>
            <th>Optie</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($list_of_all_employees as $employee) : ?>
            <tr>
                <td class="row-fullName"><?=$employee['firstName'].' '.$employee['lastName'] ?></td>
                <td><?= $employee['city']?></td>
                <td class="row-email"><?= $employee['emailAddress'] ?: $employee['firstName'].'-'.$employee['lastName']."@".$employee['firstName']."-livelearn.nl"?></td>
                <td><button class="btn btn-outline-success" onclick="addInDatabase(event,'loket')">+Add</button></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        </table>
      </div>
      <?php } ?>

      <form class="<?= $class ?>" id="from-form-loket" action="/dashboard/company/people/" method="POST">
          <div class="form-group">
            <label for="loket-username" class="col-form-label">client id</label>
            <input type="text" class="form-control" id="loket-username" name="client_id" autocomplete="nope" require>
          </div>
          <div class="form-group">
            <label for="loket-password" class="col-form-label">client secret</label>
            <input type="password"  class="form-control " id="loket-password" name="client_secret" autocomplete="new-password" require>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success <?= $class ?>" form="from-form-loket">login to Loket</button>
      </div>
    </div>
  </div>
</div>
<!--end Modal for connexion loket -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<script type="text/javascript">
    $(".remove").click(function(){
        var id = $(this).parents("tr").attr("id");

        if(confirm('Are you sure you want to remove this user from your company ?'))
        {
            $.ajax({
               url: '/delete-user',
               type: 'POST',
               data: {id: id},
               error: function() {
                  alert('Something is wrong');
               },
               success: function(data) {
                    $("#"+id).remove();
                    console.log(data);
                    alert("User removed successfully from your company !");
               }
            });
        }
    });
</script>

<script>
     $('#search_txt_company').keyup(function(){
        var txt = $(this).val();
        $.ajax({

            url:"/fetch-company-people",
            method:"post",
            data:{
                search_user_company : txt,
            },
            dataType:"text",
            success: function(data) {
                console.log(data);
                const resultat_recherche = document.getElementById('autocomplete_company_people');
                resultat_recherche.innerHTML = data;
                $('#autocomplete_company_people').html(data);
            }
        });
    });
</script>
<script>
     $('#salary-system').change(function(e){
        const select = e.target;
        const optionSelected = select.options[select.selectedIndex].value;
        console.log(select.options[select.selectedIndex]);
        console.log(optionSelected);
    });
    // sending data form for polaris
  $(document).ready(function() {
  $('#data-sending-from-polaris').submit(function(event) {
      event.preventDefault();
      const formInformation = document.getElementById('data-sending-from-polaris');
      var formData = $(this).serialize();
      console.log('data submitted : ',formData);
      const username = $('input[name="polaris-username"]').val();
      const password = $('input[name="polaris-password"]').val();
      console.log(username)
      console.log(password)
      console.log(`data sending => ${username}:${password}`)
      const buttonSubmit = document.querySelector('.btn.btn-success.polaris');
      $.ajax({
    url: 'https://login.bcs.nl/API/RestService/export?Connector=aqMedewerker_test',
    method: 'GET',
    headers: {
        'Authorization': 'Basic ' + btoa(`${username}:${password}`)
      // 'Authorization': 'Basic ' + btoa(`API_test_extern@bcs.nl:Qa1B27x4D!s`)
    },
    beforeSend:function(){
        $('#loader').attr('hidden',false) //show the loader
        formInformation.className="d-none"; //hiden the form
        buttonSubmit.className="d-none";
       // $('#data-sending-from-polaris').attr('hidden',true) // hidden the submitting button
    },
    success: function(responseXML) {
        $('#loader').attr('hidden',true)
        formInformation.className="d-none";
        document.getElementById('list-polaris').classList.remove("d-none");
        document.getElementById('error-connexion').classList.add("d-none");
        console.log('success request :>',(responseXML));
        const regels = responseXML.querySelectorAll('Regel');
        const tbody = document.getElementById('data-polaris');
        const data = [];
        regels.forEach((regel) => {
        const row = {};
        // Browse through each child of the <Regel> element and retrieve values
        regel.childNodes.forEach((node) => {
            if (node.nodeType === 1) {
                row[node.nodeName] = node.textContent;
            }
        });
        // add object in the array of data
        data.push(row);
        const tr = document.createElement("tr");
        let email;
        if (!row.Email){
            email=row.Naam.split(' ')[0]+'@livelearn-'+row.Naam.split(' ')[1]+'.nl';
        }else{email=row.Email}
        tr.innerHTML = `
        <td class="row-fullName">${row.Naam}</td>
        <td>${row.Plaats}</td>
        <td class="row-email">${email}</td>
        <td><button onclick="addInDatabase(event)" class="btn btn-outline-success">+ Add </button></td>`;
        tbody.appendChild(tr);
        });

    },
        error: function(xhr, status, error) {
            $('#loader').attr('hidden',true)
            formInformation.className=" ";
            console.log('error request :>',error);
            document.getElementById('error-connexion').classList.remove("d-none");
        }
    });
    });
    });

    function addInDatabase(e,adminSalary='') {
        idSubmitted='back-polaris'
        if (adminSalary=='loket') {
            idSubmitted = 'back-loket';
        }
        const row = e.target.parentNode.parentNode;
        const email = row.querySelector(".row-email").textContent.trim();
        const fullName = row.querySelector(".row-fullName").textContent;
        const nams = fullName.split(' ');
        const firstName = nams[0];
        const lastName = nams.slice(1).join(" ");
        console.log("email :"+email);
        console.log("firstName :"+ firstName);
        console.log("lastName :"+ lastName);
        var dataToSend = {first_name:firstName,last_name:lastName,email:email};
        dataToSend = JSON.stringify(dataToSend);
        console.log('data sending ' + dataToSend );
        $.ajax({
        url: '/dashboard/company/people-mensen/',
        // url: '/dashboard/company/people-mensen/',
        method: 'POST',
        data: dataToSend,
        beforeSend:function(){
            document.getElementById(idSubmitted).innerHTML = '';
            $('#loader-'+idSubmitted).attr('hidden',false)
            $('.loader-'+idSubmitted).attr('hidden',true)
        },
        success: function(response) {
            $('.loader-'+idSubmitted).attr('hidden',false)
            $('#loader-'+idSubmitted).attr('hidden',true)
            msg_success = "<span class='alert alert-success'>U heeft met succes een nieuwe werknemer aangemaakt ✔️</span>";
            document.getElementById(idSubmitted).innerHTML = response;
            // location.reload();
        },
        error: function(error) {
            $('#loader-'+idSubmitted).attr('hidden',true)
            $('.loader-'+idSubmitted).attr('hidden',false)
            console.log("Erreur when sending data : =>"+JSON.stringify(error) );
            msg_error = "<span class='alert alert-danger'>Er is een fout opgetreden, probeer het opnieuw.</span>";
            err=error.responseText
            document.getElementById(idSubmitted).innerHTML = JSON.stringify(error);
            console.log("Erreur when sending data : => " +JSON.stringify(error) );
            // location.reload();
        }
        });
    }
</script>
<script>
   $('.custom-dropdown-select .dropdown-item').on('click', function(){
        $('.salary-administration').html($(this).html());
    });

</script>
<script>
     $(".manager-picture-block-btn").click(function(e){
        const backApi = document.querySelector('.back-list-of-user-manager');
        const loader = document.querySelectorAll('.loader-manager');
        const idUser = e.currentTarget.id
        var managers =e.currentTarget.getAttribute('data-table');
        managers = JSON.parse(managers);
        // console.log('data sending',managers);
        console.log('user :::::::'+idUser);
        $.ajax({
        url:"/salary-admin",
        method:"post",
        data:{
            id : idUser,
        },
        // dataType:"text",
        beforeSend:function(){
        loader.forEach(load => {
                load.className = "text-center loader-manager";
            });
        $(".back-list-of-user-manager").html(' ');
        },error: function(error){
            loader.forEach(load => {
                load.className = "text-center loader-manager d-none";
            });
            $(".back-list-of-user-manager").html("<p class='alert alert-danger'>Some things are wrong !!!</p>");
        },success: function(success){
            if (success.trim()===""){
                success = "<p class='alert alert-info text-center mt-3'>this user has no managers</p>"
            }
            console.log('success',success)
            loader.forEach(load => {
                load.className = "text-center loader-manager d-none";
            });
            $(".back-list-of-user-manager").html(success);
        },complete: function(complete){
            console.log('complete',complete);
        },
        });
     });
</script>
