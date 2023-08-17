<?php
/** Artikels Endpoints */
global $wpdb;
function RandomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    $rand = '';
    for ($i = 0; $i < 10; $i++) {
        $rand = $characters[rand(0, strlen($characters))];
        $randstring .= $rand;
    }
    return $randstring;
}

function strip_html_tags($text)
{
    $allowed_tags = ['h2', 'br', 'strong', 'em', 'u', 'blockquote', 'ul', 'ol', 'li'];
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
    $table = $wpdb->prefix . 'databank';
    $datas = array();

    $list_company = [
        [
            'WorkPlace Academy' => 'https://workplaceacademy.nl/',
            'Ynno' => 'https://www.ynno.com/',
            'DeZZP' => 'https://www.dezzp.nl/',
            'Aestate' => 'https://www.aestate.nl/',
            'Alba Concepts' => 'https://albaconcepts.nl/',
            'AM' => 'https://www.am.nl/',
            // 'Limoonworks'=>'https://limoonworks.nl/',
            // 'DWA'=>'https://www.dwa.nl/',
            'Van Spaendonck' => 'https://www.vanspaendonck.nl/',
            'PTG-advies' => 'https://ptg-advies.nl/',
            'Rever' => 'https://rever.nl/',
            'Reworc' => 'https://www.reworc.com/',
            'Sweco' => 'https://www.sweco.nl/',
            'Co-pilot' => 'https://www.copilot.nl/',
            'Agile Scrum Group' => 'https://agilescrumgroup.nl/',
        ],
        [
            'Horizon' => 'https://horizontraining.nl/',
            'Kenneth Smit' => 'https://www.kennethsmit.com/',
            'Autoblog' => 'https://www.autoblog.nl/',
            'Crypto university' => 'https://www.cryptouniversity.nl/',
            'WineLife' => 'https://www.winelife.nl/',
            'Perswijn' => 'https://perswijn.nl/',
            'Koken met Kennis' => 'https://www.kokenmetkennis.nl/',
            // 'Minkowski'=>'https://minkowski.org/',
            'KIT publishers' => 'https://kitpublishers.nl/',
            'BeByBeta' => 'https://www.betastoelen.nl/',
            'Zooi' => 'https://zooi.nl/',
            'Growth Factory' => 'https://www.growthfactory.nl/',
            'Influid' => 'https://influid.nl/',
            'MediaTest' => 'https://mediatest.nl/',
            'MeMo2' => 'https://memo2.nl/',
        ],
        [
            'Impact Investor' => 'https://impact-investor.com/',
            'Equalture' => 'https://www.equalture.com/',
            'Zorgmasters' => 'https://zorgmasters.nl/',
            'AdSysco' => 'https://adsysco.nl/',
            'Transport en Logistiek Nederland' => 'https://www.tln.nl/',
            'Financieel Fit' => 'https://www.financieelfit.nl/',
            'Business Insider' => 'https://www.businessinsider.nl/',
            'Frankwatching' => 'https://www.frankwatching.com/',
            // 'MarTech'=>'https://martech.org/',
            'Search Engine Journal' => 'https://www.searchenginejournal.com/',
            // 'Search Engine Land'=>'https://searchengineland.com/',
            'TechCrunch' => 'https://techcrunch.com/',
            'The Bruno Effect' => 'https://magazine.thebrunoeffect.com/',
            'Crypto Insiders' => 'https://www.crypto-insiders.nl/',
            'HappyHealth' => 'https://happyhealthy.nl/',
        ],
        [
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
        ],
        [
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
        ],
        [
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
        ],
        [
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
        ],
        [
            'The Future Organization' => 'https://thefutureorganization.com/',
        ],
    ];

    $users = get_users();

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

            // $onderwerpen = trim($onderwerpen);

            if ($article != null) {
                $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank where titel=%s and type=%s", array($article['title']['rendered'], 'Artikel'));
                $result_title = $wpdb->get_results($sql_title);
                if ($article['featured_media'] != 0) {
                    $span2 = $website . "wp-json/wp/v2/media/" . $article['featured_media'];
                    $images = json_decode(file_get_contents($span2), true);
                    $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s AND type = %s", array($images['guid']['rendered'], 'Artikel'));
                    $result_image = $wpdb->get_results($sql_image);
                    if (!isset($result_image[0]) && !isset($result_title[0])) {
                        if (!isset($images['data']['status']) && $images['data']['status'] != 404 && $images['data']['status'] != 401) {
                            $status = 'extern';
                            $datas = array(
                                'titel' => $article['title']['rendered'],
                                'type' => 'Artikel',
                                'videos' => null,
                                'short_description' => $article['excerpt']['rendered'],
                                'long_description' => htmlspecialchars(strip_tags($article['content']['rendered'])),
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
                                'short_description' => $article['excerpt']['rendered'],
                                'long_description' => htmlspecialchars(strip_tags($article['content']['rendered'])),
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
                } else {
                    if (!isset($result_title[0])) {
                        $status = 'extern';
                        $datas = array(
                            'titel' => $article['title']['rendered'],
                            'type' => 'Artikel',
                            'videos' => null,
                            'short_description' => $article['excerpt']['rendered'],
                            'long_description' => htmlspecialchars(strip_tags($article['content']['rendered'])),
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
                    // $wpdb->insert($table, $datas);
                    // echo $key."  ".$wpdb->last_error."<br>";
                    // $id_post = $wpdb->insert_id; 
                    var_dump($datas);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        }
    }
}
