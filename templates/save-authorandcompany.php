<?php /** Template Name: Save Author and Compagny */ ?>

<?php
require_once 'add-author.php';
require_once 'upload.php';

if (isset($_POST['connect_authortoCourse']) && !empty($_POST['connect_authortoCourse']) && $_POST['action'] == 'connect_authortoCourse') 
{
            $author_ids = array_map('intval', $_POST['connect_authortoCourse']);

            $course_id  = intval($_POST['id_course']);
            //var_dump($author_ids,$course_id);die;

            // Save associated companies using ACF
           // update_field('company', $company_ids, $course_id);
           $verify=0;
           foreach ($author_ids as $value) {
           //  $update_result = update_field('course', $value, $course_id);

            $course_data = array(
            'ID' => $course_id,
            'post_author' => $value
            );

        // Update the post
            $update_result=wp_update_post($course_data);
              if ($update_result)
              $verify=1;
           }
            // Verify if the field was updated
            if ($verify==1) {
               //  $company = get_post($company_id);
                echo "<span class='alert alert-success'>Author added successfully!</span>";
            } else {
                echo "<span class='alert alert-success'>Failed to add author for the course.</p>";
            }
    }

if ( $_POST['action'] == 'get_subtopics') 
{

   if (isset($_POST['topic_id']) && !empty($_POST['topic_id'])) {
        $topic_id = intval($_POST['topic_id']);
        $subtopics = [];

         $subtopics = get_categories(
            array(
            'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $topic_id ,
            'hide_empty' => 0,
            //  change to 1 to hide categores not having a single post
            )
        );

      
        
        

       $html = '<label class="label-sub-topics">Choose Your sub-topics </label>  <div class="select-buttons-container" id="selectButtonsContainer">';
            foreach ($subtopics as $value) {
                $html .= '<button class="select-button" data-value="' . $value->cat_ID . '">' . $value->cat_name. '</button>';
            }
            $html .= '</div><button class="btn btn-save" id="save_subtopics" type="button" >Save</button>';
            echo $html;
           

        die();
    }
}
if ( $_POST['action'] == 'add_compagnies') 
{
if (!isset($_POST['company_name']) || !isset($_POST['company_country']) || !isset($_POST['company_city']) || !isset($_POST['company_address'])) {
       echo "<br><h6>Required fields are missing. running <i class='fas fa-spinner fa-pulse'></i></h6>";
    die();
}
else {
    // Sanitize input
    $company_name = sanitize_text_field($_POST['company_name']);
    $company_country = sanitize_text_field($_POST['company_country']);
    $company_city = sanitize_text_field($_POST['company_city']);
    $company_address = sanitize_text_field($_POST['company_address']);
    $company_industry = sanitize_text_field($_POST['company_industry']);
    $company_size = sanitize_text_field($_POST['company_size']);

    // Create post data array
    $args = array(
        "post_type" => "company",
        "post_title" => $company_name,
        "post_status" => "publish"
    );
    $company_id = wp_insert_post($args);

    // Insert post
    // Check for errors
    if (is_wp_error($company_id)) {

        echo "<span class='alert alert-success'>Error: " . $company_id->get_error_message() . "❌</span>";
        die();
    }
    else {
    echo 'Post created with ID: ' . $company_id;
}
    //  $author_id = generatorAuthor($company_name);
    
        // // Associate user with company
        // if(!is_wp_error($author_id)) {
        //       $company = get_post($company_id);
        //        update_field('company', $company, 'user_' . $author_id);
        // }

          

    // Optionally handle company logo upload
    if (!empty($_FILES['company_logo'])) {
        $file = $_FILES['company_logo'];
       
       $url = get_site_url() . '/wp-json/wp/v2/company/'.$company_id;
       $imageId= upload_image_to_media($file);
        //  update_post_meta($company_id, 'company_logo',  $imageId);
          update_field('company_logo',$imageId, $company_id);
        //  die();

       $ch = curl_init();


curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_POST, 1 );
curl_setopt($ch, CURLOPT_POSTFIELDS,'
    {
        "acf" : {
                  "company_logo" :'.$imageId.'
        }  
    }',);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
//  'Authorization: Basic ZmFsbG91Lm5kaWF5ZTk1QHVuaXYtdGhpZXMuc246TGl2ZWxlQHJuMjAyNA==',
//     'Content-Type:application/json;charset=UTF-8'
// local
'Authorization: Basic bmlhc3Nzc25AZ21haWwuY29tOnI4UiU5UGwmb3RDbW5td0o='
]);
$result = curl_exec($ch);

       if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }
       curl_close($ch);
        // Output the result
       if (isset($error_msg)) {
           
           echo 'Response: ' .$error_msg;
        } else {
         
    // update_post_meta($company_id, 'company_country', $company_country);
    // update_post_meta($company_id, 'company_city', $company_city);
    // update_post_meta($company_id, 'company_address', $company_address);
    update_field('company_sector',$company_industry, $company_id);
     update_field('company_address',$company_address, $company_id);
     update_field('company_city',$company_city, $company_id);
      update_field('company_country',$company_country, $company_id);
       update_field('company_size',$company_size, $company_id);

    // Return success response
   echo "<span class='alert alert-success'>compagny created successfully! ✔️</span>";
    die();
            
            
            
        }
    }
    // Save additional custom fields
   }
 }
 if ($_POST['action'] == 'add_users') {
 if (!isset($_POST['first_name']) || !isset($_POST['last_name']) || !isset($_POST['email'])) {
      // echo wp_send_json_error('Required fields are missing.');
        echo "<br><h6>Required fields are missing. running <i class='fas fa-spinner fa-pulse'></i></h6>";
        die();
       
        
    }
else{

$first_name = sanitize_text_field($_POST['first_name']);
$last_name = sanitize_text_field($_POST['last_name']);
$email = sanitize_email($_POST['email']);
$phone_number = sanitize_text_field($_POST['phone_number']);
$password = wp_generate_password();

$userdata = array(
    'first_name' => $first_name,
    'last_name' => $last_name,
    'display_name' => $first_name . ' ' . $last_name,
    'user_email' => $email,
    'user_login' => $email,
    'user_pass' => $password,
    'role' => 'author'
);
$user_id = wp_insert_user($userdata);

if (is_wp_error($user_id)) {
    echo "<span class='alert alert-success'>Error: " . $user_id->get_error_message() . "❌</span>";
  
} 
else{
        $attachment_url = '';
        // Check if a file was uploaded
       if (isset($_POST['companyId'])){
            $idCompany=intval($_POST['companyId']);
         $company = get_post($idCompany);
           update_field('company', $company, 'user_' . $user_id);
       }
        if (isset($_FILES['profile_photo'])) {
        $file = $_FILES['profile_photo'];
                   // $file = $_POST['profile_photo'];
    $imageId= upload_image_to_media($file);
    $user  = get_user_by('ID', 3);
     $username = $user->user_email;
     $password = $user->user_pass;
     $base64_credentials = base64_encode("$username:$password");
        $url = get_site_url() . '/wp-json/wp/v2/users/'.$user_id;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_POST, 1 );
curl_setopt($ch, CURLOPT_POSTFIELDS,'
    {
        "acf" : {
                  "profile_img" :'.$imageId.'
        }  
    }',);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
   // 'Authorization: Basic ZmFsbG91Lm5kaWF5ZTk1QHVuaXYtdGhpZXMuc246TGl2ZWxlQHJuMjAyNA==',
   // local
'Authorization: Basic bmlhc3Nzc25AZ21haWwuY29tOnI4UiU5UGwmb3RDbW5td0o=',
    'Content-Type:application/json;charset=UTF-8'
]);
$result = curl_exec($ch);

       if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }
       curl_close($ch);
        // Output the result
       if (isset($error_msg)) {
           
           echo 'Response: ' .$error_msg;
        } else {
            // update_field('profile_img', $imageId, 'user_' . $user_id);
             echo "<span class='alert alert-success'>User created successfully! ✔️</span>";
        }
        }
}
    }
 }
?>