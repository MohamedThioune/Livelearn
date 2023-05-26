<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>

<div class="content-new-statistic" id="tab-url1">
    <div class="d-flex justify-content-between flex-wrap">
        <div class="profil-view-statistic d-flex">
            <div class="img-user">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/dan.jpg" alt="">
            </div>
            <div>
                <p class="name-profil-view">Daniel Van der kook</p>
                <p class="date-register">Since 2020</p>
            </div>
        </div>
        <div class="tab-element">
            <ul class="nav">
                <li class="nav-one"><a href="" class="current">Company</a></li>
                <li class="nav-two"><a href="">Team</a></li>
                <li class="nav-three"><a href="">Individual</a></li>
            </ul>
        </div>
    </div>

    <div class="body-content-view-statistic">
        <div id="Company" class="">
            <div class="group-card-head d-flex flex-wrap justify-content-between">
                <div class="card-element-company d-flex align-items-center bg-bleu-c">
                    <div class="content-fa">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/faUser.png" alt="">
                    </div>
                    <div>
                        <p class="total-member">Total Members</p>
                        <p class="number-members">3280</p>
                    </div>
                </div>
                <div class="card-element-company d-flex align-items-center bg-yellow-c">
                    <select class="form-select" aria-label="Default select example">
                        <option value="Month">Par Month</option>
                        <option value="year">Per year</option>
                        <option value="week">Per week</option>
                    </select>
                    <div class="content-fa">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/faUser.png" alt="">
                    </div>
                    <div>
                        <p class="total-member">New Members</p>
                        <p class="number-members">280</p>
                    </div>
                </div>
                <div class="card-element-company d-flex align-items-center bg-purple-c">
                    <div class="content-fa">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/faCourse.png" alt="">
                    </div>
                    <div>
                        <p class="total-member">Total Course</p>
                        <p class="number-members">380</p>
                    </div>
                </div>
            </div>
            <div>
                <select class="form-select select-statistic" aria-label="Default select example">
                    <option value="General">General</option>
                    <option value="year">First Team</option>
                    <option value="week">Second Team</option>
                </select>
            </div>
            <div class="card-statistic">
                <h2>Course categories (topics) finished according to the number of users in the company</h2>
                <div class="statistic-bar">
                    <div class="progress-bar horizontal">

                        <div class="progress-element">
                            <label class="skillName">Zorg:</label>
                            <div class="progress-track">
                                <div class="progress-fill">
                                    <span>25%</span>
                                </div>
                            </div>
                            <p class="text-percentage">25%</p>
                        </div>

                        <div class="progress-element">
                            <label class="skillName">IT / Data:</label>
                            <div class="progress-track">
                                <div class="progress-fill">
                                    <span>70%</span>
                                </div>
                            </div>
                            <p class="text-percentage">70%</p>
                        </div>

                        <div class="progress-element">
                            <label class="skillName">Handel:</label>
                            <div class="progress-track">
                                <div class="progress-fill">
                                    <span>60%</span>
                                </div>
                            </div>
                            <p class="text-percentage">60%</p>
                        </div>

                        <div class="progress-element">
                            <label class="skillName">Financieel :</label>
                            <div class="progress-track">
                                <div class="progress-fill">
                                    <span>50%</span>
                                </div>
                            </div>
                            <p class="text-percentage">50%</p>
                        </div>

                        <div class="progress-element">
                            <label class="skillName">Logistiek:</label>
                            <div class="progress-track">
                                <div class="progress-fill">
                                    <span>40%</span>
                                </div>
                            </div>
                            <p class="text-percentage">40%</p>
                        </div>

                        <div class="progress-element">
                            <label class="skillName">Marketing:</label>
                            <div class="progress-track">
                                <div class="progress-fill">
                                    <span>30%</span>
                                </div>
                            </div>
                            <p class="text-percentage">30%</p>
                        </div>

                        <div class="progress-element">
                            <label class="skillName">Hardware:</label>
                            <div class="progress-track">
                                <div class="progress-fill">
                                    <span>20%</span>
                                </div>
                            </div>
                            <p class="text-percentage">20%</p>
                        </div>

                        <div class="progress-element">
                            <label class="skillName">Media:</label>
                            <div class="progress-track">
                                <div class="progress-fill">
                                    <span>78%</span>
                                </div>
                            </div>
                            <p class="text-percentage">78%</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="block-circular-bar">
                <div class="card-circular-bar">
                    <div class="head d-flex justify-content-between align-items-center">
                        <h2>User Engagement:</h2>
                        <select class="form-select" aria-label="Default select example">
                            <option value="Month">Januari</option>
                            <option value="year">Februari</option>
                            <option value="week">Maart</option>
                        </select>
                    </div>
                    <div>
                        <canvas id="ChartEngagement"></canvas>
                    </div>
                </div>
                <div class="card-circular-bar">
                    <div class="head d-flex justify-content-between align-items-center">
                        <h2 >user progress in the courses <span>(55) :</span></h2>
                    </div>
                    <div>
                        <canvas id="ChartCourse"></canvas>
                    </div>
                </div>
                <div class="card-circular-bar">
                    <div class="head d-flex justify-content-between align-items-center">
                        <h2 class="title-card-statistic">Assessment <span>(25)</span> :</h2>
                    </div>
                    <div>
                        <canvas id="ChartAssessment"></canvas>
                    </div>
                </div>
            </div>
            <div class="subTopics-usage-block d-flex flex-wrap justify-content-between">
                <div class="subTopics-card">
                    <p class="title">Most Subtopics view by your company</p>
                    <p class="number-subTopcis">36</p>
                    <p class="sub-title-topics">SubTopics</p>
                    <div class="element-SubTopics d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="imgTopics">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/ecosystem.jpeg" alt="">
                            </div>
                            <p class="text-subTopics">(Detail) Handel</p>
                        </div>
                        <p class="number">641</p>
                    </div>
                    <div class="element-SubTopics d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="imgTopics">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/ecosystem.jpeg" alt="">
                            </div>
                            <p class="text-subTopics">(Detail) Handel</p>
                        </div>
                        <p class="number">641</p>
                    </div>
                    <div class="element-SubTopics d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="imgTopics">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/ecosystem.jpeg" alt="">
                            </div>
                            <p class="text-subTopics">Bouw</p>
                        </div>
                        <p class="number">641</p>
                    </div>
                    <div class="element-SubTopics d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="imgTopics">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/ecosystem.jpeg" alt="">
                            </div>
                            <p class="text-subTopics">Financieel / Juridisch</p>
                        </div>
                        <p class="number">641</p>
                    </div>
                    <div class="element-SubTopics d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="imgTopics">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/ecosystem.jpeg" alt="">
                            </div>
                            <p class="text-subTopics">IT / Data</p>
                        </div>
                        <p class="number">641</p>
                    </div>
                    <div class="element-SubTopics d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="imgTopics">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/ecosystem.jpeg" alt="">
                            </div>
                            <p class="text-subTopics">Transport / Logistiek</p>
                        </div>
                        <p class="number">641</p>
                    </div>
                    <div class="element-SubTopics d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="imgTopics">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/ecosystem.jpeg" alt="">
                            </div>
                            <p class="text-subTopics">Zorg</p>
                        </div>
                        <p class="number">641</p>
                    </div>
                    <div class="element-SubTopics d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="imgTopics">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/ecosystem.jpeg" alt="">
                            </div>
                            <p class="text-subTopics">Cultuur</p>
                        </div>
                        <p class="number">641</p>
                    </div>
                </div>
                <div class="usage-block-card-team">
                    <h2>Usage desktop vs Mobile app</h2>
                    <div>
                        <canvas id="ChartDesktopMobile"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-course">
                <h2>Popular Course</h2>
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th scope="col courseTitle">Course Title</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Type</th>
                        <th scope="col">Instructor</th>
                        <th scope="col">Done</th>
                        <th scope="col">Not Started</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <a href="/" class="name-element">UX - UI Design certificat</a>
                        </td>
                        <td>
                            <p class="name-element">12h 33m 10s</p>
                        </td>
                        <td>
                            <p class="name-element">IT / Data</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/" class="name-element">Motion design </a>
                        </td>
                        <td>
                            <p class="name-element">12h 33m 10s</p>
                        </td>
                        <td>
                            <p class="name-element">IT / Data</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/" class="name-element">videeo annimate After Effect</a>
                        </td>
                        <td>
                            <p class="name-element">12h 33m 10s</p>
                        </td>
                        <td>
                            <p class="name-element">IT / Data</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/" class="name-element">Een nieuwe video door Daniel</a>
                        </td>
                        <td>
                            <p class="name-element">12h 33m 10s</p>
                        </td>
                        <td>
                            <p class="name-element">IT / Data</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/" class="name-element">Oefening</a>
                        </td>
                        <td>
                            <p class="name-element">12h 33m 10s</p>
                        </td>
                        <td>
                            <p class="name-element">IT / Data</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js'></script>


<script>
    $('.horizontal .progress-fill span').each(function(){
        var percent = $(this).html();
        $(this).parent().css('width', percent);
    });

</script>

<script>
    var ctx = document.getElementById("ChartEngagement").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Active",	"Inactive"],
            datasets: [{
                data: [90,	10], // Specify the data values array

                borderColor: ['#47A99E', '#FF0000'], // Add custom color border
                backgroundColor: ['#47A99E', '#FF0000'], // Add custom color background (Points and Fill)
            }]},
        options: {
            maintainAspectRatio: false,
            legend: {
                position: 'bottom' // Positionnement de la légende en bas
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById("ChartCourse").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Courses completed",	"Courses in progress",	"Courses not started"],
            datasets: [{
                data: [30,	40,	30], // Specify the data values array

                borderColor: ['#47A99E', '#94A3B8', '#515365'], // Add custom color border
                backgroundColor: ['#47A99E', '#94A3B8', '#515365'], // Add custom color background (Points and Fill)
            }]},
        options: {
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
            legend: {
                position: 'bottom' // Positionnement de la légende en bas
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById("ChartAssessment").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Asess... completed",	"Asess... in progress",	"Asessment not started"],
            datasets: [{
                data: [30,	30,	40], // Specify the data values array
                borderColor: ['#47A99E', '#94A3B8', '#515365'], // Add custom color border
                backgroundColor: ['#47A99E', '#94A3B8', '#515365'], // Add custom color background (Points and Fill)

            }]},
        options: {
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
            legend: {
                position: 'bottom',
            }
        }
    });
</script>

<!--pour desktop mobile-->
<script>
    var ctx = document.getElementById('ChartDesktopMobile').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mrt', 'April', 'Mei', 'Juni', 'Juli', 'Agtus', 'Sept', 'Okt', 'Nov', 'Dec'],
            datasets: [{
                label: 'apples',
                data: [60, 50, 40, 70, 120, 150, 140, 100, 80, 50, 22, 0],
                backgroundColor: "#247ADC"
            }, {
                label: 'oranges',
                data: [0,57, 129, 42, 183, 91, 175, 68, 106, 15, 199, 0,],
                backgroundColor: "#5AA1F2"
            }]
        },
        options: {
            responsive: true, // Instruct chart js to respond nicely.
        }
    });
</script>