<?php /** Template Name: Fetch data clean company */ ?>

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
    echo '<input type="hidden" name="complete" value="company">';
    
    ?>

    <div class="contentPageManager managerOverviewMensen">
        <div class="">
            <h4 class="titleBlockOverviewMensen">CREATE COMPANY</h4>
            <div class="">
                <br>
                <ul>
                    <div class="form-group"> <input type="text" class="form-control" name="company_title" placeholder="Company Title" required> </div>
                    <div class="form-group"> <input type="text" class="form-control" name="company_adress" placeholder="Company Adress"> </div>
                    <div class="form-group"> <input type="text" class="form-control" name="company_place" placeholder="Company Place"> </div>
                    <div class="form-group"> <input type="text" class="form-control" name="company_country" placeholder="Company Country" required> </div>
                </ul>
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
