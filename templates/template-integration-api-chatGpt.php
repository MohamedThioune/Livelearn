<?php /** Template Name: chatgtp api */ ?>
<?php
global $wpdb;
//chatgpt-api/
extract($_POST);
// Paramètres of request
$endpoint = 'https://api.openai.com/v1/chat/completions';
//$api_key = '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'; //just for tested no quota
$api_key = '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'; //paid by Daniel
//$model = 'gpt-4';
//$model = 'gpt-3.5-turbo';
$model = 'text-davinci-003';

echo "
    <form method='post' action='/chatgpt-api/'> 
        <input type='text' name='question' placeholder='question'>
        <input type='submit' name='submit' value='submit'>
    </form> ";

$args = array(
    'post_type' => array('course', 'post'),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',
);

//$courses = get_posts($args);
$all_titles = "";

//foreach ($courses as $cours){
//    $short_description = get_field('short_description',$cours->ID);
//    //$all_descriptions .= $short_description ? : '';
//    $all_titles .='"'.$cours->post_title.'" , ';
//}


$about_livelearn = "LiveLearn, founded in 2019 by Daniel van der Kolk, aims to democratize learning and development. Recognizing the challenges faced by organizations, especially small and medium-sized businesses, in attracting and retaining talent, LiveLearn focuses on making talent development accessible to all. The approach involves individualized learning, providing managers with insights into their team's development. LiveLearn distinguishes itself by combining personal guidance and technology for an optimal learning experience. The user-friendly software is designed to minimize time investment, prioritizing talent development within organizations. The data-driven approach, viewing development from the individual employee's perspective, proves impactful at an organizational level. LiveLearn operates with a global mindset, leveraging IT capabilities in both the Netherlands and Senegal, West Africa, demonstrating a belief in the universality of talent. The collaboration with Orange enables the attraction and continuous training of a diverse talent pool, reflecting LiveLearn's philosophy in its own organizational practices.";

$prompts = 'interact as assistant based on this. about livelearn :'.$about_livelearn.'tittle of courses in plateform,Generate an HTML code snippet for creating a hyperlink with the title links to guid:';

if (isset($question)) {

    $except = [
        ";",",","I","a","am","I'm","looking","and","for","can","you",
        "about","looking","hello","hi","hola","good","morning","great",
        "salut","hi","hey","there",
    ];
        echo "<h1>Question : $question </h1>";
        $tittles = "";
        $questions = explode(' ', $question);
        $questions = array_unique($questions);
        foreach ($questions as $question) {
            if (in_array($question,$except))
                continue;

            $args = array(
                'post_type' => array('course', 'post'),
                'post_status' => 'publish',
                'posts_per_page' => -1,
                's' => $question,
                'orderby' => 'title',
                'order' => 'ASC',
            );
//            $query = new WP_Query($args);
//            if ($query->have_posts()) {
//                while ($query->have_posts()) {
//                    $query->the_post();
//                    $tittles .=get_the_title().",";
//                    var_dump(get_the_title());
//                }
//            }
            $course_founded = get_posts($args);
            foreach ($course_founded as $key => $course){
                $title = $course->post_title;
                $guid = $course->guid;
                $tittles .= "($title,$guid),";
                //$tittles .= "<a href='$guid'>$course->post_title</a>,";
                if ($key == 2){
                    break;
                }
            }
        }
        $tittles = substr($tittles,0,-1);

    wp_reset_postdata(); // Réinitialisez les données des articles pour éviter d'interférer avec les autres requêtes ultérieures
    $prompts.=$tittles;
    $prompts = $tittles ? $prompts : "";

    //echo "<h1>" . strlen($prompts) . "</h1>";
    //print_r($prompts);die;
        $data = array(
            'model' => 'gpt-3.5-turbo-0613',
            'messages'=> array(
                array(
                'role' => 'system',
                    'content' => $prompts
                ),
                array(
                    'role' => 'assistant',
                     'content' => $question
                )
            ),
            'temperature' => 0.3,
            'top_p' => 1,
            'frequency_penalty' => 1,
            'presence_penalty' => 1,
        );
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key,
        );
        $json_data = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to disable secure of open ssl
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
            if ($result) {
                if ($result['error'] || $result['warning']) {
                    $type_messe = $result['error'] ? 'error' : 'warning';
                    echo "ERROR : \n" . $result[$type_messe]['message'];
                } else {
                    $message = $result['choices'][0]['message']['content'];
                    print_r($message);

//                    preg_match_all('/\b\d+\.\s(.*?)(?=\b\d+\.\s|\z)/s', $message, $resultats);
//                    foreach ($resultats[1] as $resultat) {
//                        echo "<h4>".$resultat . "</h4>";
//                    }
                }
            }

}
