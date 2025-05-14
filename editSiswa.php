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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaDepan = $_POST['namaDepan'];
    $namaBelakang = $_POST['namaBelakang'];
    $nomorHP = $_POST['nomorHP'];
    $nis = $_POST['nis'];
    $alamat = $_POST['alamat'];
    $jenisKelamin = $_POST['jenisKelamin'];
    $currentFoto = $_POST['currentFoto'];
    $fotoPath = $currentFoto;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
        }
        $tmp = $_FILES['foto']['tmp_name'];
        $name = basename($_FILES['foto']['name']);
        $dest = 'uploads/' . time() . '_' . $name;
        move_uploaded_file($tmp, $dest);
        if (file_exists($currentFoto)) unlink($currentFoto);
        $fotoPath = $dest;
    }
    $stmt = $conn->prepare("UPDATE siswa SET nama_depan=?, nama_belakang=?, nomor_hp=?, nis=?, alamat=?, jenis_kelamin=?, foto=? WHERE id=?");
    $stmt->bind_param('sssssssi', $namaDepan, $namaBelakang, $nomorHP, $nis, $alamat, $jenisKelamin, $fotoPath, $id);
    $stmt->execute();
    header('Location: dashboardAdmin.php'); exit;
}


$stmt = $conn->prepare("SELECT * FROM siswa WHERE id=?");
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
  <meta charset="UTF-8"><title>Edit Siswa</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6">
  <h1 class="text-2xl mb-4">Edit Data Siswa</h1>
  <form method="POST" enctype="multipart/form-data" class="w-full max-w-md">
    <input type="hidden" name="currentFoto" value="<?php echo htmlspecialchars($row['foto']); ?>">
    <div class="mb-4">
      <label class="block">Nama Depan</label>
      <input type="text" name="namaDepan" value="<?php echo htmlspecialchars($row['nama_depan']); ?>" required class="w-full border p-2">
    </div>
    <div class="mb-4">
      <label class="block">Nama Belakang</label>
      <input type="text" name="namaBelakang" value="<?php echo htmlspecialchars($row['nama_belakang']); ?>" required class="w-full border p-2">
    </div>
    <div class="mb-4">
      <label class="block">Nomor HP</label>
      <input type="text" name="nomorHP" value="<?php echo htmlspecialchars($row['nomor_hp']); ?>" required class="w-full border p-2">
    </div>
    <div class="mb-4">
      <label class="block">NIS</label>
      <input type="text" name="nis" value="<?php echo htmlspecialchars($row['nis']); ?>" required class="w-full border p-2">
    </div>
    <div class="mb-4">
      <label class="block">Alamat</label>
      <textarea name="alamat" class="w-full border p-2"><?php echo htmlspecialchars($row['alamat']); ?></textarea>
    </div>
    <div class="mb-4">
      <label class="block">Jenis Kelamin</label>
      <select name="jenisKelamin" class="w-full border p-2">
        <option value="Laki-Laki" <?php echo $row['jenis_kelamin'] === 'Laki-Laki' ? 'selected' : ''; ?>>Laki-Laki</option>
        <option value="Perempuan" <?php echo $row['jenis_kelamin'] === 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
      </select>
    </div>
    <div class="mb-4">
      <label class="block">Foto Saat Ini</label>
      <?php if($row['foto']): ?>
        <img src="<?php echo htmlspecialchars($row['foto']); ?>" class="w-16 h-16 rounded-full mb-2">
      <?php endif; ?>
      <input type="file" name="foto" accept="image/*" class="w-full">
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Perbarui</button>
    <a href="dashboardAdmin.php" class="ml-2 text-gray-700">Batal</a>
  </form>
</body>
</html>
