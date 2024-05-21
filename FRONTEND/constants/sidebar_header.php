<!--INCLUDE AUTHENTHICATION CONNECTION-->
<!--INCLUDE DATABASE CONNECTION-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title></title>
    <link rel="stylesheet" href="./css/sidebar_header.css"/>
  </head>
  <body>
    <!-- navbar -->
    <nav class="navbar">
      <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen"></i>
        <img src="images/sondu_logo.png" alt=""></i>HELLO KINDLY VIEW YOUR CASES BELOW
      </div>

      

      <div class="navbar_content">
        <i class="bi bi-grid"></i>
        <i class='bx bx-bell' ></i>
        <img src="images/profile.jpg" alt="" class="profile" />
      </div>
    </nav>

    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          

          <!-- duplicate this li tag if you want to add or remove  navlink with submenu -->
          <!-- start -->
            <a href="track_case.php" class="nav_link">
              <span class="navlink_icon">
                <i class="bx bx-home-alt"></i>
              </span>
              <span class="navlink">VERIFIED CASES</span>
            </a>


            <a href="declined_cases.php" class="nav_link">
              <span class="navlink_icon">
                <i class="bx bx-grid-alt"></i>
              </span>
              <span class="navlink">DECLINED CASES</span>
            </a>
            

            <a href="#" class="nav_link">
              <span class="navlink_icon">
              <i class="bx bx-mail-send"></i>
              </span>
              <span class="navlink">RE-SUBMIT CASE</span>
            </a>

        
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
    <script src="./Javascript/dashboard.js"></script>
  </body>
</html>
