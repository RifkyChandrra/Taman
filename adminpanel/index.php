<?php
    require "session.php";
    require "../koneksi.php";

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);

    $queryKecamatan = mysqli_query($con, "SELECT * FROM kecamatan");
    $jumlahKecamatan = mysqli_num_rows($queryKecamatan);

    $queryTaman = mysqli_query($con, "SELECT * FROM taman");
    $jumlahTaman = mysqli_num_rows($queryTaman);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .kotak {
        border: solid;
    }

    .summary-kategori{
        background-color: #0a6b4a;
        border-radius: 15px;
    }

    .summary-taman{
        background-color: #0a516b;
        border-radius: 15px;
    }

    .no-decoration{
        text-decoration: none;
    }
</style>


<body>
    <?php require "navbar.php";?>
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-home"></i> Home
                </li>
            </ol>
        </nav>
        <h2>Hallo <?php echo $_SESSION['username'] ?> </h2>

         <div class="container mt-5">
            <div class="row">

                <div class="col-lg-4 col-md-6 col-12 mb-3 summary-block">
                    <div class="summary-kategori p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-align-justify fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Kategori</h3>
                                <p class="fs-4"><?php echo $jumlahKategori; ?> Kategori</p>
                                <p><a href="kategori.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3 summary-block">
                    <div class="summary-kategori p-3 bg-info">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa-solid fa-city fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Kecamatan</h3>
                                <p class="fs-4"><?php echo $jumlahKecamatan; ?> kecamatan</p>
                                <p><a href="kecamatan.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 summary-block">
                    <div class="summary-taman p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-solid fa-tree fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Taman</h3>
                                <p class="fs-4"><?php echo $jumlahTaman; ?> Taman</p>
                                <p><a href="taman.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>