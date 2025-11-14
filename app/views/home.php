<!DOCTYPE html>
<html class="no-js" lang="">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Beranda | SIMPEMA</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Place favicon.ico in the root directory -->

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="<?= ASSETS_URL?>/landing/css/bootstrap-5.0.0-beta1.min.css" />
    <link rel="stylesheet" href="<?= ASSETS_URL?>/landing/css/LineIcons.2.0.css"/>
    <link rel="stylesheet" href="<?= ASSETS_URL?>/landing/css/tiny-slider.css"/>
    <link rel="stylesheet" href="<?= ASSETS_URL?>/landing/css/animate.css"/>
    <link rel="stylesheet" href="<?= ASSETS_URL?>/landing/css/lindy-uikit.css"/>
    <link rel="stylesheet" href="<?= ASSETS_URL?>/vendor/fontawesome-free/css/all.min.css"/>
  </head>
  <body>


    <!-- ========================= preloader start ========================= -->
    <div class="preloader">
      <div class="loader">
        <div class="spinner">
          <div class="spinner-container">
            <div class="spinner-rotator">
              <div class="spinner-left">
                <div class="spinner-circle"></div>
              </div>
              <div class="spinner-right">
                <div class="spinner-circle"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ========================= preloader end ========================= -->

    <!-- ========================= hero-section-wrapper-5 start ========================= -->
    <section id="home" class="hero-section-wrapper-5">

      <!-- ========================= header-6 start ========================= -->
      <header class="header header-6">
        <div class="navbar-area">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg">
                  <a class="navbar-brand" href="index.html">
                    <!-- <img src="assets/img/logo/logo.svg" alt="Logo" /> -->
                     <h5>SIMPEMA</h6>
                  </a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent6" aria-controls="navbarSupportedContent6" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                  </button>
  
                  <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent6">
                    <ul id="nav6" class="navbar-nav ms-auto">
                      <li class="nav-item">
                        <a class="page-scroll active" href="#home"> <i class="fas fa-home"></i> Beranda</a>
                      </li>
                      <li class="nav-item">
                        <a class="page-scroll" href="<?= ASSETS_URL?>dokumen/TEMPLATE JURNAL.docx" class="btn btn-primary rounded" download><i class="lni lni-cloud-download"></i> Unduh template</a>
                      </li>
                      <li class="nav-item">
                        <a class="page-scroll" href="<?=BASE_URL?>/Home/login">Login</a>
                      </li>
                    </ul>
                  </div>
                  <!-- navbar collapse -->
                </nav>
                <!-- navbar -->
              </div>
            </div>
            <!-- row -->
          </div>
          <!-- container -->
        </div>
        <!-- navbar area -->
      </header>
      <!-- ========================= header-6 end ========================= -->

      <!-- ========================= hero-5 start ========================= -->
      <div class="hero-section hero-style-5 img-bg" style="background-image: url('<?=ASSETS_URL?>/landing/img/hero/hero-5/hero-bg.svg')">
        <div class="container">
          <div class="row">
            <div class="col-lg-6">
              <div class="hero-content-wrapper">
                <h2 class="mb-30 wow fadeInUp" data-wow-delay=".2s">SIMPEMA</h2>
                <p class="mb-30 wow fadeInUp" data-wow-delay=".4s">Sistem Informasi Manajemen Penelitian Mahasiswa.</p>
                <a href="<?=BASE_URL?>/Home/upload" class="button button-lg radius-50 wow fadeInUp mb-2" data-wow-delay=".6s">Unggah Dokumen <i class="lni lni-chevron-right"></i> </a>
              </div>
            </div>
            <div class="col-lg-6 align-self-end">
              <div class="hero-image wow fadeInUp" data-wow-delay=".5s">
                <img src="<?=ASSETS_URL?>/landing/img/hero/hero-5/hero-img-storage.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ========================= hero-5 end ========================= -->

    </section>
    <!-- ========================= hero-section-wrapper-6 end ========================= -->

    <!-- ========================= footer style-4 start ========================= -->
     <footer class="footer footer-style-4">
      <div class="container">
        <div class="widget-wrapper">
          <div class="row">
            <div class="col-xl-5 col-lg-4 col-md-6">
              <div class="footer-widget wow fadeInUp" data-wow-delay=".2s">
                <div class="logo">
                  <!-- <a href="#0">
                    <img src="assets/img/logo/logo.svg" alt="" />
                  </a> -->
                  <h3>LPPM MU</h3>
                </div>
                <p class="desc">
                  Jl. Raya Cipacing No. 22 Jatinangor 45363 Jawa Barat
                  <br />
                  e-mail : lppm.masoemuniversity@gmail.com
                </p>
                <ul class="socials">
                  <li>
                    <a href="#0"> <i class="lni lni-facebook-filled"></i> </a>
                  </li>
                  <li>
                    <a href="#0"> <i class="lni lni-twitter-filled"></i> </a>
                  </li>
                  <li>
                    <a href="#0"> <i class="lni lni-instagram-filled"></i> </a>
                  </li>
                  <li>
                    <a href="#0"> <i class="lni lni-linkedin-original"></i> </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-xl-3 offset-xl-1 col-lg-2 col-md-6 col-sm-6">
              <div class="footer-widget wow fadeInUp" data-wow-delay=".3s">
                <h6>Quick Link</h6>
                <ul class="links">
                  <li><a href="#0">Home</a></li>
                  <li><a href="#0">About</a></li>
                  <li><a href="#0">Service</a></li>
                  <li><a href="#0">Testimonial</a></li>
                  <li><a href="#0">Contact</a></li>
                </ul>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
              <div class="footer-widget wow fadeInUp" data-wow-delay=".4s">
                <h6>Services</h6>
                <ul class="links">
                  <li><a href="#0">Web Design</a></li>
                  <li><a href="#0">Web Development</a></li>
                  <li><a href="#0">Seo Optimization</a></li>
                  <li><a href="#0">Blog Writing</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="copyright-wrapper wow fadeInUp" data-wow-delay=".2s">
          <p>&copy;Copyright 2025. LPPM MU</p>
        </div>
      </div>
    </footer>
    <!-- ========================= footer style-4 end ========================= -->

    <!-- ========================= scroll-top start ========================= -->
    <a href="#" class="scroll-top"> <i class="lni lni-chevron-up"></i> </a>
    <!-- ========================= scroll-top end ========================= -->
		

    <!-- ========================= JS here ========================= -->
    <script src="<?= ASSETS_URL?>/landing/js/bootstrap-5.0.0-beta1.min.js"></script>
    <script src="<?= ASSETS_URL?>/landing/js/tiny-slider.js"></script>
    <script src="<?= ASSETS_URL?>/landing/js/wow.min.js"></script>
    <script src="<?= ASSETS_URL?>/landing/js/main.js"></script>
  </body>
</html>
