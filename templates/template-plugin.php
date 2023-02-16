<?php /** Template Name: Get & Save Artikles*/?>

<?php
global $wpdb;

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
  error_reporting(E_WARNING);
  // $url="https://www.winelife.nl/";
  $websites=[
      'https://workplaceacademy.nl/',
      'https://www.ynno.com/',
      'https://powerplant.nl/',
      'https://www.dezzp.nl/',
      'https://www.aestate.nl/',
      'https://albaconcepts.nl/',
      'https://www.am.nl/',
      'https://limoonworks.nl/',
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
      'https://www.cryptouniversity.nl/'//,
      // 'https://www.winelife.nl/',
      // 'https://perswijn.nl/',
      // 'https://www.kokenmetkennis.nl/',
      // 'https://minkowski.org/',
      // 'https://kitpublishers.nl/',
      // 'https://www.betastoelen.nl/',
      // 'https://zooi.nl/',
      // 'https://www.growthfactory.nl/',
      // 'https://influid.nl/',
      // 'https://mediatest.nl/',
      // 'https://memo2.nl/',
      // 'https://impact-investor.com/',
      // 'https://www.equalture.com/',
      // 'https://zorgmasters.nl/',
      // 'https://adsysco.nl/',
      // 'https://www.tln.nl/',
      // 'https://www.financieelfit.nl/',
      // 'https://www.businessinsider.nl/',
      // 'https://www.frankwatching.com/',
      // 'https://martech.org/',
      // 'https://www.searchenginejournal.com/',
      // 'https://www.entrepreneur.com/',
      // 'https://searchengineland.com/',
      // 'https://techcrunch.com/',
      // 'https://magazine.thebrunoeffect.com/',
      // 'https://www.crypto-insiders.nl/',
      // 'https://happyhealthy.nl/',
      // 'https://focusmagazine.nl/',
      // 'https://www.chipfotomagazine.nl/',
      // 'https://www.vogue.nl/',
      // 'https://www.trendystyle.net/',
      // 'https://wwd.com/',
      // 'https://www.purseblog.com/',
      // 'https://blog.coursera.org/',
      // 'https://blog.udemy.com/',
      // 'https://blog.checkpoint.com/',
      // 'https://www.delaatstemeter.nl/',
      // 'https://www.managementpro.nl/',
      // 'https://www.1minutemanager.nl/',
      // 'https://www.strafschop.nl/',
      // 'https://www.jongebazen.nl/',
      // 'https://www.expeditieduurzaam.nl/',
      // 'https://pureluxe.nl/',
      // 'https://www.watchtime.com/',
      // 'https://monochrome-watches.com/',
      // 'https://www.literairnederland.nl/',
      // 'https://www.tzum.info/',
      // 'https://www.developer-tech.com/',
      // 'https://sdtimes.com/',
      // 'https://www.godaddy.com/garage/',
      // 'https://www.bouwwereld.nl/',
      // 'https://vastgoedactueel.nl/',
      // 'https://therealdeal.com/',
      // 'https://www.housingwire.com/',
      // 'https://aftersalesmagazine.nl/',
      // 'https://crsconsultants.nl/'
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
    'Crypto university'//,
    // 'WineLife',
    // 'Perswijn',
    // 'Koken met Kennis',
    // 'Minkowski',
    // 'KIT publishers',
    // 'BeByBeta',
    // 'Zooi',
    // 'Growth Factory',
    // 'Influid',
    // 'MediaTest',
    // 'MeMo2',
    // 'Impact Investor',
    // 'Equalture',
    // 'Zorgmasters',
    // 'AdSysco',
    // 'Transport en Logistiek Nederland',
    // 'Financieel Fit',
    // 'Business Insider',
    // 'Frankwatching',
    // 'MarTech',
    // 'Search Engine Journal',
    // 'Entrepreneur Media',
    // 'Search Engine Land',
    // 'TechCrunch',
    // 'The Bruno Effect',
    // 'Crypto Insiders',
    // 'HappyHealth',
    // 'Focus',
    // 'Chip Foto Magazine',
    // 'Vogue',
    // 'TrendyStyle',
    // 'WWD',
    // 'Purse Blog',
    // 'Coursera',
    // 'Udemy',
    // 'CheckPoint',
    // 'De laatste meter',
    // 'ManagementSite',
    // '1 Minute Manager',
    // 'De Strafschop',
    // 'JongeBazen',
    // 'Expeditie Duurzaam',
    // 'Pure Luxe',
    // 'WatchTime',
    // 'Monochrome',
    // 'Literair Nederland',
    // 'Tzum',
    // 'Developer',
    // 'SD Times',
    // 'GoDaddy',
    // 'Bouw Wereld',
    // 'Vastgoed actueel',
    // 'The Real Deal',
    // 'HousingWire',
    // 'AfterSales',
    // 'CRS Consulting'
  ];
  $users = get_users();
  $args = array(
      'post_type' => 'company', 
      'posts_per_page' => -1,
  );
  $companies = get_posts($args);
  $i=0;
  foreach($websites as $key => $url){
    $company_name = $api_company_name[$key];
    $author_id = null;

    foreach($companies as $companie) 
      if($companie->post_title == $company_name)
        $company = $companie;

    foreach($users as $user) {
      $company_user = get_field('company',  'user_' . $user->ID);

      if(isset($company_user[0]->post_title)) 
        if(strtolower($company_user[0]->post_title) == strtolower($company_name) ){
          $author_id = $user->ID;
          $company = $company_user[0];
          $company_id = $company_user[0]->ID;
        }
    }
    
    if(!$author_id)
    {
      $login = RandomString();
      $password = RandomString();
      $random = RandomString();
      $email = "author_" . $random . "@" . $api_company_name[$key] . ".nl";
      $first_name = explode(' ', $api_company_name[$key])[0];
      $last_name = isset(explode(' ', $api_company_name[$key])[1])?explode(' ', $api_company_name[$key])[1]:'';

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

    $span  = $url . "wp-json/wp/v2/posts/";
    $artikels= json_decode(file_get_contents($span),true);
    $onderwerpen='';
    foreach($artikels as $article){
      echo($i);
      $i++;
      if ($article!=null) {
        $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank where titel=%s and type=%s",array($article['title']['rendered'],'Artikel'));
        $result_title = $wpdb->get_results($sql_title);
        $span2 = $url."wp-json/wp/v2/media/".$article['featured_media'];
        if($article['featured_media']!=0){
          
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
                'long_description' => $article['content']['rendered'],
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
                'long_description' => $article['content']['rendered'],
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
              'long_description' => $article['content']['rendered'],
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
        // var_dump($data);
        $wpdb->insert($table,$data);
        $id_post = $wpdb->insert_id;
      }
    }
  }
?>   
