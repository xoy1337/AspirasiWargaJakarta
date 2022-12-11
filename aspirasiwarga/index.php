<?php
require_once "koneksi.php";

if(isset($_POST['login'])){
  $data = query("SELECT id, isAdmin FROM admin WHERE username='{$_POST['username']}' AND password= '{$_POST['password']}'");
    if (!empty($data)) {
        foreach($data as $d)
        $_SESSION['login'] = $d['id'];
        if($d['isAdmin']){
            $_SESSION['isAdmin'] = $d['id'];
        }
        header('location: index.php');
    }
    else{
      echo "
            <script>
                alert('Data Salah Silahkan Coba Lagi');
            </script>";
    }
  }

if(isset($_POST['lapor'])){
  if(aspirasi($_POST) > 0){
    echo" <script>
      alert('Aspirasi Berhasil Terkirim');
      windows.location = 'index.php';
      </script> ";
  }else{
    echo"<script>
    alert('Aspirasi Gagal Dikirim');
    </script>";
  }
}


?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>Aspirasi Warga Jakarta</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/carousel/">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/navbars-offcanvas/">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: 1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="css/carousel.css" rel="stylesheet">
  </head>
  <body>
<main>
  <nav class="navbar navbar-dark bg-primary" aria-label="Dark offcanvas navbar">
    <div class="container-fluid">
      <a class="navbar-brand" data-bs-toggle="modal" data-bs-target="#loginModal" href="#">Aspirasi Warga Jakarta</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarDark" aria-controls="offcanvasNavbarDark">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-primary" tabindex="-1" id="offcanvasNavbarDark" aria-labelledby="offcanvasNavbarDarkLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarDarkLabel">Aspirasi Warga Jakarta</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="aspirasi.php">Aspirasi</a>
            </li>
            <?php if(!isset($_SESSION['isAdmin'])):?>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="modal" data-bs-target="#laporModal" href="#">Lapor</a>
            </li>
            <?php endif; ?>
            <?php if(isset($_SESSION['isAdmin'])):?>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
            <?php endif;?>
            <!-- <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li> -->
          </ul>
        </div>
      </div>
    </div>
  </nav>
</main>

<main>

    <div class="carousel-inner">
      <div class="carousel-item active">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></svg>

        <div class="container">
          <div class="carousel-caption">
            <h1>Pelayanan Aspirasi Warga Jakarta</h1>
            <p>Untuk menampung aspirasi untuk warga jakarta dan berusaha untuk memecahkan solusi yang ada di masyarakat.</p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></svg>
  
  </div>

  </div>

  <!-- FOOTER -->
  <footer class="container">
    <p class="float-end"><a href="#">Back to top</a></p>
    <p>&copy; Made by Refzy</p>
  </footer>
</main>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

<!-- MODALS -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="loginModalLabel">Login</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
    <form class="p-4 p-md-5 border rounded-3 bg-light" action="" method="POST">
            <div class="text-center">
            <h2>Apakah Kamu Admin?</h2>
            <p>Masuk Sekarang</p>
            </div>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Username">
              <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
              <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Masuk</button>
            <hr class="my-4">
          </form>
  </div>
</div>
</div>
</div>

<div class="modal fade" id="laporModal" tabindex="-1" aria-labelledby="laporModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="laporModalLabel">Buat Laporan</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    <form class="p-2 p-md-4 border rounded-3 bg-light" action="" method="POST">
                <input type="hidden" name="id_aspirasi" value="">
                <div class="text-center">
                <h2>Ada masalah di daerah anda?</h2>
                <p>Berikan laporan anda ke kami segera dan kami berusaha untuk menyelesaikan.</p>
                </div>
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="floatingInput" name="nama_penduduk">
                    <label for="floatingInput">Nama Lengkap</label>
                </div>
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="floatingInput" name="alamat">
                    <label for="floatingInput">Alamat</label>
                </div>
                <div class="form-floating mb-2">
                    <input type="date" class="form-control" id="floatingInput" name="tanggal">
                    <label for="floatingInput">Waktu Kejadian</label>
                </div>
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="floatingInput" name="judul_aspirasi">
                    <label for="floatingInput">Judul Aspirasi</label>
                </div>
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="floatingInput" name="lokasi">
                    <label for="floatingInput">Lokasi Kejadian</label>
                </div>
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="floatingInput" name="isi_aspirasi">
                    <label for="floatingInput">Isi Aspirasi</label>
                </div>
              <div class="form-floating mb-3">
                <select class="form-control" id="floatingInput" name="id_kategori">
                  <option value="1">Lingkungan</option>
                  <option value="2">Keamanan</option>
                  <option value="3">Masyarakat</option>
                </select>
                <label for="floatingInput">Kategori</label>
              </div>

              <button class="w-100 btn btn-lg btn-primary" type="submit" name="lapor">Kirim</button>
              <hr class="my-4">
            </form>
    </div>
</div>
</div>
</div>
  <!-- END MODALS -->
  </body>
</html>