<?php /** Template Name: Get & Save Artikles*/?>
<?php
require_once 'add-author.php';
require_once 'detect-language.php';
global $wpdb;

extract($_POST);

$company = null;
$table = $wpdb->prefix . 'databank';
$data_insert = 0;

if (isset($selectedValues)) {
    foreach ($selectedValues as $option) {
        $author_id = 0;
        $website = $option['value'];
        $key = $option['text'];

        // Get author and company information
        $informations = addAuthor(get_users(), $key);
        $author_id = $informations['author'];
        $company_id = $informations['company'];

        // Fetch articles from the WordPress API
        $span = $website . "wp-json/wp/v2/posts/";
        $artikels = json_decode(file_get_contents($span), true);

        // Process each article
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

    if ($data_insert == 1) {
        echo "<span class='alert alert-success'>Articles inserted or updated successfully ✔️</span>";
    } else {
        echo "<span class='alert alert-danger'>No new data! ❌</span>";
    }
} else {
    echo "<span class='alert alert-danger'>Please select the company key to be able to upload Articles ❌</span>";
}


// header("location:/livelearn/databank");
?>

