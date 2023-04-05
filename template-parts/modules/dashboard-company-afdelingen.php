
<div class="blockAfdelingen">
    <div class="blockAfdelingen-table">
        <div class="headListeCourse">
            <p class="JouwOpleid">Werknemers (4)</p>
            <input id="search_txt_company" class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek medewerker" aria-label="Search" >
            <a href="../people-mensen" class="btnNewCourse">Persoon toevoegen</a>
        </div>
        <div class="contentCardAlloccate">
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Afbeelding</th>
                    <th scope="col">Naam</th>
                    <th scope="col">Departement</th>
                    <th scope="col">Functions</th>
                    <th scope="col">Optie</th>
                </tr>
                </thead>
                <tbody id="autocomplete_company_people">
                <tr id="" >
                    <td scope="row">1</td>
                    <td class="textTh thModife">
                        <div class="ImgUser">
                            <a href="" >
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/placeholder_user.png" alt="">
                            </a>
                        </div>
                    </td>
                    <td class="textTh"> <a href="" style="text-decoration:none;">Mamadou</a> </td>
                    <td class="textTh">Sales</td>
                    <td class="textTh">Sales Manager</td>
                    <td class="textTh">
                        <div class="dropdown text-white">
                            <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                            </p>
                            <ul class="dropdown-menu">
                                <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="" target="_blank">View</a></li>
                                <li class="my-1"><i class="fa fa-pencil px-2" ></i><a data-toggle="modal" data-target="#modalViewManager" href="#">Edit</a></li>
                                <li class="my-2"><i class="fa fa-trash px-2"></i><a href="" target="_blank">Remove</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div class="departement-block">
        <button class="btn btnNewdepartement" data-toggle="modal" data-target="#modalNewDepartement">+ new departement</button>
        <ul class="">
            <li>Sales <button class="btn btnRemoveDepartement"><i class="fa fa-trash"></i></button></li>
            <li>Marketing <button class="btn btnRemoveDepartement"><i class="fa fa-trash"></i></button></li>
            <li>Operations <button class="btn btnRemoveDepartement"><i class="fa fa-trash"></i></button></li>
            <li>IT <button class="btn btnRemoveDepartement"><i class="fa fa-trash"></i></button></li>
        </ul>
    </div>
</div>

<!-- Modal new departement -->
<div class="modal fade modal-Manager" id="modalNewDepartement" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Add new Departement</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="functie">Name</label>
                    <input type="text" class="form-control" placeholder="Name of department">
                </div>

                <button type="button" class="btn btn-add">Add</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal optie edit missign information  -->
<div class="modal fade modal-Manager" id="modalViewManager" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Edit information</h5>
            </div>
            <div class="modal-body">
                <form action="" class="selectdepartementForm">
                    <div class="form-group">
                        <label for="telefoonnummer">Departement</label>
                        <div class="formModifeChoose" >
                            <div class="formModifeChoose">

                                <select placeholder="Choose skills" class="multipleSelect2 selectdepartement" multiple="true">
                                    <option>Sales</option>
                                    <option>Marketing</option>
                                    <option>Operations</option>
                                    <option>IT</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="functie">Role (Job Functie)</label>
                        <input type="text" class="form-control Functie" placeholder="Job Title">
                    </div>
                    <button type="button" class="btn btn-add">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

