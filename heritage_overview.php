<?php
include('db.php');
include('functions.php');
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: index.php");
    exit();
}

// Stats
$totalSites = $conn->query("SELECT COUNT(*) as count FROM heritage_sites")->fetch_assoc()['count'];
$earliestDate = $conn->query("SELECT historical_date FROM heritage_sites ORDER BY historical_date ASC LIMIT 1")->fetch_assoc()['historical_date'];
$latestDate = $conn->query("SELECT historical_date FROM heritage_sites ORDER BY historical_date DESC LIMIT 1")->fetch_assoc()['historical_date'];

// Group by location for chart
$locationData = $conn->query("SELECT location, COUNT(*) as count FROM heritage_sites GROUP BY location");
$locations = [];
$locationCounts = [];
while ($row = $locationData->fetch_assoc()) {
    $locations[] = $row['location'];
    $locationCounts[] = $row['count'];
}

// Recent sites
$recentSites = $conn->query("SELECT * FROM heritage_sites ORDER BY published_date DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Heritage Sites Overview</title>
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <script src="plugins/chart.js/Chart.min.js"></script>
  <style>
    .main-sidebar { width: 280px; font-size: 1.1rem; }
    .main-sidebar .brand-link, .main-sidebar .nav-link, .main-sidebar .nav-icon { font-size: 1rem; }
    .content-wrapper, .main-footer, .main-header { margin-left: 280px !important; }
    .brand-image { width: 30px; height: 30px; object-fit: cover; }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light navbar-success">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars text-white"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-flex align-items-center">
        <span class="mr-2 text-white">Admin</span>
        <img src="./images/han.jpg" alt="Admin" class="img-circle elevation-2" style="width: 35px; height: 35px;">
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-success elevation-4">
    <a href="dashboard.php" class="brand-link">
      <img src="./images/pangga.jpg" alt="PangTour Logo" class="brand-image img-circle elevation-3" style="opacity: .8;">
      <span class="brand-text font-weight-bold text-white ml-2">PangTour</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
          <li class="nav-item"><a href="map_editor.php" class="nav-link"><i class="nav-icon fas fa-map"></i><p>Map Editor</p></a></li>
          <li class="nav-item"><a href="heritage_sites.php" class="nav-link"><i class="nav-icon fas fa-landmark"></i><p>Heritage Sites</p></a></li>
          <li class="nav-item"><a href="logout.php" class="nav-link"><i class="nav-icon fas fa-sign-out-alt text-danger"></i><p>Logout</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2>Heritage Sites Overview</h2>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">

        <!-- Stat Cards -->
        <div class="row">
          <div class="col-md-4">
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?= $totalSites ?></h3>
                <p>Total Heritage Sites</p>
              </div>
              <div class="icon"><i class="fas fa-landmark"></i></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $earliestDate ?></h3>
                <p>Earliest Historical Date</p>
              </div>
              <div class="icon"><i class="fas fa-history"></i></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $latestDate ?></h3>
                <p>Most Recent Historical Date</p>
              </div>
              <div class="icon"><i class="fas fa-clock"></i></div>
            </div>
          </div>
        </div>

        <!-- Chart -->
        <div class="card mb-4">
          <div class="card-header"><h4>Sites by Location</h4></div>
          <div class="card-body">
            <canvas id="locationChart"></canvas>
          </div>
        </div>

        <!-- Recent Sites -->
        <div class="card">
          <div class="card-header"><h4>Recently Published Sites</h4></div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Location</th>
                  <th>Historical Date</th>
                  <th>Published Date</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($site = $recentSites->fetch_assoc()): ?>
                  <tr>
                    <td><?= $site['name'] ?></td>
                    <td><?= $site['location'] ?></td>
                    <td><?= $site['historical_date'] ?></td>
                    <td><?= $site['published_date'] ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
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
<script>
const ctx = document.getElementById('locationChart').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?= json_encode($locations) ?>,
    datasets: [{
      label: 'Number of Sites',
      data: <?= json_encode($locationCounts) ?>,
      backgroundColor: 'rgba(60,141,188,0.8)'
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: { beginAtZero: true }
    }
  }
});
</script>
</body>
</html>
