<?php /** Template Name: dashboard manager leer databank */ ?>

<div class="contentOne">
    <?php require 'headerDashboard.php';?>
</div>

<div class="contentPageManager">
    <div class="blockSidbarMobile blockSidbarMobile2">
        <div class="zijbalk">
            <p class="zijbalkMenu">zijbalk menu</p>
            <button class="btn btnSidbarMob">
                <img src="img/filter.png" alt="">
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <?php require 'layaoutManager.php';?>
        </div>
        <div class="col-md-9 col-lg-9">
            <div class="contentListeCourse">
                <div class="cardOverviewCours">
                    <div class="headListeCourse">
                        <p class="JouwOpleid">Alle opleidingen</p>
                        <input type="search" class="searchInputAlle" placeholder="Zoek opleidingen, experts of ondervwerpen">
                        <a href="" class="btnNewCourse">Nieuwe course</a>
                    </div>
                    <div class="contentCardListeCourse">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th scope="col">Titel</th>
                                <th scope="col">Leervorm</th>
                                <th scope="col">Prijs</th>
                                <th scope="col">Onderwerp(en)</th>
                                <th scope="col">Startdatum</th>
                                <th scope="col">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="textTh">Werkkamersessie 'acquireren is werven'</td>
                                <td class="textTh">Training</td>
                                <td class="textTh">€1750</td>
                                <td class="textTh elementOnder">Verkoop en sales</td>
                                <td class="textTh">12-09-2021</td>
                                <td class="textTh">Live</td>
                            </tr>
                            <tr>
                                <td class="textTh">Werkkamersessie 'acquireren is werven'</td>
                                <td class="textTh">Training</td>
                                <td class="textTh">€1750</td>
                                <td class="textTh elementOnder">Verkoop en sales</td>
                                <td class="textTh">12-09-2021</td>
                                <td class="textTh">Live</td>
                            </tr>
                            <tr>
                                <td class="textTh">Werkkamersessie 'acquireren is werven'</td>
                                <td class="textTh">Training</td>
                                <td class="textTh">€1750</td>
                                <td class="textTh elementOnder">Verkoop en sales</td>
                                <td class="textTh">12-09-2021</td>
                                <td class="textTh">Concept</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
<?php wp_footer(); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="js/style.js"></script>

</body>
</html>




