<?php /** Template Name: Save Author and Compagny */ ?>

<?php
require_once 'add-author.php';
require_once 'upload.php';

if (isset($_POST['connect_authortoCourse']) && !empty($_POST['connect_authortoCourse']) && $_POST['action'] == 'connect_authortoCourse') 
{ 

  
        $author_ids = array_map('intval', $_POST['connect_authortoCourse']);

       

        $course_id  = intval($_POST['id_course']);

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
      $author_id = generatorAuthor($company_name);
    
        // Associate user with company
        if(!is_wp_error($author_id)) 
           update_field('company', $company, 'user_' . $author_id);

    // Optionally handle company logo upload
    if (!empty($_FILES['company_logo']['name'])) {
        // Handle file upload
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $attachment_id = media_handle_upload('company_logo', $company_id);

        if (is_wp_error($attachment_id)) {

            echo "<span class='alert alert-danger'>Error uploading image " . $attachment_id->get_error_message() .  "❌</span>";
            die();
        }

        // Set the logo as the post thumbnail
        set_post_thumbnail($company_id, $attachment_id);
    }

    // Save additional custom fields
    update_post_meta($company_id, 'company_country', $company_country);
    update_post_meta($company_id, 'company_city', $company_city);
    update_post_meta($company_id, 'company_address', $company_address);

    // Return success response
   echo "<span class='alert alert-success'>compagny created successfully! ✔️</span>";
    die();
}
    
}    
 if ($_POST['action'] == 'add_users') 
{  
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

       

        if (isset($_FILES['profile_photo'])) {
        $file = $_FILES['profile_photo'];
                   // $file = $_POST['profile_photo'];

        


          $attachment_id= upload_image_to_media($file);
          //  echo " l'id".$attachment_id;
          echo "<pre>";
        print_r($attachment_id);
        echo "</pre>";

          // Debugging: Print the $_FILES array
       
        

       






          //  echo "if".  $file ;

           

          
                

                // Get the URL of the uploaded image
                // $attachment_url = wp_get_attachment_url($attachment_id);


                // Update the user meta with the attachment ID
                // update_user_meta($user_id, 'profile_img', $attachment_id);
          
                // echo "<span class='alert alert-danger'>Error uploading image ❌</span>";
                // die();
           
        }
       

        // Optionally, update ACF fields if you use ACF for user profiles
        // if (function_exists('update_field')) {
        //     update_field('phone_number', $phone_number, 'user_' . $user_id);
        //     if ($attachment_url) {
        //         update_field('profile_img', $attachment_url, 'user_' . $user_id);
        //     }
        // }
         echo "<span class='alert alert-success'>User created successfully! ✔️</span>";
}


    
       
    }
 }
?>