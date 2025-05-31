  <?php

  $userLevel = $_SESSION['user_level'];
  $email = $_SESSION['email'];

  $dbc = mysqli_connect("localhost", "root", "", "probasyon");

  // Check connection
  if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
  }


  $notifications = getUnreadNotifications($dbc, $email);
  $notificationCount = count($notifications);


  // Define a mapping of subjects to icons and background colors
  $subjectIcons = [
    'Appointment' => ['icon' => 'mdi mdi-calendar', 'bgColor' => 'bg-success'],
    'Invalid File' => ['icon' => 'mdi mdi-file-excel', 'bgColor' => 'bg-danger'],
    'Valid File' => ['icon' => 'mdi mdi-file-check', 'bgColor' => 'bg-success'],
    'New Uploaded File' => ['icon' => 'mdi mdi-file', 'bgColor' => 'bg-info'],
    'Application Denied' => ['icon' => 'mdi mdi-alert', 'bgColor' => 'bg-danger'],
    'Revoked' => ['icon' => 'mdi mdi-alert', 'bgColor' => 'bg-danger'],
    'Granted' => ['icon' => 'mdi mdi-check-circle', 'bgColor' => 'bg-success'],
    'Completed' => ['icon' => 'mdi mdi-checkbox-marked', 'bgColor' => 'bg-success'],
    'Confirmation' => ['icon' => 'mdi mdi-alert-circle', 'bgColor' => 'bg-warning'],
    // Add more subjects and their corresponding icons and background colors as needed
  ];



  ?>

  <body>
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="" href="<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>"><img src="./assets/img/PPA.svg" alt="logo" class="img-fluid" width="65" height="50" /></a>
        <!-- <a class="navbar-brand brand-logo" href="<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>">LPPO-CAMMS</a> -->
        <!-- <a class="navbar-brand brand-logo-mini" href="<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>"><img src="./template/assets/images/LPPO_logo.svg" alt="logo" /></a> -->
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <div class="search-field d-none d-xl-block">
          <!-- <form class="d-flex align-items-center h-100" action="#">
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <i class="input-group-text border-0 mdi mdi-magnify"></i>
            </div>
            <input type="text" class="form-control bg-transparent border-0" placeholder="Search">
          </div>
        </form> -->
        </div>
        <ul class="navbar-nav navbar-nav-right">

          <?php
          if (isset($_SESSION['user_id'])) {
            $firstName = $_SESSION['first_name'];
            $lastName = $_SESSION['last_name'];
          }
          ?>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
                <i class="mdi mdi-account-circle"></i>
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black"><?php echo ucfirst($firstName) . ' ' . ucfirst($lastName); ?></p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
              <div class="p-2">
                <!-- <h5 class="dropdown-header text-uppercase ps-2 text-dark">User Options</h5> -->
                <!-- <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                <span>Inbox</span>
                <span class="p-0">
                  <span class="badge badge-primary">3</span>
                  <i class="mdi mdi-email-open-outline ms-1"></i>
                </span>
              </a> -->
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="profile.php">
                  <span>Profile</span>
                  <span class="p-0">
                    <!-- <span class="badge badge-success">1</span> -->
                    <i class="mdi mdi-account-outline ms-1"></i>
                  </span>
                </a>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="change_password.php">
                  <span>Settings</span>
                  <i class="mdi mdi-settings"></i>
                </a>
                <div role="separator" class="dropdown-divider"></div>
                <!-- <h5 class="dropdown-header text-uppercase  ps-2 text-dark mt-2">Actions</h5> -->
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="logout.php">
                  <span>Log Out</span>
                  <i class="mdi mdi-logout ms-1"></i>
                </a>
              </div>
            </div>
          </li>

          <!-- <li class="nav-item  dropdown d-none d-md-block">
              <a class="nav-link dropdown-toggle" id="reportDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false"> Reports </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="reportDropdown">
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-file-pdf me-2"></i>PDF </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-file-excel me-2"></i>Excel </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-file-word me-2"></i>doc </a>
              </div>
            </li> -->


          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
              <i class="mdi mdi-bell-outline"></i>
              <span class="count-symbol bg-danger fs-6"><?= $notificationCount ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <h6 class="p-3 mb-0 bg-primary text-white py-4">Notifications</h6>
              <div class="dropdown-divider"></div>

              <?php if ($notificationCount > 0) : ?>
                <?php foreach ($notifications as $notification) : ?>
                  <?php
                  $subject = htmlspecialchars($notification['subject']);
                  $iconInfo = $subjectIcons[$subject] ?? ['icon' => 'mdi mdi-alert', 'bgColor' => 'bg-secondary'];
                  $icon = $iconInfo['icon'];
                  $bgColor = $iconInfo['bgColor'];
                  $notificationId = $notification['id'];
                  $message = htmlspecialchars($notification['message']);
                  $clientId = $notification['client_id'];

                  // Customize the link based on the subject and client ID
                  switch ($subject) {
                    case 'New Uploaded File':
                      $notificationLink = "view_details.php?id=$clientId"; // link for new uploaded files
                      break;
                    case 'Valid File':
                      $notificationLink = "upload_requirements.php?id=$clientId"; // link for valid files
                      break;
                    case 'Invalid File':
                      $notificationLink = "upload_requirements.php?id=$clientId"; // Link for invalid files
                      break;
                    case 'Application Denied';
                    $notificationLink = "view_details.php?id=$clientId";
                      break;
                    case 'Granted';
                      $notificationLink = "view_details.php?id=$clientId";
                      break;
                    case 'Completed';
                      $notificationLink = "view_details.php?id=$clientId";
                      break;
                    case 'Revoked';
                      $notificationLink = "view_details.php?id=$clientId";
                      break;
                    case 'Appointment';
                      $notificationLink = "view_details.php?id=$clientId";
                      break;
                    case 'Confirmation';
                      $notificationLink = "view_details.php?id=$clientId";
                      break;
                      // Add more cases for other subjects as needed
                    default:
                      $notificationLink = "#"; // Default link if subject doesn't match known cases
                  }

                  ?>

                  <!-- <a class="dropdown-item preview-item" href="mark_as_read.php?id=<?= $notificationId ?>"> -->
                  <a class="dropdown-item preview-item" href="<?= $notificationLink ?>">
                    <div class="preview-thumbnail">
                      <div class="preview-icon <?= $bgColor ?>">
                        <i class="<?= $icon ?>"></i>
                      </div>
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject font-weight-normal mb-1"><?= $subject ?></h6>
                      <p class="text-gray ellipsis mb-0"><?= $message ?></p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                <?php endforeach; ?>

                <a class="dropdown-item preview-item text-center" href="mark_all_as_read.php">
                  Mark All as Read
                </a>

              <?php else : ?>
                <p class="dropdown-item preview-item text-center">No notifications</p>
              <?php endif; ?>

              <h6 class="p-3 mb-0 text-center">See all notifications</h6>
            </div>
          </li>




        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>