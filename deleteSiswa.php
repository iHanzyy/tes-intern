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

$res = $conn->prepare("SELECT foto FROM siswa WHERE id=?");
$res->bind_param('i', $id);
$res->execute();
$result = $res->get_result();
if ($row = $result->fetch_assoc()) {
    $foto = $row['foto'];
    if ($foto && file_exists($foto)) {
        unlink($foto);
    }
}

$stmt = $conn->prepare("DELETE FROM siswa WHERE id=?");
$stmt->bind_param('i', $id);
$stmt->execute();
header('Location: dashboardAdmin.php');
exit;
