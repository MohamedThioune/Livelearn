<?php /** Template Name: epmployee overview */ ?>
<?php wp_head(); ?>
<?php get_header(); ?>
<div class="contentOne">
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
        <div class="col-md-3">
            <section id="sectionDashboard1" class="sidBarDashboard sidBarDashboardIndividual" name="section1">
                <button class="btn btnSidbarMobCroix">
                    <img src="img/cancel.png" alt="">
                </button>
                <ul class="">
                    <li class="elementTextDashboard">
                        <a href="" class="d-flex">
                            <div class="elementImgSidebar" >
                                <img src="img/dashb.png" >
                            </div>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="" class="d-flex">
                            <div class="elementImgSidebar" >
                                <img src="img/Opleiding_toevoegen.png" >
                            </div>
                            <span> Opleiding toevoegen</span>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="" class="d-flex">
                            <div class="elementImgSidebar" >
                                <img src="img/Overzicht_opleidingen.png" >
                            </div>
                            <span> Overzicht opleidingen</span>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="" class="d-flex">
                            <div class="elementImgSidebar" >
                                <img src="img/Inschrijvingen.png" >
                            </div>
                            <span> Inschrijvingen</span>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="" class="d-flex">
                            <div class="elementImgSidebar" >
                                <img src="img/Berichten.png" >
                            </div>
                            <span> Berichten</span>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="" class="d-flex">
                            <div class="elementImgSidebar" >
                                <img src="img/Financien.png" >
                            </div>
                            <span> Financien</span>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="" class="d-flex">
                            <div class="elementImgSidebar" >
                                <img src="img/Statistieken.png" >
                            </div>
                            <span> Statistieken</span>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="" class="d-flex">
                            <div class="elementImgSidebar" >
                                <img src="img/Instellingen.png" >
                            </div>
                            <span> Instellingen</span>
                        </a>
                    </li>
                </ul>
            </section>
        </div>
        <div class="col-md-9">
            <div class="contentListeCourse">
                <div class="cardPeople">
                    <div class="headListeCourse">
                        <p class="JouwOpleid">Werknemers (5)</p>
                        <form action="" method="POST" class="form-inline ml-auto mb-0">
                            <input class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek medewerker" aria-label="Search" id="search_text">
                        </form>
                        <a href="" class="btnActiviteit">Activiteit</a>
                        <a href="" class="btnNewCourse">Persoon toevoegen</a>
                    </div>
                    <div class="contentCardListeCourse">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Naam</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telefoonnummer</th>
                                <th scope="col" class="thOnder">Functie</th>
                                <th scope="col">Afdeling</th>
                                <th scope="col">Manager</th>
                                <th scope="col">Actie</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="textTh thModife">
                                    <div class="ImgUser">
                                        <img src="img/user.png" alt="">
                                    </div>
                                </td>
                                <td class="textTh">Daneiel</td>
                                <td class="textTh">Alakhame@Alakhamecom</td>
                                <td class="textTh">77777777</td>
                                <td class="textTh elementOnder">développement</td>
                                <td class="textTh">Ouakame</td>
                                <td class="textTh">Kellell</td>
                                <td class="titleTextListe">
                                    <a href="" class="btnNewCourse">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="textTh thModife">
                                    <div class="ImgUser">
                                        <img src="img/addUser.jpeg" alt="">
                                    </div>
                                </td>
                                <td class="textTh">Daneiel</td>
                                <td class="textTh">Alakhame@Alakhamecom</td>
                                <td class="textTh">77777777</td>
                                <td class="textTh elementOnder">développement</td>
                                <td class="textTh">Ouakame</td>
                                <td class="textTh">Kellell</td>
                                <td class="titleTextListe">
                                    <a href="" class="btnNewCourse">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="textTh thModife">
                                    <div class="ImgUser">
                                        <img src="img/user.png" alt="">
                                    </div>
                                </td>
                                <td class="textTh">Daneiel</td>
                                <td class="textTh">Alakhame@Alakhamecom</td>
                                <td class="textTh">77777777</td>
                                <td class="textTh elementOnder">développement</td>
                                <td class="textTh">Ouakame</td>
                                <td class="textTh">Kellell</td>
                                <td class="titleTextListe">
                                    <a href="" class="btnNewCourse">Delete</a>
                                </td>
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



