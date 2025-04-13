<?php 
require 'db1.php';
$locations = $pdo->query("SELECT * FROM map_editor")->fetchAll(PDO::FETCH_ASSOC);
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
  <title>Map Editor</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="stylesheet" href="map_editor.css"> <!-- Keep your custom map styling -->
  <style>
    /* Sidebar size and font customizations */
    .main-sidebar {
      width: 280px;  /* Set the width of the sidebar */
      font-size: 1.1rem;        /* Adjust font size for the sidebar text */
    }

    /* Sidebar links and icons */
    .main-sidebar .brand-link,
    .main-sidebar .nav-link,
    .main-sidebar .nav-icon {
      font-size: 1rem;   /* Set font size for sidebar links and icons */
    }

    /* Shift content to match new sidebar width */
    .content-wrapper,
    .main-footer,
    .main-header {
      margin-left: 280px !important; /* Adjust content area to match sidebar width */
      transition: margin-left 0.3s ease-in-out; /* Add smooth transition for content shift */
    }

    /* Adjust content margin when sidebar is collapsed */
    .main-sidebar.collapsed + .content-wrapper,
    .main-sidebar.collapsed + .content-wrapper + .main-footer,
    .main-sidebar.collapsed + .content-wrapper + .main-footer + .main-header {
      margin-left: 0 !important; /* Remove left margin when sidebar is collapsed */
    }

    /* Style the app name and icon in the sidebar */
    .main-sidebar .brand-link {
      font-weight: bold;  /* Make the app name bold */
      font-size: 1.4rem;   /* Increase the font size of the app name */
      display: flex;       /* Align the logo and text horizontally */
      align-items: center; /* Vertically center the logo with the text */
      padding-left: 15px;  /* Add padding on the left */
    }

    /* Style the logo (image) */
    .main-sidebar .brand-link img {
      width: 30px;       /* Set the logo size */
      height: 30px; 
      border-radius: 50%; 
      object-fit: cover;
      margin-right: 10px; /* Add space between the logo and text */
    }

    /* Style the app name text color */
    .main-sidebar .brand-text {
      color: white;        /* Set the color of the app name text */
    }
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
        <span class="mr-2 text-white">Admin Name</span>
        <img src="./images/han.jpg" alt="Admin Photo" class="img-circle elevation-2" style="width: 35px; height: 35px;">
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-success elevation-4">
    <!-- App Logo and Name -->
    <a href="#" class="brand-link">
      <img src="./images/pangga.jpg" alt="Logo"> <!-- Replace with the path to your new logo -->
      <span class="brand-text">PangTour</span> <!-- App name -->
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <!-- Sidebar Links -->
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
            <a href="heritage_sites.php" class="nav-link <?php echo ($currentPage == 'heritage_sites.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-landmark"></i>
              <p>Heritage Sites</p>
            </a>
          </li>
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

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0">Map Editor</h1>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div id="map"></div>

      <!-- Add Button -->
      <button id="addBtn" title="Add New Location">+</button>

      <!-- Floating Form -->
      <div id="formContainer" class="hidden">
        <form id="locationForm" action="submit.php" method="post" enctype="multipart/form-data">
          <h2>Add New Location</h2>
          <button type="button" id="close" class="btn btn-danger">Close</button>
          <input type="text" name="location_name" placeholder="Location Name" required><br>
          <input type="text" name="age" placeholder="Estimated Age"><br>
          <textarea name="description" placeholder="Historical Description" required></textarea><br>
          <select name="category">
            <option value="">Select Category</option>
            <option value="church">Church</option>
            <option value="museum">Museum</option>
            <option value="landmark">Landmark</option>
          </select><br>
          <input type="hidden" id="lat" name="latitude">
          <input type="hidden" id="lng" name="longitude">
          <input type="file" name="image_path"><br>
          <button type="submit" class="btn btn-success">Submit Details</button>
        </form>
      </div>
    </div>
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  const locations = <?php echo json_encode($locations); ?>;
  const map = L.map('map').setView([15.9167, 120.3333], 10);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
  }).addTo(map);

  locations.forEach(loc => {
    L.marker([loc.latitude, loc.longitude])
      .addTo(map)
      .bindPopup(`<strong>${loc.location_name}</strong><br>${loc.category}`);
  });

  map.on('click', function(e) {
    const lat = e.latlng.lat.toFixed(6);
    const lng = e.latlng.lng.toFixed(6);
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;
    L.popup().setLatLng(e.latlng).setContent(`Coordinates selected: ${lat}, ${lng}`).openOn(map);
  });

  function toggleForm() {
    document.getElementById('formContainer').classList.toggle('hidden');
  }

  document.getElementById('addBtn').addEventListener('click', toggleForm);

  document.getElementById('locationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('submit.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert('Location added successfully!');
        L.marker([data.latitude, data.longitude])
          .addTo(map)
          .bindPopup(`<strong>${data.location_name}</strong><br>${data.category}`);
        this.reset();
        toggleForm();
      } else {
        alert('Error: ' + data.message);
      }
    })
    .catch(err => {
      console.error(err);
      alert('Failed to submit. Try again.');
    });
  });
</script>
</body>
</html>
