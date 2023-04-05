 <?php /** Template Name: Optie All*/?>
<?php
    global $wpdb;
    extract($_POST);

    $table = $wpdb->prefix . 'databank';

    $id=$_POST['checkOne'];
    $optie=$_POST['submit'];

    if(isset($id)){
        foreach($id as $key=>$obj){
            $sql=$wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE id = %d",$obj);
            $artikel = $wpdb->get_results($sql)[0];

            $where = ['id' => $obj];
            if($optie == "✔️"){
                if($class[$key]=='missing'){
                    $type = 'Artikel';

                    //Insert Artikel
                    if ($artikel->type == "Artikel"){
                        //Creation post
                        $args = array(
                            'post_type'   => 'post',
                            'post_author' => $course->author_id,
                            'post_status' => 'publish',
                            'post_title'  => $course->titel
                        );
                        $id_post = wp_insert_post($args, true);

                        //Custom
                        update_field('course_type', 'article', $id_post);
                        update_field('article_itself', nl2br($course->long_description), $id_post);
                    }
                    $onderwerpen = explode(',', $artikel->onderwerpen);

                    //Experts
                    $contributors = explode(',', $artikel->contributors);
                    if(isset($contributors[0]))
                        if($contributors[0] && $contributors[0] != "" && $contributors[0] != " " )
                            update_field('experts', $contributors, $id_post);

                    //Categories
                    if(isset($onderwerpen[0]))
                        if($onderwerpen[0] && $onderwerpen[0] != "" && $onderwerpen[0] != " " )
                            update_field('categories', $onderwerpen, $id_post);

                    update_field('short_description', nl2br($artikel->short_description), $id_post);
                    update_field('long_description', nl2br($artikel->long_description), $id_post);
                    update_field('url_image_xml', $artikel->image_xml, $id_post);

                    if( $artikel->company_id != 0 && $artikel->author_id != 0 ){
                        $company = get_post($artikel->company_id);
                        update_field('company', $company, 'user_' . $artikel->author_id);
                    }

                    $data = [ 'course_id' => $id_post]; // NULL value.
                    $wpdb->update( $table, $data, $where );
                }
            }else if($optie=="❌"){
                if ($class[$key] == 'missing')
                    null;
                else if ($class[$key] == 'present' )
                    // var_dump($artikel->course_id);
                    wp_trash_post($artikel->course_id);
            }
            $data = [ 'state' => 1, 'optie' =>  $optie ]; // NULL value.

            $updated = $wpdb->update( $table, $data, $where );
            echo $wpdb->last_error;

            if($updated === false)
                echo 'error';
            else 
                echo 'succeed';
        }
    }
    header('location: /databank');
?>