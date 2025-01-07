<?php
/** Template Name:live Fetch databank 2 */
if (isset($_POST['id_course_to_delete'])) {
    $id_course_to_delete = $_POST['id_course_to_delete'];

    if (isset($id_course_to_delete)){
        $post = get_post($id_course_to_delete);
        if ($post) {
            $tittle = $post->post_title;
            if (wp_trash_post($post->ID)){
                echo "course $tittle deleted successfully !";
            }
        }else{
            echo 'course not available';
        }
        return;
    }
}
