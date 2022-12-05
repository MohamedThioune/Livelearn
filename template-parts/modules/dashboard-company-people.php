<?php
    $users = get_users();
    $data_user = wp_get_current_user();
    $user_connected = $data_user->data->ID;
    $company = get_field('company',  'user_' . $user_connected);
    
    if(!empty($company))
        $company_connected = $company[0]->post_title;

    $grant = get_field('manager',  'user_' . $user_connected);
    $ismanaged = get_field('managed',  'user_' . $user_connected); 

    $user = get_users(array('include'=> 1))[0]->data;

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
    
    $count = count($members);

    extract($_POST);

    if(isset($missing_details_user)){
        update_field('telnr', $telnr, 'user_'.$user_connected);
        update_field('role', $role_user, 'user_'.$user_connected);
        update_field('department', $department, 'user_'.$user_connected);
        $message = "Informations updated";
        header('Location: /dashboard/company/people/?message=' . $message);
    }

if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>"; 
    if( in_array('administrator', $data_user->roles) || in_array('hr', $data_user->roles) || in_array('manager', $data_user->roles) || $grant ) {
?>
    <div class="cardPeople">
        <?php
          if(isset($_GET['message']))
            if($_GET['message'])
                echo "<span alert='alert alert-success'>" . $_GET['message'] . "</span> <br><br>"; 
        ?>
        <div class="headListeCourse">
            <p class="JouwOpleid">Werknemers (<?= $count; ?>)</p>
            <input id="search_txt_company" class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek medewerker" aria-label="Search" >
            <a href="../people-mensen" class="btnNewCourse">Persoon toevoegen</a>
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
                        <th scope="col">Manager</th>
                        <th scope="col">Optie</th>
                    </tr>
                </thead>
                <tbody id="autocomplete_company_people">
                    <?php
                    foreach($members as  $key => $user){
                        $image_user = get_field('profile_img',  'user_' . $user->ID); 
                        if(!$image_user)  
                            $image_user = get_stylesheet_directory_uri(). "/img/placeholder_user.png";

                        $you = NULL;
                        if(!in_array('administrator', $user->roles))
                            $you  =  (in_array($user->ID, $ismanaged) || in_array('administrator', $data_user->roles) || in_array('hr', $data_user->roles) ) ?  'You' : NULL;
                        
                        $link = "/dashboard/company/profile/?id=" . $user->ID . '&manager='. $user_connected; 
                    ?>
                        <tr id="<?php echo $user->ID; ?>" >
                            <td scope="row"><?= $key; ?></td>
                            <td class="textTh thModife">
                                <div class="ImgUser">
                                <a href="<?= $link; ?>" > <img src="<?php echo $image_user ?>" alt=""> </a>
                                </div>
                            </td>
                            <td class="textTh"> <a href="<?= $link; ?>" style="text-decoration:none;"><?php if(!empty($user->first_name)){echo $user->first_name;}else{echo $user->display_name;}?></a> </td>
                            <td class="textTh"><?php echo $user->user_email;?></td>
                            <td class="textTh"><?php echo get_field('telnr', 'user_'.$user->ID);?></td>
                            <td class="textTh elementOnder"><?php echo get_field('role', 'user_'.$user->ID);?></td>
                            <td class="textTh"><?php echo get_field('department', 'user_'.$user->ID);?></td>
                            <td class="textTh"><?= $you ?></td>
                            <td class="textTh">
                                <div class="dropdown text-white">
                                    <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                        <img  style="width:20px"
                                              src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                    </p>
                                    <ul class="dropdown-menu">
                                        <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="<?= $link; ?>" target="_blank">Bekijk</a></li>
                                        <?php
                                        if($you){
                                        ?>                            
                                            <li class="my-1"><i class="fa fa-pencil px-2" ></i><a data-toggle="modal" data-target="#modalEdit" href="#">Edit</a></li>
                                            <li class="my-1">
                                                <div class="remove">
                                                    <?php
                                                        echo '<img class="removeImg" src="' . get_stylesheet_directory_uri() . '/img/deleteIcone.png" alt="">';
                                                    ?>
                                                    <span>Verwijderen</span>
                                                </div>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php
                    } 
                    ?>
                </tbody>
            </table>
            <!-- Modal optie edit missign information  -->
            <div class="modal fade modal-Budget" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center">Add missing information</h5>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="telefoonnummer">Telefoonnummer</label>
                                    <input type="number" name="telnr" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="functie">Functie</label>
                                    <input type="text" name="role_user" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="afdeling">Afdeling</label>
                                    <input type="text" name="department" class="form-control" placeholder="">
                                </div>

                                <button type="submit" name="missing_details_user" class="btn btn-add-budget">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php 
    }
    else
        echo "<h3>Access denied !<h3>";
    
?>
</div>


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
            success: function(data){
                console.log(data);
                $('#autocomplete_company_people').html(data);
            }
        });

    });
</script>