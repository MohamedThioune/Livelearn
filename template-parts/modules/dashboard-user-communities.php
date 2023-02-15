<?php
$user_id = get_current_user_id();
$users = get_users();
$args = array(
    'post_type' => 'community',
    'post_status' => 'publish',
    'posts_per_page' => -1);

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
                      <input type="search" class="form-control search" placeholder="search">
                  </div>
                <div class="tabs__list">

                    <div class="tab active">
                        <div class="group-card-communities d-flex flex-wrap">
                        <?php
                        foreach($communities as $community){
                            $company = get_field('company_author', $community->ID)[0];
                            $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
                            $community_image = get_field('image_community', $community->ID) ?: $company_image;

                            $level = get_field('range', $community->ID);

                            //Followers
                            $max_follower = 0;
                            $followers = get_field('follower_community', $community->ID);
                            if(!empty($followers))
                                $max_follower = count($followers);
                            foreach ($followers as $key => $value)
                            if($value->ID == $user_id){
                                $bool = true;
                                break;
                            }

                            //Courses
                            $max_course = 0;
                            if(!empty($courses))
                                $max_course = count($courses);
                        ?>
                            <div class="card-communities">
                                <div class="head-card-communities">
                                    <img class="" src="<?= $company_image; ?>" alt="">
                                </div>
                                <div class="body-card-community">
                                    <div class="block-img-title d-flex align-items-center">
                                        <div class="imgCommunity">
                                            <img class="" src="<?= $community_image; ?>" alt="">
                                        </div>
                                        <div>
                                            <p class="name-community"><?= $company->post_title; ?></p>
                                            <p class="statut-community">Private Groups</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center group-detail">
                                        <div>
                                            <p class="number-element"><?= $max_course ; ?></p>
                                            <p class="description">Course</p>
                                        </div>
                                        <div class="block-detail">
                                            <p class="number-element"><?= $max_follower; ?></p>
                                            <p class="description">Members</p>
                                        </div>
                                        <div>
                                            <p class="number-element">0000</p>
                                            <p class="description">Since</p>
                                        </div>
                                    </div>
                                    <?php
                                    if(!$bool)
                                        echo "<form action='/dashboard/user/' method='POST'>
                                                    <input type='hidden' name='community_id' value='" . $community->ID . "' >
                                                    <input type='submit' class='btn btn-join-group' name='follow_community' value='Volg' >
                                              </form>";
                                    else
                                        echo " <button type='button' class='btn btn-join-group' disabled>Join Group</button>";
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
                            <div class="card-communities">
                                <div class="head-card-communities">
                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/groups-bg-11.png" alt="">
                                </div>
                                <div class="body-card-community">
                                    <div class="block-img-title d-flex align-items-center">
                                        <div class="imgCommunity">
                                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/groups-2.png" alt="">
                                        </div>
                                        <div>
                                            <p class="name-community">Graphic Design</p>
                                            <p class="statut-community">Public Groups</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center group-detail">
                                        <div>
                                            <p class="number-element">245</p>
                                            <p class="description">Post</p>
                                        </div>
                                        <div class="block-detail">
                                            <p class="number-element">4245</p>
                                            <p class="description">Members</p>
                                        </div>
                                        <div>
                                            <p class="number-element">2010</p>
                                            <p class="description">Since</p>
                                        </div>
                                    </div>
                                    <a href="" class="btn btn-join-group">Join Group</a>
                                </div>
                            </div>
                            <div class="card-communities">
                                <div class="head-card-communities">
                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/groups-bg-2.png" alt="">
                                </div>
                                <div class="body-card-community">
                                    <div class="block-img-title d-flex align-items-center">
                                        <div class="imgCommunity">
                                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/groups-2.png" alt="">
                                        </div>
                                        <div>
                                            <p class="name-community">Marketing</p>
                                            <p class="statut-community">Public Groups</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center group-detail">
                                        <div>
                                            <p class="number-element">245</p>
                                            <p class="description">Post</p>
                                        </div>
                                        <div class="block-detail">
                                            <p class="number-element">4245</p>
                                            <p class="description">Members</p>
                                        </div>
                                        <div>
                                            <p class="number-element">2010</p>
                                            <p class="description">Since</p>
                                        </div>
                                    </div>
                                    <a href="" class="btn btn-join-group">Join Group</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="group-card-communities d-flex flex-wrap">
                            <div class="card-communities">
                                <div class="head-card-communities">
                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/groups-bg-2.png" alt="">
                                </div>
                                <div class="body-card-community">
                                    <div class="block-img-title d-flex align-items-center">
                                        <div class="imgCommunity">
                                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/groups-2.png" alt="">
                                        </div>
                                        <div>
                                            <p class="name-community">Marketing</p>
                                            <p class="statut-community">Public Groups</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center group-detail">
                                        <div>
                                            <p class="number-element">245</p>
                                            <p class="description">Post</p>
                                        </div>
                                        <div class="block-detail">
                                            <p class="number-element">4245</p>
                                            <p class="description">Members</p>
                                        </div>
                                        <div>
                                            <p class="number-element">2010</p>
                                            <p class="description">Since</p>
                                        </div>
                                    </div>
                                    <a href="" class="btn btn-join-group">Join Group</a>
                                </div>
                            </div>
                            <div class="card-communities">
                                <div class="head-card-communities">
                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/groups-bg-3.png" alt="">
                                </div>
                                <div class="body-card-community">
                                    <div class="block-img-title d-flex align-items-center">
                                        <div class="imgCommunity">
                                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/groups-2.png" alt="">
                                        </div>
                                        <div>
                                            <p class="name-community">Developer</p>
                                            <p class="statut-community">Public Groups</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center group-detail">
                                        <div>
                                            <p class="number-element">245</p>
                                            <p class="description">Post</p>
                                        </div>
                                        <div class="block-detail">
                                            <p class="number-element">4245</p>
                                            <p class="description">Members</p>
                                        </div>
                                        <div>
                                            <p class="number-element">2010</p>
                                            <p class="description">Since</p>
                                        </div>
                                    </div>
                                    <a href="" class="btn btn-join-group">Join Group</a>
                                </div>
                            </div>
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



