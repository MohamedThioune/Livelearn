<?php /** Template Name: Get & Save Artikles*/?>
<?php
require 'add-author.php';
global $wpdb;

extract($_POST);

$company = null;

$table = $wpdb->prefix . 'databank';

$users = get_users();
$args = array(
    'post_type' => 'company',
    'posts_per_page' => -1,
);
var_dump($selectedValues);
$companies = get_posts($args);
if (isset($selectedValues)) {
    
    foreach ($selectedValues as $option) {
        $author_id=0;
        $website = $option['value'];
        $key = $option['text'];

        $company_id = 0;


        // function add Author  in addAuthor.php
        $informations=addAuthor($users,$key);
         $author_id= $informations['author'];
         $company_id=$informations['company'];


        $span = $website . "wp-json/wp/v2/posts/";
        $artikels = json_decode(file_get_contents($span), true);
        foreach ($artikels as $article) {
            // $onderwerpen = trim($onderwerpen);

            if ($article != null) {
                $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank where titel=%s and type=%s", array($article['title']['rendered'], 'Artikel'));
                $result_title = $wpdb->get_results($sql_title);
                
                // var_dump($article['excerpt']['rendered']);
                // die;
            if ($article['content']['rendered']!='') {
                if ($article['excerpt']['rendered']==''){
                    $firstSentence = explode('.',$article['content']['rendered']);
                    $article['excerpt']['rendered'] = $firstSentence[0];
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
                var_dump('no content');
                continue;
            }
            // echo "Selected option: $text (value=$value)<br>";
            try
            {
                
                $wpdb->insert($table, $datas);
                // echo $key."  ".$wpdb->last_error."<br>";
                $id_post = $wpdb->insert_id;
        
                echo "<span class='alert alert-success'>Articles inserted successfuly ✔️</span>";
                // var_dump($datas);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            }
        }
    }
}
// header("location:/livelearn/databank");
?>

