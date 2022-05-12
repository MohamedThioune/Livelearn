<?php /** Template Name: dashboard manager people overview mensen */ ?>

<div class="contentOne">
    <?php require 'headerDashboard.php';?>
</div>

<div class="contentPageManager managerOverviewMensen">
    <div class="blockSidbarMobile blockSidbarMobile2">
        <div class="zijbalk">
            <p class="zijbalkMenu">zijbalk menu</p>
            <button class="btn btnSidbarMob">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/filter.png" alt="">
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?php require 'layaoutManager.php';?>
        </div>
        <div class="col-md-9">
           <div class="contentOverviewMensen">
               <div class="blockOverviewMensen">
                   <h2 class="titleBlockOverviewMensen">Toevoegen</h2>
                   <div class="bodyBlockOverviewMensen">
                       <ul>
                           <li>Voornaam</li>
                           <li>Achternaam</li>
                           <li>ZaKelijk mailadres</li>
                       </ul>
                       <a href="" class="btn btnMensenToevoegen">Werknemer toevoegen</a>
                   </div>
               </div>
               <div class="blockOverviewMensen">
                   <h2 class="titleBlockOverviewMensen">Groep Toevoegen </h2>
                   <div class="bodyBlockOverviewMensen">
                       <ul>
                           <li>Zakelijk mailadres</li>
                           <li>Zakelijk mailadres</li>
                           <li>Zakelijk mailadres</li>
                           <li><a href=""><b>+meer</b></a></li>
                       </ul>
                       <a href="" class="btn btnMensenToevoegen">Werknemer toevoegen</a>
                   </div>
               </div>
               <div class="importBlock2 blockOverviewMensen">
                   <h2 class="titleBlockOverviewMensen">Import Lijst</h2>
                   <div class="file-upload">
                       <div class="file-select">
                           <div class="file-select-button btnMensenToevoegen" id="fileName">Lijst importeren</div>
                           <div class="file-select-name" id="noFileLijs">IMPORT (Excel, CSV)</div>
                           <input type="file" name="chooseFileLijs" id="chooseFileLijs">
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
    $('#chooseFileLijs').bind('change', function () {
        var filename = $("#chooseFileLijs").val();
        if (/^\s*$/.test(filename)) {
            $(".file-upload").removeClass('active');
            $("#noFileLijs").text("No file chosen...");
        }
        else {
            $(".file-upload").addClass('active');
            $("#noFileLijs").text(filename.replace("C:\\fakepath\\", ""));
        }
    });

</script>




