<?php /** Template Name: Databank */ ?>

<?php

global $wpdb;

$sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank ORDER BY id DESC");
$courses = $wpdb->get_results( $sql );
$user = wp_get_current_user();

?>

<?php wp_head(); ?>
<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Content -->
<body>

   <div class="container-fluid">
       <div class="contentListeCourseDataBank">
           <div class="cardOverviewCours">
               <div class="headListeCourse">
                   <p class="JouwOpleid"> <!-- Alle opleidingen --> <strong>Load From</strong> : &nbsp;
                       <a href="/youtube-v3-playlist" target="_blank"  class="JouwOpleid youtubeCourse"><img  src="<?= get_stylesheet_directory_uri(); ?>/img/youtube.png" alt="youtube image"></a>
                       &nbsp;&nbsp;<a href="/xml-parse" target="_blank"  class="JouwOpleid youtubeCourse" style="border: #FF802B solid;"><img style="" width="25" src="<?= get_stylesheet_directory_uri(); ?>/img/xml-orange.jpg" alt="xml image"></a>
                       &nbsp;&nbsp;<span id="reload-data"  class="bi bi-arrow-clockwise">Artikel</span>
                   <div hidden="true" id="loader" style="display:inline-block;" class="spinner-border spinner-border-sm text-primary" role="status">
                   </div>
                   </p>

                   <div class="inpustSearchDataBank">
                       <input type="search" class="searchInputAlle" placeholder="Zoek opleidingen, experts of ondervwerpen">
                       <button class="btn btnSearchCourseDatabank">
                           <img  src="<?= get_stylesheet_directory_uri(); ?>/img/searchM.png" alt="youtube image">
                       </button>
                   </div>
               </div>
               <div class="contentCardListeCourse">
                   <table class="table table-responsive">
                       <thead>
                       <tr>
                           <th scope="col">Image</th>
                           <th scope="col">Titel</th>
                           <th scope="col">Type</th>
                           <th scope="col">Prijs</th>
                           <th scope="col">Onderwerp(en)</th>
                           <th scope="col">Status</th>
                           <th scope="col">Author</th>
                           <th scope="col">Company</th>
                           <th scope="col" class="tdCenter">Optie</th>
                       </tr>
                       </thead>
                       <tbody>
                       <?php
                       foreach($courses as $course){
                           if($course->state)
                               continue;

                           //Author Image
                           $image_author = get_field('profile_img',  'user_' . $course->author_id);
                           $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';

                           //Company
                           $company = get_field('company',  'user_' . $course->author_id);
                           $company_logo = (!empty($company)) ? get_field('company_logo', $company[0]->ID) : get_stylesheet_directory_uri() . '/img/placeholder.png'; 

                           $onderwerpen = array();
                           //Onderwerpen
                           if($course->onderwerpen != "")
                                $onderwerpen = explode(',', $course->onderwerpen);
                           
                           $state = $course->course_id ? 'present' : 'missing';
                           $key = $course->id;
                           ?>
                           <tr id="<?= $key ?>" class="<?= $state ?>">
                               <td class="textTh"> <img src="<?= $course->image_xml; ?>" alt="image course" width="50" height="50"></td>
                               <td class="textTh courseDataBank" style="color:#212529;font-weight:bold"><?php echo $course->titel; ?></td>
                               <td class="textTh tdCenter"><?= $course->type; ?></td>
                               <td class="textTh tdCenter"><?= $course->prijs; ?></td>
                               <td class="textTh courseOnderwerpen">
                                   <?php
                                    if(!empty($onderwerpen))
                                        foreach($onderwerpen as $value)
                                            if($value)
                                            echo (String)get_the_category_by_ID($value) . ','; 
                                    ?>
                                </td>
                               <td class="textTh tdCenter"><?= $course->status; ?></td>
                               <td class="textTh tdCenter"> <?php if($course->author_id) echo '<img src="' .$image_author. '" alt="image course" width="25" height="25">'; else echo 'No author'; ?></td>
                               <td class="textTh tdCenter"> <?php if(!empty($company)) echo '<img src="' .$company_logo. '" alt="image course" width="25" height="25">'; else echo 'No company'; ?> </td>
                               <td class="tdCenter textThBorder"> <input type="button" class="optie btn-default" id="accept" style="background:white; border: DEE2E6" value="✔️" />&nbsp;&nbsp;<input type="button" class="optie btn-default" id="decline" style="background:white" value="❌" />&nbsp;&nbsp; <a href="/edit-databank?id=<?= $key ?>" class="btn-default" target="_blank"  style="background:white" >⚙️</a> </td>
                           </tr>
                       <?php
                       }
                       ?>
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
   </div>

   <div id="myModal" class="modal">
        <div class="modal-content modal-content-width m-auto " style="margin-top: 100px !important">
            <div class="modal-header mx-4">
                <h5 class="modal-title" id="exampleModalLabel">Content</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('myModal').style.display='none'" >
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="row d-flex text-center justify-content-center align-items-center h-50">
                <div class="col-md-11  p-4">
                    <form action='/dashboard/user/' method='POST'>
                    <div class="form-group display-fields-clean">
                    </div> 
                    <div id="modal-content">
                            
                    </div>
                    <center><input type='submit' class='btn text-white' name='databank' value='Update' style='background: #023356; border: none;'/></center>
                    <div class="d-flex justify-content-end">
                    </div>
                    </form>

                </div>
            </div>
        </div>
   </div> 
   
<?php get_footer(); ?>
<?php wp_footer(); ?>


<script>
            
            

    $('#reload-data').click(function(){
        
        $.ajax({
            url: '/scrapping',
            type: 'POST',
            data: {
                'action': 'reload_data'
            },
            beforeSend:function(){
                $('#reload-data').hide()
                $('#loader').attr('hidden',false)
            },
            complete: function(){},
            success: function(data){
                $('#reload-data').show()
                $('#loader').attr('hidden',true)
                console.log(data);
                //location.reload();
            }
        });
        //location.reload();
    });

    $('.optie').click((e)=>{
        var tr_element = e.target.parentElement.closest("tr");
        var ids = tr_element.id;
        var classs = tr_element.className;

        var optie = e.target.id;

        if(confirm('Are you sure you want to apply this record ?'))
        {
            $.ajax({
               url: '/optie-bank',
               type: 'POST',
               data: {
                   id: ids,
                   optie: optie,
                   class: classs,
                },
               error: function() {
                  alert('Something is wrong');
               },
               success: function(data) {
                    $("#"+ids).remove();
                    console.log(data);
                    alert("Record applied successfully");  
               }
            });
        }
        
    });

    $('.textTh').click((e)=>{
        var tr_element = e.target.parentElement.closest("tr");
        var key = tr_element.id;

        $.ajax({
                url:"/fetch-data-clean",
                method:"post",
                data:
                {
                    id:key,
                },
                dataType:"text",
                success: function(data){
                    // Get the modal
                    console.log(data)
                    var modal = document.getElementById("myModal");
                    $('.display-fields-clean').html(data)
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
    
</script>  



