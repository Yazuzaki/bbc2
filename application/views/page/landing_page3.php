<!DOCTYPE html>
<html lang="en">
<title>Home</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- Font Awesome -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" /> -->
<!-- Google Fonts -->
<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" /> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" /><!-- MDB -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script> -->
</head>

<body>
  <!--Main Navigation-->
  <header>
    <style>
      /* Carousel styling */
      #introCarousel,
      .carousel-inner,
      .carousel-item,
      .carousel-item.active {
        height: 100vh;
        
      }

      .carousel-item:nth-child(1) {
        background-image: url('<?php echo base_url('asset\tarpaulinasver.jpg'); ?>');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
      }

      .carousel-item:nth-child(2) {
        background-image: url('<?php echo base_url('asset\370296386_1581609075931529_4531480717191686445_n.jpg'); ?>');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
      }

      .carousel-item:nth-child(3) {
        background-image: url('<?php echo base_url('asset\368975087_215957004848978_8169321611528092148_n.jpg'); ?>');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
      }

      /* Height for devices larger than 576px */
      @media (min-width: 992px) {
        #introCarousel {
          margin-top: -58.59px;
        }

        #introCarousel,
        .carousel-inner,
        .carousel-item,
        .carousel-item.active {
          height: 50vh;
        }
      }

      .navbar .nav-link {
        color: #fff !important;
      }

      .image-modal {
        display: none;
        position: fixed;
        z-index: 999;
        padding-top: 20px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        text-align: center;
      }

      .image-modal img {
        margin: auto;
        max-width: 90%;
        max-height: 90%;
      }

      .close-button {
        position: absolute;
        top: 15px;
        right: 15px;
        color: white;
        font-size: 20px;
        cursor: pointer;
      }
    </style>



    <!-- Carousel wrapper -->
    <div id="introCarousel" class="carousel slide carousel-fade shadow-2-strong" data-mdb-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-mdb-target="#introCarousel" data-mdb-slide-to="0" class="active"></li>
        <li data-mdb-target="#introCarousel" data-mdb-slide-to="1"></li>
        <li data-mdb-target="#introCarousel" data-mdb-slide-to="2"></li>
      </ol>

      <!-- Inner -->
      <div class="carousel-inner">
        <!-- Single item -->
        <div class="carousel-item active">
          <img src="<?php echo base_url('asset/tarpaulinasver.jpg'); ?>" class="d-block w-100 img-fluid" alt="Image 1">
          <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white text-center">
              <h1 class="mb-3"></h1>
              <h5 class="mb-4"></h5>
              <a class="btn btn-outline-light btn-lg m-2" href="" role="button" rel="nofollow" target="_blank"></a>
              <a class="btn btn-outline-light btn-lg m-2" href="" target="_blank" role="button"></a>
            </div>
          </div>
        </div>

        <!-- Single item -->
        <div class="carousel-item">
          <img src="<?php echo base_url('asset\377276714_1773273606449565_1104129031896993202_n.jpg'); ?>"
            class="d-block w-100 img-fluid" alt="Image 2">
          <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-black text-center">
              <h2></h2>
            </div>
          </div>
        </div>

        <!-- Single item -->
        <div class="carousel-item">
          <img src="<?php echo base_url('asset\368975087_215957004848978_8169321611528092148_n.jpg'); ?>"
            class="d-block w-100 img-fluid" alt="Image 3">
          <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-black text-center">
              <h2></h2>

            </div>
          </div>
        </div>
      </div>
      <!-- Inner -->

      <!-- Controls -->
      <a class="carousel-control-prev" href="#introCarousel" role="button" data-mdb-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#introCarousel" role="button" data-mdb-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </header>
  <!--Main Navigation-->

  <!--Main layout-->
  <main class="mt-5">
    <div class="container">
      <!--Section: Content-->
      <section>
        <div class="row">
          <div class="col-md-6 gx-5 mb-4">
            <div class="bg-image hover-overlay ripple shadow-2-strong" data-mdb-ripple-color="light">
              <img src="<?php echo base_url('asset\200406237_340775037752137_106958076836942923_n.jpg'); ?>"
                class="img-fluid" />
              <a href="#!">
                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
              </a>
            </div>
          </div>

          <div class="col-md-6 gx-5 mb-4">
            <h4><strong>Services</strong></h4>
            <p class="text-muted">
              Our courts are well-maintained and equipped with the latest technology to ensure a top-notch playing
              experience. Enjoy your game in a spacious, well-lit environment, allowing you to perform at your best.


              4th Floor RFC Mall Molino II, Bacoor City 09153730100 Gcash 09060886262 Schedules Weekdays 10am to 12
              midnight Weekends 9am to 12 midnight
            </p>
          </div>
        </div>
      </section>
      <!--Section: Content-->

      <hr class="my-5" />

      <!--Section: Content-->
      <section class="text-center">
        <h4 class="mb-5"><strong>We Offer</strong></h4>

        <div class="row">
          

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
              <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
              
                <img src="<?php echo base_url('asset/377148393_212715685191060_3519859876361067163_n.jpg'); ?>"
                  class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                </a>
              </div>
              <div class="card-body">
                <h5 class="card-title">Beginner Court</h5>
                <p class="card-text">

                </p>

              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-12 mb-4">
            <div class="card">
              <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                <img src="<?php echo base_url('asset/393190170_310186211981848_6741480041867126761_n.jpg'); ?>"
                  class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                </a>
              </div>
              <div class="card-body">
                <h5 class="card-title">Special Court</h5>
                <p class="card-text">

                </p>

              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
              <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                <img src="<?php echo base_url('asset/369988791_1302865683705011_8359087066818662160_n.jpg'); ?>"
                  class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                </a>
              </div>
              <div class="card-body">
                <h5 class="card-title">Regular Court</h5>
                <p class="card-text">

                </p>

              </div>
            </div>
          </div>
        </div>
      </section>
      <!--Section: Content-->

      <hr class="my-5" />

      <!--Section: Content-->
    </div>
  </main>
  <div class="image-modal">
    <span class="close-button">&times;</span>
    <img id="modal-image" src="" alt="Enlarged Image">
  </div>


  <!--Footer-->
  <footer class="bg-light text-lg-start">

  </footer>
  <script>
    // JavaScript for the image modal
    $(document).ready(function () {
      $(".image-clickable").click(function () {
        var imageUrl = $(this).attr("src");
        $("#modal-image").attr("src", imageUrl);
        $(".image-modal").show();
      });

      $(".close-button").click(function () {
        $(".image-modal").hide();
      });
    });
  </script>
  <!-- MDB -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <!-- Custom scripts -->
  <script type="text/javascript" src="js/script.js"></script>
</body>

</html>