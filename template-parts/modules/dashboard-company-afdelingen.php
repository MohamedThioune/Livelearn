<?php

$users = get_users();
$data_user = wp_get_current_user();

if(!in_array('administrator', $data_user->roles) && !in_array('hr', $data_user->roles)) 
    header('Location: /dashboard/company/');

$user_connected = $data_user->data->ID;
$company = get_field('company',  'user_' . $user_connected);

//Departments 
$departments = get_field('departments', $company[0]->ID);

if(!empty($company))
    $company_connected = $company[0]->post_title;

$members = array();
foreach($users as $user)
    if($user_connected != $user->ID ){
        $company = get_field('company',  'user_' . $user->ID);
        if(!empty($company)){
            $company = $company[0]->post_title;
            if($company == $company_connected)
                array_push($members, $user);
        }
    }

?>
<?php if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>"; ?>

<div class="blockAfdelingen">
    <div class="blockAfdelingen-table">
        <div class="headListeCourse">
            <p class="JouwOpleid">Werknemers (<?= count($members)?>)</p>
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
                    <th scope="col">Departement</th>
                    <th scope="col">Functions</th>
                    <th scope="col">Optie</th>
                </tr>
                </thead>
                <tbody id="autocomplete_company_people">
                    <?php
                    foreach($members as $key => $user){
                        $image_user = get_field('profile_img',  'user_' . $user->ID); 
                        if(!$image_user)  
                            $image_user = get_stylesheet_directory_uri(). "/img/placeholder_user.png";
                        
                        $link = "/dashboard/company/profile/?id=" . $user->ID . '&manager='. $user_connected; 

                        $name = (!empty($user->first_name)) ? $user->first_name : $user->display_name;

                        $job = get_field('role', 'user_'.$user->ID);
                        $department_user = get_field('department', 'user_'.$user->ID)
                    ?>
                        <tr id="" >
                            <td scope="row"><?= $key + 1 ?></td>
                            <td class="textTh thModife">
                                <div class="ImgUser">
                                    <a href="<?= $link ?>" >
                                        <img src="<?= $image_user ?>" alt="">
                                    </a>
                                </div>
                            </td>
                            <td class="textTh"> <a href="" style="text-decoration:none;"><?= $name ?></a> </td>
                            <td class="textTh"><?= $department_user ?></td>
                            <td class="textTh"><?= $job ?></td>
                            <td class="textTh">
                                <div class="dropdown text-white">
                                    <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                        <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                    </p>
                                    <ul class="dropdown-menu">
                                        <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="<?= $link ?>" target="_blank">View</a></li>
                                        <?php
                                        if(!in_array('administrator', $user->roles) && !in_array('hr', $user->roles) )
                                            echo '<li class="my-1"><i class="fa fa-pencil px-2" ></i><a data-toggle="modal" data-target="#modalViewManager' . $key . '" href="#">Edit</a></li>';
                                        ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php
                    ?>
                    <!-- Modal optie edit missign information  -->
                    <div class="modal fade modal-Manager" id="modalViewManager<?= $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center">Edit information</h5>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post" class="selectdepartementForm">
                                        <input type="hidden" name="id_user" value=<?= $user->ID ?>>
                                        <div class="form-group">
                                            <label for="telefoonnummer">Departement</label>
                                            <div class="formModifeChoose" >
                                                <div class="formModifeChoose">
                                                    <select placeholder="Choose skills" class="multipleSelect2 selectdepartement" name="department">
                                                        <?php 
                                                        foreach($departments as $department)
                                                            if($department['name'] == $department_user)
                                                                echo '<option value="' . $department['name'] .'" selected>' . $department['name'] . '</option>';
                                                            else
                                                                echo '<option value="' . $department['name'] .'" >' . $department['name'] . '</option>';
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="functie">Role (Job Functie)</label>
                                            <input type="text" class="form-control Functie" value="<?php echo($job); ?>" placeholder="Job Title" name="role_user">
                                        </div>
                                        <button type="submit" class="btn btn-add" name="details_user_departement">Save</button>
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
    <div class="departement-block">
        <button class="btn btnNewdepartement" data-toggle="modal" data-target="#modalNewDepartement">+ new departement</button>
        <ul class="">
            <?php
            foreach ($departments as $key => $department) {
                echo '<li>' .  $department['name'] .'
                      <form action="" method="POST">
                          <input type="hidden" name="id" class="form-control" value="' . $key . '" placeholder="Name of department">
                          <button name="departement_delete" class="btn btnRemoveDepartement"><i class="fa fa-trash"></i></button></li>
                      </form>';
            }
            ?>
        </ul>
    </div>
</div>

<!-- Modal new departement -->
<div class="modal fade modal-Manager" id="modalNewDepartement" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Add new Departement</h5>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="functie">Name</label>
                        <input type="text" name="name_department" class="form-control" placeholder="Name of department">
                    </div>

                    <button type="submit" class="btn btn-add" name="departement_add">Add</button>
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
                <h5 class="modal-title text-center">Edit information</h5>
            </div>
            <div class="modal-body">
                <form action="" class="selectdepartementForm">
                    <div class="form-group">
                        <label for="telefoonnummer">Departement</label>
                        <div class="formModifeChoose" >
                            <div class="formModifeChoose">
                                <select placeholder="Choose skills" class="multipleSelect2 selectdepartement" name="department">
                                    <?php 
                                    foreach($departments as $department) 
                                        echo '<option value="' . $department['name'] .'">' . $department['name'] . '</option>'
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="functie">Role (Job Functie)</label>
                        <input type="text" class="form-control Functie" placeholder="Job Title" name="role_user">
                    </div>
                    <button type="button" class="btn btn-add" name="details_user_departement">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

