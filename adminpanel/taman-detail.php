<?php
    require "session.php";
    require "../koneksi.php";
    
    $id = isset($_GET['p']) ? intval($_GET['p']) : 0;

    $query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kecamatan, c.nama AS nama_kategori FROM taman a JOIN kecamatan b ON a.kecamatan_id=b.id JOIN kategori c ON a.kategori_id=c.id WHERE a.id=$id");
    $data = mysqli_fetch_array($query);
    
    $queryKecamatan = mysqli_query($con, "SELECT * FROM kecamatan WHERE id!='$data[kecamatan_id]'");
    $queryKategori = mysqli_query($con, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taman Detail</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<style>
    form div{
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Detail Taman</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?php echo $data['nama_taman']; ?>" class="form-control" autocomplete="off" required>
                </div>
                <div>
                    <label for="kecamatan">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan" class="form-control" required>
                        <option value="<?php echo $data['kecamatan_id']; ?>"><?php echo $data['nama_kecamatan'] ?></option>
                    <?php
                        while($dataKecamatan=mysqli_fetch_array($queryKecamatan)){
                    ?>
                        <option value="<?php echo $dataKecamatan['id']?>"><?php echo $dataKecamatan['nama'] ?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="<?php echo $data['kategori_id']; ?>"><?php echo $data['nama_kategori'] ?></option>
                    <?php
                        while($dataKategori=mysqli_fetch_array($queryKategori)){
                    ?>
                        <option value="<?php echo $dataKategori['id']?>"><?php echo $dataKategori['nama'] ?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>
                <div>
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control" required>
                        <?php echo $data['alamat']; ?>
                    </textarea>
                </div>
                <div>
                    <label for="fasilitas">Fasilitas</label>
                    <textarea name="fasilitas" id="fasilitas" cols="30" rows="5" class="form-control" required>
                        <?php echo $data['fasilitas']; ?>
                    </textarea>
                </div>
                <div>
                    <label for="operasional">Jam Operasional</label>
                    <input type="text" class="form-control" name="operasional" value="<?php echo $data['jam_operasional']; ?>" required>
                </div>
                <div>
                    <label for="curentFoto">Foto Taman Sekarang</label>
                    <img src="../image/taman/<?php echo $data['foto']?>" alt="" width="250px">
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="latitude">Latitude</label>
                    <input type="text" class="form-control" name="latitude" value="<?php echo $data['latitude']; ?>" required>
                </div>
                <div>
                    <label for="longitude">Longitude</label>
                    <input type="text" class="form-control" name="longitude" value="<?php echo $data['longitude']; ?>" required>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                    <button class="btn btn-danger" type="submit" name="hapus">Hapus</button>
                </div>
            </form>
            
            <?php
                if(isset($_POST['simpan'])){
                    $nama = htmlspecialchars($_POST['nama']);
                    $kecamatan = htmlspecialchars($_POST['kecamatan']);
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $alamat = htmlspecialchars($_POST['alamat']);
                    $fasilitas = htmlspecialchars($_POST['fasilitas']);
                    $operasional = htmlspecialchars($_POST['operasional']);
                    $latitude = htmlspecialchars($_POST['latitude']);
                    $longitude = htmlspecialchars($_POST['longitude']);

                    $queryUpdate = mysqli_query($con, "UPDATE taman SET nama_taman='$nama', kecamatan_id='$kecamatan', kategori_id='$kategori', alamat='$alamat', fasilitas='$fasilitas', jam_operasional='$operasional', latitude='$latitude', longitude='$longitude' WHERE id=$id");

                    // Check if there's a file uploaded
                    if(isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
                        $target_dir = "../image/taman/";
                        $nama_file = basename($_FILES["foto"]["name"]);
                        $target_file = $target_dir . $nama_file;
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                        $image_size = $_FILES["foto"]["size"];
                        $random_name = generateRandomString(20);
                        $new_name = $random_name . "." . $imageFileType;

                        if($image_size > 500000){
            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                File Tidak Boleh Lebih dari 500kb
                            </div>
            <?php                  
                        } elseif($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg'){
            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                File Wajib Bertipe Jpg, Png, dan Jpeg 
                            </div>
            <?php
                        } else {
                            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);

                            $queryUpdateFoto = mysqli_query($con, "UPDATE taman SET foto='$new_name' WHERE id='$id'");

                            if($queryUpdateFoto){
            ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Taman berhasil Diupdate
                                </div>
                                <meta http-equiv="refresh" content="1; url=taman.php" />
            <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }
                    } else {
                        // No file uploaded, display success message
            ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Taman berhasil Diupdate
                        </div>
                        <meta http-equiv="refresh" content="1; url=taman.php" />
            <?php
                    }
                }

                if(isset($_POST['hapus'])){
                    $queryHapus = mysqli_query($con, "DELETE FROM taman WHERE id='$id'");

                    if($queryHapus){
            ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Taman berhasil dihapus
                        </div>
                        <meta http-equiv="refresh" content="1; url=taman.php" />
            <?php
                    }
                }
            ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
