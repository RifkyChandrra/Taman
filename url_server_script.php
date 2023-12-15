<?php
// Sertakan file koneksi.php
include 'koneksi.php';

// Terima data laporan dari formulir JavaScript
$data = array(
    'nama' => $_POST['nama'],
    'email' => $_POST['email'],
    'tanggal' => $_POST['tanggal'],
    'deskripsi' => $_POST['deskripsi']
);

// Kirim email notifikasi (opsional)
// Fungsi ini harus dibuat sesuai dengan kebutuhan Anda
sendEmailNotification($data['nama'], $data['email'], $data['tanggal'], $data['deskripsi']);

// Simpan data laporan ke dalam database
$insertQuery = "INSERT INTO laporan_masalah (nama, email, tanggal, deskripsi) 
                VALUES ('{$data['nama']}', '{$data['email']}', '{$data['tanggal']}', '{$data['deskripsi']}')";
$insertResult = mysqli_query($con, $insertQuery);

// Periksa apakah penyimpanan data berhasil
if ($insertResult) {
    $response = array('success' => true, 'message' => 'Data laporan berhasil disimpan');
} else {
    $response = array('success' => false, 'message' => 'Gagal menyimpan data laporan');
}

// Tampilkan respons dalam format JSON
echo json_encode($response);

// Tutup koneksi database
mysqli_close($con);

// Fungsi untuk mengirim email notifikasi (contoh)
function sendEmailNotification($nama, $email, $tanggal, $deskripsi) {
    // Implementasi fungsi ini sesuai dengan kebutuhan Anda
    // Kirim email notifikasi atau lakukan tindakan lain yang diperlukan
}

error_log("Received data: " . print_r($_POST, true));
?>
