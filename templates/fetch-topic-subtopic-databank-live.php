<?php /** Template Name: fetch topic suptopic databank live */ ?>
<?php
if (isset ($_POST['id_course'])  && $_POST['action'] == 'get_course_subtopics') {
    $id_course = $_POST['id_course'];
    $course = get_post(intval($id_course));
    $categories = array();
    $course_subtopics = [];
    $course_subtopics = get_field('categories',$id_course);
    $id_subtopics = $course_subtopics ? array_column($course_subtopics, 'value'):[];
    if(!$course_subtopics)
        $course_subtopics = get_field('category_xml', $id_course);

    foreach($course_subtopics as $choosen){
        if(empty($course_subtopicss))
            $course_subtopics = explode(',', $choosen['value']);
        else
            $course_subtopics = array_merge($course_subtopics, explode(',', $choosen['value']));
    }

    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => ['Uncategorized','Wordpress'],
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    foreach($cats as $category){
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($categories, $category);
    }
    ?>
    <div class="modal-header">
        <h5 class="modal-title titleSubTopic" >Sub-topics</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('myModal').style.display='none'" >
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        <!--------------------------->
        <div class="container my-5">
            <div class="categories-wrapper">
                <?php foreach ($cats as $category):
                    if ($category->name=='Uncategorized')
                        continue;
                    // Préparation des variables
                    $category_name = htmlspecialchars($category->name);
                    //$category_slug = strtolower(str_replace(' ', '_', htmlspecialchars($category->slug)));

                    // Récupération des sous-catégories
                    $subcategories = get_categories(array(
                        'taxonomy'   => 'course_category',
                        'parent'     => $category->term_id,
                        'hide_empty' => 0,
                    ));
                    ?>
                    <!-- Bloc catégorie principale -->
                    <div class="category-block">
                        <h2 class="category-title" data-toggle="subcategories-<?php echo $category->slug; ?>">
                            <?php echo $category_name; ?>
                        </h2>
                        <!-- Sous-catégories masquées par défaut -->
                        <?php if (!empty($subcategories)): ?>
                            <div class="subcategories hidden" id="<?php echo $category->slug; ?>">
                                <?php foreach ($subcategories as $sub): ?>
                                    <div class="subcategory">
                                        <p><?php echo htmlspecialchars($sub->name); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="no-subcategories">no subtopics availaible.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!--------------------------->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('myModal').style.display='none'">Close</button>
            <button type="button" class="btn btn-primary" id="save_subtopic_course" >Save subtopics</button>
        </div>
    </div>
<?php }?>
