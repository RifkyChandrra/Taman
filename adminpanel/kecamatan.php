<?php
    require "session.php";
    require "../koneksi.php";

    $queryKecamatan = mysqli_query($con, "SELECT * FROM kecamatan");
    $jumlahKecamatan = mysqli_num_rows($queryKecamatan);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kecamatan</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<body>
<?php require "navbar.php";?>
<div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Kecamatan
                </li>
            </ol>
        </nav>
    <div class="my-5 col-12 col-md-6">
        <h3>Tambah Kecamatan</h3>

        <form action="kecamatan.php" method="post">
            <div>
                <label for="kode">Kode Daerah</label>
                <input type="text" id="kode" name="kode" placeholder="Input kode kecamatan" class="form-control">
            </div>
            <div>
                <label for="kecamatan">Nama Kecamatan</label>
                <input type="text" id="kecamatan" name="kecamatan" placeholder="Input nama kecamatan" class="form-control">
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                </div>
            </div>
    
        </form>

        <?php
            if(isset($_POST['simpan'])){
                $kode = mysqli_real_escape_string($con, htmlspecialchars($_POST['kode']));
                $kecamatan = mysqli_real_escape_string($con, htmlspecialchars($_POST['kecamatan']));

                $queryExist = mysqli_query($con, "SELECT nama FROM kecamatan WHERE nama='$kecamatan'");
                $jumlahDataKecamatanBaru = mysqli_num_rows($queryExist);

                if($jumlahDataKecamatanBaru > 0){
                    ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Kecamatan sudah ada
                    </div>
                    <?php
                } else {
                    $querySimpan = mysqli_query($con, "INSERT INTO kecamatan (kode, nama) VALUES ('$kode', '$kecamatan')");
                    
                    if($querySimpan){
                        ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Kecamatan berhasil tersimpan
                        </div>

                        <meta http-equiv="refresh" content="2; url=kecamatan.php" />
                        <?php  
                    } else {
                        ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            Gagal menyimpan kecamatan. Error: <?php echo mysqli_error($con); ?>
                        </div>
                        <?php
                    }
                }
            }
            ?>
            <div class="mt-3">
            <h2>Tambah Kecamatan</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Daerah</th>
                            <th>Nama Kecamatan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($jumlahKecamatan == 0){
                            ?>
                            <tr>
                                <td colspan="4" class="text-center">Data Kecamatan Tidak Tersedia</td>
                            </tr>
                            <?php
                        } else {
                            $jumlah = 1;
                            while($data = mysqli_fetch_array($queryKecamatan)){
                                ?>
                                <tr>
                                    <td><?php echo $jumlah; ?></td>
                                    <td><?php echo $data['kode']; ?></td>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td>
                                        <a href="kecamatan-detail.php?p=<?php echo $data['id']; ?>" class="btn btn-info">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $jumlah++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>      
</body>
</html>