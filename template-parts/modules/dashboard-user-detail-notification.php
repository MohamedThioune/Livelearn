
<?php
    $todos = get_field('todos',  'user_' . $user->ID);
    if(isset($todos[$_GET['todo']])){
        $value = explode(";", $todos[$_GET['todo']]);
        $manager = get_users(array('include'=> $value[2]))[0]->data;
        $image = get_field('profile_img',  'user_' . $manager->ID);
        if(!$image)
            $image = get_stylesheet_directory_uri() . '/img/Group216.png';
        $role = get_field('role',  'user_' . $manager->ID);
    }  
?>
<div class="contentActivity">
    <h1 class="activityTitle">Detail Notification</h1>
    <?php if($value){?>
        <div class="row">
            <div class="col-lg-7">
                <div class="cardRecentlyEnrolled">
                <div class="w-100">
                    <h2 class="notificationBy">Notifications By </h2>
                    <div class="globalnotificationBy">
                        <div class="contentImgName">
                            <div class="contentImg">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" alt="">
                            </div>
                            <div>
                                <p class="name"><?php if(isset($manager->first_name) && isset($manager->first_name)) echo $manager->first_name .' '. $manager->first_name; else echo $manager->display_name; ?></p>
                                <p class="name"><?php echo $role ?></p>
                            </div>
                        </div>
                        <div class="blockType">
                            <p class="">Type :</p>
                            <p><?php echo $value[3]; ?> </p>
                        </div>
                    </div>
                    <div>
                        <h3 class="titleContentNotification">Content Notification</h3>
                        <div class="NotificationFeedback">
                            <?php
                            switch ($value[3]) {
                                //Pour afficher les infos de type Beoordeling Gesprek
                                case 'Beoordeling Gesprek':
                                    echo '<br> <b>Title:</b> '.$value[0];
                                    echo '<br> <b>Algemene beoordeling:</b> '.$value[1]. '<br>';
                                    $stopics_rates_comment = explode('~',$value[4]);
                                    echo '<div class="bloclCijfers">';
                                        for($i=0; $i<count($stopics_rates_comment); $i++)
                                        {
                                            $stars = intval($stopics_rates_comment[$i+1]);
                                            echo '<p class="mb-0" style="width: 20%;"><b>'. (String)get_the_category_by_ID(intval($stopics_rates_comment[$i])) . '</b></p>';
                                            $suit = 5-$stars;
                                            echo '<div class="rate">';
                                                for($index=5; $index > $suit; $index--)
                                                    echo '<input type="radio" id="star'.$index.'__" name="sales_rate_'.$index.'" value="" checked="checked" disabled="true"/>
                                                          <label class="ma_link" for="star'.$index.'__" title="text">'.$index.' stars</label>';
                                                
                                                for($index=$suit; $index >= 1; $index++){
                                                    echo '<input type="radio" id="star'.$suit.'__" name="sales_rate_'.$suit.'" value=""  disabled="true"/>
                                                          <label class="ma_link" for="star'.$suit.'__" title="text">'.$suit.' stars</label>';
                                                }

                                                
                                            echo "</div><br>";
                                            echo '<div class="mb-0" style="width: 100%;">'. $stopics_rates_comment[$i+2] . '</div>';
                                            $i = $i + 2;
                                        }
                                    echo '</div>';
                                    break;
                                    //Pour afficher les infos de type Persoonlijk Ontwikkelplan
                                case 'Persoonlijk Ontwikkelplan' :
                                    echo '<br> <b>Title:</b> '.$value[0];
                                    $stopics= explode('~',$value[4]);
                                    for($i=0;$i<count($stopics_rates_comment); $i++)
                                    {
                                    echo '<br>'.(String)get_the_category_by_ID($stopics[$i]);
                                    }
                                    echo '<br> <b>Wat wil je bereiken ?</b>';
                                    echo  $value[5];
                                    echo '<br> <b>Hoe ga je dit bereiken ?</b>';
                                    echo  $value[6];
                                    echo '<br> <b>Heb je hierbij hulp nodig ?</b>';
                                    echo  $value[7];
                                    echo '<br> <b>Opmerkingen:</b> '.$value[1];
                                    break;
                                    // Pour afficher les infos de type feedback ou compliment vu qu'ils ont le meme format
                                default :
                                        echo '<br> Title: '.$value[0];
                                        echo '<br> Beschrijving: '.$value[1];
                                        $stopics= explode('~',$value[4]);
                                        echo '<br> Topics: ';
                                        foreach($stopics as $stopic)
                                        {
                                            if($stopic != "")
                                            echo '<br>'.(String)get_the_category_by_ID($stopic);
                                        }
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
                        $value = explode(";", $todo);
                        $manager = get_users(array('include'=> $value[2]))[0]->data;
                        $image = get_field('profile_img',  'user_' . $manager->ID);
                        if(!$image)
                            $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                    ?>
                        <div class="SousBlockNotification">
                            <div class="d-flex align-items-center">
                                <div class="circleNotification">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/notification 1.png" alt="">
                                </div>
                                <p class="feddBackNotification">
                                    <?php if(isset($manager->first_name) && isset($manager->first_name)) echo $manager->first_name .' '. $manager->first_name; else echo $manager->display_name; ?> send you a  <span>Feedback</span></p>
                            </div>
                            <!-- <p class="hoursText">0 hours ago</p> -->                    
                        </div>
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
                        <h2 class="notificationBy"> Error occured , when try to find this notification.</h2>
                    </div>
                </div>
            </div>
        </div>
   <?php } ?>

</div>