<?php /** Template Name: apply cookies */ ?>
<?php wp_head(); ?>
<?php get_header(); ?>

<?php
    extract($_POST);
    //Instructions should be there ...
    if($set_cookie == "mobile_download") 
        setcookie('mobile_download', '1', time()+3600 * 24 * 180, '','.livelearn.nl', false);
    else if($set_cookie == "cookie_consent") 
        setcookie('cookie_consent', $cookie_value, time()+3600 * 24 * 180 , '','.livelearn.nl', false);
        
    if(isset($cookie_value))
        if($cookie_value) 
            echo $cookie_value;
?>
