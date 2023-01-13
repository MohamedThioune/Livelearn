
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
  // error_reporting(E_WARNING);
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
      'https://www.winelife.nl/',
      'https://perswijn.nl/',
      'https://www.kokenmetkennis.nl/',
      'https://minkowski.org/',
      'https://kitpublishers.nl/',
      'https://www.betastoelen.nl/',
      'https://zooi.nl/',
      'https://www.growthfactory.nl/',
      'https://influid.nl/',
      'https://mediatest.nl/',
      'https://memo2.nl/',
      'https://impact-investor.com/',
      'https://www.equalture.com/',
      'https://zorgmasters.nl/',
      'https://adsysco.nl/',
      'https://www.tln.nl/',
      'https://www.financieelfit.nl/',
      'https://www.businessinsider.nl/',
      'https://www.frankwatching.com/',
      'https://www.adweek.com/',
      'https://martech.org/',
      'https://www.searchenginejournal.com/',
      'https://www.entrepreneur.com/',
      'https://searchengineland.com/',
      'https://techcrunch.com/',
      'https://magazine.thebrunoeffect.com/',
      'https://www.crypto-insiders.nl/',
      'https://happyhealthy.nl/',
      'https://focusmagazine.nl/',
      'https://www.chipfotomagazine.nl/',
      'https://www.vogue.nl/',
      'https://www.trendystyle.net/',
      'https://wwd.com/',
      'https://www.purseblog.com/',
      'https://blog.coursera.org/',
      'https://blog.udemy.com/',
      'https://blog.checkpoint.com/',
      'https://www.delaatstemeter.nl/',
      'https://www.managementpro.nl/',
      'https://www.1minutemanager.nl/',
      'https://www.strafschop.nl/',
      'https://www.jongebazen.nl/',
      'https://www.expeditieduurzaam.nl/',
      'https://pureluxe.nl/',
      'https://www.watchtime.com/',
      'https://monochrome-watches.com/',
      'https://www.literairnederland.nl/',
      'https://www.tzum.info/',
      'https://www.developer-tech.com/',
      'https://sdtimes.com/',
      'https://www.godaddy.com/garage/',
      'https://www.bouwwereld.nl/',
      'https://vastgoedactueel.nl/',
      'https://therealdeal.com/',
      'https://www.housingwire.com/',
      'https://aftersalesmagazine.nl/',
      'https://crsconsultants.nl/'
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
    'WineLife',
    'Perswijn',
    'Koken met Kennis',
    'Minkowski',
    'KIT publishers',
    'Be by Beta', 
    'Zooi',
    'Growth Factory',
    'Influid',
    'MediaTest',
    'MeMo2',
    'Equalture',
    'Impact Investor',
    'Zorgmasters',
    'AdSysco',
    'Transport en logistiek Nederland',
    'Financieel Fit',
    'Business Insider',
    'Frankwatching',
    'Adweek',
    'Martech',
    'Search Engine Journal',
    'Entrepreneur Media',
    'Search Engine Land',
    'TechCrunch',
    'The Bruno Effect',
    'Crypto Insiders',
    'HappyHealth',
    'Focus',
    'Chip Foto Magazine',
    'Vogue',
    'TrendyStyle',
    'WWD',
    'Purse Blog',
    'Coursera',
    'Udemy',
    'CheckPoint',
    'De laatste meter',
    'ManagementSite',
    '1 Minute Manager',
    'De Strafschop',
    'JongeBazen',
    'Expeditie Duurzaam',
    'Pure Luxe',
    'WatchTime',
    'Monochrome',
    'literair Nederland',
    'Tzum',
    'Developer',
    'SD Times',
    'GoDaddy',
    'Bouw Wereld',
    'Vastgoed actueel',
    'The Real Deal',
    'HousingWire',
    'AfterSales',
    'CRS Consulting'
  ];
  foreach($websites as $key=>$url){
    $users = get_users();
    $company_name= $api_company_name[$key];
    
    
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
          if(strtolower($key->post_title) == $websites[$i]){
            var_dump($websites[$i]);
            $company = $key;
            $company_id = $value->ID;
            $i++;
            break;
          }
        }
    }
    
    if(!$author_id)
    {
      if(strtolower($key->post_title) == $websites[$key]){
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

    
    //Accord the author a company
    if(!is_wp_error($author_id))
      update_field('company', $company, 'user_' . $author_id);
    $span  = $url."wp-json/wp/v2/posts/";
    $artikels= json_decode(file_get_contents($span),true);
    
    $onderwerpen='';
    foreach($artikels as $article){
      if ($article!=null) {
        $span2 = $url."wp-json/wp/v2/media/".$article['featured_media'];
        $images=json_decode(file_get_contents($span2),true);
        $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s AND type = %s", array($images['guid']['url'], 'Artikel'));
        $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank where titel=%s and type=%s",array($article['title']['rendered'],'Artikel'));
        
        $result_image = $wpdb->get_results($sql_image);
        $result_title = $wpdb->get_results($sql_title);
        if(!isset($result_image[0]) && !isset($result_title[0]))
        {
          if ($article['featured_media']!= 0 || $article['feature_media']!=null) {
            
            $status = 'extern';
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
                'onderwerpen' => $onderwerpen, 
                'date_multiple' =>  NULL, 
                'course_id' => null,
                'author_id' => $author_id,
                'company_id' =>  $company_id,
                'contributors' => null, 
                'status' => $status
            );
          }else{
            $data = array(
              'titel' => strip_tags($article['title']['rendered']),
              'type' => 'Artikel',
              'videos' => NULL, 
              'short_description' => trim(strip_tags($article['excerpt']['rendered'])),
              'long_description' => trim(strip_tags($article['content']['rendered'])),
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
          // var_dump($data);
          $wpdb->insert($table,$data);
          $id_post = $wpdb->insert_id;
        }
      }
    }
  }
?>