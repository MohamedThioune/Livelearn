
<?php /** Template Name: Interest push */ ?>

<?php
extract( $_POST);
$state_push = "Something went wrong !";
if($meta_value){
    if($meta_key == 'topic'){
        $meta_data_extern = get_user_meta($user_id, $meta_key);
        $meta_data_intern = get_user_meta($user_id, 'topic_affiliate');
        if(!in_array($meta_value, $meta_data_extern) && !in_array($meta_value, $meta_data_intern) ){
            add_user_meta($user_id, $meta_key, $meta_value);
            $state_push = "Unfollow";
        }else
            if(in_array($meta_value, $meta_data_extern)){
                delete_user_meta($user_id, $meta_key, $meta_value);
                $state_push = "Follow";
            }else{
                delete_user_meta($user_id, "topic_affiliate", $meta_value);
                $state_push = "Follow";
            }
    }
    else{
        $meta_data = get_user_meta($user_id, $meta_key);
        if(!in_array($meta_value, $meta_data)){
            add_user_meta($user_id, $meta_key, $meta_value);
            $state_push = "Unfollow";
        }else{
            delete_user_meta($user_id, $meta_key, $meta_value); 
            $state_push = "Follow"; 
        }
    }                  
}

echo $state_push;