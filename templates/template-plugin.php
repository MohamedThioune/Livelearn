<?php /** Template Name: Get & Save Artikles*/?>

<?php
global $wpdb;

extract($_POST);

function RandomString(){
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randstring = '';
  $rand='';
  for ($i = 0; $i < 10; $i++) {
      $rand = $characters[rand(0, strlen($characters))];
      $randstring .= $rand;  
  }
  return $randstring;
} 

  function strip_html_tags($text) {
    $allowed_tags = ['h2', 'br','strong','em','u','blockquote','ul','ol','li'];
    $text = preg_replace("/\n{1,}/", "\n", $text); 
    $text = str_replace("\n","<br>",$text);
    $text = str_replace(['h1','h3','h4','h5','h6'],'h2',$text);
    $pattern = '/<(?!\/?(?:' . implode('|', $allowed_tags) . ')\b)[^>]*>/';
    return preg_replace($pattern, '', $text);
  } 

  $table = $wpdb->prefix.'databank';
  
  $users = get_users();
  $args = array(
      'post_type' => 'company', 
      'posts_per_page' => -1,
  );
  $companies = get_posts($args);

  if(isset($selectedValues)) {
    // var_dump($selectedValues);
    foreach($selectedValues as $option) {
      $website = $option['value'];
      $key = $option['text'];
      
      foreach($companies as $companie){
        $company = null;
        if(strtolower($companie->post_title) == strtolower($key)){
          $company = $companie;
        }else
          continue;

        foreach($users as $user) {
          $company_user = get_field('company',  'user_' . $user->ID);

          if(isset($company_user[0]->post_title)) 
            if(strtolower($company_user[0]->post_title) == strtolower($key) ){
              $author_id = $user->ID;
              $company = $company_user[0];
              $company_id = $company_user[0]->ID;
            }
        }
      }

      if(!$author_id)
      {
        $login = RandomString();
        $password = RandomString();
        $random = RandomString();
        $email = "author_" . $random . "@" . $key . ".nl";
        $first_name = explode(' ', $key)[0];
        $last_name = isset(explode(' ', $key)[1])?explode(' ', $key)[1]:'';

        $userdata = array(
          'user_pass' => $password,
          'user_login' => $login,
          'user_email' => $email,
          'user_url' => 'https://livelearn.nl/inloggen/',
          'display_name' => $first_name,
          'first_name' => $first_name,
          'last_name' => $last_name,
          'role' => 'author' 
        );

        $author_id = wp_insert_user(wp_slash($userdata));       
      }

      //Accord the author a company
      if(!is_wp_error($author_id))
        update_field('company', $company, 'user_' . $author_id);

      $span  = $website . "wp-json/wp/v2/posts/";
      $artikels= json_decode(file_get_contents($span),true);
      foreach($artikels as $article){
        if ($article!=null) {
          $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank where titel=%s and type=%s",array($article['title']['rendered'],'Artikel'));
          $result_title = $wpdb->get_results($sql_title);
          if($article['featured_media']!=0){
            $span2 = $website."wp-json/wp/v2/media/".$article['featured_media'];          
            $images=json_decode(file_get_contents($span2),true);
            $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s AND type = %s", array($images['guid']['rendered'], 'Artikel'));
            $result_image = $wpdb->get_results($sql_image);
            if(!isset($result_image[0]) && !isset($result_title[0]))
            {
              if (!isset($images['data']['status']) && $images['data']['status']!=404 && $images['data']['status']!=401) {
                $status = 'extern';
                $data = array(
                  'titel' => $article['title']['rendered'],
                  'type' => 'Artikel',
                  'videos' => NULL, 
                  'short_description' => $article['excerpt']['rendered'],
                  'long_description' => htmlspecialchars(strip_html_tags($article['content']['rendered'])),
                  'duration' => NULL, 
                  'prijs' => 0, 
                  'prijs_vat' => 0,
                  'image_xml' => $images['guid']['rendered'], 
                  'onderwerpen' => $onderwerpen, 
                  'date_multiple' =>  NULL, 
                  'course_id' => null,
                  'author_id' => $author_id,
                  'company_id' =>  $company_id,
                  'contributors' => null, 
                  'status' => $status
                );
              }else {
                $status = 'extern';
                $data = array(
                  'titel' => $article['title']['rendered'],
                  'type' => 'Artikel',
                  'videos' => NULL, 
                  'short_description' => $article['excerpt']['rendered'],
                  'long_description' => htmlspecialchars(strip_html_tags($article['content']['rendered'])),
                  'duration' => NULL, 
                  'prijs' => 0, 
                  'prijs_vat' => 0,
                  'image_xml' => null, 
                  'onderwerpen' => $onderwerpen, 
                  'date_multiple' =>  NULL, 
                  'course_id' => null,
                  'author_id' => $author_id,
                  'company_id' =>  $company_id,
                  'contributors' => null, 
                  'status' => $status
                );
              }
            }
          }else{
            if(!isset($result_title[0]) )
            {
              $status = 'extern';
              $data = array(
                'titel' => $article['title']['rendered'],
                'type' => 'Artikel',
                'videos' => NULL, 
                'short_description' => $article['excerpt']['rendered'],
                'long_description' => htmlspecialchars(strip_html_tags($article['content']['rendered'])),
                'duration' => NULL,
                'prijs' => 0,
                'prijs_vat' => 0,
                'image_xml' => null,
                'onderwerpen' => $onderwerpen,
                'date_multiple' =>  NULL,
                'course_id' => null,
                'author_id' => $author_id,
                'company_id' =>  $company_id,
                'contributors' => null,
                'status' => $status
              );
            }
          }
          // echo "Selected option: $text (value=$value)<br>";
          try
          {
            $wpdb->insert($table,$data);
            // echo $key."  ".$wpdb->last_error."<br>";
            $id_post = $wpdb->insert_id;
            
          }catch(Exception $e) {
            echo $e->getMessage();
          }
        }
      }
    }
  }
  // header("location:/livelearn/databank");
?>   