<?php /** Template Name: Topic */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />


<div class="head2">
    <div class="comp1">
        <img src="img/addUser.jpeg" alt="">
    </div>
    <div class="d-flex elementText3">
        <p class="liverTilteHead2">KRAAMVERZORGENDE</p>
    </div>

    <a href="" class="btn toevoegenText">Toevoegen aan mijn Leeromgeving</a>
</div>
<div class="firstBlock">
    <div class="row">
        <div class="col-md-3">
            <div class="sousProductTest Mobelement">
                <div class="LeerBlock">
                    <div class="leerv">
                        <p class="sousProduct1Title">LEERVOOM</p>
                        <button class="btn btnClose" id="hide"><img src="img/X.png" alt=""></button>
                    </div>
                    <div class="checkFilter">
                        <label class="contModifeCheck">Opleiding
                            <input type="checkbox" id="opleiding" name="opleiding" value="opleiding">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="checkFilter">
                        <label class="contModifeCheck">Masterclass
                            <input type="checkbox" id="masterclass" name="masterclass" value="masterclass">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="checkFilter">
                        <label class="contModifeCheck">Workshop
                            <input type="checkbox" id="workshop" name="workshop" value="workshop">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
                <div class="LeerBlock">
                    <p class="sousProduct1Title">PRIJS</p>
                    <div class="prijsSousBlock">
                        <span class="vanafText">Vanaf</span>
                        <button class="btn btnmin">€min</button>
                        <span class="vanafText">tot</span>
                        <button class="btn btnmin">€max</button>
                    </div>
                    <div class="checkFilter">
                        <label class="contModifeCheck">Allen gratis
                            <input type="checkbox" id="Allen" name="Allen" value="Allen">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
                <div class="LeerBlock">
                    <p class="sousProduct1Title">LOCATE</p>
                    <div class="inputSearchFilter">
                        <input type="search" class="searchLocFilter"> <button class="btb btnSubmitFilter"></button>
                    </div>
                    <div class="checkFilter">
                        <label class="contModifeCheck">Alleen online
                            <input type="checkbox" id="Alleen-online" name="Alleen-online" value="Alleen-online">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
                <div class="LeerBlock">
                    <p class="sousProduct1Title">ONDERWERPEN</p>
                    <div class="checkFilter">
                        <label class="contModifeCheck">Sales
                            <input type="checkbox" id="Sales" name="Sales" value="Sales">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="checkFilter">
                        <label class="contModifeCheck">Loopbaanadvies
                            <input type="checkbox" id="Loopbaanadvies" name="Loopbaanadvies" value="Loopbaanadvies">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="checkFilter">
                        <label class="contModifeCheck">Online marketing
                            <input type="checkbox" id="Online-marketing" name="Online-marketing" value="Online-marketing">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="mob filterBlock">
                <p class="fliterElementText">Filter</p>
                <button class="btn btnIcone8" id="show"><img src="img/filter.png" alt=""></button>
            </div>
        </div>
        <div class="col-md-9">

            <div class="sousProductTest2 opleiBlock">
                <div class="sousBlockProduct2">
                    <p class="sousBlockTitleProduct">Opleidingen</p>
                    <div class="blockCardOpleidingen ">

                        <div class="swiper-container swipeContaine4">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide swiper-slide4">
                                    <div class="cardKraam2">
                                        <div class="headCardKraam">
                                            <div class="blockImgCardCour">
                                                <img src="img/libay.png" alt="">
                                            </div>
                                            <div class="blockgroup7">
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="img/kraam.png" class="icon7" alt="">
                                                        <p class="kraaText">Kraamvrzogende</p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="img/mbo3.png" class="icon7" alt="">
                                                        <p class="kraaText">MB03</p>
                                                    </div>
                                                </div>
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="img/calend.png" class="icon7" alt="">
                                                        <p class="kraaText">6 dagdelen</p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="img/euro1.png" class="icon7" alt="">
                                                        <p class="kraaText">295</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contentCardProd">
                                            <div class="group8">
                                                <div class="imgTitleCours">
                                                    <div class="imgCoursProd">
                                                        <img src="img/addUser.jpeg" alt="">
                                                    </div>
                                                    <p class="nameCoursProd">LiveLearn</p>
                                                </div>
                                                <div class="group9">
                                                    <div class="blockOpein">
                                                        <img class="iconAm" src="img/graduat.png" alt="">
                                                        <p class="lieuAm">Opleiding</p>
                                                    </div>
                                                    <div class="blockOpein">
                                                        <img class="iconAm1" src="img/map.png" alt="">
                                                        <p class="lieuAm">Amsterdam</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="werkText">WERKKAMERSESSIE</p>
                                            <p class="descriptionPlatform">
                                                Platform met complete aanbod opleidingen
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide swiper-slide4">
                                    <div class="cardKraam2">
                                        <div class="headCardKraam">
                                            <div class="blockImgCardCour">
                                                <img src="img/libay.png" alt="">
                                            </div>
                                            <div class="blockgroup7">
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="img/kraam.png" class="icon7" alt="">
                                                        <p class="kraaText">Kraamvrzogende</p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="img/mbo3.png" class="icon7" alt="">
                                                        <p class="kraaText">MB03</p>
                                                    </div>
                                                </div>
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="img/calend.png" class="icon7" alt="">
                                                        <p class="kraaText">6 dagdelen</p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="img/euro1.png" class="icon7" alt="">
                                                        <p class="kraaText">295</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contentCardProd">
                                            <div class="group8">
                                                <div class="imgTitleCours">
                                                    <div class="imgCoursProd">
                                                        <!--  <img src="" alt="">-->
                                                    </div>
                                                    <p class="nameCoursProd">LiveLearn</p>
                                                </div>
                                                <div class="group9">
                                                    <div class="blockOpein">
                                                        <img class="iconAm" src="img/graduat.png" alt="">
                                                        <p class="lieuAm">Opleiding</p>
                                                    </div>
                                                    <div class="blockOpein">
                                                        <img class="iconAm1" src="img/map.png" alt="">
                                                        <p class="lieuAm">Amsterdam</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="werkText">WERKKAMERSESSIE</p>
                                            <p class="descriptionPlatform">
                                                Platform met complete aanbod opleidingen
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide swiper-slide4">
                                    <div class="cardKraam2">
                                        <div class="headCardKraam">
                                            <div class="blockImgCardCour">
                                                <img src="img/libay.png" alt="">
                                            </div>
                                            <div class="blockgroup7">
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="img/kraam.png" class="icon7" alt="">
                                                        <p class="kraaText">Kraamvrzogende</p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="img/mbo3.png" class="icon7" alt="">
                                                        <p class="kraaText">MB03</p>
                                                    </div>
                                                </div>
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="img/calend.png" class="icon7" alt="">
                                                        <p class="kraaText">6 dagdelen</p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="img/euro1.png" class="icon7" alt="">
                                                        <p class="kraaText">295</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contentCardProd">
                                            <div class="group8">
                                                <div class="imgTitleCours">
                                                    <div class="imgCoursProd">
                                                        <img src="img/addUser.jpeg" alt="">
                                                    </div>
                                                    <p class="nameCoursProd">LiveLearn</p>
                                                </div>
                                                <div class="group9">
                                                    <div class="blockOpein">
                                                        <img class="iconAm" src="img/graduat.png" alt="">
                                                        <p class="lieuAm">Opleiding</p>
                                                    </div>
                                                    <div class="blockOpein">
                                                        <img class="iconAm1" src="img/map.png" alt="">
                                                        <p class="lieuAm">Amsterdam</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="werkText">WERKKAMERSESSIE</p>
                                            <p class="descriptionPlatform">
                                                Platform met complete aanbod opleidingen
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="sousBlockProduct3">
                    <p class="sousBlockTitleProduct">Onderwerpen</p>
                    <div class="blockSousblockTitle webBlock">

                        <div class="swiper-container swipeContaineVerkoop">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="cardblockOnder">
                                        <div class="imgBlockCardonder">
                                            <img src="img/addUser.jpeg" alt="">
                                        </div>
                                        <p class="verkop">Verkoop en sales</p>
                                        <a href="" class="btn btnMeer">Meer</a>
                                    </div>
                                </div>
                                <div class="swiper-slide ">
                                    <div class="cardblockOnder">
                                        <div class="imgBlockCardonder">
                                            <img src="img/addUser.jpeg" alt="">
                                        </div>
                                        <p class="verkop">Leiderschap</p>
                                        <a href="" class="btn btnMeer">Meer</a>
                                    </div>
                                </div>

                                <div class="swiper-slide ">
                                    <div class="cardblockOnder">
                                        <div class="imgBlockCardonder">
                                            <img src="img/addUser.jpeg" alt="">
                                        </div>
                                        <p class="verkop">Excel</p>
                                        <a href="" class="btn btnMeer">Meer</a>
                                    </div>
                                </div>

                                <div class="swiper-slide ">
                                    <div class="cardblockOnder">
                                        <div class="imgBlockCardonder">
                                            <img src="img/addUser.jpeg" alt="">
                                        </div>
                                        <p class="verkop">Excel</p>
                                        <a href="" class="btn btnMeer">Meer</a>
                                    </div>
                                </div>

                                <div class="swiper-slide ">
                                    <div class="cardblockOnder">
                                        <div class="imgBlockCardonder">
                                            <img src="img/addUser.jpeg" alt="">
                                        </div>
                                        <p class="verkop">Excel</p>
                                        <a href="" class="btn btnMeer">Meer</a>
                                    </div>
                                </div>
                                <div class="swiper-slide ">
                                    <div class="cardblockOnder">
                                        <div class="imgBlockCardonder">
                                            <img src="img/addUser.jpeg" alt="">
                                        </div>
                                        <p class="verkop">HRM</p>
                                        <a href="" class="btn btnMeer">Meer</a>
                                    </div>
                                </div>
                                <div class="swiper-slide ">
                                    <div class="cardblockOnder">
                                        <div class="imgBlockCardonder">
                                            <img src="img/addUser.jpeg" alt="">
                                        </div>
                                        <p class="verkop">HRM</p>
                                        <a href="" class="btn btnMeer">Meer</a>
                                    </div>
                                </div>
                                <div class="swiper-slide ">
                                    <div class="cardblockOnder">
                                        <div class="imgBlockCardonder">
                                            <img src="img/addUser.jpeg" alt="">
                                        </div>
                                        <p class="verkop">Marktkoopman</p>
                                        <a href="" class="btn btnMeer">Meer</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="sousBlockProduct4">
                <div class="headsousBlockProduct4">
                    <p class="sousBlockTitleProduct2">Agenda</p>
                    <div class="elementIconeRight">
                        <img class="imgIconeShowMore" src="img/IconShowMore.png" alt="">
                    </div>
                    <a href="/newFilesHtml/agenda.html" class="showAllLink">Show all</a>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="blockCardFront">
                            <div class="workshopBlock">
                                <p class="workshopText">workshop</p>
                                <div class="blockDateFront">
                                    <p class="moiText">JAN</p>
                                    <p class="dateText">20</p>
                                </div>
                            </div>
                            <div class="deToekomstBlock">
                                <p class="deToekomstText">De toekomst van het gezonde kantoorgebouw, door ventilatie</p>
                                <p class="platformText">Platform met complete aanbod opleidingenTest voor de derde regel. Het is een enorme test dus ik heb geen idee wat hier staat alleen kijken..</p>
                                <div class="detaiElementAgenda detaiElementAgendaModife">
                                    <div class="janBlock">
                                        <div class="colorFront"></div>
                                        <p class="textJan">Jan Gerard Hoendevanger</p>
                                    </div>
                                    <div class="euroBlock">
                                        <img class="euroImg" src="img/euro.png" alt="">
                                        <p class="textJan">295</p>
                                    </div>
                                    <div class="zwoleBlock">
                                        <img class="ss" src="img/ss.png" alt="">
                                        <p class="textJan">zwolle</p>
                                    </div>
                                    <div class="facilityBlock">
                                        <img class="faciltyImg" src="img/map-search.png" alt="">
                                        <p class="textJan facilityText">Facility Management</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="blockCardFront">
                            <div class="workshopBlock">
                                <p class="workshopText">workshop</p>
                                <div class="blockDateFront">
                                    <p class="moiText">JAN</p>
                                    <p class="dateText">20</p>
                                </div>
                            </div>
                            <div class="deToekomstBlock">
                                <p class="deToekomstText">De toekomst van het gezonde kantoorgebouw, door ventilatie</p>
                                <p class="platformText">Platform met complete aanbod opleidingenTest voor de derde regel. Het is een enorme test dus ik heb geen idee wat hier staat alleen kijken..</p>
                                <div class="detaiElementAgenda detaiElementAgendaModife">
                                    <div class="janBlock">
                                        <div class="colorFront"></div>
                                        <p class="textJan">Jan Gerard Hoendevanger</p>
                                    </div>
                                    <div class="euroBlock">
                                        <img class="euroImg" src="img/euro.png" alt="">
                                        <p class="textJan">295</p>
                                    </div>
                                    <div class="zwoleBlock">
                                        <img class="ss" src="img/ss.png" alt="">
                                        <p class="textJan">zwolle</p>
                                    </div>
                                    <div class="facilityBlock">
                                        <img class="faciltyImg" src="img/map-search.png" alt="">
                                        <p class="textJan facilityText">Facility Management</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="blockCardFront">
                            <div class="workshopBlock">
                                <p class="workshopText">workshop</p>
                                <div class="blockDateFront">
                                    <p class="moiText">JAN</p>
                                    <p class="dateText">20</p>
                                </div>
                            </div>
                            <div class="deToekomstBlock">
                                <p class="deToekomstText">De toekomst van het gezonde kantoorgebouw, door ventilatie</p>
                                <p class="platformText">Platform met complete aanbod opleidingenTest voor de derde regel. Het is een enorme test dus ik heb geen idee wat hier staat alleen kijken..</p>
                                <div class="detaiElementAgenda detaiElementAgendaModife">
                                    <div class="janBlock">
                                        <div class="colorFront"></div>
                                        <p class="textJan">Jan Gerard Hoendevanger</p>
                                    </div>
                                    <div class="euroBlock">
                                        <img class="euroImg" src="img/euro.png" alt="">
                                        <p class="textJan">295</p>
                                    </div>
                                    <div class="zwoleBlock">
                                        <img class="ss" src="img/ss.png" alt="">
                                        <p class="textJan">zwolle</p>
                                    </div>
                                    <div class="facilityBlock">
                                        <img class="faciltyImg" src="img/map-search.png" alt="">
                                        <p class="textJan facilityText">Facility Management</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="blockCardFront">
                            <div class="workshopBlock">
                                <p class="workshopText">workshop</p>
                                <div class="blockDateFront">
                                    <p class="moiText">JAN</p>
                                    <p class="dateText">20</p>
                                </div>
                            </div>
                            <div class="deToekomstBlock">
                                <p class="deToekomstText">De toekomst van het gezonde kantoorgebouw, door ventilatie</p>
                                <p class="platformText">Platform met complete aanbod opleidingenTest voor de derde regel. Het is een enorme test dus ik heb geen idee wat hier staat alleen kijken..</p>
                                <div class="detaiElementAgenda detaiElementAgendaModife">
                                    <div class="janBlock">
                                        <div class="colorFront"></div>
                                        <p class="textJan">Jan Gerard Hoendevanger</p>
                                    </div>
                                    <div class="euroBlock">
                                        <img class="euroImg" src="img/euro.png" alt="">
                                        <p class="textJan">295</p>
                                    </div>
                                    <div class="zwoleBlock">
                                        <img class="ss" src="img/ss.png" alt="">
                                        <p class="textJan">zwolle</p>
                                    </div>
                                    <div class="facilityBlock">
                                        <img class="faciltyImg" src="img/map-search.png" alt="">
                                        <p class="textJan facilityText">Facility Management</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sousBlockProduct2">
                <p class="sousBlockTitleProduct">Opleidingen</p>
                <div class="blockCardOpleidingen ">

                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="img/libay.png" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText">Kraamvrzogende</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText">MB03</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">6 dagdelen</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img src="img/addUser.jpeg" alt="">
                                                </div>
                                                <p class="nameCoursProd">LiveLearn</p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="img/graduat.png" alt="">
                                                    <p class="lieuAm">Opleiding</p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            Platform met complete aanbod opleidingen
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="img/libay.png" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText">Kraamvrzogende</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText">MB03</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">6 dagdelen</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <!--  <img src="" alt="">-->
                                                </div>
                                                <p class="nameCoursProd">LiveLearn</p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="img/graduat.png" alt="">
                                                    <p class="lieuAm">Opleiding</p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            Platform met complete aanbod opleidingen
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="img/libay.png" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText">Kraamvrzogende</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText">MB03</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">6 dagdelen</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img src="img/addUser.jpeg" alt="">
                                                </div>
                                                <p class="nameCoursProd">LiveLearn</p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="img/graduat.png" alt="">
                                                    <p class="lieuAm">Opleiding</p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            Platform met complete aanbod opleidingen
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="sousBlockProduct2">
                <p class="sousBlockTitleProduct">Masterclasses</p>
                <div class="blockCardOpleidingen ">

                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="img/libay.png" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText">Kraamvrzogende</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText">MB03</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">6 dagdelen</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img src="img/addUser.jpeg" alt="">
                                                </div>
                                                <p class="nameCoursProd">LiveLearn</p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="img/graduat.png" alt="">
                                                    <p class="lieuAm">Opleiding</p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            Platform met complete aanbod opleidingen
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="img/libay.png" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText">Kraamvrzogende</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText">MB03</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">6 dagdelen</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <!--  <img src="" alt="">-->
                                                </div>
                                                <p class="nameCoursProd">LiveLearn</p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="img/graduat.png" alt="">
                                                    <p class="lieuAm">Opleiding</p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            Platform met complete aanbod opleidingen
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="img/libay.png" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText">Kraamvrzogende</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText">MB03</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">6 dagdelen</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img src="img/addUser.jpeg" alt="">
                                                </div>
                                                <p class="nameCoursProd">LiveLearn</p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="img/graduat.png" alt="">
                                                    <p class="lieuAm">Opleiding</p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            Platform met complete aanbod opleidingen
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="sousBlockProduct6">
                <p class="sousBlockTitleProduct">Events</p>
                <div class="blockCardOpleidingen">

                    <div class="swiper-container swipeContaineEvens">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="cardKraam1 cardKraamTest">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour2">
                                            <img src="img/libay.png" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/hours.png" class="icon7" alt="">
                                                    <p class="kraaText">14h00</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">10 JAN</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            acqureren is werven hoe werkt dit in een normaal</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="cardKraam1 cardKraamTest">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour2">
                                            <img src="img/addUser.jpeg" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/hours.png" class="icon7" alt="">
                                                    <p class="kraaText">14h00</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">10 JAN</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            acqureren is werven hoe werkt dit in een normaal</p>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="cardKraam1 cardKraamTest">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour2">
                                            <img src="img/libay.png" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/hours.png" class="icon7" alt="">
                                                    <p class="kraaText">14h00</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">10 JAN</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            acqureren is werven hoe werkt dit in een normaal</p>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="cardKraam1 cardKraamTest">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour2">
                                            <img src="img/libay.png" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/hours.png" class="icon7" alt="">
                                                    <p class="kraaText">14h00</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">10 JAN</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            acqureren is werven hoe werkt dit in een normaal</p>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="cardKraam1 cardKraamTest">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour2">
                                            <img src="img/libay.png" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/hours.png" class="icon7" alt="">
                                                    <p class="kraaText">14h00</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">10 JAN</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            acqureren is werven hoe werkt dit in een normaal</p>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="cardKraam1 cardKraamTest">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour2">
                                            <img src="img/addUser.jpeg" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/hours.png" class="icon7" alt="">
                                                    <p class="kraaText">14h00</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">10 JAN</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            acqureren is werven hoe werkt dit in een normaal</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="cardKraam1 cardKraamTest">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour2">
                                            <img src="img/2a.jpg" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/hours.png" class="icon7" alt="">
                                                    <p class="kraaText">14h00</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">10 JAN</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            acqureren is werven hoe werkt dit in een normaal</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



            <div class="sousBlockProduct2">
                <p class="sousBlockTitleProduct">E-Learnings</p>
                <div class="blockCardOpleidingen ">

                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="img/libay.png" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText">Kraamvrzogende</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText">MB03</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">6 dagdelen</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img src="img/addUser.jpeg" alt="">
                                                </div>
                                                <p class="nameCoursProd">LiveLearn</p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="img/graduat.png" alt="">
                                                    <p class="lieuAm">Opleiding</p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            Platform met complete aanbod opleidingen
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="img/libay.png" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText">Kraamvrzogende</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText">MB03</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">6 dagdelen</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <!--  <img src="" alt="">-->
                                                </div>
                                                <p class="nameCoursProd">LiveLearn</p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="img/graduat.png" alt="">
                                                    <p class="lieuAm">Opleiding</p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            Platform met complete aanbod opleidingen
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="img/libay.png" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText">Kraamvrzogende</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText">MB03</p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText">6 dagdelen</p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText">295</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img src="img/addUser.jpeg" alt="">
                                                </div>
                                                <p class="nameCoursProd">LiveLearn</p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="img/graduat.png" alt="">
                                                    <p class="lieuAm">Opleiding</p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText">WERKKAMERSESSIE</p>
                                        <p class="descriptionPlatform">
                                            Platform met complete aanbod opleidingen
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: '3',
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>
<script>
    var swiper = new Swiper('.swipeContaineVerkoop', {
        slidesPerView: '5',
        spaceBetween: 20,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>
<script>
    var swiper = new Swiper('.swipeContaineEvens', {
        slidesPerView: '5',
        spaceBetween: 20,
        breakpoints: {
            780: {
                slidesPerView: 1,
                spaceBetween: 40,
            },
            1230: {
                slidesPerView: 3.9,
                spaceBetween: 20,
            }
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

    });
</script>
<script>
    $(document).ready(function(){
        $("#hide").click(function(){
            $(".sousProductTest").hide();
        });
        $("#show").click(function(){
            $(".sousProductTest").show();
        });
    });
</script>

</body>
</html>

