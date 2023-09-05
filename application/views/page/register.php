<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Muhamad Nauval Azhar">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="This is a login page template based on Bootstrap 5">
	<title>Bootstrap 5 Login Page</title>
	<link rel="stylesheet" href="<?php echo site_url() ?>asset/all.css">
	<link rel="stylesheet" href="<?php echo site_url() ?>asset/toast/toast.min.css">
	<script src="<?php echo site_url() ?>asset/toast/jqm.js"></script>
</head>
<style>
	.image-container {
		background: url(<?php echo base_url('asset/bg.png'); ?>) left center / cover no-repeat;
		width: 138vh;
		height: 103vh;
		position: absolute;
		z-index: -1;
	}
</style>

<body>
	<div class="image-container"></div>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-end h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="<?php echo site_url() ?>asset/299584772_435117378634124_6677388645313997495_n.png"
							alt="logo" width="100">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Register</h1>
							<?php echo form_open('Page/register_form') ?>
							<form method="POST" class="needs-validation" novalidate="" autocomplete="off">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">Full Name</label>
									<input id="name" name="name" type="text" class="form-control" value="" required
										autofocus>

								</div>
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">E-Mail Address</label>
									<input id="email" name="email" type="email" class="form-control" value="" required
										autofocus>

								</div>

								<div class="mb-3">

									<label class="mb-2 text-muted" for="password">Passsword</label>
									<input id="password" name="password" type="password" class="form-control" required>

								</div>

								<div class="mb-3">

									<label class="mb-2 text-muted" for="password">Confirm Passsword</label>
									<input id="password" name="con_password" type="password" class="form-control"
										required>

								</div>

								<div class="d-flex align-items-center">

									<button type="submit" class="btn btn-primary ">
										Register
									</button>
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								Have an account ? <a href="loginview" class="text-dark"> Login</a>
							</div>
						</div>
					</div>
					<div class="text-center mt-5 text-muted">
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php echo form_close(); ?>

</body>

</html>