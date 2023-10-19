<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" /><!-- MDB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  <title></title>
</head>

<body>
  <style>
    body {
      background-color: #fbfbfb;
    }

    @media (min-width: 991.98px) {
      main {
        padding-left: 240px;
      }
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      padding: 58px 0 0;
      /* Height of navbar */
      box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
      width: 240px;
      z-index: 600;
    }

  

    @media (max-width: 991.98px) {
      .sidebar {
        transform: translateX(-100%); /* Hide the sidebar off-screen on small screens */
      }
    }

    .sidebar.active {
      transform: translateX(0); /* Show the sidebar when it has the 'active' class */
    }
  </style>
  <header>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
          <a href="<?php echo base_url('page/test'); ?>" class="list-group-item list-group-item-action py-2 ripple"
            aria-current="true">
            <i class=""></i><span>Pending Reservations</span>
          </a>
          <a href="<?php echo base_url('page/history'); ?>"
            class="list-group-item list-group-item-action py-2 ripple">
            <i class=""></i><span>Declined</span>
          </a>
          <a href="<?php echo base_url('page/reserved'); ?>"
            class="list-group-item list-group-item-action py-2 ripple"><i class=""></i><span>Reserved Slots</span></a>
          <a href="<?php echo base_url('page/approved'); ?>"
            class="list-group-item list-group-item-action py-2 ripple"><i class=""></i><span>Approved Reservations</span></a>
          <a href="<?php echo base_url('page/canceled'); ?>" class="list-group-item list-group-item-action py-2 ripple">
            <i class=""></i><span>Canceled</span>
          </a>
          <a href="<?php echo base_url('page/court_status'); ?>"
            class="list-group-item list-group-item-action py-2 ripple"><i class=""></i><span>Court Manager</span></a>
            <a href="<?php echo base_url('page/landing_page'); ?>" class="list-group-item list-group-item-action py-2 ripple"><i
              class=""></i><span>Home Page</span></a>

        </div>
      </div>
    </nav>
    <!-- Sidebar -->

    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <!-- Container wrapper -->
      <div class="container-fluid">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
          aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>

        <!-- Brand -->
        <a class="navbar-brand" href="<?php echo base_url('page/admin'); ?>">
          <img src="<?php echo base_url('asset/299584772_435117378634124_6677388645313997495_n.png'); ?>" height="50"
            alt="" loading="lazy" />
        </a>
  
        <ul class="navbar-nav ms-auto d-flex flex-row">

          <li class="nav-item">
    <a class="nav-link" href="<?php echo base_url('page/logout'); ?>">Logout</a>
</li>

      </div>
      <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
  </header>
  <!--Main Navigation-->
  <br>
  <br>
</body>
</html>