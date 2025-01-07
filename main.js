jQuery(function($) {

    // for menu large
    $("#burger-web").click(function() {
        $(".theme-side-menu").addClass("extensive");
    });
    // for menu large
    $("#burgerCroie-web").click(function() {
        $(".theme-side-menu").removeClass("extensive");
    });

    $("#burger-web").click(function() {
        $("#burgerCroie-web").show();
        $("#burger-web").hide();
    });

    $("#burgerCroie-web").click(function() {
        $("#burgerCroie-web").hide();
        $("#burger-web").show();
    });
    $(".btn-close-modal-search").click(function() {
        $(".dropdown-search").hide();
    });

    //variable for offline courses date input
    $('.block2evens').each(function() {
        console.log('enting for reservations done');
        var dateNameStart = $(this).find('input[data-attr="dateNameStart"]').val();
        $(this).find('.yith-wapo-option input').val(dateNameStart);
    });  

    $('#modalForApp .close').click(function() {
        $('#modalForApp').hide();
    });
    // script to show sidebar on mobile

/*  //  pour cokkies et modal

// Get the modal and the close icon element
    const modal = document.getElementById("modalForApp");
    const closeIcon = modal.querySelector(".close-button");

    // Check if cookie exists
    if (document.cookie.indexOf("modalShown") == -1) {
        // If cookie doesn't exist, show modal
        modal.style.display = "block";

        // Add event listener to close icon to set cookie and hide modal
        closeIcon.addEventListener("click", () => {
            modal.style.display = "none";

            // Set cookie with expiration time of 3 hours
            let d = new Date();
            d.setTime(d.getTime() + (3*60*60*1000)); // 3 hours in milliseconds
            let expires = "expires="+ d.toUTCString();
            document.cookie = "modalShown=true;" + expires + ";path=/";
        });
    }*/


    //scroll down
    $(function() {
        $('.bntStarted').click(function() {
            $('html, body').animate({ scrollTop: $('.blockFormDeveloper').offset().top }, 'slow');
            return false;
        });
    });

    //pour mobile
    $('.close-block').click(function (){
        $('.blockShowApp').hide();
        $('.navMobile').removeClass('navMobile-custom')
        $('body').removeClass('body-custom')
    });
    if ($('.navMobile').hasClass('navMobile-custom')) {
        // Ajoute la classe
        $('body').addClass('body-custom');
    }

    //header on scroll fix
    var height = ($('nav.navbar').css('height'));
    $('body').css('padding-top', height)

    $(".navModife4").click(function() {
        console.log('menu toggled');
        $(".dropdownMenuDashboard").toggle();

    });

    $(".hideBarFilterBlock").hide();
    // For filter

    $(".filterBlock").click(function() {
        $(".formFilterDatabank, .hideBarFilterBlock").show();
    });
    $(".hideBarFilterBlock").click(function() {
        $(".formFilterDatabank, .hideBarFilterBlock").hide();
    });
// for flow button
    $('.btnFollowSubTopic').click(function() {

        $(this).text(function(_, text) {
            return text === "Follow" ? "Unfollow" : "Follow";
        });
        if($(this).text() == "Follow") {
            $(this).removeClass('unfollow');
        } else if($(this).text() == "Unfollow") {
            $(this).addClass('unfollow');
        }
    });
    // for all select
    $('#all').change(function(e) {
        if (e.currentTarget.checked) {
            $('.rows').find('input[type="checkbox"]').prop('checked', true);
        } else {
            $('.rows').find('input[type="checkbox"]').prop('checked', false);
        }
    });
    $('#allExpert').change(function(e) {
        if (e.currentTarget.checked) {
            $('.rows2').find('input[type="checkbox"]').prop('checked', true);
        } else {
            $('.rows2').find('input[type="checkbox"]').prop('checked', false);
        }
    });

    $(".btnNext").click(function() {
        $(".content-topics").hide();
        $(".content-subTopics").show();
    });
    $("#backTopics").click(function() {
        $(".content-topics").show();
        $(".content-subTopics").hide();
    });


    $(document).on('hidden.bs.modal', '#bedrijfsprofiel_modal',function () {
        $('#bedrijfsprofiel_modal').css('overflowY','auto')
    });


    $(".bntNotification").click(function() {
        $(".alertNotification").hide();
    });


    // change view list or grid

    var elem=$('.block-new-card-course');
    $('.btn-group-layouts button').on('click',function(e) {
        if ($(this).hasClass('gridview')) {
            elem.fadeOut(250, function () {
                elem.removeClass('list').addClass('grid');
                elem.fadeIn(250);
            });
        }
        else if($(this).hasClass('listview')) {
            elem.fadeOut(250, function () {
                elem.removeClass('grid').addClass('list');
                elem.fadeIn(250);
            });
        }
    });
    $(".gridview").click(function() {
        $(".listview").removeClass("active");
        $(".gridview").addClass("active");
    });
    $(".listview").click(function() {
        $(".gridview").removeClass("active");
        $(".listview").addClass("active");
    });




  /*  const elements = document.querySelectorAll('.like-and-comment .element-like-and-comment');
    const blockComments = document.querySelectorAll('.like-and-comment .first-element');

    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', function() {
            for (let j = 0; j < blockComments.length; j++) {
                if (blockComments[j].classList.contains('show-comments')) {
                    blockComments[j].classList.remove('show-comments');
                }
            }
            blockComments[i].classList.toggle('show-comments');
        });
    }*/

    // Select all the buttons and content blocks
    var buttons = document.querySelectorAll('.element-like-and-comment');
    var contents = document.querySelectorAll('.first-element');

    $(document).ready(function() {
        $(buttons).click(function() {
            var target = $(this).data('target');
            $('#' + target).toggle();
        });
    });


    // for modal add to do
    $(".element-trigger").click(function() {
        var targetClass = $(this).data("target");
        $(".content-block-bg").hide();
        $(".modal-header").hide();
        $(".detail-content-modal").hide();
        $(".content-" + targetClass).show();
    });

    $(".btn-back-frist-element").click(function() {
        $(".content-block-bg").show();
        $(".modal-header").show();
        $(".detail-content-modal").hide();
    });

    $(".nav-three").click(function() {
        $("#All").addClass("active");
    });
    $(".nav-four").click(function() {
        $("#Badges").addClass("active");
    });
    $(".nav-feedback").click(function() {
        $("#AllFeddback").addClass("active");
    });

    //for close notification

    var buttonInsideModal = $(".buttonInsideModal");

    var modal = $("#ModalNotification");
    buttonInsideModal.click(function(event) {
        event.stopPropagation();
    });

    modal.click(function() {
    });




    // for modal skills passport home page
    $("#btnStep1SkillsPasspoort").click(function() {
        $(".step1SkillsPasspoort").hide();
        $(".step3SkillsPasspoort").hide();
        $(".step4SkillsPasspoort").hide();
        $(".step5SkillsPasspoort").hide();
        $(".step2SkillsPasspoort").show();
        $('#Vakgebied').addClass('colorStep');
    });
    $("#btnStep2SkillsPasspoort").click(function() {
        $(".step1SkillsPasspoort").hide();
        $(".step2SkillsPasspoort").hide();
        $(".step5SkillsPasspoort").hide();
        $(".step4SkillsPasspoort").hide();
        $(".step3SkillsPasspoort").show();
        $('#Locatie').addClass('colorStep');
    });
    $("#btnStep3SkillsPasspoort").click(function() {
        $(".step1SkillsPasspoort").hide();
        $(".step2SkillsPasspoort").hide();
        $(".step3SkillsPasspoort").hide();
        $(".step5SkillsPasspoort").hide();
        $(".step4SkillsPasspoort").show();
        $('#Leervorm').addClass('colorStep');
    });
    $("#btnStep4SkillsPasspoort").click(function() {
        $(".step1SkillsPasspoort").hide();
        $(".step2SkillsPasspoort").hide();
        $(".step3SkillsPasspoort").hide();
        $(".step4SkillsPasspoort").hide();
        $(".step5SkillsPasspoort").show();
        $('#Generatie').addClass('colorStep');
    });
    $("#btnStep5SkillsPasspoort").click(function() {
        $(".step1SkillsPasspoort").hide();
        $(".step2SkillsPasspoort").hide();
        $(".step3SkillsPasspoort").hide();
        $(".step4SkillsPasspoort").hide();
        $(".step5SkillsPasspoort").hide();
        $(".step6SkillsPasspoort").show();
        $('#Finish').addClass('colorStep');
    });

    $("#btnSkip").click(function() {
        $(".step1SkillsPasspoort").hide();
        $(".step2SkillsPasspoort").hide();
        $(".step3SkillsPasspoort").hide();
        $(".step4SkillsPasspoort").hide();
        $(".step5SkillsPasspoort").hide();
        $(".step6SkillsPasspoort").show();
        $('#Finish').addClass('colorStep');
        $('#Generatie').addClass('colorStep');
        $('#Leervorm').addClass('colorStep');
        $('#Locatie').addClass('colorStep');
        $('#Vakgebied').addClass('colorStep');
    });


    $("#btnTerug1SkillsPasspoort").click(function() {
        $(".step1SkillsPasspoort").show();
        $(".step2SkillsPasspoort").hide();
        $('#Vakgebied').removeClass('colorStep');
    });
    $("#btnTerug2SkillsPasspoort").click(function() {
        $(".step2SkillsPasspoort").show();
        $(".step3SkillsPasspoort").hide();
        $('#Locatie').removeClass('colorStep');
    });
    $("#btnTerug3SkillsPasspoort").click(function() {
        $(".step3SkillsPasspoort").show();
        $(".step4SkillsPasspoort").hide();
        $('#Leervorm').removeClass('colorStep');
    });
    $("#btnTerug4SkillsPasspoort").click(function() {
        $(".step4SkillsPasspoort").show();
        $(".step5SkillsPasspoort").hide();
        $('#Generatie').removeClass('colorStep');
    });
    $("#btnTerug5SkillsPasspoort").click(function() {
        $(".step5SkillsPasspoort").show();
        $(".step6SkillsPasspoort").hide();
        $('#Finish').removeClass('colorStep');
    });

    // clone section dashboard course step 3
    /* $('.wrapperClone').on('click', '.remove', function() {
        $('.remove').closest('.wrapperClone').find('.elementClone').not(':first').last().remove();

    });
    $('.wrapperClone').on('click', '.clone', function() {
        $('.clone').closest('.wrapperClone').find('.elementClone').first().clone().appendTo('.results');
    });*/

    // for tabs company

    $("#tab2").click(function() {
        $("#tab2").addClass('btnactive');
        $("#tab1").removeClass('btnactive');
        $("#tab2Content").show();
        $("#tab1Content").hide();
    });
    $("#tab1").click(function() {
        $("#tab1").addClass('btnactive');
        $("#tab2").removeClass('btnactive');
        $("#tab1Content").show();
        $("#tab2Content").hide();
    });

    /* Variables */
    var row = $(".attr");

    function addRow() {
        row.clone(true, true).appendTo(".results");
    }

    function removeRow(button) {
        button.closest("div.attr").remove();
    }

    $('#attributes .attr:first-child').find('.remove').hide();

    /* Doc ready */
    $(".add").on('click', function() {
        addRow();
        if ($("#attributes .attr").length > 1) {
            //alert("Can't remove row.");
            $(".remove").show();
        }
    });
    $(".remove").on('click', function() {
        if ($("#attributes .attr").size() == 1) {
            //alert("Can't remove row.");
            $(".remove").hide();
        } else {
            removeRow($(this));

            if ($("#attributes .attr").size() == 1) {
                $(".remove").hide();
            }

        }
    });

    // strat for print or doawnload certificat


    // end code for print or doawnload certificat



    $("#modalClose").click(function () {
        $("#theModal").modal("hide");
    });

    //close login popup
    $('.modal button.close').on('click', function(e) {
        e.preventDefault();
        $(this).closest('.modal').removeClass('show');
        console.log('close popup');
    })


    // clone section dashboard course step 3

    //variable for offline courses date input
    $('.block2evens').each(function() {
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

    $(".croie").click(function() {
        $(".headSousMobilePrincipale").hide();
        $(".burgerElement").show();
        $("#croieSearch").hide();
        $("#croieProfil").hide();
        $(".croie").toggle();
    });
    $(".btnRegistrerenInloggen").click(function() {
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

    $("#upBlock3").click(function() {
        $(".firstContentHeadSousMobile").show();
        $(".sousMenuBlock3").hide();
        $(".btnUp").hide();
    });

    $("#header-search").click(function() {
        $("#for-search-element").show();
        $(".activeModalHeader").show();
        $("#voorOpleidersModal").hide();
        $("#OpleidingenModal").hide();
        $("#OverOnsModal").hide();
        $("#voorOrganisatiModal").hide();
    });

    $("#voorOrganisati").click(function() {
        $("#voorOrganisatiModal").toggle();
        $(".activeModalHeader").show();
        $("#voorOpleidersModal").hide();
        $("#OpleidingenModal").hide();
        $("#OverOnsModal").hide();
        $("#for-search-element").hide();
    });

    $("#opleiders").click(function() {
        $("#voorOrganisatiModal").hide();
        $(".activeModalHeader").show();
        $("#voorOpleidersModal").toggle();
        $("#OpleidingenModal").hide();
        $("#OverOnsModal").hide();
        $("#for-search-element").hide();
    });

    $("#Opleidingen").click(function() {
        $("#voorOrganisatiModal").hide();
        $(".activeModalHeader").show();
        $("#voorOpleidersModal").hide();
        $("#OpleidingenModal").toggle();
        $("#OverOnsModal").hide();
        $("#for-search-element").hide();
    });

    $("#OverOns").click(function() {
        $("#voorOrganisatiModal").hide();
        $(".activeModalHeader").show();
        $("#voorOpleidersModal").hide();
        $("#OpleidingenModal").hide();
        $("#OverOnsModal").toggle();
        $("#for-search-element").hide();
    });

    $(".activeModalHeader").click(function() {
        $("#voorOrganisatiModal").hide();
        $("#voorOpleidersModal").hide();
        $("#OpleidingenModal").hide();
        $(".activeModalHeader").hide();
        $("#OverOnsModal").hide();
        $("#for-search-element").hide();
    });

    //Filter bar on category page
    $(".filterBlockMobil").click(function() {
        $(".sousProductTest").show();
    });
    $("#filterHideMobile").click(function() {
        $(".sousProductTest").hide();
    });


    $("#btn_favorite").click(function() {
        $(".like1").toggle();
        $(".like2").toggle();
    });

    $(".btn_dislike").click(function() {
        $(".btn_dislike").toggle();
        $(".btn_like").toggle();
    });
    $("#btn_like").click(function() {
        $("#btn_like").toggle();
        $("#btn_dislike").toggle();
    });

    $(".btn_like").hide(); //this hides the list initially


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

// for menu hamberger:

        $("#MijzelfBtn").click(function() {
            $("#1sub-block").show();
            $(".block-sous-nav-mobile").hide();
        });
        $(".go-back").click(function() {
            $("#1sub-block").hide();
            $(".block-sous-nav-mobile").show();
        });

        $("#teambtn").click(function() {
            $("#team-organisati-block").show();
            $(".block-sous-nav-mobile").hide();
        });
        $(".go-back").click(function() {
            $("#team-organisati-block").hide();
            $(".block-sous-nav-mobile").show();
        });

        $("#expertBtn").click(function() {
            $("#expert-sub-block").show();
            $(".block-sous-nav-mobile").hide();
        });
        $(".go-back").click(function() {
            $("#expert-sub-block").hide();
            $(".block-sous-nav-mobile").show();
        });

        $("#contactBtn").click(function() {
            $("#contact-sub-block").show();
            $(".block-sous-nav-mobile").hide();
        });
        $(".go-back").click(function() {
            $("#contact-sub-block").hide();
            $(".block-sous-nav-mobile").show();
        });

        $("#Groeien").click(function() {
            $("#2sub-block").show();
            $("#1sub-block").hide();
        });
        $(".go-back-2").click(function() {
            $("#2sub-block").hide();
            $("#1sub-block").show();
        });
        $("#Groeien-binnen").click(function() {
            $("#3sub-block").show();
            $("#1sub-block").hide();
        });
        $(".go-back-2").click(function() {
            $("#3sub-block").hide();
            $("#1sub-block").show();
        });
        $("#relevante-btn").click(function() {
            $("#4sub-block").show();
            $("#1sub-block").hide();
        });
        $(".go-back-2").click(function() {
            $("#4sub-block").hide();
            $("#1sub-block").show();
        });
        $("#Persoonlijke-btn").click(function() {
            $("#5sub-block").show();
            $("#1sub-block").hide();
        });
        $(".go-back-2").click(function() {
            $("#5sub-block").hide();
            $("#1sub-block").show();
        });


// end of menu hamberger


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
    $('.tab-content:first-child').show();

    // Click function
    $('#tabs-nav li').click(function() {
        $('#tabs-nav li').removeClass('active');
        $(this).addClass('active');
        $('.tab-content').hide();

        var activeTab = $(this).find('a').attr('href');
        $(activeTab).fadeIn();
        return false;
    });

    //focus

    $(function() {
        $("#inputSearchElementPath").focus(function() {
            $('.searchElementPath img').hide();
        });

        $("#inputSearchElementPath").focusout(function() {
            $('.searchElementPath img').show();
        });
    })


    // Pour first modal after login
    $(".btnBaangerichte").click(function() {

        $(".subtopicBaangerichte").show();
        let cl = $(this).attr('class').split(' ')[3];
        hidden = ($(".cb_topics_bangricht_" + cl).attr('hidden'));
        $(".cb_topics_bangricht_" + cl).attr('hidden', !hidden);

    });

    $(".btnFunctiegericht").click(function() {
        $(".subtopicFunctiegericht").show();
        let cl = $(this).attr('class').split(' ')[3];
        hidden = ($(".cb_topics_funct_" + cl).attr('hidden'));
        $(".cb_topics_funct_" + cl).attr('hidden', !hidden);
    });

    $(".btnSkills").click(function() {
        $(".subtopicSkills").show();
        let cl = $(this).attr('class').split(' ')[3];
        hidden = ($(".cb_topics_skills_" + cl).attr('hidden'));
        $(".cb_topics_skills_" + cl).attr('hidden', !hidden);
    });

    $(".btnPersonal").click(function() {
        $(".subtopicPersonal").show();
        let cl = $(this).attr('class').split(' ')[3];
        hidden = ($(".cb_topics_personal_" + cl).attr('hidden'));
        $(".cb_topics_personal_" + cl).attr('hidden', !hidden);
    });

    $("#nextblockBaangerichte, #btnSkipTopics1").click(function() {
        $(".blockfunctiegericht").show();
        $(".blockBaangerichte").hide();
    });

    $("#nextFunctiegericht, #btnSkipTopics2").click(function() {
        $(".blockSkills").show();
        $(".blockfunctiegericht").hide();
    });

    $("#nextSkills, #btnSkipTopics3").click(function() {
        $(".blockPersonal").show();
        $(".blockSkills").hide();
    });

    $("#btnSkipTopics4").click(function() {
        $(".blockPersonal").hide();
    });



    // Pour assessments  backend
    $("#btnStratModal1").click(function() {
        $("#secondBlockAssessmentsBackend").show();
        $(".contentAsessment").hide();

    });

    $("#btnStart2").click(function() {
        $("#step1OverviewAssessmentBackend").hide();
        $("#step2OverviewAssessmentBackend").show();
    });
    $("#btnStart3").click(function() {
        $("#step2OverviewAssessmentBackend").hide();
        $("#step3OverviewAssessmentBackend").show();
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
        $("#burger").show();
        $(".show-mobile-search-block").show();
        $("#croieSearch").show();
        $("#profilView").show();
       $("#for-search-element").addClass("show-mobile-search-block");
    });
    $("#croieSearch").click(function() {
        $("#searchIcone").show();
        $(".show-mobile-search-block").hide();
        $("#croieSearch").hide();
        $("#for-search-element").removeClass("show-mobile-search-block");
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


    for (var i = 0; i < 21; i++) {
        $(".btf").appendTo(document.body);
    }

    for (var i = 0; i < 21; i++) {
        $(".I-feddback").appendTo(document.body);
    }

    //    $( "div" ).click(function() {
    //        $(".FeedbackInput").hide();
    //        $("I-feddback").Show();
    //    });


    // début pour show more partie user profil passport

    $(document).ready(function() {
        if (height >= 162) {
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
            .animate({ width: size + "%" }, {
                duration: 2000,
                step: function(valeur, fx) {
                    var elem = $(fx.elem);
                    elem.text(parseInt(valeur, 10) + "%");
                }
            });
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

    $('.file-input-img-choose').change(function() {
        var curElement = $('.imageChoose');
        console.log(curElement);
        var reader = new FileReader();

        reader.onload = function(e) {
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

    select.on('change', function() {
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