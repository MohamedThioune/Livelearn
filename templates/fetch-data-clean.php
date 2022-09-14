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
        <div class="contentOverviewMensen">
            <div class="blockOverviewMensen">
                <h4 class="titleBlockOverviewMensen">CREATE EXPERT & COMPANY</h4>
                <div class="bodyBlockOverviewMensen">
                    <strong>Expert informations :</strong><br>
                    <ul>
                        <li> <input type="text" name="first_name" placeholder="Voornaam" required>       </li>
                        <li> <input type="text" name="last_name" placeholder="Achternaam" required>      </li>
                        <li> <input type="email" name="email" placeholder="ZaKelijk mailadres" required> </li>
                    </ul>
                    <strong>Company informations :</strong><br>
                    <ul>
                        <li> <input type="text" name="company_title" placeholder="Company Title" required> </li>
                        <li> <input type="text" name="company_adress" placeholder="Company Adress"> </li>
                        <li> <input type="text" name="company_place" placeholder="Company Place"> </li>
                        <li> <input type="text" name="company_country" placeholder="Company Country" required> </li>
                    </ul>
                </div>
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
