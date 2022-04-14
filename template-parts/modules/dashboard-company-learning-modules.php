<?php

$user_connected = get_current_user_id();
$company_connected = get_field('company',  'user_' . $user_connected);
$users_companie = array();

$users = get_users();

foreach($users as $user) {
    $company_user = get_field('company',  'user_' . $user->ID);
    if(!empty($company_connected) && !empty($company_user))
        if($company_user[0]->post_title == $company_connected[0]->post_title)
            array_push($users_companie,$user->ID);
}

$args = array(
    'post_type' => 'course', 
    'posts_per_page' => -1,
    'author__in' => $users_companie,  
);

$courses = get_posts($args);

$user_in = wp_get_current_user();




//bought courses
$order_args = array(
    'customer_id' => get_current_user_id(),
    'post_status' => array_keys(wc_get_order_statuses()), 'post_status' => array('wc-processing'),

);
$orders = wc_get_orders($order_args);

var_dump($orders);

?>
<style>
    body {
        padding-top: 0px !important;
    }

    .ftco-section {
		padding: 1em 0; }


		.heading-section {
		font-size: 28px;
		color: #000; }


		.select2-container {
		min-width: 450px; }
	    @media (max-width: 991.98px) {
			.select2-container {
			min-width: 100%; } }

		.select2-results__option {
		padding-right: 20px;
		vertical-align: middle; }

	    .select2-results__option:before {
            content: "";
            display: inline-block;
            position: relative;
            height: 20px;
            width: 20px;
            border: 2px solid rgba(0, 0, 0, 0.2);
            border-radius: 4px;
            background-color: transparent;
            margin-right: 15px;
            margin-left: 10px;
            vertical-align: middle; }

        .select2-results__option[aria-selected=true]:before {
            font-family: 'fontAwesome';
            content: "\f00c";
            color: #fff;
            background-color: #023356;
            border: 0;
            display: inline-block;
            padding: 0;
            line-height: 1.2;
            padding-left: 2px; 
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #fff; 
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #fff;
            color: #000; 
        }

	.select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
	border-radius: 4px;
	-webkit-box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.8);
	-moz-box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.8);
	box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.8); }

	.select2-container--default.select2-container--focus .select2-selection--multiple {
	border-color: #fd5f00;
	border-width: 2px; }

	.select2-container--default .select2-selection--multiple {
	border-width: 2px;
	border-color: transparent;
	padding: 5px 10px;
	line-height: 1.6;
	-webkit-transition: 0.3s;
	-o-transition: 0.3s;
	transition: 0.3s;
	margin-bottom: 10px;
	-webkit-box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.63);
	-moz-box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.63);
	box-shadow: 0px 3px 22px -15px rgba(0, 0, 0, 0.63); }
	@media (prefers-reduced-motion: reduce) {
		.select2-container--default .select2-selection--multiple {
		-webkit-transition: none;
		-o-transition: none;
		transition: none; 
        /* margin-bottom: 36px;  */
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
	color: gray; }

	.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
	margin-right: 5px; }

	.select2-container--default .select2-selection--multiple .select2-selection__clear {
	color: #fd5f00; }
</style>

<!--Link apply -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">




<div class="contentListeCourse">
    <div class="cardOverviewCours">
        <div class="headListeCourse">
            <p class="JouwOpleid">Gekochte opleidingen</p>
<!--            <a href="/dashboard/teacher/course-selection/" class="btnNewCourse">Nieuwe course</a>-->
        </div>

        <div class="contentCardListeCourse">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th scope="col">Aangekocht</th>
                        <th scope="col">Ordernummer</th>
                        <th scope="col">Datum van aanschaf</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

    foreach($orders as $order){        

                    ?>
                    <tr>
                        <td class="textTh"><a href="/dashboard/company/assign/?payment_id=<?php echo $order->get_id();?>">Openen</a></td>
                        <td class="textTh">Order <?php echo $order->get_id();?></td>
                        <td class="textTh"><?php echo $order->get_date_paid();?></td>
                        <td class="textTh"><?php echo $order->get_status();?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>



<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button> -->


		
    <div class="cardOverviewCours">
        <div class="headListeCourse">
            <p class="JouwOpleid">Jouw opleidingen</p>
            <?php 
                if ( in_array( 'manager', $user_in->roles ) || in_array('administrator', $user_in->roles)) 
                    echo '<a href="/dashboard/teacher/course-selection/" class="btnNewCourse">Nieuwe course</a>';
            ?>
        </div>

        <div class="contentCardListeCourse">
            <table class="table table-responsive" id="table">
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
                    <?php 
                    foreach($courses as $course){
                        /*
                            * Categories
                            */
                        $day = "<p><i class='fas fa-calendar-week'></i></p>";
                        $month = ' ';

                        $category = ' ';

                        $tree = get_the_terms($course->ID, 'course_category'); 

                        if($tree)
                            if(isset($tree[2]))
                                $category = $tree[2]->name;

                        $category_id = 0;

                        if($category == ' '){
                            $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                            if($category_id != 0)
                                $category = (String)get_the_category_by_ID($category_id);
                        }

                        $location = ' ';

                        $data = get_field('data_locaties', $course->ID);
                        if($data){
                            $date = $data[0]['data'][0]['start_date'];
                            if($date != ""){
                                $day = explode(' ', $date)[0];
                            }
                        }else{
                            $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                            $date = $data[0];
                            $day = explode(' ', $date)[0];
                        }

                        /*
                            * Price
                            */
                        $p = get_field('price', $course->ID);
                        if($p != "0")
                            $price =  number_format($p, 2, '.', ',');
                        else
                            $price = 'Gratis';

                        // Course type
                        $course_type = get_field('course_type', $course->ID) 

                    ?>
                    <tr  >
                        <td class="textTh"><a style="color:#212529;" href="<?php echo get_permalink($course->ID) ?>"><?php echo $course->post_title; ?></a></td>
                        <td class="textTh"><?php echo $course_type; ?></td>
                        <td class="textTh"><?php echo $price; ?></td>
                        <!-- <td class="textTh" data-toggle="modal" data-target="#exampleModal"><?php echo $category; ?></td> -->
                        <td class="textTh" data-toggle="modal" data-target="#exampleModal">
                            <?php echo $category; ?> 
                            <p id="result"></p>             
                        </td>
                        <td class="textTh"><?php echo $day; ?></td>
                        <td class="textTh" id="live">Live</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<script src="js/main.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <section class="ftco-section">
            <p id="result"></p>
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-4 d-flex justify-content-center align-items-center">
                        <select class="js-select2" id="sel" multiple="multiple">
                            <option value="substopic1" data-badge="">Option1</option>
                            <option value="substopic2" data-badge="">Option2</option>
                            <option value="substopic3" data-badge="">Option3</option>
                            <option value="substopic4" data-badge="">Option4</option>
                            <option value="substopic5" data-badge="">Option5</option>
                            <option value="substopic6" data-badge="">Option6</option>
                            <option value="substopic7" data-badge="">Option7</option>
                            <option value="substopic8" data-badge="">Option8</option>
                            <option value="substopic9" data-badge="">Option9</option>
                            <option value="substopic10" data-badge="">Option10</option>
                            <option value="substopic11" data-badge="">Option11</option>
                            <option value="substopic12" data-badge="">Option12</option>
                            <option value="substopic13" data-badge="">Option13</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="text-center">
                <button class="btn text-white"  style="background: #023356;"
                onclick="listboxresult();">Save</button>
            </div>

        </section>
                    
      </div>
    </div>
  </div>
</div>

<script>

     function listboxresult() {

         var spanresult = document.getElementById("result");
         spanresult.value=""
         var x = document.getElementById("sel");

         for (let index = 0; index < x.options.length; index++) {
             if (x.options[index].selected === true) {
                 spanresult.value += x.options[index].value + ", ";
                 document.getElementById("result").innerHTML = spanresult.value;
                 document.getElementById("result").style.color = "gray";
             }
         }
         if (document.getElementById("result").value == "") {
            document.getElementById("result").innerHTML = "";
            // document.getElementById("result").style.color = "red";
         }
         
     }


     (function($) {

        "use strict";
        $(".js-select2").select2({
            closeOnSelect : false,
            placeholder : "Click to select an option",
            allowHtml: true,
            allowClear: true,
            tags: true // создает новые опции на лету
        });
        $('.icons_select2').select2({
            width: "100%",
            templateSelection: iformat,
            templateResult: iformat,
            allowHtml: true,
            placeholder: "Click to select an option",
            dropdownParent: $( '.select-icon' ),//обавили класс
            allowClear: true,
            multiple: false
        });

        document.getElementById("p1").innerHTML = originalOption;

        function iformat(icon, badge,) {
            var originalOption = icon.element;
            var originalOptionBadge = $(originalOption).data('badge');

            return $('<span><i class="fa ' + $(originalOption).data('icon') + '"></i> ' + icon.text + '<span class="badge">' + originalOptionBadge + '</span></span>');
        }

    })(jQuery);

</script>

<script>

// var table = $('#table').DataTable();
 
// $('#table tbody').on( 'click', 'tr', function () {
//     alert('document.getElementById("table").rows[2].innerHTML');
// } );

    // var table = document.getElementById("table"),rIndex,cIndex;
            
    // table rows
    // for(var i = 1; i < table.rows.length; i++)
    // {
    //     // row cells
    //     for(var j = 0; j < table.rows[i].cells.length; j++)
    //     {
    //         table.rows[i].cells[j].onclick = function()
    //         {
    //             rIndex = this.parentElement.rowIndex;
    //             cIndex = this.cellIndex+1;
    //             // console.log("Row : "+rIndex+" , Cell : "+cIndex);
    //             alert(document.getElementById("table").rows[rIndex].innerHTML);
    //         };
    //     }
    // }
    
</script>