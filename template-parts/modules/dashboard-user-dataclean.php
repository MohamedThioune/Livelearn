<?php
 //$sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE some_column = %s", $value );

 global $wpdb;

 $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank");

 $courses = $wpdb->get_results( $sql );

 $user = wp_get_current_user();


?>
<!-- modal-style -->

<style>
    body {
        padding-top: 0px !important;
    }

    /* modal on dashboard-learning-modules */
    @media (max-width: 991.98px) {
        .select2-container {
        min-width: 100%; } }

    .select2-results__option {
    padding-right: 20px;
    vertical-align: middle; }
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #fff; 
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #fd5f00;
    border-width: 2px; }

    .select2-container--default .select2-selection--multiple {
    border: none !important;
    background: #E7F8FF !important;
    border-radius: 10px !important;
    padding: 5px 10px;
    line-height: 1.6;
    -webkit-transition: 0.3s;
    -o-transition: 0.3s;
    transition: 0.3s;
    margin-bottom: 10px;
    }
    @media (prefers-reduced-motion: reduce) {
    .select2-container--default .select2-selection--multiple {
    -webkit-transition: none;
    -o-transition: none;
    transition: none; 
    } }

    .select2-container--open .select2-dropdown--below {
    padding: 10px 0;
    border-radius: 4px;
    margin-top: 25px;
    border: none;
    -webkit-box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.63);
    -moz-box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.63);
    box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.63); }

    .select2-selection .select2-selection--multiple:after {
    content: 'hhghgh'; }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
    border: none;
    background: rgba(0, 0, 0, 0.1);
    font-size: 15px;
    padding: 2px 10px;
    color: black; }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    margin-right: 5px; }

    .select2-container--default .select2-selection--multiple .select2-selection__clear {
    color: #fd5f00; }

     /* modal design width */
    .modal-content-width {
        width: 43% !important;
    }
    @media all and (max-width: 400px) {
    .modal-content-width {
        width: 90% !important;
        }
    }

</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">

<?php

?>

<!-- Content -->
<div class="contentListeCourse">
    <div class="cardOverviewCours">
        <div class="headListeCourse">
            <p class="JouwOpleid">Alle opleidingen</p>
            <input type="search" class="searchInputAlle" placeholder="Zoek opleidingen, experts of ondervwerpen">
        </div>
        <div class="contentCardListeCourse">
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Titel</th>
                    <th scope="col">Type</th>
                    <th scope="col">Prijs</th>
                    <th scope="col">Prijs VAT</th>
                    <th scope="col">Onderwerp(en)</th>
                    <!-- <th scope="col">Startdatum</th> -->
                    <th scope="col">Status</th>
                    <th scope="col">Optie</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($courses as $course){

                    ?>
                    <tr>
                        <td class="textTh"> <img src="<?= $course->image_xml; ?>" alt="image course" width="50" height="50"> </td>
                        <td class="textTh "><a style="color:#212529;font-weight:bold" href="<?= get_permalink($course->course_id) ?>"><?php echo $course->titel; ?></a></td>
                        <td class="textTh"><?= $course->type; ?></td>
                        <td class="textTh"><?= $course->prijs; ?></td>
                        <td class="textTh"><?= $course->prijs_vat; ?></td>
                        <td class="textTh"><?= $course->onderwerpen; ?></td>
                        <td class="textTh"><?= $course->status; ?></td>
                        <td class="textTh"> <button> ✔️ </button>&nbsp;&nbsp;<button> ❌ </button> </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">

           <!-- Modal content -->
       
            <!-- <div id="modal-content"> -->
           
            <div class="modal-content modal-content-width m-auto " style="margin-top: 100px !important">
                <div class="modal-header mx-4">
                    <h5 class="modal-title" id="exampleModalLabel">Subtopics </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('myModal').style.display='none'" >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="row d-flex text-center justify-content-center align-items-center h-50">
                    <div class="col-md-11  p-4">
                        <div class="form-group display-subtopics">
                        
                        </div> 
                        <div id="modal-content">

                        </div>
                        <div class="d-flex justify-content-end">
                            <button id="save_subtopics" type="button" class="btn text-white" style="background: #023356;">
                             <strong>Save</strong> </button>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
          </div>
           

       </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

<!-- script-modal -->
<script>
    var id_course;
    $('.td_subtopics').click((e)=>{
        id_course = e.target.id;
     $.ajax({
            url:"/fetch-subtopics-course",
            method:"post",
            data:
            {
                id_course:id_course,
                action:'get_course_subtopics'
            },
        dataType:"text",
        success: function(data){
            // Get the modal
            //console.log(data)
    var modal = document.getElementById("myModal");
    $('.display-subtopics').html(data)
    // Get the button that opens the modal
    
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    
    // When the user clicks on the button, open the modal
    
        modal.style.display = "block";
    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
        modal.style.display = "none";
        }
    }
            
            
        }
    });
});
    
  $('#save_subtopics').click(()=>{
      var subtopics = $('#selected_subtopics').val()
      $.ajax({
  url:"/fetch-subtopics-course",
  method:"post",
  data:
    {
      add_subtopics:subtopics,
      id_course:id_course,
      action:'add_subtopics'
    },
  dataType:"text",
  success: function(data){
      
      let modal=$('#myModal');
      modal.attr('style', { display: "none" });
      //modal.style.display = "none";
      $('#'+id_course).html(data)
      //console.log(data)
  }
  })
});
</script>  

    
