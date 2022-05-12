<?php /** Template Name: dashboard teacher signup */ ?>


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
        <div class="col-md-4 col-lg-3">
            <?php require 'layaoutTeacher.php';?>
        </div>
        <div class="col-md-5 col-lg-7">
            <div class="cardCoursGlocal">
                <div class="w-100">
                    <div class="titleOpleidingstype">
                        <h2>WERKKKAMERSESSIE 'ACQUREREN IS WERVEN'</h2>
                    </div>
                    <div class="blockCardAcqureren">
                        <div class="cardAcqureren">
                            <p class="titleCardAcqureren">Aantal inschrijvingen</p>
                            <p class="numberCardAcqureren">15</p>
                        </div>
                        <div class="cardAcqureren">
                            <p class="titleCardAcqureren">Inkomsten</p>
                            <p class="numberCardAcqureren">€26.250</p>
                        </div>
                        <div class="cardAcqureren">
                            <p class="titleCardAcqureren">Startdatum</p>
                            <p class="numberCardAcqureren">02 Maart</p>
                        </div>
                        <div class="cardAcqureren">
                            <p class="titleCardAcqureren">Locatie</p>
                            <p class="numberCardAcqureren">Amsterdam</p>
                        </div>
                    </div>
                    <div class="tableListeView">
                        <div class="headListeCourse">
                            <p class="JouwOpleid">Inschrijvingen</p>
                            <div class="d-flex">
                                <a href="" class="btnZoek">Zoek personen</a>
                                <a href="" class="btnActiviteit">Actie</a>
                            </div>
                        </div>
                        <div class="contentCardListeCourse">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Naam</th>
                                    <th scope="col">Achternaam</th>
                                    <th scope="col">Bedrijf</th>
                                    <th scope="col" >Functie</th>
                                    <th scope="col">Betaaid</th>
                                    <th scope="col">Betaaid</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="textTh pl-3 thModife">
                                        <input type="checkbox">
                                    </td>
                                    <td class="textTh">Daneiel</td>
                                    <td class="textTh">Van der Kolk</td>
                                    <td class="textTh">Livelearn</td>
                                    <td class="textTh">OPrichter</td>
                                    <td class="textTh">€1750</td>
                                    <td class="textTh">Prive</td>
                                </tr>
                                <tr>
                                    <td class="textTh pl-3 thModife">
                                        <input type="checkbox">
                                    </td>
                                    <td class="textTh">Daneiel</td>
                                    <td class="textTh">Van der Kolk</td>
                                    <td class="textTh">Livelearn</td>
                                    <td class="textTh">OPrichter</td>
                                    <td class="textTh">€1750</td>
                                    <td class="textTh">Prive</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-2">
            <div class="blockRight2">
                <a href="" class="btn btnActiviteit btnBewerken">Bewerken</a>
                <div class="w-100">
                    <div class="textGroup2">
                        <p>Geplande data</p>
                        <p>Aanmeidingen</p>
                    </div>
                    <a href="" class="btn btnDate">02 Maart, Amsterdam <span>15</span></a>
                    <a href="" class="btn btnDate2">25 Maart, online <span>15</span></a>
                    <a href="" class="btn btnSubmit w-100">Toevoegen</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
<?php wp_footer(); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="js/style.js"></script>








