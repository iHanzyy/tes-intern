<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaDepan = $_POST['namaDepan'];
    $namaBelakang = $_POST['namaBelakang'];
    $nomorHP = $_POST['nomorHP'];
    $nis = $_POST['nis'];
    $alamat = $_POST['alamat'];
    $jenisKelamin = $_POST['jenisKelamin'];
    // handle file upload
    $fotoPath = '';
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['foto']['tmp_name'];
        $name = basename($_FILES['foto']['name']);
        $dest = 'uploads/' . time() . '_' . $name;
        move_uploaded_file($tmp, $dest);
        $fotoPath = $dest;
    }
    $stmt = $conn->prepare("INSERT INTO siswa (nama_depan, nama_belakang, nomor_hp, nis, alamat, jenis_kelamin, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssss', $namaDepan, $namaBelakang, $nomorHP, $nis, $alamat, $jenisKelamin, $fotoPath);
    $stmt->execute();
    header('Location: dashboardAdmin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="p-6">
    <h1 class="text-2xl mb-4">Tambah Data Siswa</h1>
    <form method="POST" enctype="multipart/form-data" class="w-full max-w-md">
        <!-- fields -->
        <div class="mb-4">
            <label class="block">Nama Depan</label>
            <input type="text" name="namaDepan" required class="w-full border p-2">
        </div>
        <div class="mb-4">
            <label class="block">Nama Belakang</label>
            <input type="text" name="namaBelakang" required class="w-full border p-2">
        </div>
        <div class="mb-4">
            <label class="block">Nomor HP</label>
            <input type="text" name="nomorHP" required class="w-full border p-2">
        </div>
        <div class="mb-4">
            <label class="block">NIS</label>
            <input type="text" name="nis" required class="w-full border p-2">
        </div>
        <div class="mb-4">
            <label class="block">Alamat</label>
            <textarea name="alamat" class="w-full border p-2"></textarea>
        </div>
        <div class="mb-4">
            <label class="block">Jenis Kelamin</label>
            <select name="jenisKelamin" class="w-full border p-2">
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block">Foto</label>
            <input type="file" name="foto" accept="image/*" class="w-full">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="dashboardAdmin.php" class="ml-2 text-gray-700">Batal</a>
    </form>
</body>

</html>