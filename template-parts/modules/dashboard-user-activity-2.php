<?php
?>
<div class="content-activity2">
    <div class="advert-course-Block d-flex">
        <div class="advert-one d-flex">
            <div class="blockTextAdvert">
                <p class="name">Hello <span>Daniel Van Der.....</span> !</p>
                <p class="description">Welcome to our e-learning platform's activity page! Here, you'll find a variety of engaging activities to help you, reinforce your learning .</p>
            </div>
            <div class="blockImgAdvert">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/adv-course.png" alt="">
            </div>
        </div>
        <div class="advert-second d-block bg-bleu-luzien">
            <div class="d-flex">
                <div class="icone-course">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_folder-file.png" alt="">
                </div>
                <div class="d-block">
                    <p class="number-course">Your course</p>
                    <p class="description">1300</p>
                </div>
            </div>
            <p class="description-course">A courses to help you learn and acquire new skills at your own pace, on your own time</p>
        </div>
        </div>
    <div class="block-tab-activity">
        <div class="tabs-courses">
            <div class="tabs">
                <ul class="filters">
                    <li class="item active">All</li>
                    <li class="item">Course</li>
                    <li class="item">Notifications</li>
                    <li class="item">Data and analytics</li>
                    <li class="item">Your certificates</li>
                    <li class="item">Assessments</li>
                    <li class="item">Communities</li>
                    <li class="item">Your skills</li>
                </ul>

                <div class="tabs__list">
                    <div class="tab active">
                        <div class="blockItemCourse">
                            <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                                <p class="title">Courses</p>
                                <a href="" class="d-flex align-items-center">
                                    <p class="seeAllText">See All</p>
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                                </a>
                            </div>
                            <div class="card-course-activity">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col courseTitle">Course Title</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Instructor</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="d-flex align-items-center">
                                            <div class="blockImgCourse">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" class="" alt="">
                                            </div>
                                            <p class="name-element">UX - UI Design certificat</p>
                                        </td>
                                        <td>
                                            <p class="name-element">12h 33m 10s</p>
                                        </td>
                                        <td class="d-flex align-items-center r-1">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" class="" alt="">
                                            </div>
                                            <p class="name-element">Darlene Robertson</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="d-flex align-items-center">
                                            <div class="blockImgCourse">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" class="" alt="">
                                            </div>
                                            <p class="name-element">Motion design </p>
                                        </td>
                                        <td>
                                            <p class="name-element">12h 33m 10s</p>
                                        </td>
                                        <td class="d-flex align-items-center r-1">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" class="" alt="">
                                            </div>
                                            <p class="name-element">Marvin McKinney</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="d-flex align-items-center">
                                            <div class="blockImgCourse">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" class="" alt="">
                                            </div>
                                            <p class="name-element">videeo annimate After Effect</p>
                                        </td>
                                        <td>
                                            <p class="name-element">12h 33m 10s</p>
                                        </td>
                                        <td class="d-flex align-items-center r-1">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" class="" alt="">
                                            </div>
                                            <p class="name-element">Kathryn Murphy</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="d-flex align-items-center">
                                            <div class="blockImgCourse">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" class="" alt="">
                                            </div>
                                            <p class="name-element">Mecanic volvo electric</p>
                                        </td>
                                        <td>
                                            <p class="name-element">12h 33m 10s</p>
                                        </td>
                                        <td class="d-flex align-items-center r-1">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" class="" alt="">
                                            </div>
                                            <p class="name-element">Cameron Williamson</p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab">
z
                    </div>
                    <div class="tab">
e
                    </div>
                    <div class="tab">
q
                    </div>
                    <div class="tab">
s
                    </div>
                    <div class="tab">
w
                    </div>
                    <div class="tab">
x
                    </div>
                    <div class="tab">
c
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


