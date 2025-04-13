<?php
include('db.php');
include('functions.php');
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: index.php");
    exit();
}
$currentPage = basename($_SERVER['PHP_SELF']);

$query = "SELECT * FROM published_sites ORDER BY historical_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Published Heritage Sites - PangTour</title>
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

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light navbar-success">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <!-- Sidebar toggle button -->
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars text-white"></i></a>
      </li>
    </ul>

    <!-- Right navbar -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-flex align-items-center">
        <span class="mr-2 text-white">Admin Name</span>
        <img src="./images/han.jpg" alt="Admin Photo" class="img-circle elevation-2" style="width: 35px; height: 35px;">
      </li>
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
          <li class="nav-item">
            <a href="heritage_sites.php" class="nav-link">
              <i class="nav-icon fas fa-landmark"></i>
              <p>Heritage Sites</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="user_management.php" class="nav-link">
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

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2>Recently Published Heritage Sites</h2>
      </div>
    </div>

    <!-- Page Content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h4>List of Published Heritage Sites</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th>Site Name</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Published Date</th>
                    <th>Historical Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                          echo "<tr>";
                          echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                          echo "<td><img src='images/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "' width='100'></td>";
                          echo "<td>" . date("F d, Y", strtotime($row['published_date'])) . "</td>";
                          echo "<td>" . date("F d, Y", strtotime($row['historical_date'])) . "</td>";
                          echo "</tr>";
                      }
                  } else {
                      echo "<tr><td colspan='6' class='text-center'>No heritage sites found</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>&copy; 2025 PangTour</strong>
  </footer>

</div>

<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
