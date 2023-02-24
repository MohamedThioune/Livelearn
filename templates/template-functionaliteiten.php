<?php /** Template Name: functiegerichte */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<div class="content-functiegerichte">
    <section class="functionaliteiten">
        <div class="container-fluid">
            <div class="text-center">
                <img class="img-functionaliteiten" src="<?php echo get_stylesheet_directory_uri();?>/img/function.png" alt="">
            </div>
            <h2>Onze functionaliteiten</h2>
            <div class="tab-block-functiegerichte">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#Voor-individuen">Voor individuen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#Voor-organisaties">Voor organisaties</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#Voor-opleiders-experts">Voor opleiders / experts</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content" style="display: block;">
                    <div id="Voor-individuen" class="container tab-pane active"><br>
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
                                <p class="title">JTest meteen je skills met onze assessments</p>
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
                                <p class="title">360 Feedback vragen aan collega’s. </p>
                                <p class="description">Wil je van anderen horen hoe zij kijken naar je vaardigheden? Vraag ze dan direct feedback. Zo weet je zeker dat je werkt aan je juiste skills</p>
                            </div>
                        </div>
                    </div>
                    <div id="Voor-organisaties" class="container tab-pane fade"><br>
                        <h3>Menu 1</h3>
                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                    <div id="Voor-opleiders-experts" class="container tab-pane fade"><br>
                        <h3>Menu 2</h3>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                    </div>
                </div>
            </div>



            <div class="btn-Bekijk-functionaliteiten text-center">
                <a href="" class="btn ">Bekijk al onze functionaliteiten</a>
            </div>
        </div>

    </section>
</div>





<?php get_footer(); ?>
<?php wp_footer(); ?>

<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
