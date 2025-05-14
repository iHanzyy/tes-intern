<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $penanggungJawab = $_POST['penanggung_jawab'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("INSERT INTO ekstrakurikuler (nama, penanggung_jawab, status) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $nama, $penanggungJawab, $status);
    $stmt->execute();
    header('Location: dashboardAdmin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Ekstrakurikuler</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="p-6">
    <h1 class="text-2xl mb-4">Tambah Data Ekstrakurikuler</h1>
    <form method="POST" class="w-full max-w-md">
        <div class="mb-4">
            <label class="block">Nama Ekstrakurikuler</label>
            <input type="text" name="nama" required class="w-full border p-2">
        </div>
        <div class="mb-4">
            <label class="block">Penanggung Jawab</label>
            <input type="text" name="penanggung_jawab" required class="w-full border p-2">
        </div>
        <div class="mb-4">
            <label class="block">Status</label>
            <select name="status" class="w-full border p-2">
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="dashboardAdmin.php" class="ml-2 text-gray-700">Batal</a>
    </form>
</body>

</html>