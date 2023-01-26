 <?php /** Template Name: Optie All*/?>
<?php
    global $wpdb;

    $table = $wpdb->prefix . 'databank';

    extract($_POST);


    foreach($id as $key=>$obj){
        $sql=$wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE id = %d",$obj);
        $artikel = $wpdb->get_results($sql)[0];

        $where = ['id' => $obj];
        if($optie == "acceptAll"){
            if($class[$key]=='missing'){
                $type = 'Artikel';

                 //Insert Artikel
                if ($artikel->type == "Artikel"){
                    $args = array(
                        'post_type'   => 'post',
                        'post_author' => $artikel->author_id,
                        'post_status' => 'publish',
                        'post_title'  => $artikel->titel
                    );
                    
                    $id_post = wp_insert_post($args);

                    //Custom
                    update_field('course_type', 'Article', $id_post);
                    update_field('article_itself', nl2br($artikel->long_description), $id_post);
                }
                $onderwerpen = explode(',', $artikel->onderwerpen);

                //Experts
                $contributors = explode(',', $artikel->contributors);

                update_field('experts', $contributors, $id_post);
                update_field('short_description', nl2br($artikel->short_description), $id_post);
                update_field('long_description', nl2br($artikel->long_description), $id_post);
                update_field('url_image_xml', $artikel->image_xml, $id_post);
                update_field('categories', $onderwerpen, $id_post);

                if( $artikel->company_id != 0 && $artikel->author_id != 0 ){
                    $company = get_post($artikel->company_id);
                    update_field('company', $company, 'user_' . $artikel->author_id);
                }

                $data = [ 'course_id' => $id_post]; // NULL value.
                $wpdb->update( $table, $data, $where );
            }
        }else if($optie=="declineAll"){
            if ($class[$key] == 'missing')
                null;
            else if ($class[$key] == 'present' ){}
                // var_dump($artikel->course_id);
                wp_trash_post($artikel->course_id);
        }
        $data = [ 'state' => 1, 'optie' =>  $optie ]; // NULL value.

        $updated = $wpdb->update( $table, $data, $where );
        echo $wpdb->last_error;

        if($updated === false)
            return false; 
        else 
            return true;
    }
?>