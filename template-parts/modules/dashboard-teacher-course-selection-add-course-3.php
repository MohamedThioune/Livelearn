<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/bootstrap-datepicker.min.css" />


<?php
    $data_en = get_field('data_locaties_xml', $_GET['id']);
?>
<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>3.Data en locaties</h2>
                </div>

                <form action="" method="POST" class="wrapperClone" id="attributes">
                    <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                    <?php
                    if(!empty($data_en)){
                        foreach($data_en as $key => $datum){
                            $data_between = "";
                            $datum = $datum['value'];
                            $data = explode(';', $datum);

                            $data_first = $data[0];

                            $location = explode('-', $data_first)[2];
                            $adress = explode('-', $data_first)[3];

                            $data_first = explode(' ', explode('-', $data_first)[0])[0];

                            $max = intval(count($data)-1);
                            $data_last = $data[$max];
                            $data_last = explode(' ', explode('-', $data_last)[0])[0];

                            $data_first = str_replace('/', '.', $data_first);
                            $data_last = str_replace('/', '.', $data_last);

                            //Conversion str to date
                            $data_first = date('Y-m-d', strtotime($data_first));
                            $data_last = date('Y-m-d', strtotime($data_last));

                            $max++;

                            if($max > 3){
                                $slice_array = array_slice( $data, 1, $max-2 );
                                foreach($slice_array as $key => $slice){
                                    $slice = explode(' ', explode('-', $slice)[0])[0];
                                    $data_between .= $slice;
                                    if(isset($slice_array[$key + 1]))
                                        $data_between .= ',';
                                }
                            }
                        ?>
                        <div class="groupInputDate blockDateW100">
                            <div class="input-group form-group">
                                <label for="">Start date</label>
                                <input type="date" name="start_date[]" value="<?= $data_first ?>" required>
                            </div>
                        </div>
                        <div class="input-group-course">
                            <label for="">Dates between</label>
                            <input type="text" name="between_date[]"  id="" value="<?= $data_between ?>" class="datepicker Txt_Date" placeholder="Pick the multiple dates" style="cursor: pointer;">
                        </div>
                        <div class="groupInputDate blockDateW100">
                            <div class="input-group">
                                <label for="">End date</label>
                                <input type="date" name="end_date[]" value="<?= $data_last ?>"  required>
                            </div>
                        </div>
                        <div class="input-group-course">
                            <label for="">Location</label>
                            <input type="text" name="location[]" value="<?= $location ?>">
                        </div>
                        <div class="input-group-course">
                            <label for="">Adress</label>
                            <input type="text" name="adress[]" value="<?= $adress ?>">
                        </div>
                        <?php
                        }
                    }
                    else{
                    ?>
                        <div class="">
                            <div class="groupInputDate">
                                <div class="input-group form-group colM">
                                    <label for="">Start date</label>
                                    <input type="date" name="start_date[]" required>
                                </div>
                            </div>
                            <div class="input-group-course">
                                <label for="">Dates between</label>
                                <input type="text" name="between_date[]" id="" class="datepicker Txt_Date" placeholder="Pick the multiple dates" style="cursor: pointer;">
                            </div>
                            <div class="groupInputDate ">
                                <div class="input-group colM">
                                    <label for="">End date</label>
                                    <input type="date" name="end_date[]" required>
                                </div>
                            </div>
                            <div class="input-group-course">
                                <label for="">Location</label>
                                <input type="text" name="location[]">
                            </div>
                            <div class="input-group-course">
                                <label for="">Adress</label>
                                <input type="text" name="adress[]">
                            </div>
                        </div>

                    <?php
                    }
                    ?>
                    <div class="results"></div>

                    <div class="buttons groupBtnData">
                        <button type="button" class="add btn-newDate"> + Extra startdatum</button>
                        <button type="submit" name="date_add" class="btn btn-info">Opslaan & verder</button>
                    </div>

                    <!-- element for clone -->
                    <div class="blockForClone">
                            <div class="attr">
                                <hr class="line-elemnt">
                                <div class="groupInputDate blockDateW100">
                                    <div class="input-group form-group ">
                                        <label for="">Start date</label>
                                        <input type="date" name="start_date[]">
                                    </div>
                                </div>
                                <div class="input-group-course">
                                    <label for="">Dates between</label>
                                    <input type="text" name="between_date[]"  id="" class="datepicker Txt_Date" placeholder="Pick the multiple dates" style="cursor: pointer;">
                                </div>
                                <div class="groupInputDate blockDateW100">
                                    <div class="input-group">
                                        <label for="">End date</label>
                                        <input type="date" name="end_date[]">
                                    </div>
                                </div>
                                <div class="input-group-course">
                                    <label for="">Location</label>
                                    <input type="text" name="location[]">
                                </div>
                                <div class="input-group-course">
                                    <label for="">Adress</label>
                                    <input type="text" name="adress[]">
                                </div>
                                <button class="btn btn-danger remove" type="button">Remove</button>
                            </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-4 col-sm-12">
        <div class="blockCourseToevoegen">
            <p class="courseToevoegenText">Course toevoegen</p>
            <div class="contentBlockRight">
                <a href="/dashboard/teacher/course-selection/" class="contentBlockCourse">
                    <div class="circleIndicator passEtape">
                        <i class="fa fa-book"></i>
                    </div>
                    <p class="textOpleidRight">Opleidingstype</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-course<?php if(isset($_GET['id'])) echo '&id=' .$_GET['id'] . '&type=' . $_GET['type']. '&edit'; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape">
                        <i class="fa fa-info"></i>
                    </div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=2&edit'; else echo "#"; ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape">
                        <i class="fa fa-file-text"></i>
                    </div>
                    <p class="textOpleidRight">Uitgebreide beschrijving</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=3&edit'; else echo "#" ?>" class="contentBlockCourse">
                    <div class="circleIndicator passEtape2">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight ">Data en locaties</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=4&edit'; else echo "#" ?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-paste" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Settings</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=5&edit'; else echo "#" ?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-tag" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Onderwerpen</p>
                </a>
                <a href="<?php if(isset($_GET['id'])) echo '/dashboard/teacher/course-selection/?func=add-course&id=' . $_GET['id'] . '&type=' . $_GET['type'] . '&step=6&edit'; else echo "#" ?>" class="contentBlockCourse">
                    <div class="circleIndicator">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <p class="textOpleidRight">Experts</p>
                </a>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri();?>/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(function () {
        var selectedDates = [];
        datePicker = $('[class*=Txt_Date]').datepicker({
            multidate: true,
            format: 'dd/mm/yyyy ',
            todayHighlight: true,

            language: 'en'
        });
        datePicker.on('changeDate', function (e) {
            if (e.dates.length <= 10) {
                selectedDates = e.dates;
            } else {
                datePicker.data('datepicker').setDates(selectedDates);
                alert('You can only select 10 dates.');
            }
        });
    });
``
    $('.calendar').datepicker();

</script>


