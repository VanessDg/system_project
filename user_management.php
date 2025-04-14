<?php
include('db.php');
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Management</title>

  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />

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

    .content-wrapper,
    .main-footer,
    .main-header {
      margin-left: 280px !important;
      transition: margin-left 0.3s ease-in-out;
    }

    .main-sidebar.collapsed ~ .content-wrapper,
    .main-sidebar.collapsed ~ .main-footer,
    .main-sidebar.collapsed ~ .main-header {
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

    .sidebar-collapsed .main {
      margin-left: 80px;
    }

    .main {
      margin-left: 280px;
      padding: 30px;
      background-color: #f4f4f4;
      min-height: 100vh;
      transition: margin-left 0.3s ease-in-out;
    }

    h2 {
      margin-top: 0;
    }

    .filters,
    .table-wrapper {
      margin-top: 20px;
    }

    input[type="text"],
    select {
      padding: 8px;
      margin-right: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
    }

    th,
    td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    .badge {
      border: none;
      cursor: pointer;
      padding: 6px 12px;
      border-radius: 12px;
      color: white;
    }

    .badge.active {
      background-color: green;
    }

    .badge.suspended {
      background-color: red;
    }

    .actions button {
      margin-right: 5px;
      padding: 6px 10px;
    }

    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .modal.show {
      display: flex;
    }

    .modal-content {
      background: white;
      padding: 20px;
      width: 400px;
      border-radius: 8px;
    }

    .modal-content input,
    .modal-content select {
      width: 95%;
      padding: 8px;
      margin: 8px 0;
    }

    .main-footer {
      text-align: center;
      background: #fff;
      padding: 10px;
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
              <input class="form-control form-control-navbar" type="search" name="query" placeholder="Search here" aria-label="Search" />
              <div class="input-group-append">
                <button class="btn btn-navbar text-white" type="submit">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </form>
        </li>
        <li class="nav-item d-flex align-items-center">
          <span class="mr-2 text-white">Admin Name</span>
          <img src="./images/han.jpg" alt="Admin Photo" class="img-circle elevation-2" style="width: 35px; height: 35px;" />
        </li>
      </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-success elevation-4">
      <a href="#" class="brand-link">
        <img src="./images/pangga.jpg" alt="Logo" />
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

  <div class="main">
    <h2>User Management</h2>
    <div class="filters">
      <input type="text" id="searchInput" placeholder="Search..." oninput="filterTable()">
      <select id="roleFilter" onchange="filterTable()">
        <option value="">All Roles</option>
        <option>Super Admin</option>
        <option>Admin</option>
      </select>
      <select id="statusFilter" onchange="filterTable()">
        <option value="">All Status</option>
        <option>Active</option>
        <option>Suspended</option>
      </select>
      <button onclick="openModal()">+ Add User</button>
    </div>

    <div class="table-wrapper">
      <table id="userTable">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Registered</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="userTableBody">
          <!-- dito makikita yung table ng mga info ng users -->
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal" id="userModal">
    <div class="modal-content">
      <h3 id="modalTitle">Add User</h3>
      <form id="userForm">
        <input type="text" id="first_nameInput" placeholder="First Name" required>
        <input type="text" id="last_nameInput" placeholder="Last Name" required>
        <input type="email" id="emailInput" placeholder="Email" required>
        <select id="roleInput">
          <option>Super Admin</option>
          <option>Admin</option>
        </select>
        <select id="statusInput">
          <option>Active</option>
          <option>Suspended</option>
        </select>
        <button type="submit">Save User</button>
        <button type="button" onclick="closeModal()">Cancel</button>
      </form>
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
    const modal = document.getElementById("userModal");
    const modalTitle = document.getElementById("modalTitle");
    const userTableBody = document.getElementById("userTableBody");

    let users = [];
    let editingUserIndex = -1;

    function openModal(first = '', last = '', email = '', role = 'Admin', status = 'Active', index = -1) {
      modalTitle.textContent = first ? "Edit User" : "Add User";
      document.getElementById("first_nameInput").value = first;
      document.getElementById("last_nameInput").value = last;
      document.getElementById("emailInput").value = email;
      document.getElementById("roleInput").value = role;
      document.getElementById("statusInput").value = status; 
      editingUserIndex = index;
      modal.classList.add("show");
    }

    function closeModal() {
      modal.classList.remove("show");
      document.getElementById("userForm").reset();
    }

    document.getElementById("userForm").addEventListener("submit", async function (e) {
      e.preventDefault();

      const first_name = document.getElementById("first_nameInput").value.trim();
      const last_name = document.getElementById("last_nameInput").value.trim();
      const email = document.getElementById("emailInput").value.trim();
      const role = document.getElementById("roleInput").value;
      const status = document.getElementById("statusInput").value;

      if (!first_name || !last_name || !email || !role || !status) {
        alert("All fields are required!");
        return;
      }

      const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      if (!emailRegex.test(email)) {
        alert("Please enter a valid email address.");
        return;
      }

      const userData = { first_name, last_name, email, role, status };

      if (editingUserIndex === -1) {
        await addUser(userData);
      } else {
        const userId = users[editingUserIndex].id;
        await updateUser(userId, userData);
      }

    closeModal();
  });

  function filterTable() {
    const search = document.getElementById("searchInput").value.toLowerCase();
    const role = document.getElementById("roleFilter").value;
    const status = document.getElementById("statusFilter").value;

    const filteredUsers = users.filter(user => {
      const matchesSearch = user.first_name.toLowerCase().includes(search)
      || user.last_name.toLowerCase().includes(search)
      || user.email.toLowerCase().includes(search);
      const matchesRole = role === "" || user.role === role;
      const matchesStatus = status === "" || user.status === status;
      return matchesSearch && matchesRole && matchesStatus;
    });

    renderTable(filteredUsers);
  }

  function renderTable(usersToRender = users) {
    userTableBody.innerHTML = "";
    usersToRender.forEach((user, index) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${user.first_name}</td>
        <td>${user.last_name}</td>
        <td>${user.email}</td>
        <td>${user.role}</td>
        <td>
          <button 
            class="badge ${user.status === 'Active' ? 'active' : 'suspended'}"
            onclick="changeStatus(${user.id})"
            style="border: none; cursor: pointer;">
            ${user.status}
          </button>
        </td>
        <td>${user.registered}</td>
        <td class="actions">
          <button onclick="openModal('${user.first_name}', '${user.last_name}', '${user.email}', '${user.role}', '${user.status}', ${users.indexOf(user)})">Edit</button>
          <button onclick="deleteUser(${users.indexOf(user)})">Delete</button>
        </td>
      `;
      userTableBody.appendChild(row);
    });
  }

  window.addEventListener("click", function (e) {
    if (e.target === modal) {
      closeModal();
    }
  });

  async function deleteUser(index) {
    const userId = users[index].id;
    if (confirm("Are you sure you want to delete this user?")) {
      await deleteUserFromDB(userId);
    }
  }

  async function loadUsers() {
    const res = await fetch('api/get_users.php');
    const data = await res.json();

    users = data.map(user => ({
      id: user.id,
      first_name: user.first_name,
      last_name: user.last_name,
      email: user.email,
      role: user.role,
      status: user.status,
      registered: user.registered
    }));

    renderTable();
  }

  async function addUser(newUser) {
    await fetch('api/add_user.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(newUser)
    });
    loadUsers();
  }

  async function updateUser(id, updatedUser) {
    await fetch('api/update_user.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id, ...updatedUser })
    });
    loadUsers();
  }

  async function deleteUserFromDB(id) {
    await fetch('api/delete_user.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id })
    });
    loadUsers();
  }

  // Initialize
  loadUsers();

  // Handle sidebar collapse toggle
  document.querySelector('.main-header .nav-link').addEventListener('click', function () {
    document.body.classList.toggle('sidebar-collapsed');
  });
  
</script>
