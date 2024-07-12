<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function upload_image_to_media($file) {
     $url = get_site_url() . '/wp-json/wp/v2/media/';
     $user= wp_get_current_user();
     //$user  = get_user_by('id', 3);
      $username = $user->user_login;
        $password = $user->user_pass;
         $credentials = $username . ':' . $password;

    // Encode credentials to base64
    $base64_credentials = base64_encode($credentials);
   
         
   
    
$fileContent = file_get_contents($file['tmp_name'] );
$url = get_site_url() . '/wp-json/wp/v2/media/';
$ch = curl_init();
 $filename = basename($file['tmp_name']);
 // $base64_credentials =base64_encode($username . ":" . $password);


  $file_content = file_get_contents($file['tmp_name']);
    $filename = basename($file['name']);  // Utilisez le nom d'origine du fichier

    // Construire les données multipart/form-data
    $boundary = wp_generate_password(24);
    $delimiter = '-------------' . $boundary;
    $eol = "\r\n";
    
    $data = "--" . $delimiter . $eol
        . 'Content-Disposition: form-data; name="file"; filename="' . $filename . '"' . $eol
        . 'Content-Type: ' . mime_content_type($file['tmp_name']) . $eol
        . $eol
        . $file_content . $eol
        . "--" . $delimiter . "--" . $eol;

    // Préparer les en-têtes
  

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_POST, 1 );



// curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query(['file'=>$data]));
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_HTTPHEADER, [
    'Content-Disposition: form-data; filename="'.  $filename .'"',
   // 'Authorization: Basic ZmFsbG91Lm5kaWF5ZTk1QHVuaXYtdGhpZXMuc246TGl2ZWxlQHJuMjAyNA==',
   // local
'Authorization: Basic bmlhc3Nzc25AZ21haWwuY29tOnI4UiU5UGwmb3RDbW5td0o=',
    
    'Content-Type: multipart/form-data; boundary=' . $delimiter,
  
] );
$result = curl_exec( $ch );

if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }
       curl_close($ch);
        // Output the result
       if (isset($error_msg)) {
           
            return $error_msg;
        } else {
              
          
           
            //"raw": "http://localhost/livelearn/wp-content/uploads/2024/06/WhatsApp-Image-2024-05-31-a-22.31.54_6a976b2c.jpg"

            
             return json_decode($result,true)['id'];
        }



 }




?>

