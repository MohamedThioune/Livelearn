<?php /** Template Name: Client Wordpress */ ?>


<?php wp_head(); ?>
<?php get_header(); ?>

<?php
require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

$woocommerce = new Client(
    'http://livelearn.nl',
    'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
    'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
    [
      'version' => 'wc/v3',
    ]
  );

$woocommerce = new Client($url, $consumer_key, $consumer_secret, $options);
print_r($woocommerce->get('orders'));
?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />



<!-- Content -->
<body>

   <div class="contentDetailCourseDataBank">
       <div class="container-fluid">
           <div class="">
               <h2>Modife Course Databank</h2>
               <form action="">
                   <div class="groupInputDate">
                       <div class="input-group">
                           <label for="">Title</label>
                           <input type="text">
                       </div>
                       <div class="input-group">
                           <label for="">Course type</label>
                           <select name="" id="">
                               <option value="" disabled></option>
                               <option value="">Design</option>
                               <option value="">Dev</option>
                               <option value="">Econnomi</option>
                               <option value="">Political</option>
                           </select>
                       </div>

                   </div>

                   <div class="groupInputDate">
                       <div class="input-group">
                           <label for="">Short description</label>
                           <input type="text">
                       </div>
                       <div class="input-group">
                           <label for="">Price </label>
                           <input type="text">
                       </div>
                   </div>

                   <div class="groupInputDate">
                       <div class="input-group">
                           <label for="">Onderwerpen</label>
                           <select name="" id="">
                               <option value="" disabled></option>
                               <option value="">Design</option>
                               <option value="">Dev</option>
                               <option value="">Econnomi</option>
                               <option value="">Political</option>
                           </select>
                       </div>
                       <div class="input-group">
                           <label for="">Date_multiple</label>
                           <input type="text" id="" class="datepicker Txt_Date" placeholder="Pick the multiple dates" style="cursor: pointer;">
                       </div>
                   </div>

                   <div class="groupInputDate">
                       <div class="input-group">
                           <label for="">Teacher(s)</label>
                           <select name="" id="">
                               <option value="" disabled></option>
                               <option value="">Design</option>
                               <option value="">Dev</option>
                               <option value="">Econnomi</option>
                               <option value="">Political</option>
                           </select>
                       </div>
                       <div class="input-group">
                           <label for="">Certificate</label>
                           <select name="" id="">
                               <option value="" disabled></option>
                               <option value="">Design</option>
                               <option value="">Dev</option>
                               <option value="">Econnomi</option>
                               <option value="">Political</option>
                           </select>
                       </div>
                   </div>

                   <div class="input-group-course">
                       <label for="">Long description</label>
                          <textarea  name="" class="summernoteElement" id="summernoteEditBank"></textarea>

                   </div>

                   <div class="input-group-course">
                       <label for="">For who</label>
                       <textarea name="" id="" cols="30" rows="6"></textarea>
                   </div>

                   <div class="input-group-course">
                       <label for="">Agenda</label>
                       <textarea name="" id="" cols="30" rows="6"></textarea>
                   </div>

                   <div class="input-group-course">
                       <label for="">Results</label>
                       <textarea name="" id="" cols="30" rows="6"></textarea>
                   </div>

                   <button type="button" class="btn btn-newDate" data-toggle="modal" data-target="#exampleModalDate">
                       Change
                   </button>

               </form>
           </div>
       </div>
   </div>




</body>

<?php get_footer(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    $('.summernoteElement').summernote({
        placeholder: 'Hello stand alone ui',
        tabsize: 2,
        height: 195,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
</script>

<?php wp_footer(); ?>



