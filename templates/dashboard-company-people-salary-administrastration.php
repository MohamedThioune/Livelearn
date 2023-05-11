<?php /** Template Name: salary admin system */ ?>
<?php // /livelearn/salaryadmin ?>

<?php
$users = get_users();
extract($_POST);
    if (isset($managers)){
        // var_dump($managers); 
        foreach($managers as $man):
            $link = "/dashboard/company/profile/?id=" . $man->ID . '&manager='. $man->ID;
            $img_manager = get_field('profile_img',  'user_' . $man->ID) ? get_field('profile_img',  'user_' . $man->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        ?>
        <tr>
            <td> <?php echo $man->first_name!='' ? $man->first_name : $man->display_name ?> </td>
            <td>
                <img class="" src="<?= $img_manager ?>" alt="">
            </td>
            <td><a href="<?= $link ?>">See</a></td>
        </tr>
        <?php endforeach ?>

        <?php } ?>
   