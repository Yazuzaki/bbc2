<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="This is a login page template based on Bootstrap 5">
	<title>Bootstrap 5 Login Page</title>
	<link rel="stylesheet" href="<?php echo site_url() ?>asset/all.css">
	<link rel="stylesheet" href="<?php echo site_url() ?>asset/toast/toast.min.css">
	<script src="<?php echo site_url() ?>asset/toast/jqm.js"></script>
	<style>
		.image-container {
			background: url(<?php echo base_url('asset/bg.png'); ?>) left center / cover no-repeat;
			width: 138vh;
			height: 103vh;
			position: absolute;
			z-index: -1;
		}

		@media (max-width: 768px) {
			.image-container {
				width: 100%;
				/* Make the background width 100% of the viewport */
				height: auto;
				/* Allow the height to adjust automatically */
				background-size: cover;
				/* Maintain the cover aspect ratio */
				background-position: center;
				/* Center the background */
			}
		}

		#imgCompany {
			position: absolute;
			left: 50%;
			top: 0;
			transform: translate(-50%, -20%);
		}
	</style>
	<script>
		 document.addEventListener("DOMContentLoaded", function () {
		  if (email && password) {
                document.getElementById('login-button').click();
            }
		});
		</script>


</head>

<body>
	<div class="image-container"></div>

	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-end h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9" style="position:relative;">
					<img id="imgCompany"
						src="<?php echo site_url() ?>asset/299584772_435117378634124_6677388645313997495_n.png"
						alt="logo" width="200">
					<br>
					<br>
					<br>
					<div class="card-body p-5">
						<h1 class="fs-4 card-title fw-bold mb-4">Login</h1>
						<?php echo form_open('Page/process_login') ?>
						<div class="mb-3">
							<label class="mb-2 text-muted" for="email">E-Mail Address</label>
							<input id="email" type="text" class="form-control" name="email"
								value="<?php echo $userDetails['email']; ?>" required autofocus autocomplete="off">
						</div>

						<div class="mb-3">
							<label class="mb-2 text-muted" for="password">Password</label>
							<input id="password" type="password" class="form-control" name="password"
								value="<?php echo $userDetails['password']; ?>" required autocomplete="off">
						</div>


						<div class="d-flex align-items-center">
							<button type="submit" id="login-button" class="btn btn-primary ms-auto">Login</button>
						</div>
						<?php echo form_close(); ?>
					</div>
					<div class="">
						<div class="text-center">
							Don't have an account? <a href="register" class="text-dark">Create One</a>
						</div>
					</div>
				</div>
				<div class="text-center mt-5 text-muted">
				</div>
			</div>
		</div>
	</section>
</body>

</html>