<?php

function addAuthor($users){
    
$urls =
[
    'WorkPlace Academy' => 'https://workplaceacademy.nl/',
    'Ynno' => 'https://www.ynno.com/',
    // 'DeZZP'=>'https://www.dezzp.nl/',
    'Aestate' => 'https://www.aestate.nl/',
    'Alba Concepts' => 'https://albaconcepts.nl/',
    'AM' => 'https://www.am.nl/',
    'Limoonworks' => 'https://limoonworks.nl/',
    'DWA' => 'https://www.dwa.nl/',
    'Van Spaendonck' => 'https://www.vanspaendonck.nl/',
    'PTG-advies' => 'https://ptg-advies.nl/',
    'Rever' => 'https://rever.nl/',
    'Reworc' => 'https://www.reworc.com/',
    'Sweco' => 'https://www.sweco.nl/',
    'Co-pilot' => 'https://www.copilot.nl/',
    'Agile Scrum Group' => 'https://agilescrumgroup.nl/',
    'Horizon' => 'https://horizontraining.nl/',
    'Kenneth Smit' => 'https://www.kennethsmit.com/',
    'Autoblog' => 'https://www.autoblog.nl/',
    'Crypto university' => 'https://www.cryptouniversity.nl/',
    'WineLife' => 'https://www.winelife.nl/',
    'Perswijn' => 'https://perswijn.nl/',
    'Koken met Kennis' => 'https://www.kokenmetkennis.nl/',
    'Minkowski' => 'https://minkowski.org/',
    'KIT publishers' => 'https://kitpublishers.nl/',
    'BeByBeta' => 'https://www.betastoelen.nl/',
    'Zooi' => 'https://zooi.nl/',
    'Growth Factory' => 'https://www.growthfactory.nl/',
    'Influid' => 'https://influid.nl/',
    'MediaTest' => 'https://mediatest.nl/',
    'MeMo2' => 'https://memo2.nl/',
    'Impact Investor' => 'https://impact-investor.com/',
    'Equalture' => 'https://www.equalture.com/',
    'Zorgmasters' => 'https://zorgmasters.nl/',
    'AdSysco' => 'https://adsysco.nl/',
    'Transport en Logistiek Nederland' => 'https://www.tln.nl/',
    'Financieel Fit' => 'https://www.financieelfit.nl/',
    'Business Insider' => 'https://www.businessinsider.nl/',
    'Frankwatching' => 'https://www.frankwatching.com/',
    'MarTech' => 'https://martech.org/',
    'Search Engine Journal' => 'https://www.searchenginejournal.com/',
    'Search Engine Land' => 'https://searchengineland.com/',
    'TechCrunch' => 'https://techcrunch.com/',
    'The Bruno Effect' => 'https://magazine.thebrunoeffect.com/',
    'Crypto Insiders' => 'https://www.crypto-insiders.nl/',
    'HappyHealth' => 'https://happyhealthy.nl/',
    'Focus' => 'https://focusmagazine.nl/',
    'Chip Foto Magazine' => 'https://www.chipfotomagazine.nl/',
    'Vogue' => 'https://www.vogue.nl/',
    'TrendyStyle' => 'https://www.trendystyle.net/',
    'WWD' => 'https://wwd.com/',
    'Purse Blog' => 'https://www.purseblog.com/',
    'Coursera' => 'https://blog.coursera.org/',
    'Udemy' => 'https://blog.udemy.com/',
    'CheckPoint' => 'https://blog.checkpoint.com/',
    'De laatste meter' => 'https://www.delaatstemeter.nl/',
    'ManagementSite' => 'https://www.managementpro.nl/',
    '1 Minute Manager' => 'https://www.1minutemanager.nl/',
    'De Strafschop' => 'https://www.strafschop.nl/',
    'JongeBazen' => 'https://www.jongebazen.nl/',
    'Expeditie Duurzaam' => 'https://www.expeditieduurzaam.nl/',
    'Pure Luxe' => 'https://pureluxe.nl/',
    'WatchTime' => 'https://www.watchtime.com/',
    'Monochrome' => 'https://monochrome-watches.com/',
    'Literair Nederland' => 'https://www.literairnederland.nl/',
    'Tzum' => 'https://www.tzum.info/',
    'Developer' => 'https://www.developer-tech.com/',
    'SD Times' => 'https://sdtimes.com/',
    'GoDaddy' => 'https://www.godaddy.com/garage/',
    'Bouw Wereld' => 'https://www.bouwwereld.nl/',
    'Vastgoed actueel' => 'https://vastgoedactueel.nl/',
    'The Real Deal' => 'https://therealdeal.com/',
    'HousingWire' => 'https://www.housingwire.com/',
    'AfterSales' => 'https://aftersalesmagazine.nl/',
    'CRS Consulting' => 'https://crsconsultants.nl/',
    'Commercial Construction & Renovation' => 'https://www.ccr-mag.com/',
    'Training Magazine' => 'https://www.trainingmag.com/',
    'MedCity News' => 'https://www.medcitynews.com/',
    'Cocktail Enthusiast' => 'https://www.cocktailenthusiast.com/',
    'Mr. Online' => 'https://www.mronline.nl/',
    'Cash' => 'https://www.cash.nl/',
    'Kookles thuis' => 'https://www.kooklesthuis.com/',
    'Mediabistro' => 'https://www.mediabistro.com/',
    'ProBlogger' => 'https://problogger.com/',
    'Media Shift' => 'https://www.mediashift.org/',
    'Warehouse Totaal' => 'https://www.warehousetotaal.nl/',
    'CS digital' => 'https://csdm.online/',
    'Analytics Insight' => 'https://www.analyticsinsight.net/',
    'Wissenraet' => 'https://www.vanspaendonck-wispa.nl/',
    '9to5Mac' => 'https://9to5mac.com/',
    'Invest International' => 'https://investinternational.nl/',
    'Racefiets Blog' => 'https://racefietsblog.nl/',
    'Darts actueel' => 'https://www.dartsactueel.nl/',
    'Hockey.nl' => 'https://hockey.nl/',
    'Hockeykrant' => 'https://hockeykrant.nl/',
    'Tata Nexarc' => 'https://blog.tatanexarc.com/',
    'Incodocs' => 'https://incodocs.com/blog/',
    'Recruitement Tech' => 'https://www.recruitmenttech.nl/',
    'Healthcare Weekly' => 'https://healthcareweekly.com/',
    'Wellness Mama' => 'https://wellnessmama.com/',
    'Logistics Business' => 'https://www.logisticsbusiness.com/',
    '20Cube' => 'https://www.20cube.com/',
    'Outside' => 'https://velo.outsideonline.com/',
    'Trainer Road' => 'https://www.trainerroad.com/blog/',
    'AllOver Media' => 'https://allovermedia.com/',
    'The Partially Examined Life' => 'https://partiallyexaminedlife.com/',
    'The Future Organization' => 'https://thefutureorganization.com/',
    'Arts en Auto' => 'https://www.artsenauto.nl/',
    'Discutafel' => 'https://discutafel.nl/',
    'SBVO' => 'https://sbvo.nl/',
    'Your EDM' => 'https://www.youredm.com/',
    'Metal Injection' => 'https://metalinjection.net/',
    'Classical Music' => 'https://www.classical-music.com/',
    'Slipped Disc' => 'https://slippedisc.com/',
    'The Violin Channel' => 'https://www.theviolinchannel.com/',
    'Carey Nieuwhof' => 'https://careynieuwhof.com/',
    'Monday.com'=>'https://monday.com/blog/',
    'Fresh'=>'https://www.stichtingfresh.nl/',
    'Werf'=>'https://www.werf-en.nl/',
    'HR Knowledge'=>'https://www.hrknowledge.com/',
    'HRcommunity'=>'https://hrcommunity.nl/',
    'Leeuwendaal'=>'https://www.leeuwendaal.nl/',
    'Samhoud'=>'https://www.samhoudconsultancy.com/',
    'Incontext'=>'https://incontext.nl/',
    'Successday'=>'https://successday.nl/',
    'Hospitality Group'=>'https://www.hospitality-group.nl/',
    'AllChiefs'=>'https://allchiefs.nl/',
    'BTS'=>'https://bts.com/',
    'Fakton'=>'https://www.fakton.com/',
    'bbn'=>'https://bbn.nl/',
    'Over morgen'=>'https://overmorgen.nl/',
    'Beaufort'=>'https://www.beaufortconsulting.nl/',
    'Redept'=>'https://redept.nl/',
    'Akro'=>'https://akroconsult.nl/',
    'AT osborne'=>'https://atosborne.nl/',
    'Brink'=>'https://www.brink.nl/',
    'Magnus Digital'=>'https://www.magnus.nl/',
    'Lybrae'=>'https://lybrae.nl/',
    'HKA'=>'https://www.hka.com/',
    'Flux Partners'=>'https://flux.partners/',
    'TWST'=>'https://www.twst.nl/',
    'Contakt'=>'https://contakt.nl/',
    'Group Mapping'=>'https://groupmapping.org/',
    'The house of Marketing'=>'https://thom.eu/',
    'PPMC'=>'https://ppmc.nl/',
    'Newcraft'=>'https://newcraftgroup.com/',
    'The Next Organization'=>'https://thenextorganization.com/',
    'Salveos'=>'https://salveos.nl/',
    'MLC'=>'https://m-lc.nl/',
    'Artefact'=>'https://www.artefact.com/'
];
  
        $key='';
        $author_id=0;
      foreach ($users as $user) {
      $company_users = get_field('company', 'user_' . $user->ID);
      if(isset($company_users)){
                      
          $company_user=$company_users[0];
         
          foreach ($urls as $keyurl => $url) {
               $key=$keyurl;
            if (isset($company_user->post_title) && strtolower($company_user->post_title) == strtolower($key)) { 
                $author_id = $user->ID;
                $company = $company_user;
                $company_id = $company_user->ID;

                break 2;
          }
        
          }
         
            
      }
      
      
  }
  if ($author_id == 0) {
    

      // Look for company
      $company = get_page_by_path($key, OBJECT, 'company');
      if(!$company){
       // Creating new company
        $argv = array(
            "post_type" => "company",
            "post_title" => $key,
            "post_status"=> "publish"
        );
        $company_id = wp_insert_post($argv);
        $company = get_post($company_id);
    }
    
      $login = 'user' . random_int(0, 100000);
      $password = "pass" . random_int(0, 100000);
      $email = "author_" . $key . "@" . 'livelearn' . ".nl";
      $first_name = explode(' ', $key)[0];
      $last_name = isset(explode(' ', $key)[1]) ? explode(' ', $key)[1] : '';
  
      $userdata = array(
          'user_pass' => $password,
          'user_login' => $login,
          'user_email' => $email,
          'user_url' => 'https://livelearn.nl/inloggen/',
          'display_name' => $first_name,
          'first_name' => $first_name,
          'last_name' => $last_name,
          'role' => 'author',
      );
      
      // Insert new user
     $author_id = wp_insert_user(wp_slash($userdata));
  
      // Associate user with company
      if (!is_wp_error($author_id)) {
         update_field('company', $company, 'user_' . $author_id);
      }
      
     
  }
  return $author_id;
  
  
  
  }
  ?>
