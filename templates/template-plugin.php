<?php /** Template Name: Get & Save Artikles*/?>

<?php
global $wpdb;
    // $url="https://ynno.com";
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
    ];
    $table = $wpdb->prefix.'databank';
    foreach($websites as $url){
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
                if ($article['featured_media']!= 0 ) {
                    $span2 = $url."wp-json/wp/v2/media/".$article['featured_media'];
                    $images=json_decode(file_get_contents($span2),true);
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
                        'onderwerpen' => '', 
                        'date_multiple' =>  NULL, 
                        'course_id' => null,
                        'author_id' => $article['author']['rendered'],
                        'company_id' =>  $article['company']['rendered'],
                        'contributors' => null,
                        'status' => $status
                    );
                }else{
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
                        'onderwerpen' => '', 
                        'date_multiple' =>  NULL, 
                        'course_id' => null,
                        'author_id' => $article['author']['rendered'],
                        'company_id' =>  $article['company']['rendered'],
                        'contributors' => null,
                        'status' => $status
                    );
                }
                $wpdb->insert($table,$data);
                $id_post = $wpdb->insert_id;
            }
            // var_dump($data);
        }
        header('location: /databank');
    }
?>