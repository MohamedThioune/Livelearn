<?php /** Template Name: Sub topic */ ?>
<body>
<?php wp_head(); ?>
<?php get_header(); ?>

<?php
    $subtopic  = ($_GET['subtopic']) ? $_GET['subtopic'] : ' ';

    if($subtopic != ' '){
        $name = (String)get_the_category_by_ID($subtopic);
        
        $categories = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'orderby'    => 'name',
            'parent'     => $subtopic,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ) );
    }
    
?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<div class="contentOne">
    <div class="boxOne3 boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <p class="wordDeBestText2"> <?php echo $name ?> </p>
                <a href="/ecosystem/?topic=<?= $subtopic; ?>" class="btn btnCommunity">Community</a>
            </div>
        </div>
    </div>

   <div class="container">
       <div class="block11">
           <div class="row">
               <?php
               if(isset($categories)){
               foreach ($categories as $value) {


               ?>
               <div class="col-md-3 col-lg-3 col-6">
                   <a href="category-overview?category=<?php echo $value->cat_ID ?>" class="text-bero"><?php echo $value->cat_name ?></a>
               </div>
                   <?php
               }
               }
               ?>
           </div>
       </div>
   </div>

</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>

<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 'auto',
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>
</body>
</html>
