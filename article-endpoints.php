<?php
require_once 'templates/add-author.php';
require_once 'templates/detect-language.php';
/** Artikels Endpoints */
$GLOBALS['user_id'] = get_current_user_id();

function RandomDoubleString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 10; $i++) {
        $rand = $characters[rand(0, strlen($characters))]; 
        $randstring .= $rand;
    }
    return $randstring;
}

function strip_html_tags($text)
{
  $allowed_tags = ['h2', 'br', 'strong', 'em', 'u', 'blockquote', 'ul', 'ol', 'li', 'img', 'mark'];
  $text = preg_replace("/\n{1,}/", "\n", $text);
  $text = str_replace("\n", "<br>", $text);
  $text = str_replace("&lt;", "<", $text);
  $text = str_replace("&gt;", ">", $text);
  $text = str_replace("&#8216;", "`", $text);
  $text = str_replace("&#8217;", "`", $text);
  $text = str_replace("&#8220;", "\"", $text);
  $text = str_replace("&#8221;", "\"", $text);
  $text = str_replace("&#8230;", "...", $text);
  $text = str_replace(['h1', 'h3', 'h4', 'h5', 'h6'], 'h2', $text);
  $pattern = '/<(?!\/?(?:' . implode('|', $allowed_tags) . ')\b)[^>]*>/';

  return preg_replace($pattern, '', $text);
}

function Artikel_From_Company($data)
{
    global $wpdb;

    $list = array();
    $datas = array();

    $data_insert=0;

    //fix data table
    $table = $wpdb->prefix . 'databank';
    //Get all users
    $users = get_users();

    $list_company = [
      [
        'WorkPlace Academy' => 'https://workplaceacademy.nl/',
        'Ynno' => 'https://www.ynno.com/',
        'DeZZP' => 'https://www.dezzp.nl/',
        'Aestate' => 'https://www.aestate.nl/',
        'Alba Concepts' => 'https://albaconcepts.nl/',
        'AM' => 'https://www.am.nl/',
        'DWA' => 'https://www.dwa.nl/',
        'Van Spaendonck' => 'https://www.vanspaendonck.nl/',
        'PTG-advies' => 'https://ptg-advies.nl/',
        'Rever' => 'https://rever.nl/'
      ],
      [
        'Reworc' => 'https://www.reworc.com/',
        'Sweco' => 'https://www.sweco.nl/',
        'Co-pilot' => 'https://www.copilot.nl/',
        'Agile Scrum Group' => 'https://agilescrumgroup.nl/',
        'Horizon' => 'https://horizontraining.nl/',
        'Kenneth Smit' => 'https://www.kennethsmit.com/',
        'Autoblog' => 'https://www.autoblog.nl/',
        'Crypto university' => 'https://www.cryptouniversity.nl/',
        'WineLife' => 'https://www.winelife.nl/',
        'Perswijn' => 'https://perswijn.nl/'
      ],
      [
        'Koken met Kennis' => 'https://www.kokenmetkennis.nl/',
        'KIT publishers' => 'https://kitpublishers.nl/',
        'BeByBeta' => 'https://www.betastoelen.nl/',
        'Zooi' => 'https://zooi.nl/',
        'Growth Factory' => 'https://www.growthfactory.nl/',
        'Influid' => 'https://influid.nl/',
        'MediaTest' => 'https://mediatest.nl/',
        'MeMo2' => 'https://memo2.nl/',
        'Impact Investor' => 'https://impact-investor.com/',
        'Equalture' => 'https://www.equalture.com/'
      ],
      [
        'Zorgmasters' => 'https://zorgmasters.nl/',
        'AdSysco' => 'https://adsysco.nl/',
        'Transport en Logistiek Nederland' => 'https://www.tln.nl/',
        'Financieel Fit' => 'https://www.financieelfit.nl/',
        'Business Insider' => 'https://www.businessinsider.nl/',
        'Frankwatching' => 'https://www.frankwatching.com/',
        'Search Engine Journal' => 'https://www.searchenginejournal.com/',
        'TechCrunch' => 'https://techcrunch.com/',
        'The Bruno Effect' => 'https://magazine.thebrunoeffect.com/',
        'Crypto Insiders' => 'https://www.crypto-insiders.nl/'
      ],
      [
        'HappyHealth' => 'https://happyhealthy.nl/',
        'Focus' => 'https://focusmagazine.nl/',
        'Chip Foto Magazine' => 'https://www.chipfotomagazine.nl/',
        'Vogue' => 'https://www.vogue.nl/',
        'TrendyStyle' => 'https://www.trendystyle.net/',
        'WWD' => 'https://wwd.com/',
        'Purse Blog' => 'https://www.purseblog.com/',
        'Coursera' => 'https://blog.coursera.org/',
        'Udemy' => 'https://blog.udemy.com/',
        'CheckPoint' => 'https://blog.checkpoint.com/'
      ],
      [
        'De laatste meter' => 'https://www.delaatstemeter.nl/',
        'ManagementSite' => 'https://www.managementpro.nl/',
        '1 Minute Manager' => 'https://www.1minutemanager.nl/',
        'De Strafschop' => 'https://www.strafschop.nl/',
        'JongeBazen' => 'https://www.jongebazen.nl/',
        'Expeditie Duurzaam' => 'https://www.expeditieduurzaam.nl/',
        'Pure Luxe' => 'https://pureluxe.nl/',
        'WatchTime' => 'https://www.watchtime.com/',
        'Monochrome' => 'https://monochrome-watches.com/',
        'Literair Nederland' => 'https://www.literairnederland.nl/'
      ],
      [
        'Tzum' => 'https://www.tzum.info/',
        'Developer' => 'https://www.developer-tech.com/',
        'SD Times' => 'https://sdtimes.com/',
        'GoDaddy' => 'https://www.godaddy.com/garage/',
        'Bouw Wereld' => 'https://www.bouwwereld.nl/',
        'Vastgoed actueel' => 'https://vastgoedactueel.nl/',
        'The Real Deal' => 'https://therealdeal.com/',
        'HousingWire' => 'https://www.housingwire.com/',
        'AfterSales' => 'https://aftersalesmagazine.nl/',
        'CRS Consulting' => 'https://crsconsultants.nl/'
      ],
      [
        'Commercial Construction & Renovation' => 'https://www.ccr-mag.com/',
        'Training Magazine' => 'https://www.trainingmag.com/',
        'MedCity News' => 'https://www.medcitynews.com/',
        'Cocktail Enthusiast' => 'https://www.cocktailenthusiast.com/',
        'Mr. Online' => 'https://www.mronline.nl/',
        'Cash' => 'https://www.cash.nl/',
        'Kookles thuis' => 'https://www.kooklesthuis.com/',
        'Mediabistro' => 'https://www.mediabistro.com/',
        'ProBlogger' => 'https://problogger.com/',
        'Media Shift' => 'https://www.mediashift.org/'
      ],
      [
        'Warehouse Totaal' => 'https://www.warehousetotaal.nl/',
        'CS digital' => 'https://csdm.online/',
        'Analytics Insight' => 'https://www.analyticsinsight.net/',
        'Wissenraet' => 'https://www.vanspaendonck-wispa.nl/',
        '9to5Mac' => 'https://9to5mac.com/',
        'Invest International' => 'https://investinternational.nl/',
        'Racefiets Blog' => 'https://racefietsblog.nl/',
        'Darts actueel' => 'https://www.dartsactueel.nl/',
        'Hockey.nl' => 'https://hockey.nl/',
        'Hockeykrant' => 'https://hockeykrant.nl/'
      ],
      [
        'Tata Nexarc' => 'https://blog.tatanexarc.com/',
        'Incodocs' => 'https://incodocs.com/blog/',
        'Recruitement Tech' => 'https://www.recruitmenttech.nl/',
        'Healthcare Weekly' => 'https://healthcareweekly.com/',
        'Wellness Mama' => 'https://wellnessmama.com/',
        'Logistics Business' => 'https://www.logisticsbusiness.com/',
        '20Cube' => 'https://www.20cube.com/',
        'Outside' => 'https://velo.outsideonline.com/',
        'Trainer Road' => 'https://www.trainerroad.com/blog/',
        'AllOver Media' => 'https://allovermedia.com/'
      ],
      [
        'The Partially Examined Life' => 'https://partiallyexaminedlife.com/',
        'The Future Organization' => 'https://thefutureorganization.com/',
        'Arts en Auto' => 'https://www.artsenauto.nl/',
        'Discutafel' => 'https://discutafel.nl/',
        'SBVO' => 'https://sbvo.nl/',
        'Your EDM' => 'https://www.youredm.com/',
        'Metal Injection' => 'https://metalinjection.net/',
        'Classical Music' => 'https://www.classical-music.com/',
        'Slipped Disc' => 'https://slippedisc.com/',
        'The Violin Channel' => 'https://www.theviolinchannel.com/'
      ],
      [
        'Carey Nieuwhof' => 'https://careynieuwhof.com/',
        'Fresh' => 'https://www.stichtingfresh.nl/',
        'Werf' => 'https://www.werf-en.nl/',
        'Monday.com' => 'https://monday.com/blog/',
        'HR Knowledge' => 'https://www.hrknowledge.com/',
        'HRcommunity' => 'https://hrcommunity.nl/',
        'Leeuwendaal' => 'https://www.leeuwendaal.nl/',
        'Samhoud' => 'https://www.samhoudconsultancy.com/',
        'Incontext' => 'https://incontext.nl/',
        'Successday' => 'https://successday.nl/'
      ],
      [
        'Hospitality Group' => 'https://www.hospitality-group.nl/',
        'AllChiefs' => 'https://allchiefs.nl/',
        'BTS' => 'https://bts.com/',
        'Fakton' => 'https://www.fakton.com/',
        'bbn' => 'https://bbn.nl/',
        'Over morgen' => 'https://overmorgen.nl/',
        'Beaufort' => 'https://www.beaufortconsulting.nl/',
        'Redept' => 'https://redept.nl/',
        'Akro' => 'https://akroconsult.nl/',
        'AT osborne' => 'https://atosborne.nl/'
      ],
      [
        'Brink' => 'https://www.brink.nl/',
        'Magnus Digital' => 'https://www.magnus.nl/',
        'Lybrae' => 'https://lybrae.nl/',
        'HKA' => 'https://www.hka.com/',
        'Flux Partners' => 'https://flux.partners/',
        'TWST' => 'https://www.twst.nl/',
        'Contakt' => 'https://contakt.nl/',
        'Group Mapping' => 'https://groupmapping.org/',
        'The house of Marketing' => 'https://thom.eu/',
        'PPMC' => 'https://ppmc.nl/'
      ],
      [
        'Newcraft' => 'https://newcraftgroup.com/',
        'The Next Organization' => 'https://thenextorganization.com/',
        'Salveos' => 'https://salveos.nl/',
        'MLC' => 'https://m-lc.nl/',
        'Artefact' => 'https://www.artefact.com/',
        'Horeca Magazine'=>'https://horecamagazine.be/',
        'Around the Bar'=>'https://aroundthebar.nl/',
        'Hospitality News'=>'https://hospitalitynewsny.com/',
        'ZOUT'=>'https://www.zoutmagazine.eu/',
        'Tableau'=>'https://tableaumagazine.nl/'
      ],
      [
        'Amsterdam Magazine' =>	'https://www.amsterdammagazine.com/',
        'Smart Farmer Africa' =>	'https://smartfarmerkenya.com/',
        'Modern Agriculture' =>	'https://modernagriculture.ca/',
        'Farming Monthly' =>	'https://www.farmingmonthly.co.uk/',
        'Farm Journal' =>	'https://www.farmjournal.com/',
        'Future Farming' =>	'https://www.futurefarming.com/',
        'Crop Production Magazine' =>	'https://www.cpm-magazine.co.uk/',
        'Global Finance' =>	'https://gfmag.com/',
        'InFinance' =>	'https://www.infinance.nl/',
        'Financial Focus' =>	'https://financialfocus.abnamro.nl/',
      ],
      [
        'Computer' =>	'https://www.computer.org/',
        'PHP Magazine' =>	'https://phpmagazine.net/',
        'Mouse is Python' =>	'https://www.blog.pythonlibrary.org/',
        'Digital DJ Tips' =>'https://www.digitaldjtips.com/',
        'Centrum voor Conflicthantering' =>	'https://cvc.nl/',
        'HR Morning'	 =>'https://www.hrmorning.com/',
        'Human in Progress'  =>	'https://humaninprogress.com/',
        'Personelle Today'	 => 'https://www.personneltoday.com/',
        'Wccf Tech' => 'https://wccftech.com/',
        'Kit Guru'  =>	'https://www.kitguru.net/',
      ],
      [
        'CHT'  =>	'https://chtmag.com/',
        'Intelligent Transport'	 => 'https://www.intelligenttransport.com/',
        'Attorney at Law Magazine'  =>	'https://attorneyatlawmagazine.com/',
        'Lawyer Monthly'  =>	'https://www.lawyer-monthly.com/',
        'Architects Journal'  =>	'https://www.architectsjournal.co.uk/',
        'E-architect' =>	'https://www.e-architect.com/',
        'Construction News'	 => 'https://www.constructionnews.co.uk/',
        'Construction Week'  =>	'https://www.constructionweekonline.com/',
        'Threat Post'=>	'https://threatpost.com/',
        'ARTnews'  =>	'https://www.artnews.com/'
      ],
      [
        'Design Wanted'	 =>'https://designwanted.com/',
        'Craftsmanship'	 =>'https://craftsmanship.net/',
        'Wood and Panel'  =>	'https://www.woodandpanel.com/',
        'Platform O' =>	'https://platformoverheid.nl/',																							
        'Duurzaam Ondernemen' =>	'https://www.duurzaam-ondernemen.nl/',																																											
        'IVVD' =>	'https://www.ivvd.nl/',																																													
        'De Afdeling Marketing' =>	'https://deafdelingmarketing.nl/',																																												
        'Neurofactor' =>	'https://neurofactor.nl/',																							
        'Kennisportal'	=> 'https://www.kennisportal.com/'	,																							
        'Orbis' =>	'https://www.orbis-software.nl/',
      ],
      [
        'Onno Kleyn' =>	'https://www.onnokleyn.nl/',																						
        'NFCI' =>	'https://nfcihospitality.com/',																																													
        'SVO' =>	'https://www.svo.nl/'	
      ]
    ];

    $args = array(
        'post_type' => 'company',
        'posts_per_page' => -1,
    );

    $company = null;
    $groups = $data['id'];
    $list = $list_company[$groups];
    // var_dump($list);
    $companies = get_posts($args);
    foreach ($list as $key => $website) {
      // function -add author- [addAuthor.php]
      $informations = addAuthor($users, $key);
      $author_id = $informations['author'];
      $company_id = $informations['company'];
      $span = $website . "wp-json/wp/v2/posts/";

      $artikels = json_decode(file_get_contents($span), true);
     foreach ($artikels as $article) {
            if ($article != null) {
                // Check if the article title exists in the database
                $sql_title = $wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s AND type = %s",
                    $article['title']['rendered'], 'Artikel'
                );
                $result_title = $wpdb->get_results($sql_title);

                if ($article['content']['rendered'] != '') {
                    if ($article['excerpt']['rendered'] == '') {
                        $firstSentence = explode('.', $article['content']['rendered']);
                        $article['excerpt']['rendered'] = $firstSentence[0];
                    }

                    $status = 'extern';
                    $image_url = null;

                    if ($article['featured_media'] != 0) {
                        $span2 = $website . "wp-json/wp/v2/media/" . $article['featured_media'];
                        $images = json_decode(file_get_contents($span2), true);

                        if (!isset($images['data']['status'])) {
                            $image_url = $images['guid']['rendered'];
                        }
                    }

                    $datas = array(
                        'titel' => $article['title']['rendered'],
                        'type' => 'Artikel',
                        'videos' => null,
                        'short_description' => strip_html_tags($article['excerpt']['rendered']),
                        'long_description' => $article['content']['rendered'],
                        'duration' => null,
                        'prijs' => 0,
                        'prijs_vat' => 0,
                        'image_xml' => $image_url,
                        'onderwerpen' => $onderwerpen,
                        'date_multiple' => null,
                        'course_id' => null,
                        'author_id' => $author_id,
                        'company_id' => $company_id,
                        'contributors' => null,
                        'status' => $status,
                        'language' => detectLanguage($article['title']['rendered']),
                    );

                    if (isset($result_title[0])) {
                      
                        $update_result = $wpdb->update(
                            $table,
                            $datas,
                            array('id' => $result_title[0]->id)
                        );

                        if ($update_result !== false) {
                            $data_insert = 1;
                        } else {
                            echo "<span class='alert alert-danger'>Failed to update the record with title: {$article['title']['rendered']} ❌</span>";
                        }
                    } else {
                        
                        if ($wpdb->insert($table, $datas)) {
                            $id_post = $wpdb->insert_id;
                            $data_insert = 1;
                        }
                    }
                }
            }
        }
    }
    if($data_insert==1)
    echo "datas founded and recordered in Databank";
    else
     echo "new datas not founded so we have no record in Databank";

}

function addOneCourse($data_json){
     $data_insert=0;
    global $wpdb;
     $table = $wpdb->prefix . 'databank';
    $url = 'https://api.edudex.nl/data/v1/programs/bulk';

  // En-têtes de la requête
  $headers = array(
    'accept: application/json',
    'Authorization: Bearer secret-token:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJFZHUtRGV4IiwiaWF0IjoxNzEzNDMxMjExLCJuYmYiOjE3MTM0MzEyMTEsInN1YiI6ImVkdWRleC1hcGktdXNlciIsInNjb3BlIjoiZGF0YSIsIm5vbmNlIjoidjh2UjNmTkY4NHdWaTZOMDlfQWl5QSIsImV4cCI6MTkwMjc0MzEwMH0.RxttT9h1eA07fYIRFqDes3EJnLiDMVWaxcY0IVFIElI',
    'Content-Type: application/json'
  );

  // Initialisation de la session cURL
   $curl = curl_init($url);

    // Configuration des options cURL
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data_json,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => false
    ));

    // Exécuter la requête cURL
    $response = curl_exec($curl);

    // Vérification des erreurs
    if ($response === false) {
        $error = curl_error($curl);
        echo "Erreur cURL : " . $error;
    }

    // Fermer la session cURL
    curl_close($curl);   
    $data = json_decode($response, true);

    foreach($data['programs'] as $key => $data_xml){ 

      $datum = $data_xml['data'];     
      // var_dump($datum['programDescriptions']['programName']['nl']);
      $status = 'extern';
      $course_type = "Opleidingen";
      $image = "";
      if($datum['programDescriptions']['media'] != null){
      foreach($datum['programDescriptions']['media'] as $media)
      
        if($media['type'] == "image"){
          $image = $media['url'];
          break;
        }
        }//       //Redundance check "Image & Title"
       
        $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s", strval($image));
        $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", strval($datum['programDescriptions']['programName']['nl']));

        if($image != "")
          $check_image = $wpdb->get_results($sql_image); 

        $check_title = $wpdb->get_results($sql_title);
          $post = array(
          'short_description' => $datum['programDescriptions']['programSummaryText']['nl'],
          'long_description' => null,
          'agenda' => $datum['programDescriptions']['programDescriptionText']['nl'],
          'url_image' => $image,
          'prijs' => $datum['programSchedule']['genericProgramRun'][0]['cost'][0]['amount'],
          'prijsvat' => $datum['programSchedule']['genericProgramRun'][0]['cost'][0]['amountVAT'],
          'degree' => $datum['programClassification']['degree'],
          'teacher_id' => $datum['programCurriculum']['teacher']['id'],
          'org' => $datum['programClassification']['orgUnitId'],
          'duration_day' => $datum['programClassification']['programDuration'],
        );
          $attachment_xml = array();
        $data_locaties_xml = array();

        /*
        ** -- Main fields --
        */ 

        $company = null;
        $users = get_users();
      
        // Fill the company if do not exist "next-version"
        $informations = addAuthor($users, $post['org']);
        $author_id = $informations['author'];
        $company_id = $informations['company'] ;
        
        $title = explode(' ', strval($datum['programDescriptions']['programName']['nl']));
        $description = explode(' ', strval($datum['programDescriptions']['programSummaryText']['nl']));
        $description_html = explode(' ', strval($datum['programDescriptions']['programSummaryHtml']['nl']));    
        $keywords = array_merge($title, $description, $description_html);
        if(!empty($keywords)){
        
          // Value : course type
          if(in_array('masterclass:', $keywords) || in_array('Masterclass', $keywords) || in_array('masterclass', $keywords))
            $course_type = "Masterclass";
          else if(in_array('(training)', $keywords) || in_array('training', $keywords) || in_array('Training', $keywords))
            $course_type = "Training";
          else if(in_array('live', $keywords) && in_array('seminar', $keywords))
            $course_type = "Webinar";
          else if(in_array('Live', $keywords) || in_array('Online', $keywords) || in_array('E-learning', $keywords) )
            $course_type = "E-learning";
          else
            $course_type = "Opleidingen";
        }

        $descriptionHtml = $datum['programDescriptions']['programDescriptionText']['nl'];
      
        $tags = array();
          $onderwerpen = "";
          $categories = array(); 
          $cats = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'orderby'    => 'name',
            'exclude' => 'Uncategorized',
            'parent'     => 0,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ) );

          foreach($cats as $item){
            $cat_id = strval($item->cat_ID);
            $item = intval($cat_id);
            array_push($categories, $item);
          };

          $bangerichts = get_categories( array(
              'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
              'parent'  => $categories[1],
              'hide_empty' => 0, // change to 1 to hide categores not having a single post
          ) );


          $categorys = array(); 
          foreach($categories as $categ){
              //Topics
              $topics = get_categories(
                  array(
                  'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                  'parent'  => $categ,
                  'hide_empty' => 0, // change to 1 to hide categores not having a single post
                  ) 
              );

              foreach ($topics as $value) {
                  $tag = get_categories( 
                      array(
                      'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                      'parent'  => $value->cat_ID,
                      'hide_empty' => 0,
                      ) 
                  );
                  $categorys = array_merge($categorys, $tag);      
              }
          }
          foreach($datum['programDescriptions']['searchword']['nl'] as $searchword){
            $searchword = strtolower(strval($searchword));
          
          
            foreach($categorys as $category){
              $cat_slug = strval($category->slug);
              $cat_name = strval($category->cat_name);             
              if(strpos($searchword, $cat_slug) !== false)
                if(!in_array($category->cat_ID, $tags))
                    array_push($tags, $category->cat_ID);
            }
          }

          if(empty($tags)){
            $occurrence = array_count_values(array_map('strtolower', $keywords));
            arsort($occurrence);
            foreach($categorys as $value)
              if($occurrence[strtolower($value->cat_name)] >= 1)
                if(!in_array($value->cat_ID, $tags))
                  array_push($tags, $value->cat_ID);
          }

          //Final value : categorie
          $onderwerpen = join(',' , $tags);
        $attachment = array();
         if($datum['programDescriptions']['media']!=null){
        foreach($datum['programDescriptions']['media'] as $media){
          if($media['type'] == "image")
            $image = $media['url'];
          else
            array_push($attachment, $media['url']);
        } 
         }
        $attachment_xml = join(',', $attachment);
        $data_locaties_xml = array();
        $data_locaties = null;
      
           if(!empty($datum['programSchedule']['programRun'])){
         
          foreach($datum['programSchedule']['programRun'] as $program){
            
             
            $info = array();
            $infos = "";
            $row = "";
       
            foreach($program['courseDay'] as $key => $courseDay){

              $dates = explode('-',strval($courseDay['date']));
             
              //format date 
              $date = $dates[2] . "/" .  $dates[1] . "/" . $dates[0];
              
              $info['start_date'] = $date . " ". strval($courseDay['startTime']);
              $info['end_date'] = $date . " ". strval($courseDay['endTime']);
              $info['location'] = strval($courseDay['location']['city']);
              $info['adress'] = strval($courseDay['location']['address']);
          
              $row = $info['start_date']. '-' . $info['end_date'] . '-' . $info['location'] . '-' . $info['adress'] ;
               

              $infos .= $row ; 

              $infos .= ';' ; 
                
            }
            

            if(substr($infos, -1) == ';')
              $infos = rtrim($infos, ';');
            
            if(!empty($infos))
              array_push($data_locaties_xml, $infos); 
            else {
              continue;
            } 
         }

        $data_locaties = join('~', $data_locaties_xml);
        $language=detectLanguage(strval($datum['programDescriptions']['programName']['nl']));
        $post = array(
        'titel' => strval($datum['programDescriptions']['programName']['nl']),
        'type' => $course_type,
        'videos' => null,
        'short_description' => strval($datum['programDescriptions']['programSummaryText']['nl']),
        'long_description' => $descriptionHtml,
        'duration' => strval($datum['programClassification']['programDuration']),
        'agenda' => strval($datum['programDescriptions']['programDescriptionText']['nl']),
        'image_xml' => strval($image),
        'attachment_xml' => $attachment_xml,
       
         'prijs' => intval($program['cost'][0]['amount']),
        'prijs_vat' => intval($program['cost'][0]['amountVAT']),
        'level' => strval($datum['programClassification']['degree']),
        'teacher_id' => $datum['programCurriculum']['teacher']['id'],
        'org' => strval($datum['programClassification']['orgUnitId']),
        'onderwerpen' => $onderwerpen, 
        'date_multiple' => $data_locaties, 
        'course_id' => strval($datum['programClassification']['programId']),
        'author_id' => $author_id,
        'company_id' => $company_id,
        'status' => $status,
       'language'=>$language
      
      );
    
      
        
     $where = [ 'titel' => strval($datum['programDescriptions']['programName']['nl']) ];
       $updated = $wpdb->update( $table, $post, $where );
       if( !isset($check_image[0]) && !isset($check_title[0]) ){ 
           if($wpdb->insert($table, $post)) {
            $data_insert=1;
            $post_id = $wpdb->insert_id;
           
            }

        }
         else{
        
          $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", $post['titel']);
          
          $course = $wpdb->get_results( $sql )[0];     
         
//           $message = 'field on change detected and applied<br><br>';
  
          if($post['type'] != $course->type){
      
            $data = [ 'type' => $post['type']]; // NULL value.
            $where = [ 'id' => $course->id ];
            $updated = $wpdb->update( $table, $data, $where );
            if($updated)
             $change = true;

          //  echo '****** Type of course - ' . $message;
           
          }

          if($post['author_id'] != $course->author_id){
            $data = [ 'author_id' => $author_id]; // NULL value.
            $where = [ 'id' => $course->id ];
            $updated = $wpdb->update( $table, $data, $where );
             
          }

          if($post['company_id'] != $course->company_id){
            $data = [ 'company_id' => $company_id]; // NULL value.
            $where = [ 'id' => $course->id ];
            $updated = $wpdb->update( $table, $data, $where );
            
          }
        
          

        }
        }
        else{
              break;
        }
  

        
      }
      return $data_insert;
    
    
  }  

 function addCourseGeneral($catalogId){
       $data_insert=0;
     
     
         $headers = [
              'Authorization:Bearer secret-token:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJFZHUtRGV4IiwiaWF0IjoxNzEzNDMxMjExLCJuYmYiOjE3MTM0MzEyMTEsInN1YiI6ImVkdWRleC1hcGktdXNlciIsInNjb3BlIjoiZGF0YSIsIm5vbmNlIjoidjh2UjNmTkY4NHdWaTZOMDlfQWl5QSIsImV4cCI6MTkwMjc0MzEwMH0.RxttT9h1eA07fYIRFqDes3EJnLiDMVWaxcY0IVFIElI',
            ];
                    
         $url = "https://api.edudex.nl/data/v1/organizations/livelearn/dynamiccatalogs/". $catalogId . "/programs";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch); 
        $programs = json_decode($response, true);
        

        if(isset($programs)){

          $data = array();
          $data['programs']= array();
          foreach ($programs  as $prog) {
           // addOneCourse($prog);
            $element=array(
           "orgUnitId" => $prog['supplierId'],
            "programId" => $prog['programId'],
           "clientId" => $prog['clientId']
            );
            array_push($data['programs'], $element);
            
          
          }
          $data_json = json_encode($data);
           $data_insert=addOneCourse($data_json);
        }
       
          return  $data_insert;
        
       } 

function xmlParse($data)
{


 $index = $data->get_param('id');



    $verif=0;
    $data_insert=0;
    global $wpdb;
    $company = null;
    $groups = array();
    $datas = array();
    //fix data table
    $table = $wpdb->prefix . 'databank';
    //Get all users
    $users = get_users();
     $url = 'https://api.edudex.nl/data/v1/organizations/livelearn/dynamiccatalogs';
   ///  curl -s 'https://api-test.edudex.nl/data/v1/organizations' -H "Authorization: Bearer $APITOKEN" | jq
     $headers = [

    
    'Authorization:Bearer secret-token:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJFZHUtRGV4IiwiaWF0IjoxNzEzNDMxMjExLCJuYmYiOjE3MTM0MzEyMTEsInN1YiI6ImVkdWRleC1hcGktdXNlciIsInNjb3BlIjoiZGF0YSIsIm5vbmNlIjoidjh2UjNmTkY4NHdWaTZOMDlfQWl5QSIsImV4cCI6MTkwMjc0MzEwMH0.RxttT9h1eA07fYIRFqDes3EJnLiDMVWaxcY0IVFIElI',
    
    ];

    $website_urls = [];
      $file_xml= [];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch); 

    $data = json_decode($response, true);
    $catalogs=$data["catalogs"];
     
     foreach ($catalogs as $catalog) {
       $file_xml= [];
     $file_xml[$catalog['title']] = $catalog['catalogId'];
    
       $website_urls[]=$file_xml;
      
     }
   
 
       

    // $website_urls = [
    //     [
    //         '112bhv-20231101.1430.xml',
    //         '2xplain-b.v-20230925.0140.xml',
    //         'agile-scrum-group-20230922.1323.xml',
    //         'anker-kompas-20230922.1323.xml',
    //         'aeres-tech-20230925.0141.xml',
    //     ],
    //     [
    //         'edumia-20231024.1105.xml',
    //         'academie-voor-arbeidsmarktcommunicatie-b.v-20230925.0141.xml',
    //         'beeckestijn-20231101.2250.xml',
    //         'berenschot-20231101.1421.xml',
    //         'bhv.nl-20231102.0032.xml',
    //     ],
    //     [
    //         'bit-academy-20231101.1430.xml',
    //         'blom-20231102.0026.xml',
    //         'bureau-vris-20231101.1431.xml',
    //         'buro-brand-20231101.1422.xml',
    //         'cm-partners-20231102.0033.xml',
    //     ],
    //     [
    //         'comenius-20231101.1422.xml',
    //         'competence-factory-20231102.0027.xml',
    //         'faculty-of-skills-20231101.1430.xml',
    //         'frankwatching-20231102.0033.xml',
    //         'growth-tribe-20231101.1422.xml',
    //     ],
    //     [
    //         'horizon-20231102.0028.xml',
    //         'hr-academy-20231102.0028.xml',
    //         'kenneth-smit-20231102.0028.xml',
    //         'kenneth-smit-direct-20231102.0028.xml',
    //         'possible-20231102.0028.xml',
    //     ],
    //     [
    //         'saxion-parttime-school-20231101.1423.xml',
    //         'scheidegger-20231102.0027.xml',
    //         'schouten-nelissen-20231102.0028.xml',
    //         'start2move-20231101.1423.xml',
    //         'tekkieworden-20231101.1423.xml',
    //     ],
    //     [
    //         'tvvl-20231101.1423.xml',
    //         'vijfhart-20231102.0028.xml',
    //         'winc-academy-20231101.1423.xml',
    //         'yearth-academy-20231102.0029.xml',
    //     ],
    // ];

    $args = array(
        'post_type' => 'company',
        'posts_per_page' => -1,
    );

    //Start inserting course
    echo "<h1 class='titleGroupText' style='font-weight:bold'>SCRIPT XML PARSING</h1>";
// $index = intval($data->get_param('id'));
   // $index = intval($data['id']);


    $groups = $website_urls[$index];
    
    $data_insert=0;
    echo "<h1 class='titleGroupText' style='font-weight:bold'>Compagnies:</h1>";
    echo "<h1 class='titleGroupText' style='font-weight:bold'>------------</h1>";

   foreach ($groups  as $key => $website) {
        echo "<h2 class='titleGroupText' style='font-weight:bold'>".$key."</h2>";
   }
    echo "<h1 class='titleGroupText' style='font-weight:bold'>------------</h1>";
    foreach ($groups  as $key => $website) {
        //Get the URL content
          
        
       
 $headers = [
              'Authorization:Bearer secret-token:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJFZHUtRGV4IiwiaWF0IjoxNzEzNDMxMjExLCJuYmYiOjE3MTM0MzEyMTEsInN1YiI6ImVkdWRleC1hcGktdXNlciIsInNjb3BlIjoiZGF0YSIsIm5vbmNlIjoidjh2UjNmTkY4NHdWaTZOMDlfQWl5QSIsImV4cCI6MTkwMjc0MzEwMH0.RxttT9h1eA07fYIRFqDes3EJnLiDMVWaxcY0IVFIElI',
            ];
                    
         $url = "https://api.edudex.nl/data/v1/organizations/livelearn/dynamiccatalogs/". $website . "/programs";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch); 
      
        $programs = json_decode($response, true);
        

        if(isset($programs)){
          

          $data = array();
          $data['programs']= array();
          $i=0;
          foreach ($programs  as $prog) {

           // addOneCourse($prog);
          
            $element=array(
           "orgUnitId" => $prog['supplierId'],
            "programId" => $prog['programId'],
           "clientId" => $prog['clientId']
            );
            
            array_push($data['programs'], $element);
            $i++;
            if($i==37){
              $data_json = json_encode($data);
              $data_insert=addOneCourse($data_json);
              $data = array();
              $data['programs']= array();
              $i=0;
              usleep(2000);
            }
              
          }
          
            
          
         
          $data_json = json_encode($data);
        

           $data_insert=addOneCourse($data_json);
//  $url = 'https://api.edudex.nl/data/v1/programs/bulk';

// // En-têtes de la requête

// $headers = array(
//     'accept: application/json',
//     'Authorization: Bearer secret-token:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJFZHUtRGV4IiwiaWF0IjoxNzEzNDMxMjExLCJuYmYiOjE3MTM0MzEyMTEsInN1YiI6ImVkdWRleC1hcGktdXNlciIsInNjb3BlIjoiZGF0YSIsIm5vbmNlIjoidjh2UjNmTkY4NHdWaTZOMDlfQWl5QSIsImV4cCI6MTkwMjc0MzEwMH0.RxttT9h1eA07fYIRFqDes3EJnLiDMVWaxcY0IVFIElI',
//     'Content-Type: application/json'
// );

// // Initialisation de la session cURL
//    $curl = curl_init($url);

//     // Configuration des options cURL
//     curl_setopt_array($curl, array(
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_POST => true,
//         CURLOPT_POSTFIELDS => $data_json,
//         CURLOPT_HTTPHEADER => $headers,
//         CURLOPT_SSL_VERIFYHOST => 0,
//         CURLOPT_SSL_VERIFYPEER => false
//     ));

//     // Exécuter la requête cURL
//     $response = curl_exec($curl);
    

//     // Vérification des erreurs
//     if ($response === false) {
//         $error = curl_error($curl);
//         echo "Erreur cURL : " . $error;
//     }

//     // Fermer la session cURL
//     curl_close($curl);   
//      $data = json_decode($response, true);
    
    
//      if($data['programs']!=null){
//      foreach($data['programs'] as $key => $data_xml){
         
      
          

//         $datum=$data_xml['data'];    
//         if($datum!=null) {
//         // var_dump($datum['programDescriptions']['programName']['nl']);
//          $status = 'extern';
//          $course_type = "Opleidingen";
//          $image = "";
        

//         if($datum['programDescriptions']['media']!=null){
//            foreach($datum['programDescriptions']['media'] as $media)
       
      
//         if($media['type'] == "image"){
//           $image = $media['url'];
//           break;
//         }

//         }
       
       
     
//         //       //Redundance check "Image & Title"
       
//       $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s", strval($image));
//       $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", strval($datum['programDescriptions']['programName']['nl']));
    
//       if($image != "")
//         $check_image = $wpdb->get_results($sql_image); 
     


//       $check_title = $wpdb->get_results($sql_title);
//         $post = array(
//         'short_description' => $datum['programDescriptions']['programSummaryText']['nl'],
//         'long_description' => null,
//         'agenda' => $datum['programDescriptions']['programDescriptionText']['nl'],
//         'url_image' => $image,
//         'prijs' => $datum['programSchedule']['genericProgramRun'][0]['cost'][0]['amount'],
//         'prijsvat' => $datum['programSchedule']['genericProgramRun'][0]['cost'][0]['amountVAT'],
//         'degree' => $datum['programClassification']['degree'],
//         'teacher_id' => $datum['programCurriculum']['teacher'][0]['id'],
//         'org' => $datum['programClassification']['orgUnitId'],
//         'duration_day' => $datum['programClassification']['programDuration'],
//       );
//        $attachment_xml = array();
//       $data_locaties_xml = array();

//       /*
//       ** -- Main fields --
//       */ 

//       $company = null;
//       $users = get_users();
     
     
      
      
//     // Fill the company if do not exist "next-version"
//        $informations = addAuthor($users, $post['org']);
//          $author_id = $informations['author'];
//         $company_id = $informations['company'] ;
       

      
//       $title = explode(' ', strval($datum['programDescriptions']['programName']['nl']));
//       $description = explode(' ', strval($datum['programDescriptions']['programSummaryText']['nl']));
//       $description_html = explode(' ', strval($datum['programDescriptions']['programSummaryHtml']['nl']));    
//      $keywords = array_merge($title, $description, $description_html);
//        if(!empty($keywords)){
       
//         // Value : course type
//         if(in_array('masterclass:', $keywords) || in_array('Masterclass', $keywords) || in_array('masterclass', $keywords))
//           $course_type = "Masterclass";
//         else if(in_array('(training)', $keywords) || in_array('training', $keywords) || in_array('Training', $keywords))
//           $course_type = "Training";
//         else if(in_array('live', $keywords) && in_array('seminar', $keywords))
//           $course_type = "Webinar";
//         else if(in_array('Live', $keywords) || in_array('Online', $keywords) || in_array('E-learning', $keywords) )
//           $course_type = "E-learning";
//         else
//           $course_type = "Opleidingen";
//       }
//       //  var_dump($datum['programDescriptions']['programDescriptionHtml']['nl']);
//       //  var_dump('____________________');
//       //   var_dump($datum['programDescriptions']['programDescriptionText']['nl']);
//       //  if($datum['programDescriptions']['programDescriptionHtml'])
//       //   $descriptionHtml = $datum['programDescriptions']['programDescriptionHtml']['nl'];
//       // else
//         $descriptionHtml = $datum['programDescriptions']['programDescriptionText']['nl'];
      
//         $tags = array();
//           $onderwerpen = "";
//           $categories = array(); 
//           $cats = get_categories( array(
//             'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//             'orderby'    => 'name',
//             'exclude' => 'Uncategorized',
//             'parent'     => 0,
//             'hide_empty' => 0, // change to 1 to hide categores not having a single post
//             ) );

//           foreach($cats as $item){
//             $cat_id = strval($item->cat_ID);
//             $item = intval($cat_id);
//             array_push($categories, $item);
//           };

//           $bangerichts = get_categories( array(
//               'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//               'parent'  => $categories[1],
//               'hide_empty' => 0, // change to 1 to hide categores not having a single post
//           ) );


//           $categorys = array(); 
//           foreach($categories as $categ){
//               //Topics
//               $topics = get_categories(
//                   array(
//                   'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//                   'parent'  => $categ,
//                   'hide_empty' => 0, // change to 1 to hide categores not having a single post
//                   ) 
//               );

//               foreach ($topics as $value) {
//                   $tag = get_categories( 
//                       array(
//                       'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//                       'parent'  => $value->cat_ID,
//                       'hide_empty' => 0,
//                       ) 
//                   );
//                   $categorys = array_merge($categorys, $tag);      
//               }
//           }

//           if($datum['programDescriptions']['searchword']['nl']!=null){
//           foreach($datum['programDescriptions']['searchword']['nl'] as $searchword){
//             $searchword = strtolower(strval($searchword));
          
          
//             foreach($categorys as $category){
//               $cat_slug = strval($category->slug);
//               $cat_name = strval($category->cat_name);             
//               if(strpos($searchword, $cat_slug) !== false)
//                 if(!in_array($category->cat_ID, $tags))
//                     array_push($tags, $category->cat_ID);
//             }
//           }
//         }
//           if(empty($tags)){
//             $occurrence = array_count_values(array_map('strtolower', $keywords));
//             arsort($occurrence);
//             foreach($categorys as $value)
//               if($occurrence[strtolower($value->cat_name)] >= 1)
//                 if(!in_array($value->cat_ID, $tags))
//                   array_push($tags, $value->cat_ID);
//           }

//           //Final value : categorie
//           $onderwerpen = join(',' , $tags);
//         $attachment = array();
//         if($datum['programDescriptions']['media']!=null){
//         foreach($datum['programDescriptions']['media'] as $media){
//           if($media['type'] == "image")
//             $image = $media['url'];
//           else
//             array_push($attachment, $media['url']);
//         } 
//         }
        
//         $attachment_xml = join(',', $attachment);
//         $data_locaties_xml = array();
//         $data_locaties = null;
      
//       if($datum['programSchedule']['programRun']!=null){
//           foreach($datum['programSchedule']['programRun'] as $program){
            
             
//             $info = array();
//             $infos = "";
//             $row = "";

//              if($program['courseDay']!=null){
       
//               foreach($program['courseDay'] as $key => $courseDay){

//               $dates = explode('-',strval($courseDay['date']));
             
//               //format date 
//               $date = $dates[2] . "/" .  $dates[1] . "/" . $dates[0];
              
//               $info['start_date'] = $date . " ". strval($courseDay['startTime']);
//               $info['end_date'] = $date . " ". strval($courseDay['endTime']);
//               $info['location'] = strval($courseDay['location']['city']);
//               $info['adress'] = strval($courseDay['location']['address']);
          
//               $row = $info['start_date']. '-' . $info['end_date'] . '-' . $info['location'] . '-' . $info['adress'] ;
               

//               $infos .= $row ; 

//               $infos .= ';' ; 
                
//             }
//              }
           

//             if(substr($infos, -1) == ';')
//               $infos = rtrim($infos, ';');
            
//             if(!empty($infos))
//               array_push($data_locaties_xml, $infos); 
//             else {
//               continue;
//             } 
//          }

//           $data_locaties = join('~', $data_locaties_xml);
          
//        $language=$datum['programDescriptions']['programName']['nl']!=null?detectLanguage(strval($datum['programDescriptions']['programName']['nl'])):'';
        
      
//         $post = array(
//         'titel' => strval($datum['programDescriptions']['programName']['nl']),
//         'type' => $course_type,
//         'videos' => null,
//         'short_description' => strval($datum['programDescriptions']['programSummaryText']['nl']),
//         'long_description' => $descriptionHtml,
//         'duration' => strval($datum['programClassification']['programDuration']),
//         'agenda' => strval($datum['programDescriptions']['programDescriptionText']['nl']),
//         'image_xml' => strval($image),
//         'attachment_xml' => $attachment_xml,
//         'prijs' => intval($program['cost'][0]['amount']),
//         'prijs_vat' => intval($program['cost'][0]['amountVAT']),
//         'level' => strval($datum['programClassification']['degree']),
//         'teacher_id' => $datum['programCurriculum']['teacher'][0]['id'],
//         'org' => strval($datum['programClassification']['orgUnitId']),
//         'onderwerpen' => $onderwerpen, 
//         'date_multiple' => $data_locaties, 
//         'course_id' => strval($datum['programClassification']['programId']),
//         'author_id' => $author_id,
//         'company_id' => $company_id,
//         'status' => $status,
//        'language'=>$language
      
//       );
      
    
      
        
//      $where = [ 'titel' => strval($datum['programDescriptions']['programName']['nl']) ];
//        $updated = $wpdb->update( $table, $post, $where );
//        if( !isset($check_image[0]) && !isset($check_title[0]) ){ 
//            if($wpdb->insert($table, $post)) {
//             $data_insert=1;
//             $post_id = $wpdb->insert_id;
           
//             }

//         }
//          else{
        
//           $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", $post['titel']);
          
//           $course = $wpdb->get_results( $sql )[0];     
         
// //           $message = 'field on change detected and applied<br><br>';
  
//           if($post['type'] != $course->type){
      
//             $data = [ 'type' => $post['type']]; // NULL value.
//             $where = [ 'id' => $course->id ];
//             $updated = $wpdb->update( $table, $data, $where );
          

//           //  echo '****** Type of course - ' . $message;
           
//           }

//           if($post['author_id'] != $course->author_id){
//             $data = [ 'author_id' => $author_id]; // NULL value.
//             $where = [ 'id' => $course->id ];
//             $updated = $wpdb->update( $table, $data, $where );
             
//           }

//           if($post['company_id'] != $course->company_id){
//             $data = [ 'company_id' => $company_id]; // NULL value.
//             $where = [ 'id' => $course->id ];
//             $updated = $wpdb->update( $table, $data, $where );
            
//           }
            
          
//         }
          
//         }
//         else{
  
//               break;

//         }
         
          
//        }
        
//       }
//       }
      
        
         }


    if($data_insert==1){
          $verif=1;
    }
    }
    if($verif==1)
     echo "<span class='alert alert-success'> Course - Insertion done successfully</span> <br><br>";
    else 
      echo "<span class='alert alert-danger'>No New Data! ❌</span>";     
   
    
  
}






