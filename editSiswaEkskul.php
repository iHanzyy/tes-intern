<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php'); exit;
}
if (!isset($_GET['id'])) {
    header('Location: dashboardAdmin.php'); exit;
}
$id = intval($_GET['id']);


$siswaRes = mysqli_query($conn, "SELECT id, nama_depan, nama_belakang FROM siswa");
$ekskulRes = mysqli_query($conn, "SELECT id, nama FROM ekstrakurikuler");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siswaId = $_POST['siswa_id'];
    $ekskulId = $_POST['ekstrakurikuler_id'];
    $tahunMulai = $_POST['tahun_mulai'];
    $stmt = $conn->prepare("UPDATE siswa_ekstrakurikuler SET siswa_id=?, ekstrakurikuler_id=?, tahun_mulai=? WHERE id=?");
    $stmt->bind_param('iisi', $siswaId, $ekskulId, $tahunMulai, $id);
    $stmt->execute();
    header('Location: dashboardAdmin.php'); exit;
}

// fetch relasi
$stmt = $conn->prepare("SELECT siswa_id, ekstrakurikuler_id, tahun_mulai FROM siswa_ekstrakurikuler WHERE id=?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header('Location: dashboardAdmin.php'); exit;
}
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Edit Siswa Ekskul</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6">
  <h1 class="text-2xl mb-4">Edit Data Siswa dengan Ekstrakurikuler</h1>
  <form method="POST" class="w-full max-w-md">
    <div class="mb-4">
      <label class="block">Siswa</label>
      <select name="siswa_id" class="w-full border p-2">
        <?php while($s = mysqli_fetch_assoc($siswaRes)): ?>
          <option value="<?= $s['id'] ?>" <?php echo $s['id']==$row['siswa_id']?'selected':''; ?>>
            <?= htmlspecialchars($s['nama_depan'].' '.$s['nama_belakang']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-4">
      <label class="block">Ekstrakurikuler</label>
      <select name="ekstrakurikuler_id" class="w-full border p-2">
        <?php while($e = mysqli_fetch_assoc($ekskulRes)): ?>
          <option value="<?= $e['id'] ?>" <?php echo $e['id']==$row['ekstrakurikuler_id']?'selected':''; ?>>
            <?= htmlspecialchars($e['nama']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-4">
      <label class="block">Tahun Mulai</label>
      <input type="text" name="tahun_mulai" value="<?= htmlspecialchars($row['tahun_mulai']); ?>" class="w-full border p-2">
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Perbarui</button>
    <a href="dashboardAdmin.php" class="ml-2 text-gray-700">Batal</a>
  </form>
</body>
</html>
