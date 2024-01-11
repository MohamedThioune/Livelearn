<?php /** Template Name: Databank */?>

<?php

global $wpdb;

/*
 * * Pagination
 */
$pagination = 50;

if (isset($_GET['id'])) 
    $page = intval($_GET['id']);

if ($page) 
    $offset = ($page - 1) * $pagination;

if (isset($_POST['type'])) {
    switch (strtolower($_POST['type'])) {
        case 'all':
            $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
            $courses = $wpdb->get_results($sql);
            $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0");
            $count = $wpdb->get_results($sql_count);
            $count = intval($count[0]->{'COUNT(*)'});
            break;
        case 'artikel':
            $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d and type = 'Artikel' ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
            $courses = $wpdb->get_results($sql);
            $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0 and type='Artikel'");
            $count = $wpdb->get_results($sql_count);
            $count = intval($count[0]->{'COUNT(*)'});
            break;
        case 'podcast':
            $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d and type = 'Podcast' ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
            $courses = $wpdb->get_results($sql);
            $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0 and type='Podcast'");
            $count = $wpdb->get_results($sql_count);
            $count = intval($count[0]->{'COUNT(*)'});
            break;
        case 'videos': 
            $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d and type = 'Videos' ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
            $courses = $wpdb->get_results($sql);
            $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0 and type='Videos'");
            $count = $wpdb->get_results($sql_count);
            $count = intval($count[0]->{'COUNT(*)'});
            break;
        case 'courses':
            $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d and type='Opleidingen' or type='Workshop' or type='Training' or type='Masterclass' or type='E-learning' or type='Lezing' or type='Event' or type='Webinar' ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
            $courses = $wpdb->get_results($sql);
            $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0 and type='Opleidingen' or type='Workshop' or type='Training' or type='Masterclass' or type='E-learning' or type='Lezing' or type='Event' or type='Webinar'");
            $count = $wpdb->get_results($sql_count);
            $count = intval($count[0]->{'COUNT(*)'});
            break;
        default:
            $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
            $courses = $wpdb->get_results($sql);
            $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0");
            $count = $wpdb->get_results($sql_count);
            $count = intval($count[0]->{'COUNT(*)'});
            break;

    }
}
else {
    $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = %d ORDER BY id DESC LIMIT %d OFFSET %d ", array(0, $pagination, $offset));
    $courses = $wpdb->get_results($sql);
    $sql_count = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}databank WHERE state = 0");
    $count = $wpdb->get_results($sql_count);
    $count = intval($count[0]->{'COUNT(*)'});
}

if ($count % $pagination == 0) 
    $pagination_number = $count / $pagination;
else 
    $pagination_number = intval($count / $pagination) + 1;

$user = wp_get_current_user();
// $websites = ['smartwp','DeZZP','fmn','duurzaamgebouwd','adformatie','morethandrinks','sportnext','nbvt','vsbnetwerk','tvvl','nedverbak','tnw','changeINC','--------------------------','nvab','vbw','kndb','fgz','cvah','nbov','nuvo','CBD','Hoorzaken','Knvvn','Nvtl','stiba','Nfofruit','Iro','Lto','cbm','tuinbranche','jagersvereniging','Wapned','Dansbelang','Pictoright','Ngb','Griffiers','Nob','Bijenhouders','BBKnet','AuteursBond','ovfd','Adfiz','nvvr','Veneca','Sloopaannemers','Noa'];
$websites = ['smartwp', 'fmn', 'duurzaamgebouwd', 'adformatie', 'morethandrinks', 'sportnext', 'nbvt', 'vsbnetwerk', 'tvvl', 'nedverbak', 'tnw', 'changeINC', '--------------------------', 'nvab', 'vbw', 'kndb', 'fgz', 'cvah', 'nbov', 'nuvo', 'CBD', 'Hoorzaken', 'Knvvn', 'Nvtl', 'stiba', 'Nfofruit', 'Iro', 'Lto', 'cbm', 'tuinbranche', 'jagersvereniging', 'Wapned', 'Dansbelang', 'Pictoright', 'Ngb', 'Griffiers', 'Nob', 'Bijenhouders', 'BBKnet', 'AuteursBond', 'ovfd', 'Adfiz', 'nvvr', 'Veneca', 'Sloopaannemers', 'Noa'];

$urls =
    [
        'WorkPlace Academy' => 'https://workplaceacademy.nl/',
        'Ynno' => 'https://www.ynno.com/',
        // 'DeZZP'=>'https://www.dezzp.nl/',
        'Aestate' => 'https://www.aestate.nl/',
        'Alba Concepts' => 'https://albaconcepts.nl/',
        'AM' => 'https://www.am.nl/',
        'Limoonworks' => 'https://limoonworks.nl/',
        'DWA' => 'https://www.dwa.nl/',
        'Van Spaendonck' => 'https://www.vanspaendonck.nl/',
        'PTG-advies' => 'https://ptg-advies.nl/',
        'Rever' => 'https://rever.nl/',
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
        'Koken met Kennis' => 'https://www.kokenmetkennis.nl/',
        'Minkowski' => 'https://minkowski.org/',
        'KIT publishers' => 'https://kitpublishers.nl/',
        'BeByBeta' => 'https://www.betastoelen.nl/',
        'Zooi' => 'https://zooi.nl/',
        'Growth Factory' => 'https://www.growthfactory.nl/',
        'Influid' => 'https://influid.nl/',
        'MediaTest' => 'https://mediatest.nl/',
        'MeMo2' => 'https://memo2.nl/',
        'Impact Investor' => 'https://impact-investor.com/',
        'Equalture' => 'https://www.equalture.com/',
        'Zorgmasters' => 'https://zorgmasters.nl/',
        'AdSysco' => 'https://adsysco.nl/',
        'Transport en Logistiek Nederland' => 'https://www.tln.nl/',
        'Financieel Fit' => 'https://www.financieelfit.nl/',
        'Business Insider' => 'https://www.businessinsider.nl/',
        'Frankwatching' => 'https://www.frankwatching.com/',
        'MarTech' => 'https://martech.org/',
        'Search Engine Journal' => 'https://www.searchenginejournal.com/',
        'Search Engine Land' => 'https://searchengineland.com/',
        'TechCrunch' => 'https://techcrunch.com/',
        'The Bruno Effect' => 'https://magazine.thebrunoeffect.com/',
        'Crypto Insiders' => 'https://www.crypto-insiders.nl/',
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
        'The Future Organization' => 'https://thefutureorganization.com/',
        'Arts en Auto' => 'https://www.artsenauto.nl/',
        'Discutafel' => 'https://discutafel.nl/',
        'SBVO' => 'https://sbvo.nl/',
        'Your EDM' => 'https://www.youredm.com/',
        'Metal Injection' => 'https://metalinjection.net/',
        'Classical Music' => 'https://www.classical-music.com/',
        'Slipped Disc' => 'https://slippedisc.com/',
        'The Violin Channel' => 'https://www.theviolinchannel.com/',
        'Carey Nieuwhof' => 'https://careynieuwhof.com/','Fresh'=>'https://www.stichtingfresh.nl/',
        'Werf&'=>'https://www.werf-en.nl/',
        'Monday.com'=>'https://monday.com/blog',
        'HR Knowledge'=>'https://www.hrknowledge.com/',
        'HRcommunity'=>'https://hrcommunity.nl/',
        'Leeuwendaal'=>'https://www.leeuwendaal.nl/',
        '&Samhoud'=>'https://www.samhoudconsultancy.com/',
        'Incontext'=>'https://incontext.nl/',
        'Successday'=>'https://successday.nl/',
        'Hospitality Group'=>'https://www.hospitality-group.nl/',
        'AllChiefs'=>'https://allchiefs.nl/',
        'BTS'=>'https://bts.com/',
        'Fakton'=>'https://www.fakton.com/',
        'bbn'=>'https://bbn.nl/',
        'Over morgen'=>'https://overmorgen.nl/',
        'Beaufort'=>'https://www.beaufortconsulting.nl/',
        'Redept'=>'https://redept.nl/',
        'Akro'=>'https://akroconsult.nl/',
        'AT osborne'=>'https://atosborne.nl/',
        'Brink'=>'https://www.brink.nl/',
        'Magnus Digital'=>'https://www.magnus.nl/',
        'Lybrae'=>'https://lybrae.nl/',
        'HKA'=>'https://www.hka.com/',
        'Flux Partners'=>'https://flux.partners/',
        'TWST'=>'https://www.twst.nl/',
        'Contakt'=>'https://contakt.nl/',
        'Group Mapping'=>'https://groupmapping.org/',
        'Newcraft'=>'https://thom.eu/',
        'PPMC'=>'https://newcraftgroup.com/',
        'Skim'=>'https://ppmc.nl/',
        'MLC'=>'https://thenextorganization.com/',
        'Salveos'=>'https://m-lc.nl/',
        'The house of Marketing'=>'https://www.artefact.com/'
        'Fresh'=>'https://www.stichtingfresh.nl/',
        'Werf&'=>'https://www.werf-en.nl/',
        'HR Knowledge'=>'https://www.hrknowledge.com/',
        'HRcommunity'=>'https://hrcommunity.nl/',
        'Leeuwendaal'=>'https://www.leeuwendaal.nl/',
        '&Samhoud'=>'https://www.samhoudconsultancy.com/',
        'Incontext'=>'https://incontext.nl/',
        'Successday'=>'https://successday.nl/',
        'Hospitality Group'=>'https://www.hospitality-group.nl/',
        'AllChiefs'=>'https://allchiefs.nl/',
        'BTS'=>'https://bts.com/',
        'Fakton'=>'https://www.fakton.com/',
        'bbn'=>'https://bbn.nl/',
        'Over morgen'=>'https://overmorgen.nl/',
        'Beaufort'=>'https://www.beaufortconsulting.nl/',
        'Redept'=>'https://redept.nl/',
        'Akro'=>'https://akroconsult.nl/',
        'AT osborne'=>'https://atosborne.nl/',
        'Brink'=>'https://www.brink.nl/',
        'Magnus Digital'=>'https://www.magnus.nl/',
        'Lybrae'=>'https://lybrae.nl/',
        'HKA'=>'https://www.hka.com/',
        'Flux Partners'=>'https://flux.partners/',
        'TWST'=>'https://www.twst.nl/',
        'Contakt'=>'https://contakt.nl/',
        'Group Mapping'=>'https://groupmapping.org/',
        'The house of Marketing'=>'https://thom.eu/',
        'PPMC'=>=>'https://ppmc.nl/',
        'Newcraft'=>'https://newcraftgroup.com/',
        'The Next Organization'=>'https://thenextorganization.com/',
        'Salveos'=>'https://salveos.nl/',
        'MLC'=>'https://m-lc.nl/',
        'Artefact'=>'https://www.artefact.com/'
    ];

$file_xml = [
    '112BHV'=>'112bhv-20231101.1430.xml',
    '2xplain'=>'2xplain-b.v-20230925.0140.xml', 
    'agile scrum group'=>'agile-scrum-group-20230922.1323.xml', 
    'Anker Kompas'=>'anker-kompas-20230922.1323.xml', 
    'Aeres Tech'=>'aeres-tech-20230925.0141.xml',
    'Edumia'=>'edumia-20231024.1105.xml',
    'Arbeidsmarktcommunicatie'=>'academie-voor-arbeidsmarktcommunicatie-b.v-20230925.0141.xml',
    'Beeckestijn'=>'beeckestijn-20231101.2250.xml',
    'berenschot'=>'berenschot-20231101.1421.xml',
    'bhv.nl'=>'bhv.nl-20231102.0032.xml',
    'BIT Academy'=>'bit-academy-20231101.1430.xml',
    'BLOM'=>'blom-20231102.0026.xml',
    'Bureau-Vris'=>'bureau-vris-20231101.1431.xml',
    'Buro Brand'=>'buro-brand-20231101.1422.xml',
    'CM Partners'=>'cm-partners-20231102.0033.xml',
    'Comenius'=>'comenius-20231101.1422.xml',
    'Competence Factory'=>'competence-factory-20231102.0027.xml',
    'Faculty of Skills'=>'faculty-of-skills-20231101.1430.xml',
    'Frankwatching'=>'frankwatching-20231102.0033.xml',
    'Growth Tribe'=>'growth-tribe-20231101.1422.xml', 
    'Horizon'=>'horizon-20231102.0028.xml',
    'HR Academy'=>'hr-academy-20231102.0028.xml',
    'Kenneth Smit'=>'kenneth-smit-20231102.0028.xml',
    'Kenneth Smit Direct'=>'kenneth-smit-direct-20231102.0028.xml',
    'Possible'=>'possible-20231102.0028.xml',
    'Saxion Parttime School'=>'saxion-parttime-school-20231101.1423.xml',
    'Scheidegger'=>'scheidegger-20231102.0027.xml',
    'Schouten Nelissen'=>'schouten-nelissen-20231102.0028.xml',
    'Start2Move'=>'start2move-20231101.1423.xml',
    'TekkieWorden'=>'tekkieworden-20231101.1423.xml',
    'TVVL'=>'tvvl-20231101.1423.xml',
    'Vijfhart'=>'vijfhart-20231102.0028.xml',
    'Winc Academy'=>'winc-academy-20231101.1423.xml',
    'Yearth Academy'=>'yearth-academy-20231102.0029.xml'
];
?>

<?php wp_head();?>
<?php get_header();?>


<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/template.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">

<body>
    <!-- Content -->
    <div class="container-fluid">
        <div class="contentListeCourseDataBank">
            <div class="cardOverviewCours">
                <?php
if (isset($_GET["message"])) {
    echo "<span class='alert alert-info'>" . $_GET['message'] . "</span><br><br>";
}

?>
               <div class="headListeCourse">
                   <p class="JouwOpleid"> <!-- Alle opleidingen --> <strong>Load From</strong> : &nbsp;
                       <a href="/youtube-v3-playlist" target="_blank"  class="JouwOpleid youtubeCourse"><img src="<?=get_stylesheet_directory_uri();?>/img/youtube.png" alt="youtube image"></a>
                       <!-- &nbsp;&nbsp;<a href="/xml-parse" target="_blank"  class="JouwOpleid youtubeCourse" style="border: #FF802B solid;"><img style="width: 35px;" width="15" src="<?//=get_stylesheet_directory_uri();?>/img/xml-orange.jpg" alt="xml image"></a> -->
                       &nbsp;&nbsp;<button id="subtopics" class="JouwOpleid youtubeCourse" style="border: #FF802B solid;" ><img style="width: 35px;" width="15" src="<?=get_stylesheet_directory_uri();?>/img/artikel.jpg" alt="load subtopics"></button>
                       <!-- &nbsp;&nbsp;<button id="playlist-youtube" class="JouwOpleid youtubeCourse" style="border: #FF802B solid;" ><img style="width: 35px;" width="15" src="<?=get_stylesheet_directory_uri();?>/img/playlist_icon.png" alt="load playlist"></button> -->
                       <!--<button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#audios-api">
                           <img src="https://api.podcastindex.org/images/pci_avatar.jpg" width="35" height="35">
                       </button>-->

                       <button type="button" title="podcast playlist" class="btn btn-info" data-toggle="modal" data-target="#playlist-audios-indexpodcast">
                           playlist audios
                           <img src="https://api.podcastindex.org/images/pci_avatar.jpg" width="40" height="40">
                       </button>

                        <div hidden="true" id="loader" class="spinner-border spinner-border-sm text-primary" role="status">
                        </div>
                    </p>

                    <div class="inpustSearchDataBank">
                        <input type="search" class="searchInputAlle" placeholder="Zoek opleidingen, experts of ondervwerpen">
                        <button class="btn btnSearchCourseDatabank">
                            <img  src="<?=get_stylesheet_directory_uri();?>/img/searchM.png" alt="youtube image">
                        </button>
                    </div>
                </div>
                <div class="container contentCardListeCourse">
                    <div class="row">
                        <br>
                        <div class="col-md-3">
                            Articles:
                            <select name="companies[]" class="multipleSelect2 form form-control col-md-6" multiple="true" id="select_company">
                                <!-- <option name="default">Choose companies</option> -->
                                <?php
                                    foreach ($urls as $key => $url) {
                                    ?>
                                    <option class="options"  value="<?=$url?>" selected="" ><?=$key?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            &nbsp;&nbsp;<a id="bouddha">✔️</a>&nbsp;&nbsp; <a class="btn-default" onclick='$(".multipleSelect2").prop("disabled", false);'  style="background:white" >⚙️</a>
                        </div>

                        <?php
                        ##youtube Script
                        $fileName = get_stylesheet_directory_uri() . "/files/Big-Youtube-list-Correct.csv";
                        $file = fopen($fileName, 'r');
                        if ($file) {
                            $playlists_id = array();
                            $ptitle = ""; 
                            $urlPlaylist = [];
                            $parameter='';
                            $playlist_title= [];
                            $youtube_parameter=array();
                            $onderwp = '';
                            $keywords = array();
                            $indice=0;
                            while ($line = fgetcsv($file)) {
                                $subtopics = "";
                                $row = explode(';', $line[0]);
                                $playlists_id[][$row[5]] = $row[3];
                                $ptitle= $row[0];
                                $subtopics = $row[7];
                                if($subtopics=="")
                                    $subtopics="";
                                $parameter=array_keys($playlists_id[$indice])[0].','.array_values($playlists_id[$indice])[0].','.$subtopics;
                                array_push($youtube_parameter,$parameter);
                                // array_shift($youtube_parameter);
                                array_push($keywords, $subtopics);
                                array_push($playlist_title,$ptitle);
                                $indice++;
                            }
                            array_shift($playlists_id);
                            // foreach($playlists_id as $pid){
                            //     echo "<pre>";
                            //     var_dump($pid);
                            //     echo "</pre><br>";
                            // }

                            array_shift($youtube_parameter);
                            // var_dump($youtube_parameter);
                            fclose($file);
                            array_shift($keywords); 
                        } else {
                            echo "<span class='text-center alert alert-danger'>not possible to read the file</span>";
                        }
                        array_shift($playlists_id);
                        array_shift($playlist_title);
                        ##END.
                        ?>

                        <div class="col-md-5 offset-md-1">
                            Youtube:
                            <select name="Youtube[]" class="multipleSelect3 form form-control col-md-6" multiple="true" id="selected_playlist">
                                <!-- <option name="default">Choose companies</option> -->
                                <?php
                                foreach ($youtube_parameter as $key=>$param) {
                                    $parameters= explode(",",$param);
                                    if(substr($parameters[1],0,2)!="PL")
                                        continue;
                                    ?>
                                    <option class="options" value="<?=$param?>" selected="" ><?=$parameters[1]?></option>
                                <?php
                                }
                                ?>
                            </select>
                            &nbsp;&nbsp;<a id="playlist-youtube">✔️</a>&nbsp;&nbsp; <a class="btn-default" onclick='$(".multipleSelect2").prop("disabled", false);'  style="background:white" >⚙️</a>
                        </div>

                        <div class="col-md-3">
                            Courses:
                            <select name="xmlfile[]" class="multipleSelect2 form form-control col-md-6" multiple="true" id="select_file">
                                    <!-- <option name="default">Choose companies</option> -->
                                    <?php
                                        foreach ($file_xml as $key => $xml) {
                                        ?>
                                        <option class="options"  value="<?=$xml?>" selected="" ><?=$key?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                &nbsp;&nbsp;<a id="xmlparse">✔️</a>&nbsp;&nbsp; <a class="btn-default" onclick='$(".multipleSelect2").prop("disabled", false);'  style="background:white" >⚙️</a>
                        </div>
                        <br>
                    </div>
                    <br>
                    <br>
                    <form action="#" method="post"> 
                        <div class="inpustSearchDataBank">
                            <select name="type" id="type">
                                <option value="" selected disabled hidden>Select type of data</option>
                                <option value="All">All</option>
                                <option value="Artikel">Artikel</option>
                                <option value="Podcast">Podcast</option>
                                <option value="Courses">Courses</option>
                                <option value="Videos">Videos</option>
                            </select>
                            <button class="btn btnSearchCourseDatabank">
                                <img  src="<?=get_stylesheet_directory_uri();?>/img/searchM.png" alt="youtube image">
                            </button>
                        </div>
                    </form>
                    <div class="text-center" id="content-back-topics"></div>
                    <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" id="checkAll" onclick='checkUncheck(this);'></th>
                                <th scope="col">Image</th>
                                <th scope="col">Titel</th>
                                <th scope="col">Type</th>
                                <th scope="col">Prijs</th>
                                <th scope="col">Onderwerp(en)</th>
                                <th scope="col">Status</th>
                                <th scope="col">Author</th>
                                <th scope="col">Company</th>
                                <th class="tdCenter textThBorder">
                                    <input type="submit" class="optieAll btn-default" id="acceptAll" name="submit" style="background:white; border: DEE2E6" value="✔" />&nbsp;
                                    <input type="submit" class="optieAll btn-default" id="declineAll" name="submit" style="background:white" value="❌" />
                                </th>
                            </tr>
                            </thead>
                            <tbody>


                            <?php
if (!empty($courses)) {
    foreach ($courses as $course) {
        //Author Image
        $image_author = get_field('profile_img', 'user_' . $course->author_id);
        $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';

        //Company
        $company = get_field('company', 'user_' . $course->author_id);

        $company_logo = get_stylesheet_directory_uri() . '/img/placeholder.png';
        if (!empty($company)) {
            $company_logo = (get_field('company_logo', $company[0]->ID)) ? get_field('company_logo', $company[0]->ID) : get_stylesheet_directory_uri() . '/img/placeholder.png';
        }

        //Thumbnail
        $image = $course->image_xml ? $course->image_xml : $company_logo;

        $onderwerpen = array();
        //Onderwerpen
        if ($course->onderwerpen != "") {
            $onderwerpen = explode(',', $course->onderwerpen);
        }

        $state = $course->course_id ? 'present' : 'missing';
        $key = $course->id;
        ?>
                                <tr id="<?=$key?>" class="<?=$state?> state">
                                    <td class="textTh"><input type="checkbox" class="checkOne" name="checkOne[]" id="chkBox" value="<?=$course->id?>"></td>
                                    <td class="textTh"> <img src="<?=$image;?>" alt="image course" width="50" height="50"></td>
                                    <td class="textTh courseDataBank" style="color:#212529;font-weight:bold"><?php echo $course->titel; ?></td>
                                    <td class="textTh tdCenter"><?=$course->type;?></td>
                                    <td class="textTh tdCenter textTh"><?=$course->prijs;?></td>
                                    <td class="textTh courseOnderwerpen">
                                        <?php
// if ($course->type != 'Video') {
        if (!empty($onderwerpen)) {
            $tab = [];
            foreach ($onderwerpen as $value1) {
                if ($value1 && !is_wp_error(get_the_category_by_ID($value1))) {
                    $tab[] = (String) get_the_category_by_ID($value1);
                } elseif (!$value1) {
                    $tab[] = null;
                }

            }
            $tab = array_unique($tab);
            foreach ($tab as $value2) {
                if ($value2) {
                    echo $value2 . ',';
                }

            }
        }
        ?>
                                    </td>
                                    <td class="textTh tdCenter"><?=$course->status;?></td>
                                    <td class="textTh tdCenter textTh-center"> <?php if ($course->author_id) {
            echo '';
        } else {
            echo 'author';
        }
        ?> <?php if ($course->author_id) {
            echo '<img src="' . $image_author . '" alt="image course" width="25" height="25">';
        } else {
            echo '<b>No author</b>';
        }
        ?></td>
                                    <td class="textTh tdCenter textTh-center"> <?php if (!empty($company)) {
            echo '';
        } else {
            echo 'company';
        }
        ?> <?php if (!empty($company)) {
            echo '<img src="' . $company_logo . '" alt="image course" width="25" height="25">';
        } else {
            echo '<b>No company</b>';
        }
        ?> </td>
                                    <td class="tdCenter textThBorder"> <input type="button" class="optie btn-default" id="accept" style="background:white; border: DEE2E6" value="✔" />&nbsp;&nbsp;<input type="button" class="optie btn-default" id="decline" style="background:white" value="❌" />&nbsp;&nbsp; <a href="/edit-databank?id=<?=$key?>" class="btn-default" target="_blank"  style="background:white" >⚙️</a> </td>
                                </tr>
                            <?php
}
} else {
    echo ("There is nothing to see here");
}
?>
                            </tbody>
                    </table>
                    <center>
                    <?php
                        if($pagination_number>10){
                            if ($_GET['id']>1) {
                                echo '<a href="?id='.($_GET['id']-1).'" class="textLiDashboard">prev&nbsp;&nbsp;&nbsp;</a>';
                            }

                            if($_GET['id']+5<=$pagination_number && $_GET['id']-5>=1){
                                foreach (range($_GET['id']-5,$_GET['id']+5) as $number) {
                                    if (isset($_GET['id'])) {
                                        if ($_GET['id'] == $number) {
                                            echo '<a href="?id=' . $number . '" style="color: #DB372C; font-weight: bold" class="textLiDashboard">' . $number . '&nbsp;&nbsp;&nbsp;</a>';
                                        } else {
                                            echo '<a href="?id=' . $number . '" class="textLiDashboard">' . $number . '&nbsp;&nbsp;&nbsp;</a>';
                                        }
                                    } else {
                                        echo '<a href="?id=' . $number . '" class="textLiDashboard">' . $number . '&nbsp;&nbsp;&nbsp;</a>';
                                    }
                                }
                            }else if ($_GET['id']+5>=$pagination_number) {
                                foreach (range($_GET['id']-5, $pagination_number) as $number) {
                                    if (isset($_GET['id'])) {
                                        if ($_GET['id'] == $number) {
                                            echo '<a href="?id=' . $number . '" style="color: #DB372C; font-weight: bold" class="textLiDashboard">' . $number . '&nbsp;&nbsp;&nbsp;</a>';
                                        } else {
                                            echo '<a href="?id=' . $number . '" class="textLiDashboard">' . $number . '&nbsp;&nbsp;&nbsp;</a>';
                                        }
                                    } else {
                                        echo '<a href="?id=' . $number . '" class="textLiDashboard">' . $number . '&nbsp;&nbsp;&nbsp;</a>';
                                    }
                                }
                            }else if ($_GET['id']-5<=1) {
                                foreach (range(1, $_GET['id']+5) as $number) {
                                    if (isset($_GET['id'])) {
                                        if ($_GET['id'] == $number) {
                                            echo '<a href="?id=' . $number . '" style="color: #DB372C; font-weight: bold" class="textLiDashboard">' . $number . '&nbsp;&nbsp;&nbsp;</a>';
                                        } else {
                                            echo '<a href="?id=' . $number . '" class="textLiDashboard">' . $number . '&nbsp;&nbsp;&nbsp;</a>';
                                        }
                                    } else {
                                        echo '<a href="?id=' . $number . '" class="textLiDashboard">' . $number . '&nbsp;&nbsp;&nbsp;</a>';
                                    }
                                }
                            }
                            if($_GET['id'] < $pagination_number){ 
                                echo '<a href="?id='.($_GET['id']+1).'" class="textLiDashboard">next&nbsp;&nbsp;&nbsp;</a>';
                            }
                        }else {
                            if ($_GET['id']>1) {
                                echo '<a href="?id='.($_GET['id']-1).'" class="textLiDashboard">prev&nbsp;&nbsp;&nbsp;</a>';
                            }
                            foreach (range(1, $pagination_number) as $number) {
                                if (isset($_GET['id'])) {
                                    if ($_GET['id'] == $number) {
                                        echo '<a href="?id=' . $number . '" style="color: #DB372C; font-weight: bold" class="textLiDashboard">' . $number . '&nbsp;&nbsp;&nbsp;</a>';
                                    } else {
                                        echo '<a href="?id=' . $number . '" class="textLiDashboard">' . $number . '&nbsp;&nbsp;&nbsp;</a>';
                                    }
                                } else {
                                    echo '<a href="?id=' . $number . '" class="textLiDashboard">' . $number . '&nbsp;&nbsp;&nbsp;</a>';
                                }
                            }
                        }
                    ?>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content modal-content-width m-auto " style="margin-top: 100px !important">
            <div class="modal-header mx-4">
                <h5 class="modal-title" id="exampleModalLabel">Content</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('myModal').style.display='none'" >
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="row d-flex text-center justify-content-center align-items-center h-50">
                <div class="col-md-11  p-4">
                    <form action='/dashboard/user/' method='POST'>
                    <div class="form-group display-fields-clean">
                    </div>
                    <div id="modal-content">

                    </div>
                    <center><input type='submit' class='btn text-white' name='databank' value='Update' style='background: #023356; border: none;'/></center>
                    <div class="d-flex justify-content-end">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- -->


<!--begin modal audios -->
    <div class="modal fade" id="audios-api" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="navbar-brand d-flex align-items-center">
                        <img src="https://api.podcastindex.org/images/pci_avatar.jpg" width="35" height="35">
                        <span class="ml-2"><strong>Podcastindex</strong></span>
                    <div id="spinner-search-audio" class="d-none">
                        <div class="spinner-grow m-1" style="width: 1rem; height: 1rem;" role="alert">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow m-1" style="width: 0.8rem; height: 0.8rem;" role="alert">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow m-1" style="width: 0.6rem; height: 0.6rem;" role="alert">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">zoek : </label>
                        <input type="search" placeholder="zoek" class="form-control" id="search_audio" name="search_audio" autocomplete="off">
                    </div>
                    <div id="content-back-audio"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                   <!-- <button type="button" class="btn btn-outline-success" id="get-audios">Get Audios</button>
              -->  </div>
            </div>
        </div>
    </div>
<!--end modal audios -->

    <!--begin modal audios playlist -->
    <div class="modal fade" id="playlist-audios-indexpodcast" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="navbar-brand d-flex align-items-center">
                        <img src="https://api.podcastindex.org/images/pci_avatar.jpg" width="35" height="35">
                        <span class="ml-2"><strong>Podcastindex Playlist</strong></span>
                        <div id="spinner-search-audio-playlist" class="d-none">
                            <div class="spinner-grow m-1" style="width: 1rem; height: 1rem;" role="alert">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="spinner-grow m-1" style="width: 0.8rem; height: 0.8rem;" role="alert">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="spinner-grow m-1" style="width: 0.6rem; height: 0.6rem;" role="alert">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">zoek : </label>
                        <input type="search" placeholder="zoek" class="form-control" id="search_audio_playlist" name="search_audio" autocomplete="off">
                    </div>
                    <div id="content-back-audio-playlist"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-outline-success" id="get-audios">Get Audios</button>
               -->  </div>
            </div>
        </div>
    </div>
    <!--end modal audios playlist -->
</body>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

<script id="rendered-js" >
    var ids=[];
    var list=[];
    var names=[];
    window.onload = $(".multipleSelect2").val("");
    $(document).ready(function () {
        //Select2
        $(".multipleSelect2").select2({
            placeholder: "Maak uw keuze",
            maximumSelectionLength: 5,
            minimumSelectionLength: 3,
        }).on("change", function () {
            if ($(this).val() && $(this).val().length >= 5) {
                $(this).prop("disabled", true);
            }
        });

    });

    window.onload = $(".multipleSelect3").val("");
    $(document).ready(function () {
        //Select2
        $(".multipleSelect3").val([]);
        $(".multipleSelect3").select2({
            placeholder: "Youtube playlist",
            maximumSelectionLength: 4000,
            minimumSelectionLength: 3,
        }).on("change", function () {
            if ($(this).val() && $(this).val().length >= 4000) {
                $(this).prop("disabled", true);
            }
        });

    });
    //# sourceURL=pen.js
</script>
<!--begin traitement playlist podcast -->
<script type="text/javascript">
    //playlist-audios-indexpodcast
    $('#search_audio_playlist').on('input', function(e) {
        const search_playlist = e.target.value;
        const backAudioApiPlaylist = document.getElementById('content-back-audio-playlist');
        console.log(search_playlist);
        $.ajax({
            url : "/audio-api/",
            method : "POST",
            data : {
                audio_search_playlist : search_playlist
            },
            beforeSend:function(){
                $('#spinner-search-audio-playlist').removeClass('d-none');
                backAudioApiPlaylist.innerHTML = '';
                console.log('searching podcast...')
            },
            success: function(success){
                backAudioApiPlaylist.innerHTML=success;
                console.log('success',success)
            },error: function(error,status){
                console.log('error',error);
                console.log('status',status);
                backAudioApiPlaylist.innerHTML = error;
            },complete: function(complete){
                $('#spinner-search-audio-playlist').addClass('d-none');
                console.log(complete);
            },
        });
    });
</script>
<!--end traitement playlist podcast -->

<!--begin  function to save a playlist audion on databank-->
<script type="text/javascript">
    function savePodcastPlaylistInPlatform(e){
        //console.log('value',e.target);
        const data = e.target.dataset
        console.log('elt',e.target)
        const loaderSaving = document.getElementById("spinner-saving-podcast");
        //console.log('information to save',data)
        const spinner = e.target.nextElementSibling
        $.ajax({
            url : "/audio-api/",
            method : "POST",
            data : {
                playlist_audio : data
            },
            beforeSend:function(){
                console.log('saving podcast...');
               // $('#spinner-saving-podcast').removeClass('d-none');
                spinner.className = ""
            },
            success: function(success){
                alert(success);
                //console.log('result',success)
                //document.getElementById('content-back-audio-playlist').innerHTML = success;
            },error: function(error,status){
                console.log('error',error)
                console.log('status',status)
            },complete: function(complete){
                spinner.className = "d-none"
            },
        });
    }
</script>
<!--end  function to save a playlist audion on databank-->


<!--begin traitement podcast audio remove now !!! -->
<script type="text/javascript">
    $('#search_audio').on('input', function(e) {
        const search = e.target.value;
        const backAudioApi = document.getElementById('content-back-audio');
        console.log(search);
        $.ajax({
           url : "/audio-api/",
            method : "POST",
            data : {
               audio_search : search
            },
            beforeSend:function(){
                $('#spinner-search-audio').removeClass('d-none');
                backAudioApi.innerHTML = '';
                console.log('sending...')
            },
            success: function(success){
                //$('#content-back-audio').append(success)
                if (!success) {
                    backAudioApi.innerHTML = "<span class='text-center'>no result for '" + search + "'</span>";
                } else {
                    backAudioApi.innerHTML = success;
                }
                console.log('success',success)
            },error: function(error,status){
                console.log('error',error);
                backAudioApi.innerHTML = error;
            },complete: function(complete){
                $('#spinner-search-audio').addClass('d-none');
                console.log('complete');
            },
        });
    });
</script>
<!--end traitement podcast audio remove now !!! -->

<script type="text/javascript">
    function uncheckAll() {
        console.log('uncheck')
        let checkboxes = document.querySelectorAll('input[type=checkbox]');
        for (let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
        }
    }

    window.onload = uncheckAll;

    function checkUncheck(checkBox) {
        let regex = /^[0-9]+$/;
        get = document.querySelectorAll('input[type=checkbox]');
        for(var i=0; i<get.length; i++) {
            get[i].checked = checkBox.checked;
        //    console.log('::::::::::::::::::::',get[i].value);
           if (regex.test(get[i].value)){
               ids.push(get[i].value);
           }
        }
        if(!checkBox.checked)
            ids = []
        // console.log(ids);
    }

    $(document).ready(function(){
        $('#xmlparse').on('click', function(){
            var selectedOptions = $('#select_file').find('option:selected');
            var selectedxmlValues = [];

            selectedOptions.each(function() {
            var value = $(this).val();
            var text = $(this).text();
            selectedxmlValues.push({value: value, text: text});
            });
            $('#select_field').hide(true,2000);
            $('#loader').attr('hidden',false);

            // Send selectedValues array via AJAX to PHP file
            $.ajax({
                type: "POST",
                url: "/xml-parse",
                data: { selectedxmlValues: selectedxmlValues },
                success: function(response) {
                    console.log(response);
                    // document.getElementById('content-back-topics').innerHTML = response;
                    // window.location.href='/xml-parse';
                },error:function() {
                    console.log('error');
                },
                complete:function(response){
                    $('#select_field').hide(false,2000);
                    $('#loader').attr('hidden',true);
                    location.reload();
                }
            });
        });
    });

    $(document).ready(function(){
        $('#youtube').on('click',function(){
            
        });
    });

    $(document).ready(function() {
        $('#bouddha').on('click', function() {
            var selectedOptions = $('#select_company').find('option:selected');
            var selectedValues = [];

            selectedOptions.each(function() {
            var value = $(this).val();
            var text = $(this).text();
            selectedValues.push({value: value, text: text});
            });
            $('#select_field').hide(true,2000);
            $('#loader').attr('hidden',false);

            // Send selectedValues array via AJAX to PHP file
            $.ajax({
                type: "POST",
                url: "/artikels",
                data: { selectedValues: selectedValues },
                success: function(response) {
                    console.log(response);
                    // document.getElementById('content-back-topics').innerHTML = response;
                    location.reload();
                },error:function() {
                    console.log('error'); 
                },
                complete:function(response){
                    $('#select_field').hide(false,2000);
                    $('#loader').attr('hidden',true);
                    // location.reload();
                }
            });
        });
    });


    $('#select_field').change((e)=>
    {
        let website= $('#select_field').val();
        $.ajax({
            url: '/scrapping',
            type: 'POST',
            data: {
                'website': website ,
                'action': 'reload_data'
            },
            beforeSend:function(){
                $('#loader').attr('hidden',false)
                $('#select_field').attr('hidden',true)
            },
            error: function(){
                alert('Something went wrong!');
            },
            complete: function(){},
            success: function(data){
                $('#loader').attr('hidden',true)
                $('#select_field').attr('hidden',false)
                console.log(data);
                location.reload();
            }
        });
    });

    $(".checkOne").click((e)=>{
        let tags_id = e.target.value;
        let if_exist = ids.indexOf(tags_id);
        if (!ids.includes(tags_id))
            ids.push(tags_id);//push the element in array
        else
            ids.splice(if_exist, 1) // remove it in array

        console.log(ids);
    });

    $('#subtopics').on('click', function() 
    {
        console.log('click');
        if(ids.length==0){
            alert("Please, select some articles!!");
        }else{
            const objetIds = Object.assign({}, ids);
            console.log(objetIds);
            console.log('data submitted',objetIds);
            $.ajax({
                url: '/subtopics',
                type: 'POST',
                data: objetIds,
                beforeSend:function(){
                    document.getElementById('content-back-topics').innerHTML = '';
                    $('#loader').attr('hidden',false);
                    $('#select_field').attr('hidden',true);
                },error:function(error){
                    console.log("error:");
                    document.getElementById('content-back-topics').innerHTML = error;
                },success:function(success){
                    $('#loader').attr('hidden',true);
                    document.getElementById('content-back-topics').innerHTML = success;
                    console.log(success);
                    location.reload();
                },complete:function(complete){
                    // console.log("complete:",complete);
                    $('#loader').attr('hidden',true);
                    $('#select_field').attr('hidden',true);
                }
            });
        }
    });
        // window.addEventListener('load', () => {
        //     ids=[]
        // });

    $('.optieAll').click((e)=>{
        const state = document.querySelector('.state').className;
        var classs = state.split(' ')[0];
        var optie = e.target.value;
        if(confirm('Are you sure you want to apply this record ?'))
        {
            // console.log('array sending',ids);
            // console.log('classs',classs);
            $.ajax({
                url: '/optieall',
                type: 'POST',
                data: {
                    class:classs,
                    ids:ids,
                    optie:optie
                },
                beforeSend:function(){
                    document.getElementById('content-back-topics').innerHTML = '';
                    $('#loader').attr('hidden',false);
                    $('#select_field').attr('hidden',true);
                    console.log('saving many courses on plateform')
                },
               error: function(error) {
                document.getElementById('content-back-topics').innerHTML = error;
                $('#loader').attr('hidden',false)
                $('#select_field').attr('hidden',true)
                document.getElementById('content-back-topics').innerHTML = "<span class='alert alert-alert'>Something went wrong! Cannot insert null value. Please check the articles.</span>";
                location.reload();
               },
               success: function(data) {
                $('#loader').attr('hidden',true)
                $('#select_field').attr('hidden',false)
                document.getElementById('content-back-topics').innerHTML = data;
                    for(var i=0;i<ids.length;i++){
                        $("#"+ids[i]).remove();
                        // console.log(ids[i]);
                    }
                    alert("Record applied successfully");
                    location.reload();
                    // window.location.href = "/optieAll";
                },
                complete: function(data){
                    console.log(data);
                }
            });
        }
    });

    $('.optie').click((e)=>{
        var tr_element = e.target.parentElement.closest("tr");
        var ids = tr_element.id;
        const state = document.querySelector('.state').className;
        var classs = state.split(' ')[0];
        var optie = e.target.value;
        // console.log('ids::::::::::',ids);
        // console.log('option choisi',optie);
        // console.log('classs::::::::::',classs);
        if(confirm('Are you sure you want to apply this record ?'))
        {
            $.ajax({
                url: '/optie-bank',
                type: 'POST',
                data: {
                   id: ids,
                   optie: optie,
                   class: classs
                },
                beforeSend:function(){
                    document.getElementById('content-back-topics').innerHTML = '';
                    $('#loader').attr('hidden',false)
                    $('#select_field').attr('hidden',true)
                    console.log('saving one course on plateform')
                },
               error: function(error) {
                console.log(error);
                document.getElementById('content-back-topics').innerHTML = error;
                $('#loader').attr('hidden',true)
                $('#select_field').attr('hidden',false)
                document.getElementById('content-back-topics').innerHTML = "<span class='alert alert-alert'>Something went wrong! Cannot insert null value. Please check the article.</span>";
                //   alert('Something is wrong');
                // location.reload();
               },
               success: function(data) {
                    console.log('response ',data);
                    document.getElementById('content-back-topics').innerHTML = data;
                    // document.getElementById('content-back-topics').innerHTML = "<span class='alert alert-success'>Record applied successfully</span>";
                    $('#loader').attr('hidden',true)
                    $('#select_field').attr('hidden',false);
                    $("#"+ids).remove();
                    location.reload();
                    // alert("Record applied successfully");
                }
            });
        }
    });

    $('.courseDataBank').click((e)=>{
        var tr_element = e.target.parentElement.closest("tr");
        var key = tr_element.id;

        $.ajax({
            url:"/fetch-data-clean-quick",
            method:"post",
            data:
            {
                id:key,
            },
            dataType:"text",
            success: function(data){
                // Get the modal
                console.log(data)
                var modal = document.getElementById("myModal");
                $('.display-fields-clean').html(data)
                // Get the button that opens the modal


                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks on the button, open the modal

                    modal.style.display = "block";

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            }
        });
    });

    $('.youtube_button')

    $('.author').click((e)=>{
        var tr_element = e.target.parentElement.closest("tr");
        var key = tr_element.id;

        $.ajax({
                url:"/fetch-data-clean-author",
                method:"post",
                data:
                {
                    id:key,
                },
                dataType:"text",
                success: function(data){
                    // Get the modal
                    console.log(data)
                    var modal = document.getElementById("myModal");
                    $('.display-fields-clean').html(data)
                    // Get the button that opens the modal


                    // Get the <span> element that closes the modal
                    var span = document.getElementsByClassName("close")[0];

                    // When the user clicks on the button, open the modal

                        modal.style.display = "block";

                    // When the user clicks on <span> (x), close the modal
                    span.onclick = function() {
                        modal.style.display = "none";
                    }

                    // When the user clicks anywhere outside of the modal, close it
                    window.onclick = function(event) {
                        if (event.target == modal) {
                        modal.style.display = "none";
                        }
                    }

                }
        });
    });

    $('.company').click((e)=>{
        var tr_element = e.target.parentElement.closest("tr");
        var key = tr_element.id;

        $.ajax({
            url:"/fetch-data-clean-company",
            method:"post",
            data:
            {
                id:key,
            },
            dataType:"text",
            success: function(data){
                // Get the modal
                console.log(data)
                var modal = document.getElementById("myModal");
                $('.display-fields-clean').html(data)
                // Get the button that opens the modal


                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks on the button, open the modal

                    modal.style.display = "block";

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            }
        });
    });

</script>

<script defer id="rendered-js" >
    $(document).ready(function () {
        //Select2
        $(".multipleSelect2").select2({
            placeholder: "Maak uw keuze.",
            //placeholder
        });
    });
    //# sourceURL=pen.js
</script>
<script>

    $("#playlist-youtube").click((e)=>{
        var selectedYoutubeOption = $("#selected_playlist").find('option:selected');
        var playlistId = [];

        selectedYoutubeOption.each(function(){
            var values = $(this).val();
            playlistId.push(values);
        });

        $('#select_field').hide(true,2000);
         $('#loader').attr('hidden',false);

        $.ajax({
            url:"/youtube-playlist/",
            method:"POST",
            data:{
                playlist_youtube: playlistId
            },
            beforeSend:function(){
                $('#loader').attr('hidden',false);
                $('#select_field').attr('hidden',true);
                document.getElementById('content-back-topics').innerHTML = '';
                console.log('sending...')
            },
            error: function(error){
                console.log('error',error);
                document.getElementById('content-back-topics').innerHTML = error;
               },
            success: function(success){
                document.getElementById('content-back-topics').innerHTML = success;
                console.log('success',success)
            },complete: function(complete){
                $('#loader').attr('hidden',true);
                $('#select_field').attr('hidden',false);
                location.reload();
            },
        });
    })
</script>
<?php get_footer();?> 
<?php wp_footer();?>