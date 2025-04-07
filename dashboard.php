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
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="dashboard">
<div class="container">

    <aside class="sidebar">
        <div class="logo">PangTour</div>
        <ul>
            <li class="nav-item <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item <?php echo ($currentPage == 'map_editor.php') ? 'active' : ''; ?>">
                <a href="#map-editor">Map Editor</a>
            </li>
            <li class="nav-item <?php echo ($currentPage == 'heritage-sites.php') ? 'active' : ''; ?>">
                <a href="#heritage-sites">Heritage Sites</a>
            </li>
            <li class="nav-item <?php echo ($currentPage == 'user-management.php') ? 'active' : ''; ?>">
                <a href="#user-management">User Management</a>
            </li>
        </ul>
        <div class="logout-container">
            <a href="logout.php" title="Logout" class="logout-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <h2>Dashboard</h2>
            <div class="search">
                <input type="text" placeholder="Search here">
            </div>
            <div class="admin-info">
                <span>Admin Name</span>
                <img src="./images/han.jpg" alt="Admin Photo">
            </div>
        </div>

        <div class="stats">
            <div class="card" onclick="showDetails('heritage')">
                <div class="number">218</div>
                <div class="label">Total Heritage Sites</div>
            </div>
            <div class="card" onclick="showDetails('engagement')">
                <div class="number">526</div>
                <div class="label">User Engagement</div>
            </div>
            <div class="card" onclick="showDetails('published')">
                <div class="number">17</div>
                <div class="label">Recently published sites</div>
            </div>
        </div>

        <div class="custom-modal" id="infoModal" style="display: none;">
            <div class="custom-modal-content">
                <p class="modal-text" id="modalMessage">You have <b>218</b> heritage sites.</p>
                <div class="modal-buttons">
                    <button class="btn cancel-btn" onclick="closeModal()">Close</button>
                    <a id="modalActionLink" href="#" class="btn view-btn">View details</a>
                </div>
            </div>
        </div>

        <div class="activity">
            <h4>Recent Activity</h4>
            <ul>
                <li><span>Lingayen Capitol Building description edited</span><span>2 days ago</span></li>
                <li><span>Metamorphosis monument added</span><span>3 days ago</span></li>
                <li><span>Banaán Pangasinan Provincial Museum published</span><span>5 days ago</span></li>
                <li><span>Patar Beach images edited</span><span>7 days ago</span></li>
            </ul>
        </div>
    </main>
</div>

<script src="script.js"></script>

</body>
</html>
