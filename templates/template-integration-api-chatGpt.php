<?php /** Template Name: chatgtp api */ ?>
<?php
global $wpdb;
//chatgpt-api/
extract($_POST);
// Paramètres of request
$endpoint = 'https://api.openai.com/v1/chat/completions';
$api_key = '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';
//$api_key = "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";
$model = 'gpt-3.5-turbo';
//$question = 'Who won the world series in 2020?';

$data = array(
    'model' => $model,
    'messages' => array(
        array('role' => 'system', 'content' => 'You are a helpful assistant.'),
        array('role' => 'user', 'content' => $question)
    )
);
$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key,
    // 'OpenAI-Organization: org-lSyxeDYZcwIvw8MZKNwj3Rl2'
);

// Conversion des données en format JSON
$json_data = json_encode($data);

// Configuration de la requête CURL

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to disable secure of open ssl
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Envoi de la requête et récupération de la réponse
// request
$response = curl_exec($ch);
curl_close($ch);

// Traitement de la réponse JSON
$result = json_decode($response, true);
echo "<pre>";
if (!isset($result['choices'][0]['message']['content'])) {
    $answer = $result['choices'][0]['message']['content'];
    //echo 'Réponse : ' . $answer;
} else {
    echo 'Aucune réponse n\'a été reçue.';
}
/** ************************************************************* */
echo "<form method='post' action='/livelearn/chatgpt-api/'>
    <input type='text' name='question' placeholder='question'>
<input type='submit' name='submit' value='submit'>
      </form>
";


//$question = "I'm looking for a cpurse abput inf";

// Exécutez la requête de recherche avec WP_Query.
$except=[
   ";",",","I","a","am","I'm","I'm looking","and","for",
    "I am looking","I'm looking for","I am looking for",
    "I'm looking for a","I am looking for a",
    "I'm looking for a course","I am looking for a course",
    "I'm looking for a course about","I am looking for a course about",
    "I'm looking for a course about inf",
    "I am looking for a course about inf",
    "I'm looking for a course about inf"
];
if (isset($question)) {
    echo "<h1>Question : " . $question . "</h1>";
    $questions = explode(' ', $question);
    $questions = array_unique($questions);
    foreach ($questions as $question) {
        if (!in_array($question,$except)) {
            $args = array(
                'post_type' => 'course',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                's' => $question,
                'orderby' => 'title',
                'order' => 'ASC',
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                echo "<h6>Question : " . $question . "</h6>";
                while ($query->have_posts()) {
                    $query->the_post();
                    echo "<h3> tittle course : " . get_the_title() . "</h3>";
                    echo "<h3> id course : " . get_the_ID() . "</h3>";
                    echo "<h4> author : " . get_the_author() . "</h4><hr>";
                }
            } else {
                echo "<h2>No results for : " . $question . "</h2>";
            }
        }
    }
}
    wp_reset_postdata(); // Réinitialisez les données des articles pour éviter d'interférer avec les autres requêtes ultérieures
?>



