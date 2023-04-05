<?php wp_head(); ?>
<?php get_header(); ?>

<?php 
$users = get_users();

$user_connected = wp_get_current_user();
header('Location: /dashboard/company/');

$user_id = $user_connected->ID;

$company = get_field('company',  'user_' . $user_id );

$company_connected = $company[0]->post_title;
$company_id = $company[0]->ID;

$leerbudget = get_field('leerbudget', $company[0]->ID);
$zelfstand_max = get_field('zelfstand_max', $company[0]->ID);

$members = array();
$numbers = array();

$total_incomes  = 0;
$total_expenses = 0;

$orders = array();

$managed = get_field('managed',  'user_' . get_current_user_id());

foreach( $users as $user ) {
    $company = get_field('company',  'user_' . $user->ID);
    if ($company[0]->post_title == $company_connected)
    {
        array_push($numbers,$user->ID);

        //Expense by this user
        $args = array(
            'limit' => -1,
            'customer_id' => $user->ID,
            'post_status' => array('wc-processing'),
        );
        $orders = wc_get_orders($args);
        $expenses = 0;
        foreach($orders as $order){
            foreach ($order->get_items() as $item_id => $item ) {
                //Get woo orders from user
                $course_id = intval($item->get_product_id()) - 1;
                $prijs = get_field('price', $course_id);
                $expenses += $prijs; 
            }
        }
        $user->expenses = $expenses;

        $total_expenses += $user->expenses;
        
        //Income by this user
        $args = array(
            'limit' => -1,
            'post_status' => array('wc-processing'),
        );
        $bunch_orders = wc_get_orders($args);
        $incomes = 0; 
        foreach( $bunch_orders as $order ){
            foreach( $order->get_items() as $item_id => $item ) {
                $course_id = intval($item->get_product_id()) - 1;
                $course = get_post($course_id);
                $prijs = get_field('price', $course_id);
                if(isset($course->post_author))
                    if($course->post_author == $user->ID)
                        $incomes += $prijs;  
            }
        }
        $user->incomes = $incomes;

        $total_incomes += $user->incomes;

        if(in_array('administrator', $user_connected->roles) || in_array('hr', $user_connected->roles))
            array_push($members,$user);
        else
            if(in_array($user->id, $managed))
                array_push($members,$user);                      
    }
}

$budget_resterend = ($leerbudget + $total_incomes) - $total_expenses; 

$maandelijke = count($members) * 5;
?>

<style>
    .radius-custom {
        border-radius: 10px !important;
    }
</style>

<?php if(in_array('administrator', $user_connected->roles) || in_array('hr', $user_connected->roles) || in_array('manager', $user_connected->roles) ) { ?>
<div class="contentPageManager managerOverviewMensen">
    <?php if($_GET['message']) echo "<span class='alert alert-info'>" . $_GET['message'] . "</span>" ?>
    <div class="contentOverviewMensen d-flex justify-content-md-between bg-white justify-content-center p-2 radius-custom">
        <div class="h5 pt-2"><strong>Budget <?= $company_connected; ?></strong></div>
    </div>

    <div class="contentOverviewMensen mt-4">

        <div class="col-md-3 col-12 px-1  px-md-0 ">
            <div class="card mb-3 radius-custom" style="height: 125px;">
                <div class="card-body">
                    <p class="card-text text-center"><strong>Maandelijkse kosten</strong> </p>
                    <h5 class="card-title text-center"> <strong>€ <?= $maandelijke ?></strong> </h5>
                    
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12 px-1 px-md-2  pr-md-0">
            <div class="card mb-3 radius-custom" style="height: 125px;">
                <div class="card-body">
                    <p class="card-text text-center"> <strong>Inkomsten verkochte kennisproducten</strong> <!-- Sale courses --> </p>
                    <h5 class="card-title text-center"> <strong>€ <?= $total_incomes; ?></strong></h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12 px-1 px-md-2">
            <div class="card mb-3 radius-custom" style="height: 125px;">
                <div class="card-body">
                    <p class="card-text text-center"> <strong>Uitgaven Opleidingen</strong> <!-- Purchased courses --> </p>
                    <h5 class="card-title text-center"><strong>€ <?= $total_expenses; ?></strong></h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12 px-1  px-md-0">
            <div class="card mb-3 radius-custom" style="height: 125px;">
                <div class="card-body">
                    <p class="card-text text-center"> <strong>Budget resterend</strong> <!-- Remaining courses --> </p>
                    <h5 class="card-title text-center"><strong>€ <?= $budget_resterend; ?></strong></h5>
                </div>
            </div>
        </div>

        <!-- <div class="card">
                 <div class="card-body">
                     <h5 class="card-title">Card title</h5>
                     <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                     <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                 </div>
                 <img src="..." class="card-img-bottom" alt="...">
             </div> -->

    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="bg-white p-2 radius-custom" id="div_table" style="display:block" >
                        <!-- <div class="h5 pt-2"><strong>Buget Livelearn team</strong></div> -->
                        <div class="d-flex justify-content-between w-100 border-bottom border-5 pb-2">
                            <div class="h5 pt-2">Budget <strong><?= $company_connected; ?></strong></div>
                            <button type="button" class="btn-close bg-danger border-0 text-white fa-2x rounded border-3" data-bs-dismiss="modal" aria-label="Close">X</button>
                        </div>

                        <form method="POST">
                            <input type="hidden" name="company_id" value="<?= $company_id; ?>">

                            <div class="form-group py-4">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">
                                            <strong class="h5">Leerbudget</strong></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" name="leerbudget" value="<?= $leerbudget; ?>" class="form-control border-0" id="inputPassword" placeholder="" style="background: #E0EFF4">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">
                                            <strong class="h5">Zelfstand Maximum</strong></label>
                                    </div>
                                    <div class="col-md-9 pt-2">
                                        <input type="number" name="zelfstand_max" value="<?= $zelfstand_max; ?>" class="form-control border-0" id="inputPassword" placeholder="" style="background: #E0EFF4">
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                                <button class="btn text-white" style="background: #00A89D" name="define_budget"><strong>Naar bedrijfsniveau</strong></button>
                            </div>

                        </form>

                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
        </div>
    </div>


    <div class="bg-white mt-5 p-2 radius-custom mx-4 mx-md-0 mb-4" id="div_table" style="display:block" >

        <div class="d-flex justify-content-between w-100 border-bottom border-5 pb-2">
            <div class="h5 pt-2"><strong>Budget <?= $company_connected; ?></strong></div>
            <div>
                <?php
                if(in_array('hr', $user_connected->roles))
                {
                    ?>
                    <!-- Button trigger modal -->
                    <button class="btn text-white" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background: #00A89D">
                        <strong>Naar bedrijfsniveau</strong>
                    </button>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Naam</th>
                    <th scope="col">Maandelijkse kosten</th>
                    <th scope="col">Uitgaven Opleiding</th>
                    <th scope="col">Opbrengsten kennisproducten</th>
                    <th scope="col">Persoongebonden budget</th>
                    <th scope="col">Budget resterend</th>
                    <th scope="col">Optie</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($members as $key=>$member){
                    $amount_budget = get_field('amount_budget', 'user_' . $member->ID) ? : 0;
                    $amount_budget += 5; 
                    ?>
                    <tr>
                        <th scope="row"><?= $key; ?></th>
                        <td><?= $member->data->display_name; ?></td>
                        <td><?= $amount_budget ?></td> <!-- cost by this user 'const' -->
                        <td>€ <?= $member->expenses ?></td> <!-- expense by this user 'var' -->
                        <td>€ <?= $member->incomes ?></td> <!-- income by this user 'var' -->
                        <td>€ <?= $zelfstand_max ?> </td> <!-- personal budget by this user 'var' -->
                        <td>€ <?php echo (($zelfstand_max + $member->incomes) - $member->expenses); ?></td> <!-- budget remaining by this user 'var' -->
                        <td>
                            <div class="dropdown text-white">
                                <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                    <img  style="width:20px"
                                          src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                </p>
                                <ul class="dropdown-menu">
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="#">Bekijk</a></li>
                                    <li class="my-2" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-gear px-2"></i><a href="#">Pas aan</a></li>
                                    <li class="my-1"><i class="fa fa-trash px-2"></i><a href="#" class="text-danger">Verwijder</a></li>
                                </ul>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade modal-Budget" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center">Give your team a personal learning budget</h5>
                                        </div>
                                        <h6 class="manager-name">To: Daniel </h6>
                                        <div class="modal-body">
                                            <form action="">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Leerbudget</label>
                                                    <input type="number" class="form-control" placeholder="Amount €">
                                                </div>
                                                <button type="button" class="btn btn-add-budget">Add</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="form_div" style="display:none">

        <div class="row d-flex justify-content-center">
            <div class="col-md-7 col-12 m-">
                <div class="bg-white mt-5 p-2 radius-custom mx-4 mx-md-5" id="div_table" style="display:block" >
                    <!-- <div class="h5 pt-2"><strong>Buget Livelearn team</strong></div> -->
                    <div class="d-flex justify-content-between w-100 border-bottom border-5 pb-2">
                        <div class="h5 pt-2"><strong>Buget Livelearn team</strong></div>
                    </div>

                    <form class="">

                        <div class="form-group py-4">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">
                                        <strong class="h5">Leerbudget</strong></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="number" class="form-control border-0" id="inputPassword" placeholder=""
                                           style="background: #E0EFF4">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">
                                        <strong class="h5">Zelfstand Maximum</strong></label>
                                </div>
                                <div class="col-md-9 pt-2">
                                    <input type="number" class="form-control border-0" id="inputPassword"
                                           placeholder="" style="background: #E0EFF4">
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center">
                            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                            <button class="btn text-white" style="background: #00A89D"><strong>Naar bedrijfsniveau</strong></button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


</div>
<?php } ?>



