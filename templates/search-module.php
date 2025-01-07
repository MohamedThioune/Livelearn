<?php

function control($post, $offline){
    $user_id = get_current_user_id();
    $company_visibility = get_field('company',  'user_' . $user_id);
    $visibility_company = (!empty($company_visibility)) ? $company_visibility[0]->post_title : null;

    if(!$post)
        return false;
    
    $hidden = true;
    $hidden = visibility($post, $visibility_company);
    if(!$hidden)
        return false;

    //Date and Location
    $data = null;
    $count_data = 0;
    $data_locaties = get_field('data_locaties', $post->ID);
    $data_locaties_xml = get_field('data_locaties_xml', $post->ID);
    $location = 'Online';
    if(!empty($data_locaties)):
        $count_data = count($data_locaties) - 1;
        $data = $data_locaties[$count_data]['data'][0]['start_date'];
        $location = $data_locaties[0]['data'][0]['location'];
    elseif(!empty($data_locaties_xml)):
        $count_data = count($data_locaties_xml) - 1;
        if($data_locaties_xml):
            if(isset($data_locaties_xml[intval($count_data)]['value']))
                $element = $data_locaties_xml[intval($count_data)]['value'];
            if(isset($data_locaties_xml[0]['value'])){
                $data_first = explode('-', $datum[0]['value']);
                $location = $data_first[2];
            }
        endif;

        if(!isset($element))
            return false;

        $datas = explode('-', $element);
        $data = $datas[0];
    endif;

    if( empty($data) || !in_array($course_type, $offline) )
        null;
    elseif( !empty($data) )
        if($data){
            $date_now = strtotime(date('Y-m-d'));
            $data = strtotime(str_replace('/', '.', $data));
            if($data < $date_now)
                return false;
        }

    return true;
}

function searching_course($search, $search_type, $global_posts){
    $infos = array();
    $courses = array();
    $experts = array();
    $order_type = array('Opleidingen' => 0, 'Workshop' => 0, 'Masterclass' => 0, 'E-learning' => 0, 'Event' => 0, 'Training' => 0, 'Video' => 0, 'Artikel' => 0, 'Podcast' => 0, 'Webinar' => 0, 'Lezing' => 0, 'Cursus' => 0);
    $offline = ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop', 'Opleidingen', 'Cursus'];

    $user_id = get_current_user_id();
    $company_visibility = get_field('company',  'user_' . $user_id);
    $visibility_company = (!empty($company_visibility)) ? $company_visibility[0]->post_title : null;

    foreach($global_posts as $post):
       /** Control ... **/
       $controllin = null;
       $controllin = control($post, $offline);
       if(!$controllin)
           continue;
       /** End of control **/

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
                $expertis = array();
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
    endforeach;

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
    $offline = ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop', 'Opleidingen', 'Cursus'];

    if($filter):

        foreach($global_posts as $post):
            /** Control ... **/
            $controllin = null;
            $controllin = control($post, $offline);
            if(!$controllin)
                continue;
            /** End of control **/
            $course_type = get_field('course_type', $post->ID);

            if($course_type == $filter):
                array_push($courses, $post);
                $order_type[$course_type]++;

                //Adding expert
                $expert = get_field('experts', $post->ID);
                $expertis = array();
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

    // var_dump($courses);
    // die();

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
    $offline = ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop', 'Opleidingen', 'Cursus'];

    //Specially if it's type 'company'
    if($group == 'company'):
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
    endif;

    foreach($global_posts as $post):
        /** Control ... **/
        $controllin = null;
        $controllin = control($post, $offline);
        if(!$controllin)
            continue;
        /** End of control **/
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
                        $expertis = array();
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
                        //Add expert
                        foreach($expertis as $experto)
                            if(!in_array($experto, $experts))
                                array_push($experts, $experto);
                    endif;
                /* * End Experts * */
                break;
            case 'company':
                /* * Post of this company * */

                if(!empty($users_company)):
                    $args = array(
                        'post_type' => array('post','course'),
                        'posts_per_page' => -1,
                        'orderby' => 'date',
                        'order'   => 'DESC',
                        'author__in' => $users_company,
                    );
                    $courses = get_posts($args);
                endif;

                /* * End Companies * */
                break;   
        }
    endforeach;

    // var_dump($experts);
    // die();

    //Fill up the information
    $infos['courses'] = $courses;
    $infos['order_type'] = $order_type;
    $infos['experts'] = $experts;

    return $infos;
}

function searching_course_with_filter($global_posts, $args){
    $infos = array();
    $courses = array();
    $courses_in = array();
    $leervom_in = array();
    $prijs_in = array();
    $locatie_in = array();
    $expertie_in = array();

    $experts = array();
    $order_type = array('Opleidingen' => 0, 'Workshop' => 0, 'Masterclass' => 0, 'E-learning' => 0, 'Event' => 0, 'Training' => 0, 'Video' => 0, 'Artikel' => 0, 'Podcast' => 0, 'Webinar' => 0, 'Lezing' => 0, 'Cursus' => 0);
    $offline = ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop', 'Opleidingen', 'Cursus'];

    //Convert args values 
    $leervom = $args['leervom'];
    $min = intval($args['min']);
    $max = intval($args['max']);
    $gratis = intval($args['gratis']);
    $locate = intval($args['locate']);
    $online = intval($args['online']);
    $experties = $args['experties'];
    // var_dump($args); die();

    foreach ($global_posts as $course):
        /** Control ... **/
        $controllin = null;
        $controllin = control($course, $offline);
        if(!$controllin)
            continue;
        /** End of control **/
        //Get comparison values
        $price = intval(get_field('price', $course->ID));
        $data = get_field('data_locaties', $course->ID);    
        $course_type = get_field('course_type', $course->ID);

        //Group leervom 
        if($leervom):
            if(in_array($course_type, $leervom))
                $leervom_in[] = $course->ID;
        endif;

        //Group price 
        if($min || $max || $gratis):
            if($gratis)
                if($price == 0)
                    $prijs_in[] = $course->ID;
            
            if($min || $max):
                $tmp = 0;
                if( $min && $max ){
                    //Error on minimum and maximum
                    if($min > $max):
                        $tmp = $min;
                        $min = $max;
                        $max = $tmp;
                    endif;

                    //Here we got interval
                    $min = intval($min);
                    $max = intval($max);
                    if($price >= $min)
                        if($price <= $max)
                            $prijs_in[] = $course->ID;
                }
                else{
                    //Tested by one value
                    if($min){
                        $min = intval($min);
                        if($price >= $min)
                            $prijs_in[] = $course->ID;
                    }
                    elseif($max){
                        $max = intval($max);
                        if($price <= $max)
                            $prijs_in[] = $course->ID;
                    }
                }                
            endif;

        endif;

        //Group location or orientation
        if($locate || $online):
            if($online):
                //Location ?
                if(!$data)
                    $locatie_in[] = $course->ID;
            endif;

            if($locate):
                if($range == null)
                    $range = 1;
                $scope_postal = postal_range($locate, $range);
                array_push($scope_postal, $locate);

                $cities = array();
                $municipalities = array();
                $provinces = array();
                $compare = array();

                if($scope_postal)
                    foreach($scope_postal as $postal):
                        $value = postal_locator($postal);
                        if(!in_array($value[0]->{'city'}, $cities))
                            array_push($cities, $value[0]->{'city'});

                        if(!in_array($value[0]->{'municipality'}, $municipalities))
                            array_push($municipalities, $value[0]->{'municipality'});

                        if(!in_array($value[0]->{'province'}, $provinces))
                            array_push($provinces, $value[0]->{'province'});
                    endforeach;

                if($cities || count($cities) >= 0)
                    $compare = $cities;
                else if(!$cities || count($cities) <= 0)
                    $compare = $municipalities;
                else if(!$municipalities || count($municipalities) <= 0)
                    $compare = $provinces;

                //The location ?
                if($data)
                    if(!empty($data)){
                        $datx = $data[0]['data'];
                        if($datx){
                            $location = $datx[0]['location'];
                            if($location != "")
                                if(in_array($location, $compare))
                                    $locatie_in[] = $course->ID;
                        }
                    }
            endif;
        endif;

        //Group expert
        if($experties):
            $authors = array();
            $expertss = array();
            array_push($authors, $course->post_author);
    
            $expert = get_field('experts', $course->ID);
            if(isset($expert[0]))
                $expertss = array_merge($authors, $expert);
            else
                $expertss = $authors;
            foreach($experties as $expertie)
                if(in_array($expertie, $expertss) ){
                    $expertie_in[] = $course->ID;
                    break;
                }
        endif;

    endforeach;

    //IDs course
    $courses_in = array_merge($leervom_in, $prijs_in, $locatie_in, $expertie_in);
    // var_dump($courses_in);
    // die();
    if(!empty($leervom_in))
        $courses_in = array_intersect($courses_in, $leervom_in);
    if(!empty($prijs_in))
        $courses_in = array_intersect($courses_in, $prijs_in);
    if(!empty($locatie_in))
        $courses_in = array_intersect($courses_in, $locatie_in);
    if(!empty($expertie_in))
        $courses_in = array_intersect($courses_in, $expertie_in);

    //Final IDs course
    $courses_in = array_unique($courses_in);
    
    //Get post
    foreach($courses_in as $id):
        if(is_wp_error(get_post($id)))
            continue;

        $post = get_post($id);
        $course_type = get_field('course_type', $post->ID);
        $order_type[$course_type]++;

        //Add course
        $courses[] = $post;

        //Adding expert
        $expert = get_field('experts', $post->ID);
        $expertis = array();
        if(isset($expert[0]))
            $expertis = array_merge($expert, array($post->post_author));
        else
            $expertis = array($post->post_author);
        if(!empty($expertis))
            foreach($expertis as $experto)
                if(!in_array($experto, $experts))
                    array_push($experts, $experto);

    endforeach;

    //Fill up the information
    $infos['courses'] = $courses;
    $infos['order_type'] = $order_type;
    $infos['experts'] = $experts;

    return $infos;
}

?>