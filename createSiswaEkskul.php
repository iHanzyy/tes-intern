<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['email'])) { header('Location: index.php'); exit; }
// fetch siswa dan ekstrakurikuler
$siswaRes = mysqli_query($conn, "SELECT id, nama_depan, nama_belakang FROM siswa");
$ekskulRes = mysqli_query($conn, "SELECT id, nama FROM ekstrakurikuler");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siswaId = $_POST['siswa_id'];
    $ekskulId = $_POST['ekstrakurikuler_id'];
    $tahunMulai = $_POST['tahun_mulai'];
    $stmt = $conn->prepare("INSERT INTO siswa_ekstrakurikuler (siswa_id, ekstrakurikuler_id, tahun_mulai) VALUES (?, ?, ?)");
    $stmt->bind_param('iis', $siswaId, $ekskulId, $tahunMulai);
    $stmt->execute();
    header('Location: dashboardAdmin.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Tambah Siswa Eskul</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6">
  <h1 class="text-2xl mb-4">Tambah Data Siswa dengan Ekstrakurikuler</h1>
  <form method="POST" class="w-full max-w-md">
    <div class="mb-4">
      <label class="block">Siswa</label>
      <select name="siswa_id" class="w-full border p-2">
        <?php while($row = mysqli_fetch_assoc($siswaRes)): ?>
          <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nama_depan'].' '.$row['nama_belakang']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-4">
      <label class="block">Ekstrakurikuler</label>
      <select name="ekstrakurikuler_id" class="w-full border p-2">
        <?php while($row = mysqli_fetch_assoc($ekskulRes)): ?>
          <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nama']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-4">
      <label class="block">Tahun Mulai</label>
      <input type="text" name="tahun_mulai" class="w-full border p-2">
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    <a href="dashboardAdmin.php" class="ml-2 text-gray-700">Batal</a>
  </form>
</body>
</html>
