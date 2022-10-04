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

if($_GET['message']) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>"; 
    if( in_array('administrator', $data_user->roles) || in_array('hr', $data_user->roles) || $grant ) {
?>
    <div class="cardPeople">
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
                        
                        $you  =  (in_array($user->ID, $ismanaged) || in_array('administrator', $data_user->roles) || in_array('hr', $data_user->roles) ) ?  'You' : '';
                        
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
                                        <li class="my-2"><i class="fa fa-gear px-2"></i><a href="<?= $link; ?>" target="_blank">Pas aan</a></li>
                                        <li class="my-1 ">
                                            <div class="<?php if($you != '') echo 'remove' ?>">
                                                <?php
                                                if($you != '')
                                                    echo '<img class="removeImg" src="' . get_stylesheet_directory_uri() . '/img/deleteIcone.png" alt="">';
                                                ?>
                                                <span>Verwijderen</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php 
    }
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