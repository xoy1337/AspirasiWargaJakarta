<?php
require_once 'koneksi.php';

if(isset($_POST['login'])){
  $data = query("SELECT id, isAdmin FROM admin WHERE username='{$_POST['username']}' AND password= '{$_POST['password']}'");
    if (!empty($data)) {
        foreach($data as $d)
        $_SESSION['login'] = $d['id'];
        if($d['isAdmin']){
            $_SESSION['isAdmin'] = $d['id'];
        }
        header('location: detail_aspirasi.php');
    }
    else{
      echo "
            <script>
                alert('Data Salah Silahkan Coba Lagi');
            </script>";
    }
  }

if(!isset($_GET['id'])){
    header('location: aspirasi.php');
}

if(isset($_POST['send'])){
    sendFeedback($_POST);
}

if(isset($_POST['acc'])){
    mysqli_query($conn, "UPDATE aspirasi set status_aspirasi = 1 WHERE id_aspirasi ={$_POST['idAspirasi']}");
    header("location: aspirasi.php");
  }
  
  if(isset($_POST['del'])){
    mysqli_query($conn,"DELETE FROM aspirasi WHERE id_aspirasi = '{$_POST['idAspirasi']}'");
    header("location: aspirasi.php");
  }

$aspirasi = query("SELECT a.id_aspirasi, a.judul_aspirasi, a.isi_aspirasi, a.tanggal, a.lokasi, a.status_aspirasi, c.jenis_kategori, p.nama_penduduk, p.alamat 
                    FROM aspirasi AS a INNER JOIN kategori AS c ON (c.id_kategori = a.id_kategori)
                                        INNER JOIN penduduk AS p ON (p.id_penduduk = a.id_penduduk)
                    WHERE a.id_aspirasi = {$_GET['id']}       
                    ORDER BY a.status_aspirasi");

$feedback = query("SELECT id, feedback, isAdmin, created_at FROM feedbacks
                        WHERE aspirasi_id = {$_GET['id']}
                        ORDER BY created_at");
// var_dump($feedback);die;


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
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/album/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
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
  <nav class="navbar navbar-dark bg-dark" aria-label="Dark offcanvas navbar">
    <div class="container-fluid">
      <a class="navbar-brand" data-bs-toggle="modal" <?php if(!isset($_SESSION['isAdmin'])):?> data-bs-target="#loginModal" <?php endif;?> href="#">Aspirasi Warga Jakarta</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarDark" aria-controls="offcanvasNavbarDark">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbarDark" aria-labelledby="offcanvasNavbarDarkLabel">
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
          </ul>
        </div>
      </div>
    </div>
  </nav>
    </main>

    <div class="container-fluid mb-5">
        <div class="container px-5">
            <h1 class="mb-5">Aspirasi Rakyat</h1>
            <?php foreach($aspirasi as $a)?>
            <hr>
            <table class="table table-striped table-sm">
            <tbody>
                <tr>
                <td>Nomor</td>
                <td><?= $a['id_aspirasi']?></td>
                <td></td>
                </tr>
                <tr>
                <td>Tanggal</td>
                <td><?= $a['tanggal']?></td>
                <td></td>
                </tr>
                <tr>
                <td>Nama</td>
                <td><?= $a['nama_penduduk']?></td>
                <td></td>
                </tr>
                <tr>
                <td>Status</td>
                <td><?= $a['status_aspirasi'] ? 'Sudah selesai' : 'Belum selesai'?></td>
                <td></td>
                </tr>
                <tr>
                <td>Tempat Kejadian</td>
                <td><?= $a['alamat'] .", ". $a['lokasi']?></td>
                <td></td>
                </tr>
                <tr>
                <td>Jenis Masalah</td>
                <td><?= $a['jenis_kategori']?></td>
                <td></td>
                </tr>
                <tr>
                <td>Pesan</td>
                <td colspan="2"><?= $a['isi_aspirasi']?></td>
                </tr>
            </tbody>
            </table>
        <hr class="mb-3 mt-5">
        <form action="" method="post">
        <div class="d-flex flex-row-reverse justify-content-between">
            <input type="hidden" name="idAspirasi" value="<?= $a['id_aspirasi']?>">
            <?php if(isset($_SESSION['login'])): ?>
            <?php if(!$a['status_aspirasi']): ?>
            <button class=" btn btn-lg btn-success" type="submit" name="acc">Selesai</button>
            <?php endif; ?>
            <button class=" btn btn-lg btn-danger" type="submit" name="del">Hapus</button>
            <?php endif; ?>
        </div>
        </form>
        <hr class="mt-3 mb-5">
        </div>
        <div class="container d-flex justify-content-center">
        <div class="col-md-8 col-lg-9 col-xl-10">
        <?php 
        foreach($feedback as $f):
        if (!$f['isAdmin']):
        ?>
                <li class="d-flex justify-content-start mb-4" id="<?=$f['id']?>">
                    <div class="card w-100">
                    <div class="card-header d-flex justify-content-between p-3">
                        <p class="fw-bold mb-0">Warga</p>
                        <p class="text-muted small mb-0"><i class="far fa-clock"><?= $f['created_at']?></i> </p>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">
                        <?=$f['feedback']?>
                        </p>
                    </div>
                    </div>
                </li>
        <?php else: ?>
                <li class="d-flex justify-content-end mb-4" id="<?=$f['id']?>">
                    <div class="card w-100">
                    <div class="card-header d-flex justify-content-between p-3">
                        <p class="fw-bold mb-0">Admin</p>
                        <p class="text-muted small mb-0"><i class="far fa-clock"><?= $f['created_at']?></i> </p>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">
                        <?=$f['feedback']?>
                        </p>
                    </div>
                    </div>
                </li>
        <?php
        endif;
        endforeach;
        ?>
                <form action="" method="post">
                    <input type="hidden" name="aspirasi_id" value="<?=$a['id_aspirasi']?>">
                    <div class="bg-white mb-3">
                    <div class="form-outline">
                        <p>Kirim Feedback</p>
                        <textarea class="form-control" id="textAreaExample2" rows="4" name="feedback" required></textarea>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 btn-rounded float-end" name="send">Send</button>
                </form>
                </ul>
                <a id="back" href="http://localhost/siwarga-PHP/aspirasi.php" class="btn btn-primary mt-4">Back</a>
            </div>
            </div>
    </div>

  <!-- FOOTER -->
    <footer class="container">
        <p class="float-end"><a href="#">Back to top</a></p>
        <p>&copy; 2017–2022 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
    </footer>
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
        <form class="p-4 p-md-5 border rounded-3 bg-light" action="" method="POST">
                <input type="hidden" name="id_aspirasi" value="">
                <div class="text-center">
                <h2>Ada Masalah di Daerah Mu?</h2>
                <p>Buat dan Kirim Laporan Sekarang Juga!!!</p>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" name="nama_penduduk">
                    <label for="floatingInput">Nama Lengkap</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" name="alamat">
                    <label for="floatingInput">Alamat</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="floatingInput" name="tanggal">
                    <label for="floatingInput">Waktu Kejadian</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" name="judul_aspirasi">
                    <label for="floatingInput">Judul Aspirasi</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" name="lokasi">
                    <label for="floatingInput">Lokasi Kejadian</label>
                </div>
                <div class="form-floating mb-3">
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