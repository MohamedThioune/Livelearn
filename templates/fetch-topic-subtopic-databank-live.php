<?php /** Template Name: fetch topic suptopic databank live */ ?>
<?php
if (isset ($_POST['id_course'])  && $_POST['action'] == 'get_course_subtopics') {
    $id_course = $_POST['id_course'];
    $course = get_post(intval($id_course));
    $course_subtopics = [];
    $course_subtopics = get_field('categories',$id_course);
    $id_subtopics = $course_subtopics ? array_column($course_subtopics, 'value'):[];
    if(!$course_subtopics)
        $course_subtopics = get_field('category_xml', $id_course);
    $cats = get_categories( array(
        'taxonomy'   => 'course_category',
        'orderby'    => 'name',
        'exclude' => ['Uncategorized','Wordpress'],
        'parent'     => 0,
        'hide_empty' => 0,
    ));
    $ids = array();
    if ($course_subtopics)
        foreach ($course_subtopics as $course_subtopic) {
            $ids [] = $course_subtopic['value'];
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
                    if (in_array($category->name,['Uncategorized','Wordpress']))
                        continue;
                    // Préparation des variables
                    $category_name = htmlspecialchars($category->name);
                    $subcategories = get_categories(array(
                        'taxonomy'   => 'course_category',
                        'parent'     => $category->term_id,
                        'hide_empty' => 0,
                    ));
                    ?>
                    <!-- Bloc catégorie principale -->
                    <div class="category-block">
                        <h2 class="category-title" data-toggle="subcategories-<?php echo $category->slug; ?>">
                            <?= $category_name; ?>
                        </h2>
                        <?php if (!empty($subcategories)): ?>
                            <div class="subcategories btn-group btn" id="<?= $category->slug ?>">
                                <?php foreach ($subcategories as $sub):
                                    if ($ids)
                                        $selected = in_array($sub->term_id,$ids) ? 'selected' : '';
                                    $sub_sub = get_categories( array(
                                        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                                        'parent' => $sub->cat_ID,
                                        'hide_empty' => 0, // change to 1 to hide categores not having a single post
                                    ));
                                    ?>
                                    <div class="subcategory">
                                        <p class="subcatchossen btn <?= $selected ?>" id="<?= $sub->term_id ?>"><?= $sub->name ?></p>
                                        <?php if (!empty($sub_sub))echo '---------------------------------------------' ?>
                                    </div>
                                <?php if (!empty($sub_sub)){
                                    foreach ($sub_sub as $s):
                                        if ($ids)
                                            $selected_sub = in_array($sub->term_id,$ids) ? 'selected' : '';
                                        ?>
                                        <div class="subcategory">
                                            <h6 class="subcatchossen btn <?= $selected_sub ?>" id="<?= $s->term_id ?>"><?= $s->name ?></h6>
                                        </div>

                                <?php endforeach; ?>
                                <?php }?>
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
            <button type="button" class="btn btn-primary" id="save_subtopic_course" onclick="saveSubTopicsSuptopis(<?=$id_course?>)">Save subtopics</button>
        </div>
        <div class="d-none" id="loader-saving-subtopics">
            <div class="d-flex align-items-center " >
                <strong>Loading...</strong>
                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
            </div>
        </div>
    </div>
    <script>
        function saveSubTopicsSuptopis(id_course){
            const subtopicsselected = document.querySelectorAll('.selected');
            const loader = document.getElementById('loader-saving-subtopics')
            const subtosave = [];
            console.log(loader)
            subtopicsselected.forEach((subtopic)=>{
                subtosave.push(subtopic.id)
            });
            if (subtosave.length == 0){
                alert('choices some subtopics');
                return
            }
            $.ajax({
                url:"/fetch-topic-subtopics-databank-live",
                method:'post',
                data:{
                    id_course:id_course,
                    action:'save_subtopic_course',
                    categories : subtosave
                },
                beforeSend:function () {
                    console.log('saving subtopics...')
                    loader.className = "";
                },
                error:function (error) {
                    console.log(error)
                },
                success: function (data) {
                    console.log(data)
                },
                complete:function () {
                    console.log('completelyt done');
                    alert('suptopics added in the course successfully');
                    loader.className = "d-none";
                    window.location.reload();
                    //loader.classList.add('hidden');
                }
            })
            // console.log(subtosave)
        }
    </script>
<?php } ?>
<?php
if (isset($_POST['id_course']) && isset($_POST['categories']) && $_POST['action'] == 'save_subtopic_course') {
    $id_course = $_POST['id_course'];
    $categories = array_values($_POST['categories']);
    $topics_in_course = get_field('categories',$id_course);
    $topics_xml = get_field('category_xml',$id_course);
    $topics = array();
    foreach ($topics_in_course as $item) {
        $topics[] = $item['value'];
    }
    $topics = array_unique(array_merge($categories,$topics));
    update_field('categories',$topics,$id_course);
}
?>
