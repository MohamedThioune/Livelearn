<?php /** Template Name: add course form */ ?>
<?php 
acf_form_head();


?>
<div class="contentOne">
    <?php require 'headerDashboard.php';?>
</div>

<div class="contentPageManager">
    <div class="blockSidbarMobile blockSidbarMobile2">
        <div class="zijbalk">
            <p class="zijbalkMenu">zijbalk menu</p>
            <button class="btn btnSidbarMob">
                <img src="img/filter.png" alt="">
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-lg-3">
            <?php require 'layaoutTeacher.php';?>
        </div>
        <div class="col-md-5 col-lg-7">
            <div class="cardCoursGlocal">
                <div id="basis" class="w-100">
                    <div class="titleOpleidingstype">
                        <h2>2.Basis informatie</h2>
                    </div>
                    <?php acf_form(array(
                        'post_id'       => 'new_post',
                        'post_type'     => 'course',
                        'post_title'   => true,
                        'post_excerpt'   => true,
                        'fields' => array('field_610f19a34af16','field_610f0d9b21fb8', 'field_6138b85ab624e'),
                        'submit_value'  => __('Save')
                    )); ?>
                    <form onsubmit="return false" class="w-100" id="form1">
                        <div class="elementInputCours">
                            <div class="importBlock2">
                                <label for="">Import cover afbeelding</label>
                                <div class="file-upload">
                                    <div class="file-select">
                                        <div class="file-select-button" id="fileName4">Import</div>
                                        <div class="file-select-name" id="noFile4">IMPORT (Excel, CSV)</div>
                                        <input type="file" name="chooseFile4" id="chooseFile4">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementInputCours">
                            <input type="text" placeholder="Title van curcus">
                        </div>
                        <div class="elementInputCours">
                            <textarea name="" id="" rows="2" placeholder="Korte beschrijving"></textarea>
                        </div>
                        <div class="elementInputCours">

                            <div class="groupInput">
                                <label for="">Course end date</label>
                                <div class="form-inline align-items-start felement" data-fieldtype="date_time_selector">
                                    <fieldset data-fieldtype="date_time" class="m-0 p-0 border-0" id="id_startdate">
                                        <legend class="sr-only">Begin datum</legend>
                                        <div class="fdate_time_selector d-flex flex-wrap align-items-center">
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_day">
                                                    Day
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[day]" id="id_startdate_day" >
                                                    <option value="1"   >1</option>
                                                    <option value="2"   >2</option>
                                                    <option value="3"   >3</option>
                                                    <option value="4"   >4</option>
                                                    <option value="5"   >5</option>
                                                    <option value="6"   >6</option>
                                                    <option value="7"   >7</option>
                                                    <option value="8"   >8</option>
                                                    <option value="9"   >9</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27" selected  >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_day" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_month">
                                                    Month
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[month]" id="id_startdate_month">
                                                    <option value="1"   >January</option>
                                                    <option value="2"   >February</option>
                                                    <option value="3"   >March</option>
                                                    <option value="4"   >April</option>
                                                    <option value="5"   >May</option>
                                                    <option value="6"   >June</option>
                                                    <option value="7"   >July</option>
                                                    <option value="8"   >August</option>
                                                    <option value="9" selected  >September</option>
                                                    <option value="10"   >October</option>
                                                    <option value="11"   >November</option>
                                                    <option value="12"   >December</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_month" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_year">
                                                    Year
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[year]" id="id_startdate_year">
                                                <option value="2021" selected  >2021</option>
                                                <option value="2022"   >2022</option>
                                                <option value="2023"   >2023</option>
                                                <option value="2024"   >2024</option>
                                                <option value="2025"   >2025</option>
                                                <option value="2026"   >2026</option>
                                                <option value="2027"   >2027</option>
                                                <option value="2028"   >2028</option>
                                                <option value="2029"   >2029</option>
                                                <option value="2030"   >2030</option>
                                                <option value="2031"   >2031</option>
                                                <option value="2032"   >2032</option>
                                                <option value="2033"   >2033</option>
                                                <option value="2034"   >2034</option>
                                                <option value="2035"   >2035</option>
                                                <option value="2036"   >2036</option>
                                                <option value="2037"   >2037</option>
                                                <option value="2038"   >2038</option>
                                                <option value="2039"   >2039</option>
                                                <option value="2040"   >2040</option>
                                                <option value="2041"   >2041</option>
                                                <option value="2042"   >2042</option>
                                                <option value="2043"   >2043</option>
                                                <option value="2044"   >2044</option>
                                                <option value="2045"   >2045</option>
                                                <option value="2046"   >2046</option>
                                                <option value="2047"   >2047</option>
                                                <option value="2048"   >2048</option>
                                                <option value="2049"   >2049</option>
                                                <option value="2050"   >2050</option>
                                            </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_year" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_hour">
                                                    Hour
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[hour]" id="id_startdate_hour">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_hour" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_minute">
                                                    Minute
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[minute]" id="id_startdate_minute">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27"   >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                    <option value="32"   >32</option>
                                                    <option value="33"   >33</option>
                                                    <option value="34"   >34</option>
                                                    <option value="35"   >35</option>
                                                    <option value="36"   >36</option>
                                                    <option value="37"   >37</option>
                                                    <option value="38"   >38</option>
                                                    <option value="39"   >39</option>
                                                    <option value="40"   >40</option>
                                                    <option value="41"   >41</option>
                                                    <option value="42"   >42</option>
                                                    <option value="43"   >43</option>
                                                    <option value="44"   >44</option>
                                                    <option value="45"   >45</option>
                                                    <option value="46"   >46</option>
                                                    <option value="47"   >47</option>
                                                    <option value="48"   >48</option>
                                                    <option value="49"   >49</option>
                                                    <option value="50"   >50</option>
                                                    <option value="51"   >51</option>
                                                    <option value="52"   >52</option>
                                                    <option value="53"   >53</option>
                                                    <option value="54"   >54</option>
                                                    <option value="55"   >55</option>
                                                    <option value="56"   >56</option>
                                                    <option value="57"   >57</option>
                                                    <option value="58"   >58</option>
                                                    <option value="59"   >59</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_minute" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <a name="startdate[calendar]" href="#" id="id_startdate_calendar"><i class="fas fa-calendar-alt "  title="Calendar" aria-label="Calendar"></i></a>
                                        </div>
                                    </fieldset>
                                    <div class="form-control-feedback invalid-feedback" id="id_error_startdate" >

                                    </div>
                                </div>
                            </div>
                            <div class="groupInput">
                                <label for="">Course strat date</label>
                                <div class="form-inline align-items-start felement" data-fieldtype="date_time_selector">
                                    <fieldset data-fieldtype="date_time" class="m-0 p-0 border-0" id="id_startdate">
                                        <legend class="sr-only">Begin datum</legend>
                                        <div class="fdate_time_selector d-flex flex-wrap align-items-center">
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_day">
                                                    Day
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[day]" id="id_startdate_day" >
                                                    <option value="1"   >1</option>
                                                    <option value="2"   >2</option>
                                                    <option value="3"   >3</option>
                                                    <option value="4"   >4</option>
                                                    <option value="5"   >5</option>
                                                    <option value="6"   >6</option>
                                                    <option value="7"   >7</option>
                                                    <option value="8"   >8</option>
                                                    <option value="9"   >9</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"  selected  >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27"  >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_day" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_month">
                                                    Month
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[month]" id="id_startdate_month">
                                                    <option value="1"   >January</option>
                                                    <option value="2"   >February</option>
                                                    <option value="3"   >March</option>
                                                    <option value="4"   >April</option>
                                                    <option value="5"   >May</option>
                                                    <option value="6"   >June</option>
                                                    <option value="7"   >July</option>
                                                    <option value="8"   >August</option>
                                                    <option value="9"  >September</option>
                                                    <option value="10"   >October</option>
                                                    <option value="11" selected   >November</option>
                                                    <option value="12"   >December</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_month" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_year">
                                                    Year
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[year]" id="id_startdate_year">
                                                <option value="2021" selected  >2021</option>
                                                <option value="2022"   >2022</option>
                                                <option value="2023"   >2023</option>
                                                <option value="2024"   >2024</option>
                                                <option value="2025"   >2025</option>
                                                <option value="2026"   >2026</option>
                                                <option value="2027"   >2027</option>
                                                <option value="2028"   >2028</option>
                                                <option value="2029"   >2029</option>
                                                <option value="2030"   >2030</option>
                                                <option value="2031"   >2031</option>
                                                <option value="2032"   >2032</option>
                                                <option value="2033"   >2033</option>
                                                <option value="2034"   >2034</option>
                                                <option value="2035"   >2035</option>
                                                <option value="2036"   >2036</option>
                                                <option value="2037"   >2037</option>
                                                <option value="2038"   >2038</option>
                                                <option value="2039"   >2039</option>
                                                <option value="2040"   >2040</option>
                                                <option value="2041"   >2041</option>
                                                <option value="2042"   >2042</option>
                                                <option value="2043"   >2043</option>
                                                <option value="2044"   >2044</option>
                                                <option value="2045"   >2045</option>
                                                <option value="2046"   >2046</option>
                                                <option value="2047"   >2047</option>
                                                <option value="2048"   >2048</option>
                                                <option value="2049"   >2049</option>
                                                <option value="2050"   >2050</option>
                                            </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_year" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_hour">
                                                    Hour
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[hour]" id="id_startdate_hour">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_hour" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_minute">
                                                    Minute
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[minute]" id="id_startdate_minute">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27"   >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                    <option value="32"   >32</option>
                                                    <option value="33"   >33</option>
                                                    <option value="34"   >34</option>
                                                    <option value="35"   >35</option>
                                                    <option value="36"   >36</option>
                                                    <option value="37"   >37</option>
                                                    <option value="38"   >38</option>
                                                    <option value="39"   >39</option>
                                                    <option value="40"   >40</option>
                                                    <option value="41"   >41</option>
                                                    <option value="42"   >42</option>
                                                    <option value="43"   >43</option>
                                                    <option value="44"   >44</option>
                                                    <option value="45"   >45</option>
                                                    <option value="46"   >46</option>
                                                    <option value="47"   >47</option>
                                                    <option value="48"   >48</option>
                                                    <option value="49"   >49</option>
                                                    <option value="50"   >50</option>
                                                    <option value="51"   >51</option>
                                                    <option value="52"   >52</option>
                                                    <option value="53"   >53</option>
                                                    <option value="54"   >54</option>
                                                    <option value="55"   >55</option>
                                                    <option value="56"   >56</option>
                                                    <option value="57"   >57</option>
                                                    <option value="58"   >58</option>
                                                    <option value="59"   >59</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_minute" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <a name="startdate[calendar]" href="#" id="id_startdate_calendar"><i class="fas fa-calendar-alt "  title="Calendar" aria-label="Calendar"></i></a>
                                        </div>
                                    </fieldset>
                                    <div class="form-control-feedback invalid-feedback" id="id_error_startdate" >

                                    </div>
                                </div>
                            </div>
                            <div class="groupInput">
                                <label for="">Course enrolment Type</label>
                                <select class="selectCourse" name="" id="">
                                    <option value="">Users can enrol themselves onto course</option>
                                    <option value="">Saab</option>
                                </select>
                            </div>
                            <div class="groupInput">
                                <label for="">Prijs van de opleiding</label>
                                <input type="number" placeholder="Prijs (€)" class="prijsINput">
                                <input class="inputCheckAllen" type="checkbox">
                                <p class="textYes">Gratis</p>
                            </div>
                        </div>
                        <div class="blockButton2">
                            <button class="btn btnSubmit">Terug</button>
                            <button id="VerderInformatie" type="submit" class="btn btnCancel">Verder</button>
                        </div>

                    </form>
                </div>
                <div id="Uitgebreide" class="w-100">
                    <div class="titleOpleidingstype">
                        <h2>3.Uitgebreide beschrijving</h2>
                        <?php acf_form(array(
                            'post_id'       => 'new_post',
                            'field_groups' => array('group_6155d485977f6'),
                            'post_content'  => true,
                            'post_status'	=> 'publish',
                            'post_type'     => 'course',
                            'submit_value'  => __('Save')
                        )); ?>
                    </div>
                    <form onsubmit="return false" class="w-100" id="form2">
                        <div class="elementInputCours">
                            <div class="groupInput">
                                <label for="">Uit hoeveel lessen bestaat de course</label>
                                <select class="selectCourseUit" name="" id="">
                                    <option value="">Aantal </option>
                                    <option value="">Saab</option>
                                </select>
                            </div>
                            <div class="groupInput">
                                <label for="">Over hoeveel tijd is de opleiding verldeeld </label>
                                <select class="selectCourseOver" name="" id="">
                                    <option value="">Tijseenheid</option>
                                    <option value="">Saab</option>
                                </select>
                            </div>
                            <div class="groupInput">
                                <label for="">Hoeveel keer ga je deze opleiding geven </label>
                                <select class="selectCourseUit" name="" id="">
                                    <option value="">Aantal </option>
                                    <option value="">Saab</option>
                                </select>
                            </div>
                        </div>
                        <div class="elementInputCours">
                            <textarea name="" id=""  rows="4" placeholder="Uitgebreide beschrijving | Beschrijf hoe de curcus er uitziet"></textarea>
                        </div>
                        <div class="elementInputCours">
                            <textarea name="" id="" rows="4" placeholder="Agenda / Programma | Beschrijf het programma van de cursus"></textarea>
                        </div>
                        <div class="elementInputCours">
                            <textarea name="" id=""  rows="4" placeholder="Voor wie is deze curcus relevant en waarom"></textarea>
                        </div>
                        <div class="elementInputCours">
                            <textarea name="" id="" rows="4" placeholder="Resultan | What heb je na afloop geleerd en kan je beter dan voorheen"></textarea>
                        </div>

                        <div class="blockButton2">
                            <button id="terugUitgebreide" class="btn btnSubmit">Terug</button>
                            <button id="VerderUitgebreide" class="btn btnCancel">Verder</button>
                        </div>

                    </form>
                </div>

                <div id="Data" class="w-100">
                    <div class="titleOpleidingstype">
                        <h2>4.Data en locaties</h2>
                         <?php acf_form(array(
                            'post_id'       => 'new_post',
                            'post_status'	=> 'publish',
                            'post_type'     => 'course',
                            'field_groups' => array('group_610f0dc543936'),
                            'submit_value'  => __('Save')
                    )); ?>
                    </div>
                    <form  onsubmit="return false">
                        <div class="elementInputCours">

                            <div class="groupInput">
                                <label for="">Course end date</label>
                                <div class="form-inline align-items-start felement" data-fieldtype="date_time_selector">
                                    <fieldset data-fieldtype="date_time" class="m-0 p-0 border-0" id="id_startdate">
                                        <legend class="sr-only">Begin datum</legend>
                                        <div class="fdate_time_selector d-flex flex-wrap align-items-center">
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_day">
                                                    Day
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[day]" id="id_startdate_day" >
                                                    <option value="1"   >1</option>
                                                    <option value="2"   >2</option>
                                                    <option value="3"   >3</option>
                                                    <option value="4"   >4</option>
                                                    <option value="5"   >5</option>
                                                    <option value="6"   >6</option>
                                                    <option value="7"   >7</option>
                                                    <option value="8"   >8</option>
                                                    <option value="9"   >9</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27" selected  >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_day" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_month">
                                                    Month
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[month]" id="id_startdate_month">
                                                    <option value="1"   >January</option>
                                                    <option value="2"   >February</option>
                                                    <option value="3"   >March</option>
                                                    <option value="4"   >April</option>
                                                    <option value="5"   >May</option>
                                                    <option value="6"   >June</option>
                                                    <option value="7"   >July</option>
                                                    <option value="8"   >August</option>
                                                    <option value="9" selected  >September</option>
                                                    <option value="10"   >October</option>
                                                    <option value="11"   >November</option>
                                                    <option value="12"   >December</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_month" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_year">
                                                    Year
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[year]" id="id_startdate_year">
                                                <option value="2021" selected  >2021</option>
                                                <option value="2022"   >2022</option>
                                                <option value="2023"   >2023</option>
                                                <option value="2024"   >2024</option>
                                                <option value="2025"   >2025</option>
                                                <option value="2026"   >2026</option>
                                                <option value="2027"   >2027</option>
                                                <option value="2028"   >2028</option>
                                                <option value="2029"   >2029</option>
                                                <option value="2030"   >2030</option>
                                                <option value="2031"   >2031</option>
                                                <option value="2032"   >2032</option>
                                                <option value="2033"   >2033</option>
                                                <option value="2034"   >2034</option>
                                                <option value="2035"   >2035</option>
                                                <option value="2036"   >2036</option>
                                                <option value="2037"   >2037</option>
                                                <option value="2038"   >2038</option>
                                                <option value="2039"   >2039</option>
                                                <option value="2040"   >2040</option>
                                                <option value="2041"   >2041</option>
                                                <option value="2042"   >2042</option>
                                                <option value="2043"   >2043</option>
                                                <option value="2044"   >2044</option>
                                                <option value="2045"   >2045</option>
                                                <option value="2046"   >2046</option>
                                                <option value="2047"   >2047</option>
                                                <option value="2048"   >2048</option>
                                                <option value="2049"   >2049</option>
                                                <option value="2050"   >2050</option>
                                            </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_year" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_hour">
                                                    Hour
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[hour]" id="id_startdate_hour">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_hour" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_minute">
                                                    Minute
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[minute]" id="id_startdate_minute">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27"   >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                    <option value="32"   >32</option>
                                                    <option value="33"   >33</option>
                                                    <option value="34"   >34</option>
                                                    <option value="35"   >35</option>
                                                    <option value="36"   >36</option>
                                                    <option value="37"   >37</option>
                                                    <option value="38"   >38</option>
                                                    <option value="39"   >39</option>
                                                    <option value="40"   >40</option>
                                                    <option value="41"   >41</option>
                                                    <option value="42"   >42</option>
                                                    <option value="43"   >43</option>
                                                    <option value="44"   >44</option>
                                                    <option value="45"   >45</option>
                                                    <option value="46"   >46</option>
                                                    <option value="47"   >47</option>
                                                    <option value="48"   >48</option>
                                                    <option value="49"   >49</option>
                                                    <option value="50"   >50</option>
                                                    <option value="51"   >51</option>
                                                    <option value="52"   >52</option>
                                                    <option value="53"   >53</option>
                                                    <option value="54"   >54</option>
                                                    <option value="55"   >55</option>
                                                    <option value="56"   >56</option>
                                                    <option value="57"   >57</option>
                                                    <option value="58"   >58</option>
                                                    <option value="59"   >59</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_minute" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <a name="startdate[calendar]" href="#" id="id_startdate_calendar"><i class="fas fa-calendar-alt "  title="Calendar" aria-label="Calendar"></i></a>
                                        </div>
                                    </fieldset>
                                    <div class="form-control-feedback invalid-feedback" id="id_error_startdate" >

                                    </div>
                                </div>
                            </div>
                            <div class="groupInput">
                                <label for="">Course strat date</label>
                                <div class="form-inline align-items-start felement" data-fieldtype="date_time_selector">
                                    <fieldset data-fieldtype="date_time" class="m-0 p-0 border-0" id="id_startdate">
                                        <legend class="sr-only">Begin datum</legend>
                                        <div class="fdate_time_selector d-flex flex-wrap align-items-center">
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_day">
                                                    Day
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[day]" id="id_startdate_day" >
                                                    <option value="1"   >1</option>
                                                    <option value="2"   >2</option>
                                                    <option value="3"   >3</option>
                                                    <option value="4"   >4</option>
                                                    <option value="5"   >5</option>
                                                    <option value="6"   >6</option>
                                                    <option value="7"   >7</option>
                                                    <option value="8"   >8</option>
                                                    <option value="9"   >9</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"  selected  >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27"  >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_day" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_month">
                                                    Month
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[month]" id="id_startdate_month">
                                                    <option value="1"   >January</option>
                                                    <option value="2"   >February</option>
                                                    <option value="3"   >March</option>
                                                    <option value="4"   >April</option>
                                                    <option value="5"   >May</option>
                                                    <option value="6"   >June</option>
                                                    <option value="7"   >July</option>
                                                    <option value="8"   >August</option>
                                                    <option value="9"  >September</option>
                                                    <option value="10"   >October</option>
                                                    <option value="11" selected   >November</option>
                                                    <option value="12"   >December</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_month" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_year">
                                                    Year
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[year]" id="id_startdate_year">
                                                <option value="2021" selected  >2021</option>
                                                <option value="2022"   >2022</option>
                                                <option value="2023"   >2023</option>
                                                <option value="2024"   >2024</option>
                                                <option value="2025"   >2025</option>
                                                <option value="2026"   >2026</option>
                                                <option value="2027"   >2027</option>
                                                <option value="2028"   >2028</option>
                                                <option value="2029"   >2029</option>
                                                <option value="2030"   >2030</option>
                                                <option value="2031"   >2031</option>
                                                <option value="2032"   >2032</option>
                                                <option value="2033"   >2033</option>
                                                <option value="2034"   >2034</option>
                                                <option value="2035"   >2035</option>
                                                <option value="2036"   >2036</option>
                                                <option value="2037"   >2037</option>
                                                <option value="2038"   >2038</option>
                                                <option value="2039"   >2039</option>
                                                <option value="2040"   >2040</option>
                                                <option value="2041"   >2041</option>
                                                <option value="2042"   >2042</option>
                                                <option value="2043"   >2043</option>
                                                <option value="2044"   >2044</option>
                                                <option value="2045"   >2045</option>
                                                <option value="2046"   >2046</option>
                                                <option value="2047"   >2047</option>
                                                <option value="2048"   >2048</option>
                                                <option value="2049"   >2049</option>
                                                <option value="2050"   >2050</option>
                                            </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_year" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_hour">
                                                    Hour
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[hour]" id="id_startdate_hour">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_hour" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_minute">
                                                    Minute
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[minute]" id="id_startdate_minute">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27"   >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                    <option value="32"   >32</option>
                                                    <option value="33"   >33</option>
                                                    <option value="34"   >34</option>
                                                    <option value="35"   >35</option>
                                                    <option value="36"   >36</option>
                                                    <option value="37"   >37</option>
                                                    <option value="38"   >38</option>
                                                    <option value="39"   >39</option>
                                                    <option value="40"   >40</option>
                                                    <option value="41"   >41</option>
                                                    <option value="42"   >42</option>
                                                    <option value="43"   >43</option>
                                                    <option value="44"   >44</option>
                                                    <option value="45"   >45</option>
                                                    <option value="46"   >46</option>
                                                    <option value="47"   >47</option>
                                                    <option value="48"   >48</option>
                                                    <option value="49"   >49</option>
                                                    <option value="50"   >50</option>
                                                    <option value="51"   >51</option>
                                                    <option value="52"   >52</option>
                                                    <option value="53"   >53</option>
                                                    <option value="54"   >54</option>
                                                    <option value="55"   >55</option>
                                                    <option value="56"   >56</option>
                                                    <option value="57"   >57</option>
                                                    <option value="58"   >58</option>
                                                    <option value="59"   >59</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_minute" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <a name="startdate[calendar]" href="#" id="id_startdate_calendar"><i class="fas fa-calendar-alt "  title="Calendar" aria-label="Calendar"></i></a>
                                        </div>
                                    </fieldset>
                                    <div class="form-control-feedback invalid-feedback" id="id_error_startdate" >

                                    </div>
                                </div>
                            </div>
                            <div class="groupInput">
                                <label for="">Locatie</label>
                                <div class="d-flex">
                                    <input type="text" placeholder="Stad" class="stadINput">
                                    <select class="selectLand" name="" id="">
                                        <option value="">Land</option>
                                        <option value="">Saab</option>
                                    </select>
                                </div>
                            </div>
                            <div class="groupInput">
                                <label for="">Adres</label>
                                <input type="text" placeholder="Adres" class="adressInput">
                            </div>
                        </div>
                        <div class="elementInputCours">

                            <div class="groupInput">
                                <label for="">Course end date</label>
                                <div class="form-inline align-items-start felement" data-fieldtype="date_time_selector">
                                    <fieldset data-fieldtype="date_time" class="m-0 p-0 border-0" id="id_startdate">
                                        <legend class="sr-only">Begin datum</legend>
                                        <div class="fdate_time_selector d-flex flex-wrap align-items-center">
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_day">
                                                    Day
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[day]" id="id_startdate_day" >
                                                    <option value="1"   >1</option>
                                                    <option value="2"   >2</option>
                                                    <option value="3"   >3</option>
                                                    <option value="4"   >4</option>
                                                    <option value="5"   >5</option>
                                                    <option value="6"   >6</option>
                                                    <option value="7"   >7</option>
                                                    <option value="8"   >8</option>
                                                    <option value="9"   >9</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27" selected  >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_day" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_month">
                                                    Month
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[month]" id="id_startdate_month">
                                                    <option value="1"   >January</option>
                                                    <option value="2"   >February</option>
                                                    <option value="3"   >March</option>
                                                    <option value="4"   >April</option>
                                                    <option value="5"   >May</option>
                                                    <option value="6"   >June</option>
                                                    <option value="7"   >July</option>
                                                    <option value="8"   >August</option>
                                                    <option value="9" selected  >September</option>
                                                    <option value="10"   >October</option>
                                                    <option value="11"   >November</option>
                                                    <option value="12"   >December</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_month" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_year">
                                                    Year
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[year]" id="id_startdate_year">
                                                <option value="2021" selected  >2021</option>
                                                <option value="2022"   >2022</option>
                                                <option value="2023"   >2023</option>
                                                <option value="2024"   >2024</option>
                                                <option value="2025"   >2025</option>
                                                <option value="2026"   >2026</option>
                                                <option value="2027"   >2027</option>
                                                <option value="2028"   >2028</option>
                                                <option value="2029"   >2029</option>
                                                <option value="2030"   >2030</option>
                                                <option value="2031"   >2031</option>
                                                <option value="2032"   >2032</option>
                                                <option value="2033"   >2033</option>
                                                <option value="2034"   >2034</option>
                                                <option value="2035"   >2035</option>
                                                <option value="2036"   >2036</option>
                                                <option value="2037"   >2037</option>
                                                <option value="2038"   >2038</option>
                                                <option value="2039"   >2039</option>
                                                <option value="2040"   >2040</option>
                                                <option value="2041"   >2041</option>
                                                <option value="2042"   >2042</option>
                                                <option value="2043"   >2043</option>
                                                <option value="2044"   >2044</option>
                                                <option value="2045"   >2045</option>
                                                <option value="2046"   >2046</option>
                                                <option value="2047"   >2047</option>
                                                <option value="2048"   >2048</option>
                                                <option value="2049"   >2049</option>
                                                <option value="2050"   >2050</option>
                                            </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_year" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_hour">
                                                    Hour
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[hour]" id="id_startdate_hour">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_hour" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_minute">
                                                    Minute
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[minute]" id="id_startdate_minute">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27"   >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                    <option value="32"   >32</option>
                                                    <option value="33"   >33</option>
                                                    <option value="34"   >34</option>
                                                    <option value="35"   >35</option>
                                                    <option value="36"   >36</option>
                                                    <option value="37"   >37</option>
                                                    <option value="38"   >38</option>
                                                    <option value="39"   >39</option>
                                                    <option value="40"   >40</option>
                                                    <option value="41"   >41</option>
                                                    <option value="42"   >42</option>
                                                    <option value="43"   >43</option>
                                                    <option value="44"   >44</option>
                                                    <option value="45"   >45</option>
                                                    <option value="46"   >46</option>
                                                    <option value="47"   >47</option>
                                                    <option value="48"   >48</option>
                                                    <option value="49"   >49</option>
                                                    <option value="50"   >50</option>
                                                    <option value="51"   >51</option>
                                                    <option value="52"   >52</option>
                                                    <option value="53"   >53</option>
                                                    <option value="54"   >54</option>
                                                    <option value="55"   >55</option>
                                                    <option value="56"   >56</option>
                                                    <option value="57"   >57</option>
                                                    <option value="58"   >58</option>
                                                    <option value="59"   >59</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_minute" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <a name="startdate[calendar]" href="#" id="id_startdate_calendar"><i class="fas fa-calendar-alt "  title="Calendar" aria-label="Calendar"></i></a>
                                        </div>
                                    </fieldset>
                                    <div class="form-control-feedback invalid-feedback" id="id_error_startdate" >

                                    </div>
                                </div>
                            </div>
                            <div class="groupInput">
                                <label for="">Course strat date</label>
                                <div class="form-inline align-items-start felement" data-fieldtype="date_time_selector">
                                    <fieldset data-fieldtype="date_time" class="m-0 p-0 border-0" id="id_startdate">
                                        <legend class="sr-only">Begin datum</legend>
                                        <div class="fdate_time_selector d-flex flex-wrap align-items-center">
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_day">
                                                    Day
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[day]" id="id_startdate_day" >
                                                    <option value="1"   >1</option>
                                                    <option value="2"   >2</option>
                                                    <option value="3"   >3</option>
                                                    <option value="4"   >4</option>
                                                    <option value="5"   >5</option>
                                                    <option value="6"   >6</option>
                                                    <option value="7"   >7</option>
                                                    <option value="8"   >8</option>
                                                    <option value="9"   >9</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"  selected  >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27"  >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_day" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_month">
                                                    Month
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[month]" id="id_startdate_month">
                                                    <option value="1"   >January</option>
                                                    <option value="2"   >February</option>
                                                    <option value="3"   >March</option>
                                                    <option value="4"   >April</option>
                                                    <option value="5"   >May</option>
                                                    <option value="6"   >June</option>
                                                    <option value="7"   >July</option>
                                                    <option value="8"   >August</option>
                                                    <option value="9"  >September</option>
                                                    <option value="10"   >October</option>
                                                    <option value="11" selected   >November</option>
                                                    <option value="12"   >December</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_month" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_year">
                                                    Year
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[year]" id="id_startdate_year">
                                                <option value="2021" selected  >2021</option>
                                                <option value="2022"   >2022</option>
                                                <option value="2023"   >2023</option>
                                                <option value="2024"   >2024</option>
                                                <option value="2025"   >2025</option>
                                                <option value="2026"   >2026</option>
                                                <option value="2027"   >2027</option>
                                                <option value="2028"   >2028</option>
                                                <option value="2029"   >2029</option>
                                                <option value="2030"   >2030</option>
                                                <option value="2031"   >2031</option>
                                                <option value="2032"   >2032</option>
                                                <option value="2033"   >2033</option>
                                                <option value="2034"   >2034</option>
                                                <option value="2035"   >2035</option>
                                                <option value="2036"   >2036</option>
                                                <option value="2037"   >2037</option>
                                                <option value="2038"   >2038</option>
                                                <option value="2039"   >2039</option>
                                                <option value="2040"   >2040</option>
                                                <option value="2041"   >2041</option>
                                                <option value="2042"   >2042</option>
                                                <option value="2043"   >2043</option>
                                                <option value="2044"   >2044</option>
                                                <option value="2045"   >2045</option>
                                                <option value="2046"   >2046</option>
                                                <option value="2047"   >2047</option>
                                                <option value="2048"   >2048</option>
                                                <option value="2049"   >2049</option>
                                                <option value="2050"   >2050</option>
                                            </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_year" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_hour">
                                                    Hour
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[hour]" id="id_startdate_hour">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_hour" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_minute">
                                                    Minute
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[minute]" id="id_startdate_minute">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27"   >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                    <option value="32"   >32</option>
                                                    <option value="33"   >33</option>
                                                    <option value="34"   >34</option>
                                                    <option value="35"   >35</option>
                                                    <option value="36"   >36</option>
                                                    <option value="37"   >37</option>
                                                    <option value="38"   >38</option>
                                                    <option value="39"   >39</option>
                                                    <option value="40"   >40</option>
                                                    <option value="41"   >41</option>
                                                    <option value="42"   >42</option>
                                                    <option value="43"   >43</option>
                                                    <option value="44"   >44</option>
                                                    <option value="45"   >45</option>
                                                    <option value="46"   >46</option>
                                                    <option value="47"   >47</option>
                                                    <option value="48"   >48</option>
                                                    <option value="49"   >49</option>
                                                    <option value="50"   >50</option>
                                                    <option value="51"   >51</option>
                                                    <option value="52"   >52</option>
                                                    <option value="53"   >53</option>
                                                    <option value="54"   >54</option>
                                                    <option value="55"   >55</option>
                                                    <option value="56"   >56</option>
                                                    <option value="57"   >57</option>
                                                    <option value="58"   >58</option>
                                                    <option value="59"   >59</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_minute" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <a name="startdate[calendar]" href="#" id="id_startdate_calendar"><i class="fas fa-calendar-alt "  title="Calendar" aria-label="Calendar"></i></a>
                                        </div>
                                    </fieldset>
                                    <div class="form-control-feedback invalid-feedback" id="id_error_startdate" >

                                    </div>
                                </div>
                            </div>
                            <div class="groupInput">
                                <label for="">Locatie</label>
                                <div class="d-flex">
                                    <input type="text" placeholder="Stad" class="stadINput">
                                    <select class="selectLand" name="" id="">
                                        <option value="">Land</option>
                                        <option value="">Saab</option>
                                    </select>
                                </div>
                            </div>
                            <div class="groupInput">
                                <label for="">Adres</label>
                                <input type="text" placeholder="Adres" class="adressInput">
                            </div>
                        </div>
                        <div class="elementInputCours">

                            <div class="groupInput">
                                <label for="">Course end date</label>
                                <div class="form-inline align-items-start felement" data-fieldtype="date_time_selector">
                                    <fieldset data-fieldtype="date_time" class="m-0 p-0 border-0" id="id_startdate">
                                        <legend class="sr-only">Begin datum</legend>
                                        <div class="fdate_time_selector d-flex flex-wrap align-items-center">
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_day">
                                                    Day
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[day]" id="id_startdate_day" >
                                                    <option value="1"   >1</option>
                                                    <option value="2"   >2</option>
                                                    <option value="3"   >3</option>
                                                    <option value="4"   >4</option>
                                                    <option value="5"   >5</option>
                                                    <option value="6"   >6</option>
                                                    <option value="7"   >7</option>
                                                    <option value="8"   >8</option>
                                                    <option value="9"   >9</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27" selected  >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_day" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_month">
                                                    Month
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[month]" id="id_startdate_month">
                                                    <option value="1"   >January</option>
                                                    <option value="2"   >February</option>
                                                    <option value="3"   >March</option>
                                                    <option value="4"   >April</option>
                                                    <option value="5"   >May</option>
                                                    <option value="6"   >June</option>
                                                    <option value="7"   >July</option>
                                                    <option value="8"   >August</option>
                                                    <option value="9" selected  >September</option>
                                                    <option value="10"   >October</option>
                                                    <option value="11"   >November</option>
                                                    <option value="12"   >December</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_month" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_year">
                                                    Year
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[year]" id="id_startdate_year">
                                                <option value="2021" selected  >2021</option>
                                                <option value="2022"   >2022</option>
                                                <option value="2023"   >2023</option>
                                                <option value="2024"   >2024</option>
                                                <option value="2025"   >2025</option>
                                                <option value="2026"   >2026</option>
                                                <option value="2027"   >2027</option>
                                                <option value="2028"   >2028</option>
                                                <option value="2029"   >2029</option>
                                                <option value="2030"   >2030</option>
                                                <option value="2031"   >2031</option>
                                                <option value="2032"   >2032</option>
                                                <option value="2033"   >2033</option>
                                                <option value="2034"   >2034</option>
                                                <option value="2035"   >2035</option>
                                                <option value="2036"   >2036</option>
                                                <option value="2037"   >2037</option>
                                                <option value="2038"   >2038</option>
                                                <option value="2039"   >2039</option>
                                                <option value="2040"   >2040</option>
                                                <option value="2041"   >2041</option>
                                                <option value="2042"   >2042</option>
                                                <option value="2043"   >2043</option>
                                                <option value="2044"   >2044</option>
                                                <option value="2045"   >2045</option>
                                                <option value="2046"   >2046</option>
                                                <option value="2047"   >2047</option>
                                                <option value="2048"   >2048</option>
                                                <option value="2049"   >2049</option>
                                                <option value="2050"   >2050</option>
                                            </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_year" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_hour">
                                                    Hour
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[hour]" id="id_startdate_hour">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_hour" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_minute">
                                                    Minute
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[minute]" id="id_startdate_minute">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27"   >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                    <option value="32"   >32</option>
                                                    <option value="33"   >33</option>
                                                    <option value="34"   >34</option>
                                                    <option value="35"   >35</option>
                                                    <option value="36"   >36</option>
                                                    <option value="37"   >37</option>
                                                    <option value="38"   >38</option>
                                                    <option value="39"   >39</option>
                                                    <option value="40"   >40</option>
                                                    <option value="41"   >41</option>
                                                    <option value="42"   >42</option>
                                                    <option value="43"   >43</option>
                                                    <option value="44"   >44</option>
                                                    <option value="45"   >45</option>
                                                    <option value="46"   >46</option>
                                                    <option value="47"   >47</option>
                                                    <option value="48"   >48</option>
                                                    <option value="49"   >49</option>
                                                    <option value="50"   >50</option>
                                                    <option value="51"   >51</option>
                                                    <option value="52"   >52</option>
                                                    <option value="53"   >53</option>
                                                    <option value="54"   >54</option>
                                                    <option value="55"   >55</option>
                                                    <option value="56"   >56</option>
                                                    <option value="57"   >57</option>
                                                    <option value="58"   >58</option>
                                                    <option value="59"   >59</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_minute" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <a name="startdate[calendar]" href="#" id="id_startdate_calendar"><i class="fas fa-calendar-alt "  title="Calendar" aria-label="Calendar"></i></a>
                                        </div>
                                    </fieldset>
                                    <div class="form-control-feedback invalid-feedback" id="id_error_startdate" >

                                    </div>
                                </div>
                            </div>
                            <div class="groupInput">
                                <label for="">Course strat date</label>
                                <div class="form-inline align-items-start felement" data-fieldtype="date_time_selector">
                                    <fieldset data-fieldtype="date_time" class="m-0 p-0 border-0" id="id_startdate">
                                        <legend class="sr-only">Begin datum</legend>
                                        <div class="fdate_time_selector d-flex flex-wrap align-items-center">
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_day">
                                                    Day
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[day]" id="id_startdate_day" >
                                                    <option value="1"   >1</option>
                                                    <option value="2"   >2</option>
                                                    <option value="3"   >3</option>
                                                    <option value="4"   >4</option>
                                                    <option value="5"   >5</option>
                                                    <option value="6"   >6</option>
                                                    <option value="7"   >7</option>
                                                    <option value="8"   >8</option>
                                                    <option value="9"   >9</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"  selected  >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27"  >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_day" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_month">
                                                    Month
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[month]" id="id_startdate_month">
                                                    <option value="1"   >January</option>
                                                    <option value="2"   >February</option>
                                                    <option value="3"   >March</option>
                                                    <option value="4"   >April</option>
                                                    <option value="5"   >May</option>
                                                    <option value="6"   >June</option>
                                                    <option value="7"   >July</option>
                                                    <option value="8"   >August</option>
                                                    <option value="9"  >September</option>
                                                    <option value="10"   >October</option>
                                                    <option value="11" selected   >November</option>
                                                    <option value="12"   >December</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_month" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_year">
                                                    Year
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[year]" id="id_startdate_year">
                                                <option value="2021" selected  >2021</option>
                                                <option value="2022"   >2022</option>
                                                <option value="2023"   >2023</option>
                                                <option value="2024"   >2024</option>
                                                <option value="2025"   >2025</option>
                                                <option value="2026"   >2026</option>
                                                <option value="2027"   >2027</option>
                                                <option value="2028"   >2028</option>
                                                <option value="2029"   >2029</option>
                                                <option value="2030"   >2030</option>
                                                <option value="2031"   >2031</option>
                                                <option value="2032"   >2032</option>
                                                <option value="2033"   >2033</option>
                                                <option value="2034"   >2034</option>
                                                <option value="2035"   >2035</option>
                                                <option value="2036"   >2036</option>
                                                <option value="2037"   >2037</option>
                                                <option value="2038"   >2038</option>
                                                <option value="2039"   >2039</option>
                                                <option value="2040"   >2040</option>
                                                <option value="2041"   >2041</option>
                                                <option value="2042"   >2042</option>
                                                <option value="2043"   >2043</option>
                                                <option value="2044"   >2044</option>
                                                <option value="2045"   >2045</option>
                                                <option value="2046"   >2046</option>
                                                <option value="2047"   >2047</option>
                                                <option value="2048"   >2048</option>
                                                <option value="2049"   >2049</option>
                                                <option value="2050"   >2050</option>
                                            </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_year" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem  " >
                                                <label class="col-form-label sr-only" for="id_startdate_hour">
                                                    Hour
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[hour]" id="id_startdate_hour">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_hour" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="form-group  fitem">
                                                <label class="col-form-label sr-only" for="id_startdate_minute">
                                                    Minute
                                                </label>
                                                <span data-fieldtype="select">
                                                <select class="custom-select" name="startdate[minute]" id="id_startdate_minute">
                                                    <option value="0" selected  >00</option>
                                                    <option value="1"   >01</option>
                                                    <option value="2"   >02</option>
                                                    <option value="3"   >03</option>
                                                    <option value="4"   >04</option>
                                                    <option value="5"   >05</option>
                                                    <option value="6"   >06</option>
                                                    <option value="7"   >07</option>
                                                    <option value="8"   >08</option>
                                                    <option value="9"   >09</option>
                                                    <option value="10"   >10</option>
                                                    <option value="11"   >11</option>
                                                    <option value="12"   >12</option>
                                                    <option value="13"   >13</option>
                                                    <option value="14"   >14</option>
                                                    <option value="15"   >15</option>
                                                    <option value="16"   >16</option>
                                                    <option value="17"   >17</option>
                                                    <option value="18"   >18</option>
                                                    <option value="19"   >19</option>
                                                    <option value="20"   >20</option>
                                                    <option value="21"   >21</option>
                                                    <option value="22"   >22</option>
                                                    <option value="23"   >23</option>
                                                    <option value="24"   >24</option>
                                                    <option value="25"   >25</option>
                                                    <option value="26"   >26</option>
                                                    <option value="27"   >27</option>
                                                    <option value="28"   >28</option>
                                                    <option value="29"   >29</option>
                                                    <option value="30"   >30</option>
                                                    <option value="31"   >31</option>
                                                    <option value="32"   >32</option>
                                                    <option value="33"   >33</option>
                                                    <option value="34"   >34</option>
                                                    <option value="35"   >35</option>
                                                    <option value="36"   >36</option>
                                                    <option value="37"   >37</option>
                                                    <option value="38"   >38</option>
                                                    <option value="39"   >39</option>
                                                    <option value="40"   >40</option>
                                                    <option value="41"   >41</option>
                                                    <option value="42"   >42</option>
                                                    <option value="43"   >43</option>
                                                    <option value="44"   >44</option>
                                                    <option value="45"   >45</option>
                                                    <option value="46"   >46</option>
                                                    <option value="47"   >47</option>
                                                    <option value="48"   >48</option>
                                                    <option value="49"   >49</option>
                                                    <option value="50"   >50</option>
                                                    <option value="51"   >51</option>
                                                    <option value="52"   >52</option>
                                                    <option value="53"   >53</option>
                                                    <option value="54"   >54</option>
                                                    <option value="55"   >55</option>
                                                    <option value="56"   >56</option>
                                                    <option value="57"   >57</option>
                                                    <option value="58"   >58</option>
                                                    <option value="59"   >59</option>
                                                </select>
                                            </span>
                                                <div class="form-control-feedback invalid-feedback" id="id_error_startdate_minute" >

                                                </div>
                                            </div>
                                            &nbsp;
                                            <a name="startdate[calendar]" href="#" id="id_startdate_calendar"><i class="fas fa-calendar-alt "  title="Calendar" aria-label="Calendar"></i></a>
                                        </div>
                                    </fieldset>
                                    <div class="form-control-feedback invalid-feedback" id="id_error_startdate" >

                                    </div>
                                </div>
                            </div>
                            <div class="groupInput">
                                <label for="">Locatie</label>
                                <div class="d-flex">
                                    <input type="text" placeholder="Stad" class="stadINput">
                                    <select class="selectLand" name="" id="">
                                        <option value="">Land</option>
                                        <option value="">Saab</option>
                                    </select>
                                </div>
                            </div>
                            <div class="groupInput">
                                <label for="">Adres</label>
                                <input type="text" placeholder="Adres" class="adressInput">
                            </div>
                        </div>

                        <div class="blockButton2">
                            <button id="terugData" class="btn btnSubmit">Terug</button>
                            <button id="VerderData" class="btn btnCancel">Verder</button>
                        </div>
                    </form>
                </div>

                <div id="Details" class="w-100">
                    <div class="titleOpleidingstype">
                        <h2>5.Details en onderwerpen </h2>
                        <?php acf_form(array(
                            'post_id'       => 'new_post',
                            'post_status'	=> 'publish',
                            'post_type'     => 'course',
                            'field_groups' => array('group_6155e73fb1744'),
                            'submit_value'  => __('Save')
                        )); ?>
                    </div>
                    <form action="" >
                        <div class="elementInputCours">
                            <div class="groupInput">
                                <label for="">Incompany mogelijk ?</label>
                                <div class="JaNeeBlock">
                                    <input type="radio" id="Ja" name="chooseIncompany" value="Ja">
                                      <label for="Ja">Ja</label>
                                      <input type="radio" id="Nee" name="chooseIncompany" value="Nee">
                                      <label for="Nee">Nee</label>
                                </div>
                            </div>
                            <div class="groupInput">
                                <label for="">Niveau</label>
                                <div class="selectBlock">
                                    <select class="selectLand" name="" id="">
                                        <option value="">Niveau</option>
                                        <option value="">Licence</option>
                                        <option value="">Master</option>
                                    </select>
                                    <select class="selectLand" name="" id="">
                                        <option value="">Geacrediteerd</option>
                                        <option value="">Saab</option>
                                    </select>
                                </div>
                            </div>
                            <div class="groupInput">
                                <label for="">Btw-klasse</label>
                                <select class="selectBlockBtw" name="" id="">
                                    <option value="">Niveau</option>
                                    <option value="">Licence</option>
                                    <option value="">Master</option>
                                </select>
                            </div>
                        </div>
                        <div class="elementInputCours">
                            <div class="groupInput2">
                                <div>
                                    <label for="">Voor welke <b>specifieke baan</b> is de opleiding</label>
                                </div>
                                <img class="imgSelectModife" src="img/selectDown.png" alt="">
                                <select class="choices-multiple-remove-button" placeholder="Select upto 5 tags" multiple>
                                    <option value="HTML">Banen</option>
                                    <option value="Jquery">Salesmanager</option>
                                    <option value="CSS">Marktkoopman</option>
                                    <option value="CSS">Marktkoopman</option>
                                    <option value="CSS">Marktkoopman</option>
                                    <option value="CSS">Marktkoopman</option>
                                </select>
                            </div>
                        </div>
                        <div class="elementInputCours">
                            <div class="groupInput2">
                                <div>
                                    <label for="">Welke <b>skills</b>leer je met deze opleiding</label>
                                </div>
                                <img class="imgSelectModife" src="img/selectDown.png" alt="">
                                <select class="choices-multiple-remove-button" placeholder="Select upto 5 tags" multiple>
                                    <option value="HTML">Skills</option>
                                    <option value="Jquery">Verkopen</option>
                                    <option value="CSS">Account management</option>
                                    <option value="CSS">Marktkoopman</option>
                                </select>
                            </div>
                        </div>
                        <div class="elementInputCours">
                            <div class="groupInput2">
                                <div>
                                    <label for=""><b>Persoonlikje interesses</b>die je ontwikkelt</label>
                                </div>
                                <img class="imgSelectModife" src="img/selectDown.png" alt="">
                                <select class="choices-multiple-remove-button" placeholder="Select upto 5 tags" multiple>
                                    <option value="HTML">Interesses</option>
                                    <option value="Jquery">Onderhandelen</option>
                                    <option value="CSS">Account management</option>
                                    <option value="CSS">Marktkoopman</option>
                                </select>
                            </div>
                        </div>
                        <div class="elementInputCours">
                            <div class="groupInput2">
                                <div>
                                    <label for=""><b>Experts </b>die betrokken zijn bij deze opleiding</label>
                                </div>
                                <img class="imgSelectModife" src="img/selectDown.png" alt="">
                                <select class="choices-multiple-remove-button" placeholder="Select upto 5 tags" multiple>
                                    <option value="HTML">Interesses</option>
                                    <option value="Jquery">Onderhandelen</option>
                                    <option value="CSS">Account management</option>
                                    <option value="CSS">Marktkoopman</option>
                                </select>
                            </div>
                        </div>
                        <div class="blockButton2">
                            <button id="terugDetails" type="button" class="btn btnSubmit">Terug</button>
                            <button id="VerderDetails" type="submit" class="btn btnCancel">Verder</button>
                        </div>
                    </form>
                </div>
        </div>
        </div>
        <div class="col-md-3 col-lg-2 col-sm-12">
            <div class="blockCourseToevoegen">
                <p class="courseToevoegenText">Course toevoegen</p>
                <div class="contentBlockRight">
                    <div class="contentBlockCourse">
                        <div class="circleIndicator passEtape"></div>
                        <p class="textOpleidRight">Opleidingstype</p>
                    </div>
                    <div class="contentBlockCourse">
                        <div class="circleIndicator passEtape2"></div>
                        <p class="textOpleidRight">Basis informatie</p>
                    </div>
                    <div class="contentBlockCourse">
                        <div class="circleIndicator "></div>
                        <p class="textOpleidRight">Uitgebreide beschrijving</p>
                    </div>
                    <div class="contentBlockCourse">
                        <div class="circleIndicator "></div>
                        <p class="textOpleidRight ">Data en locaties</p>
                    </div>
                    <div class="contentBlockCourse">
                        <div class="circleIndicator "></div>
                        <p class="textOpleidRight">Details en onderwepren</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
<?php wp_footer(); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/main.js"></script>
<script>
    $('#chooseFile4').bind('change', function () {
        var filename = $("#chooseFile4").val();
        if (/^\s*$/.test(filename)) {
            $(".file-upload").removeClass('active');
            $("#noFile4").text("No file chosen...");
        }
        else {
            $(".file-upload").addClass('active');
            $("#noFile4").text(filename.replace("C:\\fakepath\\", ""));
        }
    });

</script>
<script>
    $(document).ready(function(){

        var multipleCancelButton = new Choices('.choices-multiple-remove-button', {
            removeItemButton: true,
            maxItemCount:5,
            searchResultLimit:5,
            renderChoiceLimit:5
        });


    });
</script>






