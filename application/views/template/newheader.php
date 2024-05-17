<!-- Header -->
<header id="header"><a class="navbar-brand nav-link" href="<?php echo base_url('page/landing_page'); ?>">
          <img src="<?php echo base_url('asset/299584772_435117378634124_6677388645313997495_n.png'); ?>" height="60"
            alt="" loading="lazy" />
        </a>
		<nav><a href="#menu">Menu</a>
		</nav>
	</header><!-- Nav -->
	<nav id="menu">
		<ul class="links">
			<li><a class="nav-link" aria-current="page" href="<?php echo base_url('page/landing_page'); ?>">Home</a></li>
			<li> <a class="nav-link" href="<?php echo base_url('page/reservation_view'); ?>">Reserve</a></li>
			<li><a class="nav-link" href="<?php echo base_url('page/reserve_status'); ?>">My Reservation</a></li>
      <li><a class="nav-link" href="<?php echo base_url('page/courtvis'); ?>">Court Availability</a></li>
		</ul>
        <ul class="links">
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
		</ul>
	</nav>