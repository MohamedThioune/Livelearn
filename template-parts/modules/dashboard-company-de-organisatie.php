<?php
    $user_id = get_current_user_id();
    $user = wp_get_current_user();

    $allocate_basic = get_field('managed', 'user_'.$user_id);
    if(!$allocate_basic)
        $allocate_basic = array();

    extract($_POST);
    
    if(isset($allocate_push))
        if($allocate){
            //Employee precision
            foreach($allocate as $locate){
                if(!in_array($locate, $allocate_normal))
                    array_push($allocate_basic, $locate);
                update_field('ismanaged', $user_id, 'user_'.$locate);
            }
            //Manager precision
            update_field('managed', $allocate_basic, 'user_'.$user_id);

            $success = true;
            $message = "Successfully assigning employees as their manager";
        }
?>
<div class="blockManageTeam">
    <a href="/dashboard/company/allocate/" class="btn cardBlockManage">
        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Mijn_mensen.png" alt="">
        <span>Jij managed deze medewerkers</span>
    </a>
    <?php 
        if(in_array('administrator', $user->roles) || in_array('hr', $user->roles)){
    ?>
        <a href="/dashboard/company/grant" class="btn cardBlockManage">
            <img src="<?php echo get_stylesheet_directory_uri();?>/img/hierarchical.png" alt="">
            <span>Beheer de managers in je organisatie</span>
        </a>
    <?php
        }
    ?>
    <a href="/dashboard/company/afdelingen/" class="btn cardBlockManage">
        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image_69.png" alt="">
        <span>Afdelingen</span>
    </a>
</div>
