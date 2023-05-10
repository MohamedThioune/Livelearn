<?php /** Template Name: apply cookies */ ?>

<?php
    extract($_POST);
    //Instructions should be there ...
    if($set_cookie == "mobile_download") 
        setcookie('mobile_download', '1', time()+3600 * 24 * 7 , '/');
    else if($set_cookie == "general") 
        setcookie('general', '0', time()+3600 * 24 * 7 , '/');

?>

<script>
    alert("Preferences set correctly");
</script>
