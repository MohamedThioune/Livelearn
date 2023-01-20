<?php
    $abonnement_date_created = $abonnement['date_created'];

    $abonnement_date_created = explode('T',$abonnement_date_created);
?>
<div class="contentProfil ">

    <h1 class="titleSubscription">Subscription</h1>
    <div class="contentFormSubscription">
        <div class="w-100 text-center">
            <img class="gif-subscription" src="<?php echo get_stylesheet_directory_uri();?>/img/success.gif" alt="gif-subscription">
        </div>
        <h2>Your order is complete and had been confirmed</h2>
        <div class="head-content-subscription">
            <div class="detail">
                <div class="element-detail">
                    <p class="subtitel-detail">Team <b>x <?= $team ?></b></p>
                    <p class="product-detail"> <?= $team * 5 ?> euros</p>
                </div>
                <div class="element-detail">
                    <p class="subtitel-detail">Last order payment</p>
                    <!-- <p class="product-detail">March 18, 2023</p> -->
                    <p class="product-detail"><?= $abonnement_date_created[0] ?></p>
                </div>
                <div class="element-detail">
                    <p class="subtitel-detail">Next payment</p>
                    <p class="product-detail">xxxx</p>
                </div>
            </div>
            <?php 
                $sub_total = $team * 5;
                $tva = $sub_total * (20/100);
                $total = $sub_total + $tva;
            ?>
            <div class="detail-cart">
                <div class="element-detail-cart">
                    <p class="item">Subtotal</p>
                    <p class="price-subscription"><?= $sub_total ?> euros</p>
                </div>
                <div class="element-detail-cart">
                    <p class="item">Tva</p>
                    <p class="price-subscription"><?= $tva ?> euros</p>
                </div>
                <div class="element-detail-cart">
                    <p class="item-total"><b>Total</b></p>
                    <p class="item-total"><b><?= $total ?> euros</b></p>
                </div>


            </div>
            <!-- 
            <div class="footer-subscription">
                <a href="" class="btn btn-continue">Continue</a>
            </div> 
            -->
        </div>
    </div>

    <div class="content-list-amount">
        <div class="d-flex justify-content-between align-items-center head-block">
            <h2>List Amount</h2>
            <input class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek" aria-label="Zoek" >
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Instrument/Account</th>
                <th scope="col">Type</th>
                <th scope="col">Amount</th>
                <th scope="col">Situation</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>10/12/22</td>
                <td>GNB 384502</td>
                <td>Debit</td>
                <td>800 €</td>
                <td><span class="done">Done</span></td>
                <td>
                    <div class="dropdown text-white">
                        <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                            <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                        </p>
                        <ul class="dropdown-menu">
                            <li class="my-1"><i class="fa fa-money px-2"></i><a href="" target="_blank">Pay</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <td>10/11/22</td>
                <td>GNB 384502</td>
                <td>Credit</td>
                <td>800 €</td>
                <td><span class="hold">On hold</span></td>
                <td>
                    <div class="dropdown text-white">
                        <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                            <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                        </p>
                        <ul class="dropdown-menu">
                            <li class="my-1"><i class="fa fa-money px-2"></i><a href="" target="_blank">Pay</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <td>10/12/22</td>
                <td>GNB 384502</td>
                <td>Debit</td>
                <td>800 €</td>
                <td><span class="done">Done</span></td>
                <td>
                    <div class="dropdown text-white">
                        <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                            <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                        </p>
                        <ul class="dropdown-menu">
                            <li class="my-1"><i class="fa fa-money px-2"></i><a href="" target="_blank">Pay</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <td>10/11/22</td>
                <td>GNB 384502</td>
                <td>Credit</td>
                <td>800 €</td>
                <td><span class="hold">On hold</span></td>
                <td>
                    <div class="dropdown text-white">
                        <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                            <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                        </p>
                        <ul class="dropdown-menu">
                            <li class="my-1"><i class="fa fa-money px-2"></i><a href="" target="_blank">Pay</a></li>
                        </ul>
                    </div>
                </td>
            </tr>

            </tbody>
        </table>
    </div>




</div>