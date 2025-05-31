<?php
$startYear = 2023;
$thisYear = date('Y');
if ($startYear == $thisYear) {
    $output = $thisYear;
} else {
    $output = "{$startYear}&ndash;{$thisYear}";
}

?>


<!-- partial:partials/_footer.html -->
<footer class="footer">
    <div class="footer-inner-wraper">
        <div class="d-sm-flex justify-content-center justify-content-sm-between py-2">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="#" target="_blank"></a><?= $output ?> All rights reserved</span>
            <span pan class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">LPPO-CAMMS<a href="#" target="_blank"></a></span>
        </div>
    </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="./template/assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="./template/assets/vendors/chart.js/Chart.min.js"></script>
<script src="./template/assets/vendors/jquery-circle-progress/js/circle-progress.min.js"></script>
<script src="./template/assets/js/jquery.cookie.js" type="text/javascript"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="./template/assets/js/off-canvas.js"></script>
<script src="./template/assets/js/hoverable-collapse.js"></script>
<script src="./template/assets/js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="./template/assets/js/dashboard.js"></script>
<!-- <script src="./template/assets/js/chart.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- End custom js for this page -->

<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
<!-- <script src="./js/jquery-3.7.1.min.js"></script> -->

<script src="./js/swal.js"></script>
<script src="./js/pass.js"></script>
<!-- <script src="./js/script.js"></script> -->


<script>
    // // notification_API
    // const notificationapi = new NotificationAPI({
    //     clientId: '45lpstrfqrk4jut97a09t7ak77',
    //     userId: 'seduxer.edgar@yahoo.com'
    // });

    // notificationapi.showInApp({
    //     root: 'CONTAINER-DIV-ID',
    //     popupPosition: 'topLeft'
    // });

    //Bar Chart
    var ctxUsers = document.getElementById('myUsersBar').getContext('2d');
    var UsersBar = new Chart(ctxUsers, {
        type: 'bar',
        data: {
            labels: ['Total', 'Verified', 'Inactive'],
            datasets: [{
                    label: 'Total',
                    data: [<?= $num_user ?>, 0, 0], // Set other dataset values to 0 for now
                    backgroundColor: 'rgba(84, 198, 235, 0.2)',
                    borderColor: 'rgba(84, 198, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Verified',
                    data: [0, <?= $num_user_verified ?>, 0], // Set other dataset values to 0 for now
                    backgroundColor: 'rgba(6, 214, 160, 0.2)',
                    borderColor: 'rgba(6, 214, 160, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Inactive',
                    data: [0, 0, <?= $num_user_inactive ?>], // Set other dataset values to 0 for now
                    backgroundColor: 'rgba(242, 152, 146, 0.2)',
                    borderColor: 'rgba(242, 152, 146, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true,
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Registered Users',
                    font: {
                        size: 16
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }

        }
    });


    //bar chart
    var ctxBar = document.getElementById('petitionersChart').getContext('2d');
    var barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Total', 'Pending', 'Granted', 'Denied'],
            datasets: [{
                    label: 'Total',
                    data: [<?= $client_count ?>, 0, 0, 0],
                    backgroundColor: 'rgba(84, 198, 235, 0.2)',
                    borderColor: 'rgba(84, 198, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Pending',
                    data: [0, <?= $pending_count ?>, 0, 0],
                    backgroundColor: 'rgba(254, 232, 154, 0.2)',
                    borderColor: 'rgba(254, 232, 154, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Granted',
                    data: [0, 0, <?= $granted_count ?>, 0],
                    backgroundColor: 'rgba(6, 214, 160, 0.2)',
                    borderColor: 'rgba(6, 214, 160, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Denied',
                    data: [0, 0, 0, <?= $denied_count ?>],
                    backgroundColor: 'rgba(242, 152, 146, 0.2)',
                    borderColor: 'rgba(242, 152, 146, 1)',
                    borderWidth: 1
                },
            ]
        },
        options: {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Petitioners',
                    font: {
                        size: 16
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    barPercentage: 0.2, 
                    categoryPercentage: 0.2,
                    barThickness: 100
                }
            }
        },
    });

    //Bar chart
    var ctxDoughnut = document.getElementById('probationersChart').getContext('2d');
    var doughnutChart = new Chart(ctxDoughnut, {
        type: 'bar',
        data: {
            labels: ['Total', 'Ongoing', 'Completed', 'Revoked'],
            datasets: [{
                label: '',
                data: [<?= $granted_count ?>, <?= $grant_count ?>, <?= $completed_count ?>, <?= $revoked_count ?>],
                backgroundColor: [
                    'rgba(84, 198, 235, 0.2)',
                    'rgba(254, 232, 154, 0.2)',
                    'rgba(6, 214, 160, 0.2)',
                    'rgba(242, 152, 146, 0.2)'
                ],
                borderColor: [
                    'rgba(84, 198, 235, 1)',
                    'rgba(254, 232, 154, 1)',
                    'rgba(6, 214, 160, 1)',
                    'rgba(242, 152, 146, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true

            },
            plugins: {
                title: {
                    display: true,
                    text: 'Probationers',
                    font: {
                        size: 16
                    }
                }
            }
        },
    });



    //sweetalert
    function showImage(fileName, requirementName) {
        // Construct the image URL based on the fileName and requirementName
        var imageUrl = "../../uploads/" + fileName;

        // Customize the message based on the requirementName
        var message = "";
        switch (requirementName) {
            case "birth_certificate":
                message = "Viewing Birth Certificate File";
                break;
            case "valid_id":
                message = "Viewing Valid ID File";
                break;
            case "talambuhay":
                message = "Viewing Talambuhay File";
                break;
            case "barangay_clearance":
                message = "Viewing Barangay Clearance File";
                break;
            case "case_info":
                message = "Viewing Case Info File";
                break;
            case "case_judgement":
                message = "Viewing Case Judgement File";
                break;
            case "petition_for_probation":
                message = "Viewing Petiton for Probation File";
                break;
            case "order_to_conduct_ps1":
                message = "Viewing Order to Conduct PS1 File";
                break;
            case "case_dissmissed":
                message = "Viewing Order of Dissmissed File/Accquitted Cases File";
                break;
            case "police_clearance":
                message = "Viewing Police Clearance File";
                break;
            case "mtc_mtcc_clearance":
                message = "Viewing MTC/MTCC Clearance File";
                break;
            case "nbi_clearance":
                message = "Viewing NBI Clearance File";
                break;
            case "drug_test_result":
                message = "Viewing Drug Test Result File";
                break;
                // Add more cases for additional file types if needed

            default:
                message = "Viewing File.";
        }

        Swal.fire({
            title: "Uploaded File!",
            text: message,
            imageUrl: imageUrl,
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: "Custom image"
        });
    }
</script>


</body>

</html>
<?php ob_end_flush(); ?>