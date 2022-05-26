jQuery(function($){
    
    //variable for offline courses date input
    $('.block2evens').each(function(){
        console.log('enting for reservations done');
        var dateNameStart = $(this).find('input[data-attr="dateNameStart"]').val();
        $(this).find('.yith-wapo-option input').val(dateNameStart);
    });

    //scroll down
    $(function() {
        $('.bntStarted').click (function() {
            $('html, body').animate({scrollTop: $('.blockFormDeveloper').offset().top }, 'slow');
            return false;
        });
    });
    
    //header on scroll fix
    var height = ($('nav.navbar').css('height'));
    $('body').css('padding-top', height)

    $(".navModife4").click(function() {
        console.log('menu toggled');
        $(".dropdownMenuDashboard").toggle();

    });

    //variable for offline courses date input
    $('.block2evens').each(function(){
        console.log('enting for reservations done');
        var dateNameStart = $(this).find('input[data-attr="dateNameStart"]').val();
        $(this).find('.yith-wapo-option input').val(dateNameStart);
    });

    function myFunction() {
        document.getElementsByClassName("autocomplete-suggestions2").classList.toggle("show");
    }
    $(document).ready(function() {
        $("#burger").click(function() {
            $(".theme-side-menu").show();
            $("#sectionDashboard1").show();
            $(".b1").hide();
            $(".b2").show();
        });
        $("#burgerCroie").click(function() {
            $(".theme-side-menu").hide();
            $("#sectionDashboard1").hide();
            $(".b2").hide();
            $(".b1").show();
        });
    });

    $(".bntNotification").click(function() {
        $(".alertNotification").hide();
    });

    $(".btnCopy").click(function() {
        $(".linkCopied").show();
    });

    $(".burgerElement").click(function() {
        $(".headSousMobilePrincipale").show();
        $(".boxSousNav3-2").hide();
        $("#croieProfil").hide();
        $(".croie").toggle();
    });

    $("#burger-web").click(function() {
        $("#burgerCroie-web").show();
        $("#burger-web").hide();
    });

    $("#burgerCroie-web").click(function() {
        $("#burgerCroie-web").hide();
        $("#burger-web").show();
    });

    $(".croie").click(function() {
        $(".headSousMobilePrincipale").hide();
        $(".burgerElement").show();
        $("#croieSearch").hide();
        $("#croieProfil").hide();
        $(".croie").toggle();
    });

    $("#richting-bineen").click(function() {
        $(".firstContentHeadSousMobile").hide();
        $(".sousMenuBlock1").show();
        $("#upBlock1").show();

    });
    $("#upBlock1").click(function() {
        $(".firstContentHeadSousMobile").show();
        $(".sousMenuBlock1").hide();
        $(".btnUp").hide();
    });

    $("#Groeien-binnen").click(function() {
        $(".firstContentHeadSousMobile").hide();
        $(".sousMenuBlock2").show();
        $("#upBlock2").show();
    });
    $("#upBlock2").click(function() {
        $(".firstContentHeadSousMobile").show();
        $(".sousMenuBlock2").hide();
        $(".btnUp").hide();
    });

    $("#Ontwikkel-specifieke").click(function() {
        $(".firstContentHeadSousMobile").hide();
        $(".sousMenuBlock3").show();
        $("#upBlock3").show();
    });

    $("#voorOrganisati").click(function() {
        $("#voorOrganisatiModal").toggle();
        $(".activeModalHeader").show();
        $("#voorOpleidersModal").hide();
        $("#OpleidingenModal").hide();
    });

    $("#opleiders").click(function() {
        $("#voorOrganisatiModal").hide();
        $(".activeModalHeader").show();
        $("#voorOpleidersModal").toggle();
        $("#OpleidingenModal").hide();
    });

    $("#Opleidingen").click(function() {
        $("#voorOrganisatiModal").hide();
        $(".activeModalHeader").show();
        $("#voorOpleidersModal").hide();
        $("#OpleidingenModal").toggle();
    });
    $(".activeModalHeader").click(function() {
        $("#voorOrganisatiModal").hide();
        $("#voorOpleidersModal").hide();
        $("#OpleidingenModal").hide();
        $(".activeModalHeader").hide();
    });


    $("#btn_favorite").click(function() {
        $(".like1").toggle();
        $(".like2").toggle();
    });


    $(".replyBtn").click(function() {
        $(".replayForm").show();
    });
    $(".sendReplay").click(function() {
        $(".replayForm").hide();
    });



    $(".replyBtn").click(function() {
        $(".firstContentHeadSousMobile").show();
        $(".sousMenuBlock3").hide();
        $(".btnUp").hide();
    });

    $("#Ontwikkel-persoonlijke").click(function() {
        $(".firstContentHeadSousMobile").hide();
        $(".sousMenuBlock4").show();
        $("#upBlock4").show();
    });
    $("#upBlock4").click(function() {
        $(".firstContentHeadSousMobile").show();
        $(".sousMenuBlock4").hide();
        $(".btnUp").hide();
    });

    // for product podcast
    $(".codeless-player-toggle").click(function() {
        $(".audioBar").toggleClass("less");
    });


    //custom tabs
    // Show the first tab and hide the rest
    $('#tabs-nav li:first-child').addClass('active');
    $('.tab-content').hide();
    $('.tab-content:first').show();

// Click function
    $('#tabs-nav li').click(function(){
        $('#tabs-nav li').removeClass('active');
        $(this).addClass('active');
        $('.tab-content').hide();

        var activeTab = $(this).find('a').attr('href');
        $(activeTab).fadeIn();
        return false;
    });

    //focus

    $(function(){
        $("#inputSearchElementPath").focus(function(){
            $('.searchElementPath img').hide();
        });

        $("#inputSearchElementPath").focusout(function(){
            $('.searchElementPath img').show();
        });
    })


    // Pour first modal after login
    $(".btnBaangerichte").click(function() {
        $(".subtopicBaangerichte").show();
        let cl =$(this).attr('class').split(' ')[3];
        hidden=($(".cb_topics_bangricht_"+cl).attr('hidden'));
        $(".cb_topics_bangricht_"+cl).attr('hidden', !hidden);
        
    });

    $(".btnFunctiegericht").click(function() {
        $(".subtopicFunctiegericht").show();
        let cl =$(this).attr('class').split(' ')[3];
        hidden=($(".cb_topics_funct_"+cl).attr('hidden'));
        $(".cb_topics_funct_"+cl).attr('hidden', !hidden);
    });

    $(".btnSkills").click(function() {
        $(".subtopicSkills").show();
        let cl =$(this).attr('class').split(' ')[3];
        hidden=($(".cb_topics_skills_"+cl).attr('hidden'));
        $(".cb_topics_skills_"+cl).attr('hidden', !hidden);
    });

    $(".btnPersonal").click(function() {
        $(".subtopicPersonal").show();
        let cl =$(this).attr('class').split(' ')[3];
        hidden=($(".cb_topics_personal_"+cl).attr('hidden'));
        $(".cb_topics_personal_"+cl).attr('hidden', !hidden);
    });

    $("#nextblockBaangerichte").click(function() {
        $(".blockfunctiegericht").show();
        $(".blockBaangerichte").hide();
    });

    $("#nextFunctiegericht").click(function() {
        $(".blockSkills").show();
        $(".blockfunctiegericht").hide();
    });

    $("#nextSkills").click(function() {
        $(".blockPersonal").show();
        $(".blockSkills").hide();
    });

    // Pour assessments  backend
    $("#btnStratModal1").click(function() {
        $("#secondBlockAssessmentsBackend").show();
        $(".contentAsessment").hide();

    });
    $("#back1").click(function() {
        $("#secondBlockAssessmentsBackend").hide();
        $(".contentAsessment").show();
    });
    $("#btnStart2").click(function() {
        $("#step1OverviewAssessmentBackend").hide();
        $("#step2OverviewAssessmentBackend").show();
    });
    $("#btnStart3").click(function() {
        $("#step2OverviewAssessmentBackend").hide();
        $("#step3OverviewAssessmentBackend").show();
    });

    // Pour assessments frontend
    $("#btnStratModalfront").click(function() {
        $("#secondBlockAssessmentsfront").show();
        $(".contentAsessment").hide();

    });
    $("#back1front").click(function() {
        $("#secondBlockAssessmentsfront").hide();
        $(".contentAsessment").show();
    });
    $("#btnStart2front").click(function() {
        $("#step1OverviewAssessmentfront").hide();
        $("#step2OverviewAssessmentfront").show();
    });
    $("#btnStart3front").click(function() {
        $("#step2OverviewAssessmentfront").hide();
        $("#step3OverviewAssessmentfront").show();
    });

    // Pour assessments full
    $("#btnStratModalfull").click(function() {
        $("#secondBlockAssessmentsfull").show();
        $(".contentAsessment").hide();

    });
    $("#back1full").click(function() {
        $("#secondBlockAssessmentsfull").hide();
        $(".contentAsessment").show();
    });
    $("#btnStart2full").click(function() {
        $("#step1OverviewAssessmentfull").hide();
        $("#step2OverviewAssessmentfull").show();
    });
    $("#btnStart3full").click(function() {
        $("#step2OverviewAssessmentfull").hide();
        $("#step3OverviewAssessmentfull").show();
    });

    // Pour assessments Android
    $("#btnStratModalAndroid").click(function() {
        $("#secondBlockAssessmentsAndroid").show();
        $(".contentAsessment").hide();
    });
    $("#back1Android").click(function() {
        $("#secondBlockAssessmentsAndroid").hide();
        $(".contentAsessment").show();
    });
    $("#btnStart2Android").click(function() {
        $("#step1OverviewAssessmentAndroid").hide();
        $("#step2OverviewAssessmentAndroid").show();
    });
    $("#btnStart3Android").click(function() {
        $("#step2OverviewAssessmentAndroid").hide();
        $("#step3OverviewAssessmentAndroid").show();
    });

    // Pour assessments IOS
    $("#btnStratModalIOS").click(function() {
        $("#secondBlockAssessmentsIOS").show();
        $(".contentAsessment").hide();
    });
    $("#back1IOS").click(function() {
        $("#secondBlockAssessmentsIOS").hide();
        $(".contentAsessment").show();
    });
    $("#btnStart2IOS").click(function() {
        $("#step1OverviewAssessmentIOS").hide();
        $("#step2OverviewAssessmentIOS").show();
    });
    $("#btnStart3IOS").click(function() {
        $("#step2OverviewAssessmentIOS").hide();
        $("#step3OverviewAssessmentIOS").show();
    });


    // for menu large
    $("#burger-web").click(function() {
        $(".theme-side-menu").addClass("extensive");
    });
    // for menu large
    $("#burgerCroie-web").click(function() {
        $(".theme-side-menu").removeClass("extensive");
    });

    // for road path
    $("#bntContinueRoad").click(function() {
        $("#step2RoadPath").show("");
        $("#step1RoadPath").hide("");
    });




//POur inuput recherche coté responsivité
    $("#searchIcone").click(function() {
        $("#searchIcone").hide();
        $("#burgerCroie").hide();
        $("#headOne").hide();
        $("#croieProfil").hide();
        $("#headTwo").hide();
        $(".searchInputHedear").show();
        $("#burger").show();
        $("#croieSearch").show();
        $("#profilView").show();
    });
    $("#croieSearch").click(function() {
        $("#searchIcone").show();
        $(".searchInputHedear").hide();
        $("#croieSearch").hide();
    });

    $("#profilView").click(function() {
        $("#croieProfil").show();
        $(".headSousMobileProfile").show();
        $("#profilView").hide();
    });
    $("#croieProfil").click(function() {
        $("#croieProfil").hide();
        $(".headSousMobileProfile").hide();
        $("#croieSearch").hide();
        $(".searchInputHedear").hide();
        $("#profilView").show();
        $("#searchIcone").show();

    });

    $("#profilView").click(function() {
        $("#burgerCroie").hide();
        $("#headOne").hide();
        $("#searchInputHedear").hide();
        $("#croieSearch").hide();
        $("#burger").show();
        $("#searchIcone").show();
    });

    $("#burger").click(function() {
        $("#firstBlockVoeg").hide();
        $(".headSousMobileProfile").hide();
        $(".searchInputHedear").hide();
        $("#croieSearch").hide();
        $("#headOne").show();
        $("#searchIcone").show();
        $("#profilView").show();

    });

    //Pour le modal feedback
    $(".close").click(function() {
        $(".secondBlockVoeg").hide();
        $(".treeBlockVoeg").hide();
        $(".fourBlockVoeg").hide();
        $(".fiveBlockVoeg").hide();
        $(".sousBlockFourBlockVoeg1").hide();
        $(".sousBlockFourBlockVoeg2").hide();
        $(".sousBlockFourBlockVoeg3").hide();
        $(".firstBlockVoeg").show();
    });

    $("#boxVoeg1").click(function() {
        $(".firstBlockVoeg").hide();
        $(".secondBlockVoeg").show();
    });
    $("#boxVoeg2").click(function() {
        $(".firstBlockVoeg").hide();
        $(".treeBlockVoeg").show();
    });
    $("#boxVoeg3").click(function() {
        $(".firstBlockVoeg").hide();
        $(".fourBlockVoeg").show();
        $(".sousBlockFourBlockVoeg1").show();
    });
    $("#boxVoeg4").click(function() {
        $(".firstBlockVoeg").hide();
        $(".fiveBlockVoeg").show();
    });
    $("#volgende1").click(function() {
        $(".sousBlockFourBlockVoeg1").hide();
        $(".sousBlockFourBlockVoeg2").show();
    });
    $("#volgende2").click(function() {
        $(".sousBlockFourBlockVoeg1").hide();
        $(".sousBlockFourBlockVoeg2").hide();
        $(".sousBlockFourBlockVoeg3").show();
    });

    // fedback
    $(".buttonFeedback").click(function() {
        $("#FeedbackInput").hide();
    });
    $(".btf1").click(function() {
        $("#FeedbackInput").hide();
        $("#FeedbackInput1").Show();
    });


    for ( var i = 0; i < 21; i++ ) {
        $( ".btf" ).appendTo( document.body );
    }

    for ( var i = 0; i < 21; i++ ) {
        $( ".I-feddback" ).appendTo( document.body );
    }

    $( "div" ).click(function() {
        $(".FeedbackInput").hide();
        $("I-feddback").Show();
    });


    // début pour show more partie user profil passport

    $(document).ready(function() {
        if (height >= 162 ){
            $(".skills").addClass("cacher");
            $("#show-more1").show();

        } else {
            $(".skills").removeClass("cacher");
        }
        $("#show-more1").click(function() {
            $(".skills").removeClass("cacher");
            $("#show-more1").hide();
            $("#show-less1").show();
        });
        $("#show-less1").click(function() {
            $(".skills").addClass("cacher");
            $("#show-more1").show();
            $("#show-less1").hide();
        });
    });

    // fin pour show more partie user profil passport




    //  for block static page

    $(document).ready(function() {
        $(".btnMeerInformation").click(function() {
            $(".blockEducationIndividualPage").show();
            window.scrollTo(0, 200);
        });
    });





    // for page passport
    // Récup. éléments concernés
    var oBtns = $("[data-progress]");
    //Action au click
    oBtns.on("click", function() {
        var $this = $(this);
        var progress = $this.data("progress");
        var size = $this.data("value");
        $("#" + progress)
            .stop()
            .css({ width: 0 })
            .animate(
            { width: size + "%" },
            {
                duration: 2000,
                step: function(valeur, fx) {
                    var elem = $(fx.elem);
                    elem.text(parseInt(valeur, 10) + "%");
                }
            }
        );
    });
    // Déclenche l'animation
    oBtns.trigger("click");
    var height = $(".skills").height();

    // début code pour owl carousel

    $('.myCarouselTestimonial').owlCarousel({
        items: 2,
        addClassActive: true
    });

    // fin code pour owl carousel


    // début pour user profil settings preview img

    $('.file-input-img-choose').change(function(){
        var curElement = $('.imageChoose');
        console.log(curElement);
        var reader = new FileReader();

        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            curElement.attr('src', e.target.result);
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });

    // fin pour user profil settings preview img

    //sidbarELEMENT

    $(".btnSidbarMob").click(function() {
        $(".sidBarDashboard2").show();
        $(".btnSidbarMobCroix").show();
        $(".sidBarDashboardIndividual").show();
    });
    $(".btnSidbarMobCroix").click(function() {
        $(".sidBarDashboard2").hide();
        $(".btnSidbarMobCroix").hide();
        $(".sidBarDashboardIndividual").hide();
    });



    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }


    var select = $('#select');
    var selected = $('#selected');

    select.on('change', function(){
        var selectedOptionText = $(this).children(':selected').text();

        selected.text(selectedOptionText);
    });


    $(".js-select2").select2();
    $(".js-select2-multi").select2();

    $(".large").select2({
        dropdownCssClass: "big-drop",
    });

    //Form
    $("#Uitgebreide").hide();
    $("#Data").hide();
    $("#Details").hide();
    $("#VerderInformatie").click(function() {
        $("#Uitgebreide").show();
        $("#basis").hide();
        window.scrollTo(0, 0);

    });
    $("#VerderUitgebreide").click(function() {
        $("#Data").show();
        $("#basis").hide();
        $("#Uitgebreide").hide();
        window.scrollTo(0, 0);

    });
    $("#VerderData").click(function() {
        $("#Details").show();
        $("#Data").hide();
        window.scrollTo(0, 0);
    });

    $("#terugUitgebreide").click(function() {
        $("#basis").show();
        $("#Data").hide();
        $("#Uitgebreide").hide();
        window.scrollTo(0, 0);

    });
    $("#terugData").click(function() {
        $("#Uitgebreide").show();
        $("#Data").hide();
        $("#basis").hide();
        window.scrollTo(0, 0);

    });
    $("#terugDetails").click(function() {
        $("#Data").show();
        $("#Details").hide();
        window.scrollTo(0, 0);

    });

    function myFunction() {
        document.getElementById("autocomplete").classList.toggle("show");
    }

});
