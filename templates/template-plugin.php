<?php /** Template Name: Get & Save Artikles*/?>
<?php
require_once 'add-author.php';
global $wpdb;

extract($_POST);

$company = null;

$table = $wpdb->prefix . 'databank';

$users = get_users();
$args = array(
    'post_type' => 'company',
    'posts_per_page' => -1,
);
$companies = get_posts($args);
$data_insert = 0;
if (isset($selectedValues)) {
    
    foreach ($selectedValues as $option) {
        $author_id=0;
        $website = $option['value'];
        $key = $option['text'];

        $company_id = 0;


        // function add Author  in addAuthor.php
        $informations = addAuthor($users,$key);
        $author_id = $informations['author'];
        $company_id = $informations['company'];

        //recuperer les posts depuis l'API wordpress
        $span = $website . "wp-json/wp/v2/posts/";
        $artikels = json_decode(file_get_contents($span), true);
        //Parcourir chaque article
        foreach ($artikels as $article) {
            // $onderwerpen = trim($onderwerpen);
            // verifier si l'article est non null 
            if ($article != null) {
                //si oui, recuperer le titre depuis le databank
                $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank where titel=%s and type=%s", array($article['title']['rendered'], 'Artikel'));
                $result_title = $wpdb->get_results($sql_title);
                
                //var_dump($article['excerpt']['rendered']);
                //die;
                //si le contenu de l'article est non null 
                if ($article['content']['rendered'] != '') {
                    if ($article['excerpt']['rendered'] == ''){
                        $firstSentence = explode('.',$article['content']['rendered']);
                        $article['excerpt']['rendered'] = $firstSentence[0];
                        //Pourquoi couper ce contenu a 1e phrase ?  @MaxBird to @Fallou
                    }

                    // var_dump($article['excerpt']['rendered']);
                    if ($article['featured_media'] != 0) {
                        $span2 = $website . "wp-json/wp/v2/media/" . $article['featured_media'];
                        $images = json_decode(file_get_contents($span2), true);
                        // $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s AND type = %s", array($images['guid']['rendered'], 'Artikel'));
                        // $result_image = $wpdb->get_results($sql_image);

                        if (/*!isset($result_image[0]) && */!isset($result_title[0])) {
                            if (!isset($images['data']['status'])) {
                                $status = 'extern';
                                $datas = array(
                                    'titel' => $article['title']['rendered'],
                                    'type' => 'Artikel',
                                    'videos' => null,
                                    'short_description' => strip_html_tags($article['excerpt']['rendered']),
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
                            }else{
                                $status = 'extern';
                                $datas = array(
                                    'titel' => $article['title']['rendered'],
                                    'type' => 'Artikel',
                                    'videos' => null,
                                    'short_description' => strip_html_tags($article['excerpt']['rendered']),
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
                        }else continue;
                    }else{
                        if (!isset($result_title[0])) {
                            $status = 'extern';
                            $datas = array(
                                'titel' => $article['title']['rendered'],
                                'type' => 'Artikel',
                                'videos' => null,
                                'short_description' => strip_html_tags($article['excerpt']['rendered']),
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
                }else{
                    continue;
                }
         
                if($wpdb->insert($table, $datas)){
                   $id_post = $wpdb->insert_id;
                   $data_insert=1;
                }            
            }
        }
    }

    if( $data_insert==1)
      echo "<span class='alert alert-success'>Articles inserted successfuly ✔️</span>";
    else
      echo "<span class='alert alert-danger'>Articles not founded so we have any inserted ❌</span>";
  
}
else{
    echo "<span class='alert alert-danger'>Please select the company key to be able to upload Articles ❌</span>";
}
// header("location:/livelearn/databank");
?>

