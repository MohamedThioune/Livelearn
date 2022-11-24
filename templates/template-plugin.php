<?php /** Template Name: Get & Save Artikles*/?>

<?php
global $wpdb;

function RandomString(){
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randstring = '';
  for ($i = 0; $i < 10; $i++) {
      $rand = $characters[rand(0, strlen($characters))];
      $randstring .= $rand;  
  }
  return $randstring;
}
    error_reporting(E_WARNING);
    // $url="https://www.winelife.nl/";
    $websites=[
        'https://workplaceacademy.nl/',
        // 'https://www.ynno.com/',
        'https://powerplant.nl/',
        'https://www.dezzp.nl/',
        'https://www.aestate.nl/',
        'https://albaconcepts.nl/',
        'https://www.am.nl/',
        'https://limoonworks.nl/',
        'https://breedweer.nl/',
        'https://www.dwa.nl/',
        'https://www.vanspaendonck.nl/',
        'https://ptg-advies.nl/',
        'https://rever.nl/',
        'https://www.reworc.com/',
        'https://www.sweco.nl/',
        'https://www.copilot.nl/',
        'https://agilescrumgroup.nl/',
        'https://horizontraining.nl/',
        'https://www.kennethsmit.com/',
        'https://www.autoblog.nl/',
        'https://www.cryptouniversity.nl/',
        // 'https://www.winelife.nl/',
        // 'https://perswijn.nl/',
        // 'https://www.kokenmetkennis.nl/',
        // 'https://minkowski.org/',
        // 'https://kitpublishers.nl/',
        // 'https://www.betastoelen.nl/',
        // 'https://zooi.nl/',
        'https://www.growthfactory.nl/',
        'https://influid.nl/'
        // 'https://mediatest.nl/',
        // 'https://memo2.nl/',
        // 'https://impact-investor.com/',
        // 'https://www.equalture.com/',
        // 'https://zorgmasters.nl/',
        // 'https://adsysco.nl/'
    ];
    $table = $wpdb->prefix.'databank';
    
    $company = null;
    $api_company_name = [
      'WorkPlace Academy',
      'Ynno',
      'PowerPlant',
      'DeZZP',
      'Aestate',
      'Alba Concepts',
      'AM',
      'Limoonworks',
      'Breedweer',
      'DWA',
      'Van Spaendonck',
      'PTG-advies',
      'Rever',
      'Reworc',
      'Sweco',
      'Co-pilot',
      'Agile Scrum Group',
      'Horizon',
      'Kenneth Smit',
      'Autoblog',
      'Crypto university',
      // 'WineLife',
      // 'Perswijn',
      // 'Koken met Kennis',
      // 'Minkowski',
      // 'KIT publishers',
      // 'Be by Beta', 
      // 'Zooi',
      'Growth Factory',
      'Influid'
      // 'MediaTest',
      // 'MeMo2',
      // 'Equalture',
      // 'Impact Investor',
      // 'Zorgmasters',
      // 'AdSysco'  
    ];
    foreach($websites as $key=>$url){
      $users = get_users();
      $company_name= $api_company_name[$key];
      // var_dump($company_name);
      // break;
      // $author_id=0;
      // var_dump($company_name);
      foreach($users as $user) {
        $company_user = get_field('company',  'user_' . $user->ID);

        if(strtolower($company_user[0]->post_title) == strtolower($company_name) ){
          $author_id = $user->ID;
          $company = $company_user[0];
          $company_id = $company_user[0]->ID;
        }

          if(!$author_id)
          {
          $i=0;
          // foreach($api_company_name as $value) 
              // strval($websites[$i]);
          if(strtolower($key->post_title) == $websites[$i]){
            // var_dump($websites[$i]);
            $company = $key;
            $company_id = $value->ID;
            $i++;
            break;
          }
          // var_dump($company);
        }
      }
      // var_dump($user);
      if(!$author_id)
      {
        if(strtolower($key->post_title) == $websites[$i]){
          // var_dump($websites[$i]);
          $company = $key;
          $company_id = $value->ID;      
        }
  
        $login = RandomString();
        $password = RandomString();
        $random = RandomString();
        $email = "author_" . $api_company_name[$i] . $random . "@expertise.nl";
        $first_name = explode(' ', $api_company_name[$i])[0];
        $last_name = explode(' ', $api_company_name[$i])[1];
  
        $userdata = array(
            'user_pass' => $password,
            'user_login' => $login,
            'user_email' => $email,
            'user_url' => 'https://livelearn.nl/inloggen/',
            'display_name' => $first_name,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role' => 'teacher'
        );
        // var_dump($userdata);
        $author_id = wp_insert_user(wp_slash($userdata));       
      }
      
      $author=get_user_by("ID",$author_id);
      // var_dump($author);
  
      //Accord the author a company
      if(!is_wp_error($author_id))
        update_field('company', $company, 'user_' . $author_id);
        $span  = $url."wp-json/wp/v2/posts/";
        $artikels= json_decode(file_get_contents($span),true);
        // var_dump($artikels);
        // echo($url);
        foreach($artikels as $article){
            $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s AND type = %s", array($images['guid']['url'], 'Artikel'));
            $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank where titel=%s and type=%s",array($article['title']['rendered'],'Artikel'));

            $result_image = $wpdb->get_results($sql_image);
            $result_title = $wpdb->get_results($sql_title);

            if(!isset($result_image[0]) && !isset($result_title[0]))
            {
                // var_dump($article['featured_media']);
                
                $status = 'extern';
                if ($article['featured_media']!= 0 || $article['feature_media']!=null) {
                    $span2 = $url."wp-json/wp/v2/media/".$article['featured_media'];
                    $images=json_decode(file_get_contents($span2),true);
                    $data = array(
                        'titel' => strip_tags($article['title']['rendered']),
                        'type' => 'Artikel',
                        'videos' => NULL, 
                        'short_description' => trim(strip_tags($article['excerpt']['rendered'])),
                        'long_description' => trim(strip_tags($article['content']['rendered'])),
                        'duration' => NULL, 
                        'prijs' => 0, 
                        'prijs_vat' => 0,
                        'image_xml' => $images['guid']['rendered'], 
                        'onderwerpen' => '', 
                        'date_multiple' =>  NULL, 
                        'course_id' => null,
                        'author_id' => $author_id,
                        'company_id' =>  $company_id,
                        'contributors' => null, 
                        'status' => $status
                    );
                }else{
                    $data = array(
                        'titel' => $article['title']['rendered'],
                        'type' => 'Artikel',
                        'videos' => NULL, 
                        'short_description' => trim(strips_tags($article['excerpt']['rendered'])),
                        'long_description' => trim(strip_tags($article['content']['rendered'])),
                        'duration' => NULL, 
                        'prijs' => 0, 
                        'prijs_vat' => 0,
                        'image_xml' => null, 
                        'onderwerpen' => '', 
                        'date_multiple' =>  NULL, 
                        'course_id' => null,
                        'author_id' => $author_id,
                        'company_id' =>  $company_id,
                        'contributors' => null,
                        'status' => $status
                    );
                }
                $wpdb->insert($table,$data);
                $id_post = $wpdb->insert_id;
            }else{
                continue;
            }
            // var_dump($data);
        }
        // header('location: /databank');
    }
?>