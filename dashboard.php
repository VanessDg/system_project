<?php
include('db.php');
include('functions.php');
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: index.php"); 
    exit();
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PangTour Admin Dashboard</title>
  <!-- Add this in the <head> of your page -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    .main-sidebar {
      width: 280px;
      font-size: 1.1rem;
    }
    .main-sidebar .brand-link,
    .main-sidebar .nav-link,
    .main-sidebar .nav-icon {
      font-size: 1rem;
    }
    .content-wrapper,
    .main-footer,
    .main-header {
      margin-left: 280px !important;
      transition: margin-left 0.3s ease-in-out;
    }
    .main-sidebar.collapsed + .content-wrapper,
    .main-sidebar.collapsed + .content-wrapper + .main-footer,
    .main-sidebar.collapsed + .content-wrapper + .main-footer + .main-header {
      margin-left: 0 !important;
    }
    .main-sidebar .brand-link {
      font-weight: bold;
      font-size: 1.4rem;
      display: flex;
      align-items: center;
      padding-left: 15px;
    }
    .main-sidebar .brand-link img {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 10px;
    }
    .main-sidebar .brand-text {
      color: white;
    }

  </style>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-light navbar-success">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars text-white"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto d-flex align-items-center">
  <!-- Search Form -->
  <li class="nav-item mr-3">
    <form class="form-inline" action="search.php" method="GET">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" name="query" placeholder="Search here" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar text-white" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
  </li>

  <!-- Admin Name and Photo -->
  <li class="nav-item d-flex align-items-center">
    <span class="mr-2 text-white">Admin Name</span>
    <img src="./images/han.jpg" alt="Admin Photo" class="img-circle elevation-2" style="width: 35px; height: 35px;">
  </li>
</ul>

    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-success elevation-4">
    <a href="#" class="brand-link">
      <img src="./images/pangga.jpg" alt="Logo">
      <span class="brand-text">PangTour</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="map_editor.php" class="nav-link <?php echo ($currentPage == 'map_editor.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-map"></i>
              <p>Map Editor</p>
            </a>
          </li>
          <!-- heritage_sites.php connection -->
          <li class="nav-item">
            <a href="heritage_sites.php" class="nav-link <?php echo ($currentPage == 'heritage_sites.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-landmark"></i>
              <p>Heritage Sites</p>
            </a>
          </li>
              <!-- user_management.php connection -->
          <li class="nav-item">
            <a href="user_management.php" class="nav-link <?php echo ($currentPage == 'user_management.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>User Management</p>
            </a>
          </li>
          <li class="nav-item mt-3">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
<!-- -- -->

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
          <h2>Dashboard</h2>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">
            <div class="small-box bg-primary" onclick="window.location.href='heritage_overview.php'">
              <div class="inner">
                <h3>218</h3>
                <p>Total Heritage Sites</p>
              </div>
              <div class="icon">
                <i class="fas fa-landmark"></i>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="small-box bg-success" onclick="showDetails('engagement')">
              <div class="inner">
                <h3>526</h3>
                <p>User Engagement</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="small-box bg-info" onclick="window.location.href='published_sites.php'">
              <div class="inner">
                <h3>17</h3>
                <p>Recently Published Sites</p>
              </div>
              <div class="icon">
                <i class="fas fa-globe"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="custom-modal" id="infoModal" style="display: none;">
          <div class="custom-modal-content">
            <p class="modal-text" id="modalMessage">You have <b>526</b> user engagements.</p>
            <div class="modal-buttons">
              <button class="btn btn-secondary" onclick="closeModal()">Close</button>
              <a id="modalActionLink" href="#" class="btn btn-primary">View details</a>
            </div>
          </div>
        </div>

        <div class="card mt-4">
          <div class="card-header">
            <h4>Recent Activity</h4>
          </div>
          <div class="card-body">
            <ul>
              <li><span>Lingayen Capitol description edited</span> <span class="float-right">2 days ago</span></li>
              <li><span>Sual Port added</span> <span class="float-right">3 days ago</span></li>
              <li><span>Palaris Revolt published</span> <span class="float-right">5 days ago</span></li>
              <li><span>La Marcha Nacional Filipina edited</span> <span class="float-right">7 days ago</span></li>
            </ul>
          </div>
        </div>

      </div>
    </section>
  </div>

<!-- Add this to the end of the body section of your page -->
  <footer class="main-footer text-center">
    <strong>&copy; 2025 PangTour</strong>
  </footer>
</div>

<!-- Add this before closing </body> of your page -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

<script>
function showDetails(type) {
    var modalMessage = '';
    var actionLink = '#';

    if (type === 'engagement') {
        modalMessage = 'You have <b>526</b> user engagements.';
        actionLink = 'engagement_details.php';
    }

    document.getElementById('modalMessage').innerHTML = modalMessage;
    document.getElementById('modalActionLink').href = actionLink;
    document.getElementById('infoModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('infoModal').style.display = 'none';
}
</script>

</body>
</html>
