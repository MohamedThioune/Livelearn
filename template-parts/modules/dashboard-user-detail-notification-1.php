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
                            <p>Feedback</p>
                        </div>
                    </div>
                    <div>
                        <h3 class="titleContentNotification">Content Notification</h3>
                        <p class="NotificationFeedback"><?php echo $value[1]; ?> </p>
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
                                <p class="feddBackNotification"><?php if(isset($manager->first_name) && isset($manager->first_name)) echo $manager->first_name .' '. $manager->first_name; else echo $manager->display_name; ?> send you a  <span>Feedback</span></p>
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
   <?php } ?>

</div>