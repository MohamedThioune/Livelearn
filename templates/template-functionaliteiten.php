<?php /** Template Name: functionaliteiten */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>


<div class="content-functiegerichte">
    <section class="functionaliteiten">
        <div class="container-fluid">
            <div class="text-center">
                <img class="img-functionaliteiten" src="<?php echo get_stylesheet_directory_uri();?>/img/function.png" alt="">
            </div>
            <h2>Onze functionaliteiten</h2>

            <div class="tab-block-functiegerichte" id="tab-url1">
                <ul class="nav nav-tabs">
                    <li class="nav-item nav-one"><a href="#Voor-individuen" class="current">Voor individuen</a></li>
                    <li class="nav-item nav-two"><a href="#Voor-organisaties" class="load_content_type">Voor organisaties</a></li>
                    <li class="nav-item nav-three"><a href="#Voor-opleiders-experts" class="load_content_type">Voor opleiders / experts</a></li>
                </ul>

                <div class="list-wrap tab-content" style="display: block;">
                    <ul id="Voor-individuen">
                        <div>
                            <div class="block-functionaliteiten d-flex flex-wrap">
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/geperso.png" alt="">
                                    </div>
                                    <p class="title">Je gepersonaliseerde leeromgeving</p>
                                    <p class="description">Jij bepaalt zelf wat je in je omgeving te zien krijgt. Kies je onderwerpen of experts en neem je omgeving ook gewoon mee naar nieuwe werkgevers.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mobiele.png" alt="">
                                    </div>
                                    <p class="title">Een mobiele app voor je dagelijkse learnings</p>
                                    <p class="description">Veel onderweg en toch op de hoogte blijven van de laatste ontwikkelingen of vaardigheden. Gebruik dan onze app voor Apple of Android. </p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Leervormen.png" alt="">
                                    </div>
                                    <p class="title">Leervormen die bij iedereen passen.</p>
                                    <p class="description">We hebben 10 verschillende leervormen in het LiveLearn platform. Van het lezen van artikelen tot het volgen van een opleiding.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/meten-icon.png" alt="">
                                    </div>
                                    <p class="title">Test meteen je skills met onze assessments</p>
                                    <p class="description">Leuk hè, al die content. Test ook meteen hoe goed je de materie nou echt beheerst met onze assessments. Dan weet je het precies.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/bewaren.png" alt="">
                                    </div>
                                    <p class="title">Bewaren voor later? Sla je content direct op.</p>
                                    <p class="description">Leuke opleiding gezien óf een artikel later teruglezen? Sla alles op in je profiel. Je kan alle content ook direct delen met je vrienden of collega’s</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/vragen-icon.png" alt="">
                                    </div>
                                    <p class="title">360 Feedback vragen aan collega’s.</p>
                                    <p class="description">Wil je van anderen horen hoe zij kijken naar je vaardigheden? Vraag ze dan direct feedback. Zo weet je zeker dat je werkt aan je juiste skills</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Onze-slimme.png" alt="">
                                    </div>
                                    <p class="title">AI? Onze slimme algoritmes helpen je.</p>
                                    <p class="description">Wat past er nou het best bij jou als persoon. Wij hebben slimme software ontwikkeld die je helpt de juiste keuzes te maken en je content aanraadt.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/certificaten.png" alt="">
                                    </div>
                                    <p class="title">Diploma’s / certificaten op éen plek.</p>
                                    <p class="description">Je haalt veel meer diploma’s en certificaten dan je eigenlijk weet. Houd ze allemaal bij in je eigen certificatenbox.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Skills-paspoort.png" alt="">
                                    </div>
                                    <p class="title">Skills paspoort, jouw dynamische CV.</p>
                                    <p class="description">Alle skills die ontwikkelt, feedback die je krijgt of diploma’s die je haalt worden omgezet naar je skills paspoort. Zo heb je een dynamisch en realistisch CV.</p>
                                </div>
                            </div>
                            <a href="/Individu/" class="btn btn-meer-lezen">Meer lezen over wat LiveLearn jou biedt?</a>
                        </div>
                    </ul>

                    <ul id="Voor-organisaties" class="hide">
                        <div>
                            <div class="block-functionaliteiten d-flex flex-wrap">
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/geperso.png" alt="">
                                    </div>
                                    <p class="title">Een eigen organisatie dashboard</p>
                                    <p class="description">Personaliseer je leertrajecten met een eigen dashboard. Krijg inzichten in personeel, volg hun voortgang en ontgrendel hun volledige potentieel. </p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mobiele.png" alt="">
                                    </div>
                                    <p class="title">Beheer cursussen en trainingen</p>
                                    <p class="description">Beheer moeiteloos cursussen en trainingen. Volg voortgang, lever content en verrijk de leerervaring. Optimaliseer je leeromgeving.  </p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Leervormen.png" alt="">
                                    </div>
                                    <p class="title">Tien verschillende leervormen.</p>
                                    <p class="description">Ontdek 10 diverse leervormen. Kies, ontwikkel en groei wederop z’n eigen manier. Verrijkende leerervaringen gegarandeerd.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/meten-icon.png" alt="">
                                    </div>
                                    <p class="title">Sociale interactie en samenwerking</p>
                                    <p class="description">Versterk je leerproces met sociale interactie en samenwerking. Verbind, deel en groei samen met anderen. Optimaal leren in gemeenschap.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/bewaren.png" alt="">
                                    </div>
                                    <p class="title">Analyse en rapportage per team.</p>
                                    <p class="description">Krijg waardevolle inzichten met krachtige analyse en rapportage. Monitor voortgang, meet prestaties en optimaliseer je leerresultaten.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/vragen-icon.png" alt="">
                                    </div>
                                    <p class="title">Integratie met externe systemen</p>
                                    <p class="description">Naadloze integratie met bestaande systemen. Optimaliseer workflows, deel gegevens en versterk je leeromgeving zonder onnodig werk.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Onze-slimme.png" alt="">
                                    </div>
                                    <p class="title">AI? Onze slimme algoritmes helpen je.</p>
                                    <p class="description">Wat past er nou het best bij elk persoon. Wij hebben slimme software ontwikkeld die je helpt de juiste keuzes te maken en je content aanraadt.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/certificaten.png" alt="">
                                    </div>
                                    <p class="title">Diploma’s / certificaten op éen plek.</p>
                                    <p class="description">Je haalt veel meer diploma’s en certificaten dan je eigenlijk weet. Houd ze allemaal bij in je eigen certificatenbox.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Skills-paspoort.png" alt="">
                                    </div>
                                    <p class="title">Een mobiele app voor iedere collega</p>
                                    <p class="description">Bied elke medewerker een eigen mobiele app. Flexibel leren, waar en wanneer dan ook. Empowerment in de palm van je hand.</p>
                                </div>
                            </div>
                            <a href="/voor-organisaties/" class="btn btn-meer-lezen">Meld je aan als bedrijf</a>
                        </div>
                    </ul>

                    <ul id="Voor-opleiders-experts" class="hide">
                        <div>
                            <div class="block-functionaliteiten d-flex flex-wrap">
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/geperso.png" alt="">
                                    </div>
                                    <p class="title">Je gepersonaliseerde expert-dashboard
                                    </p>
                                    <p class="description">Jij bepaalt zelf wat je in je omgeving te zien krijgt. Kies je onderwerpen of experts en neem je omgeving ook gewoon mee naar nieuwe werkgevers.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mobiele.png" alt="">
                                    </div>
                                    <p class="title">Beheer cursussen en trainingen
                                    </p>
                                    <p class="description">Beheer moeiteloos cursussen en trainingen. Volg voortgang, lever content en verrijk de leerervaring. Optimaliseer je leeromgeving. </p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Leervormen.png" alt="">
                                    </div>
                                    <p class="title">Bied verschillende leervormen aan
                                    </p>
                                    <p class="description">We hebben 10 verschillende leervormen in het LiveLearn platform. Van het lezen van artikelen tot het volgen van een opleiding.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/meten-icon.png" alt="">
                                    </div>
                                    <p class="title">Ontwerp je eigen cursussen.</p>
                                    <p class="description">Tools om cursussen te maken en te structureren volgens jouw expertise. Dit omvat het creëren van lessen, modules, quizzen en interactieve activiteiten.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/bewaren.png" alt="">
                                    </div>
                                    <p class="title">Analyseer de prestatie van je deelnemers.
                                    </p>
                                    <p class="description">Krijg inzicht in de prestaties en voortgang van deelnemers aan jouw cursussen. Dit kan het volgen van voltooide modules, quizscores en andere prestatie-indicatoren omvatten.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/vragen-icon.png" alt="">
                                    </div>
                                    <p class="title">Opleidersexpertise en profielbeheer .</p>
                                    <p class="description">Mogelijkheid om een persoonlijk profiel te maken en jouw expertise te presenteren. Hierdoor kun je reputatie opbouwen en zichtbaar zijn voor potentiële deelnemers.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Onze-slimme.png" alt="">
                                    </div>
                                    <p class="title">AI? Onze slimme algoritmes helpen je.</p>
                                    <p class="description">Wat past er nou het best bij jouw doelgroep? Wij hebben slimme software ontwikkeld die je helpt de juiste keuzes te maken om je doelgroep te bereiken.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/certificaten.png" alt="">
                                    </div>
                                    <p class="title">Genereer nieuwe inkomsten</p>
                                    <p class="description">Verkopen je kennis om inkomsten te genereren. Wij hebben integraties met betalingsgateways, prijsstellingsopties en bieden rapportage van je verkoopprestaties.</p>
                                </div>
                                <div class="card-functionaliteiten">
                                    <div class="text-right">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Skills-paspoort.png" alt="">
                                    </div>
                                    <p class="title">Integratie met externe systemen
                                    </p>
                                    <p class="description">Naadloze integratie met bestaande systemen. Optimaliseer workflows, deel gegevens en versterk je afzetmarkt zonder onnodig werk.</p>
                                </div>
                            </div>
                            <a href="/voor-opleiders/" class="btn btn-meer-lezen">Meld je aan als expert / opleider</a>
                        </div>
                    </ul>
                </div>
            </div>

        </div>

    </section>
    <section class="block-contact-calendy bleu-block-contact-calendy text-center" style="margin-top: 0;">
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="img-Direct-een">
                    <img id="firstImg-direct-contact" src="<?php echo get_stylesheet_directory_uri();?>/img/Direct-een.png" alt="">
                </div>
                <div class="img-Direct-een">
                    <img id="secondImg-direct-contact" src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der-Kolk.png" alt="">
                </div>
            </div>
            <h3 class="title-Direct-een"><strong>Direct een afspraak inplannen?</strong><br> Hulp nodig of heb je vragen over LiveLearn? Wij zijn er om je te helpen.</h3>
            <button class="btn btn-kies" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/livelearn/overleg-pilot'});return false;">Kies een datum</button>

        </div>
    </section>
</div>





<?php get_footer(); ?>
<?php wp_footer(); ?>

<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo get_stylesheet_directory_uri();?>/organictabs.jquery.js"></script>
<script>
    $(function() {

        // Calling the plugin
        $("#tab-url1").organicTabs();

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


</body>
