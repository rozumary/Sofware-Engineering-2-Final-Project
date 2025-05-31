<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar" style="background: #c22828 !important;">
    <ul class="nav">
      <li class="nav-item nav-category">Main</li>
      <li class="nav-item">
        <?php
        $user_level = $_SESSION['user_level'];
        $role = $_SESSION['role'];
        if ($user_level == 1): ?>
          <a class="nav-link" href="admin_dashboard.php">
          <?php else: ?>
            <a class="nav-link" href="user_dashboard.php">
            <?php endif; ?>
            <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
            <span class="menu-title">Dashboard</span>
          </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profile.php">
          <span class="icon-bg"><i class="mdi mdi-contacts menu-icon"></i></span>
          <span class="menu-title">Profile</span>
        </a>
      </li>


      <?php if ($user_level == 1): ?>
        <li class="nav-item">
          <a class="nav-link" href="search_client.php">
            <span class="icon-bg"><i class="mdi mdi-account-search menu-icon"></i></span>
            <span class="menu-title">Search Client</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="calendar.php">
            <span class="icon-bg"><i class="mdi mdi-calendar menu-icon"></i></span>
            <span class="menu-title">Calendar</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="email_msg.php">
            <span class="icon-bg"><i class="mdi mdi-email menu-icon"></i></span>
            <span class="menu-title">Email Messages</span>
          </a>
        </li>



        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
            <span class="icon-bg"><i class="mdi mdi-account-multiple menu-icon"></i></span>
            <span class="menu-title">Account Management</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="clients_list.php">Clients</a></li>
              <li class="nav-item"> <a class="nav-link" href="users_list.php">Users List</a></li>
              <li class="nav-item"> <a class="nav-link" href="petitioners_list_v02.php">Petitioners List</a></li>
              <li class="nav-item"> <a class="nav-link" href="probationers_list.php">Probationers List</a></li>
              <li class="nav-item"> <a class="nav-link" href="denied_list.php">Denied List</a></li>
              <li class="nav-item"> <a class="nav-link" href="completed_list.php">Completed List</a></li>
              <li class="nav-item"> <a class="nav-link" href="revoked_list.php">Revoked List</a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="archived_users.php">
            <span class="icon-bg"><i class="mdi mdi-folder menu-icon"></i></span>
            <span class="menu-title">Archived Users</span>
          </a>
        </li>



        <!-- <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
            <span class="icon-bg"><i class="mdi mdi-file menu-icon"></i></span>
            <span class="menu-title">Reports</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="auth">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="#"> Attendance Report</a></li>
              <li class="nav-item"> <a class="nav-link" href="#"> Send Email </a></li>
              <li class="nav-item"> <a class="nav-link" href="#"> # </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#"> 404 </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#"> 500 </a></li>
            </ul>
          </div>
        </li> -->
      <?php endif; ?>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui" aria-expanded="false" aria-controls="ui-basic">
          <span class="icon-bg"><i class="mdi mdi-settings menu-icon"></i></span>
          <span class="menu-title">Settings</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui">
          <ul class="nav flex-column sub-menu">
            <!-- <li class="nav-item"> <a class="nav-link" href="#">Account Settings</a></li> -->
            <li class="nav-item"> <a class="nav-link" href="change_password.php">Change Password</a></li>
            <!-- <li class="nav-item"> <a class="nav-link" href="#">#</a></li> -->
          </ul>
        </div>
      </li>


      <?php if ($user_level == 1): ?>
        <li class="nav-item sidebar-user-actions">
          <div class="user-details">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <div class="d-flex align-items-center">

                  <div class="sidebar-profile-text">
                    <?php if ($role == 'admin'): ?>
                      <p class="mb-1 text-dark">Parole and Probation Officer</p>
                    <?php elseif ($role == 'superadmin'): ?>
                      <p class="mb-0 fs-6 text-dark">Chief Parole and Probation Officer</p>
                    <?php else: ?>
                      <p class="mb-0 fs-6 text-dark">Admin Clerk</p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <!-- <div class="badge badge-danger"><?= $notificationCount ?></div> -->
            </div>
          </div>
        </li>

  <li class="nav-item">
    <a class="nav-link" href="add_officers.php">
      <span class="icon-bg"><i class="mdi mdi-account-plus menu-icon"></i></span>
      <span class="menu-title">Parole Officers</span>
    </a>
  </li>

        <li class="nav-item sidebar-user-actions">
          <div class="sidebar-user-menu">
            <a href="logout.php" class="nav-link">
              <span class="icon-bg"><i class="mdi mdi-logout menu-icon"></i></span>
              <span class="menu-title">Log Out</span></a>
          </div>
        </li>
      <?php endif; ?>
    </ul>
  </nav>