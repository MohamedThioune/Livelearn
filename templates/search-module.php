<?php

function searching_course($search, $search_type, $global_posts){
    $infos = array();
    $courses = array();
    $experts = array();
    $order_type = array('Opleidingen' => 0, 'Workshop' => 0, 'Masterclass' => 0, 'E-learning' => 0, 'Event' => 0, 'Training' => 0, 'Video' => 0, 'Artikel' => 0, 'Podcast' => 0, 'Webinar' => 0, 'Lezing' => 0, 'Cursus' => 0);

    foreach($global_posts as $post)
        if(stristr($post->post_title, $search)):
            $course_type = get_field('course_type', $post->ID);
            $bool = 0;
            if($search_type == 'Alles'):
                array_push($courses, $post);
                $order_type[$course_type]++;
                $bool = 1;
            else:
                if($course_type == $search_type):
                    array_push($courses, $post);
                    $order_type[$course_type]++;
                    $bool = 1;
                endif;

            if($bool):
                //Adding expert
                $expert = get_field('experts', $post->ID);
                if(isset($expert[0]))
                    $expertis = array_merge($expert, array($post->post_author));
                else
                    $expertis = array($post->post_author);
                if(!empty($expertis))
                    foreach($expertis as $experto)
                        if(!in_array($experto, $experts))
                            array_push($experts, $experto);
            endif;

            endif;
        endif;

    //Fill up the information
    $infos['courses'] = $courses;
    $infos['order_type'] = $order_type;
    $infos['experts'] = $experts;

    return $infos;
}

function searching_course_by_type($global_posts, $filter){
    $infos = array();
    $courses = array();
    $experts = array();
    $order_type = array('Opleidingen' => 0, 'Workshop' => 0, 'Masterclass' => 0, 'E-learning' => 0, 'Event' => 0, 'Training' => 0, 'Video' => 0, 'Artikel' => 0, 'Podcast' => 0, 'Webinar' => 0, 'Lezing' => 0, 'Cursus' => 0);

    if($filter):

        foreach($global_posts as $post):
            $course_type = get_field('course_type', $post->ID);

            if($course_type == $filter):
                array_push($courses, $post);
                $order_type[$course_type]++;

                //Adding expert
                $expert = get_field('experts', $post->ID);
                if(isset($expert[0]))
                    $expertis = array_merge($expert, array($post->post_author));
                else
                    $expertis = array($post->post_author);
                if(!empty($expertis))
                    foreach($expertis as $experto)
                        if(!in_array($experto, $experts))
                            array_push($experts, $experto);
            endif;
        endforeach;

    endif;

    //Fill up the information
    $infos['courses'] = $courses;
    $infos['order_type'] = $order_type;
    $infos['experts'] = $experts;

    return $infos;
}

function searching_course_by_group($global_posts, $group, $value){
    $infos = array();
    $courses = array();
    $courses_in = array();
    $experts = array();
    $order_type = array('Opleidingen' => 0, 'Workshop' => 0, 'Masterclass' => 0, 'E-learning' => 0, 'Event' => 0, 'Training' => 0, 'Video' => 0, 'Artikel' => 0, 'Podcast' => 0, 'Webinar' => 0, 'Lezing' => 0, 'Cursus' => 0);

    foreach($global_posts as $post):
        $course_type = get_field('course_type', $post->ID);

        switch ($group) {
            case 'category':
                /* * Post of this category * */
                $category_default = get_field('categories', $post->ID);
                $category_xml = get_field('category_xml', $post->ID);
                $categories = array();
                $expertis = array();

                //Merge the categories
                if(!empty($category_default))
                    foreach($category_default as $item)
                        if($item)
                            if(!in_array($item['value'], $categories))
                                array_push($categories,$item['value']);
                else if(!empty($category_xml))
                    foreach($category_xml as $item)
                        if($item)
                            if(!in_array($item['value'], $categories))
                                array_push($categories,$item['value']);

                //Add post categories 
                if(!empty($categories))
                    if(in_array($value, $categories) && !in_array($post->ID, $courses_in)):
                        array_push($courses, $post);
                        array_push($courses_in, $post->ID);
                        $order_type[$course_type]++;

                        //Adding expert
                        $expert = get_field('experts', $post->ID);
                        if(isset($expert[0]))
                            $expertis = array_merge($expert, array($post->post_author));
                        else
                            $expertis = array($post->post_author);
                        if(!empty($expertis))
                            foreach($expertis as $experto)
                                if(!in_array($experto, $experts))
                                    array_push($experts, $experto);
                    endif;
                /* * End Categories * */
                break;
            
            case 'expert':
                $bool = 0;
                /* * Post of this expert * */
                $expert = get_field('experts', $post->ID);
                if(isset($expert[0]))
                    $expertis = array_merge($expert, array($post->post_author));
                else
                    $expertis = array($post->post_author);

                if(!empty($expertis))
                    if(in_array($value, $expertis) && !in_array($post->ID, $courses_in)):
                        array_push($courses, $post);
                        array_push($courses_in, $post->ID);
                        $order_type[$course_type]++;
                        if(!empty($expertis))
                            foreach($expertis as $experto)
                                if(!in_array($experto, $experts))
                                    array_push($experts, $experto);
                    endif;
                /* * End Experts * */
                break;
            case 'company':
                /* * Post of this company * */
                $args = array(
                    'post_type' => 'company',
                    'posts_per_page' => 1,
                    'include' => $value
                );
                $company = get_posts($args)[0];

                $users = get_users();
                $users_company = array();
                foreach($users as $user) {
                    $company_user = get_field('company',  'user_' . $user->ID);
                    if(!empty($company_user) && !empty($company))
                        if($company_user[0]->ID == $company->ID)
                            array_push($users_company, $user->ID);
                }

                $args = array(
                    'post_type' => array('post','course'),
                    'posts_per_page' => -1,
                    'orderby' => 'date',
                    'order'   => 'DESC',
                    'author__in' => $users_company,
                );
                $courses = get_posts($args);

                /* * End Companies * */
                break;
        }


    endforeach;

    //Fill up the information
    $infos['courses'] = $courses;
    $infos['order_type'] = $order_type;
    $infos['experts'] = $experts;

    return $infos;
}



?>