<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/bootstrap-datepicker.min.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri();?>/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(function () {
        var selectedDates = [];
        datePicker = $('[class*=Txt_Date]').datepicker({
            multidate: true,
            format: 'mm/dd/yyyy ',
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
</script>


<?php
    $data_en = get_field('data_locaties_xml', $_GET['id']);
    print_r($dat_en[0]);
?>
<div class="row">
    <div class="col-md-5 col-lg-8">
        <div class="cardCoursGlocal">
            <div id="basis" class="w-100">
                <div class="titleOpleidingstype">
                    <h2>3.Data en locaties</h2>
                </div>
                
                <form action="" method="POST">
                    <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                    <div class="groupInputDate">
                        <div class="input-group form-group">
                            <label for="">Start date</label>
                            <input type="date" name="start_date[]" required>
                        </div>
                    </div>
                    <div class="input-group-course">
                        <label for="">Dates between</label>
                        <input type="text" name="between_date[]"  id="" class="datepicker Txt_Date" placeholder="Pick the multiple dates" style="cursor: pointer;">
                    </div>
                    <div class="groupInputDate">
                        <div class="input-group">
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
                    <button type="button" class="btn btn-newDate" data-toggle="modal" data-target="#exampleModalDate">
                       Complete with another section
                    </button>
                    <br><br>
                    <button type="submit" name="date_add" class="btn btn-info">Opslaan & verder</button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalDate" tabindex="-1" role="dialog" aria-labelledby="exampleModalDateLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add other Date en locaties</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="dataEnLocation">
                                        <div class="groupInputDate">
                                            <div class="input-group form-group">
                                                <label for="">Start date</label>
                                                <input type="date" name="start_date[]">
                                            </div>
                                        </div>
                                        <div class="input-group-course">
                                            <label for="">Dates between</label>
                                            <input type="text" name="between_date[]"  id="" class="datepicker Txt_Date" placeholder="Pick the multiple dates" style="cursor: pointer;">
                                        </div>
                                        <div class="groupInputDate">
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
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="date_add" class="btn btn-info">Opslaan & verder</button>
                                </div>
                            </div>
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
                    <div class="circleIndicator passEtape"></div>
                    <p class="textOpleidRight">Opleidingstype</p>
                </a>
                <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&step=1" class="contentBlockCourse">
                    <div class="circleIndicator  passEtape"></div>
                    <p class="textOpleidRight">Basis informatie</p>
                </a>
                <?php if(isset($_GET['id'])){ ?>
                    <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&type=<?= $_GET['type'] ?>&step=2" class="contentBlockCourse">
                        <div class="circleIndicator passEtape"></div>
                        <p class="textOpleidRight">Uitgebreide beschrijving</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&type=<?= $_GET['type'] ?>&step=3" class="contentBlockCourse">
                        <div class="circleIndicator passEtape2"></div>
                        <p class="textOpleidRight ">Data en locaties</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&type=<?= $_GET['type'] ?>&step=4" class="contentBlockCourse">
                        <div class="circleIndicator"></div>
                        <p class="textOpleidRight">Details en onderwepren</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&type=<?= $_GET['type'] ?>&step=5" class="contentBlockCourse">
                        <div class="circleIndicator"></div>
                        <p class="textOpleidRight">Tags</p>
                    </a>
                    <a href="/dashboard/teacher/course-selection/?func=add-course&id=<?php echo $_GET['id'];?>&type=<?= $_GET['type'] ?>&step=6" class="contentBlockCourse">
                        <div class="circleIndicator"></div>
                        <p class="textOpleidRight">Experts</p>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>




