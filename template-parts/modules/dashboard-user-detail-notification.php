
<?php
    /*
    * * Feedbacks
    */
    $user_id = get_current_user_id();
    $args = array(
        'post_type' => array('feedback','manadatory','badge'), 
        'author' => $user_id,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'posts_per_page' => -1,
    );

    $todos = get_posts($args);
    if(isset($_GET['do']))
        $_GET['todo'] = $_GET['do'];

    if($_GET['todo'] > 0 ){ 

        $value = get_post($_GET['todo']);  
        if(!empty($value)){
            $type = get_field('type_feedback', $value->ID) ?: $value->post_type;
            $manager_id = (get_field('manager_feedback', $value->ID)) ?: get_field('manager_badge', $value->ID);
            $manager_id = ($manager_id) ?: get_field('manager_must', $value->ID);
            $image = get_field('profile_img', $manager_id);
            if(!$image)
                $image = get_stylesheet_directory_uri() . '/img/logo_livelearn.png';

            $manager = get_user_by('id', $manager_id);
            $manager_display = ($manager->first_name) ?: $manager->display_name;

            if($manager){
                $manager = get_user_by('ID', $manager_id);
                $manager_display = $manager->display_name;
            }else
                $manager_display = 'Livelearn';
        
            if($type == "Feedback" || $type == "Compliment" || $type == "Gedeelde cursus")
                $beschrijving_feedback = get_field('beschrijving_feedback', $value->ID);
            else if($type == "Persoonlijk ontwikkelplan")
                $beschrijving_feedback = get_field('opmerkingen', $value->ID);
            else if($type == "Beoordeling Gesprek")
                $beschrijving_feedback = get_field('algemene_beoordeling', $value->ID);
            else 
                $beschrijving_feedback = get_field('beschrijving_feedback', $value->ID) ?: 'Naan';
        
            if($type == "badge")
                $beschrijving_feedback = get_field('trigger_badge', $value->ID);

            $role = get_field('role',  'user_' . $manager->ID);
        } 
    }

    $state = false;
    if($manager_id == $user_id)
        $state = true;
    
?>
<div class="contentActivity">
    <h1 class="activityTitle">Detail Notification</h1>
    <?php 
    if(($value && $state) || !$manager_id || $user_id == $value->post_author){
    //Readed feedback
    update_field('read_feedback', 1, $value->ID);
    ?>
    <div class="row">
        <div class="col-lg-7">
            <div class="cardRecentlyEnrolled">
            <div class="w-100">
                <h2 class="notificationBy">Notifications By <?= $manager_display ?></h2>
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
                        <p class="type"><?= $type; ?> </p>
                    </div>
                </div>
                <div class="NotificationFeedback">
                    <?php
                    switch ($type) {
                        //Pour afficher les infos de type Beoordeling Gesprek
                        case 'Beoordeling Gesprek':
                            echo '<div class="d-flex"> <p class="title">Title: '. $value->post_title  .' </p>  </div> ' ;
                            echo '<p class="subTitle">Algemene beoordeling:</p>  <p class="subTitle">'. get_field('algemene_beoordeling', $value->ID).' </p> ' ;
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

                            echo '<div class="d-flex"> <p class="title">Title: '. $value->post_title  .' </p>  </div> ' ;

                            $onderwerp_feedback = get_field('onderwerp_feedback', $value->ID);
                            $onderwerp_feedback = explode(';', $onderwerp_feedback);
                            $wat_bereiken = get_field('je_bereiken', $value->ID);
                            $hoe_bereiken = get_field('je_dit_bereike', $value->ID);
                            $hulp_nodig = get_field('hulp_nodig', $value->ID);
                            $opmerkingen = get_field('opmerkingen', $value->ID);
                            $hulp_nodig_ja = ($hulp_nodig == 'JA') ? 'checked' : '';
                            $hulp_nodig_nee = ($hulp_nodig == 'NEE') ? 'checked' : '';
                            echo "<div class='inputGroein'>";
                            foreach($onderwerp_feedback as $onderwerp)
                            {
                                if($onderwerp != "")
                                    echo '<p>'.(String)get_the_category_by_ID($onderwerp).'</p>';
                            }
                            echo "</div>";

                            echo '<p>Wat wil je bereiken ?</p>';
                            echo  $wat_bereiken;
                            echo '<p>Hoe ga je dit bereiken ?</p>';
                            echo  $hoe_bereiken;
                            echo '<p>Heb je hierbij hulp nodig ?</p>';
                            echo '<div class="group-input-settings">
                                            <label for="">Heb je hierbij hulp nodig ?</label>
                                            <div class="d-flex">
                                                <div class="mr-3">
                                                    <input type="radio" id="JA" name="hulp_radio_JA" value="JA" '. $hulp_nodig_ja  .' disabled>
                                                    <label for="JA">JA</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="NEE" name="hulp_radio_JA" value="NEE" '. $hulp_nodig_nee  .' disabled>
                                                    <label for="NEE">NEE</label>
                                                </div>
                                            </div>
                                        </div>';
                            echo ' <p>Opmerkingen : </p>' . $opmerkingen;
                            break;
                        case 'Onderwerpen' :
                            echo '<div class="d-flex"> <p class="title"><span>Title</span> : '. $value->post_title  .' </p>  </div> ' ;
                            echo '<p class="subTitle">Beschrijving :</p> <p class="content-beschrij">'.$beschrijving_feedback;
                            $onderwerp_todos = (get_field('onderwerpen_todo', $value->ID)) ? (String)get_the_category_by_ID(get_field('onderwerpen_todo', $value->ID)) : null; 
                            if($onderwerp_todos):
                                echo '<p>Topic :</p> 
                                      <div class="inputGroein">
                                      <p>' . $onderwerp_todos . '</p>';
                                echo '</div>';
                            endif;
                            break;
                        
                        // Pour afficher les infos de type feedback ou compliment vu qu'ils ont le meme format
                        default :
                            echo '<div class="d-flex"> <p class="title"><span>Title</span> : '. $value->post_title  .' </p>  </div> ' ;
                            echo ' <p class="subTitle">Beschrijving :</p> <p class="content-beschrij">'.$beschrijving_feedback;
                            $onderwerp_feedback = get_field('onderwerp_feedback', $value->ID);
                            if ($onderwerp_feedback)
                                echo '<p>Topics :</p> ';
                            $onderwerp_feedback = explode(';',$onderwerp_feedback) .' </p> ';

                            if ($onderwerp_feedback):
                            echo '<div class="inputGroein">';
                            foreach($onderwerp_feedback as $onderwerp)
                            {
                                if($onderwerp != "")
                                    echo '<p>'.(String)get_the_category_by_ID($onderwerp). '</p>';
                            }
                            echo '</div>';
                            endif;

                            $collegas_feedback = get_field('collegas_feedback', $value->ID);
                            $show_collegas_feedback = ($collegas_feedback) ? '<p>Te verwittigen collegas : </p> <br>' : null;
                            echo '<br><p class="subTitle">Te verwittigen collegas :</p>' . $beschrijving_feedback;
                            if ($collegas_feedback):
                                echo '<div class="inputGroein">';
                                foreach($collegas_feedback as $collega):
                                    if($collega)
                                        echo '<p>'. $collega->display_name . '</p>';
                                endforeach;
                                echo '</div>';
                            endif;    
                            break;
                    }
                    ?>
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
                    $manager_id = 0;
                    if($todo->ID == $_GET['todo'])
                        continue;
                        
                    if($key == 10)
                        break;

                    $type = get_field('type_feedback', $todo->ID) ?: $todo->post_type;
                    $manager_id = (get_field('manager_feedback', $todo->ID)) ?: get_field('manager_badge', $todo->ID);
                    $manager_id = ($manager_id) ?: get_field('manager_must', $todo->ID);
                    $image = get_field('profile_img', $manager_id);
        
                    if($manager_id){
                        $manager = get_user_by('ID', $manager_id);
                        $image = get_field('profile_img',  'user_' . $manager->ID);
                        $manager_display = $manager->display_name;
                    }else{
                        $manager_display = 'Livelearn';
                        $image = 0;
                    }

                    if(!$image)
                        $image = get_stylesheet_directory_uri() . '/img/logo_livelearn.png';
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
    <?php 
    }
    else{ ?>
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