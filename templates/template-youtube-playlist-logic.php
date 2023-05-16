<?php /** Template Name: youtube playlist */ ?>
<?php
//youtube-playlist
global $wpdb;

$table = $wpdb->prefix . 'databank';
$api_key = "AIzaSyB0J1q8-LdT0994UBb6Q35Ff5ObY-Kqi_0";
$maxResults = 45;

$users = get_users();

$author_id = 0;

extract($_POST);
if ($playlist_youtube){
    $fileName = get_stylesheet_directory_uri()."/files/Big-Youtube-list-Correct.csv";
    $file = fopen($fileName, 'r');
    if ($file) {
        $idPlaylists = array();
        $urlPlaylist = [];

        while ($line = fgetcsv($file)){
            $row = explode(';',$line[0]);
            $idPlaylists [] = $row[2];
            //$urlPlaylist [] = $row[0];
        }
        fclose($file);
    }else {
        echo "<span class='text-center alert alert-danger'>not possible to read the file</span>";
    }
    array_shift($idPlaylists); //remove the tittle of the colone
    var_dump($idPlaylists);
}
