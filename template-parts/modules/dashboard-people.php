<?php
$users = get_users();
?>

<div class="contentListeCourse">
    <div class="cardPeople">
        <div class="headListeCourse">
            <p class="JouwOpleid">Werknemers (5)</p>
            <form action="" method="POST" class="form-inline ml-auto mb-0">
                <input class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek medewerker" aria-label="Search" id="search_text">
            </form>
            <a href="" class="btnActiviteit">Activiteit</a>
            <a href="" class="btnNewCourse">Persoon toevoegen</a>
        </div>
        <div class="contentCardListeCourse">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Naam</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefoonnummer</th>
                        <th scope="col" class="thOnder">Functie</th>
                        <th scope="col">Afdeling</th>
                        <th scope="col">Manager</th>
                        <th scope="col">Actie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($users as $user){?>
                    <tr>
                        <td class="textTh thModife">
                            <div class="ImgUser">
                                <img src="img/user.png" alt="">
                            </div>
                        </td>
                        <td class="textTh"><?php if(!empty($user->first_name)){echo $user->first_name;}else{echo $user->display_name;}?></td>
                        <td class="textTh"><?php echo $user->user_email;?></td>
                        <td class="textTh"><?php echo get_field('telnr', 'user_'.$user->ID);?></td>
                        <td class="textTh elementOnder"><?php echo get_field('role', 'user_'.$user->ID);?></td>
                        <td class="textTh"><?php echo get_field('department', 'user_'.$user->ID);?></td>
                        <td class="textTh">Kellell</td>
                        <td class="titleTextListe">
                            <a href="" class="btnNewCourse">Delete</a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>


