<?php
    require "session.php";
    require "../koneksi.php";
    
    $id = $_GET['p'];

    $query = mysqli_query($con, "SELECT * FROM kecamatan WHERE id='$id'");
    $data = mysqli_fetch_array($query);

    if (!$data) {
        echo "Data tidak ditemukan.";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kecamatan</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <h2>Detail Kecamatan</h2>
        
        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="kecamatan">Nama Kecamatan</label>
                    <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="<?php echo $data['nama']; ?>">
                </div>
                <div>
                    <label for="kode">Kode Daerah</label>
                    <input type="text" name="kode" id="kode" class="form-control" value="<?php echo $data['kode']; ?>">
                </div>

                <div class="mt-3 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editBtn">Update</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn" formaction="kecamatan-detail.php?p=<?php echo $id; ?>">Delete</button>
                </div>
            </form>

            <?php
               if(isset($_POST['editBtn'])){
                    $kecamatan = htmlspecialchars($_POST['kecamatan']);
                    
                    if($data['nama'] == $kecamatan){
                        ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Kecamatan tidak diubah karena nilai tetap sama
                            </div>
                        <?php
                    } else {
                        $queryCheck = mysqli_query($con, "SELECT * FROM kecamatan WHERE nama='$kecamatan' AND id != '$id'");
                        $jumlahData = mysqli_num_rows($queryCheck);
                        
                        if($jumlahData > 0){
                            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Kecamatan sudah ada
                            </div>
                            <?php
                        } else {
                            $queryUpdate = mysqli_query($con, "UPDATE kecamatan SET nama= '$kecamatan' WHERE id='$id'");

                            if($queryUpdate){
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Kecamatan berhasil diubah
                                </div>

                                <meta http-equiv="refresh" content="1; url=kecamatan.php" />
                                <?php  
                            } else {
                                echo mysqli_error($con);
                            }
                        }
                    }
               } 

               if(isset($_POST['deleteBtn'])){
                    $queryCheck = mysqli_query($con, "SELECT * FROM taman WHERE kecamatan_id= '$id'");

                    if ($queryCheck === false) {
                        die("Query error: " . mysqli_error($con));
                    }
                    
                    $dataCount = mysqli_num_rows($queryCheck);
                    
                    if ($dataCount > 0) {
            ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            Kecamatan tidak bisa dihapus karena sudah digunakan untuk taman
                        </div>
            <?php
                    } else {
                        $queryDelete = mysqli_query($con, "DELETE FROM kecamatan WHERE id='$id'");
                    
                        if ($queryDelete) {
                            ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                Kecamatan berhasil dihapus
                            </div>
                    
                            <meta http-equiv="refresh" content="1; url=kecamatan.php" />
                            <?php
                        } else {
                            ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                Gagal menghapus kecamatan. Error: <?php echo mysqli_error($con); ?>
                            </div>
                            <?php
                        }
                    }
               }
            ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
