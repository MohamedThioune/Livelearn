<?php /** Template Name: Fetch user communities */ ?>

<?php

extract($_POST);

$user_id = get_current_user_id();
$users = get_users();
$args = array(
    'post_type' => 'community',
    'post_status' => 'publish',
    'posts_per_page' => -1);

$communities = get_posts($args);

// $your_communities = array();
// $other_communities = array();

if(isset($search_all)){
    foreach($communities as $community){
        $filter = $community->post_title;
        $company = get_field('company_author', $community->ID);
        $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
        $community_image = get_field('image_community', $community->ID) ?: $company_image;

        $level = get_field('range', $community->ID);

        //Since year
        $date = $community->post_date;
        $days = explode(' ', $date)[0];
        $year = explode('-', $days)[0];

        //Courses comin through custom field 
        $courses = get_field('course_community', $community->ID); 
        $max_course = 0;
        if(!empty($courses))
            $max_course = count($courses);

        //Followers
        $max_follower = 0;
        $followers = get_field('follower_community', $community->ID);
        if(!empty($followers))
            $max_follower = count($followers);
        $bool = false;
        foreach ($followers as $key => $value)
            if($value->ID == $user_id){
                $bool = true;
                break;
            }
        
        $access_community = "";
        if($bool){
            // array_push($your_communities, $community);
            $access_community = '<a href="/dashboard/user/community-detail/?mu=' . $community->ID . '" class="name-community">' . $community->post_title . '</a>';
            $subscribe ="<form action='' method='POST'>
                                <input type='hidden' name='community_id' value='" . $community->ID . "' >
                                <input type='submit' class='btn btn-join-group' name='follow_community' value='Join Group' >
                        </form>";
        }
        else{
            // array_push($other_communities, $community);
            $access_community = '<a href="#" class="name-community" data-toggle="tooltip" data-placement="top" title="Je moet eerst tot deze gemeenschap behoren">' . $community->post_title . '</a>';
            $subscribe = "<a href='/dashboard/user/community-detail/?mu=".$community->ID."' class='btn btn-join-group'>Go !</a>";
        }         

        if( stristr($filter, $search_all) || $search_all == '')
            $row_user_communities .= '
            <div class="card-communities">
            <div class="head-card-communities">
                <img class="" src="' . get_stylesheet_directory_uri() . '/img/groups-bg-11.png" alt="">
            </div>
            <div class="body-card-community">
                <div class="block-img-title d-flex align-items-center">
                    <div class="imgCommunity">
                        <img class="" src="' . $community_image . '  " alt="">
                    </div>
                    <div class="text-left" style="padding-top: 15px;">
                        ' . $access_community . '
                        <p class="statut-community">Private Groups</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center group-detail">
                    <div>
                        <p class="number-element">' . $max_course . '</p>
                        <p class="description">Post</p>
                    </div>
                    <div class="block-detail">
                        <p class="number-element">' . $max_follower . '</p>
                        <p class="description">Members</p>
                    </div>
                    <div>
                        <p class="number-element">' . $year . '</p>
                        <p class="description">Since</p>
                    </div>
                </div>
                ' . $subscribe . '
            </div>
        </div>';
    }

    echo $row_user_communities;
}

