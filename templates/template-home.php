<?php /** Template Name: Home template */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<?php 

$page = dirname(__FILE__) . '/check_visibility.php';
require($page); 

?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<?php

    function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $rand = $characters[rand(0, strlen($characters))];
            $randstring .= $rand;  
        }
        return $randstring;
    }

    if (isset($_POST))
    {

    extract($_POST);
    if(isset($email)){
       
        if($email != null)
        {
             $args = array(
                 'post_type' => 'company', 
                 'post_status' => 'publish',
                 'posts_per_page' => -1,
                 'order' => 'DESC',                        
             );
        
             $companies = get_posts($args);

             foreach($companies as $company){
                 if($company->post_title == $company){
                     $companie = $company;
                     break;
                 }
             }

            if($first_name == null)
                $first_name = "ANONYM";
            
            if($last_name == null)
                $last_name = "ANONYM";
            
                $login = RandomString();
                $password = RandomString();
            

            $userdata = array(
                'user_pass' => $password,
                'user_login' => $login,
                'user_email' => $email,
                'user_url' => 'https://livelearn.nl/inloggen/',
                'display_name' => $first_name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'role' => 'subscriber'
            );

            $user_id = wp_insert_user(wp_slash($userdata));
             if(is_wp_error($user_id)){
                 $danger = $user_id->get_error_message();
                 ?>
                  <script>
                     window.location.replace("/?message=".$danger);
                  </script>
                  <?php
                  echo ("<span class='alert alert-info'>" .  $danger . "</span>");   
              }else
                  {
                      $subject = 'Je LiveLearn inschrijving is binnen! ✨';
                      $body = "
                      Bedankt voor je inschrijving<br>
                      <h1>Hello " . $first_name  . "</h1>,<br> 
                      Je hebt je succesvol geregistreerd. Welcome onboard! Je LOGIN-ID is <b style='color:blue'>" . $login . "</b>  en je wachtwoord <b>".$password."</b><br><br>
                      <h4>Inloggen:</h4><br>
                      <h6><a href='https:livelearn.nl/inloggen/'> Log in </a></h6>
                      ";
                
                      $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
                      wp_mail($email, $subject, $body, $headers, array( '' )) ; 
                      
                      update_field('telnr', $telefoonnummer, 'user_' . $user_id);
                      update_field('degree_user', $choiceDegrees, 'user_'.$user_id);
                      update_field('company', $companie, 'user_'.$user_id);
                      update_field('work', $work, 'user_'.$user_id);
                      update_field('course_type_user', $choiceCourseType, 'user_'.$user_id);
                      update_field('generatie', $choiceGeneratie, 'user_'.$user_id);
                      update_field('country', $prive, 'user_'.$user_id);
                      $subtopics_already_selected = get_user_meta(get_current_user_id(),'topic');
                    foreach ($bangerichtsChoice as $key => $topic) { 
                        if (!empty($topic))
                        {
                            if (!(in_array($topic, $subtopics_already_selected)))
                            {
                                add_user_meta(get_current_user_id(),'topic',$topic);  
                            }
                            
                        }
                    }
                    
                      header('Location: /inloggen/?message=Je bent succesvol geregistreerd. Je ontvangt een e-mail met je login-gegevens.');
                  ?>
                  
             <?php
               
             }
         }
     }
     }
    
/** 
 * Skills Passport
*/

$degrees=[
    'n.v.t'=> 'NVT',
    'mbo1' => 'MBO1',
    'mbo2' => 'MBO2',
    'mbo3' => 'MBO3',
    'mbo4' => 'MBO4',
    'hbo' => 'HBO',
    'university' => 'Universiteit',
];
  foreach ($degrees as $key => $value) {
    $input_degrees.= '<input type="radio" name="choiceDegrees" value='.$key.' id="level'.$key.'"><label for="level'.$key.'">'.$value.'</label>';
  }

  $generaties=[
    'Generatie BabyBoom (1940-1960)' => 'BabyBoom',
    'Generatie X (1961-1980)' => 'X',
    'Millenials (1981-1995)' => 'Millennials',
    'Generatie Z (1996-nu)' => 'Z',
];
    foreach ($generaties as $key => $value) {
        $input_generaties.= '<input type="radio" name="choiceGeneratie" value='.$value.' id="generatie'.$key.'"><label for="generatie'.$key.'">'.$key.'</label>';
    }

    $course_type=['Opleidingen','E-learnings','Lezingen','Trainingen','Videos','Events','Workshop','Artikelen','Webinars','Masterclasses','Assessments','Podcasts'];
    foreach ($course_type as $key => $value) {
         $input_course_type.= '
         <div class="blockInputCheck">
             <input type="checkbox" name="choiceCourseType[]" value='.$value.' id="courseType'.$key.'"/><label class="labelChoose btnBaangerichte" for="courseType'.$key.'">'.$value.'</label>
        </div>';
        
    }
/** 
 * Skills Passport
*/
    $args = array(
        'post_type' => array('course', 'post'), 
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

<?php


    $subtopics = array();  
    foreach($categories as $categ){
        //Topics
        $topicss = get_categories(
            array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categ,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ) 
        );

        foreach ($topicss as  $value) {
            $subtopic = get_categories( 
                 array(
                 'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                 'parent'  => $value->cat_ID,
                 'hide_empty' => 0,
                  //  change to 1 to hide categores not having a single post
                ) 
            );
            $subtopics = array_merge($subtopics, $subtopic);      
        }
    }




    foreach($bangerichts as $key1=>$tag){
        
        //Topics
        $cats_bangerichts = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => $tag->cat_ID,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
        if (count($cats_bangerichts)!=0)
        {
            $row_bangrichts.='<div hidden=true class="cb_topics_bangricht_'.($key1+1).'" '.($key1+1).'">';
            foreach($cats_bangerichts as $key => $value)
            {   
                $row_bangrichts .= '
                <input type="checkbox" name="choice_bangrichts_'.$value->cat_ID.'" value= '.$value->cat_ID .' id=subtopics_bangricht_'.$value->cat_ID.' /><label class="labelChoose" for=subtopics_bangricht_'.$value->cat_ID.'>'. $value->cat_name .'</label>';
            }
            $row_bangrichts.= '</div>';
        }
      
    }

    foreach($functies as $key1 =>$tag)
    {
        
        //Topics
        $cats_functies = get_categories(
            array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => $tag->cat_ID,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
        if (count($cats_functies)!=0)
        {
            $row_functies.='<div hidden=true class="cb_topics_funct_'.($key1+1).'" '.($key1+1).'">';
            foreach($cats_functies as $key => $value)
            {   
            $row_functies .= '
            <input type="checkbox" name="choice_functies_'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_funct_'.($value->cat_ID).'" /><label class="labelChoose" for="cb_funct_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
            }
            $row_functies.= '</div>';
        }
    }

    foreach($skills as $key1=>$tag){
        //Topics
        $cats_skills = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => $tag->cat_ID,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
        if (count($cats_skills)!=0)
        {
            $row_skills.='<div hidden=true class="cb_topics_skills_'.($key1+1).'" '.($key1+1).'">';
            foreach($cats_skills as $key => $value)
            {   
                    $row_skills .= '
                    <input type="checkbox" name="choice_skills'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_skills_'.($value->cat_ID).'" /><label class="labelChoose"  for="cb_skills_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
            }
            $row_skills.= '</div>';
        }
      
    }

    foreach($interesses as $key1=>$tag){
        //Topics
            $cats_interesses = get_categories( array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent' => $tag->cat_ID,
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ));
            if (count($cats_interesses)!=0)
        {
            $row_interesses.='<div hidden=true class="cb_topics_personal_'.($key1+1).'" '.($key1+1).'">';
            foreach($cats_interesses as $key => $value)
            {   
            $row_interesses .= '
            <input type="checkbox" name="choice_interesses_'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_interesses_'.($value->cat_ID).'" /><label class="labelChoose"  for="cb_interesses_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
            }
            $row_interesses.= '</div>';
        }
      
    }
      
    if (isset($_POST["subtopics_first_login"])){
        unset($_POST["subtopics_first_login"]);
        $subtopics_already_selected = get_user_meta(get_current_user_id(),'topic');
        foreach ($_POST as $key => $subtopics) { 
            if (isset($_POST[$key]))
            {
                if (!(in_array($_POST[$key], $subtopics_already_selected)))
                {
                    add_user_meta(get_current_user_id(),'topic',$_POST[$key]);  
                }
                
            }
        }
        update_field('is_first_login', true, 'user_'.get_current_user_id());
    }
    
    $is_first_login = (get_field('is_first_login','user_' . get_current_user_id()));
    if (!$is_first_login && get_current_user_id() !=0 )
    {
        
    ?>    
    <!-- Modal First Connection --> 
    <div class="contentModalFirst">
        <div class="modal" id="myFirstModal" tabindex="-1" role="dialog" aria-labelledby="myFirstModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modalHeader">
                        <h5 class="modal-title text-center" id="exampleModalLabel">Welcome to livelearn</h5>
                        <p class="pickText">Pick your favorite topics to set up your feeds</p>
                    </div>
                    <div class="modal-body">
                      <form method="post" name="first_login_form">
                        <div class="blockBaangerichte">
                            <h1 class="titleSubTopic">Baangerichte</h1>
                            <div class="hiddenCB">
                                <div>
                                    <?php
                                    foreach($bangerichts as $key => $value)
                                    {
                                        //echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                        echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_bangricht'.($key+1).'" /><label class="labelChoose btnBaangerichte subtopics_bangricht_'.($key+1).' '.($key+1).'" for="cb_topics_bangricht'.($key+1).'">'. $value->cat_name .'</label>';
                                    }
                                    ?>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnBaangerichte" for="cb1">Choice A</label> -->

                                </div>
                            </div>
                            <div class="subtopicBaangerichte">

                                <div class="hiddenCB">
                                    <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                    <?php
                                    echo $row_bangrichts;
                                    ?>
                                </div>
                                <button type="button" class="btn btnNext" id="nextblockBaangerichte">Next</button>
                            </div>
                        </div>

                        <div class="blockfunctiegericht">
                            <h1 class="titleSubTopic">functiegericht</h1>
                            <div class="hiddenCB">
                                <div>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnFunctiegericht" for="cb1">Choice A</label> -->
                                    <?php
                                    foreach($functies as $key => $value)
                                    {
                                        //echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                        echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_funct'.($key+1).'" /><label class="labelChoose btnFunctiegericht subtopics_funct_'.($key+1).' '.($key+1).'"  for="cb_topics_funct'.($key+1).'">'. $value->cat_name .'</label>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="subtopicFunctiegericht">
                                <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                <div class="hiddenCB">
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                    <?php
                                        echo $row_functies;
                                    ?>
                                </div>
                                <button type="button" class="btn btnNext" id="nextFunctiegericht">Next</button>
                            </div>
                        </div>

                        <div class="blockSkills">
                            <h1 class="titleSubTopic">Skills</h1>
                            <div class="hiddenCB">
                                <div>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnSkills" for="cb1">Choice A</label> -->

                                    <?php
                                    foreach($skills as $key => $value)
                                    {
                                        //echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                        echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_skills'.($key+1).'" /><label class="labelChoose btnSkills subtopics_skills_'.($key+1).' '.($key+1).'" for=cb_skills'.($key+1).'>'. $value->cat_name .'</label>';
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="subtopicSkills">
                                <div class="hiddenCB">
                                    <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                    <?php
                                        echo $row_skills;
                                    ?>
                                </div>
                                <button type="button" class="btn btnNext" id="nextSkills">Next</button>
                            </div>
                        </div>

                        <div class="blockPersonal">
                            <h1 class="titleSubTopic">Personal interest </h1>
                            <div class="hiddenCB">
                                <div>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnPersonal" for="cb1">Choice A</label> -->

                                    <?php
                                    foreach($interesses as $key => $value)
                                    {
                                        //echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                        echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_personal'.($key+1).'" /><label class="labelChoose btnPersonal subtopics_personal_'.($key+1).' '.($key+1).'" for="cb_topics_personal'.($key+1).'">'. $value->cat_name .'</label>';
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="subtopicPersonal">
                                <div class="hiddenCB">
                                    <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                    <?php
                                        echo $row_interesses;
                                    ?>
                                </div>
                                <button name="subtopics_first_login" class="btn btnNext" id="nextPersonal">Save</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    }  
    ?>




<div class="contentOne">
  
    <div class="boxOne3">
        <div class="container">
            <div class="voorBlock">
                <p class="wordDeBestText2" style="font-weight: bold">Ontdek, ontwikkel en maak carrière </p>
                <p class="altijdText2">Er valt altijd iets nieuws te leren, maak gratis jouw skills paspoort en word expert.</p>
                <form action="/product-search" class="position-relative" method="POST">
                    <input id="search" type="search" class="jAuto searchInputHome form-control"
                        placeholder="Zoek opleidingen, experts of onderwerpen" name="search" autocomplete="off">
                    <button class="btn btn-Zoek elementWeb">Zoek</button>
                    <?php 
                        if(get_current_user_id()==0){ 
                    ?>

                        <div class="groupeBtn-Jouw-inloggen">
                            <button type="button" class="btn jouwn-skills elementWeb" data-toggle="modal" data-target="#SkillsModal" >Jouw skills paspoort in 6 stappen</button>
                            <button type="button" class="jouwn-skills elementMobile" data-toggle="modal" data-target="#SkillsModal" >Skills Paspoort</button>
                            <a href="#" data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal"  class="inloggenbtn">Inloggen</a>
                        </div>

                    <?php 
                        }
                    ?>
                    <div class="dropdown-menuSearch" id="list">
                        <div class="list-autocomplete" id="autocomplete">
                        <center> <i class='hasNoResults'>No matching results ... </i> </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Skills passport -->
    <div class="modal fade" id="SkillsModal" tabindex="-1" role="dialog" aria-labelledby="SkillsModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Jouw skills paspoort in 6 stappen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="skills_passport_add" method="post">
                        <div class="blockStepSkillsPaspoort">
                            <div class="setp" >
                                <div class="circleIndicator colorStep" id="Niveau">
                                    <i class="fa fa-level-up" aria-hidden="true"></i>
                                </div>
                                <p class="textOpleidRight">Level</p>
                            </div>
                            <div class="setp" >
                                <div class="circleIndicator" id="Vakgebied">
                                    <i class="fa fa-file"></i>
                                </div>
                                <p class="textOpleidRight">Vakgebied (en) </p>
                            </div>
                            <div class="setp" >
                                <div class="circleIndicator" id="Locatie">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <p class="textOpleidRight">Locatie</p>
                            </div>
                            <div class="setp" >
                                <div class="circleIndicator" id="Leervorm">
                                    <i class="fa fa-graduation-cap"></i>
                                </div>
                                <p class="textOpleidRight">Leervorm</p>
                            </div>
                            <div class="setp" >
                                <div class="circleIndicator" id="Generatie">
                                    <i class="fa fa-calendar-check"></i>
                                </div>
                                <p class="textOpleidRight">Generatie</p>
                            </div>
                            <div class="setp" >
                                <div class="circleIndicator" id="Finish">
                                    <i class="fa fa-flag-checkered"></i>
                                </div>
                                <p class="textOpleidRight">Finish</p>
                            </div>
                        </div>
                    
                            <div class="step1SkillsPasspoort">
                                <p class="titleBlockStepSkills">Wat is jouw hoogst afgeronde opleiding ?</p>
                                <div class="blockInputRadio">
                                    <?= $input_degrees; ?>
                                </div>
                                <div class="text-center w-100 groupBtnStepSkillsP">
                                    <button type="button" class="btn btnSkip" id="btnSkip">Sikp</button>
                                    <button type="button" class="btn btn-volgende" id="btnStep1SkillsPasspoort">Volgende</button>
                                </div>
                            </div>

                            <div class="step2SkillsPasspoort stepSkillpasspoort">
                                <p class="titleBlockStepSkills">In welk vakgebied ben je werkzaam of ben je geïnteresseerd ?
                                    <br><span>(Meerdere mogelijk)</span></p>
                                <div class="hiddenCB">
                                    <div>
                                        <?php
                                        foreach($bangerichts as $bangericht){
                                        $image_category = get_field('image', 'category_'. $bangericht->cat_ID);
                                        $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/Image-79.png';
                                        ?>
                                        <div class="blockInputCheck">
                                            <input type="checkbox" name="bangerichtsChoice[]" value=<?php echo $bangericht->cat_ID ?> id="<?php echo $bangericht->cat_ID ?>" /><label class="labelChoose btnBaangerichte" for="<?php echo $bangericht->cat_ID ?>"><?php echo $bangericht->cat_name ?></label>
                                        </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="text-center w-100 groupBtnStepSkillsP">
                                    <button type="button" class="btn btnTerug" id="btnTerug1SkillsPasspoort">Terug</button>
                                    <button type="button" class="btn btn-volgende" id="btnStep2SkillsPasspoort">Volgende stap</button>
                                </div>
                            </div>

                            <div class="step3SkillsPasspoort stepSkillpasspoort">
                                <p class="titleBlockStepSkills">Geef de locatie(s) aan waar jij woont of werkt</p>
                                <div class="input-group-locaties">
                                    <div class="form-group-skillsP">
                                        <label for="">Privé</label>
                                        <select name="prive" class="form-control" id="exampleFormControlSelect1">
                                            <option value="" disabled selected>Selecteer de stad waar je woont</option>
                                            <option>Dakar</option>
                                            <option>London</option>
                                            <option>Berlin</option>
                                            <option>Quebec</option>
                                        </select>
                                    </div>
                                    <div class="form-group-skillsP">
                                        <label for="">Werk</label>
                                        <select name="work" class="form-control" id="exampleFormControlSelect1">
                                            <option value="" disabled selected>Selecteer de stad waar je werkt</option>
                                            <option>Dakar</option>
                                            <option>London</option>
                                            <option>Berlin</option>
                                            <option>Quebec</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-center w-100 groupBtnStepSkillsP">
                                    <button type="button" class="btn btnTerug" id="btnTerug2SkillsPasspoort">Terug</button>
                                    <button type="button" class="btn btn-volgende" id="btnStep3SkillsPasspoort">Volgende stap</button>
                                </div>
                            </div>

                            <div class="step4SkillsPasspoort stepSkillpasspoort">
                                <p class="titleBlockStepSkills">Hoe leer jij het liefst ?</p>
                                <div class="hiddenCB">
                                    <div>
                                        <?= $input_course_type; ?>
                                    </div>
                                    
                                </div>
                                    
                                    <div class="text-center w-100 groupBtnStepSkillsP">
                                        <button type="button" class="btn btnTerug" id="btnTerug3SkillsPasspoort">Terug</button>
                                        <button type="button" class="btn btn-volgende" id="btnStep4SkillsPasspoort">Volgende stap</button>
                                    </div>
                                </div>

                            <div class="step5SkillsPasspoort stepSkillpasspoort">
                                    <p class="titleBlockStepSkills">Tot welke generatie behoor je ?</p>
                                    <div class="blockInputRadio" id="groupBtnChoice2">
                                        <?=  $input_generaties; ?>
                                    </div>
                                    <div class="text-center w-100 groupBtnStepSkillsP">
                                        <button type="button" class="btn btnTerug" id="btnTerug4SkillsPasspoort">Terug</button>
                                        <button type="button" class="btn btn-volgende" id="btnStep5SkillsPasspoort">Volgende stap</button>
                                    </div>
                                </div>

                            <div class="step6SkillsPasspoort stepSkillpasspoort">
                                    <p class="titleBlockStepSkills">Vul je gegevens in en je hebt direct toegang tot je skills paspoort </p>
                                    <div class="hiddenCB">
                                        <div class="input-group-register">
                                            <div class="form-group-skills">
                                                <label for="">Voornaam</label>
                                                <input name="first_name"  type="text" placeholder="Voorman">
                                            </div>
                                            <div class="form-group-skills">
                                                <label for="">Achternaam</label>
                                                <input name="last_name" type="text" placeholder="Achternaam">
                                            </div>
                                            <div class="form-group-skills">
                                                <label for="">Bedrijf</label>
                                                <input name="companie" type="text" placeholder="Bedrijf">
                                            </div>
                                            <!-- <div class="form-group-skills">
                                                <label for="">Wachtwoord</label>
                                                <input type="text" placeholder="Wachtwoord">
                                            </div> -->
                                            <div class="form-group-skills">
                                                <label for="">Email</label>
                                                <input name="email" type="text" placeholder="Email">
                                            </div>
                                            <div class="form-group-skills">
                                                <label for="">Telefoonnummer</label>
                                                <input name="telefoonnummer" type="text" placeholder="Telefoonnummer">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center w-100 groupBtnStepSkillsP">
                                        <button type="button" class="btn btnTerug" id="btnTerug5SkillsPasspoort">Terug</button>
                                        <button type="submit" class="btn btn-volgende">Maak je skills paspoort</button>
                                    </div>
                                </div>

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
<div class="blockWinDeWar">
    <div class="container-fluid">
        <div class="elementWinWar">
            <div class="imgWInWar">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/win-war.png"  alt="">
            </div>
          <div class="text-center">
              <h2 class="titleWinWar">Win de <b>War-on-Talent</b></h2>
              <p class="descriptionWinWar">Gratis ontwikkeltraject t.w.v €700 p.p voor je operationele team (max. MBO2)</p>
          </div>
            <a href="/ontwikkeladvies" class="btn btnLessHoe">Lees hoe</a>
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
                <a href="/voor-teachers">
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
                    <a href="/voor-teachers">
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
                        if(!visibility($course, $visibility_company))
                            continue;

                        /*
                        * Categories
                        */
                        $location = 'Virtual';
                        $day = "<p><i class='fas fa-calendar-week'></i></p>";
                        $month = '';

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

                        $datas = get_field('data_locaties', $course->ID);
                        if($datas){
                            $data = $datas[0]['data'][0]['start_date'];
                            if($data != ""){
                                $day = explode('/', explode(' ', $data)[0])[0];
                                $mon = explode('/', explode(' ', $data)[0])[1];
                                $month = $calendar[$mon];
                            }

                            $location = $datas[0]['data'][0]['location'];
                        }else{
                            $datas = explode('-', get_field('data_locaties_xml', $course->ID)[0]['value']);
                            $data = $datas[0];
                            $day = explode('/', explode(' ', $data)[0])[0];
                            $month = explode('/', explode(' ', $data)[0])[1];
                            $month = $calendar[$month];
                            $location = $datas[2];
                        }

                        if(!$month)
                            continue;

                        if(isset($data)){
                            $date_now = strtotime(date('Y-m-d'));
                            $data = strtotime(str_replace('/', '.', $data));
                            if($data < $date_now)
                                continue;
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
                        //Image
                        $thumbnail = get_the_post_thumbnail_url($course->ID);
                        if(!$thumbnail)
                            $thumbnail = get_field('preview', $course->ID)['url'];

                        if(!$thumbnail)
                            $thumbnail = get_field('url_image_xml', $course->ID);

                        if(!$thumbnail)
                            $thumbnail = get_stylesheet_directory_uri() . '/img/placeholder.png';
                        
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
                  $author_id = 0;
                  $users = get_users();

                  foreach($users as $user){
                      $name_user = strtolower($user->data->display_name);
                      if($name_user == "Livelean" || $name_user == "livelean"){
                        $author_id = intval($user->data->ID);
                        $name_user = $user->display_name;
                        $featured = get_field('featured', 'user_' . $author_id);
                        if($featured)
                            break;
                      }
                  }

                  if(!empty($featured))
                    $courses = $featured;
                  
                  $i = 0;

                  foreach($courses as $course){

                    if(!visibility($course, $visibility_company))
                        continue;

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
                <img class="imgCategoryCard" src="<?php echo get_stylesheet_directory_uri();?>/img/alle-opleiders.png" alt="">
                <p class="textAlloOP">Alle opleiders</p>
                <img class="imgPolygone" src="<?php echo get_stylesheet_directory_uri();?>/img/Polygone.png" alt="">
            </a>
            <a href="/onderwer" class="cardBoxSix">
                <img class="imgCategoryCard" src="<?php echo get_stylesheet_directory_uri();?>/img/all-onderwerpen.png" alt="">
                <p class="textAlloOP">Alle onderwerpen</p>
                <img class="imgPolygone" src="<?php echo get_stylesheet_directory_uri();?>/img/Polygone.png" alt="">
            </a>
            <a href="/product-search" class="cardBoxSix">
                <img class="imgCategoryCard" src="<?php echo get_stylesheet_directory_uri();?>/img/all-opleidegen.png" alt="">
                <p class="textAlloOP">Alle opleidingen</p>
                <img class="imgPolygone" src="<?php echo get_stylesheet_directory_uri();?>/img/Polygone.png" alt="">
            </a>
            <a href="/static-education-advice" class="cardBoxSix">
                <img class="imgCategoryCard" src="<?php echo get_stylesheet_directory_uri();?>/img/skills-passport.png" alt="">
                <p class="textAlloOP">Skills paspoort</p>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<?php get_footer(); ?>
<?php wp_footer(); ?>

<script>

    $('.bangricht').click(()=>{
        alert('bangricht');
    });

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

<script>
    $('.bntNotification').click((e)=>{
        $.ajax({
                url:"/read-notification",
                method:"get",
                data:
                {
                },
                dataType:"text",
                success: function(data){
                    // Get the modal
                    console.log(data);
                    var modal = document.getElementById("ModalNotification");
                    // $('.display-fields-clean').html(data)
                    // Get the button that opens the modal


                    // Get the <span> element that closes the modal
                    //var span = document.getElementsByClassName("close")[0];

                    // When the user clicks on the button, open the modal

                        modal.style.display = "block";

                    // When the user clicks on <span> (x), close the modal
                    // span.onclick = function() {
                    //     modal.style.display = "none";
                    // }

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

