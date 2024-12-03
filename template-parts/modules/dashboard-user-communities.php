<?php
$user_id = get_current_user_id();
$users = get_users();
$args = array(
    'post_type' => 'community',
    'post_status' => 'publish',
    'posts_per_page' => -1
);

$communities = get_posts($args);

$your_communities = array();
$other_communities = array();
?>

<div class="content-communities">
    <div class="head-community">
        <h1>Communities</h1>
    </div>

    <div class="tabs-search-block">
        <div class="tabs-courses">
            <div class="tabs">
                <div class="head">
                    <ul class="filters">
                        <li class="item active">All</li>
                        <li class="item">Your Groups</li>
                        <li class="item">Others Groups</li>
                    </ul>
                    <input type="search" class="form-control search" id="search" placeholder="search">
                </div>
                <div class="tabs__list">
                    <!-- 
                    <div class="search-bar-block">
                        <div class="input-group">
                           <input type="text" class="form-control" id="search" placeholder="Search">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div> 
                        </div>
                    </div>
                    -->
                    <?php if(isset($_GET['message'])) echo "<span class='alert alert-info'>" . $_GET['message'] . "</span><br><br>"; ?>
                    <div class="tab active">
                        <div class="group-card-communities d-flex flex-wrap" id="autocomplete">
                        <?php
                        foreach($communities as $community){
                            $company = get_field('company_author', $community->ID);
                            $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
                            $community_image = get_field('image_community', $community->ID) ?: $company_image;

                            $level = get_field('range', $community->ID);
                            $private  = get_field('password_community', $community->ID);

                            $type_groups = "";
                            $button_join = "<input type='submit' class='btn btn-join-group' name='follow_community' value='Join Group'>";

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
                                array_push($your_communities, $community);
                                $access_community = '<a href="/dashboard/user/community-detail/?mu=' . $community->ID . '" class="name-community">' . $community->post_title . '</a>';
                            }
                            else{
                                array_push($other_communities, $community);
                                $access_community = '<a href="#" class="name-community" data-toggle="tooltip" data-placement="top" title="Je moet eerst tot deze gemeenschap behoren">' . $community->post_title . '</a>';
                            } 

                            //Private community
                            $private_field = ($private) ? "<input type='text' class='form-control search' name='password' placeholder='Please fill community password !' required>" : ''; 
                            $type_groups = ($private_field == '') ? 'Public Groups' : 'Private Groups';

                            //Intern community
                            $company_user = get_field('company',  'user_' . $user_id);
                            $company_title_user = (!empty($company_user)) ? $company_user[0]->post_title : '';
                            $visibility_community = get_field('visibility_community', $community->ID); 
                            if($visibility_community){
                                $type_groups = ($type_groups == 'Private Groups') ? 'Private|Intern Groups' : 'Intern Groups';
                                if($company->post_title != $company_title_user)
                                    $button_join = "<button type='button' class='btn btn-join-group' name='follow_community' data-toggle='tooltip' data-placement='top' title='Intern community, only for member of the " . $company->post_title . " company' disabled>Join group</button>";
                            }
                        ?>
                            <div class="card-communities">
                                <div class="head-card-communities">
                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/groups-bg-11.png" alt="">
                                </div>
                                <div class="body-card-community">
                                    <div class="block-img-title d-flex align-items-center">
                                        <div class="imgCommunity">
                                            <img class="" src="<?= $community_image; ?>" alt="">
                                        </div>
                                        <div class="text-left" style="padding-top: 15px;">
                                            <?= $access_community ?>
                                            <p class="statut-community"><?= $type_groups ?></p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center group-detail">
                                        <div>
                                            <p class="number-element"><?= $max_course ; ?></p>
                                            <p class="description">Post</p>
                                        </div>
                                        <div class="block-detail">
                                            <p class="number-element"><?= $max_follower; ?></p>
                                            <p class="description">Members</p>
                                        </div>
                                        <div>
                                            <p class="number-element"><?= $year; ?> </p>
                                            <p class="description">Since</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center flex-wrap align-items-center">
                                        <?php
                                        if(!$bool)
                                            echo "<form action='' method='POST'>
                                                    <input type='hidden' name='community_id' value='" . $community->ID . "' >
                                                    " . $private_field . " " 
                                                      . $button_join . "
                                                  </form>";
                                        else{
                                            echo " <a href='/dashboard/user/community-detail/?mu=".$community->ID."' class='btn btn-join-group'>Go !</a>";
                                            echo '<form action="" class="mb-0" method="POST">
                                                    <input type="hidden" name="community_id" value="' . $community->ID . '" >
                                                    <button type="submit" name="unfollow_community" class="btn btn-danger">Unsubscribe</button>
                                                  </form>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="group-card-communities d-flex flex-wrap">
                        <?php

                        foreach($your_communities as $community){
                            $company = get_field('company_author', $community->ID);
                            $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
                            $community_image = get_field('image_community', $community->ID) ?: $company_image;

                            $level = get_field('range', $community->ID);
                            $private  = get_field('password_community', $community->ID);

                            $type_groups = "";
                            $button_join = "<input type='submit' class='btn btn-join-group' name='follow_community' value='Join Group'>";

                            //Since year
                            $date = "";
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

                            //Access community
                            $access_community = '<a href="/dashboard/user/community-detail/?mu=' . $community->ID . '" class="name-community">' . $community->post_title . '</a>';

                            //Private community
                            $private_field = ($private) ? "<input type='text' class='form-control search' name='password' placeholder='Please fill community password !' required>" : ''; 
                            $type_groups = ($private_field == '') ? 'Public Groups' : 'Private Groups';

                            //Intern community
                            $company_user = get_field('company',  'user_' . $user_id);
                            $company_title_user = (!empty($company_user)) ? $company_user[0]->post_title : '';
                            $visibility_community = get_field('visibility_community', $community->ID); 
                            if($visibility_community)
                                $type_groups = ($type_groups == 'Private Groups') ? 'Private|Intern Groups' : 'Intern Groups';
                            
                        ?>
                            <div class="card-communities">
                                <div class="head-card-communities">
                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/groups-bg-11.png" alt="">
                                </div>
                                <div class="body-card-community">
                                    <div class="block-img-title d-flex align-items-center">
                                        <div class="imgCommunity">
                                            <img class="" src="<?= $community_image; ?>" alt="">
                                        </div>
                                        <div>
                                            <?= $access_community ?>
                                            <p class="statut-community"><?= $type_groups ?></p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center group-detail">
                                        <div>
                                            <p class="number-element"><?= $max_course ; ?></p>
                                            <p class="description">Post</p>
                                        </div>
                                        <div class="block-detail">
                                            <p class="number-element"><?= $max_follower; ?></p>
                                            <p class="description">Members</p>
                                        </div>
                                        <div>
                                            <p class="number-element"><?= $year ?></p>
                                            <p class="description">Since</p>
                                        </div>
                                    </div>
                                    <?php
                                    echo " <a href='/dashboard/user/community-detail/?mu=".$community->ID."' class='btn btn-join-group'>Go !</a>";
                                    echo '<form action=""  method="POST">
                                            <input type="hidden" name="community_id" value="' . $community->ID . '" >
                                            <button type="submit" name="unfollow_community" class="btn btn-danger">Unsubscribe</button>
                                            </form>';
                                    ?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="group-card-communities d-flex flex-wrap">
                        <?php

                        foreach($other_communities as $community){
                            $company = get_field('company_author', $community->ID);
                            $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
                            $community_image = get_field('image_community', $community->ID) ?: $company_image;

                            $level = get_field('range', $community->ID);
                            $private = get_field('password_community', $community->ID);

                            $type_groups = "";
                            $button_join = "<input type='submit' class='btn btn-join-group' name='follow_community' value='Join Group'>";

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
                            
                            //Access community
                            $access_community = '<a href="#" class="name-community" data-toggle="tooltip" data-placement="top" title="Je moet eerst tot deze gemeenschap behoren">' . $community->post_title . '</a>';

                            //Private community
                            $private_field = ($private) ? "<input type='text' class='form-control search' name='password' placeholder='Please fill community password !' required>" : ''; 
                            $type_groups = ($private_field == '') ? 'Public Groups' : 'Private Groups';

                            //Intern community
                            $company_user = get_field('company',  'user_' . $user_id);
                            $company_title_user = (!empty($company_user)) ? $company_user[0]->post_title : '';
                            $visibility_community = get_field('visibility_community', $community->ID); 
                            if($visibility_community){
                                $type_groups = ($type_groups == 'Private Groups') ? 'Private|Intern Groups' : 'Intern Groups';
                                if($company->post_title != $company_title_user)
                                    $button_join = "<button type='button' class='btn btn-join-group' name='follow_community' data-toggle='tooltip' data-placement='top' title='Intern community, only for member of the " . $company->post_title . " company' disabled>Join group</button>";
                            }
                        ?>
                            <div class="card-communities">
                                <div class="head-card-communities">
                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/groups-bg-11.png" alt="">
                                </div>
                                <div class="body-card-community">
                                    <div class="block-img-title d-flex align-items-center">
                                        <div class="imgCommunity">
                                            <img class="" src="<?= $community_image; ?>" alt="">
                                        </div>
                                        <div class="text-left" style="padding-top: 15px;">
                                            <?= $access_community ?>
                                            <p class="statut-community"><?= $type_groups ?></p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center group-detail">
                                        <div>
                                            <p class="number-element"><?= $max_course ; ?></p>
                                            <p class="description">Post</p>
                                        </div>
                                        <div class="block-detail">
                                            <p class="number-element"><?= $max_follower; ?></p>
                                            <p class="description">Members</p>
                                        </div>
                                        <div>
                                            <p class="number-element"><?= $year; ?> </p>
                                            <p class="description">Since</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center flex-wrap align-items-center">
                                        <?php
                                        if(!$bool)
                                            echo "<form action='' method='POST'>
                                                    <input type='hidden' name='community_id' value='" . $community->ID . "' >
                                                    " . $private_field . " " 
                                                      . $button_join . "
                                                  </form>";
                                    ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $('#search').keyup(function(){
        var txt = $(this).val();
        $.ajax({

            url:"/fetch-user-communities",
            method:"post",
            data:{
                search_all:txt,
            },
            dataType:"text",
            success: function(data){
                console.log(data);
                $('#autocomplete').html(data);
            }
        });
    });
</script>

<script>
    document.querySelectorAll(".filters .item").forEach(function (tab, index) {
        tab.addEventListener("click", function () {
            const filters = document.querySelectorAll(".filters .item");
            const tabs = document.querySelectorAll(".tabs__list .tab");

            filters.forEach(function (tab) {
                tab.classList.remove("active");
            });
            this.classList.add("active");

            tabs.forEach(function (tabContent) {
                tabContent.classList.remove("active");
            });
            tabs[index].classList.add("active");
        });
    });

</script>

