<?php
require "session.php";
require "../koneksi.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kecamatan, c.nama AS nama_kategori FROM taman a JOIN kecamatan b ON a.kecamatan_id=b.id JOIN kategori c ON a.kategori_id=c.id");

$jumlahTaman = mysqli_num_rows($query);

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
$queryKecamatan = mysqli_query($con, "SELECT * FROM kecamatan");

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
    <title>Taman</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php";?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Taman
                </li>
            </ol>
        </nav>

        <!-- Tambah Taman -->
        <div class="my-7 col-12 col-md-6">
            <h2>Tambah Taman</h2>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required
                        value="<?php echo isset($_SESSION['input_data']['nama']) ? $_SESSION['input_data']['nama'] : ''; ?>">
                </div>
                <div>
                    <label for="kecamatan">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan" class="form-control" required>
                        <?php
                            while ($data=mysqli_fetch_array($queryKecamatan)){
                        ?>
                        <option value="<?php echo $data['id']?>"><?php echo $data['nama'] ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <?php
                            while ($data=mysqli_fetch_array($queryKategori)){
                        ?>
                        <option value="<?php echo $data['id']?>"><?php echo $data['nama'] ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" cols="20" rows="5" class="form-control"
                        required><?php echo isset($_SESSION['input_data']['alamat']) ? $_SESSION['input_data']['alamat'] : ''; ?></textarea>
                </div>
                <div>
                    <label for="fasilitas">Fasilitas</label>
                    <textarea name="fasilitas" id="fasilitas" cols="20" rows="5" class="form-control"
                        required><?php echo isset($_SESSION['input_data']['fasilitas']) ? $_SESSION['input_data']['fasilitas'] : ''; ?></textarea>
                </div>
                <div>
                    <label for="jam_operasional">Jam Operasional</label>
                    <input type="text" class="form-control" name="jam_operasional"
                        value="<?php echo isset($_SESSION['input_data']['jam_operasional']) ? $_SESSION['input_data']['jam_operasional'] : ''; ?>"
                        required>
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="latitude">Latitude</label>
                    <input type="text" class="form-control" name="latitude" required>
                </div>
                <div>
                    <label for="longitude">Longitude</label>
                    <input type="text" class="form-control" name="longitude" required>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                </div>
            </form>

            <?php
                if (isset($_POST['simpan'])){
                    $nama = htmlspecialchars($_POST['nama']);
                    $kecamatan = htmlspecialchars($_POST['kecamatan']);
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $alamat = htmlspecialchars($_POST['alamat']);
                    $fasilitas = htmlspecialchars($_POST['fasilitas']);
                    $jam_operasional = htmlspecialchars($_POST['jam_operasional']);
                    $latitude = htmlspecialchars($_POST['latitude']);
                    $longitude = htmlspecialchars($_POST['longitude']);

                    $target_dir = "../image/taman/";
                    $nama_file = basename($_FILES["foto"]["name"]);
                    $target_file = $target_dir . $nama_file;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $image_size = $_FILES["foto"]["size"];
                    $random_name = generateRandomString(20);
                    $new_name = $random_name . "." . $imageFileType;

                    $error_messages = [];

                    if ($nama == '' || $kecamatan == '' || $kategori == '' || $alamat == '' || $fasilitas == '' || $jam_operasional == '') {
                        $error_messages[] = "Nama, kategori, alamat, fasilitas, dan jam operasional wajib diisi";
                    }

                    if ($nama_file != '') {
                        if ($image_size > 500000) {
                            $error_messages[] = "File tidak boleh lebih dari 500kb";
                        } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                            $error_messages[] = "File wajib bertipe JPG, PNG, dan JPEG";
                        }
                    } else {
                        $error_messages[] = "File gambar wajib diunggah";
                    }

                    if (empty($error_messages)) {
                        unset($_SESSION['input_data']);

                        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);

                        $queryTambah = mysqli_query($con, "INSERT INTO taman (nama_taman, kecamatan_id, kategori_id, alamat, fasilitas, jam_operasional, foto, latitude, longitude) VALUES ('$nama', '$kecamatan', '$kategori', '$alamat', '$fasilitas', '$jam_operasional', '$new_name', '$latitude', '$longitude')");

                        if ($queryTambah) {
                            ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                Taman berhasil tersimpan
                            </div>

                            <meta http-equiv="refresh" content="2; url=taman.php" />;
                            <?php
                        } else {
                            echo mysqli_error($con);
                        }
                    } else {
                        $_SESSION['input_data'] = compact('nama', 'kecamatan', 'kategori', 'alamat', 'fasilitas', 'jam_operasional');

                        ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            <?php echo implode('<br>', $error_messages); ?>
                        </div>
                        <?php
                    }
                }

                unset($_SESSION['input_data']);
            ?>
        </div>

        <div class="mt-3 mb-5">
            <h2>List Taman</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Kecamatan</th>
                            <th>Kategori</th>
                            <th>Alamat</th>
                            <th>Fasilitas</th>
                            <th>Jam Operasional</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahTaman == 0){
                            ?>
                            <tr>
                                <td colspan=8 class="text-center">Data Taman Tidak Tersedia</td>
                            </tr>
                            <?php
                        } else {
                            $jumlah = 1;
                            while ($data = mysqli_fetch_array($query)){
                                ?>
                                <tr>
                                    <td><?php echo $jumlah; ?></td>
                                    <td><?php echo $data['nama_taman']; ?></td>
                                    <td><?php echo $data['nama_kecamatan']; ?></td>
                                    <td><?php echo $data['nama_kategori']; ?></td>
                                    <td><?php echo $data['alamat']; ?></td>
                                    <td><?php echo $data['fasilitas']; ?></td>
                                    <td><?php echo $data['jam_operasional']; ?></td>
                                    <td>
                                        <img src="../image/taman/<?php echo $data['foto']; ?>" alt="<?php echo $data['nama_taman']; ?>" class="img-thumbnail" width="50">
                                        <a href="taman-detail.php?p=<?php echo $data['id']; ?>" class="btn btn-info"><i
                                                class="fas fa-search"></i></a>
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
