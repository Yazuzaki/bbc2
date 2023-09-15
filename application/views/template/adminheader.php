<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" />
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
  <title>Document</title>
</head>

<body>
  <style>
    .sidebar,
    .main-content {
      transition: margin 0.3s;
      /* Add a smooth transition effect */
    }

    .sidebar {
      width: 250px;
      height: 100%;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #333;
      padding-top: 20px;
      z-index: 1;
      /* Ensure sidebar is above the main content */
    }

    .sidebar ul {
      list-style-type: none;
      padding: 0;
    }

    .sidebar li {
      margin-bottom: 10px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 10px;
      display: block;
      transition: background-color 0.3s;
    }

    .sidebar a:hover {
      background-color: #555;
    }

    .main-content {
      padding: 20px;
      margin-left: 0;
      /* Initially, no margin on the left */
    }

    .logo {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo img {
      width: 150px;
      height: auto;
    }

    /* Media query for mobile devices */
    @media (max-width: 768px) {
      .sidebar {
        width: 0;
        /* Collapse the sidebar initially */
      }

      .sidebar.active {
        width: 250px;
        /* Show sidebar when active */
      }

      .sidebar ul {
        text-align: center;
        /* Center-align menu items */
      }

      .sidebar li {
        margin: 0;
      }

      .sidebar a {
        padding: 15px 0;
        /* Increase padding for touch-friendly buttons */
        display: inline-block;
        /* Menu items in a row */
      }

      .main-content {
        margin-left: 0;
        /* No margin on the left */
      }
    }
  </style>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Logo -->
    <div class="logo">
      <img src="<?php echo base_url('asset/299584772_435117378634124_6677388645313997495_n.png'); ?>" alt="Logo"
        height="30">

    </div>
    <!-- Sidebar content goes here -->
    <ul>
      <li><a class="nav-link" href="<?php echo base_url('page/test'); ?>">Pending Reservations</a></li>
      <li><a class="nav-link" href="<?php echo base_url('page/history'); ?>">Declined</a></li>
      <li><a class="nav-link" href="<?php echo base_url('page/reserved'); ?>">Reserved</a></li>
      <li><a class="nav-link" href="<?php echo base_url('page/test'); ?>"></a></li>
      <li><a class="nav-link" href="<?php echo base_url('page/test'); ?>"></a></li>
    </ul>
  </div>

  <script>
    const sidebar = document.getElementById("sidebar");
    const sidebarToggle = document.getElementById("sidebarToggle");

    sidebarToggle.addEventListener("click", function () {
      sidebar.classList.toggle("active");
    });
  </script>
</body>

</html>