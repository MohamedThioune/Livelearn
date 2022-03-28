<?php /** Template Name: Home template */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<?php
    $args = array(
                    'post_type' => 'course',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'order' => 'DESC',
                );

    $courses = get_posts($args);

    /*
    ** Categories - all  * 
    */

    $categories = array();

    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );



    foreach($cats as $category){
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($categories, $category);
    }

    //Categories
    $bangerichts = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[1],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $functies = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[0],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $skills = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[3],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $interesses = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[2],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

?>

<div class="contentOne">
  
    <div class="boxOne3">
        <div class="container">
            <div class="voorBlock">
                <p class="wordDeBestText2" style="font-weight: bold">Ontdek, ontwikkel en maak carrière </p>
                <p class="altijdText2">Er valt altijd iets nieuws te leren, maak gratis jouw skills paspoort en word expert.</p>
                <form action="/product-search" method="POST">
                    <input id="search" type="search" class="jAuto searchInputHome form-control"
                        placeholder="Zoek opleidingen, experts of onderwerpen" name="search" autocomplete="off">
                    <div class="dropdown-menuSearch" id="list">
                        <div class="list-autocomplete" id="autocomplete">
                        <center> <i class='hasNoResults'>No matching results рџ’Ј </i> </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="boxCard3">
            <a href="functiegerichte" class="card3">
                <div class="box1Img">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/box1.png" id="imgBoxx1" alt="">
                </div>
                <p class="textCard3">Groei binnen <br> je functie</p>
            </a>
            <a href="baangerichte" class="card3">
                <div class="box1Img">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/vitreHomme.png"  alt="">
                </div>
                <p class="textCard3">Tijd voor een (nieuwe) baan</p>
            </a>
            <a href="skill" class="card3">
                <div class="box1Img">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/hNoir.png"  alt="">
                </div>
                <p class="textCard3">Ontwikkel specifieke skills</p>
            </a>
            <a href="persoonlijke" class="card3">
                <div class="box1Img">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/buul.png"  alt="">
                </div>
                <p class="textCard3">Persoonlijke <br>interesses</p>
            </a>
        </div>
    </div>
    <div>
        <p class="daaromText">Daarom maken meer dan 250 organisaties, experts en opleiders gebruik van LiveLearn</p>
       <div class="container">
           <div class="contentSponsortBlock">
               <div class="sponsortBlock">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners1.jpeg" class="sponsortImg" alt="">
               </div>
               <div class="sponsortBlock">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners2.jpeg" class="sponsortImg" alt="">
               </div>
               <div class="sponsortBlock">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners3.jpeg" class="sponsortImg" alt="">
               </div>
               <div class="sponsortBlock">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners4.jpeg" class="sponsortImg" alt="">
               </div>
               <div class="sponsortBlock">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners5.jpeg" class="sponsortImg" alt="">
               </div>
               <div class="sponsortBlock">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners6.jpeg" class="sponsortImg" alt="">
               </div>
               <div class="sponsortBlock">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners7.jpeg" class="sponsortImg" alt="">
               </div>
               <div class="sponsortBlock">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners8.jpeg" class="sponsortImg" alt="">
               </div>
           </div>
       </div>
    </div>
</div>
<div class="cardVoor">
    <div class="container-fluid web">
        <p class="titleGroupText">Onze gebruikers</p>
        <div class="row paddingElement7">
            <div class="col-lg-4  col-md-6">
                <a href="/static-education-individual">
                    <div class="cardModife3">
                        <div class="boxImgCard3">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/phoneHomme.png" alt="">
                            <p  class="startGratis">Skill paspoort</p>
                        </div>
                        <div class="textGroup">
                            <p class="voorText2">Voor Individuen</p>
                            <p class="dePaterneText">Direct en gratis je persoonlijke skill paspoort. Blijf groeien gedurende je carrière of vind een
                                nieuwe uitdaging</p>
                            <p class="merrText text-center">Meer Informatie</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4  col-md-6">
                <a href="/voor-teacher-2">
                    <div class="cardModife3">
                        <div class="boxImgCard3">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/hmTableau.png" alt="">
                            <p class="startGratis">Word partner</p>
                        </div>
                        <div class="textGroup">
                            <p class="voorText2">Voor opleiders / experts</p>
                            <p class="dePaterneText">Word partner van LiveLearn. Bied je training, cursus of e-learning eenvoudig aan en bereik
                                nieuwe klanten.</p>
                            <p class="merrText text-center">Meer Informatie</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4  col-md-6">
                <a href="/voor-organisaties">
                    <div class="cardModife3">
                        <div class="boxImgCard3">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/sta.png" alt="">
                            <p class="startGratis">Start gratis</p>
                        </div>
                        <div class="textGroup">
                            <p class="voorText2">Voor organisaties</p>
                            <p class="dePaterneText">Een lerende organisatie binnen een paar klikken. LiveLearn is jouw beste partner voor een
                                future-proof organisatie.</p>
                            <p class="merrText text-center">Meer Informatie</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="Mob">
        <p class="onzeText">Onze gebruikers</p>
        <div class="swiper-container swipeContaine1">
            <div class="swiper-wrapper">
                <div class="swiper-slide swiper-slide3">
                    <a href="/static-education-individual">
                        <div class="cardModife3">
                            <div class="boxImgCard3">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/phoneHomme.png" alt="">
                                <p  class="startGratis">Skill paspoort</p>
                            </div>
                            <div class="textGroup">
                                <p class="voorText2">Voor Individuen</p>
                                <p class="dePaterneText">Direct en gratis je persoonlijke skill paspoort. Blijf groeien gedurende je carrière of vind een
                                    nieuwe uitdaging</p>
                                <p class="merrText text-center">Meer Informatie</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="swiper-slide swiper-slide3">
                    <a href="/voor-teacher-2">
                        <div class="cardModife3">
                            <div class="boxImgCard3">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/hmTableau.png" alt="">
                                <p class="startGratis">Word partner</p>
                            </div>
                            <div class="textGroup">
                                <p class="voorText2">Voor opleiders / experts</p>
                                <p class="dePaterneText">Word partner van LiveLearn. Bied je training, cursus of e-learning eenvoudig aan en bereik
                                    nieuwe klanten.</p>
                                <p class="merrText text-center">Meer Informatie</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="swiper-slide swiper-slide3">
                    <a href="/voor-organisaties">
                        <div class="cardModife3">
                            <div class="boxImgCard3">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/sta.png" alt="">
                                <p class="startGratis">Start gratis</p>
                            </div>
                            <div class="textGroup">
                                <p class="voorText2">Voor organisaties</p>
                                <p class="dePaterneText">Een lerende organisatie binnen een paar klikken. LiveLearn is jouw beste partner voor een
                                    future-proof organisatie.</p>
                                <p class="merrText text-center">Meer Informatie</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="block9">
    <div class="container-fluid">
        <div class="blockGroupText">
            <p class="titleGroupText">Opleiden richting een baan </p>

            <div class="sousBlockGroupText">
                <?php
                    foreach($bangerichts as $bangericht){
                ?>
                <a href="sub-topic?subtopic=<?php echo $bangericht->cat_ID ?>" class="TextZorg"><?php echo $bangericht->cat_name ?></a>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="blockGroupText">
            <p class="titleGroupText">Groeien binnen je functie </p>

            <div class="sousBlockGroupText">
                <?php
                    foreach($functies as $functie){
                ?>
                    <a href="sub-topic?subtopic=<?php echo $functie->cat_ID ?>" class="TextZorg"><?php echo $functie->cat_name ?></a>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="blockGroupText">
            <p class="titleGroupText">Relevante skills ontwikkelen:</p>

            <div class="sousBlockGroupText">
                <?php
                    foreach($skills as $skill){
                ?>
                    <a href="sub-topic?subtopic=<?php echo $skill->cat_ID ?>" class="TextZorg"><?php echo $skill->cat_name ?></a>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="blockGroupText">
            <p class="titleGroupText">Persoonlijke interesses & vrije tijd</p>

            <div class="sousBlockGroupText">
                <?php
                    foreach($interesses as $interesse){
                ?>
                    <a href="sub-topic?subtopic=<?php echo $interesse->cat_ID ?>" class="TextZorg"><?php echo $interesse->cat_name ?></a>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="blockAl joum">
    <div class="container-fluid">
        <div class="alJoum">
            <div class="blockImGDaniel">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/daniel.png" alt="">
            </div>
            <?php
                echo do_shortcode("[gravityform id='10' title='false' description='false' ajax='true']");
            ?>
         
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="OfMaanBlock">
        <div class="ofWordBlock">
            <p class="ofWordText">Of gebruik LiveLearn Zakelijk</p>
            <p class="krijgText">Een eigen leeromgeving, tot wel 65% korting op opleidingen en andere leervormen, toegang
                tot exclusieve events en maak gebruik van ons leven lang leren scholingsadvies.</p>
            <a href="/voor-organisaties" class="ikWil">Ik wil dit</a>
        </div>
        <div class="ookBlock">
            <p class="textmaand">€4,95 per maand</p>
            <p class="textOok">Per werknemer in jouw eigen ontwikkel portaal</p>
        </div>
    </div>
</div>
<div class="blockAgenda">
    <div class="blockText8">
        <p class="titleAgenda">Een agenda vol leer-mogelijkheden</p>
        <p class="dePaterneText">Groei op zakelijk gebied of ontdek nieuwe talenten.</p>
    </div>
    <div class="blockFrontAgenda">
        <div class="container-fluid">
            <div class="sousBlockFrontAgenda">
                <?php
                    $i = 0;
                    foreach($courses as $course){

                        if(!get_field('visibility', $course->ID)) {
                            /*
                            * Categories
                            */
                            $location = 'Virtual';
                            $day = "<p><i class='fas fa-calendar-week'></i></p>";
                            $month = ' ';

                            $category = ' ';
                                        
                            $category_id = 0;
                            $category_string = " ";
                            
                            if($category == ' '){
                                $category_str = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]);
                                $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                                if($category_str != 0)
                                    $category = (String)get_the_category_by_ID($category_str);
                                else if($category_id != 0)
                                    $category = (String)get_the_category_by_ID($category_id);                                    
                            }

                            /*
                            *  Date and Location
                            */
                            $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

                            $data = get_field('data_locaties', $course->ID);
                            if($data){
                                $date = $data[0]['data'][0]['start_date'];
                                if($date != ""){
                                    $day = explode('/', explode(' ', $date)[0])[0];
                                    $mon = explode('/', explode(' ', $date)[0])[1];
                                    $month = $calendar[$mon];
                                }

                                $location = $data[0]['data'][0]['location'];
                            }else{
                                $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                                $date = $data[0];
                                $day = explode('/', explode(' ', $date)[0])[0];
                                $month = explode('/', explode(' ', $date)[0])[1];
                                $month = $calendar[$month];
                                $location = $data[2];
                            }

                            /*
                            * Price
                            */
                            $p = get_field('price', $course->ID);
                            if($p != "0")
                                $price =  number_format($p, 2, '.', ',');
                            else
                                $price = 'Gratis';

                            /*
                            * Thumbnails
                            */
                            $thumbnail = get_field('preview', $course->ID)['url'];
                            if(!$thumbnail){
                                $thumbnail = get_field('url_image_xml', $course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_stylesheet_directory_uri() . '/img/placeholder.png';
                            }

                            /*
                             * Companies
                            */
                            $company = get_field('company',  'user_' . $course->post_author);
                            $company_id = $company[0]->ID;
                            $company_logo = get_field('company_logo', $company_id);
                ?>
                <a href="<?php echo get_permalink($course->ID) ?>" class="blockCardFront" style="color:#43454D">
                    <div class="workshopBlock">
                        <img class="" src="<?php echo $thumbnail ?>" alt="">
                        <div class="containWorkshopAgenda">
                            <p class="workshopText"><?php echo get_field('course_type', $course->ID) ?></p>
                            <div class="blockDateFront">
                                <p class="moiText"><?php echo $day ?></p>
                                <p class="dateText" style="font-size: 11px"><?php echo $month ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="deToekomstBlock">
                        <p class="deToekomstText"><?php echo $course->post_title; ?></p>
                        <p class="platformText"><?php echo get_field('short_description', $course->ID) ?></p>
                        <div class="detaiElementAgenda">
                            <div class="janBlock">
                                <?php
                                    if(!empty($company)){
                                        $company_title = $company[0]->post_title;
                                        $company_id = $company[0]->ID;
                                        $company_logo = get_field('company_logo', $company_id);
                                ?>
                                <div class="colorFront">
                                    <img src="<?php echo $company_logo; ?>" width="15" alt="">
                                </div>
                                <p class="textJan"><?php echo $company_title; ?></p>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="euroBlock">
                                <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/euro.png" alt="">
                                <p class="textJan"><?php echo $price ?></p>
                            </div>
                            <?php
                                if($location != ''){
                            ?>
                            <div class="zwoleBlock">
                                <img class="ss" src="<?php echo get_stylesheet_directory_uri();?>/img/ss.png" alt="">
                                <p class="textJan"><?php echo $location ?></p>
                            </div>
                            <?php
                                }
                                if($category != ' '){
                            ?>
                            <div class="facilityBlock">
                                <img class="faciltyImg" src="<?php echo get_stylesheet_directory_uri();?>/img/map-search.png" alt="">
                                <p class="textJan"><?php echo $category ?></p>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </a>
                <?php
                        if($i == 7)
                            break;
                    }
                    $i++;
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="productBlock3">
        <p class="TitleWat">Wat je niet mag missen</p>
        <div class="swiper-container swiper-container-3">
            <div class="swiper-wrapper">
                <?php

                  $i = 0;

                  foreach($courses as $course){

                      if(!get_field('visibility', $course->ID)) {

                        /*
                        * Categories
                        */
                        $category = ' ';
                                        
                        $category_id = 0;
                        $category_string = " ";
                        
                        if($category == ' '){
                            $category_str = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]);
                            $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                            if($category_str != 0)
                                $category = (String)get_the_category_by_ID($category_str);
                            else if($category_id != 0)
                                $category = (String)get_the_category_by_ID($category_id);                                    
                        }
                        /*
                        *  Date and Location
                        */
                        $location = 'Virtual';

                        $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];

                        $data = get_field('data_locaties', $course->ID);
                        if($data){
                            $date = $data[0]['data'][0]['start_date'];

                            $day = explode('/', explode(' ', $date)[0])[0];
                            $month = explode('/', explode(' ', $date)[0])[1];
                            $month = $calendar[$month];

                            $location = $data[0]['data'][0]['location'];
                        }
                        else{
                            $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                            $date = $data[0];
                            $day = explode('/', explode(' ', $date)[0])[0];
                            $month = explode('/', explode(' ', $date)[0])[1];
                            $month = $calendar[$month];
                            $location = $data[2];
                        }

                      /*
                      * Price
                      */
                      $p = get_field('price', $course->ID);
                      if($p != "0")
                          $price =  number_format($p, 2, '.', ',');
                      else
                          $price = 'Gratis';

                      /*
                      * Thumbnails
                      */
                      $thumbnail = get_field('preview', $course->ID)['url'];
                      if(!$thumbnail){
                        $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                        if(!$thumbnail)
                            $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                       }

                        /*
                        * Companies
                        */
                        $company = get_field('company',  'user_' . $course->post_author);
                        $company_id = $company[0]->ID;
                        $company_logo = get_field('company_logo', $company_id);
                ?>
                <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiperSlideModife">
                    <div class="cardKraam2">
                        <div class="headCardKraam">
                            <div class="blockImgCardCour">
                                <img src="<?php echo $thumbnail ?>" alt="">
                            </div>
                            <div class="blockgroup7">
                                <div class="iconeTextKraa">
                                    <div class="sousiconeTextKraa">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                        <p class="kraaText"><?php echo $category ?></p>
                                    </div>
                                    <div class="sousiconeTextKraa">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                        <p class="kraaText"><?php echo get_field('degree', $course->ID);?></p>
                                    </div>
                                </div>
                                <div class="iconeTextKraa">
                                    <div class="sousiconeTextKraa">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                        <p class="kraaText"><?php echo $day . ' ' . $month ?></p>
                                    </div>
                                    <div class="sousiconeTextKraa">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                        <p class="kraaText"><?php echo $price; ?> &nbsp;&nbsp;</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="contentCardProd">
                            <div class="group8">
                                <div class="imgTitleCours">
                                    <?php
                                        if(!empty($company)){
                                            $company_title = $company[0]->post_title;
                                            $company_id = $company[0]->ID;
                                            $company_logo = get_field('company_logo', $company_id);
                                    ?>
                                    <div class="imgCoursProd">
                                        <img src="<?php echo $company_logo; ?>" width="25" alt="">
                                    </div>
                                    <p class="nameCoursProd"><?php echo $company_title; ?></p>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="group9">
                                    <div class="blockOpein">
                                        <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                        <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                    </div>
                                    <div class="blockOpein">
                                        <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                        <p class="lieuAm"><?php echo $location ?></p>
                                    </div>
                                </div>
                            </div>
                            <p class="werkText"><?php echo $course->post_title;?></p>
                            <p class="descriptionPlatform">
                                <?php echo get_field('short_description', $course->ID) ?>
                            </p>
                        </div>
                    </div>
                </a>

                <?php
                    $i++;
                    if($i == 5)
                        break;
                    }
                }?>
            </div>
        </div>
    </div>
</div>
<div class="blockDeBeste">
    <div class="container-fluid web">
        <div class="sousBlockDebeste">
            <div class="deBesteElement">
                <p class="deBesteText">De beste plek op het internet om je verder te ontwikkelen</p>
                <p class="enZorgenText">En zorgen zo dat jij altjid je doel bereikt</p>
            </div>
            <div class="ensembleCard">
                <div class="cardModife4">
                    <div class="imgCard4">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/intro.png" alt="">
                    </div>
                    <p class="ontdexText" >Ontdek nieuwe interesses of verborgen talenten</p>
                </div>
                <div class="cardModife4">
                    <div class="imgCard4">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/tab1.png" alt="">
                    </div>
                    <p class="ontdexText">Volg training online of op locatie bij jou in de buurt</p>
                </div>
                <div class="cardModife4">
                    <div class="imgCard4">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/chrono.png" alt="">
                    </div>
                    <p class="ontdexText">Blijf altijd up-to-date en relevant op de arbeidsmarkt</p>
                </div>
            </div>
        </div>
    </div>
    <div class="Mob">
        <div class="deBesteElement">
            <p class="deBesteText">De beste plek op het internet om je verder te ontwikkelen</p>
            <p class="enZorgenText">En zorgen zo dat jij altjid je doel bereikt</p>
        </div>
        <div class="swiper-container swipeContaine1">
            <div class="swiper-wrapper">
                <div class="swiper-slide swiper-slide1">
                    <div class="cardModife4">
                        <div class="imgCard4">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/intro.png" alt="">
                        </div>
                        <p class="ontdexText">Ontdek nieuwe interesses of verborgen talenten</p>
                    </div>
                </div>
                <div class="swiper-slide swiper-slide1">
                    <div class="cardModife4">
                        <div class="imgCard4">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/tab1.png" alt="">
                        </div>
                        <p class="ontdexText">Volg trainingen online of op locatie bij jou in de buurt</p>
                    </div>
                </div>
                <div class="swiper-slide swiper-slide1">
                    <div class="cardModife4">
                        <div class="imgCard4">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/chrono.png" alt="">
                        </div>
                        <p class="ontdexText">Blijf altijd up-to-date en relevant op de arbeidsmarkt</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="blockTopBanen">
    <div class="container-fluid">
        <div class="d-flex align-center align-item-center">
            <p class="titleTopBanen">Banen om naar te scholen</p>
        </div>

        <div class="swiper-container swipeContaine2">
            <div class="swiper-wrapper">
                    <a href="/baangerichte" class="swiper-slide swiper-slide2">
                        <div class="cardTop bleu">
                            <?php
                                $image_principal = get_field('image', 'category_'. $categories[1]);
                                $image_principal = $image_principal ? $image_principal : get_stylesheet_directory_uri() . '/img/maternite.jpg';
                            ?>
                            <div class="contentImg">
                                <img src="<?php echo $image_principal; ?>" alt="">
                            </div>
                            <p class="bekijText bleuT">Bekijk alles</p>
                        </div>
                    </a>
                    <?php
                        foreach ($bangerichts as $value) {
                            $image_category = get_field('image', 'category_'. $value->cat_ID);
                            $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/maternite.jpg';
                    ?>
                    <a href="sub-topic?subtopic=<?php echo $value->cat_ID; ?>" class="swiper-slide swiper-slide2">
                        <div class="cardTop ">
                            <div class="contentImg">
                                <img src="<?php echo $image_category; ?>" alt="">
                            </div>
                            <p class="bekijText"><?php echo $value->cat_name; ?></p>
                        </div>
                    </a>
                    <?php

                        }
                    ?>
                </div>
        </div>
    </div>
</div>

<div class="blockCardBleu3">
    <div class="container-fluid">
        <div class="contentSix">
            <a href="/opleiders" class="cardBoxSix">
                <p class="textAlloOP">Alle opleiders</p>
                <img class="imgPolygone" src="<?php echo get_stylesheet_directory_uri();?>/img/Polygone.png" alt="">
            </a>
            <a href="/onderwer" class="cardBoxSix">
                <p class="textAlloOP">Alle onderwerpen</p>
                <img class="imgPolygone" src="<?php echo get_stylesheet_directory_uri();?>/img/Polygone.png" alt="">
            </a>
            <a href="/product-search" class="cardBoxSix">
                <p class="textAlloOP">Alle opleidingen</p>
                <img class="imgPolygone" src="<?php echo get_stylesheet_directory_uri();?>/img/Polygone.png" alt="">
            </a>
            <a href="/static-education-advice" class="cardBoxSix">
                <p class="textAlloOP">LIFT Leden</p>
                <img class="imgPolygone" src="<?php echo get_stylesheet_directory_uri();?>/img/Polygone.png" alt="">
            </a>
        </div>
    </div>
</div>

<div class="blockTopBanen">
    <div class="container-fluid">
        <div class="d-flex align-center align-item-center">
            <p class="titleTopBanen">Top Functies</p>
        </div>

        <div class="swiper-container swipeContaine2">
            <div class="swiper-wrapper">
                    <a href="/functiegerichte/" class="swiper-slide swiper-slide2">
                        <div class="cardTop bleu">
                            <?php
                                $image_principal = get_field('image', 'category_'. $categories[0]);
                                $image_principal = $image_principal ? $image_principal : get_stylesheet_directory_uri() . '/img/maternite.jpg';
                            ?>
                            <div class="contentImg">
                                <img src="<?php echo $image_principal; ?>" alt="">
                            </div>
                            <p class="bekijText bleuT">Bekijk alles</p>
                        </div>
                    </a>
                    <?php
                        foreach ($functies as $value) {
                            $image_category = get_field('image', 'category_'. $value->cat_ID);
                            $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/maternite.jpg';
                    ?>
                    <a href="sub-topic?subtopic=<?php echo $value->cat_ID; ?>" class="swiper-slide swiper-slide2">
                        <div class="cardTop ">
                            <div class="contentImg">
                                <img src="<?php echo $image_category; ?>"  alt="">
                            </div>
                            <p class="bekijText"><?php echo $value->cat_name; ?></p>

                        </div>
                    </a>
                    <?php

                        }
                    ?>
                </div>
        </div>
    </div>
</div>

<div class="blockTopBanen">
    <div class="container-fluid">
        <div class="d-flex align-center align-item-center">
            <p class="titleTopBanen">Skills om te ontwikkelen</p>
        </div>

        <div class="swiper-container swipeContaine2">
            <div class="swiper-wrapper">
                    <a href="/skill/" class="swiper-slide swiper-slide2">
                        <div class="cardTop bleu">
                            <?php
                                $image_principal = get_field('image', 'category_'. $categories[3]);
                                $image_principal = $image_principal ? $image_principal : get_stylesheet_directory_uri() . '/img/maternite.jpg';
                            ?>
                            <div class="contentImg">
                                <img src="<?php echo $image_principal; ?>" alt="">
                            </div>
                            <p class="bekijText bleuT">Bekijk alles</p>
                        </div>
                    </a>
                    <?php
                        foreach ($skills as $value) {
                            $image_category = get_field('image', 'category_'. $value->cat_ID);
                            $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/maternite.jpg';
                    ?>
                    <a href="sub-topic?subtopic=<?php echo $value->cat_ID; ?>" class="swiper-slide swiper-slide2">
                        <div class="cardTop ">
                            <div class="contentImg">
                                <img src="<?php echo $image_category; ?>" alt="">
                            </div>
                            <p class="bekijText"><?php echo $value->cat_name; ?></p>
                        </div>
                    </a>
                    <?php

                        }
                    ?>
                </div>
        </div>
    </div>
</div>

<div class="blockTopBanen">
    <div class="container-fluid">
        <div class="d-flex align-center align-item-center">
            <p class="titleTopBanen">Persoonlijke interesses om te verbeteren</p>
        </div>

        <div class="swiper-container swipeContaine2">
            <div class="swiper-wrapper">
                    <a href="/persoonlijke/" class="swiper-slide swiper-slide2">
                        <div class="cardTop bleu">
                            <?php
                                $image_principal = get_field('image', 'category_'. $categories[2]);
                                $image_principal = $image_principal ? $image_principal : get_stylesheet_directory_uri() . '/img/maternite.jpg';
                            ?>
                            <div class="contentImg">
                                <img src="<?php echo $image_principal; ?>" alt="">
                            </div>
                            <p class="bekijText bleuT">Bekijk alles</p>
                        </div>
                    </a>
                    <?php
                        foreach ($interesses as $value) {
                            $image_category = get_field('image', 'category_'. $value->cat_ID);
                            $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/maternite.jpg';
                    ?>
                    <a href="sub-topic?subtopic=<?php echo $value->cat_ID; ?>" class="swiper-slide swiper-slide2">
                        <div class="cardTop ">
                            <div class="contentImg">
                                <img src="<?php echo $image_category; ?>" alt="">
                            </div>
                            <p class="bekijText"><?php echo $value->cat_name; ?></p>

                        </div>
                    </a>
                    <?php

                        }
                    ?>
                </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<?php get_footer(); ?>
<?php wp_footer(); ?>

<script>
     $('#search').keyup(function(){
        var txt = $(this).val();

        event.stopPropagation();

        $("#list").fadeIn("fast");

        $(document).click( function(){

            $('#list').hide();

        });

        if(txt){
            $.ajax({

                url:"fetch-ajax",
                method:"post",
                data:{
                    search:txt,
                },
                dataType:"text",
                success: function(data){
                    console.log(data);
                    $('#autocomplete').html(data);
                }
            });
        }
        else
            $('#autocomplete').html("<center> <small>Typing ... </small> <center>");
    });
</script>

