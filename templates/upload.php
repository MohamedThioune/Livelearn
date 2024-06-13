<?php
// function upload_image_to_media($file) {
//     $url = get_site_url().'/wp-json/wp/v2/media/';
//     $user= wp_get_current_user();

// // $image = get_field('profile_img',  'user_' . $user->ID);
// // if(!$image)
// //     $image = get_stylesheet_directory_uri() . '/img/Ellipse17.png';
    
    
//     $username = $user->user_email;
//     $password = $user->user_pass;
//     $base64_credentials = base64_encode("$username:$password");
    

//     $headers = [
//         'Authorization: Basic ' . $base64_credentials,
//         'Content-Disposition: attachment; filename="' . $file['name'] . '"',
//         'Content-Type: application/octet-stream' ];

//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($file['tmp_name']));
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//     $response = curl_exec($ch);
//     if (curl_errno($ch)) {
//         curl_close($ch);
//         return ['error' => curl_error($ch)];
//     }

//     curl_close($ch);
//     $upload_response= json_decode($response, true);
//    $image_id = $upload_response['id'];
//    var_dump($image_id);
//    return $image_id;
    
// }
function upload_image_to_media($file) {
     $url = get_site_url() . '/wp-json/wp/v2/media/';
     $user= wp_get_current_user();
     $user  = get_user_by('ID', 3);
     
    // $username = "mbayamemansor@gmail.com";
    // $password = "hidden"; // Ensure this is securely managed
   $username = $user->user_email;
   $password = $user->user_pass;
    $base64_credentials = base64_encode("$username:$password");
    

    // Prepare headers
    $headers = [
        'Authorization: Basic ' . $base64_credentials,
        'Content-Disposition: attachment; filename="' . $file['name'] . '"',
        'Content-Type: multipart/form-data'
    ];
    
    // Read the file content

    $file_contents = file_get_contents($file['name']);
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $file_contents );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
$result = curl_exec( $ch );
curl_close( $ch );
print_r( json_decode( $result ) );



    // 'file' => new CURLFile($file['tmp_name'], $file['type'], $file['name'])
    

    // Initialize cURL session
   // $curl = curl_init($url);

    // Configuration des options cURL
    // curl_setopt_array($curl, array(
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_POST => true,
    //     CURLOPT_POSTFIELDS => $file_contents,
    //     CURLOPT_HTTPHEADER => $headers,
    //     CURLOPT_SSL_VERIFYHOST => 0,
    //     CURLOPT_SSL_VERIFYPEER => false
    // ));



    // Exécuter la requête cURL
    //$response = curl_exec($curl);

    // Check for errors
//     if (curl_errno($ch)) {
//         $error_msg = curl_error($ch);
//         curl_close($ch);
//         return  $error_msg;
//     }
     
//     //  return "bonne nouvelle";

//     // Close cURL session
//     curl_close($ch);

//     // Decode JSON response
//     return $response;
//     $upload_response = json_decode($response, true);


//     if (isset($upload_response['id'])) {
//         $image_id = $upload_response['id'];
//         return $image_id;
//     } else {
//         return  'Failed to upload image.';
//     }
 }


function uploadFileToWordPress($file) {

  $url = get_site_url() . '/wp-json/wp/v2/media/';
     $user= wp_get_current_user();
     $user  = get_user_by('ID', 3);
     
    // $username = "mbayamemansor@gmail.com";
    // $password = "hidden"; // Ensure this is securely managed
   $email = $user->user_email;
   $password = $user->user_pass;

        // $filePath=$file['tmp_name'];
        // $fileName=$file['name'];
        //  $cfile = new CURLFile($filePath, mime_content_type($filePath), $fileName);
        // return $fileName;
        // return  new CURLFILE('/C:/Users/Fallou/Pictures/Capture VERSION NODE.PNG');


    // Initialize cURL session
    $curl = curl_init();

    // Base64 encode the email and password
    $credentials = base64_encode("$email:$password");
    $filePath = $file['tmp_name'];
   $type=$file['type'];
$fileName = $file['name'];
    
$data = array('file' => curl_file_create($filePath, $type, $fileName));
    

    

    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_POST => true,
        


        CURLOPT_POSTFIELDS =>$data,
        CURLOPT_HTTPHEADER => [
            "Authorization: Basic $credentials",
            'Content-Type: multipart/form-data'
        ],
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => false
    ));
    

    // Execute cURL request and get the response
    $response = curl_exec($curl);

    // Check for errors
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }

    // Close cURL session
    curl_close($curl);

   // Handle errors
    if (isset($error_msg)) {
        return "cURL Error: $error_msg";
    }
    echo $response;

   $upload_response= json_decode($response, true);
//    $image_id = $upload_response['id'];
//    var_dump($image_id);
   return $upload_response;
}

// Usage example
$filePath = '/C:/Users/Fallou/Pictures/Capture VERSION NODE.PNG';



?>

