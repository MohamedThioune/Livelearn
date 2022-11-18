
<?php
   /*
    * * Feedbacks
    */
    $args = array(
        'post_type' => 'feedback', 
        'author' => $user->ID,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'posts_per_page' => -1,
    );

    $todos = get_posts($args);

    $user_id = get_current_user_id();
    if($_GET['todo'] > 0 ){

        $value = get_post($_GET['todo']);   
        if(!empty($value)){
            $type = get_field('type_feedback', $value->ID);
            $manager_id = get_field('manager_feedback', $value->ID);
            var_dump($manager_id);
            $image = get_field('profile_img',  'user_' . $manager_id);
            if(!$image)
                $image = get_stylesheet_directory_uri() . '/img/Group216.png';

            $manager = get_user_by('id', $manager_id);
            $manager_display = ($manager->first_name) ?: $manager->display_name;

            if($manager){
                $manager = get_user_by('ID', $manager_id);
                $manager_display = $manager->display_name;
            }else
                $manager_display = 'A manager';
            
        
            if($type == "Feedback" || $type == "Compliment" || $type == "Gedeelde cursus")
                $beschrijving_feedback = get_field('beschrijving_feedback', $value->ID);
            else if($type == "Persoonlijk ontwikkelplan")
                $beschrijving_feedback = get_field('opmerkingen', $value->ID);
            else if($type == "Beoordeling Gesprek")
                $beschrijving_feedback = get_field('algemene_beoordeling', $value->ID);

            $role = get_field('role',  'user_' . $manager->ID);
        } 
    }

    $state = false;
    foreach($todos as $todo)
        if($todo->ID == $_GET['todo']){
            $state = true;
            break;
        }
            
?>
<div class="contentActivity">
    <h1 class="activityTitle">Detail Notification</h1>
    <?php if($value && $state){?>
        <div class="row">
            <div class="col-lg-7">
                <div class="cardRecentlyEnrolled">
                <div class="w-100">
                    <h2 class="notificationBy">Notifications By</h2>
                    <div class="globalnotificationBy">
                        <div class="contentImgName">
                            <div class="contentImg">
                                <img src="<?= $image ?>" alt="">
                            </div>
                            <div>
                                <p class="name"><?= $manager_display ?></p>
                                <p class="name"><?php echo $role ?></p>
                            </div>
                        </div>
                        <div class="blockType">
                            <p class="">Type :</p>
                            <p><?=$type;?> </p>
                        </div>
                    </div>
                    <div>
                        <h3 class="titleContentNotification">Content Notification</h3>
                        <div class="NotificationFeedback">
                            <?php
                            switch ($type) {
                                //Pour afficher les infos de type Beoordeling Gesprek
                                case 'Beoordeling Gesprek':
                                    echo '<br> <b>Title:</b> '.$value->post_title;
                                    echo '<br> <b>Algemene beoordeling:</b> '. get_field('algemene_beoordeling', $value->ID). '<br>';
                                    $stopics_rates_comment = explode(';',get_field('rate_comments', $value->ID));
                                    echo '<div class="bloclCijfers inputGroein">';
                                        for($i=0; $i<count($stopics_rates_comment); $i++)
                                        {
                                            $stars = intval($stopics_rates_comment[$i+1]);
                                            $topics=(String)get_the_category_by_ID(intval($stopics_rates_comment[$i]));
                                                
                                                    if($topics!= "")
                                                        echo '<p>'.$topics.'</p>';
                                                
                                            echo '<div class="rate">';

                                                
                                            for($in=$stars; $in >= 1; $in--)
                                                echo "⭐";
                                                                                            
                                                      
                                            echo "</div><br>";
                                            echo '<div class="mb-0" style="width: 100%;">'. $stopics_rates_comment[$i+2] . '</div>';
                                            $i = $i + 2;
                                        }
                                    echo '</div>';
                                    break;
                                //Pour afficher les infos de type Persoonlijk Ontwikkelplan
                                case 'Persoonlijk Ontwikkelplan' :

                                    echo '<br> <b>Title:</b> '. $value->post_title;

                                    $onderwerp_feedback = get_field('onderwerp_feedback', $value->ID);
                                    $onderwerp_feedback = explode(';', $onderwerp_feedback);
                                    $wat_bereiken = get_field('je_bereiken', $value->ID);
                                    $hoe_bereiken = get_field('je_dit_bereike', $value->ID);
                                    $hulp_nodig = get_field('hulp_nodig', $value->ID);
                                    $opmerkingen = get_field('opmerkingen', $value->ID);

                                    echo "<div class='inputGroein'>";
                                        foreach($onderwerp_feedback as $onderwerp)
                                        {
                                            if($onderwerp != "")
                                                echo '<p>'.(String)get_the_category_by_ID($onderwerp).'</p>';
                                        }
                                    echo "</div>";

                                    echo '<br> <b>Wat wil je bereiken ?</b>';
                                    echo  $wat_bereiken;
                                    echo '<br> <b>Hoe ga je dit bereiken ?</b>';
                                    echo  $hoe_bereiken;
                                    echo '<br> <b>Heb je hierbij hulp nodig ?</b>';
                                    echo  '<div class="group-input-settings">
                                                <label for="">Heb je hierbij hulp nodig ?</label>
                                                <div class="d-flex">
                                                    <div class="mr-3">
                                                        <input type="radio" id="JA" name="hulp_radio_JA" value="JA" '. ($hulp_nodig == 'JA') ? 'checked' : ''  .' disabled>
                                                        <label for="JA">JA</label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" id="NEE" name="hulp_radio_JA" value="NEE" '. ($hulp_nodig == 'NEE') ? 'checked' : ''  .' disabled>
                                                        <label for="NEE">NEE</label>
                                                    </div>
                                                </div>
                                            </div>';
                                    echo '<br> <b>Opmerkingen : </b> <br>' . $opmerkingen;
                                    break;
                                    // Pour afficher les infos de type feedback ou compliment vu qu'ils ont le meme format
                                default :
                                        echo '<br> <b>Title :</b> '.$value->post_title;
                                        echo '<br> <b>Beschrijving :</b> '.$beschrijving_feedback;
                                        $onderwerp_feedback = get_field('onderwerp_feedback', $value->ID);
                                        $onderwerp_feedback = explode(';',$onderwerp_feedback);
                                        echo '<br> <b>Topics :</b> <br> ';

                                        echo '<div class="inputGroein">';
                                        foreach($onderwerp_feedback as $onderwerp)
                                        {
                                            if($onderwerp != "")
                                                echo '<p>'.(String)get_the_category_by_ID($onderwerp). '</p>';
                                        }
                                        echo '</div>';
                                    break;
                            }       
                            ?>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <?php 
            if($todos)
                if(!empty($todos)){
            ?>
            <div class="col-lg-5">
                <div class="cardNotification">
                    <h2>Notifications</h2>
                    <?php 
                    
                    foreach($todos as $key=>$todo) {
                        if($todo->ID == $_GET['todo'])
                            continue;
                            
                        if($key == 10)
                            break;

                        $type = get_field('type_feedback', $todo->ID);
                        $manager_id = get_field('manager_feedback', $todo->ID);
                        if($manager_id){
                            $manager = get_user_by('ID', $manager_id);
                            $image = get_field('profile_img',  'user_' . $manager->ID);
                            $manager_display = $manager->display_name;
                        }else{
                            $manager_display = 'Anonymous';
                            $image = 0;
                        }

                        if(!$image)
                            $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                    ?>
                        <a  href="/dashboard/user/detail-notification/?todo=<?php echo $todo->ID; ?>" class="SousBlockNotification">
                            <div class="d-flex align-items-center">
                                <div class="circleNotification">
                                    <img src="<?php echo $image ?>" alt="">
                                </div>
                                <p class="feddBackNotification">
                                    <?= $manager_display ?> send you a  <span><?=$type?></span></p>
                            </div>
                            <!-- <p class="hoursText">0 hours ago</p> -->                    
                        </a>
                    <?php
                        }
                    ?>

                </div>
            </div>
            <?php
                }
            ?>
        </div>
    <?php }else{ ?>
        <div class="row">
            <div class="col-lg-7">
                <div class="cardRecentlyEnrolled">
                    <div class="w-100">
                        <h2 class="notificationBy"> Error occured when try to find this notification, make sure that it exists and you have the access rights.</h2>
                    </div>
                </div>
            </div>
        </div>
   <?php } ?>

</div>