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
                <li class="nav-one"><a href="" >Company</a></li>
                <li class="nav-two"><a href="" class="current">Team</a></li>
                <li class="nav-three"><a href="">Individual</a></li>
            </ul>
        </div>
    </div>

    <div class="body-content-view-statistic">
        <div id="Team" class="">
            <div class="group-card-head d-flex flex-wrap justify-content-between">
                <div class="card-element-company d-flex align-items-center ">
                    <div class="content-fa bg-bleu-c">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-team-user.png" alt="">
                    </div>
                    <div>
                        <p class="total-member">Total Members</p>
                        <p class="number-members">300</p>
                    </div>
                </div>
                <div class="card-element-company d-flex align-items-center ">
                    <div class="content-fa bg-yellow-c">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-team-actif.png" alt="">
                    </div>
                    <div>
                        <p class="total-member">Members Actifs</p>
                        <p class="number-members">280</p>
                    </div>
                </div>
                <div class="card-element-company d-flex align-items-center ">
                    <div class="content-fa bg-purple-c">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-team-allCourse.png" alt="">
                    </div>
                    <div>
                        <p class="total-member">All Course</p>
                        <p class="number-members">3800</p>
                    </div>
                </div>
                <div class="card-element-company d-flex align-items-center ">
                    <div class="content-fa bg-green-c">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-team-courseDone.png" alt="">
                    </div>
                    <div>
                        <p class="total-member">Course Done</p>
                        <p class="number-members">380</p>
                    </div>
                </div>
                <div class="card-element-company d-flex align-items-center ">
                    <div class="content-fa bg-bleuLight-c">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-team-assessment.png" alt="">
                    </div>
                    <div>
                        <p class="total-member">Assessment</p>
                        <p class="number-members">280</p>
                    </div>
                </div>
                <div class="card-element-company d-flex align-items-center ">
                    <div class="content-fa bg-dark-c">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-team-mandatory.png" alt="">
                    </div>
                    <div>
                        <p class="total-member">Mandatories</p>
                        <p class="number-members">280</p>
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
                <div class="subTopics-card ">
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
            <div class="card-course card-user-team">
                <h2>Others User</h2>
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th scope="col courseTitle">Name</th>
                        <th scope="col">Team</th>
                        <th scope="col">Status</th>
                        <th scope="col">Persoonsgebonden Budget</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                         <tr>
                        <td class="d-flex align-items-center">
                            <div class="userImg">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <span class="name-element">Cameron Williamson</span>
                        </td>
                        <td>
                            <p class="name-element">Information Technology Team</p>
                        </td>
                        <td class="actif">
                            <span></span>
                            <p class="name-element ">Actif</p>
                        </td>
                        <td>
                            <p class="name-element">€1560.2</p>
                        </td>
                        <td class="textTh">
                            <div class="dropdown text-white">
                                <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                    <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                </p>
                                <ul class="dropdown-menu">
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">View</a></li>
                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="" target="_blank">Edit</a></li>
                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2 "></i>Remove</li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                         <tr>
                        <td class="d-flex align-items-center">
                            <div class="userImg">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <span href="/" class="name-element">Cameron Williamson</span>
                        </td>
                        <td>
                            <p class="name-element">Information Technology Team</p>
                        </td>
                        <td class="actif inactif">
                            <span></span>
                            <p class="name-element ">Actif</p>
                        </td>
                        <td>
                            <p class="name-element">€1560.2</p>
                        </td>
                        <td class="textTh">
                            <div class="dropdown text-white">
                                <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                    <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                </p>
                                <ul class="dropdown-menu">
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">View</a></li>
                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="" target="_blank">Edit</a></li>
                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2 "></i>Remove</li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                         <tr>
                        <td class="d-flex align-items-center">
                            <div class="userImg">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <span class="name-element">Cameron Williamson</span>
                        </td>
                        <td>
                            <p class="name-element">Information Technology Team</p>
                        </td>
                        <td class="actif">
                            <span></span>
                            <p class="name-element ">Actif</p>
                        </td>
                        <td>
                            <p class="name-element">€1560.2</p>
                        </td>
                        <td class="textTh">
                            <div class="dropdown text-white">
                                <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                    <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                </p>
                                <ul class="dropdown-menu">
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">View</a></li>
                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="" target="_blank">Edit</a></li>
                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2 "></i>Remove</li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                         <tr>
                        <td class="d-flex align-items-center">
                            <div class="userImg">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <span class="name-element">Cameron Williamson</span>
                        </td>
                        <td>
                            <p class="name-element">Information Technology Team</p>
                        </td>
                        <td class="actif">
                            <span></span>
                            <p class="name-element ">Actif</p>
                        </td>
                        <td>
                            <p class="name-element">€1560.2</p>
                        </td>
                        <td class="textTh">
                            <div class="dropdown text-white">
                                <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                    <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                </p>
                                <ul class="dropdown-menu">
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">View</a></li>
                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="" target="_blank">Edit</a></li>
                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2 "></i>Remove</li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                         <tr>
                        <td class="d-flex align-items-center">
                            <div class="userImg">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-1.png" alt="">
                            </div>
                            <span class="name-element">Cameron Williamson</span>
                        </td>
                        <td>
                            <p class="name-element">Information Technology Team</p>
                        </td>
                        <td class="actif">
                            <span></span>
                            <p class="name-element ">Actif</p>
                        </td>
                        <td>
                            <p class="name-element">€1560.2</p>
                        </td>
                        <td class="textTh">
                            <div class="dropdown text-white">
                                <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                    <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                </p>
                                <ul class="dropdown-menu">
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">View</a></li>
                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="" target="_blank">Edit</a></li>
                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2 "></i>Remove</li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"  crossorigin="anonymous"></script
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