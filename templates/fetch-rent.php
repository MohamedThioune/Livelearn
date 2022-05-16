<?php /** Template Name: Fetch rent */ ?>
<?php 

extract($_POST);

$user_connected = get_current_user_id();
$company_connected = get_field('company',  'user_' . $user_connected);
$users_company = array();
$allocution = get_field('allocation', $id_course);
$users = get_users();

foreach($users as $user) {
    $company_user = get_field('company',  'user_' . $user->ID);
    if(!empty($company_connected) && !empty($company_user))
        if($company_user[0]->post_title == $company_connected[0]->post_title)
            array_push($users_company,$user->ID);
}

if (isset($id_course))
{
    echo "<input type='hidden' name='course_id' value='" . $id_course . "' />";
    echo "<input type='hidden' name='path' value='dashboard' />";
    echo "<select multiple class='multipleSelect2' name='selected_members[]' >";
    if(!empty($users_company))
        foreach($users_company as $user){
            $name = get_users(array('include'=> $user))[0]->data->display_name;
            if(in_array($user, $allocution))
                echo "<option value='" . $user . "' selected>" . $name . "</option>";
            else
                echo "<option value='" . $user . "'>" . $name . "</option>";   
        }
    echo "</select>";
}


?>


<script id="rendered-js" >
    $(document).ready(function () {
        //Select2
        $(".multipleSelect2").select2({
            placeholder: "Select subtopics",
             //placeholder
        });
    });
    //# sourceURL=pen.js
</script>    
                     
