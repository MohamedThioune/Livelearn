<?php wp_head(); ?>
<?php get_header(); ?>

<style>
    .radius-custom {
        border-radius: 10px !important;
    }
</style>
  

<!-- start leerbudgetten content -->
<div class="theme-learning">

    <div class="contentPageManager managerOverviewMensen">
        <br>
        <div class="contentOverviewMensen d-flex justify-content-md-between bg-white justify-content-center p-2 radius-custom mx-4 mx-md-0"> 
            <div class="h5 pt-2"><strong>Buget Livelearn team</strong></div>
            <div><button class="btn e" style="background: #00A89D"><strong class="text-white">Naar bedrijfsniveau</strong></button></div>               
        </div>

        <div class="contentOverviewMensen mt-4"> 

            <div class="col-md-3 col-12 px-1  px-md-0 ">
                <div class="card mb-3 radius-custom" style="height: 125px;">
                    <div class="card-body">
                        <p class="card-text text-center"><strong>Maandelijkse kosten</strong> </p>   
                        <h5 class="card-title text-center"> <strong>$49,50</strong> </h5>
                        <p class="card-text text-right h6"><small class="text-muted">
                            <strong>Last updated 3 mins ago</strong> </small></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12 px-1 px-md-2  pr-md-0">
                <div class="card mb-3 radius-custom" style="height: 125px;">
                    <div class="card-body">
                        <p class="card-text text-center"> <strong>Inkomsten verkochte kennisproducten</strong> </p>
                        <h5 class="card-title text-center"> <strong>$6,250</strong></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12 px-1 px-md-2">
                <div class="card mb-3 radius-custom" style="height: 125px;">
                    <div class="card-body">
                        <p class="card-text text-center"> <strong>Uitgaven Opleidingen</strong> </p>
                        <h5 class="card-title text-center"><strong>$9,273</strong></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12 px-1  px-md-0">
                <div class="card mb-3 radius-custom" style="height: 125px;">
                    <div class="card-body">
                        <p class="card-text text-center"> <strong>Budget resterend</strong> </p>
                        <h5 class="card-title text-center"><strong>$11,383</strong></h5>
                        <p class="card-text text-right h6"><small class="text-muted">
                            <strong>Last updated 3 mins ago</strong> </small></p>
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
                                <div class="h5 pt-2"><strong>Buget Livelearn team</strong></div>
                                <button type="button" class="btn-close bg-danger border-0 text-white fa-2x rounded border-3" data-bs-dismiss="modal" aria-label="Close">X</button>
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
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
                </div>
            </div>
        </div>


        <div class="bg-white mt-5 p-2 radius-custom mx-4 mx-md-0 mb-4" id="div_table" style="display:block" >  
            
            <!-- <div class="h5 pt-2"><strong>Buget Livelearn team</strong></div> -->
            <div class="d-flex justify-content-between w-100 border-bottom border-5 pb-2">
                <div class="h5 pt-2"><strong>Buget Livelearn team</strong></div>
                <div>
                    <!-- Button trigger modal -->
                    <button class="btn text-white" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background: #00A89D">
                        <strong>Naar bedrijfsniveau</strong>
                    </button>
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
                            <th scope="col">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>
                                <div class="dropdown text-white">
                                    <p class="dropdown-toggle mb-0" type="button" data-toggle="dropdown">
                                        <img  style="width:20px"
                                        src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                    </p>
                                    <ul class="dropdown-menu">
                                        <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="#">Bekijk</a></li>
                                        <li class="my-2"><i class="fa fa-gear px-2"></i><a href="#">Pas aan</a></li>
                                        <li class="my-1"><i class="fa fa-trash px-2"></i><a href="#" class="text-danger">Verwijder</a></li>
                                    </ul>
                                </div> 
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            <td>@fat</td>
                            <td>@fat</td>
                            <td>@fat</td>
                            <td>
                                <div class="dropdown text-white">
                                    <p class="dropdown-toggle  mb-0" type="button" data-toggle="dropdown">
                                        <img  style="width:20px"
                                        src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                    </p>
                                    <ul class="dropdown-menu">
                                        <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="#">Bekijk</a></li>
                                        <li class="my-2"><i class="fa fa-gear px-2"></i><a href="#">Pas aan</a></li>
                                        <li class="my-1"><i class="fa fa-trash px-2"></i><a href="#" class="text-danger">Verwijder</a></li>
                                    </ul>
                                </div> 
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry the Bird</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>
                                <div class="dropdown text-white">
                                    <p class="dropdown-toggle  mb-0" type="button" data-toggle="dropdown">
                                        <img  style="width:20px"
                                        src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                    </p>
                                    <ul class="dropdown-menu">
                                        <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="#">Bekijk</a></li>
                                        <li class="my-2"><i class="fa fa-gear px-2"></i><a href="#">Pas aan</a></li>
                                        <li class="my-1"><i class="fa fa-trash px-2"></i><a href="#" class="text-danger">Verwijder</a></li>
                                    </ul>
                                </div> 
                            </td>
                        </tr>
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
</div>
<!-- start leerbudgetten content -->


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>


<?php get_footer(); ?>
<?php wp_footer(); ?>