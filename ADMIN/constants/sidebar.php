<!DOCTYPE html>
<!-- Coding by CodingNepal || www.codingnepalweb.com -->
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Boxicons CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Police Dashboard</title>
    <link rel="stylesheet" href="css/sidebar.css" />
  </head>
  <body>
    <!-- navbar -->
    <nav class="navbar">
      <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen"></i>
        <img src="images/sondu_logo.png" alt=""></i>SONDU ADMIN
      </div>

     
    </nav>

    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <!-- duplicate or remove this li tag if you want to add or remove navlink with submenu -->
          


          <li class="item">
            <a href="admin_dashboard.php" class="nav_link">
              <span class="navlink_icon">
                <i class="fas fa-tachometer-alt"></i>
              </span>
              <span class="navlink">Dashboard</span>
            </a>
          </li>


          <!-- start -->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fas fa-users"></i>
              </span>
              <span class="navlink">Manage Users</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="add_police.php" class="nav_link sublink"><i class="fas fa-plus-circle"></i>Add-Police</a>
              <a href="manage_police.php" class="nav_link sublink"><i class="fas fa-user-times"></i>Manage Police</a>
              <a href="manage_users.php" class="nav_link sublink"><i class="fas fa-user-minus"></i>Manage Citizen</a>
            </ul>
          </li>

          <!-- end -->


          <li class="item">
            <a href="police_schedule.php" class="nav_link">
              <span class="navlink_icon">
              <i class="fas fa-calendar-times"></i>
              </span>
              <span class="navlink">Police Schedule</span>
            </a>
          </li>


          <li class="item">
            <a href="reports.php" class="nav_link">
              <span class="navlink_icon">
                <i class="fas fa-clipboard-list"></i>
              </span>
              <span class="navlink">Reports</span>
            </a>
          </li>

          <li class="item">
            <a href="add_location.php" class="nav_link">
              <span class="navlink_icon">
              <i class="fas fa-map-marker-alt"></i>
              </span>
              <span class="navlink">Manage Locations</span>
            </a>
          </li>


          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
              <i class="fas fa-cogs"></i>
              </span>
              <span class="navlink">Settings</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="add_admin.php" class="nav_link sublink"><i class="fas fa-users-cog"></i>Add-Admin</a>
              <a href="update_admin_details.php" class="nav_link sublink"><i class="fas fa-edit"></i>Update-Admin</a>
            </ul>
          </li>
      
        <li class="item">
          <a href="admin_logout.php" class="nav_link">
            <span class="navlink_icon">
              <i class="fas fa-sign-out-alt"></i>
            </span>
            <span class="navlink">Logout</span>
          </a>
        </li>

        <!-- Sidebar Open / Close -->
        <div class="bottom_content">
          <div class="bottom expand_sidebar">
            <span> Expand</span>
            <i class='bx bx-log-in' ></i>
          </div>
          <div class="bottom collapse_sidebar">
            <span> Collapse</span>
            <i class='bx bx-log-out'></i>
          </div>
        </div>
      </div>
    </nav>
    <!-- JavaScript -->
    <script src="Javascript/sidebar.js"></script>
  </body>
</html>
