<?php

    /** 
 *  Handling adding tags to courses v2
*/
if (isset($_GET['edit']))
{
    $already_linked_tags = array();
    if (get_field('categories',$_GET['id']) != null)
        foreach (get_field('categories',$_GET['id']) as $key => $value) 
            array_push($already_linked_tags,$value['value']);
}


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

    $choosen_categories = array();
    $choosen_categorie = get_field('categories', $_GET['id']);
    if(!$choosen_categorie)
        $choosen_categorie = get_field('category_xml', $_GET['id']);

    foreach($choosen_categorie as $choosen){
        if(empty($choosen_categories))
            $choosen_categories = explode(',', $choosen['value']);
        else
            array_merge($choosen_categories, explode(',', $choosen['value']));
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
                $selected = '';
                if(!empty($already_linked_tags))
                    $selected = in_array($value->cat_ID,$already_linked_tags) ? 'checked' : '' ; 
                                    
                $row_bangrichts .= '
                <input '.$selected.' class="selected" type="checkbox" name="choice_bangrichts_'.$value->cat_ID.'" value= '.$value->cat_ID .' id=subtopics_bangricht_'.$value->cat_ID.' /><label class="labelChoose" for=subtopics_bangricht_'.$value->cat_ID.'>'. $value->cat_name .'</label>';
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
                foreach ($already_linked_tags as $key => $selected_tags) { 
                    $selected =  $selected_tags['value'] == $value->cat_ID ? true : false ; 
                }
                $row_functies .= '
                <input selected='.$selected.' class="selected" type="checkbox" name="choice_functies_'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_funct_'.($value->cat_ID).'" /><label class="labelChoose" for="cb_funct_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
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
                foreach ($already_linked_tags as $key => $selected_tags) { 
                    $selected =  $selected_tags['value'] == $value->cat_ID ? false : true ; 
                }
                    $row_skills .= '
                    <input selected='.$selected.' class="selected" type="checkbox" name="choice_skills'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_skills_'.($value->cat_ID).'" /><label class="labelChoose"  for="cb_skills_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
            }
            $row_skills.= '</div>';
        }
      
    }

    foreach($interesses as $key1=>$tag) {
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
                foreach ($already_linked_tags as $key => $selected_tags) { 
                    $selected =  $selected_tags['value'] == $value->cat_ID ? false : true ; 
                }
                $row_interesses .= '
                <input selected='.$selected.' class="selected" type="checkbox" name="choice_interesses_'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_interesses_'.($value->cat_ID).'" /><label class="labelChoose"  for="cb_interesses_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
            }
            $row_interesses.= '</div>';
        }
      
    }
    
?>

<?php
/**
 * Handling adding tags to courses
 */
if (isset($_POST['add_tags_to_course']) && $_POST['add_tags_to_course']==true)
    {
        $already_linked_tags = array();
        if (get_field('categories',$_GET['id'])!=null)
        {
            foreach (get_field('categories',$_GET['id']) as $key => $value) 
            {
                array_push($already_linked_tags,$value['value']);
            } 
        }
        extract($_POST);
        $categories = $already_linked_tags ?? array();
        foreach ($tags as $key => $tag) {
            array_push($categories,$tag);
        }
        $categories = array_merge($categories,$already_linked_tags);
        update_field('categories', $categories, $id);
    }
?>

    <div class="row">
        <div class="col-md-5 col-lg-8">
            <div class="cardCoursGlocal">
                <div id="basis" class="w-100">
                  
                    <div class="titleOpleidingstype">
                        <h2>TAGS</h2>
                    </div>
                  
                    <!-- <form id="step1">
                        <div class="acf-field">
                            <input type="hidden" id="course_id" value="<?= $_GET['id'] ?>">
                            <label for="locate">Specifieke baan :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-bangers"  form="foo_form" class="multipleSelect2 dropdown" multiple="true">
                                    <?php
                                    //Baangerichts
                                    $displayed = array();
                                    foreach($bangerichts as $value){
                                        $state = false;
                                        $childrens = get_term_children($value->cat_ID, 'course_category');
                                        foreach($choosen_categories as $element)
                                            if(in_array($element, $childrens) && !in_array($value->cat_ID, $displayed)){
                                                echo "<option selected value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                                array_push($displayed, $value->cat_ID);
                                                $state = true;
                                            }

                                            if($state)
                                                continue;
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <label for="locate">Functies :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-functs" class="multipleSelect2" multiple="true">
                                    <?php
                                    //Functies
                                    foreach($functies as $value){
                                        $state = false;
                                        $childrens = get_term_children($value->cat_ID, 'course_category');
                                        foreach($choosen_categories as $element)
                                            if(in_array($element, $childrens) && !in_array($element, $displayed)){
                                                echo "<option selected value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                                array_push($displayed, $element);
                                                $state = true;
                                            }

                                            if($state)
                                                continue;
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";                                    }
                                    ?>
                                </select>

                            </div>

                            <label for="locate">Skills :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-skills" class="multipleSelect2" multiple="true">
                                    <?php
                                    //Skills
                                    foreach($skills as $value){
                                        $displayed = array(); 
                                        $state = false;
                                        $childrens = get_term_children($value->cat_ID, 'course_category');
                                        foreach($choosen_categories as $element)
                                            if(in_array($element, $childrens) && !in_array($element, $displayed)){
                                                echo "<option selected value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                                array_push($displayed, $element);
                                                $state = true;
                                            }

                                            if($state)
                                                continue;
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";                                    }
                                    ?>
                                </select>

                            </div>

                            <label for="locate">Persoonlikje interesses :</label><br>
                            <div class="form-group formModifeChoose">

                                <select id="form-control-interess" class="multipleSelect2" multiple="true">
                                    <?php
                                    //Persoonlikje interesses
                                    foreach($interesses as $value){
                                        $state = false;
                                        $childrens = get_term_children($value->cat_ID, 'course_category');
                                        foreach($choosen_categories as $element)
                                            if(in_array($element, $childrens) && !in_array($element, $displayed)){
                                                echo "<option selected value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                                array_push($displayed, $element);
                                                $state = true;
                                            }

                                            if($state)
                                                continue;
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";                                    }
                                    ?>
                                </select>

                            </div>
                            <button type="button" name="step1" id="btn-ajax" class="btn btn-info">Apply</button>
                        </div>

                        

                    </form> -->

                    <div class="addCourseStep">
                            <form method="post" name="first_login_form" id="first_login_form">
                            <div class="blockBaangerichte">
                                <h1 class="titleSubTopic">Baangerichte</h1>
                                <div class="hiddenCB">
                                    <div>
                                    <?php
                                        foreach($bangerichts as $key => $value)
                                        {
                                            $state = false;
                                            $childrens = get_term_children($value->cat_ID, 'course_category');
                                            foreach($choosen_categories as $element)
                                                if(in_array($element, $childrens) && !in_array($element, $displayed)){
                                                    echo '<input checked type="checkbox" value= '.$value->cat_ID .' id="cb_topics_bangricht'.($key+1).'" /><label class="labelChoose btnBaangerichte subtopics_bangricht_'.($key+1).' '.($key+1).'" for="cb_topics_bangricht'.($key+1).'">'. $value->cat_name .'</label>';
                                                    array_push($displayed, $element);
                                                    $state = true;
                                                }
    
                                                if($state)
                                                    continue;
                                            echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_bangricht'.($key+1).'" /><label class="labelChoose btnBaangerichte subtopics_bangricht_'.($key+1).' '.($key+1).'" for="cb_topics_bangricht'.($key+1).'">'. $value->cat_name .'</label>';
                                        }
                                    ?>

                                    </div>
                                </div>
                                <div class="subtopicBaangerichte">

                                    <div class="hiddenCB">
                                        <p class="pickText">Pick the sub-topics matching with the course you are creating</p>
                                        
                                        <?php
                                        echo $row_bangrichts;
                                        ?>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="button" class="btn btnSkipCourse" id="btnSkipTopics1">Skip</button>
                                        <button type="button" class="btn btnNext" id="nextblockBaangerichte">Next</button>
                                    </div>
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
                                        
                                        <?php
                                            echo $row_functies;
                                        ?>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <button type="button" class="btn btnSkipCourse" id="btnSkipTopics2">Skip</button>
                                        <button type="button" class="btn btnNext" id="nextFunctiegericht">Next</button>
                                    </div>
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
                                        
                                        <?php
                                            echo $row_skills;
                                        ?>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="button" class="btn btnSkipCourse" id="btnSkipTopics3">Skip</button>
                                        <button type="button" class="btn btnNext" id="nextSkills">Next</button>
                                    </div>
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
                                        
                                        <?php
                                            echo $row_interesses;
                                        ?>
                                    </div>
                                    <button name="subtopics_first_login" class="btn btnNext" id="nextPersonal">Save</button>
                                </div>
                            </div>
                        
                            </form>
                        </div>

                    <form action='/dashboard/teacher/course-selection/?func=add-video&id=<?php echo $_GET['id'] ?>&step=6' method='post'>
                        <div class='acf-field' id="autocomplete_ajax">
                        </div>
                    </form>
                   
                </div>
            </div>
        </div>


        <div class="col-md-3 col-lg-4 col-sm-12">
            <div class="blockCourseToevoegen">
                <p class="courseToevoegenText">Course toevoegen</p>
                <div class="contentBlockRight">
                    <a href="/dashboard/teacher/course-selection/" class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-book"></i>
                        </div>
                        <p class="textOpleidRight">Opleidingstype</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-video<?php if(isset($_GET['id'])) echo '&id=' .$_GET['id'] . '&edit'; ?>" class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-info"></i>
                        </div>
                        <p class="textOpleidRight">Basis informatie</p>
                    </a>
                    <a href="<?php echo '/dashboard/teacher/course-selection/?func=add-video&id=' . $_GET['id'] . '&step=2&edit'; ?>" class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <p class="textOpleidRight">Uitgebreide beschrijving</p>
                    </a>
                    <a  href="<?php echo '/dashboard/teacher/course-selection/?func=add-video&id=' . $_GET['id'] . '&step=3&edit'; ?>"  class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-film" aria-hidden="true"></i>
                        </div>
                        <p class="textOpleidRight ">voeg video's toe</p>
                    </a>
                    <a  href="<?php echo '/dashboard/teacher/course-selection/?func=add-video&id=' . $_GET['id'] . '&step=4&edit'; ?>"  class="contentBlockCourse">
                        <div class="circleIndicator passEtape">
                            <i class="fa fa-paste" aria-hidden="true"></i>
                        </div>
                        <p class="textOpleidRight">Details en onderwepren</p>
                    </a>
                    <a  href="<?php echo '/dashboard/teacher/course-selection/?func=add-video&id=' . $_GET['id'] . '&step=5&edit'; ?>"  class="contentBlockCourse">
                        <div class="circleIndicator passEtape2">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                        </div>
                        <p class="textOpleidRight">Onderwerpen</p>
                    </a>
                    <a  href="<?php echo '/dashboard/teacher/course-selection/?func=add-video&id=' . $_GET['id'] . '&step=6&edit'; ?>"  class="contentBlockCourse">
                        <div class="circleIndicator">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        <p class="textOpleidRight">Experts</p>
                    </a>
                </div>
            </div>
        </div>
        
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>

    var selected_subtopics_id=[];
    $(".selected").click((e)=>{
        let tags_id = e.target.value;
        let if_exist = selected_subtopics_id.indexOf(tags_id);
        if (if_exist > 0)
            selected_subtopics_id.splice(if_exist, 1)
        else 
            selected_subtopics_id.push(tags_id);
        
    })
    
    $("#nextPersonal").click((e)=>{
        e.preventDefault();
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const id = urlParams.get('id')
        const step = urlParams.get('step')
        const url = "?func=add-video&id="+id+"&step="
        $.ajax({
            url:url+step,
            method:"post",
            data:{
                add_tags_to_course:true,
                tags:selected_subtopics_id,
                id:id
            },
            dataType:"text",
            success: function(data){
                window.location.assign("/dashboard/teacher/course-selection"+url+(parseInt(step)+1));
            }
    })
    });

    $("#btn-ajax").click((e)=>
    {
        $(e.preventDefault())
        var course_id = $("#course_id").val();
        var bangers = $("#form-control-bangers").val();
        var functs = $("#form-control-functs").val();
        var skills = $("#form-control-skills").val();
        var interess = $("#form-control-interess").val();

        $.ajax({

            url:"/topic-ajax",
            method:"post",
            data:{
                course_id:course_id,
                bangers:bangers,
                functs:functs,
                skills:skills,
                interess:interess
            },
            dataType:"text",
            success: function(data){
                console.log(data);
                $('#autocomplete_ajax').html(data);
            }
        });
    })
</script>
