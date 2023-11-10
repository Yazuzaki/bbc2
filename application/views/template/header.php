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
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
</head>

<body>
  <!--Main Navigation-->
  <header>
    <style>
      .navbar .nav-link {
        color: #fff !important;
      }

      .navbar {
        background-color: #000000;
        /* Replace with your desired color */
      }
    </style>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark d-none d-lg-block" style="z-index: 2000;">
      <div class="container-fluid">
        <!-- Navbar brand -->
        <a class="navbar-brand nav-link" href="<?php echo base_url('page/landing_page'); ?>">
          <img src="<?php echo base_url('asset/299584772_435117378634124_6677388645313997495_n.png'); ?>" height="30"
            alt="" loading="lazy" />
        </a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample01"
          aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarExample01">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item active">
              <a class="nav-link" aria-current="page" href="<?php echo base_url('page/landing_page'); ?>">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="" rel="nofollow" target="_blank"></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('page/reserve'); ?>">Reserve</a>
            </li>
          </ul>

          <ul class="navbar-nav d-flex flex-row">
            <?php
            // Check if the user is logged in
            if ($this->session->userdata('id')) {
              // Load the user's data from the database using the user ID
              $user_id = $this->session->userdata('id');
              $user = $this->db->get_where('users', array('id' => $user_id))->row();

              if ($user) {
                // If the user is an admin, show the "Admin" link
                if ($user->role === 'admin') {
                  echo '<li class="nav-item me-3 me-lg-0">
              <a class="nav-link" href="' . base_url('page/admin') . '">Admin</a>
            </li>';
                }


                echo '<li class="nav-item me-3 me-lg-0">
              <a class="nav-link" href="' . base_url('page/logout') . '">Logout</a>
            </li>';
              }
            } else {
              // If not logged in, show the "Sign In" link
              echo '<li class="nav-item me-3 me-lg-0">
          <a class="nav-link" href="' . base_url('page/loginview') . '">Sign In</a>
        </li>';
              echo '<li class="nav-item me-3 me-lg-0">
        <a class="nav-link" href="' . base_url('page/register') . '">Register</a>
      </li>';
            }
            ?>


            <!-- Icons -->



          </ul>
        </div>
      </div>
    </nav>
    <!-- Navbar for Mobile Phones -->
    <nav class="navbar navbar-expand-lg navbar-dark d-lg-none" style="z-index: 2000;">
      <div class="container-fluid">
        <!-- Navbar brand -->
        <a class="navbar-brand nav-link" target="_blank" href="https://mdbootstrap.com/docs/standard/">
          <img src="<?php echo base_url('asset/299584772_435117378634124_6677388645313997495_n.png'); ?>" height="30"
            alt="" loading="lazy" />
        </a>
        <!-- Add an id to the button for toggling the mobile navbar -->
        <button id="mobileNavbarToggler" class="navbar-toggler" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbarExamplePhone" aria-controls="navbarExamplePhone" aria-expanded="false"
          aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarExamplePhone">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item active">
              <a class="nav-link" aria-current="page" href="<?php echo base_url('page/landing_page'); ?>">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('page/reserve'); ?>">Reserve</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <script>
    // JavaScript to close the mobile navbar when a navigation link is clicked
    document.addEventListener("DOMContentLoaded", function () {
      // Get the mobileNavbarToggler button and the mobile navbar
      var mobileNavbarToggler = document.getElementById("mobileNavbarToggler");
      var mobileNavbar = document.getElementById("navbarExamplePhone");

      // Add a click event listener to each navigation link
      var navLinks = mobileNavbar.querySelectorAll(".nav-link");
      navLinks.forEach(function (link) {
        link.addEventListener("click", function () {
          // Close the mobile navbar
          if (mobileNavbar.classList.contains("show")) {
            mobileNavbarToggler.click(); // Click the button to close the navbar
          }
        });
      });
    });
  </script>
</body>

</html>