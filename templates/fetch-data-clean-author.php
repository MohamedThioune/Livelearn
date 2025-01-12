<?php /** Template Name: Fetch data clean author */ ?>

<?php

global $wpdb;

$table = $wpdb->prefix . 'databank';

extract($_POST);

if ( isset($id) ) {

    $input = 'id';
    $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE id = %d", $id);

    $course = $wpdb->get_results( $sql )[0];

    /*
    * * Display forms w/ correct elements
    */

    echo '<input type="hidden" name="id" value="' . $course->id . '">';
    echo '<input type="hidden" name="complete" value="expert">';
    
    ?>

    <div class="contentPageManager managerOverviewMensen">
        <div class="">
            <h4 class="titleBlockOverviewMensen">CREATE EXPERT</h4>
            <div class="">
                <div class="form-group">  <input type="text" class="form-control" name="first_name" placeholder="Voornaam" required>       </div>
                <div class="form-group"> <input type="text" class="form-control" name="last_name" placeholder="Achternaam" required>      </div>
                <div class="form-group">  <input type="email" class="form-control" name="email" placeholder="ZaKelijk mailadres" required> </div>
            </div>
        </div>
    </div>
    
    <?php

}

/*
* *Closing forms
*/

?>


<script id="rendered-js" >
$(document).ready(function () {
    //Select2
    $(".multipleSelect2").select2({
        placeholder: "Maak uw keuze.",
         //placeholder
    });
});
//# sourceURL=pen.js
</script>    
