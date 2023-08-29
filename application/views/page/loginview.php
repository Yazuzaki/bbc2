<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="This is a login page template based on Bootstrap 5">
    <title>Bootstrap 5 Login Page</title>
    <link rel="stylesheet" href="<?php echo site_url()?>asset/all.css">
    <link rel="stylesheet" href="<?php echo site_url()?>asset/toast/toast.min.css">
    <script src="<?php echo site_url()?>asset/toast/jqm.js"></script>
    <style>
        .image-container {
            background: url(<?php echo base_url('asset/bg.png');?>) left center / cover no-repeat;
            width: 138vh;
            height: 103vh;
            position: absolute;
            z-index: -1; 
        }
    </style>
</head>
<body>
    <div class="image-container"></div>

	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-end h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="<?php echo site_url()?>asset/299584772_435117378634124_6677388645313997495_n.png" alt="logo" width="100">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Login</h1>
							<?php echo form_open('Page/login_form')?>
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" value="" required autofocus>
									
								</div>

								<div class="mb-3">
								
                                    <label class="mb-2 text-muted" for="password">Passsword</label>
									<input id="password" type="password" class="form-control" name="password" required>
								  
								</div>

								<div class="d-flex align-items-center">
								
									<button type="submit" class="btn btn-primary ms-auto">
										Login
									</button>
								</div>
						<?php echo form_close(); ?>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								Don't have an account? <a href="register" class="text-dark">Create One</a>
							</div>
						</div>
					</div>
					<div class="text-center mt-5 text-muted">
					</div>
				</div>
			</div>
		</div>
	</section>

</body>
</html>

