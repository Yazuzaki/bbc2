<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="User Profile Page">
    <title>User Profile</title>
    <link rel="stylesheet" href="<?php echo site_url() ?>asset/all.css">
    <link rel="stylesheet" href="<?php echo site_url() ?>asset/toast/toast.min.css">
    <script src="<?php echo site_url() ?>asset/toast/jqm.js"></script>
    <style>
        /* Add your custom styles here */
        .reservation-container {
            margin-top: 20px;
        }

        .reservation-item {
            margin-bottom: 10px;
        }

        .cancel-link {
            color: red;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-end h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                    <div class="text-center my-5">
                        <img id="companyimg"
                            src="<?php echo site_url() ?>asset/299584772_435117378634124_6677388645313997495_n.png"
                            alt="logo" width="200">
                    </div>

                    <div class="card text-white bg-primary">
                        <img class="card-img-top" src="holder.js/100x180" alt="">
                        <div class="card-body">
                            <!-- Display user name from session -->
                            <p>Welcome,</p>
                            <!-- Use $username here -->
                            <p class="card-text"><?php echo $name; ?> !</p>

                    <div class="text-center mt-5 text-muted">
                        <!-- Additional content as needed -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
