<?php
//chekc if user is logged in
if(is_user_logged_in()){
    //get user role
    $user = wp_get_current_user();
    $user_roles = $user->roles;

//    if(in_array('manager', $user_roles) || in_array('administrator', $user_roles)){
//        include_once(dirname(__FILE__).'/header_manager.php');	
//    }else if(in_array('teacher', $user_roles)){
//        include_once(dirname(__FILE__).'/header_teacher.php');
//    }else{
        include_once(dirname(__FILE__).'/header_user.php');
//    }
}else{
    include_once(dirname(__FILE__).'/header_base.php');
}
//include_once(dirname(__FILE__).'/header_base.php');	
?>

