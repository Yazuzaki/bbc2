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

    .sidebar {
        width: 250px;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #333;
        padding-top: 20px;
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
        margin-left: 250px;
        padding: 20px;
    }

    .logo {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo img {
        width: 150px;
        height: auto;
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
      <li><a class="nav-link" href="<?php echo base_url('page/test'); ?>">Manage</a></li>
      <li><a class="nav-link" href="<?php echo base_url('page/history'); ?>">Declined</a></li>
      <li><a class="nav-link" href="<?php echo base_url('page/presentreservation'); ?>"></a></li>
      <li><a class="nav-link" href="<?php echo base_url('page/test'); ?>"></a></li>
      <li><a class="nav-link" href="<?php echo base_url('page/test'); ?>"></a></li>
    </ul>
  </div>
</body>

</html>