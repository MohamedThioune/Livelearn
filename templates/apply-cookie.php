<?php /** Template Name: apply cookies */ ?>
<?php wp_head(); ?>
<?php get_header(); ?>

<?php
    extract($_POST);
    //Instructions should be there ...
    if($set_cookie == "mobile_download") 
    setcookie('mycookie','mydata',time() + 2*7*24*60*60,'/','.livelearn.nl', false);
        setcookie('mobile_download', '1', time()+3600 * 24 * 7, '/','.livelearn.nl', false);
    else if($set_cookie == "general") 
        setcookie('general', $cookie_value, time()+3600 * 24 * 360 , '/','.livelearn.nl', false);
    if(isset($cookie_value))
        if($cookie_value) 
            echo $cookie_value;
?>
