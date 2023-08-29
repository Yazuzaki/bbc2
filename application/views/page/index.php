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
					
                    <div class="card text-white bg-primary">
                        <img class="card-img-top" src="holder.js/100x180" alt="">
                        <div class="card-body">
                            <h4 class="card-title">Welcome </h4>
                            <p class="card-text">Users</p>
                            <a href="<?php echo base_url('Page/logout'); ?>">Logout</a>
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

