<?php 
$user_in = wp_get_current_user();
?>

<div class="contentListeCourse">
    <div class="cardOverviewCours">
        <div class="headListeCourse">
            <p class="JouwOpleid">Jouw leerpaden</p>
            <?php 
                if ( in_array( 'manager', $user_in->roles ) || in_array('administrator', $user_in->roles)) 
                    echo '<a href="/dashboard/teacher/course-selection/" class="btnNewCourse">Nieuwe course</a>';
            ?>
        </div>
        <div class="contentCardListeCourse">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th scope="col">Titel</th>
                        <th scope="col">Leervorm</th>
                        <th scope="col">Prijs</th>
                        <th scope="col">Onderwerp(en)</th>
                        <th scope="col">Startdatum</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="textTh">Werkkamersessie 'acquireren is werven'</td>
                        <td class="textTh">Training</td>
                        <td class="textTh">€1750</td>
                        <td class="textTh elementOnder">Verkoop en sales</td>
                        <td class="textTh">12-09-2021</td>
                        <td class="textTh">Live</td>
                    </tr>
                    <tr>
                        <td class="textTh">Werkkamersessie 'acquireren is werven'</td>
                        <td class="textTh">Training</td>
                        <td class="textTh">€1750</td>
                        <td class="textTh elementOnder">Verkoop en sales</td>
                        <td class="textTh">12-09-2021</td>
                        <td class="textTh">Live</td>
                    </tr>
                    <tr>
                        <td class="textTh">Werkkamersessie 'acquireren is werven'</td>
                        <td class="textTh">Training</td>
                        <td class="textTh">€1750</td>
                        <td class="textTh elementOnder">Verkoop en sales</td>
                        <td class="textTh">12-09-2021</td>
                        <td class="textTh">Concept</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


