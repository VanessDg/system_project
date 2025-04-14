<?php
include('db.php');
include('functions.php');
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: index.php");
    exit();
}
$currentPage = basename($_SERVER['PHP_SELF']);

$deleteMessage = "";
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);

    $stmtImg = $conn->prepare("SELECT image_path FROM map_editor WHERE id = ?");
    $stmtImg->bind_param("i", $deleteId);
    $stmtImg->execute();
    $resultImg = $stmtImg->get_result();
    if ($resultImg->num_rows > 0) {
        $imgRow = $resultImg->fetch_assoc();
        if (!empty($imgRow['image_path']) && file_exists($imgRow['image_path'])) {
            unlink($imgRow['image_path']);
        }
    }
    $stmtImg->close();

    // Delete the row
    $stmt = $conn->prepare("DELETE FROM map_editor WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    if ($stmt->execute()) {
        $deleteMessage = "Heritage site deleted successfully.";
    } else {
        $deleteMessage = "Failed to delete heritage site.";
    }
    $stmt->close();
}

$heritageSites = [];
$result = $conn->query("SELECT * FROM map_editor");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $heritageSites[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PangTour Admin Dashboard</title>

  <!-- AdminLTE and Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="heritage_sites.css">


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
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars text-white"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto d-flex align-items-center">
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

      <li class="nav-item d-flex align-items-center">
        <span class="mr-2 text-white"><?= htmlspecialchars($_SESSION["admin"]["name"] ?? 'Admin') ?></span>
        <img src="./images/han.jpg" alt="Admin Photo" class="img-circle elevation-2" style="width: 35px; height: 35px;">
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
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

  <!-- Content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h2>Heritage Sites</h2>
      </div>
    </div>

    <div class="container-fluid">

    <?php if (!empty($deleteMessage)): ?>
  <div class="alert alert-info"><?= htmlspecialchars($deleteMessage) ?></div>
<?php endif; ?>

    <section class="heritage-list pb-4">
  <?php if ($heritageSites): ?>
    <?php foreach ($heritageSites as $site): ?>
      <div class="heritage-card">
        <img src="<?= !empty($site['image_path']) && file_exists($site['image_path']) 
                        ? htmlspecialchars($site['image_path']) 
                        : 'img/default.jpg' ?>" 
            alt="<?= htmlspecialchars($site['location_name']) ?>" 
            class="heritage-image">

        <div class="heritage-content">
          <h3><?= htmlspecialchars($site['location_name']) ?></h3>
          <p class="location"><?= htmlspecialchars($site['location_address'] ?? 'Unknown location') ?></p>
          <p class="desc"><?= htmlspecialchars($site['description']) ?></p>
        </div>

        <div class="heritage-actions">
          <a href="edit_heritage.php?id=<?= $site['id'] ?>"><i class="fas fa-pen"></i></a>
          <a href="heritage_sites.php?delete_id=<?= $site['id'] ?>" onclick="return confirm('Are you sure you want to delete this site?');"><i class="fas fa-trash"></i></a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No heritage sites found.</p>
  <?php endif; ?>
</section>
    </div>
  </div>
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
