<?php /** Template Name: youtube playlist */ ?>
<?php
//youtube-playlist
extract($_POST);
if ($playlist_youtube){
    $fileName = get_stylesheet_directory_uri()."/files/Big-Youtube-list-Correct.csv";
    $file = fopen($fileName, 'r');
    if ($file) {
        while ($row = fgetcsv($file)){
            $line1 = $row[0]; //url youtube
            $line2 = $row[1]; //
            $line3 = $row[2]; //list Url
            $line4 = $row[3]; //Type
            $line5 = $row[4]; // Expert name
            $line6 = $row[5]; // Company name
            $line7 = $row[6]; //Sub-topics
            $line8 = $row[7]; //YouTube account

            echo "line 1 : $line1, line 2 : $line2,line 3 : $line3, line 4 : $line4,line 5 : $line5, line 6 : $line6,line 7 : $line7, line 8 : $line8 <br>";
        }
        fclose($file);
    }else
        echo "Erreur lors de l'ouverture du fichier.";
}
