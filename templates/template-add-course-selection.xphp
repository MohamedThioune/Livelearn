<?php /** Template Name: add course selection */ ?>
<head>
    <meta charset="utf-8">
    <title>Livelearn</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
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
                <div class="titleOpleidingstype">
                    <h2>1. Kies opleidingstype</h2>
                </div>
                <a href="../../add-course" class="cardCours cardCoursInitial" >
                    <p class="contentText">
                        <b>Opleiding</b>
                    </p>
                </a>
                <a href="../../add-course" class="cardCours cardCoursInitial" >
                    <p class="contentText">
                        <b>Training</b>
                    </p>
                </a>
                <a href="../../add-course" class="cardCours cardCoursInitial" >
                    <p class="contentText">
                        <b>Workshop</b>

                    </p>
                </a>
                <a href="../../add-course" class="cardCours cardCoursInitial" >
                    <p class="contentText">
                        <b>Masterclass</b>
                    </p>
                </a>
                <a href="../../add-course" class="cardCours cardCoursInitial" >
                    <p class="contentText">
                        <b>E-Learning</b>
                    </p>
                </a>
                <a href="../../add-course" class="cardCours cardCoursInitial" >
                    <p class="contentText">
                        <b>Video</b>
                    </p>
                </a>
                <a href="../../add-course" class="cardCours cardCoursInitial" >
                    <p class="contentText">
                        <b>Artikel</b>
                    </p>
                </a>
                <a href="../../add-course" class="cardCours cardCoursInitial" >
                    <p class="contentText">
                        <b>Assessment</b>
                    </p>
                </a>
                <a href="../../add-course" class="cardCours cardCoursInitial" >
                    <p class="contentText">
                        <b>Cursus</b>
                    </p>
                </a>
                <a href="../../add-course" class="cardCours cardCoursInitial" >
                    <p class="contentText">
                        <b>Lezing</b>
                    </p>
                </a>
                <a href="../../add-course" class="cardCours cardCoursInitial" >
                    <p class="contentText">
                        <b>Event</b>
                    </p>
                </a>
                <a href="../../add-course" class="cardCours cardCoursInitial" >
                    <p class="contentText">
                        <b>Webinar</b>
                    </p>
                </a>

            </div>
        </div>
        <div class="col-md-3 col-lg-2 col-sm-12">
            <div class="importBlock2">
                <p class="kiesText">Import meerdere</p>
                <div class="file-upload">
                    <div class="file-select">
                        <div class="file-select-button" id="fileName">Import</div>
                        <div class="file-select-name" id="noFile">IMPORT (Excel, CSV)</div>
                        <input type="file" name="chooseFile" id="chooseFile">
                    </div>
                </div>
            </div>
            <div class="importBlock2 doawnloadBlock2">
                <p class="kiesText">Doawnload excel format</p>
                <div class="file-upload">
                    <div class="file-select">
                        <div class="file-select-button" id="fileName2">Doawnload</div>
                        <div class="file-select-name" id="noFile2">Doawnload (Excel)</div>
                        <input type="file" name="chooseFile2" id="chooseFile2">
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
<script src="../main.js"></script>

<script>
    $('#chooseFile').bind('change', function () {
        var filename = $("#chooseFile").val();
        if (/^\s*$/.test(filename)) {
            $(".file-upload").removeClass('active');
            $("#noFile").text("No file chosen...");
        }
        else {
            $(".file-upload").addClass('active');
            $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
        }
    });

</script>
<script>
    $('#chooseFile2').bind('change', function () {
        var filename = $("#chooseFile2").val();
        if (/^\s*$/.test(filename)) {
            $(".file-upload").removeClass('active');
            $("#noFile2").text("No file chosen...");
        }
        else {
            $(".file-upload").addClass('active');
            $("#noFile2").text(filename.replace("C:\\fakepath\\", ""));
        }
    });

</script>

</body>
</html>




