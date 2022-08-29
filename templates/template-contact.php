<?php /** Template Name: template Contact  */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />


<body>     

    <section class="py-5" style="background: #043356">
        <div class="container-fluid py-md-5 pb-5">
            <div class="row d-flex justify-content-center align-items-center mx-2">
            
                <div class="col-md-6 px-md-0 text-md-left text-center">
                    <img class="im-fluid w-75"  src="<?php echo get_stylesheet_directory_uri();?>/img/Contact_team2.png" alt="team">     
                </div>

                <div class="col-md-6 px-md-0 text-md-left text-center">
                    <h2 class="hero-title text-white">Direct contact met één van onze adviseurs?</h2>
                    <div class="my-3 text-white">
                        <p>
                            We helpen je graag met jouw specifieke vragen omtrent talent management en de 
                            toepasbaarheid hiervan binnen je organisatie.
                        </p>
                    </div>    
                    <a href="mailto:contact@livelearn.nl" class="btn btn-default rounded-pill px-5 my-2 ml-md-0 ml-2" style="background: #E3EFF4">
                        <strong class="text-dark">Email </strong>
                    </a>
                    <a href="tel: +31627003962" class="btn btn-default rounded-pill px-5 my-2 ml-md-3" style="background: #00A89D">
                        <strong >Bellen</strong> 
                    </a>
                </div>
            </div>
        </div>
    </section>
    
</body> 

<?php get_footer(); ?>
<?php wp_footer(); ?>