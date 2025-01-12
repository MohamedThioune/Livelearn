<?php /** Template Name: Voor teachers template */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />


<body>
    <section class=" pt-md-5" style="background: #00A89D">
        <div class="container  py-5">
            <div class="row  py-md-5">
                <div class="col-md-8 text-md-left text-center">

                    <div class="">
                        <h1 class="CreeerText" style="">
                            Word onderdeel van het grootste expert / opleidersnetwerk
                        </h1>
                        <h5 class="text-white">Deel jouw kennis met rest van Nederland</h5>
                        <a class="btn rounded-pill my-3" href="/overview-organisations-5"
                            style="padding: 7px 20px !important; background: #E0EFF4;">
                            <strong class=" p-3">Meer informatie? </strong>
                        </a>
                    </div>
                    <div class="mt-5">
                        <img class="w-50" src="<?php echo get_stylesheet_directory_uri();?>/img/headWeb8.png" alt="">
                    </div>

                </div>
                <div class="col-md-4 mt-5">
                    <div class="blockForm" style="width:100%">
                        <p class="gratisText gratisText2">Gratis</p>
                        <p><b>Meld je aan</b></p>
                        <?php
                            echo do_shortcode("[gravityform id='12' title='false' description='false' ajax='true']");
                        ?>
                    </div>
                </div>
            </div>


        </div>
    </section>


</body>


<?php get_footer(); ?>
<?php wp_footer(); ?>