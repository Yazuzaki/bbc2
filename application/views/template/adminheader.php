<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Add Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="<?php echo base_url('asset/BBCLOGO.jpg'); ?>">
  <!-- Add jQuery and Bootstrap JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
  <style>
    .navbar-nav.ml-auto {
      margin-left: auto;
    }
  </style>
  <script src="https://kit.fontawesome.com/f637f0ce7e.js" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo base_url('page/landing_page'); ?>">
      <img src="<?php echo base_url('asset/299584772_435117378634124_6677388645313997495_n.png'); ?>" alt="Logo" height="30">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('page/landing_page'); ?>">Home</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('page/admin'); ?>">Admin</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('page/timetable'); ?>">Timetable</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('page/history'); ?>">History</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('page/approved'); ?>">Approved</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url('page/loginview'); ?>">Login</a></li>
        <li class="nav-item"><a class="nav-link bg-success" href="<?php echo base_url('page/register'); ?>">Get Started</a></li>
      </ul>
    </div>
  </div>
</nav>

          
    
