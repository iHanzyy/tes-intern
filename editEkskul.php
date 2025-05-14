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
    $nama = $_POST['nama'];
    $penanggungJawab = $_POST['penanggung_jawab'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE ekstrakurikuler SET nama=?, penanggung_jawab=?, status=? WHERE id=?");
    $stmt->bind_param('sssi', $nama, $penanggungJawab, $status, $id);
    $stmt->execute();
    header('Location: dashboardAdmin.php'); exit;
}


$stmt = $conn->prepare("SELECT * FROM ekstrakurikuler WHERE id=?");
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
<head><meta charset="UTF-8"><title>Edit Ekstrakurikuler</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6">
  <h1 class="text-2xl mb-4">Edit Data Ekstrakurikuler</h1>
  <form method="POST" class="w-full max-w-md">
    <div class="mb-4">
      <label class="block">Nama Ekstrakurikuler</label>
      <input type="text" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required class="w-full border p-2">
    </div>
    <div class="mb-4">
      <label class="block">Penanggung Jawab</label>
      <input type="text" name="penanggung_jawab" value="<?php echo htmlspecialchars($row['penanggung_jawab']); ?>" required class="w-full border p-2">
    </div>
    <div class="mb-4">
      <label class="block">Status</label>
      <select name="status" class="w-full border p-2">
        <option value="Aktif" <?php echo $row['status']==='Aktif'?'selected':''; ?>>Aktif</option>
        <option value="Tidak Aktif" <?php echo $row['status']==='Tidak Aktif'?'selected':''; ?>>Tidak Aktif</option>
      </select>
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Perbarui</button>
    <a href="dashboardAdmin.php" class="ml-2 text-gray-700">Batal</a>
  </form>
</body>
</html>
