<?php
include 'koneksi.php';
session_start();


if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit();
}


$currentEmail = $_SESSION['email'];

// Get form data
$namaDepan = $_POST['namaDepan'];
$namaBelakang = $_POST['namaBelakang'];
$email = $_POST['email'];
$tanggalLahir = $_POST['tanggalLahir'];
$jenisKelamin = $_POST['jenisKelamin'];
$password = $_POST['password'];


$query = "UPDATE admin SET 
          nama_depan = '$namaDepan',
          nama_belakang = '$namaBelakang',
          email = '$email',
          tanggal_lahir = '$tanggalLahir',
          jenis_kelamin = '$jenisKelamin'";


if (!empty($password)) {
    $query .= ", password = '$password'";
}


$query .= " WHERE email = '$currentEmail'";


if (mysqli_query($conn, $query)) {
    // Update session variables
    $_SESSION['email'] = $email;
    $_SESSION['namaDepan'] = $namaDepan;
    $_SESSION['namaBelakang'] = $namaBelakang;
    $_SESSION['tanggalLahir'] = $tanggalLahir;
    $_SESSION['jenisKelamin'] = $jenisKelamin;

    
    header('location: dashboardAdmin.php?success=Profil berhasil diperbarui');
} else {
    
    header('location: dashboardAdmin.php?error=Gagal memperbarui profil: ' . mysqli_error($conn));
}
