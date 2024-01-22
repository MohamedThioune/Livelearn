<?php
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
    $company = null;
    $list = array();
    $datas = array();

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
            'Rever' => 'https://rever.nl/',
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
            'Perswijn' => 'https://perswijn.nl/',
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
            'Equalture' => 'https://www.equalture.com/',
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
            'Crypto Insiders' => 'https://www.crypto-insiders.nl/',
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
            'CheckPoint' => 'https://blog.checkpoint.com/',
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
            'Literair Nederland' => 'https://www.literairnederland.nl/',
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
            'CRS Consulting' => 'https://crsconsultants.nl/',
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
            'Media Shift' => 'https://www.mediashift.org/',
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
            'Hockeykrant' => 'https://hockeykrant.nl/',
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
            'AllOver Media' => 'https://allovermedia.com/',
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
            'The Violin Channel' => 'https://www.theviolinchannel.com/',
        ],
        [
            'Carey Nieuwhof' => 'https://careynieuwhof.com/',
            'Fresh' => 'https://www.stichtingfresh.nl/',
            'Werf' => 'https://www.werf-en.nl/',
            'Monday.com' => 'https://monday.com/blog/',
            'HR Knowledge'=>'https://www.hrknowledge.com/',
            'HRcommunity'=>'https://hrcommunity.nl/',
            'Leeuwendaal'=>'https://www.leeuwendaal.nl/',
            'Samhoud'=>'https://www.samhoudconsultancy.com/',
            'Incontext'=>'https://incontext.nl/',
            'Successday'=>'https://successday.nl/'
        ],
        [
            'Hospitality Group'=>'https://www.hospitality-group.nl/',
            'AllChiefs'=>'https://allchiefs.nl/',
            'BTS'=>'https://bts.com/',
            'Fakton'=>'https://www.fakton.com/',
            'bbn'=>'https://bbn.nl/',
            'Over morgen'=>'https://overmorgen.nl/',
            'Beaufort'=>'https://www.beaufortconsulting.nl/',
            'Redept'=>'https://redept.nl/',
            'Akro'=>'https://akroconsult.nl/',
            'AT osborne'=>'https://atosborne.nl/'
        ],
        [
            'Brink'=>'https://www.brink.nl/',
            'Magnus Digital'=>'https://www.magnus.nl/',
            'Lybrae'=>'https://lybrae.nl/',
            'HKA'=>'https://www.hka.com/',
            'Flux Partners'=>'https://flux.partners/',
            'TWST'=>'https://www.twst.nl/',
            'Contakt'=>'https://contakt.nl/',
            'Group Mapping'=>'https://groupmapping.org/',
            'The house of Marketing'=>'https://thom.eu/',
            'PPMC'=>'https://ppmc.nl/'
        ],
        [
            'Newcraft'=>'https://newcraftgroup.com/',
            'The Next Organization'=>'https://thenextorganization.com/',
            'Salveos'=>'https://salveos.nl/',
            'MLC'=>'https://m-lc.nl/',
            'Artefact'=>'https://www.artefact.com/'
        ]
    ]; 

    $args = array(
        'post_type' => 'company',
        'posts_per_page' => -1,
    );
    $groups = $data['id'];
    $list = $list_company[$groups];
    // var_dump($list);
    $companies = get_posts($args);
    foreach ($list as $key => $website) {
        $author_id = null;
        foreach ($companies as $companie) {
            if (strtolower($companie->post_title) == strtolower($key)) {
                $company = $companie;
            } else {
                continue;
            }

            foreach ($users as $user) {
                $company_user = get_field('company', 'user_' . $user->ID);

                if (isset($company_user[0]->post_title)) {
                    if (strtolower($company_user[0]->post_title) == strtolower($key)) {
                        $author_id = $user->ID;
                        $company = $company_user[0];
                        $company_id = $company_user[0]->ID;
                    }
                }

            }
            // var_dump($author_id);
        }

        if (!$author_id) {
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

            $author_id = wp_insert_user(wp_slash($userdata));
        }

        //Accord the author a company
        if (!is_wp_error($author_id)) {
            update_field('company', $company, 'user_' . $author_id);
        }

        $span = $website . "wp-json/wp/v2/posts/";
        $artikels = json_decode(file_get_contents($span), true);
        foreach ($artikels as $article) {
            //         // $onderwerpen = trim($onderwerpen);

            if ($article != null) {
                $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank where titel=%s and type=%s", array($article['title']['rendered'], 'Artikel'));
                $result_title = $wpdb->get_results($sql_title);
                if ($article['featured_media'] != 0) {
                    $span2 = $website . "wp-json/wp/v2/media/" . $article['featured_media'];
                    $images = json_decode(file_get_contents($span2), true);
                    // $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s AND type = %s", array($images['guid']['rendered'], 'Artikel'));
                    // $result_image = $wpdb->get_results($sql_image);

                    if ( /*!isset($result_image[0]) && */!isset($result_title[0])) {
                        if (!isset($images['data']['status'])) {
                            $status = 'extern';
                            $datas = array(
                                'titel' => $article['title']['rendered'],
                                'type' => 'Artikel',
                                'videos' => null,
                                'short_description' => htmlspecialchars(strip_html_tags($article['excerpt']['rendered'])),
                                'long_description' => $article['content']['rendered'],
                                'duration' => null,
                                'prijs' => 0,
                                'prijs_vat' => 0,
                                'image_xml' => $images['guid']['rendered'],
                                'onderwerpen' => $onderwerpen,
                                'date_multiple' => null,
                                'course_id' => null,
                                'author_id' => $author_id,
                                'company_id' => $company_id,
                                'contributors' => null,
                                'status' => $status,
                            );
                        } else {
                            $status = 'extern';
                            $datas = array(
                                'titel' => $article['title']['rendered'],
                                'type' => 'Artikel',
                                'videos' => null,
                                'short_description' => htmlspecialchars(strip_html_tags($article['excerpt']['rendered'])),
                                'long_description' => $article['content']['rendered'],
                                'duration' => null,
                                'prijs' => 0,
                                'prijs_vat' => 0,
                                'image_xml' => null,
                                'onderwerpen' => $onderwerpen,
                                'date_multiple' => null,
                                'course_id' => null,
                                'author_id' => $author_id,
                                'company_id' => $company_id,
                                'contributors' => null,
                                'status' => $status,
                            );
                        }
                    } else {
                        continue;
                    }

                } else {
                    if (!isset($result_title[0])) {
                        $status = 'extern';
                        $datas = array(
                            'titel' => $article['title']['rendered'],
                            'type' => 'Artikel',
                            'videos' => null,
                            'short_description' => htmlspecialchars(strip_html_tags($article['excerpt']['rendered'])),
                            'long_description' => $article['content']['rendered'],
                            'duration' => null,
                            'prijs' => 0,
                            'prijs_vat' => 0,
                            'image_xml' => null,
                            'onderwerpen' => $onderwerpen,
                            'date_multiple' => null,
                            'course_id' => null,
                            'author_id' => $author_id,
                            'company_id' => $company_id,
                            'contributors' => null,
                            'status' => $status,
                        );
                    }
                }
                // echo "Selected option: $text (value=$value)<br>";
                try
                {
                    $wpdb->insert($table, $datas);
                    // echo $key."  ".$wpdb->last_error."<br>";
                    $id_post = $wpdb->insert_id;
                    // var_dump($datas);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        }
    }
}

function xmlParse($data)
{
    global $wpdb;
    $company = null;
    $list = array();
    $datas = array();
    //fix data table
    $table = $wpdb->prefix . 'databank';
    //Get all users
    $users = get_users();

    $website_urls = [
        [
            '112bhv-20231101.1430.xml',
            '2xplain-b.v-20230925.0140.xml',
            'agile-scrum-group-20230922.1323.xml',
            'anker-kompas-20230922.1323.xml',
            'aeres-tech-20230925.0141.xml',
        ],
        [
            'edumia-20231024.1105.xml',
            'academie-voor-arbeidsmarktcommunicatie-b.v-20230925.0141.xml',
            'beeckestijn-20231101.2250.xml',
            'berenschot-20231101.1421.xml',
            'bhv.nl-20231102.0032.xml',
        ],
        [
            'bit-academy-20231101.1430.xml',
            'blom-20231102.0026.xml',
            'bureau-vris-20231101.1431.xml',
            'buro-brand-20231101.1422.xml',
            'cm-partners-20231102.0033.xml',
        ],
        [
            'comenius-20231101.1422.xml',
            'competence-factory-20231102.0027.xml',
            'faculty-of-skills-20231101.1430.xml',
            'frankwatching-20231102.0033.xml',
            'growth-tribe-20231101.1422.xml',
        ],
        [
            'horizon-20231102.0028.xml',
            'hr-academy-20231102.0028.xml',
            'kenneth-smit-20231102.0028.xml',
            'kenneth-smit-direct-20231102.0028.xml',
            'possible-20231102.0028.xml',
        ],
        [
            'saxion-parttime-school-20231101.1423.xml',
            'scheidegger-20231102.0027.xml',
            'schouten-nelissen-20231102.0028.xml',
            'start2move-20231101.1423.xml',
            'tekkieworden-20231101.1423.xml',
        ],
        [
            'tvvl-20231101.1423.xml',
            'vijfhart-20231102.0028.xml',
            'winc-academy-20231101.1423.xml',
            'yearth-academy-20231102.0029.xml',
        ],
    ];

    $args = array(
        'post_type' => 'company',
        'posts_per_page' => -1,
    );

    //Start inserting course
    echo "<h1 class='titleGroupText' style='font-weight:bold'>SCRIPT XML PARSING</h1>";

    foreach ($website_urls[$data] as $website) {
        //Get the URL content
        $file = get_stylesheet_directory_uri() . "/" . $website;
        $xml = simplexml_load_file($file);
        $data_xml = $xml->program;

        $author_id = null;

        echo "<h3>" . $data_xml[0]->programClassification->orgUnitId . " running <i class='fas fa-spinner fa-pulse'></i></h3><br><br>";

        //Retrieve courses
        // $i = 0;
        foreach ($data_xml as $key => $datum) {

            $status = 'extern';
            $course_type = "Opleidingen";
            $image = "";

            /*
            Get the url media image
             */
            foreach ($datum->programDescriptions->media as $media) {
                if ($media->type == "image") {
                    $image = $media->url;
                    break;
                }
            }

            //Redundance check "Image & Title"
            $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s", strval($image));
            $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", strval($datum->programDescriptions->programName));

            if ($image != "") {
                $check_image = $wpdb->get_results($sql_image);
            } else {
                $check_image = 1;
            }

            $check_title = $wpdb->get_results($sql_title);

            $post = array(
                'short_description' => $datum->programDescriptions->programSummaryText,
                'long_description' => null,
                'agenda' => $datum->programDescriptions->programDescriptionText,
                'url_image' => $image,
                'prijs' => $datum->programSchedule->genericProgramRun->cost->amount,
                'prijsvat' => $datum->programSchedule->genericProgramRun->cost->amountVAT,
                'degree' => $datum->programClassification->degree,
                'teacher_id' => $datum->programCurriculum->teacher->id,
                'org' => $datum->programClassification->orgUnitId,
                'duration_day' => $datum->programClassification->programDuration,
            );

            $attachment_xml = array();
            $data_locaties_xml = array();

            /*
             ** -- Main fields --
             */

            $company = null;
            $users = get_users();

            //Implement author of this course
            foreach ($users as $user) {
                $company_user = get_field('company', 'user_' . $user->ID);

                if (strtolower($company_user[0]->post_title) == strtolower(strval($post['org']))) {
                    $author_id = $user->ID;
                    $company = $company_user[0];
                    $company_id = $company_user[0]->ID;
                }
            }

            if (!$author_id) {
                

                $companies = get_posts($args);
                foreach ($companies as $value) {
                    if (strtolower($value->post_title) == strval($post['org'])) {
                        $company = $value;
                        $company_id = $value->ID;
                        break;
                    }
                }

                $login = RandomString();
                $password = RandomString();
                $random = RandomString();
                $email = "author_" . strval($datum->programClassification->orgUnitId) . $random . "@expertise.nl";
                $first_name = (explode(' ', strval($datum->programCurriculum->teacher->name))[0]) ?? RandomString();
                $last_name = (explode(' ', strval($datum->programCurriculum->teacher->name))[1]) ?? RandomString();
                $display_name = ($first_name) ?? RandomString();

                $userdata = array(
                    'user_pass' => $password,
                    'user_login' => $login,
                    'user_email' => $email,
                    'user_url' => 'https://livelearn.nl/inloggen/',
                    'display_name' => $display_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'role' => 'author',
                );

                $author_id = wp_insert_user(wp_slash($userdata));
            }

            //Accord the author a company
            if (!is_wp_error($author_id)) {
                update_field('company', $company, 'user_' . $author_id);
            }

            //Fill the company if do not exist "next-version"

            $title = explode(' ', strval($datum->programDescriptions->programName));
            $description = explode(' ', strval($datum->programDescriptions->programSummaryText));
            $description_html = explode(' ', strval($datum->programDescriptions->programSummaryHtml));
            $keywords = array_merge($title, $description, $description_html);

            if (!empty($keywords)) {
                // Value : course type
                if (in_array('masterclass:', $keywords) || in_array('Masterclass', $keywords) || in_array('masterclass', $keywords)) {
                    $course_type = "Masterclass";
                } else if (in_array('(training)', $keywords) || in_array('training', $keywords) || in_array('Training', $keywords)) {
                    $course_type = "Training";
                } else if (in_array('live', $keywords) && in_array('seminar', $keywords)) {
                    $course_type = "Webinar";
                } else if (in_array('Live', $keywords) || in_array('Online', $keywords) || in_array('E-learning', $keywords)) {
                    $course_type = "E-learning";
                } else {
                    $course_type = "Opleidingen";
                }

            }

            // Value : description
            if ($datum->programDescriptions->programDescriptionHtml) {
                $descriptionHtml = $datum->programDescriptions->programDescriptionHtml;
            } else {
                $descriptionHtml = $datum->programDescriptions->programDescriptionText;
            }

            /*
             * * -- Other fields --
             */

            /*
            Tags *
             */
            $tags = array();
            $onderwerpen = "";
            $categories = array();
            $cats = get_categories(array(
                'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'orderby' => 'name',
                'exclude' => 'Uncategorized',
                'parent' => 0,
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ));

            foreach ($cats as $item) {
                $cat_id = strval($item->cat_ID);
                $item = intval($cat_id);
                array_push($categories, $item);
            }
            ;

            $bangerichts = get_categories(array(
                'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent' => $categories[1],
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ));

            $functies = get_categories(array(
                'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent' => $categories[0],
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ));

            $skills = get_categories(array(
                'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent' => $categories[3],
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ));

            $interesses = get_categories(array(
                'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent' => $categories[2],
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ));

            $categorys = array();
            foreach ($categories as $categ) {
                //Topics
                $topics = get_categories(
                    array(
                        'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                        'parent' => $categ,
                        'hide_empty' => 0, // change to 1 to hide categores not having a single post
                    )
                );

                foreach ($topics as $value) {
                    $tag = get_categories(
                        array(
                            'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                            'parent' => $value->cat_ID,
                            'hide_empty' => 0,
                        )
                    );
                    $categorys = array_merge($categorys, $tag);
                }
            }

            foreach ($datum->programDescriptions->searchword as $searchword) {
                $searchword = strtolower(strval($searchword));
                foreach ($categorys as $category) {
                    $cat_slug = strval($category->slug);
                    $cat_name = strval($category->cat_name);
                    if (strpos($searchword, $cat_slug) !== false) {
                        if (!in_array($category->cat_ID, $tags)) {
                            array_push($tags, $category->cat_ID);
                        }
                    }

                }
            }

            if (empty($tags)) {
                $occurrence = array_count_values(array_map('strtolower', $keywords));
                arsort($occurrence);
                foreach ($categorys as $value) {
                    if ($occurrence[strtolower($value->cat_name)] >= 1) {
                        if (!in_array($value->cat_ID, $tags)) {
                            array_push($tags, $value->cat_ID);
                        }
                    }
                }

            }

            //Final value : categorie
            $onderwerpen = join(',', $tags);
            /*
            End *
             */

            /*
            Get the url media image & attachment to display on front
             */
            $attachment = array();
            foreach ($datum->programDescriptions->media as $media) {
                if ($media->type == "image") {
                    $image = $media->url;
                } else {
                    array_push($attachment, $media->url);
                }

            }
            $attachment_xml = join(',', $attachment);
            /*
             ** END
             */

            $data_locaties_xml = array();
            $data_locaties = null;
            /*
            Modify the dates
             */
            if (!empty($datum->programSchedule->programRun)) {
                foreach ($datum->programSchedule->programRun as $program) {
                    $info = array();
                    $infos = "";
                    $row = "";
                    foreach ($program->courseDay as $key => $courseDay) {
                        $dates = explode('-', strval($courseDay->date));
                        //format date
                        $date = $dates[2] . "/" . $dates[1] . "/" . $dates[0];

                        $info['start_date'] = $date . " " . strval($courseDay->startTime);
                        $info['end_date'] = $date . " " . strval($courseDay->endTime);
                        $info['location'] = strval($courseDay->location->city);
                        $info['adress'] = strval($courseDay->location->address);

                        $row = $info['start_date'] . '-' . $info['end_date'] . '-' . $info['location'] . '-' . $info['adress'];

                        $infos .= $row;

                        $infos .= ';';

                    }

                    if (substr($infos, -1) == ';') {
                        $infos = rtrim($infos, ';');
                    }

                    array_push($data_locaties_xml, $infos);
                }

                $data_locaties = join('~', $data_locaties_xml);
            }

            /*
             * * END
             */

            /*
             * * Data to create the course
             */
            $post = array(
                'titel' => strval($datum->programDescriptions->programName),
                'type' => $course_type,
                'videos' => null,
                'short_description' => strval($datum->programDescriptions->programSummaryText),
                'long_description' => $descriptionHtml,
                'duration' => strval($datum->programClassification->programDuration),
                'agenda' => strval($datum->programDescriptions->programDescriptionText),
                'image_xml' => strval($image),
                'attachment_xml' => $attachment_xml,
                'prijs' => intval($datum->programSchedule->genericProgramRun->cost->amount),
                'prijs_vat' => intval($datum->programSchedule->genericProgramRun->cost->amountVAT),
                'level' => strval($datum->programClassification->degree),
                'teacher_id' => $datum->programCurriculum->teacher->id,
                'org' => strval($datum->programClassification->orgUnitId),
                'onderwerpen' => $onderwerpen,
                'date_multiple' => $data_locaties,
                'course_id' => strval($datum->programClassification->programId),
                'author_id' => $author_id,
                'company_id' => $company_id,
                'status' => $status,
            );
            $where = ['titel' => strval($datum->programDescriptions->programName)];
            $updated = $wpdb->update($table, $post, $where);

            if (!isset($check_image[0]) && !isset($check_title[0])) {

                $wpdb->insert($table, $post);
                $post_id = $wpdb->insert_id;
                // $post_id = 1;

                echo $wpdb->last_error;

                echo "<span class='textOpleidRight'> Course_ID: " . $datum->programClassification->programId . " - Insertion done successfully <br><br></span>";

            } else {
                $course = array(1);

                if (empty($course)) {
                    echo "****** Course # " . strval($datum->programDescriptions->programName) . " not detected anymore<br><br>";
                } else {

                    $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", $post['titel']);

                    $course = $wpdb->get_results($sql)[0];

                    $change = false;
                    $message = 'field on change detected and applied<br><br>';

                    if ($post['type'] != $course->type) {
                        $datas = ['type' => $post['type']]; // NULL value.
                        $where = ['id' => $course->id];
                        $updated = $wpdb->update($table, $data, $where);

                        echo '****** Type of course - ' . $message;
                        $change = true;
                    }

                    if ($post['author_id'] != $course->author_id) {
                        $datas = ['author_id' => $author_id]; // NULL value.
                        $where = ['id' => $course->id];
                        $updated = $wpdb->update($table, $data, $where);

                        echo '****** Author - ' . $message;
                        $change = true;
                    }

                    if ($post['company_id'] != $course->company_id) {
                        $datas = ['company_id' => $company_id]; // NULL value.
                        $where = ['id' => $course->id];
                        $updated = $wpdb->update($table, $data, $where);

                        echo '****** Company - ' . $message;
                        $change = true;
                    }

                    if (!$change) {
                        echo '*** ~ *** No change found for this course ! *** ~ ***<br><br>';
                    } else {
                        echo '<br><br>';
                    }

                }
            }
        }

        echo "<h2 class='titleGroupText'> End .</h2>";
    }
}
